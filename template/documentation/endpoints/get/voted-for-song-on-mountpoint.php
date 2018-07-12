<div class="row">
	<div class="col s12 l8 offset-l2">
		<div class="card color-2">
			<div class="card-content white-text">
				<h3 class="card-title center">
					<div class="chip right color-1 white-text z-depth-1">GET</div>
					<span>Voted for song on mountpoint</span>
				</h3>
				<div class="divider"></div>

				<div class="row">
					<div class="col s12">
						<div class="api-url grey darken-4 z-depth-1">
							<?php echo $data['request']->getUri()->getBasePath(); ?>/api/vote/check/{voterId}/{mountpoint}
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col s12 l4">
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

					<div class="col s12 l8">
						<pre class="json-output grey darken-4 z-depth-1">
{
  "status": "success",
  "message": null,
  "result": {
    "voted": true|false,
    "direction": "up"|"down"|""
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
