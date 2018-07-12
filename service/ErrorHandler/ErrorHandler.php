<?php

namespace Service\ErrorHandler;

use Closure;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class ErrorHandler {
	/**
	 * @var \Psr\Container\ContainerInterface
	 */
	protected $container;

	/**
	 * @param \Psr\Container\ContainerInterface $container
	 *
	 * @return \Closure
	 */
	public function __invoke(ContainerInterface $container): Closure {
		$this->container = $container;

		return function(Request $request, Response $response, \Throwable $error) {
			return $this->createErrorResponse($response, $error);
		};
	}

	/**
	 * @param \Slim\Http\Response $response
	 * @param \Throwable $error
	 *
	 * @return \Slim\Http\Response
	 */
	private function createErrorResponse(Response $response, \Throwable $error): Response {
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
