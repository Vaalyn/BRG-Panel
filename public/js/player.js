$(document).ready(function() {
	$('#brg-player').jPlayer({
		ready: function() {
			$(this).jPlayer('setMedia', { mp3: getCurrentStreamUrl() });
		},
		pause: function() {
			$(this).jPlayer('clearMedia');
		},
		error: function(event) {
			var stream = { mp3: getCurrentStreamUrl() };
			$(this).jPlayer('setMedia', stream).jPlayer('play');
		},
		cssSelectorAncestor: '.brg-player-container',
		swfPath: 'swf/jquery.jplayer.swf',
		supplied: 'mp3',
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true,
		remainingDuration: false,
		toggleDuration: false,
		volume: 0.5,
		preload: 'none',
		solution: 'html, flash'
	});

	if ($.jPlayer.platform.mobile) {
		$('.brg-player-volume-controls').hide();
	}

	$('#brg-player').bind($.jPlayer.event.play, function(event) {
		$('.brg-player-controls-button-play').hide();
		$('.brg-player-controls-button-pause').show();

		if (!Push.Permission.has() && Push.Permission.get() !== 'denied') {
			Push.Permission.request();
		}
	});

	$('#brg-player').bind($.jPlayer.event.pause, function(event) {
		$('.brg-player-controls-button-play').show();
		$('.brg-player-controls-button-pause').hide();
	});

	$('#brg-player').bind($.jPlayer.event.volumechange, function(event) {
		Cookies.set('brg-player-volume', event.jPlayer.options.volume.toFixed(2), { expires: 365 });

		if (event.jPlayer.options.muted) {
			$('.brg-player-volume-badge').text('0%');
			$('.brg-player-button-mute').hide();
			$('.brg-player-button-unmute').show();
		} else {
			$('.brg-player-volume-badge').text(Math.round(event.jPlayer.options.volume * 100) + '%');
			$('.brg-player-button-mute').show();
			$('.brg-player-button-unmute').hide();
		}
	});

	$(document).on('change', '.brg-player-stream-selection', function() {
		updatePlayerInfo(false);

		$('.brg-player-modal-stream-selection').val($(this).val());

		let playerIsPlaying = isPlayerPlaying();
		$('#brg-player').jPlayer('setMedia', { mp3: getCurrentStreamUrl() });

		if (playerIsPlaying) {
			$('#brg-player').jPlayer('play');
		}
	});

	$(document).on('click', '.brg-player-history-button', function() {
		openHistoryModal();
	});

	$(document).on('click', '.brg-player-request-button-wrapper .btn', function() {
		openSystemModal();
	});

	$(document).on('click', '.brg-player-message-button-wrapper .btn', function() {
		openSystemModal();
	});

	$(document).on('click', '.brg-player-actions-menu-button', function() {
		if (!isEmbededAsIframe()) {
			$('#brg-player-actions-menu').modal('open');
		} else {
			$('.brg-player-actions-wrapper').toggleClass('open');
		}
	});

	registerPlayerActionMenu();

	if (!isEmbededAsIframe()) {
		$.get(brgPlayerBaseUrl + '/player/modal/history')
			.done(function(data) {
				$('body').append(data);
				$('.modal').modal();
			});

		$.get(brgPlayerBaseUrl + '/player/modal/action-menu')
			.done(function(data) {
				$('body').append(data);
				$('.modal').modal();
			});
	} else {
		$('.brg-player-actions-wrapper').addClass('full-framed');

		$(window).on('message onmessage', function(e) {
			if (e.originalEvent.data === 'close-actions-menu') {
				$('.brg-player-actions-wrapper').removeClass('open');
			}
		});
	}

	Push.config({
		serviceWorker: brgPlayerHost + '/js/push.service-worker.min.js'
	});

	updatePlayerInfo(true);
	updatePlayerVoted(true);
	updatePlayerVolume(parseFloat(Cookies.get('brg-player-volume')));
});

/* ######################### */
/* Register Action Functions */
/* ######################### */

function registerUpvoteClick() {
	$(document).on('click', '.brg-player-voting-upvote', function() {
		voteSong('up');
	});
	$('.brg-player-voting-upvote').removeClass('disabled');
}

