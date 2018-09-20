<?php

namespace BRG\Panel\Routes\Frontend;

use BRG\Panel\Model\Status;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class DocumentationController {
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
		return $this->container->renderer->render($response, '/documentation/documentation.php', [
			'flashMessages' => $this->container->flash->getMessages(),
			'mountpoints' => $this->container->config['icecast']['mountpoints'],
			'request' => $request,
			'statusList' => Status::get()
		]);
	}
}
