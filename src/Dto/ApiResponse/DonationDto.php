<?php

namespace BRG\Panel\Dto\ApiResponse;

use JsonSerializable;

class DonationDto implements JsonSerializable {
	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $amount;

	/**
	 * @param int $id
	 * @param string $name
	 * @param string $amount
	 */
	public function __construct(int $id, string $name, string $amount) {
		$this
			->setId($id)
			->setName($name)
			->setAmount($amount);
	}

	/**
	 * @param int $id
	 *
	 * @return DonationDto
	 */
	public function setId(int $id): DonationDto {
		$this->id = $id;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * @param string $name
	 *
	 * @return DonationDto
	 */
	public function setName(string $name): DonationDto {
		$this->name = $name;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @param string $amount
	 *
	 * @return DonationDto
	 */
	public function setAmount(string $amount): DonationDto {
		$this->amount = $amount;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAmount(): string {
		return $this->amount;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			'id' => $this->getId(),
			'name' => $this->getName(),
			'amount' => $this->getAmount()
		];
	}
}
