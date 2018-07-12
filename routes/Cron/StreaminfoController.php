<?php

namespace Routes\Cron;

use Dto\ApiResponse\JsonApiResponseDto;
use Exception\InvalidMountpointException;
use Model\Manager\TrackModelManager;
use Model\Manager\ArtistModelManager;
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
	 * @var \Model\Manager\ArtistModelManager
	 */
	protected $artistModelManager;

	/**
	 * @var \Model\Manager\TrackModelManager
	 */
	protected $trackModelManager;

	/**
	 * @param \Psr\Container\ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->container = $container;

		$this->artistModelManager = new ArtistModelManager();
		$this->trackModelManager  = new TrackModelManager();
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

		$mountpoint = $args['mountpoint'];

		try {
			/** @var \Dto\IceCast\IceCastStreamDto $iceCastStreamDto */
			$iceCastStreamDto = $this->container->iceCastDataClient->fetchMountpoint($mountpoint);

			$stream = Stream::where('mountpoint', '=', $mountpoint)->first();

			if (!isset($stream)) {
				$stream         = new Stream();
				$stream->status = 'Online';
			}

			$stream->mountpoint = $mountpoint;
			$stream->listener   = $iceCastStreamDto->getListeners();
			$stream->artist     = $iceCastStreamDto->getArtist();
			$stream->title      = $iceCastStreamDto->getTitle();
			$stream->save();

			$this->persistTrackAndArtist($stream->title, $stream->artist);

			$apiResponse = (new JsonApiResponseDto())
				->setStatus('success')
				->setResult($stream);

			return $response->write(json_encode($apiResponse));
		}
		catch (InvalidMountpointException $exception) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage($exception->getMessage());

			return $response->write(json_encode($apiResponse));
		}
	}

	/**
	 * @param string $title
	 * @param string $artistName
	 *
	 * @return void
	 */
	protected function persistTrackAndArtist(string $title, string $artistName): void {
		$artist = $this->artistModelManager->createArtist($artistName);

		$currentEventSetting = Setting::where('key', '=', 'current_event')->first();

		$isAutoDjTrack = false;

		if ($currentEventSetting->value === 'DJ-Pony Lucy' || $currentEventSetting->value === 'DJ-Pony Mary') {
			$isAutoDjTrack = true;
		}

		$this->trackModelManager->createTrack($title, $artist->artist_id, $isAutoDjTrack);
	}
}