function registerDownvoteClick() {
	$(document).on('click', '.brg-player-voting-downvote', function() {
		voteSong('down');
	});
	$('.brg-player-voting-downvote').removeClass('disabled');
}

function registerPlayerActionMenu() {
	$(document).on('click', '.brg-player-modal-request-button-wrapper .btn', function() {
		$('#brg-player-actions-menu').modal('close');
		openSystemModal();
	});

	$(document).on('change', '.brg-player-modal-stream-selection', function() {
		$('.brg-player-stream-selection').val($(this).val()).change();
		$('#brg-player-actions-menu').modal('close');
	});
}

var trackSearchTypingTimer;

function registerTrackSearch() {
	$(document).on(
		'input',
		'#brg-player-system-modal #title, #brg-player-system-modal #artist',
		function() {
			let title = $('#brg-player-system-modal #title').val();
			let artist = $('#brg-player-system-modal #artist').val();

			clearTimeout(trackSearchTypingTimer);

			if (title.length < 2 && artist.length < 2) {
				$('#brg-player-system-modal tbody').html('');
				return;
			}

			trackSearchTypingTimer = setTimeout(function() {
				searchAutoDjTracks(title, artist)
					.then(function(response) {
						buildRequestModalTrackTable(response.result);
					})
					.catch(function(error) {
						console.log(error);
					});
			}, 500);
		}
	);
}

