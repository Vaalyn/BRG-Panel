<?php

namespace BRG\Panel\Routes\Api;

use AzuraCast\Api\Client as AzuraCastApiClient;
use AzuraCast\Api\Exception\ClientRequestException;
use AzuraCast\Api\Exception\RequestsDisabledException;
use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Exception\InfoException;
use BRG\Panel\Model;
use BRG\Panel\Model\History;
use BRG\Panel\Model\Manager\TrackModelManager;
use BRG\Panel\Model\Status;
use Carbon\Carbon;
use Psr\Container\ContainerInterface;
use Respect\Validation\Validator;
use Slim\Http\Request;
use Slim\Http\Response;

class RequestController {
	protected const STATION_ID = 1;

	protected const MINUTES_BETWEEN_CLIENT_AUTODJ_REQUESTS = 60;
	protected const MINUTES_BETWEEN_ARTIST_REPLAYS         = 20;
	protected const MINUTES_BETWEEN_TRACK_REQUESTS         = 240;
	protected const MINUTES_BETWEEN_TRACK_REPLAYS          = 120;

	/**
	 * @var AzuraCastApiClient
	 */
	protected $azuraCastApiClient;

	/**
	 * @var Validator
	 */
	protected $stringNotEmptyValidator;

	/**
	 * @var TrackModelManager
	 */
	protected $trackModelManager;

