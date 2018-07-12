<div class="row">
	<div class="col s12">
		<div class="card-title center white-text">AutoDJ Request</div>
		<div class="divider"></div>
		<div class="center white-text">
			<?php echo sprintf('%s Request/s pro Person', $systems['autodj_request']['limit']); ?>
		</div>
	</div>
</div>

<div class="row">
	<div class="col s12 center">
		<a href="https://brg.drweissbrot.net/autodj/add" class="btn-flat blue-text text-lighten-1">Song für AutoDj vorschlagen</a>
	</div>

	<div class="col s12 center">
		<a href="https://brg.drweissbrot.net/autodj/remove" class="btn-flat blue-text text-lighten-1">Song aus AutoDj entfernen</a>
	</div>
</div>

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
					<td class="white center" colspan="3">
						Gib einen Titel und/oder Artist ein um nach Songs zu suchen
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
