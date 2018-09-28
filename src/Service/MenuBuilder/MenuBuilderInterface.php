<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\MenuBuilder;

use Slim\Http\Request;

interface MenuBuilderInterface {
	/**
	 * @param string $name
	 * @param array $menuConfig
	 * @param Request $request
	 *
	 * @return MenuInterface
	 */
	public function buildMenuFromConfig(string $name, array $menuConfig, Request $request): MenuInterface;

	/**
	 * @param string $name
	 * @param array $menuItemConfig
	 * @param Request $request
	 *
	 * @return MenuItemInterface
	 */
	public function buildMenuItemFromConfig(string $name, array $menuItemConfig, Request $request): MenuItemInterface;
}
