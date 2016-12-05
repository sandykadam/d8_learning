<?php

namespace Drupal\d8_training\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\d8_training\OpenWeatherForcaster;
use Drupal\Core\Plugin\Factory\ContainerFactory;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface; 
use Drupal\Component\Serialization\Json;

/**
* Provides a 'WeatherBlock' block.
* 
* @Block(
*  id = "weather_block",
*  admin_label = @Translation("Weather block"),
* )
*/
class WeatherBlock extends BlockBase implements ContainerFactoryPluginInterface {

	private $open_weather_forcaster;
	public function __construct(array $configuration, $plugin_id, $plugin_definition, OpenWeatherForcaster $open_weather_forcaster) {
		parent::__construct($configuration, $plugin_id, $plugin_definition);
		$this->open_weather_forcaster = $open_weather_forcaster;
	}

	/**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['city_name'] = array(
  		'#type' => 'textfield',
  		'#title' => 'City Name',
  		'#default_value' => $this->configuration['city_name'],
  	);
  	
  	return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state) {

  	$city_name = $form_state->getValue('city_name');
  	

  	if (empty($city_name)) {
  		 $form_state->setErrorByName('city_name', $this->t('Please enter City Name.'));
  	}
  }

	/**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
  	$this->configuration['city_name'] = $form_state->getValue('city_name');
  }

  public function build() {
  	$data_display='';
    $weather_data =array();
  	$city_name = $this->configuration['city_name'];
  //	$weather_data = Json::decode($this->open_weather_forcaster->fetchWeatherData($city_name));
  	$build = [];
  	$build['weather_block'] = array(
  		'#theme' => 'weather_widget',
  		'#attached' => [
  			'library' => ['d8_training/weather_widget']
  		],
  		'#weather_data' => $weather_data,
  		);
  	return $build;

  }

 public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
  	return new static(
  		$configuration, $plugin_id, $plugin_definition, $container->get('d8_training.weather_api_service')
  	);
  }

}