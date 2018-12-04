<?php

namespace BRG\Panel\Routes\Cron;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Model\Manager\TrackModelManager;
use BRG\Panel\Model\Manager\ArtistModelManager;
use BRG\Panel\Model\Stream;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Vaalyn\AzuraCastApiClient\AzuraCastApiClient;
use Vaalyn\AzuraCastApiClient\Exception\AzuraCastApiClientRequestException;

class StreaminfoController {
	/**
	 * @var ArtistModelManager
	 */
	protected $artistModelManager;

	/**
	 * @var AzuraCastApiClient
	 */
	protected $azuraCastApiClient;

	/**
	 * @var TrackModelManager
	 */
	protected $trackModelManager;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->artistModelManager = new ArtistModelManager();
		$this->azuraCastApiClient  = $container->azuraCastApiClient;
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

		$stationId = (int) $args['stationId'];

		try {
			$nowPlayingDto = $this->azuraCastApiClient->nowPlayingOnStation($stationId);

			$artist = $nowPlayingDto->getCurrentSong()->getSong()->getArtist();
			$title  = $nowPlayingDto->getCurrentSong()->getSong()->getTitle();

			foreach ($nowPlayingDto->getStation()->getMounts() as $mountDto) {
				$mountpoint = str_replace('/', '', $mountDto->getName());

				$stream = Stream::where('mountpoint', '=', $mountpoint)->first();

				if (!isset($stream)) {
					$stream         = new Stream();
					$stream->status = 'Online';
				}

				$stream->mountpoint = $mountpoint;
				$stream->listener   = $nowPlayingDto->getListeners()->getTotal();
				$stream->artist     = $artist;
				$stream->title      = $title;
				$stream->save();
			}

			$this->persistTrackAndArtist(
				$title,
				$artist,
				$nowPlayingDto->getLive()->getIsLive()
			);

			$apiResponse = (new JsonApiResponseDto())
				->setStatus('success');

			return $response->write(json_encode($apiResponse));
		}
		catch (AzuraCastApiClientRequestException $exception) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage($exception->getMessage());

			return $response->write(json_encode($apiResponse));
		}
	}

	/**
	 * @param string $title
	 * @param string $artistName
	 * @param bool $isLive
	 *
	 * @return void
	 */
	protected function persistTrackAndArtist(string $title, string $artistName, bool $isLive): void {
		$artist = $this->artistModelManager->createArtist($artistName);

		$this->trackModelManager->createTrack($title, $artist->artist_id, !$isLive);
	}
}
