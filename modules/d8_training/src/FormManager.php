<?php
namespace Drupal\d8_training;

use Drupal\Core\Database\Driver\mysql\Connection;

class FormManager {
	private $connection;
	protected $user_data;
	public function __construct(Connection $connection) {
		$this->connection = $connection;
	}

	public function getData() {
		$query = $this->connection->select('user_table', 'u');
		$query->fields('u', array());
		$query->range(0, 1);
		$result = $query->execute()->fetchAssoc();
		return $result['first_name'] . ' ' . $result['last_name'];

	}

	public function addData($user_array) {
		//$user_array = $this->user_data;
  	    $query = $this->connection->insert('user_table');
	    $query->fields(array(
	      'first_name' => $user_array['first_name'],
	      'last_name' => $user_array['last_name'],
	    ))
	    ->execute();

	}
}