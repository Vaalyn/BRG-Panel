<div class="row">
	<div class="col s12 l8 offset-l2">
		<div class="card color-2">
			<div class="card-content white-text">
				<h3 class="card-title center">
					<div class="chip right color-1 white-text z-depth-1">POST</div>
					<span>Message</span>
				</h3>
				<div class="divider"></div>

				<div class="row">
					<div class="col s12">
						<div class="api-url grey darken-4 z-depth-1">
							<?php echo $data['request']->getUri()->getBasePath(); ?>/api/message
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col s12 l4">
						<div class="row">
							<div class="col s12">
								The following parameters have to be provided.
							</div>
						</div>

						<table class="striped z-depth-1">
							<thead class="color-1">
								<tr>
									<th>Parameter</th>
									<th>Value</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>nickname</td>
									<td>Your nickname that will be shown to the DJ</td>
								</tr>
								<tr>
									<td>message</td>
									<td>The message you want to send to the DJ</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="col s12 l8">
						<pre class="json-output grey darken-4 z-depth-1">
{
  "status": "success",
  "message": "Nachricht eingereicht",
  "result": null,
  "pages": null
}
						</pre>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
