<?php include_once(__DIR__ . '/../header.php'); ?>
	<main id="best-of-voting">
		<div class="container">
			<div class="row">
				<div class="col s12">
					<div class="card color-2">
						<div id="best-of-voting-config" class="card-content white-text">
							<div class="row">
								<div class="col s12 center">
									<h3 class="card-title">Best of Voting Einstellungen</h3>
									<div class="divider"></div>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12 m6">
									<div class="row no-margin-bottom">
										<div class="col s12">
											<label for="start-date">Datum Voting Start</label>
											<input type="date" name="start_date" id="start-date" class="datepicker white-text" data-value="<?php echo $votingStartDate->format('Y/m/d'); ?>">
										</div>
									</div>

									<div class="row">
										<div class="col s12">
											<button id="update-voting-start-date-button" class="btn full-width-button waves-effect waves-light color-1" type="button" data-value="<?php echo $recommendedNextStartDate->format('Y-m-d'); ?>">
												Übernehme <?php echo $recommendedNextStartDate->format('d.m.Y'); ?>
											</button>
										</div>
									</div>
								</div>
								<div class="input-field col s12 m6">
									<div class="row no-margin-bottom">
											<div class="col s12">
												<label for="end-date">Datum Voting Ende</label>
												<input type="date" name="end_date" id="end-date" class="datepicker white-text" data-value="<?php echo $votingEndDate->format('Y/m/d'); ?>">
											</div>
									</div>

									<div class="row no-margin-bottom">
										<div class="col s12">
											<button id="update-voting-end-date-button" class="btn full-width-button waves-effect waves-light color-1" type="button" data-value="<?php echo $recommendedNextEndDate->format('Y-m-d'); ?>">
												Übernehme <?php echo $recommendedNextEndDate->format('d.m.Y'); ?>
											</button>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12">
									<label for="title">Playlist Code</label>
									<input type="text" name="playlist_code" id="playlist-code" class="validate white-text" placeholder="Playlist Code" value="<?php echo $votingPlaylistCode; ?>">
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12 center">
									<button id="save-best-of-voting-config" class="btn waves-effect waves-light color-1" type="button">Speichern
										<i class="material-icons right">save</i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col s12">
				<div class="card color-2">
					<div id="best-of-voting-votes" class="card-content white-text">
						<div class="row">
							<div class="col s12 center">
								<h3 class="card-title">Votes: <span class="count"><?php echo count($bestOfVotes); ?></span></h3>
								<div class="divider"></div>
							</div>
						</div>

						<div class="row">
							<div class="col s12">
								<table class="bordered striped responsive-table" id="votes">
									<thead class="color-1">
										<tr>
											<th>Nickname</th>
											<th>Song 1.</th>
											<th>Link 1.</th>
											<th>Song 2.</th>
											<th>Link 2.</th>
											<th>Song 3.</th>
											<th>Link 3.</th>
											<th>Song 4.</th>
											<th>Link 4.</th>
											<th>Song 5.</th>
											<th>Link 5.</th>
											<th>Datum</th>
											<th>Aktionen</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($bestOfVotes as $vote) : ?>
											<tr id="vote-<?php echo $vote->best_of_vote_id; ?>">
												<td><?php echo htmlentities($vote->nickname); ?></td>
												<td><?php echo htmlentities($vote->songname_1); ?></td>
												<td>
													<?php if ($validator->url()->validate($vote->link_1)) : ?>
														<a href="<?php echo strip_tags($vote->link_1); ?>" class="tooltipped" data-position="top" data-delay="50" data-tooltip="Song Link öffnen" target="_blank">
															<i class="material-icons">music_video</i>
														</a>
													<?php endif; ?>
												</td>
												<td><?php echo htmlentities($vote->songname_2); ?></td>
												<td>
													<?php if ($validator->url()->validate($vote->link_2)) : ?>
														<a href="<?php echo strip_tags($vote->link_2); ?>" class="tooltipped" data-position="top" data-delay="50" data-tooltip="Song Link öffnen" target="_blank">
															<i class="material-icons">music_video</i>
														</a>
													<?php endif; ?>
												</td>
												<td><?php echo htmlentities($vote->songname_3); ?></td>
												<td>
													<?php if ($validator->url()->validate($vote->link_3)) : ?>
														<a href="<?php echo strip_tags($vote->link_3); ?>" class="tooltipped" data-position="top" data-delay="50" data-tooltip="Song Link öffnen" target="_blank">
															<i class="material-icons">music_video</i>
														</a>
													<?php endif; ?>
												</td>
												<td><?php echo htmlentities($vote->songname_4); ?></td>
												<td>
													<?php if ($validator->url()->validate($vote->link_4)) : ?>
														<a href="<?php echo strip_tags($vote->link_4); ?>" class="tooltipped" data-position="top" data-delay="50" data-tooltip="Song Link öffnen" target="_blank">
															<i class="material-icons">music_video</i>
														</a>
													<?php endif; ?>
												</td>
												<td><?php echo htmlentities($vote->songname_5); ?></td>
												<td>
													<?php if ($validator->url()->validate($vote->link_5)) : ?>
														<a href="<?php echo strip_tags($vote->link_5); ?>" class="tooltipped" data-position="top" data-delay="50" data-tooltip="Song Link öffnen" target="_blank">
															<i class="material-icons">music_video</i>
														</a>
													<?php endif; ?>
												</td>
												<td><?php echo $vote->created_at->format('H:i:s - d.m.Y'); ?></td>
												<td class="left-align">
													<a href="#!" class="delete-best-of-vote red-text tooltipped" data-position="top" data-delay="50" data-tooltip="Vote löschen" data-uid="<?php echo $vote->best_of_vote_id; ?>">
														<i class="material-icons">delete_forever</i>
													</a>
												</td>
											</tr>
										<?php endforeach; ?>

										<?php if (!count($bestOfVotes)) : ?>
											<tr class="no-results">
												<td colspan="13">
													<div class="center">Es sind keine Votes vorhanden</div>
												</td>
											</tr>
										<?php endif; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/../footer.php'); ?>
