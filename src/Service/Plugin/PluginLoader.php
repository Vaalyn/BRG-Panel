<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\Plugin;

use Psr\Container\ContainerInterface;
use Slim\App;

class PluginLoader implements PluginLoaderInterface {
	/**
	 * @var PluginInterface[]
	 */
	protected $plugins;

	/**
	 * @param PluginInterface[] $plugins
	 */
	public function __construct(array $plugins = []) {
		$this->plugins = $plugins;
	}

	/**
	 * @inheritDoc
	 */
	public function registerPlugin(PluginInterface $plugin): PluginLoaderInterface {
		if ($this->plugins === null) {
			$this->plugins = [];
		}

		$this->plugins[] = $plugin;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function loadPlugins(ContainerInterface $container): void {
		foreach ($this->plugins as $plugin) {
			$plugin->load($container);
		}
	}

	/**
	 * @inheritDoc
	 */
	public function registerPluginServices(ContainerInterface $container): void {
		foreach ($this->plugins as $plugin) {
			$plugin->registerServices($container);
		}
	}

	/**
	 * @inheritDoc
	 */
	public function registerPluginMiddlewares(App $app, ContainerInterface $container): void {
		foreach ($this->plugins as $plugin) {
			$plugin->registerMiddlewares($app, $container);
		}
	}

	/**
	 * @inheritDoc
	 */
	public function registerPluginRoutes(App $app, ContainerInterface $container): void {
		foreach ($this->plugins as $plugin) {
			$plugin->registerRoutes($app, $container);
		}
	}
}
