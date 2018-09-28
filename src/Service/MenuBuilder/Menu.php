<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\MenuBuilder;

class Menu implements MenuInterface {
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var bool|null
	 */
	protected $isLeftMenu;

	/**
	 * @var bool|null
	 */
	protected $isRightMenu;

	/**
	 * @var string[]
	 */
	protected $classes;

	/**
	 * @var MenuItemInterface[]|null
	 */
	protected $menuItems;

	/**
	 * @param string $name
	 * @param bool|null $isLeftMenu
	 * @param bool|null $isRightMenu
	 * @param array $classes
	 * @param array|null $menuItems
	 */
	public function __construct(
		string $name,
		?bool $isLeftMenu = null,
		?bool $isRightMenu = null,
		array $classes = [],
		?array $menuItems = null
	) {
		$this
			->setName($name)
			->setLeftMenu($isLeftMenu)
			->setRightMenu($isRightMenu)
			->setClasses($classes)
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
	public function setName(string $name): MenuInterface {
		$this->name = $name;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function isLeftMenu(): ?bool {
		return $this->isLeftMenu;
	}

	/**
	 * @inheritDoc
	 */
	public function setLeftMenu(?bool $isLeft): MenuInterface {
		$this->isLeftMenu  = $isLeft;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function isRightMenu(): ?bool {
		return $this->isRightMenu;
	}

	/**
	 * @inheritDoc
	 */
	public function setRightMenu(?bool $isRight): MenuInterface {
		$this->isRightMenu = $isRight;

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
	public function addClass(string $class): MenuInterface {
		$this->classes[] = $class;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function setClasses(array $classes): MenuInterface {
		$this->classes = $classes;

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
	public function addMenuItem(MenuItemInterface $menuItem): MenuInterface {
		if ($this->menuItems === null) {
			$this->menuItems = [];
		}

		$this->menuItems[$menuItem->getName()] = $menuItem;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function setMenuItems(?array $menuItems): MenuInterface {
		$this->menuItems = $menuItems;

		return $this;
	}
}
