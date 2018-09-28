<?php if ($menu->getMenuItems() !== null) : ?>
	<ul class="side-nav color-1" id="side-nav">
		<?php foreach ($menu->getMenuItems() as $menuItem) : ?>
			<?php require __DIR__ . '/side-nav-menu-item.php'; ?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
