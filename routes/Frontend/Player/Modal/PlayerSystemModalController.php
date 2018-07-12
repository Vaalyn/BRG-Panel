<?php

namespace Routes\Frontend\Player\Modal;

use Model\Status;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class PlayerSystemModalController {
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
		$requestSystemStatus = Status::find(1);

		if ($requestSystemStatus->active) {
			return $this->renderRequestModal(
				$response,
				$requestSystemStatus->limit
			);
		}

		$messageSystemStatus = Status::find(2);

		if ($messageSystemStatus->active) {
			return $this->renderMessageModal($response);
		}

		$autoDjRequestSystemStatus = Status::find(3);

		if ($autoDjRequestSystemStatus->active) {
			return $this->renderAutoDjRequestModal(
				$response,
				$autoDjRequestSystemStatus->limit
			);
		}

		return $this->container->renderer->render($response, '/player/modal/request-offline.php');
	}

	/**
	 * @param \Slim\Http\Response $response
	 * @param int $limit
	 *
	 * @return Response
	 */
	protected function renderRequestModal(Response $response, int $limit): Response {
		return $this->container->renderer->render($response, '/player/modal/request.php', [
			'limit' => $limit
		]);
	}

	/**
	 * @param \Slim\Http\Response $response
	 *
	 * @return Response
	 */
	protected function renderMessageModal(Response $response): Response {
		return $this->container->renderer->render($response, '/player/modal/message.php');
	}

	/**
	 * @param \Slim\Http\Response $response
	 * @param int $limit
	 *
	 * @return Response
	 */
	protected function renderAutoDjRequestModal(Response $response, int $limit): Response {
		return $this->container->renderer->render($response, '/player/modal/request-autodj.php', [
			'limit' => $limit
		]);
	}
}
