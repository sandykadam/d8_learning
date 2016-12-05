<?php

namespace Drupal\d8_training\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use AntoineAugusti\Books\Fetcher;
use GuzzleHttp\Client;


/**
 * Provides a 'GoogleBooksBlock' block.
 *
 * @Block(
 *  id = "google_books_block",
 *  admin_label = @Translation("Google books block"),
 * )
 */
class GoogleBooksBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['isbn_number'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('ISBN Number'),
      '#description' => $this->t('ISBN number of book'),
      '#default_value' => isset($this->configuration['isbn_number']) ? $this->configuration['isbn_number'] : '',
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['isbn_number'] = $form_state->getValue('isbn_number');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $client = new Client(['base_uri' => 'https://www.googleapis.com/books/v1/']);
$fetcher = new Fetcher($client);
$book = $fetcher->forISBN($this->configuration['isbn_number']);

//print_r($book);
    $build = [];
    $build['google_books_block_isbn_number']['#markup'] = '<p>' . $book->title . ' by Author ' . $book->authors[0] . '</p>';

    return $build;
  }

}
