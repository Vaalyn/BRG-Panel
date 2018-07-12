<?php

namespace Routes\Frontend\Dashboard;

use Model;
use Model\Message;
use Model\Status;
use Model\Stream;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class DashboardController {
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
		$requestSystemStatus       = Status::find(1);
		$messageSystemStatus       = Status::find(2);
		$autoDjRequestSystemStatus = Status::find(3);

		$requestsCount       = Model\Request::count();
		$messagesCount       = Message::count();
		$autoDjRequestsCount = Model\Request::where('is_autodj', '=', true)->count();

		$mainStream    = Stream::where('mountpoint', '=', 'stream')->first();
		$dayDjStream   = Stream::where('mountpoint', '=', 'daydj')->first();
		$nightDjStream = Stream::where('mountpoint', '=', 'nightdj')->first();

		return $this->container->renderer->render($response, '/dashboard/dashboard/dashboard.php', [
			'auth' => $this->container->auth,
			'request' => $request,
			'stream' => [
				'stream' 	=> $mainStream,
				'daydj' 	=> $dayDjStream,
				'nightdj' 	=> $nightDjStream
			],
			'system' => [
				'request' => [
					'active' => $requestSystemStatus->active,
					'limit' => $requestSystemStatus->limit,
					'requests' => $requestsCount
				],
				'message' => [
					'active' => $messageSystemStatus->active,
					'limit' => $messageSystemStatus->limit,
					'messages' => $messagesCount
				],
				'autodj_request' => [
					'active' => $autoDjRequestSystemStatus->active,
					'limit' => $autoDjRequestSystemStatus->limit,
					'requests' => $autoDjRequestsCount
				]
			]
		]);
	}
}
