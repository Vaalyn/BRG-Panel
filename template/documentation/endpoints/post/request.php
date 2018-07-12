<div class="row">
	<div class="col s12 l8 offset-l2">
		<div class="card color-2">
			<div class="card-content white-text">
				<h3 class="card-title center">
					<div class="chip right color-1 white-text z-depth-1">POST</div>
					<span>Request</span>
				</h3>
				<div class="divider"></div>

				<div class="row">
					<div class="col s12">
						<div class="api-url grey darken-4 z-depth-1">
							<?php echo $data['request']->getUri()->getBasePath(); ?>/api/request
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col s12 l4">
						<div class="row">
							<div class="col s12">
								The live request system supports requests with title and artist as well as requests by track IDs.
							</div>
						</div>

						<div class="row">
							<div class="col s12">
								The following parameters are used for title and artist requests.
							</div>
						</div>

						<div class="row">
							<table class="striped z-depth-1">
								<thead class="color-1">
									<tr>
										<th>Parameter</th>
										<th>Value</th>
										<th>Required</th>
									</tr>
								</thead>

								<tbody>
									<tr>
										<td>title</td>
										<td>Title of a song</td>
										<td class="center">
											<i class="material-icons">done</i>
										</td>
									</tr>
									<tr>
										<td>artist</td>
										<td>Artist of a song</td>
										<td class="center">
											<i class="material-icons">done</i>
										</td>
									</tr>
									<tr>
										<td>url</td>
										<td>Link to the song</td>
										<td></td>
									</tr>
									<tr>
										<td>nickname</td>
										<td>Your nickname that will be shown to the DJ</td>
										<td></td>
									</tr>
									<tr>
										<td>message</td>
										<td>The message you want to send to the DJ</td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="row">
							<div class="col s12">
								The following parameters are used for track ID requests.
							</div>
						</div>

						<div class="row">
							<table class="striped z-depth-1">
								<thead class="color-1">
									<tr>
										<th>Parameter</th>
										<th>Value</th>
										<th>Required</th>
									</tr>
								</thead>

								<tbody>
									<tr>
										<td>id</td>
										<td>ID of a track</td>
										<td class="center">
											<i class="material-icons">done</i>
										</td>
									</tr>
									<tr>
										<td>nickname</td>
										<td>Your nickname that will be shown to the DJ</td>
										<td></td>
									</tr>
									<tr>
										<td>message</td>
										<td>The message you want to send to the DJ</td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="col s12 l8">
						<pre class="json-output grey darken-4 z-depth-1">
{
  "status": "success",
  "message": "Request eingereicht",
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
