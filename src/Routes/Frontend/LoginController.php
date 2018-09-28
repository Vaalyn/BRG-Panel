<?php

namespace BRG\Panel\Routes\Frontend;

use BRG\Panel\Service\Authentication\AuthenticationInterface;
use Psr\Container\ContainerInterface;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\PhpRenderer;

class LoginController {
	/**
	 * @var AuthenticationInterface
	 */
	protected $authentication;

	/**
	 * @var Messages
	 */
	protected $flashMessages;

	/**
	 * @var PhpRenderer
	 */
	protected $renderer;

	/**
	 * @var Router
	 */
	protected $router;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->authentication = $container->authentication;
		$this->flashMessages  = $container->flashMessages;
		$this->renderer       = $container->renderer;
		$this->router         = $container->router;
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function getLoginAction(Request $request, Response $response, array $args): Response {
		if ($this->authentication->check()) {
			if (count($request->getHeader('HTTP_REFERER'))) {
				return $response->withRedirect($request->getHeader('HTTP_REFERER')[0]);
			}

			return $response->withRedirect($this->router->pathFor('dashboard'));
		}

		return $this->renderer->render($response, '/login/login.php', [
			'authentication' => $this->authentication,
			'flashMessages' => $this->flashMessages->getMessages(),
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

		if (!$this->authentication->attempt($username, $password, $rememberMe)) {
			$this->flashMessages->addMessage('Login error', 'Username or password incorrect');
			return $response->withRedirect($this->router->pathFor('login'));
		}

		if ($referer !== null && substr_compare($referer, 'login', -5) !== 0) {
			return $response->withRedirect($referer);
		}

		return $response->withRedirect($this->router->pathFor('dashboard'));
	}
}
