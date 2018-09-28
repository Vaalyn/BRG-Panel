<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\MenuBuilder;

use BRG\Panel\Service\Authentication\AuthenticationInterface;
use BRG\Panel\Service\Authorization\AuthorizationInterface;
use BRG\Panel\Service\MenuBuilder\Constants\MenuBuilderConstants;
use Slim\Http\Request;
use Slim\Interfaces\RouterInterface;

class MenuBuilder implements MenuBuilderInterface {
	/**
	 * @var RouterInterface
	 */
	protected $router;

	/**
	 * @var AuthenticationInterface
	 */
	protected $authentication;

	/**
	 * @var AuthorizationInterface
	 */
	protected $authorization;

	/**
	 * @param RouterInterface $router
	 * @param AuthenticationInterface $authentication
	 * @param AuthorizationInterface $authorization
	 */
	public function __construct(
		RouterInterface $router,
		AuthenticationInterface $authentication,
		AuthorizationInterface $authorization
	) {
		$this->router         = $router;
		$this->authentication = $authentication;
		$this->authorization  = $authorization;
	}

	/**
	 * @inheritDoc
	 */
	public function buildMenuFromConfig(string $name, array $menuConfig, Request $request): MenuInterface {
		$menu = new Menu(
			$name,
			$menuConfig[MenuBuilderConstants::MENU_CONFIG_KEY_IS_LEFT],
			$menuConfig[MenuBuilderConstants::MENU_CONFIG_KEY_IS_RIGHT],
			$menuConfig[MenuBuilderConstants::MENU_CONFIG_KEY_CLASSES]
		);

		$menuItemConfigs = $menuConfig[MenuBuilderConstants::MENU_CONFIG_KEY_MENU_ITEMS];

		foreach ($menuItemConfigs as $menuItemName => $menuItemConfig) {
			$menuItem = $this->buildMenuItemFromConfig($menuItemName, $menuItemConfig, $request);

			if (!$this->hasAccessToMenuItem($menuItem, $request)) {
				continue;
			}

			if ($this->shouldBeHidden($menuItem)) {
				continue;
			}

			$menu->addMenuItem($menuItem);
		}

		return $menu;
	}

	/**
	 * @inheritDoc
	 */
	public function buildMenuItemFromConfig(string $name, array $menuItemConfig, Request $request): MenuItemInterface {
		$menuItem = new MenuItem(
			$name,
			$menuItemConfig[MenuBuilderConstants::MENU_ITEM_CONFIG_KEY_DISPLAY_NAME],
			$menuItemConfig[MenuBuilderConstants::MENU_ITEM_CONFIG_KEY_ICON],
			$menuItemConfig[MenuBuilderConstants::MENU_ITEM_CONFIG_KEY_URL],
			$menuItemConfig[MenuBuilderConstants::MENU_ITEM_CONFIG_KEY_ROUTE_NAME],
			$menuItemConfig[MenuBuilderConstants::MENU_ITEM_CONFIG_KEY_CLASSES],
			$menuItemConfig[MenuBuilderConstants::MENU_ITEM_CONFIG_KEY_HIDE_WHEN_AUTHENTICATED] ?? false
		);

		$menuItem = $this->resolveRouteNameToUrl($menuItem);

		$menuItemConfigs = $menuItemConfig[MenuBuilderConstants::MENU_ITEM_CONFIG_KEY_MENU_ITEMS] ?? [];

		foreach ($menuItemConfigs as $subMenuItemName => $subMenuItemConfig) {
			$subMenuItem = $this->buildMenuItemFromConfig($subMenuItemName, $subMenuItemConfig, $request);

			if (!$menuItem->isDropdown()) {
				$menuItem->setIsDropdown(true);
			}

			if (!$this->hasAccessToMenuItem($subMenuItem, $request)) {
				continue;
			}

			if ($this->shouldBeHidden($menuItem)) {
				continue;
			}

			$menuItem->addMenuItem($subMenuItem);
		}

		return $menuItem;
	}

	/**
	 * @param MenuItemInterface $menuItem
	 *
	 * @return MenuItemInterface
	 */
	protected function resolveRouteNameToUrl(MenuItemInterface $menuItem): MenuItemInterface {
		$routeName = $menuItem->getRouteName();

		if ($routeName === null) {
			return $menuItem;
		}

		$menuItem->setUrl(
			$this->router->pathFor($routeName)
		);

		return $menuItem;
	}

	/**
	 * @param MenuItemInterface $menuItem
	 * @param Request $request
	 *
	 * @return bool
	 */
	protected function hasAccessToMenuItem(MenuItemInterface $menuItem, Request $request): bool {
		$routeName = $menuItem->getRouteName();

		if ($routeName === null) {
			return true;
		}

		if ($this->authentication->routeNeedsAuthentication($routeName) && $this->authentication->user() === null) {
			return false;
		}

		if (!$this->authorization->needsAuthorizationForRoute($routeName)) {
			return true;
		}

		return $this->hasAuthorizationForRoute($routeName, $request);
	}

	/**
	 * @param string $routeName
	 * @param Request $request
	 *
	 * @return bool
	 */
	protected function hasAuthorizationForRoute(string $routeName, Request $request): bool {
		return $this->authorization->hasAuthorizationForRoute(
			$this->authentication->user(),
			$routeName,
			$request
		);
	}

	/**
	 * @param MenuItemInterface $menuItem
	 *
	 * @return bool
	 */
	protected function shouldBeHidden(MenuItemInterface $menuItem): bool {
		if (!$menuItem->getHideWhenAuthenticated()) {
			return false;
		}

		return $this->authentication->user() !== null;
	}
}
