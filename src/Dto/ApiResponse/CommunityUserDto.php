<?php

namespace BRG\Panel\Dto\ApiResponse;

use JsonSerializable;

class CommunityUserDto implements JsonSerializable {
	/**
	 * @var string
	 */
	protected $discordUsername;

	/**
	 * @var string
	 */
	protected $discordUserId;

	/**
	 * @var int
	 */
	protected $coins;

	/**
	 * @param string $discordUsername
	 * @param string $discordUserId
	 * @param int $coins
	 */
	public function __construct(string $discordUsername, string $discordUserId, int $coins) {
		$this
			->setDiscordUsername($discordUsername)
			->setDiscordUserId($discordUserId)
			->setCoins($coins);
	}

	/**
	 * @param string $discordUsername
	 *
	 * @return CommunityUserDto
	 */
	public function setDiscordUsername(string $discordUsername): CommunityUserDto {
		$this->discordUsername = $discordUsername;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDiscordUsername(): string {
		return $this->discordUsername;
	}

	/**
	 * @param string $discordUserId
	 *
	 * @return CommunityUserDto
	 */
	public function setDiscordUserId(string $discordUserId): CommunityUserDto {
		$this->discordUserId = $discordUserId;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDiscordUserId(): string {
		return $this->discordUserId;
	}

	/**
	 * @param string $coins
	 *
	 * @return CommunityUserDto
	 */
	public function setCoins(string $coins): CommunityUserDto {
		$this->coins = $coins;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCoins(): string {
		return $this->coins;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			'discord_username' => $this->getDiscordUsername(),
			'discord_user_id' => $this->getDiscordUserId(),
			'coins' => $this->getCoins()
		];
	}
}
