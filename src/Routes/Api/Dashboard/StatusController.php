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
	public function changeRequestSystemStatusActiveAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

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

		return $response->write(json_encode($apiResponse));
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function setRequestSystemStatusRequestLimitAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

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

		return $response->write(json_encode($apiResponse));
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function changeMessageSystemStatusActiveAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

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

		return $response->write(json_encode($apiResponse));
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function changeAutoDjRequestSystemStatusActiveAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

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

		return $response->write(json_encode($apiResponse));
	}
}
