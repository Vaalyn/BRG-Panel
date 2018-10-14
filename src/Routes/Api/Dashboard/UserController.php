<?php

namespace BRG\Panel\Routes\Api\Dashboard;

use BRG\Panel\Exception\InfoException;
use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Model\User;
use Psr\Container\ContainerInterface;
use Respect\Validation\Validator;
use Slim\Http\Request;
use Slim\Http\Response;
use Vaalyn\AuthenticationService\AuthenticationInterface;

class UserController {
	/**
	 * @var AuthenticationInterface
	 */
	protected $authentication;

	/**
	 * @var Validator
	 */
	protected $validator;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->authentication = $container->authentication;
		$this->validator      = $container->validator;
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function updateEmailAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$email = $request->getParsedBody()['email'] ?? null;

		if (!$this->validator->email()->validate($email)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Keine gültige E-Mail Adresse');

			return $response->write(json_encode($apiResponse));
		}

		$user        = User::find($this->authentication->user()->getUserId());
		$user->email = $email;
		$user->save();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success');

		return $response->write(json_encode($apiResponse));
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function updatePasswordAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$passwordNew = $request->getParsedBody()['passwordNew'] ?? null;
		$passwordOld = $request->getParsedBody()['passwordOld'] ?? null;

		try {
			if (!$this->validator->stringType()->length(8, null)->validate($passwordNew)) {
				throw new InfoException('Das Passwort muss mindestens 8 Zeichen lang sein');
			}

			$user = User::find($this->authentication->user()->getUserId());

			if (!password_verify($passwordOld, $user->password_new)) {
				throw new InfoException('Das alte Passwort ist nicht korrekt');
			}

			$user->password_new = password_hash($passwordNew, PASSWORD_DEFAULT);
			$user->save();

			$apiResponse = (new JsonApiResponseDto())
				->setStatus('success')
				->setMessage('Dein Passwort wurde geändert');

			return $response->write(json_encode($apiResponse));
		}
		catch (InfoException $exception) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage($exception->getMessage());

			return $response->write(json_encode($apiResponse));
		}
	}
}
