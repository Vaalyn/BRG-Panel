<?php

namespace BRG\Panel\Routes\Frontend\Player\Modal;

use BRG\Panel\Model\Status;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class PlayerSystemModalController {
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

		return $this->renderOfflineModal($request, $response);
	}

	/**
	 * @param Response $response
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
	 * @param Response $response
	 *
	 * @return Response
	 */
	protected function renderMessageModal(Response $response): Response {
		return $this->container->renderer->render($response, '/player/modal/message.php');
	}

	/**
	 * @param Response $response
	 * @param int $limit
	 *
	 * @return Response
	 */
	protected function renderAutoDjRequestModal(Response $response, int $limit): Response {
		return $this->container->renderer->render($response, '/player/modal/request-autodj.php', [
			'limit' => $limit
		]);
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 *
	 * @return Response
	 */
	protected function renderOfflineModal(Request $request, Response $response): Response {
		$baseUrl = sprintf(
			'%s://%s%s',
			$request->getUri()->getScheme(),
			$request->getUri()->getHost(),
			($request->getUri()->getBasePath() !== '') ? $request->getUri()->getBasePath() . '/' : '/'
		);

		return $this->container->renderer->render($response, '/player/modal/request-offline.php', [
			'baseUrl' => $baseUrl
		]);
	}
}
