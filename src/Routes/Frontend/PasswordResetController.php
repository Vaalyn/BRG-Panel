<?php

namespace BRG\Panel\Routes\Frontend;

use BRG\Panel\Model\RecoveryCode;
use Carbon\Carbon;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class PasswordResetController {
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
			return $response->withRedirect($this->container->router->pathFor('login'));
		}

		return $this->container->renderer->render($response, '/password-reset/password-reset.php', [
			'auth' => $this->container->auth,
			'code' => $code,
			'flashMessages' => $this->container->flash->getMessages(),
			'request' => $request
		]);
	}
}
