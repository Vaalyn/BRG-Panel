<?php

namespace BRG\Panel\Routes\Api\Dashboard;

use BRG\Panel\Model\Manager\HistoryModelManager;
use Illuminate\Database\Eloquent\Builder;
use League\Csv\Writer;
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
	public function downloadHistoryCsvAction(Request $request, Response $response, array $args): Response {
		$historyQuery = $this->createFetchHistoryQuery($request);
		$history = $historyQuery->get();

		$csvWriter = Writer::createFromFileObject(new \SplTempFileObject());
		$csvWriter->insertOne(['Id', 'Datum', 'Uhrzeit', 'Titel', 'Artist']);
		$csvWriter->insertAll($history->toArray());

		$historyCsvFile = tmpfile();
		fwrite($historyCsvFile, $csvWriter->getContent());

		$downloadFileStream = new \Slim\Http\Stream($historyCsvFile);

		return $response->withStatus(200)
			->withHeader('Content-Type', 'text/csv')
			->withHeader('Content-Description', 'File Transfer')
			->withHeader('Content-Disposition', 'attachment; filename="BRG_History.csv"')
			->withHeader('Content-Transfer-Encoding', 'binary')
			->withHeader('Cache-Control', 'no-cache')
			->withHeader('Expires', '0')
			->withBody($downloadFileStream);
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
