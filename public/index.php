<?php

require __DIR__ . '/../vendor/autoload.php';

use BRG\Panel\Middleware\Cors\CorsMiddleware;
use BRG\Panel\Middleware\PaginationLinkParameters\PaginationLinkParametersMiddleware;
use Slim\Http\Request;
use Slim\Http\Response;
use Vaalyn\AuthenticationService\Middleware\AuthenticationMiddleware;
use Vaalyn\AuthorizationService\Middleware\AuthorizationMiddleware;
use Vaalyn\MenuBuilderService\Middleware\MenuMiddleware;
use Vaalyn\PluginService\PluginLoader;

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

$services = require_once __DIR__ . '/../config/services.php';
foreach ($services as $serviceName => $service) {
	$container[$serviceName] = $service;
}

$pluginLoader->registerPluginServices($container);

$pluginLoader->registerPluginMiddlewares($app, $container);

$app->add(new MenuMiddleware($container));
$app->add(new PaginationLinkParametersMiddleware($container));
$app->add(new AuthorizationMiddleware($container));
$app->add(new AuthenticationMiddleware($container));
$app->add(new CorsMiddleware($container));
$app->add(new RKA\Middleware\IpAddress(true, []));

$app->add(function (Request $request, Response $response, callable $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
        // recursively remove slashes when its more than 1 slash
        while(substr($path, -1) == '/') {
            $path = substr($path, 0, -1);
        }

        // permanently redirect paths with a trailing slash
        // to their non-trailing counterpart
        $uri = $uri->withPath($path);

        if($request->getMethod() == 'GET') {
            return $response->withRedirect((string)$uri, 301);
        }
        else {
            return $next($request->withUri($uri), $response);
        }
    }

    return $next($request, $response);
});

require_once __DIR__ . '/../config/routes.php';

$pluginLoader->registerPluginRoutes($app, $container);

$app->run();
