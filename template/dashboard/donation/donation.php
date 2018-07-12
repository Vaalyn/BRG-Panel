<?php include_once(__DIR__ . '/../header.php'); ?>
	<main>
		<div class="container">
			<div class="row">
				<div class="col s12 m8 l6 offset-m2 offset-l3">
					<div class="card color-2">
						<div class="card-content white-text" id="donation">
							<div class="row">
								<form action="" class="col s12">
									<div class="row">
										<span class="card-title center">Benötigte Spendensumme festlegen</span>
										<div class="input-field col s12 m6 offset-m3">
											<input id="currently-needed-donation-amount" type="number" class="validate" value="<?php echo $currentlyNeededDonationAmount; ?>">
											<label for="currently-needed-donation-amount">Benötigte Spendensumme</label>
										</div>
										<div class="input-field col s12 center">
											<a href="#!" id="save-currently-needed-donation-amount" class="waves-effect waves-light btn color-1">
												<i class="material-icons left">save</i>Speichern
											</a>
										</div>
									</div>
								</form>
							</div>
							<div class="row">
								<div class="col s12">
									<div class="divider"></div>
								</div>
							</div>
							<div class="row">
								<form action="" class="col s12">
									<span class="card-title center">Spende hinzufügen</span>
									<div class="row">
										<div class="input-field col s12 m6">
											<input id="donor-name" type="text" class="validate" value="">
											<label for="donor-name">Username</label>
										</div>
										<div class="input-field col s12 m6">
											<input id="donor-donated-amount" type="number" class="validate" value="">
											<label for="donor-donated-amount">Spenden-Betrag</label>
										</div>
										<div class="input-field col s12 center">
											<a href="#!" id="save-donation" class="waves-effect waves-light btn color-1">
												<i class="material-icons left">save</i>Spende hinzufügen
											</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12 m10 l8 offset-m1 offset-l2">
					<div class="card color-2">
						<div class="card-content white-text" id="donations">
							<span class="card-title center">Spenden</span>
							<br />
							<div class="row">
								<div class="col s12">
									<?php foreach ($donations as $donation) : ?>
										<div class="chip color-1 white-text z-depth-1 donation">
											<span class="white-text center donor-donated-amount"><?php echo $donation->amount; ?>€</span>
											<?php echo $donation->donor->name; ?>
											<i class="delete material-icons" data-id="<?php echo $donation->donation_id; ?>">close</i>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php include_once(__DIR__ . '/../footer.php'); ?>
