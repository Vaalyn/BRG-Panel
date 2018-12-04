<?php

use BRG\Panel\Routes\Api;
use BRG\Panel\Routes\Cron;
use BRG\Panel\Routes\Frontend;

$app->group('/api', function() {
	$this->post('/community/user/coin/add', Api\CommunityUserController::class . ':addCoinsAction')->setName('api.community.user.coin.add');
	$this->post('/community/user/coin/remove', Api\CommunityUserController::class . ':removeCoinsAction')->setName('api.community.user.coin.remove');
	$this->get('/community/user/coin/{discordUserId}', Api\CommunityUserController::class . ':getCoinsAction')->setName('api.community.user.coin.get');

	$this->get('/donation/currently-needed-amount', Api\DonationController::class . ':getCurrentlyNeededAmountAction')->setName('api.donation.currently-needed-amount');
	$this->get('/donation/list', Api\DonationController::class . ':getDonationsAction')->setName('api.donation.list');

	$this->get('/history[/{page}]', Api\HistoryController::class . ':getHistoryAction')->setName('api.history.list');

	$this->post('/message', Api\MessageController::class . ':createMessageAction')->setName('api.message.add');

	$this->post('/request', Api\RequestController::class . ':createRequestAction')->setName('api.request.add');
	$this->post('/request/autodj', Api\RequestController::class . ':createAutoDjRequestAction')->setName('api.request.autodj.add');

	$this->get('/status/{id}', Api\StatusController::class . ':getStatusAction')->setName('api.status');

	$this->get('/streaminfo/{mountpoint}', Api\StreaminfoController::class)->setName('api.streaminfo');

	$this->get('/track/list', Api\TrackController::class . ':getTracksAction')->setName('api.track.list');
	$this->get('/track/list/autodj', Api\TrackController::class . ':getAutoDjTracksAction')->setName('api.track.list.autodj');
	$this->get('/track/autodj/{id}', Api\TrackController::class . ':getAutoDjTrackAction')->setName('api.track.autodj');
	$this->get('/track/{id}', Api\TrackController::class . ':getTrackAction')->setName('api.track');

	$this->post('/user/password/forgot', Api\UserController::class . ':forgotPasswordAction')->setName('api.user.password.forgot');
	$this->post('/user/password/reset', Api\UserController::class . ':resetPasswordAction')->setName('api.user.password.reset');

	$this->get('/vote/check/{voterId}/{mountpoint}', Api\VoteController::class . ':getVotedForTrackOnMountpointAction')->setName('api.vote.check');
	$this->post('/vote/{mountpoint}', Api\VoteController::class . ':voteAction')->setName('api.vote.vote');

	$this->post('/voter', Api\VoteController::class . ':createVoterAction')->setName('api.voter.add');
});

$app->group('/api/dashboard', function() {
	$this->post('/user/email', Api\Dashboard\UserController::class . ':updateEmailAction')->setName('api.dashboard.user.email');
	$this->post('/user/password', Api\Dashboard\UserController::class . ':updatePasswordAction')->setName('api.dashboard.user.password');

	$this->post('/donation', Api\Dashboard\DonationController::class . ':createDonationAction')->setName('api.dashboard.donation.add');
	$this->delete('/donation/{id}', Api\Dashboard\DonationController::class . ':deleteDonationAction')->setName('api.dashboard.donation.delete');

	$this->post('/icecast/metadata/{mountpoint}', Api\Dashboard\IceCastController::class . ':setMetadataToMountpointAction')->setName('api.dashboard.icecast.set.metadata');

	$this->post('/discord/bot/lucylight/restart', Api\Dashboard\DiscordController::class . ':restartLucyLightAction')->setName('api.dashboard.lucylight.restart');

	$this->get('/history/export/csv', Api\Dashboard\HistoryController::class . ':downloadHistoryCsvAction')->setName('api.dashboard.history.export.csv');

	$this->delete('/message/{id}', Api\Dashboard\MessageController::class . ':deleteMessageAction')->setName('api.dashboard.message.delete');

	$this->post('/request/{id}/played', Api\Dashboard\RequestController::class . ':setRequestPlayedAction')->setName('api.dashboard.request.played');
	$this->post('/request/{id}/skipped', Api\Dashboard\RequestController::class . ':setRequestSkippedAction')->setName('api.dashboard.request.skipped');

	$this->post('/setting/currently-needed-donation-amount', Api\Dashboard\DonationController::class . ':updateCurrentlyNeededDonationAmountAction')->setName('api.dashboard.setting.currently-needed-donation-amount');

	$this->post('/system/autodj/request/status/{active}', Api\Dashboard\StatusController::class . ':changeAutoDjRequestSystemStatusActiveAction')->setName('api.dashboard.system.autodj.request.active');

	$this->post('/system/message/status/{active}', Api\Dashboard\StatusController::class . ':changeMessageSystemStatusActiveAction')->setName('api.dashboard.system.message.active');

	$this->post('/system/request/status/{active}', Api\Dashboard\StatusController::class . ':changeRequestSystemStatusActiveAction')->setName('api.dashboard.system.request.active');
	$this->post('/system/request/limit/{limit}', Api\Dashboard\StatusController::class . ':setRequestSystemStatusRequestLimitAction')->setName('api.dashboard.system.request.limit');

	$this->post('/system/{statusId}/rules', Api\Dashboard\StatusController::class . ':setSystemStatusRulesAction')->setName('api.dashboard.system.rules');

	$this->post('/track/{id}/votes/ignore', Api\Dashboard\TrackController::class . ':setIgnoreVotesForTrackAction')->setName('api.dashboard.track.votes.ignore');
});

