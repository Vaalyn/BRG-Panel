<?php

namespace BRG\Panel\Routes\Cron;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Dto\IceCast\IceCastStreamDto;
use BRG\Panel\Exception\InvalidMountpointException;
use BRG\Panel\Model\Manager\TrackModelManager;
use BRG\Panel\Model\Manager\ArtistModelManager;
use BRG\Panel\Model\Setting;
use BRG\Panel\Model\Stream;
use BRG\Panel\Service\IceCast\IceCastDataClient;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class StreaminfoController {
	/**
	 * @var ArtistModelManager
	 */
	protected $artistModelManager;

	/**
	 * @var IceCastDataClient
	 */
	protected $iceCastDataClient;

	/**
	 * @var TrackModelManager
	 */
	protected $trackModelManager;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->artistModelManager = new ArtistModelManager();
		$this->iceCastDataClient  = $container->iceCastDataClient;
		$this->trackModelManager  = new TrackModelManager();
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

		$mountpoint = $args['mountpoint'];

		try {
			/** @var IceCastStreamDto $iceCastStreamDto */
			$iceCastStreamDto = $this->iceCastDataClient->fetchMountpoint($mountpoint);

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
