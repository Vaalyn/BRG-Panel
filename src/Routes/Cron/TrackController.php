<?php

namespace BRG\Panel\Routes\Cron;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Model\CentovaCast;
use BRG\Panel\Model\Manager\TrackModelManager;
use BRG\Panel\Model\Manager\ArtistModelManager;
use BRG\Panel\Model\Track;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class TrackController {
	protected const CENTOVA_CAST_ACCOUNT_ID = 2;
	protected const CENTOVA_CAST_DISABLED_TRACKS_PATHNAME = 'gesperrt/';
	protected const CENTOVA_CAST_JINGLES_PATHNAME = 'Jingles/';

	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @var ArtistModelManager
	 */
	protected $artistModelManager;

	/**
	 * @var TrackModelManager
	 */
	protected $trackModelManager;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->container = $container;

		$this->artistModelManager = new ArtistModelManager();
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
	 * @return Track
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
