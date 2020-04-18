<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="row">
			<div class="col s12 m10 offset-m1">
				<div class="row">
					<div class="col s12 m10 l6 offset-m1">
						<?php include(__DIR__ . '/systems.php'); ?>
					</div>
					<div class="col s12 m10 l6 offset-m1">
						<?php include(__DIR__ . '/streams.php'); ?>
					</div>
					<div class="col s12 m10 l6 offset-m1">
						<?php include(__DIR__ . '/discord-bots.php'); ?>
					</div>
					<div class="col s12 m10 l6 offset-m1">
						<iframe width="100%" height="80" src="<?php echo $router->pathFor('best-of-voting-button'); ?>" frameborder="0"></iframe>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/../footer.php'); ?>
