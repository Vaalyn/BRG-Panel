<?php

namespace BRG\Panel\Service\Factory\Eloquent;

use Illuminate\Database\Capsule\Manager;

class EloquentFactory {
	/**
	 * @param array $config
	 * @param string $name
	 *
	 * @return Manager
	 */
	public static function create(array $config, string $name = 'default'): Manager {
		$capsule = new Manager;
		$capsule->addConnection($config, $name);
		$capsule->setAsGlobal();
		$capsule->bootEloquent();

		return $capsule;
	}

	/**
	 * @param array $config
	 *
	 * @return Manager
	 */
	public static function createMultiple(array $config): Manager {
		$capsule = new Manager;

		foreach ($config as $name => $databaseConfig) {
			$capsule->addConnection($databaseConfig, $name);
		}

		$capsule->setAsGlobal();
		$capsule->bootEloquent();

		return $capsule;
	}
}
