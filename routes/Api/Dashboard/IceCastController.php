<?php

namespace Routes\Api\Dashboard;

use Dto\ApiResponse\JsonApiResponseDto;
use Exception\InfoException;
use Model\Stream;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class IceCastController {
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
	public function setMetadataToMountpointAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$mountpoint = $args['mountpoint'];
		$song       = trim($request->getParsedBody()['song']) ?? null;

		try {
			if ($this->container->validator::stringType()->length(1, null)->validate($song)) {
				throw new InfoException('Es muss ein Song eingegeben werden');
			}

			if (!Stream::where('mountpoint', '=', $args['mountpoint'])->exists()) {
				throw new InfoException('Invalid mountpoint');
			}

			$this->container->iceCastDataClient->updateMetadataSongForMountpoint($song, $mountpoint);

			$apiResponse = (new JsonApiResponseDto())
				->setStatus('success');

			return $response->write(json_encode($apiResponse));
		}
		catch (InfoException $exception) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage($exception->getMessage());

			return $response->write(json_encode($apiResponse));
		}
	}
}
