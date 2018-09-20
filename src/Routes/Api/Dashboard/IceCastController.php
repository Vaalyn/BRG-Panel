<?php

namespace BRG\Panel\Routes\Api\Dashboard;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Exception\InfoException;
use BRG\Panel\Model\Stream;
use BRG\Panel\Service\IceCast\IceCastDataClient;
use Psr\Container\ContainerInterface;
use Respect\Validation\Validator;
use Slim\Http\Request;
use Slim\Http\Response;

class IceCastController {
	/**
	 * @var IceCastDataClient
	 */
	protected $iceCastDataClient;

	/**
	 * @var Validator
	 */
	protected $validator;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->iceCastDataClient = $container->iceCastDataClient;
		$this->validator         = $container->validator;
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function setMetadataToMountpointAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$mountpoint = $args['mountpoint'];
		$song       = trim($request->getParsedBody()['song']) ?? null;

		try {
			if (!$this->validator::stringType()->length(1, null)->validate($song)) {
				throw new InfoException('Es muss ein Song eingegeben werden');
			}

			if (!Stream::where('mountpoint', '=', $args['mountpoint'])->exists()) {
				throw new InfoException('Invalid mountpoint');
			}

			$this->iceCastDataClient->updateMetadataSongForMountpoint($song, $mountpoint);

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
