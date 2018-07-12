<?php

namespace Model\Manager;

use Exception\InfoException;
use Model\CoinEvent;
use Model\CommunityUser;

class CommunityUserModelManager {
	/**
	 * @param string $discordUserId
	 * @param string $discordUsername
	 *
	 * @return \Model\CommunityUser
	 */
	public function createCommunityUser(string $discordUserId, string $discordUsername): CommunityUser {
		$this->validateCommunityUserArguments($discordUserId, $discordUsername);

		$communityUser                   = new CommunityUser();
		$communityUser->discord_username = $discordUsername;
		$communityUser->discord_user_id  = $discordUserId;
		$communityUser->coins            = 0;
		$communityUser->save();

		return $communityUser;
	}

	/**
	 * @param string $discordUserId
	 * @param string $discordUsername
	 *
	 * @return \Model\CommunityUser
	 */
	public function updateCommunityUser(string $discordUserId, string $discordUsername): CommunityUser {
		$this->validateCommunityUserArguments($discordUserId, $discordUsername);

		$communityUser = CommunityUser::where('discord_user_id', '=', $discordUserId)->first();

		if (!isset($communityUser)) {
			throw new InfoException('Community User nicht gefunden');
		}

		$communityUser->discord_username = $discordUsername;
		$discordUsername->save();

		return $communityUser;
	}

	/**
	 * @param \Model\CommunityUser $communityUser
	 * @param int $coins
	 *
	 * @return void
	 */
	public function addCoinsToCommunityUser(CommunityUser $communityUser, int $coins): void {
		$communityUser->coins += $coins;
		$communityUser->save();

		$this->createCoinEvent($communityUser, $coins, 'add');
	}

	/**
	 * @param \Model\CommunityUser $communityUser
	 * @param int $coins
	 *
	 * @return void
	 */
	public function removeCoinsFromCommunityUser(CommunityUser $communityUser, int $coins): void {
		if ($communityUser->coins < $coins) {
			$coins = $communityUser->coins;
		}

		$communityUser->coins -= $coins;
		$communityUser->save();

		$this->createCoinEvent($communityUser, $coins, 'remove');
	}

	/**
	 * @param \Model\CommunityUser $communityUser
	 * @param int $coins
	 * @param string $event
	 *
	 * @return \Model\CoinEvent
	 */
	protected function createCoinEvent(
		CommunityUser $communityUser,
		int $coins,
		string $event
	): CoinEvent {
		$coinEvent                    = new CoinEvent();
		$coinEvent->event             = $event;
		$coinEvent->coins             = $coins;
		$coinEvent->community_user_id = $communityUser->community_user_id;
		$coinEvent->save();

		return $coinEvent;
	}

	/**
	 * @param string $discordUserId
	 * @param string $discordUsername
	 *
	 * @return void
	 */
	protected function validateCommunityUserArguments(string $discordUserId, string $discordUsername): void {
		if ($discordUsername === '') {
			throw new InfoException('No discord username provided');
		}

		if ($discordUserId === '') {
			throw new InfoException('No discord user id provided');
		}
	}
}
