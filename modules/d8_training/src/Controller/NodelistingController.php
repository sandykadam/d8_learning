<?php
namespace Drupal\d8_training\Controller;

use \Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class NodelistingController extends ControllerBase {

    public function content() {
        return array(
          '#theme' => "item_list",
          '#items' => array(1,2,3,4,5)
        );
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
}