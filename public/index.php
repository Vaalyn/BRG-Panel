<?php

require '../vendor/autoload.php';

use BRG\Panel\Middleware\Authentication\AuthenticationMiddleware;
use BRG\Panel\Middleware\Authorization\AuthorizationMiddleware;
use BRG\Panel\Middleware\Cors\CorsMiddleware;
use BRG\Panel\Middleware\Menu\MenuMiddleware;
use BRG\Panel\Service\Authentication\Authentication;
use BRG\Panel\Service\Authorization\Authorization;
use BRG\Panel\Service\CentovaCast\CentovaCastApiClient;
use BRG\Panel\Service\ErrorHandler\ErrorHandler;
use BRG\Panel\Service\Factory\Eloquent\EloquentFactory;
use BRG\Panel\Service\Factory\Flysystem\FlysystemFactory;
use BRG\Panel\Service\Google\Calendar\GoogleCalendarApiClient;
use BRG\Panel\Service\IceCast\IceCastDataClient;
use BRG\Panel\Service\Mailer\Mailer;
use BRG\Panel\Service\MenuBuilder\MenuBuilder;
use BRG\Panel\Service\Session\Session;
use Respect\Validation\Validator;
use Slim\Flash\Messages;
use Slim\Views\PhpRenderer;

$app = new \Slim\App(require_once __DIR__ . '/../config/config.php');

$container                            = $app->getContainer();
$container['authorization']           = new Authorization($container);
$container['session']                 = (new Session($container->config['session']))->start();
$container['authentication']          = new Authentication($container);
$container['centovaCastApiClient']    = new CentovaCastApiClient($container->config['centova']['api']);
$container['database']                = EloquentFactory::createMultiple($container->config['database']);
$container['errorHandler']            = new ErrorHandler();
$container['files']                   = FlysystemFactory::create($container->config['flysystem']['files']);
$container['flashMessages']           = new Messages();
$container['googleCalendarApiClient'] = new GoogleCalendarApiClient($container->config['google']['calendar']);
$container['iceCastDataClient']       = new IceCastDataClient($container->config['icecast']);
$container['mailer']                  = new Mailer($container->config['mailer']);
$container['menuBuilder']             = new MenuBuilder($container->router, $container->authentication, $container->authorization);
$container['phpErrorHandler']         = new ErrorHandler();
$container['renderer']                = new PhpRenderer('../template');

$container['validator'] = function() {
	return new Validator();
};

$app->add(new MenuMiddleware($container));
$app->add(new AuthorizationMiddleware($container));
$app->add(new AuthenticationMiddleware($container));
$app->add(new CorsMiddleware($container));
$app->add(new RKA\Middleware\IpAddress(false, []));

require_once '../config/routes.php';

$app->run();