	/**
	 * @var Validator
	 */
	protected $validator;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->azuraCastApiClient      = $container->azuraCastApiClient;
		$this->stringNotEmptyValidator = $container->validator::stringType()->length(1, null);
		$this->trackModelManager       = new TrackModelManager();
		$this->validator               = $container->validator;
	}

	/**
	 * @param Request $httpRequest
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function createRequestAction(Request $httpRequest, Response $response, array $args): Response {
		try {
			$requestSystemStatus = Status::find(1);

			if (!$requestSystemStatus->active) {
				throw new InfoException('Das Request System ist nicht aktiv');
			}

			if (isset($httpRequest->getParsedBody()['id'])) {
				$this->processCreateRequestWithTrackId($httpRequest);
			}
			else {
				$this->processCreateRequestWithSongParameters($httpRequest);
			}

			$apiResponse = (new JsonApiResponseDto())
				->setStatus('success')
				->setMessage('Request eingereicht');

			return $response->withJson($apiResponse);
		}
		catch (InfoException $exception) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage($exception->getMessage());

			return $response->withJson($apiResponse);
		}
	}

	/**
	 * @param Request $httpRequest
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function createAutoDjRequestAction(Request $httpRequest, Response $response, array $args): Response {
		$id        = (int) $httpRequest->getParsedBody()['id'] ?? 0;
		$nickname  = trim($httpRequest->getParsedBody()['nickname']) ?? '';
		$ipAddress = $httpRequest->getAttribute('ip_address');

		try {
			$autoDjRequestSystemStatus = Status::find(3);

			if (!$autoDjRequestSystemStatus->active) {
				throw new InfoException('Das AutoDj Request System ist nicht aktiv');
			}

			$track = $this->trackModelManager->findTrackById($id);

			if (!isset($track) || $track->requestable_song_id === '') {
				throw new InfoException(sprintf('Es wurde kein requestbarer Song mit der ID %s gefunden', $id));
			}

			$this->checkIfClientHasReachedAutoDjRequestLimit($nickname, $ipAddress);

			$this->checkIfTrackCanBeRequested($track->title, $track->artist->name);

			try {
				$this->azuraCastApiClient->station(self::STATION_ID)->requests()->submit(
					$track->requestable_song_id
				);
			}
			catch (RequestsDisabledException $exception) {
				throw new InfoException('Das AutoDj Request System ist nicht aktiv');
			}
			catch (ClientRequestException $exception) {
				throw new InfoException('Beim einreichen des Requests ist ein Fehler aufgetreten');
			}

			$request             = new Model\Request();
			$request->title      = $track->title;
			$request->artist     = $track->artist->name;
			$request->url        = '';
			$request->nickname   = $nickname;
			$request->message    = 'AutoDj Request';
			$request->ip_address = $ipAddress;
			$request->is_skipped = false;
			$request->is_autodj  = true;
			$request->save();
			$request->delete();

			$apiResponse = (new JsonApiResponseDto())
				->setStatus('success')
				->setMessage('Request eingereicht');

			return $response->withJson($apiResponse);
		}
		catch (InfoException $exception) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage($exception->getMessage());

			return $response->withJson($apiResponse);
		}
	}

	/**
	 * @param Request $httpRequest
	 *
	 * @return void
	 */
	protected function processCreateRequestWithTrackId(Request $httpRequest): void {
		$id        = (int) $httpRequest->getParsedBody()['id'] ?? 0;
		$nickname  = trim($httpRequest->getParsedBody()['nickname']) ?? '';
		$message   = trim($httpRequest->getParsedBody()['message']) ?? '';
		$ipAddress = $httpRequest->getAttribute('ip_address');

		$track = $this->trackModelManager->findTrackById($id);

		if (!isset($track)) {
			throw new InfoException(sprintf('Es wurde kein Song mit der ID %s gefunden', $id));
		}

		$this->checkIfClientHasReachedRequestLimit($nickname, $ipAddress);

		$request             = new Model\Request();
		$request->title      = $track->title;
		$request->artist     = $track->artist->name;
		$request->url        = '';
		$request->nickname   = $nickname;
		$request->message    = $message;
		$request->ip_address = $ipAddress;
		$request->is_skipped = false;
		$request->is_autodj  = false;
		$request->save();
	}

	/**
	 * @param Request $httpRequest
	 *
	 * @return void
	 */
	protected function processCreateRequestWithSongParameters(Request $httpRequest): void {
		$title     = trim($httpRequest->getParsedBody()['title']) ?? '';
		$artist    = trim($httpRequest->getParsedBody()['artist']) ?? '';
		$url       = trim($httpRequest->getParsedBody()['url']) ?? '';
		$nickname  = trim($httpRequest->getParsedBody()['nickname']) ?? '';
		$message   = trim($httpRequest->getParsedBody()['message']) ?? '';
		$ipAddress = $httpRequest->getAttribute('ip_address');

		$this->validateRequestSongParameters($title, $artist, $url);

		$this->checkIfClientHasReachedRequestLimit($nickname, $ipAddress);

		$request             = new Model\Request();
		$request->title      = $title;
		$request->artist     = $artist;
		$request->url        = $url;
		$request->nickname   = $nickname;
		$request->message    = $message;
		$request->ip_address = $ipAddress;
		$request->is_skipped = false;
		$request->is_autodj  = false;
		$request->save();
	}

	/**
	 * @param string $title
	 * @param string $artist
	 * @param string $url
	 *
	 * @return void
	 */
	protected function validateRequestSongParameters(string $title, string $artist, string $url): void {
		if (!$this->stringNotEmptyValidator->validate($title)) {
			throw new InfoException('Es muss ein Titel eingegeben werden');
		}

		if (!$this->stringNotEmptyValidator->validate($artist)) {
			throw new InfoException('Es muss ein Artist eingegeben werden');
		}

		if ($this->stringNotEmptyValidator->validate($url)) {
			if (!$this->validator::url()->validate($url)) {
				throw new InfoException('Der Link / die Url ist ungültig');
			}
		}
	}

	/**
	 * @param string $nickname
	 * @param string $ipAddress
	 *
	 * @return void
	 */
	protected function checkIfClientHasReachedRequestLimit(string $nickname, string $ipAddress): void {
		$requestSystemStatus = Status::find(1);
		$requestLimit = $requestSystemStatus->limit;

		$activeRequestsForClient = Model\Request::where('ip_address', '=', $ipAddress)
			->orWhere('nickname', '=', $nickname)
			->count();

		if ($activeRequestsForClient >= $requestLimit) {
			throw new InfoException(
				sprintf(
					'Du hast das Request Limit von %s aktiven Request(s) erreicht',
					$requestLimit
				)
			);
		}
	}

	/**
	 * @param string $nickname
	 * @param string $ipAddress
	 *
	 * @return void
	 */
	protected function checkIfClientHasReachedAutoDjRequestLimit(string $nickname, string $ipAddress): void {
		$autoDjSystemStatus = Status::find(3);
		$requestLimit = $autoDjSystemStatus->limit;

		$dateTimeForRequestLimit = Carbon::now()
			->subMinutes(self::MINUTES_BETWEEN_CLIENT_AUTODJ_REQUESTS);

		$requestCount = Model\Request::withTrashed()
			->where('created_at', '>', $dateTimeForRequestLimit->toDateTimeString())
			->where(function($query) use ($ipAddress, $nickname) {
				$query->where('ip_address', '=', $ipAddress)
					->orWhere('nickname', '=', $nickname);
			})
			->count();

		if ($requestCount >= $requestLimit) {
			throw new InfoException(
				sprintf(
					'Du hast das Request Limit von %s Request(s) in den letzten %s Minuten erreicht',
					$requestLimit,
					self::MINUTES_BETWEEN_CLIENT_AUTODJ_REQUESTS
				)
			);
		}
	}

	/**
	 * @param string $title
	 * @param string $artist
	 *
	 * @return void
	 */
	protected function checkIfTrackCanBeRequested(string $title, string $artist): void {
		if ($this->hasArtistBeenRequestedSince($artist, self::MINUTES_BETWEEN_ARTIST_REPLAYS)) {
			throw new InfoException(
				sprintf(
					'Es wurde innerhalb der letzten %s Minuten bereits ein Lied von diesem Artist requested',
					self::MINUTES_BETWEEN_ARTIST_REPLAYS
				)
			);
		}

		if ($this->hasArtistBeenPlayedSince($artist, self::MINUTES_BETWEEN_ARTIST_REPLAYS)) {
			throw new InfoException(
				sprintf(
					'Es wurde innerhalb der letzten %s Minuten bereits ein Lied von diesem Artist gespielt',
					self::MINUTES_BETWEEN_ARTIST_REPLAYS
				)
			);
		}

		if ($this->hasTrackBeenRequestedSince($title, $artist, self::MINUTES_BETWEEN_TRACK_REQUESTS)) {
			throw new InfoException(
				sprintf(
					'Dieses Lied wurde bereits innerhalb der letzten %s Stunden requested',
					self::MINUTES_BETWEEN_TRACK_REQUESTS / 60
				)
			);
		}

		if ($this->hasTrackBeenPlayedSince($title, $artist, self::MINUTES_BETWEEN_TRACK_REPLAYS)) {
			throw new InfoException(
				sprintf(
					'Dieses Lied wurde bereits innerhalb der letzten %s Stunden gespielt',
					self::MINUTES_BETWEEN_TRACK_REPLAYS / 60
				)
			);
		}
	}

	/**
	 * @param string $artist
	 * @param int $minutes
	 *
	 * @return bool
	 */
	protected function hasArtistBeenRequestedSince(string $artist, int $minutes): bool {
		$dateTimeForArtistRequestLimit = Carbon::now()->subMinutes($minutes);

		return Model\Request::withTrashed()
			->where([
				['created_at', '>', $dateTimeForArtistRequestLimit->toDateTimeString()],
				['artist', '=', $artist]
			])
			->exists();
	}

	/**
	 * @param string $artist
	 * @param int $minutes
	 *
	 * @return bool
	 */
	protected function hasArtistBeenPlayedSince(string $artist, int $minutes): bool {
		$dateTimeForArtistPlayedLimit = Carbon::now()->subMinutes($minutes);

		return History::where([
				['date_played', '>', $dateTimeForArtistPlayedLimit->format('Y-m-d')],
				['time_played', '>', $dateTimeForArtistPlayedLimit->format('H:i:s')],
				['artist', '=', $artist]
			])->exists();
	}

	/**
	 * @param string $title
	 * @param string $artist
	 * @param int $minutes
	 *
	 * @return bool
	 */
	protected function hasTrackBeenRequestedSince(string $title, string $artist, int $minutes): bool {
		$dateTimeForTrackRequestLimit = Carbon::now()->subMinutes($minutes);

		return Model\Request::withTrashed()
			->where([
				['created_at', '>', $dateTimeForTrackRequestLimit->toDateTimeString()],
				['title', '=', $title],
				['artist', '=', $artist]
			])
			->exists();
	}

	/**
	 * @param string $title
	 * @param string $artist
	 * @param int $minutes
	 *
	 * @return bool
	 */
	protected function hasTrackBeenPlayedSince(string $title, string $artist, int $minutes): bool {
		$dateTimeForTrackPlayedLimit = Carbon::now()->subMinutes($minutes);

		return History::where([
				['date_played', '>', $dateTimeForTrackPlayedLimit->format('Y-m-d')],
				['time_played', '>', $dateTimeForTrackPlayedLimit->format('H:i:s')],
				['title', '=', $title],
				['artist', '=', $artist]
			])->exists();
	}
}
