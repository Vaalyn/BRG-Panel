<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\MenuBuilder\Constants;

interface MenuBuilderConstants {
	public const MENU_CONFIG_KEY_IS_LEFT    = 'is_left';
	public const MENU_CONFIG_KEY_IS_RIGHT   = 'is_right';
	public const MENU_CONFIG_KEY_CLASSES    = 'classes';
	public const MENU_CONFIG_KEY_MENU_ITEMS = 'menu_items';

	public const MENU_ITEM_CONFIG_KEY_DISPLAY_NAME            = 'display_name';
	public const MENU_ITEM_CONFIG_KEY_ICON                    = 'icon';
	public const MENU_ITEM_CONFIG_KEY_URL                     = 'url';
	public const MENU_ITEM_CONFIG_KEY_ROUTE_NAME              = 'route_name';
	public const MENU_ITEM_CONFIG_KEY_MENU_ITEMS              = 'menu_items';
	public const MENU_ITEM_CONFIG_KEY_CLASSES                 = 'classes';
	public const MENU_ITEM_CONFIG_KEY_HIDE_WHEN_AUTHENTICATED = 'hide_when_authenticated';
}
