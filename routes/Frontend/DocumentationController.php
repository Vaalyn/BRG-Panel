<?php

namespace Routes\Frontend;

use Model\Status;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class DocumentationController {
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
		return $this->container->renderer->render($response, '/documentation/documentation.php', [
			'flashMessages' => $this->container->flash->getMessages(),
			'mountpoints' => $this->container->config['icecast']['mountpoints'],
			'request' => $request,
			'statusList' => Status::get()
		]);
	}
}
