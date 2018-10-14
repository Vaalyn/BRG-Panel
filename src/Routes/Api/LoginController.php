<?php

namespace BRG\Panel\Routes\Api;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Vaalyn\AuthenticationService\AuthenticationInterface;

class LoginController {
	/**
	 * @var AuthenticationInterface
	 */
	protected $authentication;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->authentication = $container->authentication;
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

		if (!$this->authentication->attempt($username, $password, $rememberMe)) {
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
