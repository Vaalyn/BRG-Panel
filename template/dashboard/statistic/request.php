<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="container">
			<div class="row">
				<div class="col s12">
					<div class="card color-2">
						<div class="card-content white-text">
							<?php
								if (isset($statisticRequestsPerUser)) {
									include_once(__DIR__ . '/requests-per-user.php');
								}
								else if (isset($statisticRequestsPerTitle)) {
									include_once(__DIR__ . '/requests-per-title.php');
								}
								else if (isset($statisticRequestsPerArtist)) {
									include_once(__DIR__ . '/requests-per-artist.php');
								}
								else {
									include_once(__DIR__ . '/request-overview.php');
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/../footer.php'); ?>
