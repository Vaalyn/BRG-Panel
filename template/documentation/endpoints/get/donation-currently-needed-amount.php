<div class="row">
	<div class="col s12 l8 offset-l2">
		<div class="card color-2">
			<div class="card-content white-text">
				<h3 class="card-title center">
					<div class="chip right color-1 white-text z-depth-1">GET</div>
					<span>Donation amount needed</span>
				</h3>
				<div class="divider"></div>

				<div class="row">
					<div class="col s12">
						<div class="api-url grey darken-4 z-depth-1">
							<?php echo $data['request']->getUri()->getBasePath(); ?>/api/donation/currently-needed-amount
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col s12">
						<pre class="json-output grey darken-4 z-depth-1">
{
  "status": "success",
  "message": null,
  "result": "100.99",
  "pages": null
}
						</pre>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
