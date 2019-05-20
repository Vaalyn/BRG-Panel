<?php

require '../vendor/autoload.php';

use AzuraCast\AzuraCastApiClient\AzuraCastApiClient;
use BRG\Panel\Middleware\Cors\CorsMiddleware;
use BRG\Panel\Middleware\PaginationLinkParameters\PaginationLinkParametersMiddleware;
use BRG\Panel\Service\ErrorHandler\ErrorHandler;
use BRG\Panel\Service\Factory\Eloquent\EloquentFactory;
use BRG\Panel\Service\Factory\Flysystem\FlysystemFactory;
use BRG\Panel\Service\Google\Calendar\GoogleCalendarApiClient;
use BRG\Panel\Service\IceCast\IceCastDataClient;
use BRG\Panel\Service\Mailer\Mailer;
use Respect\Validation\Validator;
use Slim\Flash\Messages;
use Slim\Views\PhpRenderer;
use Vaalyn\AuthenticationService\Authentication;
use Vaalyn\AuthenticationService\Middleware\AuthenticationMiddleware;
use Vaalyn\AuthorizationService\Authorization;
use Vaalyn\AuthorizationService\Middleware\AuthorizationMiddleware;
use Vaalyn\MenuBuilderService\MenuBuilder;
use Vaalyn\MenuBuilderService\Middleware\MenuMiddleware;
use Vaalyn\PluginService\PluginLoader;
use Vaalyn\SessionService\Session;

$app          = new \Slim\App(require_once __DIR__ . '/../config/config.php');
$container    = $app->getContainer();
$pluginLoader = new PluginLoader();

if (file_exists(__DIR__ . '/../config/plugins.php')) {
	$plugins = require_once __DIR__ . '/../config/plugins.php';

	foreach ($plugins as $plugin) {
		$pluginLoader->registerPlugin(new $plugin);
	}
}

$pluginLoader->loadPlugins($container);

$container['session']                 = (new Session($container->config['session']))->start();
$container['database']                = EloquentFactory::createMultiple($container->config['database']);
$container['authorization']           = new Authorization($container);
$container['authentication']          = new Authentication($container, $container->database);
$container['azuraCastApiClient']      = new AzuraCastApiClient($container->config['azura']['host'], $container->config['azura']['api_key']);
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

$pluginLoader->registerPluginServices($container);

$pluginLoader->registerPluginMiddlewares($app, $container);

$app->add(new MenuMiddleware($container));
$app->add(new PaginationLinkParametersMiddleware($container));
$app->add(new AuthorizationMiddleware($container));
$app->add(new AuthenticationMiddleware($container));
$app->add(new CorsMiddleware($container));
$app->add(new RKA\Middleware\IpAddress(false, []));

require_once '../config/routes.php';

$pluginLoader->registerPluginRoutes($app, $container);

$app->run();
