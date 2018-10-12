<div class="row">
	<div class="col s12">
		<div class="card-title center white-text">Nachricht</div>
		<div class="divider"></div>
	</div>
</div>

<?php if (strlen($systems['message']['rules']) > 1) : ?>
	<div class="row">
		<div class="col s12 center white-text">
			<?php echo htmlentities($systems['message']['rules']); ?>
		</div>
	</div>
<?php endif; ?>

<div class="row">
	<div class="col s12">
		<div class="row">
			<div class="input-field col s12">
				<input type="text" id="nickname" class="white-text">
				<label for="nickname">Dein Nickname</label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				<textarea id="message" class="materialize-textarea white-text"></textarea>
				<label for="message">Nachricht an den DJ</label>
			</div>
		</div>

		<div class="row">
			<div class="col s12 center">
				<button id="send-message" class="btn brg-red waves-effect waves-light">
					<i class="material-icons left">queue_music</i>Nachricht senden
				</button>
			</div>
		</div>
	</div>
</div>
