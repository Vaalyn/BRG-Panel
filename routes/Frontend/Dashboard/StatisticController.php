<?php

namespace Routes\Frontend\Dashboard;

use Model;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

use Illuminate\Database\Query\Expression;

class StatisticController {
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
	public function getRequestStatisticAction(Request $request, Response $response, array $args): Response {
		$page           = 1;
		$entriesPerPage = 20;

		if (isset($args['page'])) {
			$page = $args['page'];
		}

		$requestsQuery = Model\Request::withTrashed()
			->orderBy('created_at')
			->orderBy('request_id');

		$pages = max([ceil($requestsQuery->count() / $entriesPerPage), 1]);

		$requests = $requestsQuery
			->take($entriesPerPage)
			->skip(($page - 1) * $entriesPerPage)
			->get();

		return $this->container->renderer->render($response, '/dashboard/statistic/request.php', [
			'auth' => $this->container->auth,
			'page' => $page,
			'pages' => $pages,
			'path' => $request->getUri()->getPath(),
			'request' => $request,
			'requests' => $requests
		]);
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function getRequestStatisticArtistAction(Request $request, Response $response, array $args): Response {
		$page           = 1;
		$entriesPerPage = 20;

		if (isset($args['page'])) {
			$page = $args['page'];
		}

		$requestsQuery = Model\Request::withTrashed()
			->select('artist', new Expression('COUNT(*) AS total'))
			->groupBy('artist')
			->orderByRaw(new Expression('COUNT(*) DESC'))
			->orderBy('artist');

		$pages = max([ceil($requestsQuery->getQuery()->getCountForPagination() / $entriesPerPage), 1]);

		$requests = $requestsQuery
			->take($entriesPerPage)
			->skip(($page - 1) * $entriesPerPage)
			->get();

		return $this->container->renderer->render($response, '/dashboard/statistic/request.php', [
			'auth' => $this->container->auth,
			'page' => $page,
			'pages' => $pages,
			'path' => $request->getUri()->getPath(),
			'request' => $request,
			'requests' => $requests,
			'statisticRequestsPerArtist' => true
		]);
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function getRequestStatisticTitleAction(Request $request, Response $response, array $args): Response {
		$page           = 1;
		$entriesPerPage = 20;

		if (isset($args['page'])) {
			$page = $args['page'];
		}

		$requestsQuery = Model\Request::withTrashed()
			->select('title', 'artist', new Expression('COUNT(*) AS total'))
			->groupBy('title')
			->groupBy('artist')
			->orderByRaw(new Expression('COUNT(*) DESC'))
			->orderBy('title');

		$pages = max([ceil($requestsQuery->getQuery()->getCountForPagination() / $entriesPerPage), 1]);

		$requests = $requestsQuery
			->take($entriesPerPage)
			->skip(($page - 1) * $entriesPerPage)
			->get();

		return $this->container->renderer->render($response, '/dashboard/statistic/request.php', [
			'auth' => $this->container->auth,
			'page' => $page,
			'pages' => $pages,
			'path' => $request->getUri()->getPath(),
			'request' => $request,
			'requests' => $requests,
			'statisticRequestsPerTitle' => true
		]);
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function getRequestStatisticUserAction(Request $request, Response $response, array $args): Response {
		$page           = 1;
		$entriesPerPage = 20;

		if (isset($args['page'])) {
			$page = $args['page'];
		}

		$requestsQuery = Model\Request::withTrashed()
			->select('nickname', new Expression('COUNT(*) AS total'))
			->groupBy('nickname')
			->orderByRaw(new Expression('COUNT(*) DESC'))
			->orderBy('nickname');

		$pages = max([ceil($requestsQuery->getQuery()->getCountForPagination() / $entriesPerPage), 1]);

		$requests = $requestsQuery
			->take($entriesPerPage)
			->skip(($page - 1) * $entriesPerPage)
			->get();

		return $this->container->renderer->render($response, '/dashboard/statistic/request.php', [
			'auth' => $this->container->auth,
			'page' => $page,
			'pages' => $pages,
			'path' => $request->getUri()->getPath(),
			'request' => $request,
			'requests' => $requests,
			'statisticRequestsPerUser' => true
		]);
	}
}
