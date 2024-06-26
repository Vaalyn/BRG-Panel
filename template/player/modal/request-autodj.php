<div id="brg-player-system-modal" class="modal modal-fixed-footer grey darken-4">
	<div class="modal-content">
		<div class="row">
			<div class="col s12 center white-text">
				<?php echo sprintf('%s Request/s pro Person', $limit); ?>
			</div>
		</div>

		<?php if (strlen($rules) > 1) : ?>
			<div class="row">
				<div class="col s12 center white-text">
					<?php echo htmlentities($rules); ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="row">
			<div class="col s12">
				<div class="row">
					<div class="input-field col s12 m4">
						<input type="text" id="nickname" class="white-text">
						<label for="nickname">Dein Nickname</label>
					</div>

					<div class="input-field col s12 m4">
						<input type="text" id="title" class="white-text">
						<label for="title">Titel</label>
					</div>

					<div class="input-field col s12 m4">
						<input type="text" id="artist" class="white-text">
						<label for="artist">Artist</label>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col s12">
				<table class="striped">
					<thead class="white-text">
						<tr>
							<th>Titel</th>
							<th>Artist</th>
							<th>Aktion</th>
						</tr>
					</thead>

					<tbody>
					</tbody>

					<tfoot>
						<tr>
							<td class="white grey-text text-darken-4 center" colspan="3">
								Gib einen Titel und/oder Artist ein um nach Songs zu suchen
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<a href="javascript:;" class="modal-action modal-close waves-effect waves-red btn-flat white-text">Schließen</a>
	</div>
</div>
