<?php

namespace BRG\Panel\Routes\Frontend\Player\Modal;

use BRG\Panel\Model\Status;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class PlayerSystemModalController {
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
		$requestSystemStatus = Status::find(1);

		if ($requestSystemStatus->active) {
			return $this->renderRequestModal(
				$response,
				$requestSystemStatus
			);
		}

		$messageSystemStatus = Status::find(2);

		if ($messageSystemStatus->active) {
			return $this->renderMessageModal(
				$response,
				$messageSystemStatus
			);
		}

		$autoDjRequestSystemStatus = Status::find(3);

		if ($autoDjRequestSystemStatus->active) {
			return $this->renderAutoDjRequestModal(
				$response,
				$autoDjRequestSystemStatus
			);
		}

		return $this->renderOfflineModal($request, $response);
	}

	/**
	 * @param Response $response
	 * @param Status $systemStatus
	 *
	 * @return Response
	 */
	protected function renderRequestModal(Response $response, Status $systemStatus): Response {
		return $this->renderer->render($response, '/player/modal/request.php', [
			'limit' => $systemStatus->limit,
			'rules' => $systemStatus->rules
		]);
	}

	/**
	 * @param Response $response
	 * @param Status $systemStatus
	 *
	 * @return Response
	 */
	protected function renderMessageModal(Response $response, Status $systemStatus): Response {
		return $this->renderer->render($response, '/player/modal/message.php', [
			'rules' => $systemStatus->rules
		]);
	}

	/**
	 * @param Response $response
	 * @param Status $systemStatus
	 *
	 * @return Response
	 */
	protected function renderAutoDjRequestModal(Response $response, Status $systemStatus): Response {
		return $this->renderer->render($response, '/player/modal/request-autodj.php', [
			'limit' => $systemStatus->limit,
			'rules' => $systemStatus->rules
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

		return $this->renderer->render($response, '/player/modal/request-offline.php', [
			'baseUrl' => $baseUrl
		]);
	}
}
