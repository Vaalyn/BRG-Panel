<?php

declare(strict_types = 1);

namespace BRG\Panel\Middleware\Authentication;

use BRG\Panel\Service\Authentication\AuthenticationInterface;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Interfaces\RouterInterface;

class AuthenticationMiddleware {
	/**
	 * @var AuthenticationInterface
	 */
	protected $authentication;

	/**
	 * @var RouterInterface
	 */
	protected $router;

	/**
	 * @var string[]
	 */
	protected $routesWithAuthentication;

	/**
	 * @var string[]
	 */
	protected $localRoutes;

	/**
	 * @var string
	 */
	protected $hostIp;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->authentication           = $container->authentication;
		$this->router                   = $container->router;
        $this->routesWithAuthentication = $container->config['authentication']['routes'];
		$this->localRoutes              = $container->config['authentication']['local'];
		$this->hostIp                   = $container->config['authentication']['host']['ip'];
    }

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param callable $next
	 *
	 * @return Response
	 */
	public function __invoke(Request $request, Response $response, callable $next): Response {
		$currentRoute = $request->getAttribute('route');

		if ($currentRoute === null) {
			return $next($request, $response);
		}

		$currentRouteName = $currentRoute->getName();

		if ($this->routeIsHostOnly($currentRouteName) && !$this->isHostIp($request->getAttribute('ip_address'))) {
			return $response->withStatus(400)
				->withHeader('Content-Type', 'application/json')
				->write(json_encode(array(
					'status' => 'error',
					'message' => 'the requested resource is not available for you'
				)));
		}

		$routeNeedsAuthentication = $this->authentication->routeNeedsAuthentication(
			$currentRouteName
		);

		if ($routeNeedsAuthentication) {
			if (!$this->authentication->check()) {
				return $response->withRedirect($this->router->pathFor('login'));
			}
		}

		return $next($request, $response);
	}

	/**
	 * @param string $routeName
	 *
	 * @return bool
	 */
	protected function routeIsHostOnly(string $routeName): bool {
		return in_array($routeName, $this->localRoutes);
	}

	/**
	 * @param string $ipAddress
	 *
	 * @return bool
	 */
	protected function isHostIp(string $ipAddress): bool {
		return $this->hostIp === $ipAddress;
	}
}
