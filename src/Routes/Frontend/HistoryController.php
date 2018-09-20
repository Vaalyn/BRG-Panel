<?php

namespace BRG\Panel\Routes\Frontend;

use BRG\Panel\Model\Manager\HistoryModelManager;
use Carbon\Carbon;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class HistoryController {
	/**
	 * @var PhpRenderer
	 */
	protected $renderer;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->renderer = $container->renderer;
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function __invoke(Request $request, Response $response, array $args): Response {
		$historyModelManager = new HistoryModelManager();

		$entriesPerPage = 20;

		$historyQuery = $historyModelManager->createFetchHistoryQuery();

		$history = $historyQuery
			->take($entriesPerPage)
			->get();

		return $this->renderer->render($response, '/history/history.php', [
			'carbon' => new Carbon(),
			'history' => $history,
			'request' => $request
		]);
	}
}
