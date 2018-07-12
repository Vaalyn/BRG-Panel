<?php

namespace Routes\Frontend;

use Model\Status;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class SystemController {
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

		return $this->container->renderer->render($response, '/system/system.php', [
			'request' => $request,
			'systems' => [
				'request' => [
					'active' => $requestSystemStatus->active,
					'limit' => $requestSystemStatus->limit
				],
				'message' => [
					'active' => $messageSystemStatus->active,
					'limit' => $messageSystemStatus->limit
				],
				'autodj_request' => [
					'active' => $autoDjRequestSystemStatus->active,
					'limit' => $autoDjRequestSystemStatus->limit
				]
			]
		]);
	}
}
