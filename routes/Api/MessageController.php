<?php

namespace Routes\Api;

use Dto\ApiResponse\JsonApiResponseDto;
use Exception\InfoException;
use Model\Message;
use Model\Status;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class MessageController {
	/**
	 * @var \Psr\Container\ContainerInterface
	 */
	protected $container;

	/**
	 * @var \Respect\Validation\Validator
	 */
	protected $stringNotEmptyValidator;

	/**
	 * @param \Psr\Container\ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->container = $container;

		$this->stringNotEmptyValidator = $this->container->validator::stringType()->length(1, null);
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function createMessageAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$nickname    = trim($request->getParsedBody()['nickname']) ?? '';
		$messageText = trim($request->getParsedBody()['message']) ?? '';

		try {
			if (!$this->isMessageSystemActive()) {
				throw new InfoException('Das Nachrichtensystem ist nicht aktiv');
			}

			$this->validateParameters($nickname, $messageText);

			$message           = new Message();
			$message->nickname = $nickname;
			$message->message  = $messageText;
			$message->save();

			$apiResponse = (new JsonApiResponseDto())
				->setStatus('success')
				->setMessage('Nachricht eingereicht');

			return $response->write(json_encode($apiResponse));
		}
		catch (InfoException $exception) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage($exception->getMessage());

			return $response->write(json_encode($apiResponse));
		}
	}

	/**
	 * @return bool
	 */
	protected function isMessageSystemActive(): bool {
		$status = Status::find(2);

		return $status->active;
	}

	/**
	 * @param string $nickname
	 * @param string $message
	 *
	 * @return void
	 */
	protected function validateParameters(string $nickname, string $message): void {
		if (!$this->stringNotEmptyValidator->validate($nickname)) {
			throw new InfoException('Es muss ein Nickname eingegeben werden');
		}

		if (!$this->stringNotEmptyValidator->validate($message)) {
			throw new InfoException('Es muss eine Nachricht eingegeben werden');
		}
	}
}
