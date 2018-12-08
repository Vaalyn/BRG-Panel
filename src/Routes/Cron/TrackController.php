<?php

namespace BRG\Panel\Routes\Cron;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Model\Manager\TrackModelManager;
use BRG\Panel\Model\Manager\ArtistModelManager;
use BRG\Panel\Model\Track;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Vaalyn\AzuraCastApiClient\AzuraCastApiClient;
use Vaalyn\AzuraCastApiClient\Dto\RequestableSongDto;

class TrackController {
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
		$this->azuraCastApiClient = $container->azuraCastApiClient;
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

		$requestableSongsDtoArray = $this->azuraCastApiClient->allRequestableSongs(1);

		$requestableSongs = [];

		foreach ($requestableSongsDtoArray as $requestableSongsDto) {
			$requestableSongs = array_merge(
				$requestableSongs,
				$requestableSongsDto->getRequestableSongs()
			);
		}

		$panelAutoDjTracks = Track::with('artist')
			->where('autodj', '=', true)
			->get();

		$currentlyAvailableAutoDjTrackIds = [];

		/** @var RequestableSongDto $requestableSong */
		foreach ($requestableSongs as $requestableSong) {
			$track = $this->persistTrackAndArtist(
				$requestableSong->getSong()->getTitle(),
				$requestableSong->getSong()->getArtist(),
				$requestableSong->getRequestableSongId()
			);

			$currentlyAvailableAutoDjTrackIds[] = $track->track_id;
		}

		foreach ($panelAutoDjTracks as $track) {
			if (in_array($track->track_id, $currentlyAvailableAutoDjTrackIds)) {
				continue;
			}

			$track->autodj = false;
			$track->save();
		}

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success')
			->setResult('');

		return $response->write(json_encode($apiResponse));
	}

	/**
	 * @param string $title
	 * @param string $artistName
	 * @param string $requestableSongId
	 *
	 * @return Track
	 */
	protected function persistTrackAndArtist(
		string $title,
		string $artistName,
		string $requestableSongId
	): Track {
		$artist = $this->artistModelManager->createArtist($artistName);

		return $this->trackModelManager->createTrack(
			$title,
			$artist->artist_id,
			true,
			null,
			null,
			null,
			null,
			$requestableSongId
		);
	}
}
