<?php

return [
	'navbar_pages' => [
		'is_left' => false,
		'is_right' => true,
		'classes' => [
			'hide-on-med-and-down'
		],
		'menu_items' => [
			'dashboard' => [
				'display_name' => 'Dashboard',
				'icon' => null,
				'url' => null,
				'route_name' => 'dashboard',
				'classes' => []
			],
			'brg_systems' => [
				'display_name' => 'BRG-Systeme',
				'icon' => null,
				'url' => '#!',
				'route_name' => null,
				'classes' => [],
				'menu_items' => [
					'request' => [
						'display_name' => 'Requests',
						'icon' => null,
						'url' => null,
						'route_name' => 'dashboard.request',
						'classes' => []
					],
					'message' => [
						'display_name' => 'Nachrichten',
						'icon' => null,
						'url' => null,
						'route_name' => 'dashboard.message',
						'classes' => []
					]
				]
			],
			'history' => [
				'display_name' => 'History',
				'icon' => null,
				'url' => null,
				'route_name' => 'dashboard.history',
				'classes' => []
			],
			'votes' => [
				'display_name' => 'Votes',
				'icon' => null,
				'url' => null,
				'route_name' => 'dashboard.votes',
				'classes' => []
			],
			'donation' => [
				'display_name' => 'Spenden',
				'icon' => null,
				'url' => null,
				'route_name' => 'dashboard.donation',
				'classes' => []
			],
			'statistics' => [
				'display_name' => 'Statistik',
				'icon' => null,
				'url' => '#!',
				'route_name' => null,
				'classes' => [],
				'menu_items' => [
					'request' => [
						'display_name' => 'Requests',
						'icon' => null,
						'url' => null,
						'route_name' => 'dashboard.statistic.request',
						'classes' => []
					],
					'request_per_artist' => [
						'display_name' => 'Requests pro Artist',
						'icon' => null,
						'url' => null,
						'route_name' => 'dashboard.statistic.request.artist',
						'classes' => []
					],
					'request_per_title' => [
						'display_name' => 'Requests pro Titel',
						'icon' => null,
						'url' => null,
						'route_name' => 'dashboard.statistic.request.title',
						'classes' => []
					],
					'request_per_user' => [
						'display_name' => 'Requests pro User',
						'icon' => null,
						'url' => null,
						'route_name' => 'dashboard.statistic.request.user',
						'classes' => []
					]
				]
			],
			'my_account' => [
				'display_name' => '',
				'icon' => 'account_circle',
				'url' => null,
				'route_name' => 'dashboard.account',
				'classes' => []
			],
			'login' => [
				'display_name' => 'Login',
				'icon' => 'lock_open',
				'url' => null,
				'route_name' => 'login',
				'classes' => [],
				'hide_when_authenticated' => true
			],
			'logout' => [
				'display_name' => '',
				'icon' => 'lock_outline',
				'url' => null,
				'route_name' => 'logout',
				'classes' => []
			]
		]
	]
];
