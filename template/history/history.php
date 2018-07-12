<?php include_once(__DIR__ . '/header.php'); ?>
	<main>
		<div class="container">
			<div class="row">
				<div class="col s12">
					<div class="card brg-grey">
						<div class="card-content">
							<div class="card-title center white-text">History</div>
							<table class="bordered" id="history">
								<thead class="white-text">
									<tr>
										<th>Datum</th>
										<th>Zeit</th>
										<th>Titel</th>
										<th>Artist</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($history as $historyEntry) : ?>
										<tr>
											<td><?php echo $carbon->createFromFormat('Y-m-d', $historyEntry->date_played)->format('d.m.Y'); ?></td>
											<td><?php echo $historyEntry->time_played; ?></td>
											<td><?php echo htmlentities($historyEntry->title); ?></td>
											<td><?php echo htmlentities($historyEntry->artist); ?></td>
										</tr>
									<?php endforeach; ?>
									<?php if (!count($history)) : ?>
										<tr>
											<td colspan="7">
												<div class="center">Es wurden keine Einträge gefunden</div>
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
	</main>
<?php include_once(__DIR__ . '/footer.php'); ?>
