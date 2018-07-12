<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="container">
			<div class="row">
				<div class="col s12">
					<div class="card color-2">
						<div class="card-content white-text">
							<?php include(__DIR__ . '/../pagination.php'); ?>

							<table class="bordered striped" id="votes">
								<thead class="color-1">
									<tr>
										<th>Id</th>
										<th>Titel</th>
										<th>Artist</th>
										<th>Upvotes</th>
										<th>Downvotes</th>
										<th>Score</th>
										<th>Aktionen</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($tracks as $track) : ?>
										<tr>
											<td><?php echo $track->track_id; ?></td>
											<td><?php echo htmlentities($track->title); ?></td>
											<td><?php echo htmlentities($track->artist->name); ?></td>
											<td class="center"><?php echo $track->votes->sum('upvote'); ?></td>
											<td class="center"><?php echo $track->votes->sum('downvote'); ?></td>
											<td class="center">
												<?php echo ($track->votes->sum('upvote') - $track->votes->sum('downvote')); ?>
											</td>
											<td class="center">
												<a href="#!" class="set-song-ignore-votes red-text tooltipped" data-position="top" data-delay="50" data-tooltip="Song ausblenden" data-uid="<?php echo $track->track_id; ?>">
													<i class="material-icons">visibility_off</i>
												</a>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>

							<?php include(__DIR__ . '/../pagination.php'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/../footer.php'); ?>
