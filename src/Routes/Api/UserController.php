<?php

namespace BRG\Panel\Routes\Api;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Exception\InfoException;
use BRG\Panel\Exception\MailNotSendException;
use BRG\Panel\Model\Manager\UserModelManager;
use BRG\Panel\Model\RecoveryCode;
use BRG\Panel\Model\User;
use BRG\Panel\Service\Mailer\MailerInterface;
use Carbon\Carbon;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\PhpRenderer;

class UserController {
	/**
	 * @var MailerInterface
	 */
	protected $mailer;

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
		$this->mailer   = $container->mailer;
		$this->renderer = $container->renderer;
		$this->router   = $container->router;
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function forgotPasswordAction(Request $request, Response $response, array $args): Response {
		$username = $request->getParsedBody()['username'] ?? '';
		$email    = $request->getParsedBody()['email'] ?? '';

		try {
			$user = User::where([
				['username', '=', $username],
				['email', '=', $email]
			])->first();

			if (!isset($user)) {
				throw new InfoException('Kein Benutzer mit diesem Usernamen für die E-Mail Addresse gefunden');
			}

			$code = Uuid::uuid4()->toString();

			$recoveryCode          = new RecoveryCode();
			$recoveryCode->user_id = $user->user_id;
			$recoveryCode->code    = password_hash($code, PASSWORD_DEFAULT);
			$recoveryCode->save();

			if ($recoveryCode->recovery_code_id === null) {
				throw new InfoException('Passwort Reset Code konnte nicht generiert werden');
			}

			$passwordResetUrl = sprintf(
				'%s://%s%s%s',
				$request->getUri()->getScheme(),
				$request->getUri()->getHost(),
				$this->router->pathFor('password-reset', ['code' => null]),
				$code
			);

			$passwordResetEmailMessage = $this->renderer->fetch(
				'/mailer/user/reset-password/reset-password.php',
				[
					'passwordResetUrl' => $passwordResetUrl
				]
			);

			try {
				$this->mailer->sendMail(
					'BRG-Panel Passwort vergessen',
					$email,
					$user->username,
					$passwordResetEmailMessage
				);
			} catch (MailNotSendException $exception) {
				$recoveryCode->delete();
				throw new InfoException('E-Mail konnte nicht gesendet werden');
			}

			$apiResponse = (new JsonApiResponseDto())
				->setStatus('success')
				->setMessage('E-Mail zum Passwort zurücksetzen versendet');

			return $response->withJson($apiResponse);
		}
		catch (InfoException $exception) {
			return $response->withJson([
				'status' => 'error',
				'errors' => $exception->getMessage()
			]);
		}
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function resetPasswordAction(Request $request, Response $response, array $args): Response {
		$code     = $request->getParsedBody()['code'] ?? '';
		$password = $request->getParsedBody()['password'] ?? '';

		try {
			$userModelManager = new UserModelManager();
			$userModelManager->validatePassword($password);

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
				throw new InfoException('Ungültiger code');
			}

			$recoveryCode->user->password = password_hash($password, PASSWORD_DEFAULT);
			$recoveryCode->user->save();

			$recoveryCode->delete();

			$apiResponse = (new JsonApiResponseDto())
				->setStatus('success')
				->setMessage('Passwort wurde geändert');

			return $response->withJson($apiResponse);
		}
		catch (InfoException $exception) {
			return $response->withJson([
				'status' => 'error',
				'errors' => $exception->getMessage()
			]);
		}
	}
}
