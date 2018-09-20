<?php

namespace BRG\Panel\Routes\Api\Dashboard;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use phpseclib\Crypt\RSA;
use phpseclib\Net\SSH2;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class DiscordController {
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
	public function restartLucyLightAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$botServerConfig = $this->config['discord']['bot']['lucy_light']['server'];

		$key = new RSA();
		$key->loadKey(file_get_contents($botServerConfig['ssh_key_path']));

		$ssh = new SSH2($botServerConfig['host']);

		if (!$ssh->login($botServerConfig['user'], $key)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Konnte Bot Server nicht erreichen');

			return $response->write(json_encode($apiResponse));
		}

		$ssh->exec($botServerConfig['command']['restart']);
		$ssh->disconnect();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success');

		return $response->write(json_encode($apiResponse));
	}
}
