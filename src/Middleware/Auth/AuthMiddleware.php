<?php

namespace BRG\Panel\Middleware\Auth;

use BRG\Panel\Service\Auth\AuthInterface;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;

class AuthMiddleware {
	/**
	 * @var AuthInterface
	 */
	protected $authentication;

	/**
	 * @var array
	 */
	protected $config;

	/**
	 * @var Router
	 */
	protected $router;

	/**
	 * @param ContainerInterface $container
	 *
	 * @return void
	 */
	public function __construct(ContainerInterface $container) {
        $this->authentication = $container->authentication;
		$this->config         = $container->config;
		$this->router         = $container->router;
    }

	/**
	 * @param Request  $request
	 * @param Response $response
	 * @param callable $next
	 *
	 * @return Response
	 */
	public function __invoke(Request $request, Response $response, callable $next): Response {
		$currentRoute = $request->getAttribute('route');

		if ($currentRoute !== null) {
			$currentRouteName = $currentRoute->getName();
			$protectedRoutes  = $this->config['auth']['routes'];
			$localRoutes      = $this->config['auth']['local'];
			$authorizedRoutes = $this->config['auth']['authorized'];

			if (!empty($currentRoute) && (in_array($currentRouteName, $protectedRoutes) || array_key_exists($currentRouteName, $protectedRoutes))) {
				if (!$this->authentication->check()) {
					return $response->withRedirect($this->router->pathFor('login'));
				}

				if (isset($protectedRoutes[$currentRouteName]) && in_array('admin', $protectedRoutes[$currentRouteName]) && !$this->authentication->isAdmin()) {
					return $response->withStatus(400)
								->withHeader('Content-Type', 'application/json')
								->write(json_encode(array(
									'status' => 'error',
									'message' => 'the requested resource is not available for you'
								)));
				}
			}

			if (!empty($currentRoute) && in_array($currentRouteName, $localRoutes)) {
				if ($request->getAttribute('ip_address') != $this->config['host']['ip']) {
					return $response->withStatus(400)
								->withHeader('Content-Type', 'application/json')
								->write(json_encode(array(
									'status' => 'error',
									'message' => 'the requested resource is not available for you'
								)));
				}
			}

			if (!empty($currentRoute) && in_array($currentRouteName, $authorizedRoutes)) {
				$authorizationToken = $request->getQueryParams()['authorizationToken'] ?? null;

				if ($authorizationToken === null || !in_array($authorizationToken, $authorizedRoutes[$currentRouteName])) {
					return $response->withStatus(400)
								->withHeader('Content-Type', 'application/json')
								->write(json_encode(array(
									'status' => 'error',
									'message' => 'the requested resource is not available for you'
								)));
				}
			}
		}

		return $next($request, $response);
	}
}
