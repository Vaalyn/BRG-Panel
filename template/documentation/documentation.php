<?php include_once(__DIR__ . '/header.php'); ?>
	<main>
		<div class="row">
			<div class="col s12 l8 offset-l2">
				<div class="card color-2">
					<div class="card-content white-text">
						<h3 class="card-title center">BRG API Docs</h3>
						<div class="divider"></div>

						<div class="row">
							<div class="col s12">
								All endpoints will return a JSON response with the following format.<br />
								If the "status" field is set to "error" an error message will be provided in the "message" field.<br />
								If an action has a response message that should be printed to a user it will also be provided in the "message" field.<br />
								If the response is paginated the number of pages will be provided in the "pages" field.
							</div>
						</div>

						<div class="row">
							<div class="col s12">
								<pre class="json-output grey darken-4 z-depth-1">
{
  "status": "success"|"error",
  "message": "string"|null,
  "result": object|array|string|null,
  "pages": int|null
}
								</pre>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- GET Routes -->

		<?php include_once(__DIR__ . '/endpoints/get/streaminfo.php'); ?>

		<?php include_once(__DIR__ . '/endpoints/get/track-list.php'); ?>

		<?php include_once(__DIR__ . '/endpoints/get/track-list-autodj.php'); ?>

		<?php include_once(__DIR__ . '/endpoints/get/track.php'); ?>

		<?php include_once(__DIR__ . '/endpoints/get/track-autodj.php'); ?>

		<?php include_once(__DIR__ . '/endpoints/get/status.php'); ?>

		<?php include_once(__DIR__ . '/endpoints/get/history.php'); ?>

		<?php include_once(__DIR__ . '/endpoints/get/donation-list.php'); ?>

		<?php include_once(__DIR__ . '/endpoints/get/donation-currently-needed-amount.php'); ?>

		<?php include_once(__DIR__ . '/endpoints/get/community-user-coins.php'); ?>

		<?php include_once(__DIR__ . '/endpoints/get/voted-for-song-on-mountpoint.php'); ?>

		<!-- POST Routes -->

		<?php include_once(__DIR__ . '/endpoints/post/message.php'); ?>

		<?php include_once(__DIR__ . '/endpoints/post/request.php'); ?>

		<?php include_once(__DIR__ . '/endpoints/post/request-autodj.php'); ?>

		<?php include_once(__DIR__ . '/endpoints/post/voter.php'); ?>

		<?php include_once(__DIR__ . '/endpoints/post/vote.php'); ?>

	</main>
<?php include_once(__DIR__ . '/footer.php'); ?>
