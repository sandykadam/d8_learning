<?php
namespace Drupal\d8_training\Controller;

use \Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Database\Driver\mysql\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\dblog\Logger\DbLog;


class NodelistingController extends ControllerBase {

    private $dblog;
    private $connection;

    public function __construct(Connection $connection, DbLog $dblog) {
       // parent::__constructor($connection, $dblog);
        $this->connection = $connection;
    }

    public function content() {
       /* return array(
          '#theme' => "item_list",
          '#items' => array(1,2,3,4,5)
        );*/

       $data = $this->connection->select('node', 'n')
          ->fields('n', array())
          ->execute()
          ->fetchAssoc();
        
        $header = array();
          $rows = array();
        foreach ($data as $key => $value) {
            $header[$key] = $key;
            $rows[$key] = array('data' => $value);
            
        }
            $output[] = [
              '#theme' => 'table',
              '#rows' => $rows,
              '#header' => $header
            ];

            return $output;
         // print_r($data);exit;
    }

    public function node_details($id) {
      return array(
        '#markup' => 'This is id of the page ' . $id
        );
    }

    public function node_content(NodeInterface $node) {
      //print_r($node);exit;
        //return array('#markup' => "Title - " . $node->getTitle() . '<br> ' . "Description - " . $node);
      return new JsonResponse($node);
    }

    public static function create(ContainerInterface $container) {
      return new static(
          $container->get('database'),
          $container->get('logger.dblog')          
        );

    }
}