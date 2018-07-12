<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="container">
			<div class="row">
				<div class="col s12">
					<div class="card color-2">
						<div class="card-content white-text">
							<?php include(__DIR__ . '/../pagination.php'); ?>

							<table class="bordered striped" id="requests">
								<thead class="color-1">
									<tr>
										<th>Id</th>
										<th>Titel</th>
										<th>Artist</th>
										<th>Nickname</th>
										<th>Nachricht</th>
										<th>Zeitpunkt</th>
										<th>Aktionen</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($requests as $request) : ?>
										<tr>
											<td><?php echo $request->request_id; ?></td>
											<td><?php echo htmlentities($request->title); ?></td>
											<td><?php echo htmlentities($request->artist); ?></td>
											<td><?php echo htmlentities($request->nickname); ?></td>
											<td class="text-break"><?php echo htmlentities($request->message); ?></td>
											<td><?php echo $request->created_at->format('H:i:s - d.m.Y'); ?></td>
											<td class="left-align">
												<a href="#!" class="set-request-played green-text tooltipped" data-position="top" data-delay="50" data-tooltip="Als gespielt markieren" data-uid="<?php echo $request->request_id; ?>">
													<i class="material-icons">check_circle</i>
												</a>
												<a href="#!" class="set-request-skipped red-text tooltipped" data-position="top" data-delay="50" data-tooltip="Request ablehnen" data-uid="<?php echo $request->request_id; ?>">
													<i class="material-icons">not_interested</i>
												</a>
												<?php if ($validator->url()->validate($request->url)) : ?>
													<a href="<?php echo strip_tags($request->url); ?>" class="tooltipped" data-position="top" data-delay="50" data-tooltip="Song Link öffnen" target="_blank">
														<i class="material-icons">music_video</i>
													</a>
												<?php endif; ?>
											</td>
										</tr>
									<?php endforeach; ?>
									
									<?php if (!count($requests)) : ?>
										<tr>
											<td colspan="7">
												<div class="center">Es sind keine aktiven Requests vorhanden</div>
											</td>
										</tr>
									<?php endif; ?>
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
