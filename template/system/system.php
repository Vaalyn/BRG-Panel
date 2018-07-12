<?php include_once(__DIR__ . '/header.php'); ?>
	<main>
		<div class="container">
			<div class="row">
				<div class="col s12 l8 offset-l2">
					<div class="card brg-grey">
						<div class="card-content">
							<?php
								if ($systems['request']['active']) {
									include_once(__DIR__ . '/request.php');
								}
								else if ($systems['message']['active']) {
									include_once(__DIR__ . '/message.php');
								}
								else if ($systems['autodj_request']['active']) {
									include_once(__DIR__ . '/request-autodj.php');
								}
								else {
									include_once(__DIR__ . '/offline.php');
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/footer.php'); ?>
