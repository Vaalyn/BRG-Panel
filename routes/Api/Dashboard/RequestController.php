<?php

namespace Routes\Api\Dashboard;

use Dto\ApiResponse\JsonApiResponseDto;
use Model;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class RequestController {
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
	public function setRequestPlayedAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$id = $args['id'];

		$request = Model\Request::find($id);

		if (!isset($request)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Request not found');

			return $response->write(json_encode($apiResponse));
		}

		$request->delete();

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
	public function setRequestSkippedAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$id = $args['id'];

		$request = Model\Request::find($id);

		if (!isset($request)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Request not found');

			return $response->write(json_encode($apiResponse));
		}

		$request->is_skipped = true;
		$request->save();
		$request->delete();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success');

		return $response->write(json_encode($apiResponse));
	}
}
