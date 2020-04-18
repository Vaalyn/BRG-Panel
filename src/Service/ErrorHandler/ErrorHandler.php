<?php

namespace BRG\Panel\Service\ErrorHandler;

use Closure;
use Throwable;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class ErrorHandler {
	/**
	 * @var array
	 */
	protected $settings;

	public function __construct($container) {
		$this->settings = $container->settings;
	}

	/**
	 * @param Response $response
	 * @param Throwable $error
	 *
	 * @return Response
	 */
	public function createErrorResponse(Response $response, \Throwable $exception): Response {
		$message = 'Beim Verarbeiten der Anfrage ist ein Fehler aufgetreten.';

		if ($this->settings['displayErrorDetails']) {
			$message .= '<pre>' . $exception . '</pre>';
		}

		return $response
			->withStatus(500)
			->withHeader('Content-Type', 'text/html')
			->write($message);
	}
}
