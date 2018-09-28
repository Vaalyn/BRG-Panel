<?php

declare(strict_types = 1);

namespace BRG\Panel\Middleware\Authorization;

use BRG\Panel\Service\Authentication\AuthenticationInterface;
use BRG\Panel\Service\Authorization\AuthorizationInterface;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Interfaces\RouterInterface;

class AuthorizationMiddleware {
	/**
	 * @var AuthenticationInterface
	 */
	protected $authentication;

	/**
	 * @var RouterInterface
	 */
	protected $router;

	/**
	 * @var AuthorizationInterface
	 */
	protected $authorization;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->authentication = $container->authentication;
        $this->authorization  = $container->authorization;
		$this->router         = $container->router;
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

		if (!$this->authorization->needsAuthorizationForRoute($currentRouteName)) {
			return $next($request, $response);
		}

		$user = $this->authentication->user();

		if (!$this->authorization->hasAuthorizationForRoute($user, $currentRouteName, $request)) {
			return $response->withStatus(400)
				->withHeader('Content-Type', 'application/json')
				->write(json_encode(array(
					'status' => 'error',
					'message' => 'the requested resource is not available for you'
				)));
		}

		return $next($request, $response);
	}
}