function registerRequestSongClick() {
	$(document).on('click', '#brg-player-system-modal #request-song', function() {
		let queryParams = {
			title: $('#brg-player-system-modal #title').val(),
			artist: $('#brg-player-system-modal #artist').val(),
			url: $('#brg-player-system-modal #url').val(),
			nickname: $('#brg-player-system-modal #nickname').val(),
			message: $('#brg-player-system-modal #message').val()
		};

		$.post(brgPlayerBaseUrl + '/api/request', queryParams)
			.done(function(response) {
				if (response.status === 'success') {
					Materialize.toast('<i class="material-icons green-text text-darken-1">done</i> ' + response.message, 2000, '', function() {
						$('#brg-player-system-modal').modal('close');
					});
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + response.message, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Es ist ein Fehler aufgetreten', 3000);
			});
	});
}

function registerRequestTrackClick(registerForAutoDj) {
	$(document).on('click', '#brg-player-system-modal .request-track', function() {
		let requestApiUrl = brgPlayerBaseUrl + '/api/request';

		let queryParams = {
			id: $(this).data('id'),
			nickname: $('#brg-player-system-modal #nickname').val()
		};

		if (registerForAutoDj) {
			requestApiUrl += '/autodj';
		} else {
			queryParams.message = $('#brg-player-system-modal #message').val();
		}

		$.post(requestApiUrl, queryParams)
			.done(function(response) {
				if (response.status === 'success') {
					Materialize.toast('<i class="material-icons green-text text-darken-1">done</i> ' + response.message, 2000, '', function() {
						$('#brg-player-system-modal').modal('close');
					});
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + response.message, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Es ist ein Fehler aufgetreten', 3000);
			});
	});
}

function registerSendMessageClick() {
	$(document).on('click', '#brg-player-system-modal #send-message', function() {
		let queryParams = {
			nickname: $('#brg-player-system-modal #nickname').val(),
			message: $('#brg-player-system-modal #message').val()
		};

		$.post(brgPlayerBaseUrl + '/api/message', queryParams)
			.done(function(response) {
				if (response.status === 'success') {
					Materialize.toast('<i class="material-icons green-text text-darken-1">done</i> ' + response.message, 2000, '', function() {
						$('#brg-player-system-modal').modal('close');
					});
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + response.message, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Es ist ein Fehler aufgetreten', 3000);
			});
	});
}

/* ########################### */
/* Deregister Action Functions */
/* ########################### */

function deregisterUpvoteClick() {
	$(document).off('click', '.brg-player-voting-upvote');
	$('.brg-player-voting-upvote').addClass('disabled');
}

function deregisterDownvoteClick() {
	$(document).off('click', '.brg-player-voting-downvote');
	$('.brg-player-voting-downvote').addClass('disabled');
}

function deregisterTrackSearch() {
	$(document).off(
		'input',
		'#brg-player-system-modal #title, #brg-player-system-modal #artist'
	);
}

function deregisterRequestSongClick() {
	$(document).off('click', '#brg-player-system-modal #request-song');
}

function deregisterRequestTrackClick() {
	$(document).off('click', '#brg-player-system-modal .request-track');
}

function deregisterSendMessageClick() {
	$(document).off('click', 'brg-player-system-modal #send-message');
}

/* ############### */
/* Modal Functions */
/* ############### */

function openSystemModal() {
	if (isEmbededAsIframe()) {
		notifyIfPopUpIsBlocked(window.open('system'));
		return;
	}

	$('#brg-player-system-modal').remove();

	deregisterRequestSongClick();
	deregisterTrackSearch();
	deregisterRequestTrackClick();
	deregisterSendMessageClick();

	$.get(brgPlayerBaseUrl + '/player/modal/system')
		.done(function(data) {
			$('body').append(data);
			$('.modal').modal();
			$('.tooltipped').tooltip();

			registerRequestSystemModalListeners().then(function(requestSystemActive) {
				if (!requestSystemActive) {
					registerMessageSystemModalListeners().then(function(messageSystemActive) {
						if (!messageSystemActive) {
							registerAutoDjRequestModalListeners();
						}
					});
				}
			});

			$('#brg-player-system-modal').modal('open');
		});
}

function registerRequestSystemModalListeners() {
	return new Promise(function(resolve, reject) {
		isRequestSystemActive().then(function(active) {
			if (active) {
				registerRequestSongClick();
				registerTrackSearch();
				registerRequestTrackClick(false);
			}

			resolve(active);
		});
	});
}

function registerAutoDjRequestModalListeners() {
	return new Promise(function(resolve, reject) {
		isAutoDjRequestSystemActive().then(function(active) {
			if (active) {
				registerTrackSearch();
				registerRequestTrackClick(true);
			}

			resolve(active);
		});
	});
}

function registerMessageSystemModalListeners() {
	return new Promise(function(resolve, reject) {
		isMessageSystemActive().then(function(active) {
			if (active) {
				registerSendMessageClick();
			}

			resolve(active);
		});
	});
}

function openHistoryModal() {
	if (isEmbededAsIframe()) {
		notifyIfPopUpIsBlocked(window.open('history'));
		return;
	}

	getSongHistory(1)
		.then(function(response) {
			let dateOptions = {
				'day': '2-digit',
				'month': '2-digit',
				'year': '2-digit'
			};
			let history = response.result;

			$('#brg-player-history-modal tbody').html('');

			history.forEach(function(entry) {
				var row = '<tr>';
				row += '<td>' + entry.time_played + '</td>';
				row += '<td>' + new Date(entry.date_played).toLocaleDateString('de-DE', dateOptions) + '</td>';
				row += '<td>' + entry.artist + '</td>';
				row += '<td>' + entry.title + '</td>';
				row += '</tr>';

				$('#brg-player-history-modal tbody').append(row);
			});
		});

	$('#brg-player-history-modal').modal('open');
}

/* ####################### */
/* Player Action Functions */
/* ####################### */

function voteSong(direction) {
	return new Promise(function(resolve, reject) {
		getVoterId()
			.then(function(voterId) {
				let queryParams = {
					voter_id: voterId,
					direction: direction
				};

				$.post(brgPlayerBaseUrl + '/api/vote/' + getCurrentStream(), queryParams)
					.done(function(data) {
						updatePlayerVoted(false);
						updatePlayerInfo(false);
						resolve();
					});
			});
	});
}

function updatePlayerInfo(repeat) {
	$.get(brgPlayerBaseUrl + '/api/streaminfo/' + getCurrentStream())
		.done(function(response) {
			if (response.status !== 'success') {
				return;
			}

			let songTitle = response.result.artist + ' - ' + response.result.title;

			if (isPlayerPlaying() && Push.Permission.has() && $('.brg-player-title span').text() !== songTitle) {
				Push.create(songTitle, {
					body: 'Upvotes: ' + response.result.upvotes + ' | Downvotes: ' + response.result.downvotes,
					icon: brgPlayerHost + '/image/brg_logo.png',
					timeout: 6000,
					onClick: function() {
						window.focus();
						this.close();
					}
				});
			}

			$('.brg-player-title span').text(songTitle);
			$('.brg-player-votes').text(response.result.upvotes - response.result.downvotes);
			$('.brg-player-listener-count').text(response.result.listener);

			if (['DJ-Pony Lucy', 'DJ-Pony Mary'].indexOf(response.result.current_event) === -1) {
				$('.brg-player-details').addClass('live');
			} else if ($('.brg-player-details').hasClass('live')) {
				$('.brg-player-details').removeClass('live');
			}
		})
		.fail(function(error) {
			console.log('Nowplaying info could not be updated:', error);
		})
		.always(function() {
			if (repeat) {
				setTimeout(function() {
					updatePlayerInfo(true);
				}, 5000);
			}
		});

	updateSystemButtons();
}

function updatePlayerVolume(volume) {
	if (isNaN(volume)) {
		return;
	}

	$('#brg-player').jPlayer('option', 'volume', volume);
}

function updatePlayerVoted(repeat) {
	getVoterId()
		.then(function(voterId) {
			$.get(brgPlayerBaseUrl + '/api/vote/check/' + voterId + '/' + getCurrentStream())
				.done(function(response) {
					if (response.status !== 'success') {
						return;
					}

					registerUpvoteClick();
					registerDownvoteClick();

					if (!response.result.voted) {
						if ($('.brg-player-voting-downvote').hasClass('red')) {
							$('.brg-player-voting-downvote').removeClass('red');
						}

						if ($('.brg-player-voting-upvote').hasClass('green')) {
							$('.brg-player-voting-upvote').removeClass('green');
						}

						return;
					}

					if (response.result.direction === 'up') {
						deregisterUpvoteClick();
						$('.brg-player-voting-upvote').addClass('green');
						$('.brg-player-voting-downvote').removeClass('red');
					} else if (response.result.direction === 'down') {
						deregisterDownvoteClick();
						$('.brg-player-voting-downvote').addClass('red');
						$('.brg-player-voting-upvote').removeClass('green');
					}
				})
				.fail(function(error) {
					console.log('Voting info could not be updated:', error);
				})
				.always(function() {
					if (repeat) {
						setTimeout(function() {
							updatePlayerVoted(true);
						}, 5000);
					}
				});
		});
}

function updateSystemButtons() {
	isRequestSystemActive().then(function(active) {
		if (active) {
			$('.brg-player-message-button-wrapper').addClass('hide');
			$('.brg-player-request-button-wrapper').removeClass('hide');
			return;
		}

		isMessageSystemActive().then(function(active) {
			if (active) {
				$('.brg-player-request-button-wrapper').addClass('hide');
				$('.brg-player-message-button-wrapper').removeClass('hide');
				return;
			}

			isAutoDjRequestSystemActive().then(function(active) {
				$('.brg-player-message-button-wrapper').addClass('hide');
				$('.brg-player-request-button-wrapper').removeClass('hide');
			});
		});
	});
}

/* ################## */
/* API Call Functions */
/* ################## */

function isRequestSystemActive() {
	return new Promise(function(resolve, reject) {
		getSystemStatus(1)
			.then(function(response) {
				resolve(response);
			})
			.catch(function(error) {
				reject(error);
			});
	});
}

function isMessageSystemActive() {
	return new Promise(function(resolve, reject) {
		getSystemStatus(2)
			.then(function(response) {
				resolve(response);
			})
			.catch(function(error) {
				reject(error);
			});
	});
}

function isAutoDjRequestSystemActive() {
	return new Promise(function(resolve, reject) {
		getSystemStatus(3)
			.then(function(response) {
				resolve(response);
			})
			.catch(function(error) {
				reject(error);
			});
	});
}

function getSystemStatus(uid) {
	return new Promise(function(resolve, reject) {
		$.get(brgPlayerBaseUrl + '/api/status/' + uid)
			.done(function(response) {
				if (response.status !== 'success') {
					resolve(false);
				}

				resolve(response.result.active);
			})
			.fail(function(error) {
				reject(error);
			});
	});
}

function getSongHistory(page) {
	return new Promise(function(resolve, reject) {
		$.get(brgPlayerBaseUrl + '/api/history/' + page)
			.done(function(response) {
				if (response.status !== 'success') {
					reject(response.message);
				}

				resolve(response);
			})
			.fail(function(error) {
				reject(error);
			});
	});
}

function searchAutoDjTracks(title, artist) {
	return new Promise(function(resolve, reject) {
		let queryParams = {
			title: title,
			artist: artist
		};

		$.get(brgPlayerBaseUrl + '/api/track/list/autodj', queryParams)
			.done(function(response) {
				if (response.status !== 'success') {
					reject(response.message);
				}

				resolve(response);
			})
			.fail(function(error) {
				reject(error);
			});
	});
}

function registerVoter() {
	return new Promise(function(resolve, reject) {
		$.post(brgPlayerBaseUrl + '/api/voter')
			.done(function(response) {
				if (response.status !== 'success') {
					reject(response.message);
				}

				resolve(response);
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Es ist ein Fehler aufgetreten', 3000);
			});
	});
}

/* ################ */
/* Helper Functions */
/* ################ */

function getCurrentStream() {
	return $('.brg-player-stream-selection').val();
}

function getCurrentStreamUrl() {
	return getStreamUrl(getCurrentStream());
}

function getStreamUrl(streamName) {
	switch (streamName) {
		case 'stream':
			return 'http://radio.bronyradiogermany.com:8000/stream';
		case 'mobile':
			return 'http://radio.bronyradiogermany.com:8000/mobile';
		case 'opus':
			return 'http://radio.bronyradiogermany.com:8000/opus';
		case 'nightdj':
			return 'http://radio.bronyradiogermany.com:8003/nightdj_autodj';
		case 'daydj':
			return 'http://radio.bronyradiogermany.com:8006/daydj_autodj';
	}
}

function buildRequestModalTrackTable(tracks) {
	$('#brg-player-system-modal tbody').html('');

	tracks.forEach(function(track) {
		let row = '<tr>';
		row += '<td class="grey-text text-darken-4">' + track.title + '</td>';
		row += '<td class="grey-text text-darken-4">' + track.artist + '</td>';
		row += '<td>';
		row += '<button class="request-track btn-floating waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Song requesten" data-id="' + track.id + '">';
		row += '<i class="material-icons">queue_music</i>';
		row += '</button>';
		row += '</td>';
		row += '</tr>';

		$('#brg-player-system-modal tbody').append(row);
	});

	$('.tooltipped').tooltip();
}

function isPlayerPlaying() {
	return !$('#brg-player').data('jPlayer').status.paused;
}

function isEmbededAsIframe() {
	if (top !== self) {
		return true;
	}

	return false;
}

function getVoterId() {
	return new Promise(function(resolve, reject) {
		let voterId = getVoterIdFromCookie();

		if (voterId === undefined) {
			voterId = getVoterIdFromLocalStorage();
		}

		if (voterId === undefined) {
			registerVoter()
				.then(function(response) {
					updateVoterIdInStorage(response.result.voter_id);
					resolve(response.result.voter_id);
				});
		} else {
			updateVoterIdInStorage(voterId);
			resolve(voterId);
		}
	});
}

function getVoterIdFromCookie() {
	return Cookies.get('brg-player-voting-uuid');
}

function getVoterIdFromLocalStorage() {
	let uuid = localStorage.getItem('brg-player-voting-uuid');
	return uuid === null ? undefined : uuid;
}

function updateVoterIdInStorage(uuid) {
	setVoterIdInCookie(uuid);
	setVoterIdInLocalStorage(uuid);
}

function setVoterIdInCookie(uuid) {
	Cookies.set('brg-player-voting-uuid', uuid, { expires: 365 });
}

function setVoterIdInLocalStorage(uuid) {
	localStorage.setItem('brg-player-voting-uuid', uuid);
}

function notifyIfPopUpIsBlocked(windowReference) {
	if (windowReference === null || windowReference === undefined) {
		alert('Dein Browser blockiert das öffnen des Fensters. Bitte erlaube das öffnen von Pop-ups.');
	}
}
