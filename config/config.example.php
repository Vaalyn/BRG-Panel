<?php

return [
	'config' => [
		'authentication' => [
			'cookie' => [
				'expire'   => 2592000,
				'domain'   => '',
				'httponly' => true,
				'name'     => 'remember',
				'secure'   => false
			],
			'host' => [
				'ip' => '127.0.0.1'
			],
			'local' => require_once __DIR__ . '/routes/local.php',
			'routes' => require_once __DIR__ . '/routes/authenticated.php'
		],
		'authorization' => [
			'authorizers' => require_once __DIR__ . '/authorizers.php',
			'routes' => require_once __DIR__ . '/routes/authorized.php'
		],
		'centova' => [
			'api' => [
				'url'      => '',
				'username' => '',
				'password' => '',
				'rpc_url'  => ''
			]
		],
		'cors' => require_once __DIR__ . '/routes/cors.php',
		'database' => [
			'centova' => [
				'charset'   => 'utf8',
				'collation' => 'utf8_general_ci',
				'database' 	=> '',
				'default'   => false,
				'driver'    => 'mysql',
				'host' 	    => '',
				'password' 	=> '',
				'port'      => 3306,
				'prefix'    => '',
				'username' 	=> ''
			],
			'panel' => [
				'charset'   => 'utf8',
				'collation' => 'utf8_general_ci',
				'database' 	=> '',
				'default'   => true,
				'driver'    => '',
				'host' 	    => '',
				'password' 	=> '',
				'port'      => 3306,
				'prefix'    => '',
				'username' 	=> ''
			]
		],
		'discord' => [
			'bot' => [
				'lucy_light' => [
					'server' => [
						'command' => [
							'restart' => ''
						],
						'host' => '',
						'user' => '',
						'ssh_key_path' => __DIR__ . '/../ssh/id_brg_panel_rsa'
					]
				]
			]
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
		'google' => [
			'calendar' => [
				'api_key' => '',
				'calendar_id' => ''
			]
		],
		'host' => [
			'ip' => '',
			'url' => ''
		],
		'icecast' => [
			'api' => [
				'stream'  => 'http://radio.bronyradiogermany.com:8000/status-json.xsl',
				'mobile'  => 'http://radio.bronyradiogermany.com:8000/status-json.xsl',
				'opus'    => 'http://radio.bronyradiogermany.com:8000/status-json.xsl',
				'nightdj' => 'http://radio.bronyradiogermany.com:8003/status-json.xsl',
				'daydj'   => 'http://radio.bronyradiogermany.com:8006/status-json.xsl'
			],
			'mountpoints' => [
				'stream' => [
					'name'                        => 'Haupt Stream',
					'mountpoint'                  => 'stream',
					'url'                         => 'http://radio.bronyradiogermany.com:8000/',
					'username'                    => '',
					'password'                    => '',
					'metadata_update_mountpoints' => [
						'stream',
						'autodj',
						'live',
						'mobile',
						'mobile_autodj',
						'mobile_live',
						'opus',
						'opus_autodj',
						'opus_live'
					]
				],
				'mobile' => [
					'name'                        => 'Mobile Stream',
					'mountpoint'                  => 'mobile',
					'url'                         => 'http://radio.bronyradiogermany.com:8000/',
					'username'                    => '',
					'password'                    => '',
					'metadata_update_mountpoints' => []
				],
				'opus' => [
					'name'                        => 'Opus Stream',
					'mountpoint'                  => 'opus',
					'url'                         => 'http://radio.bronyradiogermany.com:8000/',
					'username'                    => '',
					'password'                    => '',
					'metadata_update_mountpoints' => []
				],
				'nightdj' => [
					'name'                        => 'NightDJ',
					'mountpoint'                  => 'nightdj',
					'url'                         => 'http://radio.bronyradiogermany.com:8003/',
					'username'                    => '',
					'password'                    => '',
					'metadata_update_mountpoints' => [
						'nightdj',
						'nightdj_autodj',
						'nightdj_live'
					]
				],
				'daydj' => [
					'name'                        => 'DayDJ',
					'mountpoint'                  => 'daydj',
					'url'                         => 'http://radio.bronyradiogermany.com:8006/',
					'username'                    => '',
					'password'                    => '',
					'metadata_update_mountpoints' => [
						'daydj',
						'daydj_autodj',
						'daydj_live'
					]
				]
			]
		],
		'mailer' => [
			'authMode' => 'plain',
			'from' => 'Brony Radio Germany',
			'fromAddress' => 'no-reply@bronyradiogermany.com',
			'host' => '',
			'password' => '',
			'port' => 587,
			'username' => '',
			'security' => 'tls',
		],
		'menu' => require_once __DIR__ . '/menu.php',
		'partners' => require_once __DIR__ . '/partners.php',
		'plugins' => [],
		'session' => [
			'domain'   => '',
			'httponly' => true,
			'lifetime' => 1200,
			'name'     => 'BRG_PANEL_SESSID',
			'path'     => '/',
			'secure'   => false,
		]
	],
	'settings' => [
		'determineRouteBeforeAppMiddleware' => true,
		'displayErrorDetails' => false
	]
];
