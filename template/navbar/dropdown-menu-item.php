<?php $dropdownMenuItem->addClass('white-text'); ?>

<li>
	<a href="<?php echo $dropdownMenuItem->getUrl(); ?>" class="<?php echo implode(' ', $dropdownMenuItem->getClasses()); ?>">
		<?php if ($dropdownMenuItem->getIcon() !== null) : ?>
			<i class="material-icons left"><?php echo $dropdownMenuItem->getIcon(); ?></i><?php echo htmlentities($dropdownMenuItem->getDisplayName()); ?>
		<?php else : ?>
			<?php echo htmlentities($dropdownMenuItem->getDisplayName()); ?>
		<?php endif; ?>
	</a>
</li>
