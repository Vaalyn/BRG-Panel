<?php

namespace BRG\Panel\Routes\Frontend\Dashboard;

use BRG\Panel\Model;
use BRG\Panel\Service\Authentication\AuthenticationInterface;
use Psr\Container\ContainerInterface;
use Respect\Validation\Validator;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class RequestController {
	/**
	 * @var AuthenticationInterface
	 */
	protected $authentication;

	/**
	 * @var PhpRenderer
	 */
	protected $renderer;

	/**
	 * @var Validator
	 */
	protected $validator;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->authentication = $container->authentication;
		$this->renderer       = $container->renderer;
		$this->validator      = $container->validator;
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

		return $this->renderer->render($response, '/dashboard/request/request.php', [
			'authentication' => $this->authentication,
			'page' => $page,
			'pages' => $pages,
			'path' => $request->getUri()->getPath(),
			'request' => $request,
			'requests' => $requests,
			'validator' => $this->validator
		]);
	}
}
