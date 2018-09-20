<?php

namespace BRG\Panel\Routes\Frontend;

use BRG\Panel\Model\Status;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class DocumentationController {
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
		$this->config   = $container->config;
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
		return $this->renderer->render($response, '/documentation/documentation.php', [
			'mountpoints' => $this->config['icecast']['mountpoints'],
			'request' => $request,
			'statusList' => Status::get()
		]);
	}
}
