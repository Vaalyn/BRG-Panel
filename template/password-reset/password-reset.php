<?php include_once(__DIR__ . '/header.php'); ?>
	<main>
		<div class="row">
			<div id="password-reset" class="col s12 m8 l4 offset-m2 offset-l4">
				<div class="card color-2">
					<div class="card-content white-text">
						<h3 class="card-title center">Passwort zurücksetzen</h3>
						<div class="divider"></div>
							<input type="hidden" name="code" id="code" value="<?php echo htmlentities($code); ?>" />

							<div class="row">
								<div class="input-field col s12">
									<input type="password" name="password" id="password" required>
									<label for="password">Neues Passwort</label>
								</div>
							</div>

							<div class="row center">
								<div class="col s12">
									<a id="change-password" class="btn waves-effect waves-light color-1">Passwort ändern
										<i class="material-icons right">save</i>
									</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/footer.php'); ?>
