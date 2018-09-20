<?php

namespace BRG\Panel\Middleware\Session;

use BRG\Panel\Service\Session\Session;
use Psr\Container\ContainerInterface;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;

class SessionMiddleware {
	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

	/**
	 * @param Request  $request
	 * @param Response $response
	 * @param callable $next
	 *
	 * @return Response
	 */
	public function __invoke(Request $request, Response $response, callable $next): Response {
		$this->container['session'] = new Session($this->container->config['session']);
		$this->container['session']->start();

		$this->container['flash'] = new Messages();

		return $next($request, $response);
	}
}
