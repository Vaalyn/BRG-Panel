<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\MenuBuilder;

interface MenuInterface {
	/**
	 * @return string
	 */
	public function getName(): string;

	/**
	 * @param string $name
	 *
	 * @return MenuInterface
	 */
	public function setName(string $name): MenuInterface;

	/**
	 * @return bool|null
	 */
	public function isLeftMenu(): ?bool;

	/**
	 * @param bool|null $isLeft
	 *
	 * @return MenuInterface
	 */
	public function setLeftMenu(?bool $isLeft): MenuInterface;

	/**
	 * @return bool|null
	 */
	public function isRightMenu(): ?bool;

	/**
	 * @param bool|null $isRight
	 *
	 * @return MenuInterface
	 */
	public function setRightMenu(?bool $isRight): MenuInterface;

	/**
	 * @return array
	 */
	public function getClasses(): array;

	/**
	 * @param string $class
	 *
	 * @return MenuInterface
	 */
	public function addClass(string $class): MenuInterface;

	/**
	 * @param array $classes
	 *
	 * @return MenuInterface
	 */
	public function setClasses(array $classes): MenuInterface;

	/**
	 * @return MenuItemInterface[]|null
	 */
	public function getMenuItems(): ?array;

	/**
	 * @param MenuItemInterface $menuItem
	 *
	 * @return MenuInterface
	 */
	public function addMenuItem(MenuItemInterface $menuItem): MenuInterface;

	/**
	 * @param MenuItemInterface[]|null $menuItems
	 *
	 * @return MenuInterface
	 */
	public function setMenuItems(?array $menuItems): MenuInterface;
}
