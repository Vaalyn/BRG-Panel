$(document).ready(function() {
	$('.button-collapse').sideNav();
	$('.modal').modal();
	$('select').material_select();

	$('.datepicker').pickadate({
		monthsFull: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
		monthsShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
		weekdaysFull: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
		weekdaysShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
		format: 'dd.mm.yyyy',
		formatSubmit: 'yyyy-mm-dd',
		firstDay: 1,
		selectMonths: true,
		selectYears: 50,
		today: 'Heute',
		clear: 'Löschen',
		close: 'Schließen',
		closeOnSelect: true,
		hiddenName: true
	});

	/***************/
	// Login START
	/***************/

	$('#forgot-password-modal .modal-save').on('click', function() {
		let username = $('#username-forgot').val();
		let email = $('#email-forgot').val();

		$.post('api/user/password/forgot', {username: username, email: email})
			.done(function(response) {
				if (response.status === 'success') {
					Materialize.toast('<i class="material-icons green-text">done</i> ' + response.message, 2000, '', function() {
						window.location.reload();
					});
				} else {
					Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text">clear</i> Fehler beim zurücksetzen', 3000);
			});
	});

	/*************/
	// Login END
	/*************/

	/************************/
	// Password Reset START
	/************************/

	$('#password-reset #change-password').on('click', function() {
		let code = $('#code').val();
		let password = $('#password').val();

		$.post('api/user/password/reset', {code: code, password: password})
			.done(function(response) {
				if (response.status === 'success') {
					Materialize.toast('<i class="material-icons green-text">done</i> ' + response.message, 2000, '', function() {
						window.location.reload();
					});
				} else {
					Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text">clear</i> Fehler beim zurücksetzen', 3000);
			});
	});

	/************************/
	// Password Reset END
	/************************/

	/********************/
	// Dashboard START
	/********************/

	$('#system-requests #set-request-system-active').click(function(event) {
		event.preventDefault();
		var button = this;

		var active 	= $(button).data('active');

		var message = 'Das Request System wirklich ';
		var status 	= '';

		if (active === 1) {
			message += 'aktivieren?';
			status 	= 'aktiviert';
		} else {
			message += 'deaktivieren?';
			status 	= 'deaktiviert';
		}

		$.confirm({
			theme: 'supervan',
			title: 'Request System Status ändern',
			content: message,
			buttons: {
				confirm: {
					text: 'Ja',
					btnClass: 'btn green',
					action: function() {
						$.ajax({
							type: 'POST',
							url: document.baseURI + 'api/dashboard/system/request/status/' + active,
							data: null,
							success: function(response) {
								if (response.status === 'success') {
									if (active === 1) {
										$(button).removeClass('green-text');
										$(button).addClass('red-text');
										$(button).closest('tr').find('td:nth-child(2)').text('Aktiv');
										$(button).find('.material-icons').text('remove_circle');
										$(button).data('active', '0');
									} else {
										$(button).removeClass('red-text');
										$(button).addClass('green-text');
										$(button).closest('tr').find('td:nth-child(2)').text('Inaktiv');
										$(button).find('.material-icons').text('check_circle');
										$(button).data('active', '1');
									}

									Materialize.toast('<i class="material-icons green-text">done</i> Das Request System wurde ' + status, 3000);
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons red-text">clear</i> Das Request konnte nicht ' + status + ' werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Nein',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			}
		});
	});

	$('#system-requests #set-request-system-requests-count').click(function(event) {
		event.preventDefault();
		var button = this;

		$.confirm({
			theme: 'supervan',
			title: 'Anzahl Requests pro Person ändern',
			content: '' +
				'<form action="" class="set-request-system-requests-count-form">' +
					'<div class="row">' +
						'<div class="input-field col s8 m6 l4 offset-s2 offset-m3 offset-l4">' +
							'<input type="text" class="name form-control" id="set-request-system-requests-count-input" placeholder="#" required />' +
							'<label for="set-request-system-requests-count-input">Anzahl Requests pro Person</label>' +
						'</div>' +
					'</div>' +
				'</form>',
			buttons: {
				save: {
					text: 'Speichern',
					btnClass: 'btn green',
					action: function() {
						var newRequestCount = this.$content.find('#set-request-system-requests-count-input').val();

						$.ajax({
							type: 'POST',
							url: document.baseURI + 'api/dashboard/system/request/limit/' + newRequestCount,
							data: null,
							success: function(response) {
								if (response.status === 'success') {
									$(button).closest('tr').find('td:nth-child(2)').text(newRequestCount);
									Materialize.toast('<i class="material-icons green-text">done</i> Die Request Anzahl pro Person wurde geändern', 3000);
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons red-text">clear</i> Die Request Anzahl pro Person konnte nicht geändert werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Abbrechen',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			},
			onContentReady: function() {
				var jc = this;
				this.$content.find('form').on('submit', function(e) {
					e.preventDefault();
				});

				Materialize.updateTextFields();
			}
		});
	});

	$('#system-messages #set-message-system-active').click(function(event) {
		event.preventDefault();
		var button = this;

		var active 	= $(button).data('active');

		var message = 'Das Message System wirklich ';
		var status 	= '';

		if (active === 1) {
			message += 'aktivieren?';
			status 	= 'aktiviert';
		} else {
			message += 'deaktivieren?';
			status 	= 'deaktiviert';
		}

		$.confirm({
			theme: 'supervan',
			title: 'Message System Status ändern',
			content: message,
			buttons: {
				confirm: {
					text: 'Ja',
					btnClass: 'btn green',
					action: function() {
						$.ajax({
							type: 'POST',
							url: document.baseURI + 'api/dashboard/system/message/status/' + active,
							data: null,
							success: function(response) {
								if (response.status === 'success') {
									if (active === 1) {
										$(button).removeClass('green-text');
										$(button).addClass('red-text');
										$(button).closest('tr').find('td:nth-child(2)').text('Aktiv');
										$(button).find('.material-icons').text('remove_circle');
										$(button).data('active', '0');
									} else {
										$(button).removeClass('red-text');
										$(button).addClass('green-text');
										$(button).closest('tr').find('td:nth-child(2)').text('Inaktiv');
										$(button).find('.material-icons').text('check_circle');
										$(button).data('active', '1');
									}

									Materialize.toast('<i class="material-icons green-text">done</i> Das Message System wurde ' + status, 3000);
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons red-text">clear</i> Das Message konnte nicht ' + status + ' werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Nein',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			}
		});
	});

	$('#system-autodj-requests #set-autodj-request-system-active').click(function(event) {
		event.preventDefault();
		var button = this;

		var active 	= $(button).data('active');

		var message = 'Das AutoDJ Request System wirklich ';
		var status 	= '';

		if (active === 1) {
			message += 'aktivieren?';
			status 	= 'aktiviert';
		} else {
			message += 'deaktivieren?';
			status 	= 'deaktiviert';
		}

		$.confirm({
			theme: 'supervan',
			title: 'AutoDJ Request System Status ändern',
			content: message,
			buttons: {
				confirm: {
					text: 'Ja',
					btnClass: 'btn green',
					action: function() {
						$.ajax({
							type: 'POST',
							url: document.baseURI + 'api/dashboard/system/autodj/request/status/' + active,
							data: null,
							success: function(response) {
								if (response.status === 'success') {
									if (active === 1) {
										$(button).removeClass('green-text');
										$(button).addClass('red-text');
										$(button).closest('tr').find('td:nth-child(2)').text('Aktiv');
										$(button).find('.material-icons').text('remove_circle');
										$(button).data('active', '0');
									} else {
										$(button).removeClass('red-text');
										$(button).addClass('green-text');
										$(button).closest('tr').find('td:nth-child(2)').text('Inaktiv');
										$(button).find('.material-icons').text('check_circle');
										$(button).data('active', '1');
									}

									Materialize.toast('<i class="material-icons green-text">done</i> Das AutoDJ Request System wurde ' + status, 3000);
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons red-text">clear</i> Das AutoDJ Request konnte nicht ' + status + ' werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Nein',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			}
		});
	});

	$('#systems .set-system-rules').click(function(event) {
		event.preventDefault();
		var button = this;

		$.confirm({
			theme: 'supervan',
			title: 'Regeln ändern',
			content: '' +
				'<form action="" class="set-system-rules-form">' +
					'<div class="row">' +
						'<div class="input-field col s8 m6 l4 offset-s2 offset-m3 offset-l4">' +
							'<input type="text" class="name form-control" id="set-system-rules-input" required />' +
							'<label for="set-system-rules-input">Regeln</label>' +
						'</div>' +
					'</div>' +
				'</form>',
			buttons: {
				save: {
					text: 'Speichern',
					btnClass: 'btn green',
					action: function() {
						var rules = this.$content.find('#set-system-rules-input').val();
						var systemId = $(button).data('system-id');

						$.ajax({
							type: 'POST',
							url: document.baseURI + 'api/dashboard/system/' + systemId + '/rules',
							data: {
								rules: rules
							},
							success: function(response) {
								if (response.status === 'success') {
									$(button).closest('tr').find('td:nth-child(2)').text(rules);
									Materialize.toast('<i class="material-icons green-text">done</i> Die Regeln wurden geändern', 3000);
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons red-text">clear</i> Die Regeln konnten nicht geändert werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Abbrechen',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			},
			onContentReady: function() {
				var jc = this;
				this.$content.find('form').on('submit', function(e) {
					e.preventDefault();
				});

				Materialize.updateTextFields();
			}
		});
	});

	$('.bot-restart').click(function(event) {
		event.preventDefault();
		var button = this;

		var bot = $(button).data('bot');
		var botName = $(button).data('name');

		var message = botName + ' wirklich neustarten?';

		$.confirm({
			theme: 'supervan',
			title: botName + ' neustarten',
			content: message,
			buttons: {
				confirm: {
					text: 'Ja',
					btnClass: 'btn green',
					action: function() {
						$.ajax({
							type: 'POST',
							url: document.baseURI + 'api/dashboard/discord/bot/' + bot + '/restart',
							data: null,
							success: function(response) {
								if (response.status === 'success') {
									Materialize.toast('<i class="material-icons green-text">done</i> ' + botName + ' wurde neugestartet', 3000);
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons right red-text">clear</i> ' + botName + ' konnte nicht neugestartet werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Nein',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			}
		});
	});

	$('.update-stream-tags').click(function(event) {
		event.preventDefault();
		var button = this;

		var mountpoint = $(button).data('mountpoint');

		var message = '<div class="row"><div class="col s12 m6 offset-m3"><label>Artist - Title</label>';
		message += '<input type="text"/></div></div>';

		$.confirm({
			theme: 'supervan',
			title: 'Tags ändern',
			content: message,
			buttons: {
				confirm: {
					text: 'Ändern',
					btnClass: 'btn green',
					action: function() {
						$.ajax({
							type: 'POST',
							url: document.baseURI + 'api/dashboard/icecast/metadata/' + mountpoint,
							data: {
								song: this.$content.find('input').val()
							},
							success: function(response) {
								if (response.status === 'success') {
									Materialize.toast('<i class="material-icons green-text">done</i> Tags wurden geändert', 3000);
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons red-text">clear</i> Tags konnten nicht geändert werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Abbrechen',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			}
		});
	});

	/********************/
	// Dashboard END
	/********************/

	/********************/
	// Requests START
	/********************/

	$('#requests .set-request-played').click(function(event) {
		event.preventDefault();

		var uid = $(this).data('uid');
		var row = $(this).closest('tr');

		$.confirm({
			theme: 'supervan',
			title: 'Request als gespielt markieren?',
			content: 'Den Reuqest #' + uid + ' wirklich als gespielt markieren?',
			buttons: {
				confirm: {
					text: 'Ja',
					btnClass: 'btn green',
					action: function() {
						$.ajax({
							type: 'POST',
							url: document.baseURI + 'api/dashboard/request/' + uid + '/played',
							data: null,
							success: function(response) {
								if (response.status === 'success') {
									$(row).fadeOut(300, function(row) {
										$(row).remove();
									});
									Materialize.toast('<i class="material-icons green-text">done</i> Request wurde als gespielt markiert', 3000);
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons red-text">clear</i> Request konnte nicht als gespielt markiert werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Nein',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			}
		});
	});

	$('#requests .set-request-skipped').click(function(event) {
		event.preventDefault();

		var uid = $(this).data('uid');
		var row = $(this).closest('tr');

		$.confirm({
			theme: 'supervan',
			title: 'Request ablehnen?',
			content: 'Den Reuqest #' + uid + ' wirklich ablehnen?',
			buttons: {
				confirm: {
					text: 'Ja',
					btnClass: 'btn green',
					action: function() {
						$.ajax({
							type: 'POST',
							url: document.baseURI + 'api/dashboard/request/' + uid + '/skipped',
							data: null,
							success: function(response) {
								if (response.status === 'success') {
									$(row).fadeOut(300, function(row) {
										$(row).remove();
									});
									Materialize.toast('<i class="material-icons green-text">done</i> Request wurde abgelehnt', 3000);
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons red-text">clear</i> Request konnte nicht abgelehnt werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Nein',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			}
		});
	});

	/********************/
	// Requests END
	/********************/

	/********************/
	// Messages START
	/********************/

	$('#messages .delete-message').click(function(event) {
		event.preventDefault();

		var uid = $(this).data('uid');
		var row = $(this).closest('tr');

		$.confirm({
			theme: 'supervan',
			title: 'Nachricht entfernen?',
			content: 'Die Nachricht #' + uid + ' wirklich entfernen?',
			buttons: {
				confirm: {
					text: 'Ja',
					btnClass: 'btn green',
					action: function() {
						$.ajax({
							type: 'DELETE',
							url: document.baseURI + 'api/dashboard/message/' + uid,
							data: null,
							success: function(response) {
								if (response.status === 'success') {
									$(row).fadeOut(300, function(row) {
										$(row).remove();
									});
									Materialize.toast('<i class="material-icons green-text">done</i> Nachricht wurde entfernt', 3000);
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons red-text">clear</i> Nachricht konnte nicht entfernt werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Nein',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			}
		});
	});

	/********************/
	// Messages END
	/********************/

	/********************/
	// Account START
	/********************/

	$('#account #set-account-email').click(function(event) {
		event.preventDefault();

		var email = $('#account-email').val();

		$.confirm({
			theme: 'supervan',
			title: 'E-Mail Adresse des Accounts ändern?',
			content: 'Die E-Mail Adresse des Account wirklich ändern?',
			buttons: {
				confirm: {
					text: 'Ja',
					btnClass: 'btn green',
					action: function() {
						$.ajax({
							type: 'POST',
							url: document.baseURI + 'api/dashboard/user/email',
							data: {
								email: email
							},
							success: function(response) {
								if (response.status === 'success') {
									Materialize.toast('<i class="material-icons green-text">done</i> E-Mail Adresse wurde geändert', 3000);
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons red-text">clear</i> E-Mail Adresse konnte nicht geändert werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Nein',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			}
		});
	});

	$('#account #set-account-password').click(function(event) {
		event.preventDefault();

		var passwordOld = $('#account-password-old').val();
		var passwordNew = $('#account-password-new').val();

		$.confirm({
			theme: 'supervan',
			title: 'Passwort ändern?',
			content: 'Das Passwort wirklich ändern?',
			buttons: {
				confirm: {
					text: 'Ja',
					btnClass: 'btn green',
					action: function() {
						$.ajax({
							type: 'POST',
							url: document.baseURI + 'api/dashboard/user/password',
							data: {
								passwordOld: passwordOld,
								passwordNew: passwordNew
							},
							success: function(response) {
								if (response.status === 'success') {
									Materialize.toast('<i class="material-icons green-text">done</i> Passwort wurde geändert', 3000);
									$('#account-password-old').val('');
									$('#account-password-new').val('');
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons red-text">clear</i> Passwort konnte nicht geändert werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Nein',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			}
		});
	});

	/********************/
	// Account END
	/********************/

	/********************/
	// Votes START
	/********************/

	$(document).on('click', '#votes .set-song-ignore-votes', function(event) {
		event.preventDefault();

		var uid = $(this).data('uid');
		var row = $(this).closest('tr');

		$.confirm({
			theme: 'supervan',
			title: 'Song ausblenden?',
			content: 'Den Song wirklich ausblenden?',
			buttons: {
				confirm: {
					text: 'Ja',
					btnClass: 'btn green',
					action: function() {
						$.ajax({
							type: 'POST',
							url: document.baseURI + 'api/dashboard/track/' + uid + '/votes/ignore',
							data: null,
							success: function(response) {
								if (response.status === 'success') {
									$(row).fadeOut(300, function(row) {
										$(row).remove();
									});
									Materialize.toast('<i class="material-icons green-text">done</i> Der Song wurde erfolgreich ausgeblendet', 3000);
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons red-text">clear</i> Der Song konnte nicht ausgeblendet werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Nein',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			}
		});
	});

	/********************/
	// Votes END
	/********************/

	/********************/
	// Donations START
	/********************/

	$('#donation #save-currently-needed-donation-amount').click(function(event) {
		event.preventDefault();

		var amount = $('#currently-needed-donation-amount').val();

		$.confirm({
			theme: 'supervan',
			title: 'Benötigte Spendensumme ändern?',
			content: 'Die benötigte Spendensumme wirklich ändern?',
			buttons: {
				confirm: {
					text: 'Ja',
					btnClass: 'btn green',
					action: function() {
						$.ajax({
							type: 'POST',
							url: document.baseURI + 'api/dashboard/setting/currently-needed-donation-amount',
							data: {
								amount: amount
							},
							success: function(response) {
								if (response.status === 'success') {
									Materialize.toast('<i class="material-icons green-text">done</i> Benötigte Spendensumme wurde geändert', 3000);
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons red-text">clear</i> Benötigte Spendensumme konnte nicht geändert werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Nein',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			}
		});
	});

	$('#donation #save-donation').click(function(event) {
		event.preventDefault();

		var name = $('#donor-name').val();
		var amount = $('#donor-donated-amount').val();

		$.confirm({
			theme: 'supervan',
			title: 'Spende hinzufügen?',
			content: 'Die Spende wirklich hinzufügen?',
			buttons: {
				confirm: {
					text: 'Ja',
					btnClass: 'btn green',
					action: function() {
						$.ajax({
							type: 'POST',
							url: document.baseURI + 'api/dashboard/donation',
							data: {
								name: name,
								amount: amount
							},
							success: function(response) {
								if (response.status === 'success') {
									Materialize.toast('<i class="material-icons green-text">done</i> Spende wurde hinzugefügt', 3000);
									$('#donations .row .col').append(
										'<div class="chip brg-red white-text z-depth-1 donation">' +
											'<span class="brg-red-dark white-text center donor-donated-amount">' + amount + '€</span>' +
											name +
											'<i class="delete material-icons" data-id="' + response.id + '">close</i>' +
										'</div>'
									);
									$('#donor-name').val('');
									$('#donor-donated-amount').val('');
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons red-text">clear</i> Spende konnte nicht hinzugefügt werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Nein',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			}
		});
	});

	$(document).on('click', '#donations .donation .delete', function(event) {
		event.preventDefault();

		var id = $(this).data('id');
		var chip = $(this).closest('.chip');

		$.confirm({
			theme: 'supervan',
			title: 'Spende entfernen?',
			content: 'Die Spende wirklich entfernen?',
			buttons: {
				confirm: {
					text: 'Ja',
					btnClass: 'btn green',
					action: function() {
						$.ajax({
							type: 'DELETE',
							url: document.baseURI + 'api/dashboard/donation/' + id,
							data: null,
							success: function(response) {
								if (response.status === 'success') {
									$(chip).fadeOut(300, function(chip) {
										$(chip).remove();
									});
									Materialize.toast('<i class="material-icons green-text">done</i> Die Spende wurde erfolgreich entfernt', 3000);
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons red-text">clear</i> Die Spende konnte nicht entfernt werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Nein',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			}
		});
	});

	/********************/
	// Donations END
	/********************/

	/***********************/
	// Best of Voting START
	/***********************/

	$('#best-of-voting #update-voting-start-date-button').on('click', function() {
		let votingStartDate = $(this).data('value');

		$('#start-date').pickadate('picker').set('select', votingStartDate, { format: 'yyyy-mm-dd' });
	});

	$('#best-of-voting #update-voting-end-date-button').on('click', function() {
		let votingEndDate = $(this).data('value');

		$('#end-date').pickadate('picker').set('select', votingEndDate, { format: 'yyyy-mm-dd' });
	});

	$('#best-of-voting #save-best-of-voting-config').on('click', function() {
		let votingStartDate = $('#start-date').pickadate('picker').get('select', 'yyyy-mm-dd');
		let votingEndDate = $('#end-date').pickadate('picker').get('select', 'yyyy-mm-dd');
		let votingPlaylistCode = $('#playlist-code').val();

		let votingConfigParameters = {
			start_date: votingStartDate,
			end_date: votingEndDate,
			playlist_code: votingPlaylistCode
		};

		$.post('api/dashboard/best-of-voting/config', votingConfigParameters)
			.done(function(response) {
				if (response.status === 'success') {
					Materialize.toast('<i class="material-icons green-text">done</i> ' + response.message, 2000, '', function() {
						window.location.reload();
					});
				} else {
					Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
				}
			})
			.fail(function() {
				Materialize.toast('<i class="material-icons red-text">clear</i> Fehler beim speichern', 3000);
			});
	});

	// TODO: Delete Best-of Vote => (Button Class) .delete-best-of-vote
	$('#best-of-voting-votes .delete-best-of-vote').on('click', function(event) {
		event.preventDefault();

		let uid = $(this).data('uid');
		let row = $(this).closest('tr');

		$.confirm({
			theme: 'supervan',
			title: 'Best-of Vote entfernen?',
			content: 'Den Vote mit der ID "' + uid + '" wirklich entfernen?',
			buttons: {
				confirm: {
					text: 'Ja',
					btnClass: 'btn green',
					action: function() {
						$.ajax({
							type: 'DELETE',
							url: document.baseURI + 'api/dashboard/best-of-voting/vote/' + uid,
							data: null,
							success: function(response) {
								if (response.status === 'success') {
									$(row).fadeOut(300, function() {
										$(row).remove();

										let rowCount = $('#best-of-voting-votes table#votes tbody tr').length;
										$('#best-of-voting-votes .card-title span.count').text(rowCount);
									});
									Materialize.toast('<i class="material-icons green-text">done</i> Best-of Vote wurde entfernt', 3000);
								} else {
									Materialize.toast('<i class="material-icons red-text">clear</i> ' + response.message, 3000);
								}
							},
							fail: function(error) {
								console.log(error);
								Materialize.toast('<i class="material-icons red-text">clear</i> Best-of Vote konnte nicht entfernt werden', 3000);
							}
						});
					}
				},
				cancel: {
					text: 'Nein',
					btnClass: 'btn red',
					action: function() {
						return true;
					}
				}
			}
		});
	});

	/***********************/
	// Best of Voting END
	/***********************/
});
