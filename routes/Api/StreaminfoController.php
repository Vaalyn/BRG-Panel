<?php

namespace Routes\Api;

use Dto\ApiResponse\JsonApiResponseDto;
use Dto\ApiResponse\StreaminfoDto;
use Model\Manager\TrackModelManager;
use Model\Setting;
use Model\Stream;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class StreaminfoController {
	/**
	 * @var \Psr\Container\ContainerInterface
	 */
	protected $container;

	/**
	 * @var \Model\Manager\TrackModelManager
	 */
	protected $trackModelManager;

	/**
	 * @param \Psr\Container\ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->container = $container;

		$this->trackModelManager = new TrackModelManager();
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function __invoke(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$stream = Stream::where('mountpoint', '=', $args['mountpoint'])->first();

		if (!isset($stream)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Invalid mountpoint');

			return $response->write(json_encode($apiResponse));
		}

		$currentEventSetting = Setting::where('key', '=', 'current_event')->first();

		$track = $this->trackModelManager->findTrackByTitleAndArtist(
			$stream->title,
			$stream->artist
		);

		$upvotes = $track->votes->where('upvote', '=', 1)->count();
		$downvotes = $track->votes->where('downvote', '=', 1)->count();

		$streaminfoDto = new StreaminfoDto(
			$stream->stream_id,
			$stream->title,
			$stream->artist,
			$stream->listener,
			$stream->status,
			$currentEventSetting->value,
			$upvotes,
			$downvotes
		);

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success')
			->setResult($streaminfoDto);

		return $response->write(json_encode($apiResponse));
	}
}
