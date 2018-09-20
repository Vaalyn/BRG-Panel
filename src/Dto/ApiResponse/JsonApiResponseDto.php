<?php

namespace BRG\Panel\Dto\ApiResponse;

use JsonSerializable;

class JsonApiResponseDto implements JsonSerializable {
	/**
	 * @var string
	 */
	protected $status;

	/**
	 * @var string|null
	 */
	protected $message;

	/**
	 * @var mixed
	 */
	protected $result;

	/**
	 * @var int|null
	 */
	protected $pages;

	/**
	 * @param string $status
	 *
	 * @return JsonApiResponseDto
	 */
	public function setStatus(string $status): JsonApiResponseDto {
		$this->status = $status;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getStatus(): string {
		return $this->status;
	}

	/**
	 * @param string|null $message
	 *
	 * @return JsonApiResponseDto
	 */
	public function setMessage(?string $message): JsonApiResponseDto {
		$this->message = $message;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getMessage(): ?string {
		return $this->message;
	}

	/**
	 * @param mixed $result
	 *
	 * @return JsonApiResponseDto
	 */
	public function setResult($result): JsonApiResponseDto {
		$this->result = $result;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * @param int|null $pages
	 *
	 * @return JsonApiResponseDto
	 */
	public function setPages(?int $pages): JsonApiResponseDto {
		$this->pages = $pages;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getPages(): ?int {
		return $this->pages;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			'status' => $this->getStatus(),
			'message' => $this->getMessage(),
			'result' => $this->getResult(),
			'pages' => $this->getPages()
		];
	}
}
