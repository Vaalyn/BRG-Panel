<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="container">
			<div class="row">
				<div class="col s12">
					<div class="card color-2">
						<div class="card-content">
							<form action="dashboard/history" method="get">
								<div class="row">
									<div class="input-field col s6 m3">
										<label for="date-played-start">Datum Anfang</label>
										<input type="date" name="date_played_start" id="date-played-start" class="datepicker white-text" placeholder="dd.mm.yyyy" value="<?php if (isset($_GET['date_played_start'])) { echo $carbon->parse($_GET['date_played_start'])->format('d.m.Y'); } ?>">
									</div>
									<div class="input-field col s6 m3">
										<label for="date-played-end">Datum Ende</label>
										<input type="date" name="date_played_end" id="date-played-end" class="datepicker white-text" placeholder="dd.mm.yyyy" value="<?php if (isset($_GET['date_played_end'])) { echo $carbon->parse($_GET['date_played_end'])->format('d.m.Y'); } ?>">
									</div>
									<div class="input-field col s6 m3">
										<label for="title">Titel</label>
										<input type="text" name="title" id="title" class="validate white-text" placeholder="Titel" value="<?php if (isset($_GET['title'])) { echo htmlentities($_GET['title']); } ?>">
									</div>
									<div class="input-field col s6 m3">
										<label for="artist">Artist</label>
										<input type="text" name="artist" id="artist" class="validate white-text" placeholder="Artist" value="<?php if (isset($_GET['artist'])) { echo htmlentities($_GET['artist']); } ?>">
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

							<form action="api/dashboard/history/export/csv" method="get">
								<input type="hidden" name="date_played_start" value="<?php if (isset($_GET['date_played_start'])) { echo htmlentities($_GET['date_played_start']); } ?>">
								<input type="hidden" name="date_played_end" value="<?php if (isset($_GET['date_played_end'])) { echo htmlentities($_GET['date_played_end']); } ?>">
								<input type="hidden" name="title" value="<?php if (isset($_GET['title'])) { echo htmlentities($_GET['title']); } ?>">
								<input type="hidden" name="artist" value="<?php if (isset($_GET['artist'])) { echo htmlentities($_GET['artist']); } ?>">
								<div class="row">
									<div class="col s12 center">
										<button class="btn waves-effect waves-light color-1" type="submit">Download .csv
											<i class="material-icons right">file_download</i>
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="card color-2">
						<div class="card-content white-text">
							<div class="card-title center">History</div>
							<div class="divider"></div>

							<?php include(__DIR__ . '/../pagination.php'); ?>

							<table class="bordered striped" id="history">
								<thead class="color-1">
									<tr>
										<th>Id</th>
										<th>Datum</th>
										<th>Zeit</th>
										<th>Titel</th>
										<th>Artist</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($history as $historyEntry) : ?>
										<tr>
											<td><?php echo htmlentities($historyEntry->history_id); ?></td>
											<td><?php echo htmlentities($carbon->parse($historyEntry->date_played)->format('d.m.Y')); ?></td>
											<td><?php echo htmlentities($carbon->parse($historyEntry->time_played)->format('H:i:s')); ?></td>
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

							<?php include(__DIR__ . '/pagination.php'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/../footer.php'); ?>
