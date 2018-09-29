<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\ConfigLoader;

use BRG\Panel\Exception\InvalidConfigException;
use BRG\Panel\Exception\ConfigFileNotFoundException;
use Psr\Container\ContainerInterface;

class ConfigLoader implements ConfigLoaderInterface {
	/**
	 * @var ConfigInterface[]
	 */
	protected $configs;

	/**
	 * @inheritDoc
	 */
	public function loadConfigs(ContainerInterface $container): void {
		foreach ($this->configs as $config) {
			$containerConfig = $container->config;
			$configToLoad    = $config->getConfig();

			$container->config = array_merge_recursive($containerConfig, $configToLoad);
		}
	}

	/**
	 * @inheritDoc
	 */
	public function registerConfig(string $configFile): ConfigLoaderInterface {
		if (!file_exists($configFile)) {
			throw new ConfigFileNotFoundException(
				sprintf(
					'The file "%s" could not be found',
					$configFile
				)
			);
		}

		$config = require $configFile;

		if (!is_array($config)) {
			throw new InvalidConfigException(
				sprintf(
					'The file "%s" does not return a valid config array',
					$configFile
				)
			);
		}

		$this->configs[] = new Config($config);

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getConfigs(): array {
		return $this->configs;
	}
}
