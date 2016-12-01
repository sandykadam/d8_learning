<?php
namespace Drupal\d8_training\Controller;

use \Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Database\Driver\mysql\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\dblog\Logger\DbLog;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class ExampleformController extends ControllerBase {
    private $form_state;

    public function __construct(FormStateInterface $form_state) {
       // parent::__constructor($connection, $dblog);
        $this->form_state = $form_state;
    }

	public function thankyouMessage() {
print_r($form_state);exit;
		return array(
        	'#markup' => 'Thank you for the values'
        );
	}
}