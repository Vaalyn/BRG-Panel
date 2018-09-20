<?php

namespace BRG\Panel\Dto\ApiResponse;

use JsonSerializable;

class TrackDto implements JsonSerializable {
	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $artist;

	/**
	 * @param int $id
	 * @param string $title
	 * @param string $artist
	 */
	public function __construct(int $id, string $title, string $artist) {
		$this
			->setId($id)
			->setTitle($title)
			->setArtist($artist);
	}

	/**
	 * @param int $id
	 *
	 * @return TrackDto
	 */
	public function setId(int $id): TrackDto {
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
	 * @param string $title
	 *
	 * @return TrackDto
	 */
	public function setTitle(string $title): TrackDto {
		$this->title = $title;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * @param string $artist
	 *
	 * @return TrackDto
	 */
	public function setArtist(string $artist): TrackDto {
		$this->artist = $artist;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getArtist(): string {
		return $this->artist;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			'id' => $this->getId(),
			'title' => $this->getTitle(),
			'artist' => $this->getArtist()
		];
	}
}
