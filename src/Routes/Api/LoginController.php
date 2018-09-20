<?php

namespace BRG\Panel\Routes\Api;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class LoginController {
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
	public function loginAction(Request $request, Response $response, array $args): Response {
		$username = $request->getParsedBody()['username'] ?? null;
		$password = $request->getParsedBody()['password'] ?? null;
		$rememberMe = true;

		if (!$this->container->auth->attempt($username, $password, $rememberMe)) {
			return $response->write(json_encode(array(
				'status' => 'error',
				'errors' => $exception->getMessage()
			)));
		}

		return $response->write(json_encode(array(
			'status' => 'success'
		)));
	}
}
