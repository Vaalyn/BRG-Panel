<?php

namespace BRG\Panel\Routes\Api\Dashboard;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Model;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class RequestController {
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
	public function setRequestPlayedAction(Request $request, Response $response, array $args): Response {
		$id = $args['id'];

		$request = Model\Request::find($id);

		if (!isset($request)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Request not found');

			return $response->withJson($apiResponse);
		}

		$request->delete();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success');

		return $response->withJson($apiResponse);
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function setRequestSkippedAction(Request $request, Response $response, array $args): Response {
		$id = $args['id'];

		$request = Model\Request::find($id);

		if (!isset($request)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Request not found');

			return $response->withJson($apiResponse);
		}

		$request->is_skipped = true;
		$request->save();
		$request->delete();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success');

		return $response->withJson($apiResponse);
	}
}
