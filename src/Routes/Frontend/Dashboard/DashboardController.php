<?php

namespace BRG\Panel\Routes\Frontend\Dashboard;

use BRG\Panel\Model;
use BRG\Panel\Model\Message;
use BRG\Panel\Model\Status;
use BRG\Panel\Model\Stream;
use BRG\Panel\Service\Auth\AuthInterface;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class DashboardController {
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
		$requestSystemStatus       = Status::find(1);
		$messageSystemStatus       = Status::find(2);
		$autoDjRequestSystemStatus = Status::find(3);

		$requestsCount       = Model\Request::count();
		$messagesCount       = Message::count();
		$autoDjRequestsCount = Model\Request::where('is_autodj', '=', true)->count();

		$mainStream    = Stream::where('mountpoint', '=', 'stream')->first();
		$dayDjStream   = Stream::where('mountpoint', '=', 'daydj')->first();
		$nightDjStream = Stream::where('mountpoint', '=', 'nightdj')->first();

		return $this->renderer->render($response, '/dashboard/dashboard/dashboard.php', [
			'auth' => $this->authentication,
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
