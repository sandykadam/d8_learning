<?php
namespace Drupal\d8_training\Form;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface; 
use Drupal\Core\Routing\RedirectDestinationTrait;
use Drupal\Core\Routing\UrlGeneratorTrait;
use Drupal\Core\Url;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\dblog\Logger\DbLog;
use Drupal\d8_training\FormManager;

 
class ExampleForm extends FormBase  implements ContainerInjectionInterface {
	private $formmanager;
    public function __construct(FormManager $formmanager) {
        $this->formmanager = $formmanager;
    }


 /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
  	return 'RegistrationForm';
  }

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
  	$form['first_name'] = array(
  		'#type' => 'textfield',
  		'#title' => 'First Name',
  	);

  	$form['last_name'] = array(
  		'#type' => 'textfield',
  		'#title' => 'Last Name',
  	);

  	$form['submit'] = array(
  		'#type' => 'submit',
  		'#value' => 'Submit',
  	);

  	return $form;

  }

  /**
   * Form validation handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  	$first_name = $form_state->getValue('first_name');
  	$last_name = $form_state->getValue('last_name');

  	if (empty($first_name)) {
  		 $form_state->setErrorByName('first_name', $this->t('Please enter first Name.'));
  	}

  	if (empty($last_name)) {
  		 $form_state->setErrorByName('last_name', $this->t('Please enter last Name.'));
  	}

  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
	$first_name = $form_state->getValue('first_name');
  	$last_name = $form_state->getValue('last_name');
    $user_array = array('first_name' => $first_name, 'last_name' => $last_name);
    $this->formmanager->addData($user_array);
    //$url = Url::fromRoute('d8_training.example_form_thankyou');
    //$form_state->setRedirectUrl($url);
  }

  public static function create(ContainerInterface $container) {
  	return new static(
  		$container->get('d8_training.form_manager')
  	);
  }
}