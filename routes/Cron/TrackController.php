<?php

namespace Routes\Cron;

use Dto\ApiResponse\JsonApiResponseDto;
use Model\CentovaCast;
use Model\Manager\TrackModelManager;
use Model\Manager\ArtistModelManager;
use Model\Track;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class TrackController {
	protected const CENTOVA_CAST_ACCOUNT_ID = 2;
	protected const CENTOVA_CAST_DISABLED_TRACKS_PATHNAME = 'gesperrt/';
	protected const CENTOVA_CAST_JINGLES_PATHNAME = 'Jingles/';

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

		$panelAutoDjTracks = Track::with('artist')
			->where('autodj', '=', true)
			->get();

		$centovaCastAutoDjTracks = CentovaCast\Track::with('artist')
			->where([
				['accountid', '=', self::CENTOVA_CAST_ACCOUNT_ID],
				['pathname', 'NOT LIKE', self::CENTOVA_CAST_DISABLED_TRACKS_PATHNAME],
				['pathname', 'NOT LIKE', self::CENTOVA_CAST_JINGLES_PATHNAME]
			])
			->get();

		$currentlyAvailableAutoDjTrackIds = [];

		foreach ($centovaCastAutoDjTracks as $autoDjTrack) {
			$track = $this->persistTrackAndArtist(
				$autoDjTrack->title,
				$autoDjTrack->artist->name,
				$autoDjTrack->length
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
	 * @param int $length
	 *
	 * @return \Model\Track
	 */
	protected function persistTrackAndArtist(string $title, string $artistName, int $length): Track {
		$artist = $this->artistModelManager->createArtist($artistName);

		return $this->trackModelManager->createTrack(
			$title,
			$artist->artist_id,
			true,
			$length
		);
	}
}
