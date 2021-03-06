<?php

namespace BRG\Panel\Routes\Api;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Model\Manager\HistoryModelManager;
use Illuminate\Database\Eloquent\Builder;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class HistoryController {
	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function getHistoryAction(Request $request, Response $response, array $args): Response {
		$page           = 1;
		$entriesPerPage = 20;

		if (isset($args['page'])) {
			$page = $args['page'];
		}

		$historyQuery = $this->createFetchHistoryQuery($request);

		$historyPages = max([ceil($historyQuery->count() / $entriesPerPage), 1]);

		$history = $historyQuery
			->take($entriesPerPage)
			->skip(($page - 1) * $entriesPerPage)
			->get();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success')
			->setResult($history)
			->setPages($historyPages);

		return $response->withJson($apiResponse);
	}

	/**
	 * @param Request $request
	 *
	 * @return Builder
	 */
	protected function createFetchHistoryQuery(Request $request): Builder {
		$datePlayedStart = $request->getQueryParams()['date_played_start'] ?? null;
		$datePlayedEnd   = $request->getQueryParams()['date_played_end'] ?? null;
		$timePlayedStart = $request->getQueryParams()['time_played_start'] ?? null;
		$timePlayedEnd   = $request->getQueryParams()['time_played_end'] ?? null;
		$title           = $request->getQueryParams()['title'] ?? null;
		$artist          = $request->getQueryParams()['artist'] ?? null;

		$historyModelManager = new HistoryModelManager();

		return $historyModelManager->createFetchHistoryQuery(
			$datePlayedStart,
			$datePlayedEnd,
			$timePlayedStart,
			$timePlayedEnd,
			$title,
			$artist
		);
	}
}
