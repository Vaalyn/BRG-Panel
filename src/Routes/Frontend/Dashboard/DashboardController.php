<?php

namespace BRG\Panel\Routes\Frontend\Dashboard;

use BRG\Panel\Model;
use BRG\Panel\Model\Message;
use BRG\Panel\Model\Status;
use BRG\Panel\Model\Stream;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\PhpRenderer;
use Vaalyn\AuthenticationService\AuthenticationInterface;

class DashboardController {
	/**
	 * @var AuthenticationInterface
	 */
	protected $authentication;

	/**
	 * @var PhpRenderer
	 */
	protected $renderer;

	/**
	 * @var Router
	 */
	protected $router;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->authentication = $container->authentication;
		$this->renderer = $container->renderer;
		$this->router = $container->router;
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
			'authentication' => $this->authentication,
			'request' => $request,
			'router' => $this->router,
			'stream' => [
				'stream' 	=> $mainStream,
				'daydj' 	=> $dayDjStream,
				'nightdj' 	=> $nightDjStream
			],
			'system' => [
				'request' => [
					'active'   => $requestSystemStatus->active,
					'id'       => $requestSystemStatus->status_id,
					'limit'    => $requestSystemStatus->limit,
					'requests' => $requestsCount,
					'rules'    => $requestSystemStatus->rules
				],
				'message' => [
					'active'   => $messageSystemStatus->active,
					'id'       => $messageSystemStatus->status_id,
					'limit'    => $messageSystemStatus->limit,
					'messages' => $messagesCount,
					'rules'    => $messageSystemStatus->rules
				],
				'autodj_request' => [
					'active'     => $autoDjRequestSystemStatus->active,
					'id'         => $autoDjRequestSystemStatus->status_id,
					'limit'      => $autoDjRequestSystemStatus->limit,
					'requests'   => $autoDjRequestsCount,
					'rules'      => $autoDjRequestSystemStatus->rules
				]
			]
		]);
	}
}
