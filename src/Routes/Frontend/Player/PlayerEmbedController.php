<?php

namespace BRG\Panel\Routes\Frontend\Player;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class PlayerEmbedController {
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
		return $this->container->renderer->render($response, '/player/embed/player.php', [
			'auth' => $this->container->auth,
			'host' => $this->container->config['host']['url'],
			'mountpoints' => $this->container->config['icecast']['mountpoints'],
			'preSelectedMountpoint' => $request->getQueryParams()['mountpoint'] ?? '',
			'request' => $request
		]);
	}
}
