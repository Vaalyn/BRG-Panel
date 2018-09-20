<?php

namespace BRG\Panel\Dto\ApiResponse;

use JsonSerializable;

class StreaminfoDto implements JsonSerializable {
	/**
	 * @var int $id
	 */
	protected $id;

	/**
	 * @var int $trackId
	 */
	protected $trackId;

	/**
	 * @var string $title
	 */
	protected $title;

	/**
	 * @var string $artist
	 */
	protected $artist;

	/**
	 * @var int $listener
	 */
	protected $listener;

	/**
	 * @var string $status
	 */
	protected $status;

	/**
	 * @var string $currentEvent
	 */
	protected $currentEvent;

	/**
	 * @var int $upvotes
	 */
	protected $upvotes;

	/**
	 * @var int $downvotes
	 */
	protected $downvotes;

	/**
	 * @param int $id
	 * @param int $trackId
	 * @param string $title
	 * @param string $artist
	 * @param int $listener
	 * @param string $status
	 * @param string $currentEvent
	 * @param int $upvotes
	 * @param int $downvotes
	 */
	public function __construct(
		int $id,
		int $trackId,
		string $title,
		string $artist,
		int $listener,
		string $status,
		string $currentEvent,
		int $upvotes,
		int $downvotes
	) {
		$this
			->setId($id)
			->setTrackId($trackId)
			->setTitle($title)
			->setArtist($artist)
			->setListener($listener)
			->setStatus($status)
			->setCurrentEvent($currentEvent)
			->setUpvotes($upvotes)
			->setDownvotes($downvotes);
	}

	/**
	 * @param int $id
	 *
	 * @return StreaminfoDto
	 */
	public function setId(int $id): StreaminfoDto {
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
	 * @param int $trackId
	 *
	 * @return StreaminfoDto
	 */
	public function setTrackId(int $trackId): StreaminfoDto {
		$this->trackId = $trackId;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getTrackId(): int {
		return $this->trackId;
	}

	/**
	 * @param string $title
	 *
	 * @return StreaminfoDto
	 */
	public function setTitle(string $title): StreaminfoDto {
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
	 * @return StreaminfoDto
	 */
	public function setArtist(string $artist): StreaminfoDto {
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
	 * @param int $listener
	 *
	 * @return StreaminfoDto
	 */
	public function setListener(int $listener): StreaminfoDto {
		$this->listener = $listener;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getListener(): int {
		return $this->listener;
	}

	/**
	 * @param string $status
	 *
	 * @return StreaminfoDto
	 */
	public function setStatus(string $status): StreaminfoDto {
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
	 * @param string $currentEvent
	 *
	 * @return StreaminfoDto
	 */
	public function setCurrentEvent(string $currentEvent): StreaminfoDto {
		$this->currentEvent = $currentEvent;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCurrentEvent(): string {
		return $this->currentEvent;
	}

	/**
	 * @param int $upvotes
	 *
	 * @return StreaminfoDto
	 */
	public function setUpvotes(int $upvotes): StreaminfoDto {
		$this->upvotes = $upvotes;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getUpvotes(): int {
		return $this->upvotes;
	}

	/**
	 * @param int $downvotes
	 *
	 * @return StreaminfoDto
	 */
	public function setDownvotes(int $downvotes): StreaminfoDto {
		$this->downvotes = $downvotes;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getDownvotes(): int {
		return $this->downvotes;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			'id' => $this->getId(),
			'track_id' => $this->getTrackId(),
			'title' => $this->getTitle(),
			'artist' => $this->getArtist(),
			'listener' => $this->getListener(),
			'status' => $this->getStatus(),
			'current_event' => $this->getCurrentEvent(),
			'upvotes' => $this->getUpvotes(),
			'downvotes' => $this->getDownvotes()
		];
	}
}
