<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\MenuBuilder;

interface MenuItemInterface {
	/**
	 * @return string
	 */
	public function getName(): string;

	/**
	 * @param string $name
	 *
	 * @return MenuItemInterface
	 */
	public function setName(string $name): MenuItemInterface;

	/**
	 * @return string
	 */
	public function getDisplayName(): string;

	/**
	 * @param string $displayName
	 *
	 * @return MenuItemInterface
	 */
	public function setDisplayName(string $displayName): MenuItemInterface;

	/**
	 * @return string|null
	 */
	public function getIcon(): ?string;

	/**
	 * @param string|null $icon
	 *
	 * @return MenuItemInterface
	 */
	public function setIcon(?string $icon): MenuItemInterface;

	/**
	 * @return string|null
	 */
	public function getUrl(): ?string;

	/**
	 * @param string|null $url
	 *
	 * @return MenuItemInterface
	 */
	public function setUrl(?string $url): MenuItemInterface;

	/**
	 * @return string|null
	 */
	public function getRouteName(): ?string;

	/**
	 * @param string|null $routeName
	 *
	 * @return MenuItemInterface
	 */
	public function setRouteName(?string $routeName): MenuItemInterface;

	/**
	 * @return bool
	 */
	public function isDropdown(): bool;

	/**
	 * @param bool $isDropdown
	 *
	 * @return MenuItemInterface
	 */
	public function setIsDropdown(bool $isDropdown): MenuItemInterface;

	/**
	 * @return array
	 */
	public function getClasses(): array;

	/**
	 * @param string $class
	 *
	 * @return MenuItemInterface
	 */
	public function addClass(string $class): MenuItemInterface;

	/**
	 * @param array $classes
	 *
	 * @return MenuItemInterface
	 */
	public function setClasses(array $classes): MenuItemInterface;

	/**
	 * @return bool
	 */
	public function getHideWhenAuthenticated(): bool;

	/**
	 * @param bool $hideWhenAuthenticated
	 *
	 * @return MenuItemInterface
	 */
	public function setHideWhenAuthenticated(bool $hideWhenAuthenticated): MenuItemInterface;

	/**
	 * @return MenuItemInterface[]|null
	 */
	public function getMenuItems(): ?array;

	/**
	 * @param MenuItemInterface $menuItem
	 *
	 * @return MenuItemInterface
	 */
	public function addMenuItem(MenuItemInterface $menuItem): MenuItemInterface;

	/**
	 * @param MenuItemInterface[]|null $menuItems
	 *
	 * @return MenuItemInterface
	 */
	public function setMenuItems(?array $menuItems): MenuItemInterface;
}
