<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="container">
			<div class="row">
				<div class="col s12">
					<div class="card color-2">
						<div class="card-content white-text">
							<form action="dashboard/vote" method="get">
								<div class="row">
									<div class="input-field col s6 m2">
										<label for="title">Titel</label>
										<input type="text" name="title" id="title" class="validate white-text" value="<?php if (isset($_GET['title'])) { echo htmlentities($_GET['title']); } ?>">
									</div>
									<div class="input-field col s6 m2">
										<label for="artist">Artist</label>
										<input type="text" name="artist" id="artist" class="validate white-text" value="<?php if (isset($_GET['artist'])) { echo htmlentities($_GET['artist']); } ?>">
									</div>
									<div class="input-field col s3 m2">
										<label for="min-votes">Min. Votes</label>
										<input type="number" name="min_votes" id="min-votes" class="validate white-text" value="<?php if (isset($_GET['min_votes'])) { echo htmlentities($_GET['min_votes']); } ?>">
									</div>
									<div class="input-field col s6 m3">
										<select name="sort_by" id="sort-by" class="white-text">
											<option value="">Standard</option>
											<option value="upvotes">Upvotes aufsteigend</option>
											<option value="downvotes">Downvotes aufsteigend</option>
											<option value="upvotes_desc">Upvotes absteigend</option>
											<option value="downvotes_desc">Downvotes absteigend</option>
										</select>
										<label for="sort-by">Sortieren nach</label>
									</div>
									<div class="col s6 m3">
										<input type="checkbox" name="include_hidden" id="include-hidden" class="filled-in" <?php if (isset($_GET['include_hidden'])) { echo 'checked'; } ?> />
										<label for="include-hidden">Mit Versteckten</label>
									</div>
								</div>
								<div class="row">
									<div class="input-field col s12 center">
										<button class="btn waves-effect waves-light color-1" type="submit">Filtern
											<i class="material-icons right">filter_list</i>
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

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
