<?php
namespace Drupal\d8_training;

use GuzzleHttp\Client;

use Drupal\Core\Config\ConfigFactory;


class OpenWeatherForcaster {

	private $api_url;
	private $config_factory;
	private $http_client;

	public function __construct(ConfigFactory $config_factory, Client $http_client) {
		$this->config_factory = $config_factory;	
		$this->http_client = $http_client;
	}

	public function fetchWeatherData($city_name) {
		$app_id = $this->config_factory->get('d8_training.site_config')->get('page_refresh');
		
		$this->api_url = 'http://api.openweathermap.org/data/2.5/weather?q=' . $city_name .'&appid=' . $app_id;
		$response = $this->http_client->request('GET', $this->api_url);
		$body = $response->getBody()->getContents();
		return $body;

	}


}