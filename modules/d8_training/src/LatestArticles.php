<?php
namespace Drupal\d8_training;

use Drupal\Core\Database\Driver\mysql\Connection;

class LatestArticles {
	private $connection;
	protected $user_data;
	public function __construct(Connection $connection) {
		$this->connection = $connection;
	}

	public function getArticles() {
		$query = $this->connection->select('node_field_data', 'n');
		$query->fields('n', array('title', 'nid'));
		$result = $query->execute();
		$data = array();	
		$i=0;
		while($n = $result->fetchAssoc()) {
			$data[$i]['title'] = $n['title'];
			$data[$i]['nid'] = $n['nid'];
			$i++;
		}
		return $data;

	}
}