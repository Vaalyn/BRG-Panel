<?php

namespace BRG\Panel\Routes\Frontend\Dashboard;

use BRG\Panel\Model;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class RequestController {
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
		$page           = 1;
		$entriesPerPage = 20;

		if (isset($args['page'])) {
			$page = $args['page'];
		}

		$requestsQuery = Model\Request::orderBy('created_at')->orderBy('request_id');

		$pages = max([ceil($requestsQuery->count() / $entriesPerPage), 1]);

		$requests = $requestsQuery
			->take($entriesPerPage)
			->skip(($page - 1) * $entriesPerPage)
			->get();

		return $this->container->renderer->render($response, '/dashboard/request/request.php', [
			'auth' => $this->container->auth,
			'page' => $page,
			'pages' => $pages,
			'path' => $request->getUri()->getPath(),
			'request' => $request,
			'requests' => $requests,
			'validator' => $this->container->validator
		]);
	}
}
