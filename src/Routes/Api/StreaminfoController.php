<?php

namespace BRG\Panel\Routes\Api;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Dto\ApiResponse\StreaminfoDto;
use BRG\Panel\Model\Manager\TrackModelManager;
use BRG\Panel\Model\Setting;
use BRG\Panel\Model\Stream;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class StreaminfoController {
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
			$track->track_id,
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
