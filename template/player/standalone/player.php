<?php include_once(__DIR__ . '/../header.php'); ?>
	<?php if (!isset($external)) : ?>
		<?php include_once(__DIR__ . '/partner.php'); ?>
	<?php endif; ?>

	<div class="brg-player-container">
		<div id="brg-player" class="jp-jplayer hide">
			<audio id="brg-audio" preload="none" src="http://radio.bronyradiogermany.com:8000/stream"></audio>
		</div>
		<div class="container">
			<div class="row">
				<div class="col s12">
					<div class="brg-player-controls">
						<div class="brg-player-controls-button-play btn-floating waves-effect white">
							<a href="javascript:;" class="jp-play">
								<i class="material-icons">play_arrow</i>
							</a>
						</div>

						<div class="brg-player-controls-button-pause btn-floating waves-effect white">
							<a href="javascript:;" class="jp-pause">
								<i class="material-icons">pause</i>
							</a>
						</div>
					</div>
					<div class="brg-player-details">
						<div class="brg-player-live-label green white-text">
							Live
						</div>

						<div class="brg-player-title marquee grey darken-4">
							<span></span>
						</div>

						<a href="javascript:;" class="brg-player-history-button btn white">
							<i class="material-icons">playlist_play</i>
							<span class="hide-on-small-only">Songliste</span>
						</a>

						<div class="brg-player-volume">
							<div class="brg-player-volume-controls">
								<div class="brg-player-volume-controls-wrapper">
									<div class="brg-player-volume-controls-button brg-player-button-mute z-depth-1">
										<a href="javascript:;" class="jp-mute tooltipped" data-position="top" data-delay="50" data-tooltip="Mute">
											<i class="material-icons">volume_up</i>
										</a>
									</div>

									<div class="brg-player-volume-controls-button brg-player-button-unmute z-depth-1">
										<a href="javascript:;" class="jp-unmute tooltipped" data-position="top" data-delay="50" data-tooltip="Unmute">
											<i class="material-icons">volume_mute</i>
										</a>
									</div>
								</div>
								<span class="brg-player-volume-badge white">100%</span>
							</div>
							<div class="brg-player-volume-bar-container">
								<div class="brg-player-volume-bar jp-volume-bar grey darken-4">
									<div class="brg-player-volume-bar-value jp-volume-bar-value green"></div>
								</div>
							</div>
						</div>

						<div class="brg-player-voting">
							<a href="javascript:;" class="brg-player-voting-downvote z-depth-1 disabled">
								<i class="material-icons red-text text-lighten-2">thumb_down</i>
							</a>

							<div class="brg-player-votes grey darken-4 white-text">0</div>

							<a href="javascript:;" class="brg-player-voting-upvote z-depth-1 disabled">
								<i class="material-icons green-text text-lighten-2">thumb_up</i>
							</a>
						</div>

						<div class="brg-player-listener grey darken-4">
							<i class="material-icons">people</i>
							<span class="brg-player-listener-count">0</span>
						</div>
					</div>
					<div class="brg-player-actions">
						<a href="javascript:;" class="brg-player-actions-menu-button btn-floating waves-effect white hide-on-med-and-up">
							<i class="material-icons">menu</i>
						</a>

						<div class="brg-player-actions-wrapper">
							<div class="brg-player-stream-selection-wrapper">
								<select class="brg-player-stream-selection browser-default">
									<?php foreach ($mountpoints as $mountpoint) : ?>
										<?php if ($preSelectedMountpoint === $mountpoint['mountpoint']) : ?>
											<option value="<?php echo $mountpoint['mountpoint'] ?>" selected><?php echo $mountpoint['name'] ?></option>
										<?php else : ?>
											<option value="<?php echo $mountpoint['mountpoint'] ?>"><?php echo $mountpoint['name'] ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
							</div>

							<div class="brg-player-request-button-wrapper hide">
								<a class="waves-effect waves-light btn white grey-text text-darken-4">
									<i class="material-icons left">queue_music</i>Request
								</a>
							</div>

							<div class="brg-player-message-button-wrapper hide">
								<a class="waves-effect waves-light btn white grey-text text-darken-4">
									<i class="material-icons left">chat</i>Nachricht
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="jp-no-solution" style="display: none;">
				<span class="jp-ns-title">Browser Update benötigt</span><br/>
				Dein Browser unterstützt keinen Standard HTML5 oder Flash Audio Stream.<br/>
				Werde endlich modern und nutze einen aktuellen Browser!
			</div>
		</div>
	</div>
<?php include_once(__DIR__ . '/../footer.php'); ?>
