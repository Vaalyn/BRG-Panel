$(document).ready(function() {
	if (requestSystemActive) {
		registerRequestSongClick();
		registerTrackSearch();
		registerRequestTrackClick(false);
	} else if (messageSystemActive) {
		registerSendMessageClick();
	} else if (requestAutoDjSystemActive) {
		registerTrackSearch();
		registerRequestTrackClick(true);
	}
});

var trackSearchTypingTimer;

function registerTrackSearch() {
	$(document).on(
		'input',
		'#title, #artist',
		function() {
			let title = $('#title').val();
			let artist = $('#artist').val();

			clearTimeout(trackSearchTypingTimer);

			if (title.length < 2 && artist.length < 2) {
				$('tbody').html('');
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
	$(document).on('click', '#request-song', function() {
		let queryParams = {
			title: $('#title').val(),
			artist: $('#artist').val(),
			url: $('#url').val(),
			nickname: $('#nickname').val(),
			message: $('#message').val()
		};

		let buttonReference = $(this);

		$(buttonReference).hide();

		$.post(brgPlayerBaseUrl + '/api/request', queryParams)
			.done(function(response) {
				if (response.status === 'success') {
					Materialize.toast('<i class="material-icons green-text text-darken-1">done</i> ' + response.message, 2000);
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + response.message, 3000);
				}
				$(buttonReference).show();
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Es ist ein Fehler aufgetreten', 3000);
				$(buttonReference).show();
			});
	});
}

function registerRequestTrackClick(registerForAutoDj) {
	$(document).on('click', '.request-track', function() {
		let requestApiUrl = brgPlayerBaseUrl + '/api/request';

		let queryParams = {
			id: $(this).data('id'),
			nickname: $('#nickname').val()
		};

		if (registerForAutoDj) {
			requestApiUrl += '/autodj';
		} else {
			queryParams.message = $('#message').val();
		}

		let buttonReference = $(this);

		$(buttonReference).hide();

		$.post(requestApiUrl, queryParams)
			.done(function(response) {
				if (response.status === 'success') {
					Materialize.toast('<i class="material-icons green-text text-darken-1">done</i> ' + response.message, 2000);
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + response.message, 3000);
				}
				$(buttonReference).show();
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Es ist ein Fehler aufgetreten', 3000);
				$(buttonReference).show();
			});
	});
}

function registerSendMessageClick() {
	$(document).on('click', '#send-message', function() {
		let queryParams = {
			nickname: $('#nickname').val(),
			message: $('#message').val()
		};

		let buttonReference = $(this);

		$(buttonReference).hide();

		$.post(brgPlayerBaseUrl + '/api/message', queryParams)
			.done(function(response) {
				if (response.status === 'success') {
					Materialize.toast('<i class="material-icons green-text text-darken-1">done</i> ' + response.message, 2000);
					$(buttonReference).show();
				} else {
					Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> ' + response.message, 3000);
					$(buttonReference).show();
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text text-darken-1">error_outline</i> Es ist ein Fehler aufgetreten', 3000);
				$(buttonReference).show();
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

function buildRequestModalTrackTable(tracks) {
	$('tbody').html('');

	tracks.forEach(function(track) {
		let row = '<tr>';
		row += '<td class="grey-text text-darken-4">' + track.title + '</td>';
		row += '<td class="grey-text text-darken-4">' + track.artist + '</td>';
		row += '<td>';
		row += '<button class="request-track btn-floating brg-red waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Song requesten" data-id="' + track.id + '">';
		row += '<i class="material-icons">queue_music</i>';
		row += '</button>';
		row += '</td>';
		row += '</tr>';

		$('tbody').append(row);
	});

	$('.tooltipped').tooltip();
}
