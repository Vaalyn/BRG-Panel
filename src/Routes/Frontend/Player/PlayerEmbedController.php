<?php

namespace BRG\Panel\Routes\Frontend\Player;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;
use Vaalyn\AuthenticationService\AuthenticationInterface;

class PlayerEmbedController {
	/**
	 * @var AuthenticationInterface
	 */
	protected $authentication;

	/**
	 * @var array
	 */
	protected $config;

	/**
	 * @var PhpRenderer
	 */
	protected $renderer;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->authentication = $container->authentication;
		$this->config         = $container->config;
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
		return $this->renderer->render($response, '/player/embed/player.php', [
			'authentication' => $this->authentication,
			'host' => $this->config['host']['url'],
			'mountpoints' => $this->config['icecast']['mountpoints'],
			'preSelectedMountpoint' => $request->getQueryParams()['mountpoint'] ?? '',
			'request' => $request
		]);
	}
}
