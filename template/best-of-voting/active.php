<div class="col s12 l6">
	<div class="card color-2">
		<div class="card-content white-text">
			<h3 class="card-title center">Best-of Voting <?php echo $votingEndDate->copy()->locale($language)->subMonthNoOverflow(1)->isoFormat('MMMM'); ?></h3>
			<div class="divider"></div>

			<div class="row">
				<div class="col s12">
					<?php echo p__('best-of-voting', 'Hier könnt Ihr für Eure Top Fünf Bronysongs des vergangenen Monats voten. Ich werde alle eingegangen Stimmen auswerten und die Songs mit den meisten Votes in die nächste Best-of Sendung aufnehmen. Ich hoffe auf eine hohe Beteiligung, damit das Voting Eure Meinungen so gut wie möglich widerspiegelt.'); ?>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<ul class="browser-default">
						<li><?php echo p__('best-of-voting', 'Ihr müsst einen Link (bestenfalls zu YouTube) angegeben'); ?></li>
						<li><?php echo p__('best-of-voting', 'Die Angabe von Interpret und Titel des Songs ist optional'); ?></li>
						<li><?php echo p__('best-of-voting', 'Das Voting läuft vom 1. des Monats, bis einen Tag vor der Best-of Sendung'); ?></li>
						<li><?php echo p__('best-of-voting', 'Es müssen nicht alle fünf Plätze vergeben werden, es reicht der erste Platz'); ?></li>
						<li><?php echo p__('best-of-voting', 'Angegebene Nicknamen werden nicht veröffentlicht'); ?></li>
					</ul>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<?php echo sprintf(
						p__('best-of-voting', 'Zur Orientierung gibt es eine von mir erstellte <a href="https://www.youtube.com/playlist?list=%s" target="_blank">Playlist</a> mit im letzten Monat erschienen Songs:'),
						$votingPlaylistCode
					); ?>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<iframe width="100%" height="250" src="https://www.youtube-nocookie.com/embed/videoseries?list=<?php echo htmlentities($votingPlaylistCode); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<div class="card color-3">
						<div class="card-content white-text">
							<?php echo sprintf(
								p__('best-of-voting', 'Diese Playlist beinhaltet Bronysongs, welche im %s %s erschienen sind. Einige Künstler veröffentlichen ihre Songs auch auf anderen Plattformen als YouTube, zum Beispiel auf Bandcamp oder Soundcloud. Daher besteht die Möglichkeit, dass das Uploaddatum auf den verschieden Plattformen unterschiedlich ist. Aus diesem Grund kann es passieren, dass Songs, welche nicht im %s %s auf YouTube hochgeladen wurden, in dieser Playlist sind.'),
								$votingStartDate->copy()->locale($language)->subMonthNoOverflow(1)->isoFormat('MMMM'),
								$votingStartDate->format('Y'),
								$votingStartDate->copy()->locale($language)->subMonthNoOverflow(1)->isoFormat('MMMM'),
								$votingStartDate->format('Y')
							); ?>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<?php echo p__('best-of-voting', 'Abschließend wünsche ich Euch viel Spaß beim Voten und hoffentlich hören wir uns bei der nächsten Best-of Sendung.'); ?>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<?php echo p__('best-of-voting', '− Euer Rainbow Rocks'); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if ($hasAlreadyVoted) : ?>
	<div class="col s12 l6">
		<div class="card color-2">
			<div class="card-content white-text">
				<div class="row">
					<div class="col s12 center">
						<?php echo p__('best-of-voting', 'Du hast für diesen Monat abgestimmt.'); ?>
					</div>
				</div>

				<div class="row">
					<div class="col s12 center">
						<img src="image/pointy_lucy_light_voting.png" alt="Lucy Light Best-of Voting Bild"/>
					</div>
				</div>

				<div class="row">
					<div class="col s12 center">
						<?php echo p__('best-of-voting', 'Vielen Dank für deine Stimme!'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php else : ?>
	<div class="col s12 l6">
		<div class="card color-2">
			<div class="card-content white-text">
				<div class="row">
					<div class="col s12">
						<?php echo sprintf(
							p__('best-of-voting', 'Bitte gib deine Favoriten des Monats %s %s ein. Gib bitte nur Songs an, die im %s %s veröffentlicht wurden. Einsendeschluss ist der %s um 23:59 Uhr'),
							$votingEndDate->copy()->locale($language)->subMonthNoOverflow(1)->isoFormat('MMMM'),
							$votingEndDate->format('Y'),
							$votingEndDate->copy()->locale($language)->subMonthNoOverflow(1)->isoFormat('MMMM'),
							$votingEndDate->format('Y'),
							$votingEndDate->copy()->subDay()->format('d.m.Y')
						); ?>
					</div>
				</div>

				<div class="row">
					<div class="col s12 red-text">
						<?php echo sprintf(
							p__('best-of-voting-new-generation-1', 'Achtung, die Songs aus dem Film, "My Little Pony: New Generation" konnten nicht alle in die YouTube-Playlist aufgenommen werden, diese dürfen aber natürlich gevotet werden.')
						); ?>
					</div>
				</div>

				<div class="row">
					<div class="col s12 red-text">
						<?php echo sprintf(
							p__('best-of-voting-new-generation-2', 'Schreibt daher bei diesen Songs als link: google.com und ergänzt dann den Titel des gewünschten Film-Songs.')
						); ?>
					</div>
				</div>

				<div class="row">
					<div class="col s12">
						<form action="<?php echo $router->pathFor('best-of-voting.vote'); ?>" method="POST">
							<div class="row">
								<div class="input-field col s12 l6 offset-l3">
									<input type="text" name="nickname" id="nickname" placeholder="<?php echo p__('best-of-voting', 'Dein Nickname'); ?>">
									<label for="nickname"><?php echo p__('best-of-voting', 'Nickname'); ?></label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s6">
									<input type="text" name="votes[0][link]" id="link-1" class="validate" placeholder="<?php echo p__('best-of-voting', 'https://youtube.com'); ?>">
									<label for="link-1">1. <?php echo p__('best-of-voting', 'Link zum Song'); ?> <span class="red-text">*</span></label>
								</div>
								<div class="input-field col s6">
									<input type="text" name="votes[0][songname]" id="songname-1" class="validate" placeholder="<?php echo p__('best-of-voting', 'Interpret - Titel'); ?>">
									<label for="songname-1">1. <?php echo p__('best-of-voting', 'Interpret - Titel'); ?></label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s6">
									<input type="text" name="votes[1][link]" id="link-2" placeholder="<?php echo p__('best-of-voting', 'https://youtube.com'); ?>">
									<label for="link-2">2. <?php echo p__('best-of-voting', 'Link zum Song'); ?></label>
								</div>
								<div class="input-field col s6">
									<input type="text" name="votes[1][songname]" id="songname-2" placeholder="<?php echo p__('best-of-voting', 'Interpret - Titel'); ?>">
									<label for="songname-2">2. <?php echo p__('best-of-voting', 'Interpret - Titel'); ?></label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s6">
									<input type="text" name="votes[2][link]" id="link-3" placeholder="<?php echo p__('best-of-voting', 'https://youtube.com'); ?>">
									<label for="link-3">3. <?php echo p__('best-of-voting', 'Link zum Song'); ?></label>
								</div>
								<div class="input-field col s6">
									<input type="text" name="votes[2][songname]" id="songname-3" placeholder="<?php echo p__('best-of-voting', 'Interpret - Titel'); ?>">
									<label for="songname-3">3. <?php echo p__('best-of-voting', 'Interpret - Titel'); ?></label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s6">
									<input type="text" name="votes[3][link]" id="link-4" placeholder="<?php echo p__('best-of-voting', 'https://youtube.com'); ?>">
									<label for="link-4">4. <?php echo p__('best-of-voting', 'Link zum Song'); ?></label>
								</div>
								<div class="input-field col s6">
									<input type="text" name="votes[3][songname]" id="songname-4" placeholder="<?php echo p__('best-of-voting', 'Interpret - Titel'); ?>">
									<label for="songname-4">4. <?php echo p__('best-of-voting', 'Interpret - Titel'); ?></label>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s6">
									<input type="text" name="votes[4][link]" id="link-5" placeholder="<?php echo p__('best-of-voting', 'https://youtube.com'); ?>">
									<label for="link-5">5. <?php echo p__('best-of-voting', 'Link zum Song'); ?></label>
								</div>
								<div class="input-field col s6">
									<input type="text" name="votes[4][songname]" id="songname-5" placeholder="<?php echo p__('best-of-voting', 'Interpret - Titel'); ?>">
									<label for="songname-5">5. <?php echo p__('best-of-voting', 'Interpret - Titel'); ?></label>
								</div>
							</div>

							<div class="row">
								<div class="col s12 center">
									<?php echo sprintf(
										p__('best-of-voting', 'Die mit einem %s*%s markierten Felder sind Pflichtfelder'),
										'<span class="red-text">',
										'</span>'
									); ?>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12 center">
									<button class="btn waves-effect waves-light color-1" type="submit" name="action">
										<?php echo p__('best-of-voting', 'abstimmen'); ?>
										<i class="material-icons right">send</i>
									</button>
								</div>
							</div>
							<input type="hidden" name="language" value="<?php echo htmlentities($language); ?>">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
