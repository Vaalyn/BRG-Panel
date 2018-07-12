<div class="row">
	<div class="col s12 l8 offset-l2">
		<div class="card color-2">
			<div class="card-content white-text">
				<h3 class="card-title center">
					<div class="chip right color-1 white-text z-depth-1">GET</div>
					<span>Track List AutoDJ</span>
				</h3>
				<div class="divider"></div>

				<div class="row">
					<div class="col s12">
						<div class="api-url grey darken-4 z-depth-1">
							<?php echo $data['request']->getUri()->getBasePath(); ?>/api/track/list/autodj
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col s12 l4">
						<div class="row">
							<div class="col s12">
								The following parameters can be provided to filter the response.
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
									<td>title</td>
									<td>Title of a song</td>
								</tr>
								<tr>
									<td>artist</td>
									<td>Artist of a song</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="col s12 l8">
						<pre class="json-output grey darken-4 z-depth-1">
{
  "status": "success",
  "message": null,
  "result": [
    {
      "id": 1,
      "title": "Magic Dance (w/ AgileDash)",
      "artist": "&I"
    },
    {
      "id": 2,
      "title": "Canterlot Disco",
      "artist": "&I"
    },
    ...
  ],
  "pages": null
}
						</pre>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
