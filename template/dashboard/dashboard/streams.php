<div class="card color-2 white-text">
	<div class="card-content">
		<div class="card-title center">Streams</div>
		<div class="divider"></div>
	</div>
	<div class="card-tabs">
		<ul class="tabs tabs-fixed-width color-1">
			<li class="tab">
				<a href="#stream-stream">Stream</a>
			</li>
			<li class="tab">
				<a href="#stream-daydj">DayDJ</a>
			</li>
			<li class="tab">
				<a href="#stream-nightdj">NightDJ</a>
			</li>
		</ul>
	</div>
	<div class="card-content">
		<div id="stream-stream">
			<div class="row">
				<div class="col s12">
					<table class="bordered">
						<tbody>
							<tr>
								<th>Status</th>
								<td>
									<?php echo htmlentities($stream['stream']->status); ?>
								</td>
								<td>
								</td>
							</tr>
							<tr>
								<th>Zuhörer</th>
								<td>
									<?php echo htmlentities($stream['stream']->listener); ?>
								</td>
								<td></td>
							</tr>
							<tr>
								<th>Titel</th>
								<td>
									<?php echo htmlentities($stream['stream']->title); ?>
								</td>
								<td></td>
							</tr>
							<tr>
								<th>Artist</th>
								<td>
									<?php echo htmlentities($stream['stream']->artist); ?>
								</td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="row">
				<div class="col s12 center">
					<a href="#!" class="update-stream-tags btn waves-effect waves-light color-1" data-mountpoint="stream">Tags ändern</a>
				</div>
			</div>
		</div>
		<div id="stream-daydj">
			<div class="row">
				<div class="col s12">
					<table class="bordered">
						<tbody>
							<tr>
								<th>Status</th>
								<td>
									<?php echo htmlentities($stream['daydj']->status); ?>
								</td>
								<td></td>
							</tr>
							<tr>
								<th>Zuhörer</th>
								<td>
									<?php echo htmlentities($stream['daydj']->listener); ?>
								</td>
								<td></td>
							</tr>
							<tr>
								<th>Titel</th>
								<td>
									<?php echo htmlentities($stream['daydj']->title); ?>
								</td>
								<td></td>
							</tr>
							<tr>
								<th>Artist</th>
								<td>
									<?php echo htmlentities($stream['daydj']->artist); ?>
								</td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="row">
				<div class="col s12 center">
					<a href="#!" class="update-stream-tags btn waves-effect waves-light color-1" data-mountpoint="daydj">Tags ändern</a>
				</div>
			</div>
		</div>
		<div id="stream-nightdj">
			<div class="row">
				<div class="col s12">
					<table class="bordered">
						<tbody>
							<tr>
								<th>Status</th>
								<td>
									<?php echo htmlentities($stream['nightdj']->status); ?>
								</td>
								<td></td>
							</tr>
							<tr>
								<th>Zuhörer</th>
								<td>
									<?php echo htmlentities($stream['nightdj']->listener); ?>
								</td>
								<td></td>
							</tr>
							<tr>
								<th>Titel</th>
								<td>
									<?php echo htmlentities($stream['nightdj']->title); ?>
								</td>
								<td></td>
							</tr>
							<tr>
								<th>Artist</th>
								<td>
									<?php echo htmlentities($stream['nightdj']->artist); ?>
								</td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="row">
				<div class="col s12 center">
					<a href="#!" class="update-stream-tags btn waves-effect waves-light color-1" data-mountpoint="nightdj">Tags ändern</a>
				</div>
			</div>
		</div>
	</div>
</div>