$app->group('/cron', function() {
	$this->get('', Cron\CronController::class)->setName('cron');
	$this->get('/current/event/update', Cron\CurrentEventController::class)->setName('cron.current.event.update');
	$this->get('/history/update', Cron\HistoryController::class)->setName('cron.history.update');
	$this->get('/streaminfo/update/{stationId}', Cron\StreaminfoController::class)->setName('cron.streaminfo.update');
	$this->get('/track/autodj/update', Cron\TrackController::class)->setName('cron.track.autodj.update');
});

$app->group('/dashboard', function() {
	$this->get('', Frontend\Dashboard\DashboardController::class)->setName('dashboard');
	$this->get('/account', Frontend\Dashboard\AccountController::class)->setName('dashboard.account');
	$this->get('/donation', Frontend\Dashboard\DonationController::class)->setName('dashboard.donation');
	$this->get('/history[/page/{page}]', Frontend\Dashboard\HistoryController::class)->setName('dashboard.history');
	$this->get('/message[/page/{page}]', Frontend\Dashboard\MessageController::class)->setName('dashboard.message');
	$this->get('/request[/page/{page}]', Frontend\Dashboard\RequestController::class)->setName('dashboard.request');
	$this->get('/statistic/request[/page/{page}]', Frontend\Dashboard\StatisticController::class . ':getRequestStatisticAction')->setName('dashboard.statistic.request');
	$this->get('/statistic/request/artist[/page/{page}]', Frontend\Dashboard\StatisticController::class . ':getRequestStatisticArtistAction')->setName('dashboard.statistic.request.artist');
	$this->get('/statistic/request/title[/page/{page}]', Frontend\Dashboard\StatisticController::class . ':getRequestStatisticTitleAction')->setName('dashboard.statistic.request.title');
	$this->get('/statistic/request/user[/page/{page}]', Frontend\Dashboard\StatisticController::class . ':getRequestStatisticUserAction')->setName('dashboard.statistic.request.user');
	$this->get('/vote[/page/{page}]', Frontend\Dashboard\VoteController::class)->setName('dashboard.votes');
});

$app->get('/documentation', Frontend\DocumentationController::class)->setName('documentation');

$app->get('/history', Frontend\HistoryController::class)->setName('history');

$app->get('/login', Frontend\LoginController::class . ':getLoginAction')->setName('login');
$app->post('/login', Frontend\LoginController::class . ':loginAction')->setName('post.login');

$app->get('/logout', Frontend\LogoutController::class)->setName('logout');

$app->get('/password-reset/{code}', Frontend\PasswordResetController::class)->setName('password-reset');

$app->group('/player', function() {
	$this->get('', Frontend\Player\PlayerController::class)->setName('player');
	$this->get('/embed', Frontend\Player\PlayerEmbedController::class)->setName('player.embed');
	$this->get('/embed/external', Frontend\Player\PlayerEmbedExternalController::class)->setName('player.embed.external');

	$this->group('/modal', function() {
		$this->get('/action-menu', Frontend\Player\Modal\PlayerActionMenuModalController::class)->setName('player.modal.action-menu');
		$this->get('/history', Frontend\Player\Modal\PlayerHistoryModalController::class)->setName('player.modal.history');
		$this->get('/system', Frontend\Player\Modal\PlayerSystemModalController::class)->setName('player.modal.system');
	});
});

$app->get('/system', Frontend\SystemController::class)->setName('system');
