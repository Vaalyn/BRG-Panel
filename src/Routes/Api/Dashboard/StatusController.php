<?php

namespace BRG\Panel\Routes\Api\Dashboard;

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
	public function changeRequestSystemStatusActiveAction(Request $request, Response $response, array $args): Response {
		$active = (bool) $args['active'];

		$status = Status::find(1);
		$status->active = $active;
		$status->save();

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

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function setRequestSystemStatusRequestLimitAction(Request $request, Response $response, array $args): Response {
		$limit = (int) $args['limit'];

		$status = Status::find(1);
		$status->limit = $limit;
		$status->save();

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

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function changeMessageSystemStatusActiveAction(Request $request, Response $response, array $args): Response {
		$active = (bool) $args['active'];

		$status = Status::find(2);
		$status->active = $active;
		$status->save();

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

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function changeAutoDjRequestSystemStatusActiveAction(Request $request, Response $response, array $args): Response {
		$active = (bool) $args['active'];

		$status = Status::find(3);
		$status->active = $active;
		$status->save();

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

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function setSystemStatusRulesAction(Request $request, Response $response, array $args): Response {
		$statusId = (int) $args['statusId'];
		$rules    = $request->getParsedBody()['rules'] ?? '';

		if ($statusId !== 1 && $statusId !== 2) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Die Regeln dürfen für dieses System nicht geändert werden');

			return $response->withJson($apiResponse);
		}

		$status = Status::find($statusId);
		$status->rules = $rules;
		$status->save();

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
