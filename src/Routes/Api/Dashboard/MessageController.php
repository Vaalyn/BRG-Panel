<?php

namespace BRG\Panel\Routes\Api\Dashboard;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Model\Message;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class MessageController {
	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function deleteMessageAction(Request $request, Response $response, array $args): Response {
		$id = $args['id'];

		$message = Message::find($id);

		if (!isset($message)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Message not found');

			return $response->withJson($apiResponse);
		}

		$message->delete();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success');

		return $response->withJson($apiResponse);
	}
}
