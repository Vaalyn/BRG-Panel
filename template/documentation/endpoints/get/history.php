<div class="row">
	<div class="col s12 l8 offset-l2">
		<div class="card color-2">
			<div class="card-content white-text">
				<h3 class="card-title center">
					<div class="chip right color-1 white-text z-depth-1">GET</div>
					<span>History</span>
				</h3>
				<div class="divider"></div>

				<div class="row">
					<div class="col s12">
						<div class="api-url grey darken-4 z-depth-1">
							<?php echo $data['request']->getUri()->getBasePath(); ?>/api/history[/{page}]
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
									<td>date_played_start</td>
									<td>YYYY-MM-DD</td>
								</tr>
								<tr>
									<td>date_played_end</td>
									<td>YYYY-MM-DD</td>
								</tr>
								<tr>
									<td>time_played_start</td>
									<td>hh:mm:ss</td>
								</tr>
								<tr>
									<td>time_played_end</td>
									<td>hh:mm:ss</td>
								</tr>
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
      "history_id": 436429,
      "date_played": "2018-07-09",
      "time_played": "14:14:13",
      "artist": "Foozogz",
      "title": "Sparkle (Season Rebirth)"
    },
    {
      "history_id": 436409,
      "date_played": "2018-07-09",
      "time_played": "14:10:37",
      "artist": "Glaze",
      "title": "Our Terrarium (µThunder Remix)"
    },
  ],
  "pages": 21822
}
						</pre>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
