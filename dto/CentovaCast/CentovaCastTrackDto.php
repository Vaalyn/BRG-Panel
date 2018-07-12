<?php

namespace Dto\CentovaCast;

class CentovaCastTrackDto {
	/**
	 * @var int $time
	 */
	protected $time;

	/**
	 * @var string
	 */
	protected $artist;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @param int $time
	 * @param string $artist
	 * @param string $title
	 */
	public function __construct(int $time, string $artist, string $title) {
		$this
			->setTime($time)
			->setArtist($artist)
			->setTitle($title);
	}

	/**
	 * @return int
	 */
	public function getTime(): int {
		return $this->time;
	}

	/**
	 * @param int $time
	 *
	 * @return \Dto\CentovaCast\CentovaCastTrackDto
	 */
	public function setTime(int $time): CentovaCastTrackDto {
		$this->time = $time;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getArtist(): string {
		return $this->artist;
	}

	/**
	 * @param string $artist
	 *
	 * @return \Dto\CentovaCast\CentovaCastTrackDto
	 */
	public function setArtist(string $artist): CentovaCastTrackDto {
		$this->artist = $artist;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * @param string $title
	 *
	 * @return \Dto\CentovaCast\CentovaCastTrackDto
	 */
	public function setTitle(string $title): CentovaCastTrackDto {
		$this->title = $title;

		return $this;
	}
}
