<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\MenuBuilder;

class MenuItem implements MenuItemInterface {
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $displayName;

	/**
	 * @var string|null
	 */
	protected $icon;

	/**
	 * @var string|null
	 */
	protected $url;

	/**
	 * @var string|null
	 */
	protected $routeName;

	/**
	 * @var string[]
	 */
	protected $classes;

	/**
	 * @var bool
	 */
	protected $isDropdown;

	/**
	 * @var bool
	 */
	protected $hideWhenAuthenticated;

	/**
	 * @var MenuItemInterface[]|null
	 */
	protected $menuItems;

	/**
	 * @param string $name
	 * @param string $displayName
	 * @param string|null $icon
	 * @param string|null $url
	 * @param string|null $routeName
	 * @param string[] $classes
	 * @param bool $hideWhenAuthenticated
	 * @param MenuItemInterface[]|null $menuItems
	 */
	public function __construct(
		string $name,
		string $displayName,
		?string $icon,
		?string $url,
		?string $routeName,
		array $classes = [],
		bool $hideWhenAuthenticated = false,
		?array $menuItems = null
	) {
		$this
			->setName($name)
			->setDisplayName($displayName)
			->setIcon($icon)
			->setUrl($url)
			->setRouteName($routeName)
			->setClasses($classes)
			->setHideWhenAuthenticated($hideWhenAuthenticated)
			->setMenuItems($menuItems);
	}

	/**
	 * @inheritDoc
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @inheritDoc
	 */
	public function setName(string $name): MenuItemInterface {
		$this->name = $name;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getDisplayName(): string {
		return $this->displayName;
	}

	/**
	 * @inheritDoc
	 */
	public function setDisplayName(string $displayName): MenuItemInterface {
		$this->displayName = $displayName;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getIcon(): ?string {
		return $this->icon;
	}

	/**
	 * @inheritDoc
	 */
	public function setIcon(?string $icon): MenuItemInterface {
		$this->icon = $icon;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getUrl(): ?string {
		return $this->url;
	}

	/**
	 * @inheritDoc
	 */
	public function setUrl(?string $url): MenuItemInterface {
		$this->url = $url;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getRouteName(): ?string {
		return $this->routeName;
	}

	/**
	 * @inheritDoc
	 */
	public function setRouteName(?string $routeName): MenuItemInterface {
		$this->routeName = $routeName;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function isDropdown(): bool {
		return $this->isDropdown;
	}

	/**
	 * @inheritDoc
	 */
	public function setIsDropdown(bool $isDropdown): MenuItemInterface {
		$this->isDropdown = $isDropdown;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getClasses(): array {
		return $this->classes;
	}

	/**
	 * @inheritDoc
	 */
	public function addClass(string $class): MenuItemInterface {
		$this->classes[] = $class;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function setClasses(array $classes): MenuItemInterface {
		$this->classes = $classes;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getHideWhenAuthenticated(): bool {
		return $this->hideWhenAuthenticated;
	}

	/**
	 * @inheritDoc
	 */
	public function setHideWhenAuthenticated(bool $hideWhenAuthenticated): MenuItemInterface {
		$this->hideWhenAuthenticated = $hideWhenAuthenticated;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getMenuItems(): ?array {
		return $this->menuItems;
	}

	/**
	 * @inheritDoc
	 */
	public function addMenuItem(MenuItemInterface $menuItem): MenuItemInterface {
		if ($this->menuItems === null) {
			$this->menuItems = [];
			$this->isDropdown = true;
		}

		$this->menuItems[$menuItem->getName()] = $menuItem;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function setMenuItems(?array $menuItems): MenuItemInterface {
		$this->menuItems = $menuItems;

		$this->isDropdown = ($menuItems !== null);

		return $this;
	}
}
