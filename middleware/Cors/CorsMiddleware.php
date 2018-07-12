<?php

namespace Middleware\Cors;

use Psr\Container\ContainerInterface;
use Respect\Validation\Validator;
use Slim\Http\Request;
use Slim\Http\Response;

class CorsMiddleware {
	/**
	 * @var \Psr\Container\ContainerInterface
	 */
	private $container;

	/**
	 * @param \Psr\Container\ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

	/**
	 * @param \Slim\Http\Request  $request
	 * @param \Slim\Http\Response $response
	 * @param callable $next
	 *
	 * @return Response
	 */
	public function __invoke(Request $request, Response $response, callable $next): Response {
		$currentRoute = $request->getAttribute('route');

		if ($currentRoute === null) {
			return $next($request, $response);
		}

		$corsRoutes = $this->container->config['cors'];

		$currentRouteName = $currentRoute->getName();

		if (array_key_exists($currentRouteName, $corsRoutes)) {
			$currentRouteOriginConfig = $corsRoutes[$currentRouteName];

			if (is_string($currentRouteOriginConfig)) {
				$response = $this->setCorsHeaderForOrigin($response, $currentRouteOriginConfig);
			}
			else if (is_array($currentRouteOriginConfig)) {
				$response = $this->setCorsHeaderForOriginFromArray($response, $currentRouteOriginConfig);
			}
		}

		$request = $request->withAttribute(
			'origin',
			$_SERVER['HTTP_ORIGIN'] ?? $_SERVER["SERVER_NAME"]
		);

		return $next($request, $response);
	}

	/**
	 * @param \Slim\Http\Response $response
	 * @param string $origin
	 *
	 * @return \Slim\Http\Response
	 */
	protected function setCorsHeaderForOrigin(Response $response, string $origin): Response {
		return $response->withAddedHeader('Access-Control-Allow-Origin', $origin);
	}

	/**
	 * @param \Slim\Http\Response $response
	 * @param array $allowedOrigins
	 *
	 * @return \Slim\Http\Response
	 */
	protected function setCorsHeaderForOriginFromArray(Response $response, array $allowedOrigins): Response {
		$origin = $_SERVER['HTTP_ORIGIN'];

		if (!Validator::url($origin)) {
			return $response;
		}

		if (in_array($origin, $allowedOrigins)) {
			$response = $this->setCorsHeaderForOrigin($response, $origin);
		}

		return $response;
	}
}
