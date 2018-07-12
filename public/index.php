<?php

require '../vendor/autoload.php';

use Respect\Validation\Validator;
use Service\CentovaCast\CentovaCastApiClient;
use Service\ErrorHandler\ErrorHandler;
use Service\Factory\Eloquent\EloquentFactory;
use Service\Factory\Flysystem\FlysystemFactory;
use Service\Google\Calendar\GoogleCalendarApiClient;
use Service\IceCast\IceCastDataClient;
use Service\Mailer\Mailer;
use Slim\Views\PhpRenderer;

$app = new \Slim\App(require_once __DIR__ . '/../config/config.php');

$container                            = $app->getContainer();
$container['auth']                    = new \Service\Auth\Auth($container);
$container['centovaCastApiClient']    = new CentovaCastApiClient($container->config['centova']['api']);
$container['database']                = EloquentFactory::createMultiple($container->config['database']);
$container['errorHandler']            = new ErrorHandler();
$container['files']                   = FlysystemFactory::create($container->config['flysystem']['files']);
$container['googleCalendarApiClient'] = new GoogleCalendarApiClient($container->config['google']['calendar']);
$container['iceCastDataClient']       = new IceCastDataClient($container->config['icecast']);
$container['mailer']                  = new Mailer($container->config['mailer']);
$container['phpErrorHandler']         = new ErrorHandler();
$container['renderer']                = new PhpRenderer('../template');

$container['validator'] = function() {
	return new Validator();
};

$app->add(new Middleware\Auth\AuthMiddleware($container));
$app->add(new Middleware\Cors\CorsMiddleware($container));
$app->add(new Middleware\Session\SessionMiddleware($container));
$app->add(new RKA\Middleware\IpAddress(false, []));

require_once '../config/routes.php';

$app->run();
