<?php

namespace Drupal\d8_training\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\DependencyInjection\ContainerInterface; 

class SiteconfigForm extends ConfigFormBase {

 /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
  	return 'SiteConfigForm';
  }

  public function getEditableConfigNames() {
  	return [
  		'd8_training.site_config'
  	];
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
  	$config = $this->config('d8_training.site_config');
	$form['page_refresh'] = array(
  		'#type' => 'textfield',
  		'#title' => 'Page Refresh Time',
  		'#default_value' => $config->get('page_refresh'),
  	);

  	$form['submit'] = array(
  		'#type' => 'submit',
  		'#value' => 'Submit',
  	);


    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  	parent::submitForm($form, $form_state);
  	$config = $this->config('d8_training.site_config');
  	$config->set('page_refresh', $form_state->getValue('page_refresh'));
  	$config->save();
  	
    drupal_set_message($this->t('The configuration options have been saved.'));
  }

}