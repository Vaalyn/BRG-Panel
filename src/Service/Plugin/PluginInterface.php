<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\Plugin;

use Psr\Container\ContainerInterface;
use Slim\App;

interface PluginInterface {
	/**
	 * Returns the name of the plugin
	 *
	 * @return string
	 */
	public static function getPluginName(): string;

	/**
	 * Return the path to the plugin directory
	 *
	 * @return string
	 */
	public static function getPluginPath(): string;

	/**
	 * Initialize the plugin
	 *
	 * @param ContainerInterface $container
	 *
	 * @return void
	 */
	public function load(ContainerInterface $container): void;

	/**
	 *	Register all services
	 *
	 * @param ContainerInterface $container
	 *
	 * @return void
	 */
	public function registerServices(ContainerInterface $container): void;

	/**
	 * Register all middlewares
	 *
	 * @param App $app
	 * @param ContainerInterface $container
	 *
	 * @return void
	 */
	public function registerMiddlewares(App $app, ContainerInterface $container): void;

	/**
	 * Register all routes
	 *
	 * @param App $app
	 *
	 * @param ContainerInterface $container
	 */
	public function registerRoutes(App $app, ContainerInterface $container): void;
}
