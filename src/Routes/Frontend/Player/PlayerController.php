<?php

namespace BRG\Panel\Routes\Frontend\Player;

use BRG\Panel\Model\Status;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class PlayerController {
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
		$isRequestSystemActive       = Status::find(1)->active;
		$isAutoDjRequestSystemActive = Status::find(3)->active;
		$isMessageSystemActive       = Status::find(2)->active;

		return $this->container->renderer->render($response, '/player/standalone/player.php', [
			'currentPartner' => $request->getQueryParams()['partner'] ?? '',
			'host' => $this->container->config['host']['url'],
			'isRequestSystemActive' => $isRequestSystemActive,
			'isAutoDjRequestSystemActive' => $isAutoDjRequestSystemActive,
			'isMessageSystemActive' => $isMessageSystemActive,
			'mountpoints' => $this->container->config['icecast']['mountpoints'],
			'partners' => $this->container->config['partners'],
			'preSelectedMountpoint' => $request->getQueryParams()['mountpoint'] ?? '',
			'request' => $request
		]);
	}
}
