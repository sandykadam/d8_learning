<?php

namespace Drupal\d8_training\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\dblog\Logger\DbLog;
use Drupal\d8_training\LatestArticles;
use Drupal\Core\Plugin\Factory\ContainerFactory;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface; 


/**
 * Provides a 'LatestArticlesBlock' block.
 *
 * @Block(
 *  id = "latest_articles_block",
 *  admin_label = @Translation("Latest articles block"),
 * )
 */
class LatestArticlesBlock extends BlockBase implements ContainerFactoryPluginInterface {

	private $latest_articles;
    public function __construct(array $configuration, $plugin_id, $plugin_definition, LatestArticles $latest_articles) {
		parent::__construct($configuration, $plugin_id, $plugin_definition);
		$this->latest_articles = $latest_articles;
	}


  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $cache = [];
   	$articles = $this->latest_articles->getArticles();
   	$header = ['nid', 'title'];
   	foreach($articles as $key => $article) {
   		$output[] = [
   			'nid' => $article['nid'],
   			'title' => $article['title'],
   		];
   		$cache[] = "node:" . $article['nid'];
   	}
   	$table = array(
   		'#type' => 'table',
   		'#header' => $header,
   		'#rows' => $output,
    );
    $user = \Drupal::currentUser();
    $user_email = $user->getAccount()->getEmail();
  //  $tags['context']=>
    $markup = drupal_render($table);
    $build['#markup'] =   $markup . ' -- ' . $user_email;
    $build['#cache']['tags'] =   $cache;
      $build['#cache']['context'] = 'user';

    return $build;
  }

 public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
  	return new static(
  		$configuration, $plugin_id, $plugin_definition, $container->get('d8_training.latest_articles')
  	);
  }

 
}
