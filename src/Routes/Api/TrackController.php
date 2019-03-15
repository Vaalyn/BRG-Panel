<?php

namespace BRG\Panel\Routes\Api;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Dto\ApiResponse\TrackDto;
use BRG\Panel\Model\Manager\TrackModelManager;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class TrackController {
	/**
	 * @var TrackModelManager
	 */
	protected $trackModelManager;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->trackModelManager = new TrackModelManager();
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function getTrackAction(Request $request, Response $response, array $args): Response {
		$id = (int) $args['id'];

		$track = $this->trackModelManager->findTrackById($id);

		if (!isset($track)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Track not found');

			return $response->withJson($apiResponse);
		}

		$trackDto = new TrackDto(
			$track->track_id,
			$track->title,
			$track->artist->name ?? ''
		);

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success')
			->setResult($trackDto);

		return $response->withJson($apiResponse);
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function getAutoDjTrackAction(Request $request, Response $response, array $args): Response {
		$id = $args['id'];

		$track = $this->trackModelManager->findTrackById($id, true);

		if (!isset($track)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Track not found');

			return $response->withJson($apiResponse);
		}

		$trackDto = new TrackDto(
			$track->track_id,
			$track->title,
			$track->artist->name ?? ''
		);

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success')
			->setResult($trackDto);

		return $response->withJson($apiResponse);
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function getTracksAction(Request $request, Response $response, array $args): Response {
		$title  = $request->getQueryParams()['title'] ?? null;
		$artist = $request->getQueryParams()['artist'] ?? null;

		$tracks = $this->trackModelManager->searchTracksByTitleAndArtist($title, $artist);

		$trackList = [];

		foreach ($tracks as $track) {
			$trackList[] = new TrackDto(
				$track->track_id,
				$track->title,
				$track->artist->name ?? ''
			);
		}

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success')
			->setResult($trackList);

		return $response->withJson($apiResponse);
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function getAutoDjTracksAction(Request $request, Response $response, array $args): Response {
		$title  = $request->getQueryParams()['title'] ?? null;
		$artist = $request->getQueryParams()['artist'] ?? null;

		$tracks = $this->trackModelManager->searchAutoDjTracksByTitleAndArtist($title, $artist);

		$trackList = [];

		foreach ($tracks as $track) {
			$trackList[] = new TrackDto(
				$track->track_id,
				$track->title,
				$track->artist->name ?? ''
			);
		}

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success')
			->setResult($trackList);

		return $response->withJson($apiResponse);
	}
}
