<div class="row">
	<div class="col s12 l8 offset-l2">
		<div class="card color-2">
			<div class="card-content white-text">
				<h3 class="card-title center">
					<div class="chip right color-1 white-text z-depth-1">POST</div>
					<span>Vote</span>
				</h3>
				<div class="divider"></div>

				<div class="row">
					<div class="col s12">
						<div class="api-url grey darken-4 z-depth-1">
							<?php echo $data['request']->getUri()->getBasePath(); ?>/api/vote/{mountpoint}
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col s12 l4">
						<div class="row">
							<div class="col s12">
								This endpoint is restricted by CORS. If you want to implement the voting functionality on your website please contact us.
							</div>
						</div>

						<div class="row">
							<table class="striped z-depth-1">
								<thead class="color-1">
									<tr>
										<th>Stream</th>
										<th>Mountpoint</th>
									</tr>
								</thead>

								<tbody>
									<?php foreach ($mountpoints as $mountpoint) : ?>
										<tr>
											<td><?php echo $mountpoint['name']; ?></td>
											<td><?php echo $mountpoint['mountpoint']; ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>

						<div class="row">
							<div class="col s12">
								The following parameters have to be provided.
							</div>
						</div>

						<div class="row">
							<table class="striped z-depth-1">
								<thead class="color-1">
									<tr>
										<th>Parameter</th>
										<th>Value</th>
									</tr>
								</thead>

								<tbody>
									<tr>
										<td>voter_id</td>
										<td>VoterID obtained from the voter endpoint</td>
									</tr>
									<tr>
										<td>direction</td>
										<td>up, down</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="col s12 l8">
						<pre class="json-output grey darken-4 z-depth-1">
{
  "status": "success",
  "message": null,
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
