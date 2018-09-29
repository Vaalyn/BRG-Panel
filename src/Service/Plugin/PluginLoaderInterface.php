<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\Plugin;

use Psr\Container\ContainerInterface;
use Slim\App;

interface PluginLoaderInterface {
	/**
	 * @param PluginInterface $plugin
	 *
	 * @return PluginLoaderInterface
	 */
	public function registerPlugin(PluginInterface $plugin): PluginLoaderInterface;

	/**
	 * Initialize the plugin here
	 *
	 * @param ContainerInterface $container
	 *
	 * @return void
	 */
	public function loadPlugins(ContainerInterface $container): void;

	/**
	 * Register all services here
	 *
	 * @param ContainerInterface $container
	 *
	 * @return void
	 */
	public function registerPluginServices(ContainerInterface $container): void;

	/**
	 * Register all middlewares here
	 *
	 * @param App $app
	 * @param ContainerInterface $container
	 *
	 * @return void
	 */
	public function registerPluginMiddlewares(App $app, ContainerInterface $container): void;

	/**
	 * Register all routes here
	 *
	 * @param App $app
	 * @param ContainerInterface $container
	 */
	public function registerPluginRoutes(App $app, ContainerInterface $container): void;
}
