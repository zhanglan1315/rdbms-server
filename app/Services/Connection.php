<?php

namespace App\Services;

class Connection
{
	protected $config;

	protected $hasConfiged = false;

	public function config($config)
	{
		$this->config = $config;

		config(['database.connections.customer' => array_merge($config, [
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
			'strict'    => true,
			'engine'    => null
		])]);

		config(['database.default' => 'customer']);
	}

	public function selectDatabase($database)
	{
		config(['database.connections.customer.database' => $database]);
	}

	public function getConfig()
	{
		return $this->config;
	}
}
