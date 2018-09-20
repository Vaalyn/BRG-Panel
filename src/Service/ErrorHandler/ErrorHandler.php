<?php

namespace BRG\Panel\Service\ErrorHandler;

use Closure;
use Throwable;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class ErrorHandler {
	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @param ContainerInterface $container
	 *
	 * @return Closure
	 */
	public function __invoke(ContainerInterface $container): Closure {
		$this->container = $container;

		return function(Request $request, Response $response, \Throwable $error) {
			return $this->createErrorResponse($response, $error);
		};
	}

	/**
	 * @param Response $response
	 * @param Throwable $error
	 *
	 * @return Response
	 */
	private function createErrorResponse(Response $response, Throwable $error): Response {
		$message = 'Beim Verarbeiten der Anfrage ist ein Fehler aufgetreten.';

		if ($this->container->settings['displayErrorDetails']) {
			$message .= '<pre>' . $error . '</pre>';
		}

		return $response
			->withStatus(500)
			->withHeader('Content-Type', 'text/html')
			->write($message);
	}
}
