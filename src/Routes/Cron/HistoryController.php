<?php

namespace BRG\Panel\Routes\Cron;

use AzuraCast\Api\Client as AzuraCastApiClient;
use AzuraCast\Api\Dto\SongHistoryDto;
use AzuraCast\Api\Exception\ClientRequestException;
use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Model\History;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class HistoryController {
	protected const STATION_ID = 1;

	/**
	 * @var AzuraCastApiClient
	 */
	protected $azuraCastApiClient;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->azuraCastApiClient = $container->azuraCastApiClient;
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

		try {
			$nowPlayingDto = $this->azuraCastApiClient->station(self::STATION_ID)->nowPlaying();
			$songHistoryDtos = $nowPlayingDto->getSongHistory();

			usort($songHistoryDtos, function($firstSongHistoryDto, $secondSongHistoryDto) {
				return $firstSongHistoryDto->getPlayedAt() > $secondSongHistoryDto->getPlayedAt();
			});

			/** @var SongHistoryDto $songHistoryDto */
			foreach ($songHistoryDtos as $songHistoryDto) {
				if (time() < $songHistoryDto->getPlayedAt()) {
					continue;
				}

				$datePlayed = date('Y-m-d', $songHistoryDto->getPlayedAt());
				$timePlayed = date('H:i:s', $songHistoryDto->getPlayedAt());

				$artist = $songHistoryDto->getSong()->getArtist();
				$title = $songHistoryDto->getSong()->getTitle();

				$historyQuery = History::where([
					['date_played', '=', $datePlayed],
					['time_played', '=', $timePlayed],
					['artist', '=', $artist],
					['title', '=', $title]
				]);

				if ($historyQuery->exists()) {
					continue;
				}

				$history              = new History();
				$history->date_played = $datePlayed;
				$history->time_played = $timePlayed;
				$history->artist      = $artist;
				$history->title       = $title;
				$history->save();
			}

			$apiResponse = (new JsonApiResponseDto())
				->setStatus('success');

			return $response->write(json_encode($apiResponse));
		}
		catch (ClientRequestException $exception) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage($exception->getMessage());

			return $response->write(json_encode($apiResponse));
		}
	}
}
