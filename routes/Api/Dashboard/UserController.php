<?php

namespace Routes\Api\Dashboard;

use Exception\InfoException;
use Dto\ApiResponse\JsonApiResponseDto;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController {
	/**
	 * @var \Psr\Container\ContainerInterface
	 */
	protected $container;

	/**
	 * @param \Psr\Container\ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function updateEmailAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$email = $request->getParsedBody()['email'] ?? null;

		if (!$this->container->validator->email()->validate($email)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Keine gültige E-Mail Adresse');

			return $response->write(json_encode($apiResponse));
		}

		$user        = $this->container->auth->user();
		$user->email = $email;
		$user->save();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success');

		return $response->write(json_encode($apiResponse));
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function updatePasswordAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$passwordNew = $request->getParsedBody()['passwordNew'] ?? null;
		$passwordOld = $request->getParsedBody()['passwordOld'] ?? null;

		try {
			if (!$this->validator->stringType()->length(8, null)->validate($passwordNew)) {
				throw new InfoException('Das Passwort muss mindestens 8 Zeichen lang sein');
			}

			$user = $this->container->auth->user();

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
