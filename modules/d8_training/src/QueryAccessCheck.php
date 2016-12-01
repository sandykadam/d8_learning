<?php
namespace Drupal\d8_training;

use Drupal\Core\Access\AccessCheckInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;

class QueryAccessCheck implements AccessInterface {

	/**
	* @inheritdoc
	*
	*/
	public function access(Request $request) {
		$qs = $request->getQueryString();
		//print_r($qs);exit;
		if (empty($qs)) {
			return AccessResult::forbidden();
		}
		else {
			return AccessResult::allowed();
		}
		
	}

}