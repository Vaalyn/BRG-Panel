<?php

namespace BRG\Panel\Routes\Frontend;

use BRG\Panel\Model\Status;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class SystemController {
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
		$requestSystemStatus       = Status::find(1);
		$messageSystemStatus       = Status::find(2);
		$autoDjRequestSystemStatus = Status::find(3);

		return $this->renderer->render($response, '/system/system.php', [
			'request' => $request,
			'systems' => [
				'request' => [
					'active' => $requestSystemStatus->active,
					'limit' => $requestSystemStatus->limit,
					'rules' => $requestSystemStatus->rules
				],
				'message' => [
					'active' => $messageSystemStatus->active,
					'limit' => $messageSystemStatus->limit,
					'rules' => $messageSystemStatus->rules
				],
				'autodj_request' => [
					'active' => $autoDjRequestSystemStatus->active,
					'limit' => $autoDjRequestSystemStatus->limit,
					'rules' => $autoDjRequestSystemStatus->rules
				]
			]
		]);
	}
}
