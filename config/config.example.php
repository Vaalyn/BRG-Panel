<?php

return [
	'settings' => [
		'determineRouteBeforeAppMiddleware' => true,
		'displayErrorDetails' => false
	],
	'config' => [
		'session' => [
			'name'     => 'BRG_PANEL_SESSID',
			'lifetime' => 1200,
			'path'     => '/',
			'domain'   => '',
			'secure'   => false,
			'httponly' => true
		],
		'database' => [
			'centova' => [
				'driver'    => 'mysql',
				'host' 	    => '',
				'database' 	=> '',
				'username' 	=> '',
				'password' 	=> '',
				'charset'   => 'utf8',
				'collation' => 'utf8_general_ci',
				'prefix'    => '',
				'port'      => 3306
			],
			'panel' => [
				'driver'    => '',
				'host' 	    => '',
				'database' 	=> '',
				'username' 	=> '',
				'password' 	=> '',
				'charset'   => 'utf8',
				'collation' => 'utf8_general_ci',
				'prefix'    => '',
				'port'      => 3306
			]
		],
		'centova' => [
			'api' => [
				'url' 		=> '',
				'username' 	=> '',
				'password' 	=> '',
				'rpc_url' => ''
			]
		],
		'icecast' => [
			'api' => [
				'stream' 	=> 'http://radio.bronyradiogermany.com:8000/status-json.xsl',
				'mobile' 	=> 'http://radio.bronyradiogermany.com:8000/status-json.xsl',
				'opus' 	    => 'http://radio.bronyradiogermany.com:8000/status-json.xsl',
				'nightdj' 	=> 'http://radio.bronyradiogermany.com:8003/status-json.xsl',
				'daydj' 	=> 'http://radio.bronyradiogermany.com:8006/status-json.xsl'
			],
			'mountpoints' => [
				'stream' => [
					'name'              => 'Haupt Stream',
					'mountpoint'        => 'stream',
					'mountpoint_autodj' => 'autodj',
					'url'               => 'http://radio.bronyradiogermany.com:8000/',
					'username'          => '',
					'password'          => ''
				],
				'mobile' => [
					'name'              => 'Mobile Stream',
					'mountpoint'        => 'mobile',
					'mountpoint_autodj' => 'mobile_autodj',
					'url'               => 'http://radio.bronyradiogermany.com:8000/',
					'username'          => '',
					'password'          => ''
				],
				'opus' => [
					'name'              => 'Opus Stream',
					'mountpoint'        => 'opus',
					'mountpoint_autodj' => 'opus_autodj',
					'url'               => 'http://radio.bronyradiogermany.com:8000/',
					'username'          => '',
					'password'          => ''
				],
				'nightdj' => [
					'name'              => 'NightDJ',
					'mountpoint'        => 'nightdj',
					'mountpoint_autodj' => 'nightdj_autodj',
					'url'               => 'http://radio.bronyradiogermany.com:8003/',
					'username'          => '',
					'password'          => ''
				],
				'daydj' => [
					'name'              => 'DayDJ',
					'mountpoint'        => 'daydj',
					'mountpoint_autodj' => 'daydj_autodj',
					'url'               => 'http://radio.bronyradiogermany.com:8006/',
					'username'          => '',
					'password'          => ''
				]
			]
		],
		'google' => [
			'calendar' => [
				'api_key' => '',
				'calendar_id' => ''
			]
		],
		'auth' => [
			'cookie' => [
				'name'     => 'remember',
				'expire'   => 2592000,
				'domain'   => '',
				'secure'   => true,
				'httponly' => true
			],
			'routes' => require_once __DIR__ . '/routePermissions.php',
			'local' => require_once __DIR__ . '/routePermissionsLocal.php',
			'authorized' => require_once __DIR__ . '/routePermissionsAuthorized.php'
		],
		'cors' => require_once __DIR__ . '/routeCors.php',
		'host' => [
			'ip' => '',
			'url' => ''
		],
		'discord' => [
			'bot' => [
				'lucy_light' => [
					'server' => [
						'host' => '',
						'user' => '',
						'ssh_key_path' => __DIR__ . '/../ssh/id_brg_panel_rsa',
						'command' => [
							'restart' => ''
						]
					]
				]
			]
		],
		'mailer' => [
			'from' => 'Brony Radio Germany',
			'fromAddress' => 'no-reply@bronyradiogermany.com',
			'username' => '',
			'password' => '',
			'host' => '',
			'port' => 587,
			'security' => 'tls',
			'authMode' => 'plain'
		],
		'flysystem' => [
			'files' => [
				'adapter' => 'League\Flysystem\Adapter\Local',
				'arguments' => [
					'path' => __DIR__ . '/../files'
				],
				'config' => []
			]
		],
		'partners' => require_once __DIR__ . '/partners.php'
	]
];
