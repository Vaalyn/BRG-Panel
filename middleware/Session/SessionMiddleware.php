<?php

namespace Middleware\Session;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Service\Session\Session;

class SessionMiddleware {
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
		$this->container['session'] = new Session($this->container->config['session']);
		$this->container['session']->start();

		$this->container['flash'] = new \Slim\Flash\Messages();

		return $next($request, $response);
	}
}
