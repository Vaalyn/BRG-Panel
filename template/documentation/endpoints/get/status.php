<div class="row">
	<div class="col s12 l8 offset-l2">
		<div class="card color-2">
			<div class="card-content white-text">
				<h3 class="card-title center">
					<div class="chip right color-1 white-text z-depth-1">GET</div>
					<span>System Status</span>
				</h3>
				<div class="divider"></div>

				<div class="row">
					<div class="col s12">
						<div class="api-url grey darken-4 z-depth-1">
							<?php echo $data['request']->getUri()->getBasePath(); ?>/api/status/{id}
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col s12 l4">
						<table class="striped z-depth-1">
							<thead class="color-1">
								<tr>
									<th>System</th>
									<th>ID</th>
								</tr>
							</thead>

							<tbody>
								<?php foreach ($statusList as $status) : ?>
									<tr>
										<td><?php echo $status->description; ?></td>
										<td><?php echo $status->status_id; ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>

					<div class="col s12 l8">
						<pre class="json-output grey darken-4 z-depth-1">
{
  "status": "success",
  "message": null,
  "result": {
    "id": 1,
    "active": false,
    "limit": 1,
    "description": "Request System"
  },
  "pages": null
}
						</pre>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
