<div class="partner container">
	<div class="row">
		<div class="col s12 m10 l8 offset-m1 offset-l2">
			<div class="card center grey darken-3">
				<div class="card-content">
					<a href="https://www.bronyradiogermany.com">
						<img src="image/brg_logo.png" alt="BRG Logo" class="brg-logo" />
						<h1 class="white-text">Brony Radio Germany <small>e.V.</small></h1>
						<h2>www.bronyradiogermany.com</h2>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="partner-banner row">
		<div class="col s12">
			<div class="card white-text grey darken-3">
				<div class="card-content">
					<div class="row">
						<div class="col s12">
							<span class="card-title center">Unsere Partner</span>
							<div class="divider"></div>
						</div>
					</div>

					<?php if (array_key_exists($currentPartner, $partners)) : ?>
						<div class="row">
							<div class="col s12 center">
								<a href="<?php echo $partners[$currentPartner]['url']; ?>" target="_blank">
									<img src="image/partner/<?php echo $partners[$currentPartner]['banner']; ?>"  />
								</a>
							</div>
						</div>
						<div class="row">
							<div class="col s12">
								<div class="divider"></div>
							</div>
						</div>
						<?php unset($partners[$currentPartner]); ?>
					<?php endif; ?>

					<div class="row">
						<div class="col s12 center">
							<?php foreach ($partners as $partnerKey => $partner) : ?>
								<a href="<?php echo $partner['url']; ?>" target="_blank">
									<img src="image/partner/<?php echo $partner['banner']; ?>"  />
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
