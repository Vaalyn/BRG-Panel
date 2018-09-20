<?php

namespace BRG\Panel\Routes\Frontend\Dashboard;

use BRG\Panel\Model\Manager\HistoryModelManager;
use BRG\Panel\Service\Auth\AuthInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class HistoryController {
	/**
	 * @var AuthInterface
	 */
	protected $authentication;

	/**
	 * @var PhpRenderer
	 */
	protected $renderer;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->authentication = $container->authentication;
		$this->renderer       = $container->renderer;
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function __invoke(Request $request, Response $response, array $args): Response {
		$page           = 1;
		$entriesPerPage = 20;

		if (isset($args['page'])) {
			$page = $args['page'];
		}

		$historyQuery = $this->createFetchHistoryQuery($request);

		$pages = max([ceil($historyQuery->count() / $entriesPerPage), 1]);

		$history = $historyQuery
			->take($entriesPerPage)
			->skip(($page - 1) * $entriesPerPage)
			->get();

		return $this->renderer->render($response, '/dashboard/history/history.php', [
			'auth' => $this->authentication,
			'carbon' => new Carbon(),
			'history' => $history,
			'page' => $page,
			'pages' => $pages,
			'path' => $request->getUri()->getPath(),
			'request' => $request
		]);
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
