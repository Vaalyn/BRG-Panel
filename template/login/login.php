<?php include_once(__DIR__ . '/header.php'); ?>
	<main>
		<div class="row">
			<div class="col s12 m8 l4 offset-m2 offset-l4">
				<?php if (!empty($flashMessages)) : ?>
					<div class="card color-2">
						<div class="card-content white-text">
							<?php foreach ($flashMessages as $flashTitle => $flashMessageArray) : ?>
								<h3 class="card-title center"><?php echo htmlentities($flashTitle); ?></h3>
								<div class="divider"></div>

								<ul class="center">
									<?php foreach ($flashMessageArray as $flashMessage) : ?>
										<li><?php echo htmlentities($flashMessage); ?></li>
									<?php endforeach; ?>
								</ul>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="card color-2">
					<div class="card-content white-text">
						<h3 class="card-title center">Login</h3>
						<div class="divider"></div>

						<form action="login" method="post">
							<?php if (count($request->getHeader('HTTP_REFERER'))) : ?>
								<input type="hidden" name="referer" value="<?php echo $request->getHeader('HTTP_REFERER')[0]; ?>" />
							<?php endif; ?>
							<div class="row">
								<div class="input-field col s12">
									<input type="text" name="username" id="username" placeholder="Benutzername" required>
									<label for="username">Benutzername</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input type="password" name="password" id="password" placeholder="Passwort" required>
									<label for="password">Passwort</label>
								</div>
							</div>
							<div class="row">
								<div class="col s12 center">
									<input name="remember_me" id="remember-me" class="filled-in" type="checkbox" />
									<label for="remember-me">Eingeloggt bleiben</label>
								</div>
							</div>
							<div class="row center">
								<div class="col s12">
									<button class="btn waves-effect waves-light color-1" type="submit">Einloggen
										<i class="material-icons right">lock_open</i>
									</button>
								</div>
							</div>
							<div class="row center">
								<div class="col s12">
									<a class="btn-flat waves-effect waves-light modal-trigger blue-text" data-target="forgot-password-modal">Passwort vergessen</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div id="forgot-password-modal" class="modal modal-fixed-footer color-2">
			<div class="modal-content white-text">
				<div class="row">
					<div class="col s12">
						<h5 class="center">Passwort vergessen</h5>
						<div class="divider"></div>
					</div>
				</div>

				<div class="row">
					<div class="input-field col s12 m6 offset-m3">
						<input name="username" id="username-forgot" type="text" />
						<label for="username-forgot">Benutzername</label>
					</div>
				</div>

				<div class="row">
					<div class="input-field col s12 m6 offset-m3">
						<input name="email" id="email-forgot" type="text" />
						<label for="email-forgot">E-Mail</label>
					</div>
				</div>
			</div>
			<div class="modal-footer color-3">
				<button class="modal-action waves-effect waves-green modal-save btn-flat white-text">
					<span class="hide-on-small-only">Passwort </span>zurücksetzen
				</button>
				<button class="modal-action modal-close waves-effect waves-red btn-flat white-text">Abbrechen</button>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/footer.php'); ?>
