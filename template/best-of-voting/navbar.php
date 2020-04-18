<div class="navbar-fixed">
	<nav class="color-1">
		<div class="nav-wrapper container">
			<a href="dashboard" class="brand-logo">
				<img src="image/brg_logo.png">
			</a>

			<ul id="nav-menu" class="right">
				<li>
					<a href="<?php echo $router->pathFor('best-of-voting', ['language' => 'en']) ?>">
						<?php echo __('Englisch'); ?>
					</a>
				</li>
				<li>
					<a href="<?php echo $router->pathFor('best-of-voting', ['language' => 'de']) ?>">
						<?php echo __('Deutsch'); ?>
					</a>
				</li>
			</ul>
		</div>
	</nav>
</div>
