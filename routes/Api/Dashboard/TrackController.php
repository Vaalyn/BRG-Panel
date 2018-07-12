<?php

namespace Routes\Api\Dashboard;

use Dto\ApiResponse\JsonApiResponseDto;
use Model\Track;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class TrackController {
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
	public function setIgnoreVotesForTrackAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$id = $args['id'];

		$track = Track::find($id);

		if (!isset($track)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Song nicht gefunden');

			return $response->write(json_encode($apiResponse));
		}

		$track->ignore_votes = true;
		$track->save();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success');

		return $response->write(json_encode($apiResponse));
	}
}
