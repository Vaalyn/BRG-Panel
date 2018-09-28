<?php
	if ($menu->isLeftMenu() === true) {
		$menu->addClass('left');
	}

	if ($menu->isRightMenu() === true) {
		$menu->addClass('right');
	}
?>

<?php if ($menu->getMenuItems() !== null) : ?>
	<ul id="<?php echo htmlentities($menu->getName()); ?>-menu" class="<?php echo implode(' ', $menu->getClasses()); ?>">
		<?php foreach ($menu->getMenuItems() as $menuItem) : ?>
			<?php require __DIR__ . '/menu-item.php'; ?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
