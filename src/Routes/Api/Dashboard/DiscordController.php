<?php

namespace BRG\Panel\Routes\Api\Dashboard;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Exception\UnableToConnectException;
use phpseclib3\Net\SSH2;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class DiscordController {
	/**
	 * @var array
	 */
	protected $discordConfig;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->discordConfig = $container->config['discord'];
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function restartLucyLightAction(Request $request, Response $response, array $args): Response {
		$botServerConfig = $this->discordConfig['bot']['lucy_light']['server'];

		$key = PublicKeyLoader::load(file_get_contents($botServerConfig['ssh_key_path']));

		$ssh = new SSH2($botServerConfig['host']);

		try {
			$isLoggedIn = $ssh->login($botServerConfig['user'], $key);
		}
		catch (UnableToConnectException $exception) {
			$isLoggedIn = false;
		}

		if (!$isLoggedIn) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Konnte Bot Server nicht erreichen');

			return $response->write(json_encode($apiResponse));
		}

		$ssh->exec($botServerConfig['command']['restart']);
		$ssh->disconnect();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success');

		return $response->withJson($apiResponse);
	}
}
