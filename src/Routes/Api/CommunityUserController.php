<?php

namespace BRG\Panel\Routes\Api;

use BRG\Panel\Dto\ApiResponse\CommunityUserDto;
use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Exception\InfoException;
use BRG\Panel\Model\CommunityUser;
use BRG\Panel\Model\Manager\CommunityUserModelManager;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class CommunityUserController {
	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function getCoinsAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$discordUserId = $args['discordUserId'];

		$communityUser = CommunityUser::where('discord_user_id', '=', $discordUserId)->first();

		$communityUserDto = new CommunityUserDto(
			$communityUser->discord_username ?? '',
			$discordUserId,
			$communityUser->coins ?? 0
		);

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success')
			->setResult($communityUserDto);

		return $response->write(json_encode($apiResponse));
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function addCoinsAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$discordUsername = $request->getParsedBody()['discordUsername'] ?? '';
		$discordUserId   = $request->getParsedBody()['discordUserId'] ?? '';
		$coins           = (int) $request->getParsedBody()['coins'] ?? 0;

		try {
			if ($coins === null) {
				throw new InfoException('No coins provided');
			}

			$communityUserModelManager = new CommunityUserModelManager();

			$communityUser = CommunityUser::where('discord_user_id', '=', $discordUserId)->first();

			if (!isset($communityUser)) {
				$communityUser = $communityUserModelManager->createCommunityUser(
					$discordUserId,
					$discordUsername
				);
			}
			else {
				$communityUser = $communityUserModelManager->updateCommunityUser(
					$discordUserId,
					$discordUsername
				);
			}

			$communityUserModelManager->addCoinsToCommunityUser($communityUser, $coins);

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

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function removeCoinsAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$discordUsername = $request->getParsedBody()['discordUsername'] ?? '';
		$discordUserId   = $request->getParsedBody()['discordUserId'] ?? '';
		$coins           = (int) $request->getParsedBody()['coins'] ?? 0;

		try {
			if ($coins === null) {
				throw new InfoException('No coins provided');
			}

			$communityUserModelManager = new CommunityUserModelManager();

			$communityUser = CommunityUser::where('discord_user_id', '=', $discordUserId)->first();

			if (!isset($communityUser)) {
				$communityUser = $communityUserModelManager->createCommunityUser(
					$discordUserId,
					$discordUsername
				);
			}

			$communityUserModelManager->removeCoinsFromCommunityUser($communityUser, $coins);

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
