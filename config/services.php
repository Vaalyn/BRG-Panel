<?php

declare(strict_types=1);

use AzuraCast\Api\Client as AzuraCastApiClient;
use BRG\Panel\Service\ErrorHandler\ErrorHandler;
use BRG\Panel\Service\Factory\Eloquent\EloquentFactory;
use BRG\Panel\Service\Factory\Flysystem\FlysystemFactory;
use BRG\Panel\Service\Google\Calendar\GoogleCalendarApiClient;
use BRG\Panel\Service\IceCast\IceCastDataClient;
use BRG\Panel\Service\Mailer\Mailer;
use Respect\Validation\Validator;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;
use Vaalyn\AuthenticationService\Authentication;
use Vaalyn\AuthorizationService\Authorization;
use Vaalyn\MenuBuilderService\MenuBuilder;
use Vaalyn\SessionService\Session;

return [
	'session' => function ($container) {
		return (new Session($container->config['session']))->start();
	},

	'database' => function ($container) {
		return EloquentFactory::createMultiple($container->config['database']);
	},

	'authorization' => function ($container) {
		return new Authorization($container);
	},

	'authentication' => function ($container) {
		return new Authentication($container, $container->database);
	},

	'azuraCastApiClient' => function ($container) {
		return AzuraCastApiClient::create($container->config['azura']['host'], $container->config['azura']['api_key']);
	},

	'errorHandler' => function ($container) {
		return function (Request $request, Response $response, \Throwable $exception) use ($container) {
			return (new ErrorHandler($container))->createErrorResponse($response, $exception);
		};
	},

	'files' => function ($container) {
		return FlysystemFactory::create($container->config['flysystem']['files']);
	},

	'flashMessages' => function () {
		return new Messages();
	},

	'googleCalendarApiClient' => function ($container) {
		return new GoogleCalendarApiClient($container->config['google']['calendar']);
	},

	'iceCastDataClient' => function ($container) {
		return new IceCastDataClient($container->config['icecast']);
	},

	'mailer' => function ($container) {
		return new Mailer($container->config['mailer']);
	},

	'menuBuilder' => function ($container) {
		return new MenuBuilder($container->router, $container->authentication, $container->authorization);
	},

	'phpErrorHandler' => function ($container) {
		return function (Request $request, Response $response, \Throwable $exception) use ($container) {
			return (new ErrorHandler($container))->createErrorResponse($response, $exception);
		};
	},

	'renderer' => function () {
		return new PhpRenderer(__DIR__ . '/../template');
	},

	'validator' => function() {
		return new Validator();
	},
];
