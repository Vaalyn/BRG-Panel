<?php

declare(strict_types = 1);

namespace BRG\Panel\Middleware\PaginationLinkParameters;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class PaginationLinkParametersMiddleware {
	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
    }

	/**
	 * @param Request  $request
	 * @param Response $response
	 * @param callable $next
	 *
	 * @return Response
	 */
	public function __invoke(Request $request, Response $response, callable $next): Response {
		$parameters = $request->getQueryParams();

		if (count($parameters) === 0) {
			return $next($request, $response);
		}

		$urlEncodedParameters = [];

		foreach ($parameters as $parameter => $value) {
			$urlEncodedParameters[] = urlencode($parameter) . '=' . urlencode($value);
		}

		$request = $request->withAttribute(
			'paginationLinkParameters',
			implode('&', $urlEncodedParameters)
		);

		return $next($request, $response);
	}
}
