<?php
namespace Drupal\d8_training\Controller;

use \Drupal\node\Entity\NodeType;

class NodelistingPermissions {

	public function getPermissions() {
		$types = NodeType::loadMultiple();
		$permissions = array();
		foreach ($types as $type) {
			$permissions += [
				'access training program' . $type->get('name') => [
					'title' => 'Access training program for content type '. $type->get('name'),
					'description' => 'Description of access training program for content type ' . $type->get('name')
				],
			];
		}
		return $permissions;
	}
	
}