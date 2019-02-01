<div class="navbar-fixed">
	<nav class="color-1">
		<div class="nav-wrapper">
			<a href="#" data-activates="side-nav" class="button-collapse">
				<i class="material-icons">menu</i>
			</a>

			<a href="dashboard" class="brand-logo">
				<img src="image/brg_logo.png">
			</a>

			<?php $menus = $request->getAttribute('menus'); ?>

			<?php foreach ($menus as $menu) : ?>
				<?php if (in_array($menu->getName(), ['navbar_pages'])) : ?>
					<?php require __DIR__ . '/menu.php' ?>
				<?php endif; ?>

				<?php if ($menu->getName() === 'navbar_pages') : ?>
					<?php require __DIR__ . '/side-nav.php'; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</nav>
</div>
