<?php include_once(__DIR__ . '/header.php'); ?>
	<main id="best-of-voting" class="container">
		<?php if (!empty($flashMessages)) : ?>
			<div class="row">
				<div class="col s12">
					<div class="card color-2">
						<div class="card-content white-text">
							<?php foreach ($flashMessages as $flashTitle => $flashMessageArray) : ?>
								<h3 class="card-title center"><?php echo htmlentities($flashTitle); ?></h3>
								<div class="divider"></div>

								<ul class="center">
									<?php foreach ($flashMessageArray as $flashMessage) : ?>
										<li><?php echo htmlentities($flashMessage); ?></li>
									<?php endforeach; ?>
								</ul>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="row">
			<?php if ($isVotingActive) : ?>
				<?php include_once(__DIR__ . '/active.php'); ?>
			<?php else : ?>
				<?php include_once(__DIR__ . '/inactive.php'); ?>
			<?php endif; ?>
		</div>
	</main>
<?php include_once(__DIR__ . '/footer.php'); ?>
