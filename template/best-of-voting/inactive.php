<div class="col s12 l8 offset-l2">
	<div class="card color-2">
		<div class="card-content white-text">
			<h3 class="card-title center">Best-of Voting <?php echo $votingEndDate->locale($language)->isoFormat('MMMM'); ?></h3>
			<div class="divider"></div>

			<div class="row">
				<div class="col s12">
					<?php echo p__('best-of-voting', 'Das Voting derzeit nicht aktiv. Das Best of-Voting findet immer vom 1. eines Monats bis zum zweiten Freitag eines Monats, jeweils um punkt 00:00 Uhr, statt.'); ?>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<div class="card color-3">
						<div class="card-content white-text center">
							<?php echo sprintf(
								p__('best-of-voting', 'Das nächste Voting beginnt am %s um 00:00 Uhr. Versuche es dann bitte erneut.'),
								$votingStartDate->format('d.m.Y')
							); ?>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<?php echo sprintf(
						p__('best-of-voting', 'In der Zwischenzeit kannst Du aber %sdie von uns erstellten Playlisten%s mit in vergangenen Monaten erschienenen Songs anhören.'),
						'<a href="https://www.youtube.com/channel/UC45pT_HLzhlIMn2U23LesJA/playlists">',
						'</a>'
					); ?>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
				<?php echo sprintf(
					p__('best-of-voting', 'Die <a href="https://www.youtube.com/playlist?list=%s" target="_blank">Playliste von %s</a>:'),
					$votingPlaylistCode,
					$votingStartDate->locale($language)->isoFormat('MMMM')
				); ?>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<iframe width="100%" height="250" src="https://www.youtube-nocookie.com/embed/videoseries?list=<?php echo htmlentities($votingPlaylistCode); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
</div>
