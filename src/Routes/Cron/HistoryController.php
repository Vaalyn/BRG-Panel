<?php

namespace BRG\Panel\Routes\Cron;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Dto\CentovaCast\CentovaCastTrackDto;
use BRG\Panel\Exception\InvalidMountpointException;
use BRG\Panel\Model\History;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class HistoryController {
	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
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
			$centovaCastTrackDtos = $this->container->centovaCastApiClient->fetchSongHistory('stream');

			/** @var CentovaCastTrackDto $centovaCastTrackDto */
			foreach ($centovaCastTrackDtos as $centovaCastTrackDto) {
				if (time() < $centovaCastTrackDto->getTime()) {
					continue;
				}

				$datePlayed = date('Y-m-d', $centovaCastTrackDto->getTime());
				$timePlayed = date('H:i:s', $centovaCastTrackDto->getTime());

				$historyQuery = History::where([
					['date_played', '=', $datePlayed],
					['time_played', '=', $timePlayed],
					['artist', '=', $centovaCastTrackDto->getArtist()],
					['title', '=', $centovaCastTrackDto->getTitle()]
				]);

				if ($historyQuery->exists()) {
					continue;
				}

				$history              = new History();
				$history->date_played = $datePlayed;
				$history->time_played = $timePlayed;
				$history->artist      = $centovaCastTrackDto->getArtist();
				$history->title       = $centovaCastTrackDto->getTitle();
				$history->save();
			}

			$apiResponse = (new JsonApiResponseDto())
				->setStatus('success');

			return $response->write(json_encode($apiResponse));
		}
		catch (InvalidMountpointException $exception) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage($exception->getMessage());

			return $response->write(json_encode($apiResponse));
		}
	}
}
