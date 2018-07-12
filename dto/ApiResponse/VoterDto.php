<?php

namespace Dto\ApiResponse;

use JsonSerializable;

class VoterDto implements JsonSerializable {
	/**
	 * @var bool
	 */
	protected $voterId;

	/**
	 * @param string $voterId
	 */
	public function __construct(string $voterId) {
		$this->setVoterId($voterId);
	}

	/**
	 * @param string $voterId
	 *
	 * @return \Dto\ApiResponse\VoterDto
	 */
	public function setVoterId(string $voterId): VoterDto {
		$this->voterId = $voterId;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getVoterId(): string {
		return $this->voterId;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			'voter_id' => $this->getVoterId()
		];
	}
}
