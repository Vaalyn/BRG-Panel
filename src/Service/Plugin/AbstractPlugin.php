<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\Plugin;

use BRG\Panel\Service\ConfigLoader\ConfigLoader;
use Psr\Container\ContainerInterface;
use Slim\App;

abstract class AbstractPlugin implements PluginInterface {
	public const PLUGIN_CONFIGS_NAME = 'plugins';

	/**
	 * @inheritDoc
	 */
	abstract public static function getPluginName(): string;

	/**
	 * @inheritDoc
	 */
	abstract public static function getPluginPath(): string;

	/**
	 * @inheritDoc
	 */
	abstract public function load(ContainerInterface $container): void;

	/**
	 * @inheritDoc
	 */
	abstract public function registerServices(ContainerInterface $container): void;

	/**
	 * @inheritDoc
	 */
	abstract public function registerMiddlewares(App $app, ContainerInterface $container): void;

	/**
	 * @inheritDoc
	 */
	abstract public function registerRoutes(App $app, ContainerInterface $container): void;

	/**
	 * @param ContainerInterface $container
	 *
	 * @return void
	 */
	protected function loadConfiguration(ContainerInterface $container): void {
		$configFilePath = $this->getPluginPath() . '/config/config.php';

		$configLoader = new ConfigLoader();
		$configLoader->registerConfig($configFilePath);
		$configLoader->loadConfigs($container);
	}

	/**
	 * @param ContainerInterface $container
	 * @param PluginConfigValidatorInterface|null $pluginConfigValidator
	 * @param PluginConfigTransformerInterface|null $pluginConfigTransformer
	 *
	 * @return void
	 */
	protected function loadPluginConfig(
		ContainerInterface $container,
		?PluginConfigValidatorInterface $pluginConfigValidator = null,
		?PluginConfigTransformerInterface $pluginConfigTransformer = null
	): void {
		$pluginConfigLoader = new PluginConfigLoader(
			$this->getPluginPath(),
			$this->getPluginName(),
			$container
		);

		$pluginConfigLoader->setPluginConfigValidator($pluginConfigValidator);

		$pluginConfigs = $pluginConfigLoader->loadPluginConfig();

		if ($pluginConfigTransformer !== null) {
			$pluginConfigs = $pluginConfigTransformer->transform($pluginConfigs);
		}

		$container->config[self::PLUGIN_CONFIGS_NAME][$this->getPluginName()] = $pluginConfigs;
	}
}
