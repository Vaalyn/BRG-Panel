<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="container">
			<div class="row">
				<div class="col s12 m8 l6 offset-m2 offset-l3">
					<div class="card color-2">
						<div class="card-content white-text" id="account">
							<span class="card-title center">Mein Account</span>
							<div class="row">
								<form action="" class="col s12">
									<div class="row">
										<div class="input-field col s12">
											<input id="account-username" type="text" class="validate" value="<?php echo htmlentities($user->username); ?>" disabled>
											<label for="account-username">Username</label>
										</div>
									</div>
									<div class="row">
										<div class="input-field col s12">
											<input id="account-email" type="email" class="validate" value="<?php echo htmlentities($user->email); ?>">
											<label for="account-email">E-Mail</label>
										</div>
										<div class="input-field col s12 center">
											<a href="#!" id="set-account-email" class="waves-effect waves-light btn color-1">
												<i class="material-icons left">save</i>E-Mail ändern
											</a>
										</div>
									</div>
									<div class="row">
										<div class="input-field col s12 m6">
											<input id="account-password-old" type="password" class="validate">
											<label for="account-password-old">Altes Passwort</label>
										</div>
										<div class="input-field col s12 m6">
											<input id="account-password-new" type="password" class="validate">
											<label for="account-password-new">Neues Passwort</label>
										</div>
										<div class="input-field col s12 center">
											<a href="#!" id="set-account-password" class="waves-effect waves-light btn color-1">
												<i class="material-icons left">save</i>Passwort ändern
											</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/../footer.php'); ?>
