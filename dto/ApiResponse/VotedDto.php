<?php

namespace Dto\ApiResponse;

use JsonSerializable;

class VotedDto implements JsonSerializable {
	/**
	 * @var bool
	 */
	protected $voted;

	/**
	 * @var string
	 */
	protected $direction;

	/**
	 * @param bool $voted
	 * @param string $direction
	 */
	public function __construct(bool $voted, string $direction) {
		$this
			->setVoted($voted)
			->setDirection($direction);
	}

	/**
	 * @param bool $voted
	 *
	 * @return \Dto\ApiResponse\VotedDto
	 */
	public function setVoted(bool $voted): VotedDto {
		$this->voted = $voted;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getVoted(): bool {
		return $this->voted;
	}

	/**
	 * @param string $direction
	 *
	 * @return \Dto\ApiResponse\VotedDto
	 */
	public function setDirection(string $direction): VotedDto {
		$this->direction = $direction;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDirection(): string {
		return $this->direction;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			'voted' => $this->getVoted(),
			'direction' => $this->getDirection()
		];
	}
}
