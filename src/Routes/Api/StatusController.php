<?php

namespace BRG\Panel\Routes\Api;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Dto\ApiResponse\StatusDto;
use BRG\Panel\Model\Status;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class StatusController {
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
	public function getStatusAction(Request $request, Response $response, array $args): Response {
		$id = $args['id'];

		$status = Status::find($id);

		if (!isset($status)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Invalid status id');

			return $response->withJson($apiResponse);
		}

		$statusDto = new StatusDto(
			$status->status_id,
			$status->active,
			$status->limit,
			$status->description
		);

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success')
			->setResult($statusDto);

		return $response->withJson($apiResponse);
	}
}
