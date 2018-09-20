<?php

require '../vendor/autoload.php';

use BRG\Panel\Middleware\Auth\AuthMiddleware;
use BRG\Panel\Middleware\Cors\CorsMiddleware;
use BRG\Panel\Middleware\Session\SessionMiddleware;
use BRG\Panel\Service\Auth\Auth;
use BRG\Panel\Service\CentovaCast\CentovaCastApiClient;
use BRG\Panel\Service\ErrorHandler\ErrorHandler;
use BRG\Panel\Service\Factory\Eloquent\EloquentFactory;
use BRG\Panel\Service\Factory\Flysystem\FlysystemFactory;
use BRG\Panel\Service\Google\Calendar\GoogleCalendarApiClient;
use BRG\Panel\Service\IceCast\IceCastDataClient;
use BRG\Panel\Service\Mailer\Mailer;
use Respect\Validation\Validator;
use Slim\Views\PhpRenderer;

$app = new \Slim\App(require_once __DIR__ . '/../config/config.php');

$container                            = $app->getContainer();
$container['auth']                    = new Auth($container);
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

$app->add(new AuthMiddleware($container));
$app->add(new CorsMiddleware($container));
$app->add(new SessionMiddleware($container));
$app->add(new RKA\Middleware\IpAddress(false, []));

require_once '../config/routes.php';

$app->run();
