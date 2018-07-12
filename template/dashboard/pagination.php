<?php if ($pages > 1) : ?>
	<?php $pathWithoutArguments = str_replace('/page/' . $page, '', $path); ?>
	<ul class="pagination center">
		<?php if ($page > 2) : ?>
			<li class="waves-effect">
				<a href="<?php echo $pathWithoutArguments; ?>/page/1" class="tooltipped" data-position="top" data-delay="50" data-tooltip="1">
					<i class="material-icons">first_page</i>
				</a>
			</li>
		<?php endif; ?>

		<?php if ($page > 2) : ?>
			<li>
				<a href="<?php echo $pathWithoutArguments; ?>/page/<?php echo $page-2; ?>"><?php echo $page-2; ?></a>
			</li>
		<?php endif; ?>

		<?php if ($page > 1) : ?>
			<li>
				<a href="<?php echo $pathWithoutArguments; ?>/page/<?php echo $page-1; ?>"><?php echo $page-1; ?></a>
			</li>
		<?php endif; ?>

		<li class="active">
			<a><?php echo $page; ?></a>
		</li>

		<?php if ($page < $pages) : ?>
			<li>
				<a href="<?php echo $pathWithoutArguments; ?>/page/<?php echo $page+1; ?>"><?php echo $page+1; ?></a>
			</li>
		<?php endif; ?>

		<?php if ($page < $pages-1) : ?>
			<li>
				<a href="<?php echo $pathWithoutArguments; ?>/page/<?php echo $page+2; ?>"><?php echo $page+2; ?></a>
			</li>

			<li class="waves-effect">
				<a href="<?php echo $pathWithoutArguments; ?>/page/<?php echo $pages; ?>" class="tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo $pages; ?>">
					<i class="material-icons">last_page</i>
				</a>
			</li>
		<?php endif; ?>
	</ul>
<?php endif; ?>
