<?php

namespace BRG\Panel\Routes\Frontend;

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
	public function getLoginAction(Request $request, Response $response, array $args): Response {
		if ($this->container->auth->check()) {
			if (count($request->getHeader('HTTP_REFERER'))) {
				return $response->withRedirect($request->getHeader('HTTP_REFERER')[0]);
			}

			return $response->withRedirect($this->container->router->pathFor('dashboard'));
		}

		return $this->container->renderer->render($response, '/login/login.php', [
			'auth' => $this->container->auth,
			'flashMessages' => $this->container->flash->getMessages(),
			'request' => $request
		]);
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
		$referer = $request->getParsedBody()['referer'] ?? null;
		$rememberMe = isset($request->getParsedBody()['remember_me']) ? true : false;

		if (!$this->container->auth->attempt($username, $password, $rememberMe)) {
			$this->container->flash->addMessage('Login error', 'Username or password incorrect');
			return $response->withRedirect($this->container->router->pathFor('login'));
		}

		if ($referer !== null && substr_compare($referer, 'login', -5) !== 0) {
			return $response->withRedirect($referer);
		}

		return $response->withRedirect($this->container->router->pathFor('dashboard'));
	}
}
