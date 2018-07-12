<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="container">
			<div class="row">
				<div class="col s12">
					<div class="card color-2">
						<div class="card-content white-text">
							<?php include(__DIR__ . '/../pagination.php'); ?>

							<table class="bordered striped" id="messages">
								<thead class="color-1">
									<tr>
										<th>Id</th>
										<th>Nickname</th>
										<th>Zeitpunkt</th>
										<th>Nachricht</th>
										<th>Aktionen</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($messages as $message) : ?>
										<tr>
											<td><?php echo $message->message_id; ?></td>
											<td><?php echo htmlentities($message->nickname); ?></td>
											<td><?php echo $message->created_at->format('H:i:s - d.m.Y'); ?></td>
											<td class="text-break"><?php echo htmlentities($message->message); ?></td>
											<td class="left-align">
												<a href="#!" class="delete-message red-text tooltipped" data-position="top" data-delay="50" data-tooltip="Entfernen" data-uid="<?php echo $message->message_id; ?>">
													<i class="material-icons">delete</i>
												</a>
											</td>
										</tr>
									<?php endforeach; ?>
									
									<?php if (!count($messages)) : ?>
										<tr>
											<td colspan="7">
												<div class="center">Es sind keine aktiven Nachrichten vorhanden</div>
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
