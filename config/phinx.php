<?php

$config = require_once __DIR__ . '/config.php';

return [
	'paths' => [
		'migrations' => __DIR__ . '/../phinx/migrations',
	    'seeds' => __DIR__ . '/../phinx/seeds'
	],
	'environments' => [
		'default_migration_table' => 'phinxlog',
	    'default_database' => 'production',
	    'production' => [
			'adapter' => $config['config']['database']['panel']['driver'],
	        'host' => $config['config']['database']['panel']['host'],
	        'name' => $config['config']['database']['panel']['database'],
	        'user' => $config['config']['database']['panel']['username'],
	        'pass' => $config['config']['database']['panel']['password'],
	        'port' => $config['config']['database']['panel']['port'],
	        'charset' => $config['config']['database']['panel']['charset'],
			'collation' => $config['config']['database']['panel']['collation'],
			'table_prefix' => $config['config']['database']['panel']['prefix']
		]
	],
	'version_order' => 'creation'
];
