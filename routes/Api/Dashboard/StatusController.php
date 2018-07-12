<?php

namespace Routes\Api\Dashboard;

use Dto\ApiResponse\JsonApiResponseDto;
use Dto\ApiResponse\StatusDto;
use Model\Status;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class StatusController {
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
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
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
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
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
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
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
