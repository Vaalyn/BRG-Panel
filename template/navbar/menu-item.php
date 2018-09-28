<?php
	$dataActivates = '';

	if ($menuItem->getMenuItems() !== null) {
		$dataActivates = sprintf('data-activates="%s-menu"', htmlentities($menuItem->getName()));

		$menuItem->addClass('dropdown-button');
	}

	$menuItem->addClass('white-text');
?>

<?php if (!$menuItem->isDropdown() || ($menuItem->isDropdown() && $menuItem->getMenuItems() !== null)) : ?>
	<li>
		<a href="<?php echo $menuItem->getUrl(); ?>" class="<?php echo implode(' ', $menuItem->getClasses()); ?>" <?php echo $dataActivates; ?>>
			<?php if ($menuItem->getIcon() !== null) : ?>
				<i class="material-icons left"><?php echo $menuItem->getIcon(); ?></i><?php echo htmlentities($menuItem->getDisplayName()); ?>
			<?php else : ?>
				<?php echo htmlentities($menuItem->getDisplayName()); ?>
			<?php endif; ?>

			<?php if ($menuItem->getMenuItems() !== null) : ?>
				<i class="material-icons right">arrow_drop_down</i>
			<?php endif; ?>
		</a>

		<?php if ($menuItem->getMenuItems() !== null) : ?>
			<?php require __DIR__ . '/dropdown-menu.php'; ?>
		<?php endif; ?>
	</li>
<?php endif; ?>
