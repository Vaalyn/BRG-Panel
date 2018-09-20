<?php

namespace BRG\Panel\Dto\ApiResponse;

use JsonSerializable;

class StatusDto implements JsonSerializable {
	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var bool
	 */
	protected $active;

	/**
	 * @var int
	 */
	protected $limit;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @param int $id
	 * @param bool $active
	 * @param int $limit
	 * @param string $description
	 */
	public function __construct(int $id, bool $active, int $limit, string $description) {
		$this
			->setId($id)
			->setActive($active)
			->setLimit($limit)
			->setDescription($description);
	}

	/**
	 * @param int $id
	 *
	 * @return StatusDto
	 */
	public function setId(int $id): StatusDto {
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
	 * @param bool $active
	 *
	 * @return StatusDto
	 */
	public function setActive(bool $active): StatusDto {
		$this->active = $active;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getActive(): bool {
		return $this->active;
	}

	/**
	 * @param int $limit
	 *
	 * @return StatusDto
	 */
	public function setLimit(int $limit): StatusDto {
		$this->limit = $limit;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getLimit(): int {
		return $this->limit;
	}

	/**
	 * @param string $description
	 *
	 * @return StatusDto
	 */
	public function setDescription(string $description): StatusDto {
		$this->description = $description;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDescription(): string {
		return $this->description;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			'id' => $this->getId(),
			'active' => $this->getActive(),
			'limit' => $this->getLimit(),
			'description' => $this->getDescription()
		];
	}
}
