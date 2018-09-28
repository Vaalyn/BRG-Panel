<?php

namespace BRG\Panel\Routes\Frontend;

use BRG\Panel\Model\RecoveryCode;
use BRG\Panel\Service\Authentication\AuthenticationInterface;
use Carbon\Carbon;
use Psr\Container\ContainerInterface;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\PhpRenderer;

class PasswordResetController {
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
	public function __invoke(Request $request, Response $response, array $args): Response {
		$code = $args['code'];

		$codeValidFromDateTime = Carbon::now()->subHours(6);
		$validRecoveryCodes = RecoveryCode::whereDate(
			'created_at',
			'>=',
			$codeValidFromDateTime->toDateString()
		)->get();

		$validRecoveryCode = null;

		foreach ($validRecoveryCodes as $recoveryCode) {
			if (password_verify($code, $recoveryCode->code)) {
				$validRecoveryCode = $recoveryCode;
			}
		}

		if (!isset($validRecoveryCode)) {
			return $response->withRedirect($this->router->pathFor('login'));
		}

		return $this->renderer->render($response, '/password-reset/password-reset.php', [
			'authentication' => $this->authentication,
			'code' => $code,
			'flashMessages' => $this->flashMessages->getMessages(),
			'request' => $request
		]);
	}
}
