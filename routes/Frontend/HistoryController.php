<?php

namespace Routes\Frontend;

use Carbon\Carbon;
use Model\Manager\HistoryModelManager;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class HistoryController {
	/**
	 * @var \Psr\Container\ContainerInterface
	 */
	protected $container;

	/**
	 * @param \Psr\Container\ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function __invoke(Request $request, Response $response, array $args): Response {
		$historyModelManager = new HistoryModelManager();

		$entriesPerPage = 20;

		$historyQuery = $historyModelManager->createFetchHistoryQuery();

		$history = $historyQuery
			->take($entriesPerPage)
			->get();

		return $this->container->renderer->render($response, '/history/history.php', [
			'carbon' => new Carbon(),
			'history' => $history,
			'request' => $request
		]);
	}
}
