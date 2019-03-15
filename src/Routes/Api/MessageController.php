<?php

namespace BRG\Panel\Routes\Api;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Exception\InfoException;
use BRG\Panel\Model\Message;
use BRG\Panel\Model\Status;
use Psr\Container\ContainerInterface;
use Respect\Validation\Validator;
use Slim\Http\Request;
use Slim\Http\Response;

class MessageController {
	/**
	 * @var Validator
	 */
	protected $stringNotEmptyValidator;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->stringNotEmptyValidator = $container->validator::stringType()->length(1, null);
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function createMessageAction(Request $request, Response $response, array $args): Response {
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

			return $response->withJson($apiResponse);
		}
		catch (InfoException $exception) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage($exception->getMessage());

			return $response->withJson($apiResponse);
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
