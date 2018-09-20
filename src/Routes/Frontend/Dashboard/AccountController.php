<?php

namespace BRG\Panel\Routes\Frontend\Dashboard;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class AccountController {
	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function __invoke(Request $request, Response $response, array $args): Response {
		return $this->container->renderer->render($response, '/dashboard/account/account.php', [
			'auth' => $this->container->auth,
			'request' => $request,
			'user' => $this->container->auth->user()
		]);
	}
}
