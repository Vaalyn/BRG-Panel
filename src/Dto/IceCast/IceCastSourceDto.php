<?php

namespace BRG\Panel\Dto\IceCast;

class IceCastSourceDto {
	/**
	 * @var string $audioInfo
	 */
	protected $audioInfo;

	/**
	 * @var int $bitrate
	 */
	protected $bitrate;

	/**
	 * @var int $channels
	 */
	protected $channels;

	/**
	 * @var string $genre
	 */
	protected $genre;

	/**
	 * @var int $listenerPeak
	 */
	protected $listenerPeak;

	/**
	 * @var int $listeners
	 */
	protected $listeners;

	/**
	 * @var string $listenurl
	 */
	protected $listenurl;

	/**
	 * @var int $samplerate
	 */
	protected $samplerate;

	/**
	 * @var string $serverDescription
	 */
	protected $serverDescription;

	/**
	 * @var string $serverName
	 */
	protected $serverName;

	/**
	 * @var string $serverType
	 */
	protected $serverType;

	/**
	 * @var string $serverUrl
	 */
	protected $serverUrl;

	/**
	 * @var string $streamStart
	 */
	protected $streamStart;

	/**
	 * @var string $title
	 */
	protected $title;

	/**
	 * @param string $audioInfo
	 * @param int $bitrate
	 * @param int $channels
	 * @param string $genre
	 * @param int $listenerPeak
	 * @param int $listeners
	 * @param string $listenurl
	 * @param int $samplerate
	 * @param string $serverDescription
	 * @param string $serverName
	 * @param string $serverType
	 * @param string $serverUrl
	 * @param string $streamStart
	 * @param string $title
	 */
	public function __construct(
		string $audioInfo,
		int $bitrate,
		int $channels,
		string $genre,
		int $listenerPeak,
		int $listeners,
		string $listenurl,
		int $samplerate,
		string $serverDescription,
		string $serverName,
		string $serverType,
		string $serverUrl,
		string $streamStart,
		string $title
	) {
		$this->setAudioInfo($audioInfo)
			->setBitrate($bitrate)
			->setChannels($channels)
			->setGenre($genre)
			->setListenerPeak($listenerPeak)
			->setListeners($listeners)
			->setListenurl($listenurl)
			->setSamplerate($samplerate)
			->setServerDescription($serverDescription)
			->setServerName($serverName)
			->setServerType($serverType)
			->setServerUrl($serverUrl)
			->setStreamStart($streamStart)
			->setTitle($title);
	}

	/**
	 * @return string
	 */
	public function getAudioInfo(): string {
		return $this->audioInfo;
	}

	/**
	 * @param string $audioInfo
	 *
	 * @return IceCastSourceDto
	 */
	public function setAudioInfo(string $audioInfo): IceCastSourceDto {
		$this->audioInfo = $audioInfo;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getBitrate(): int {
		return $this->bitrate;
	}

	/**
	 * @param int $bitrate
	 *
	 * @return IceCastSourceDto
	 */
	public function setBitrate(int $bitrate): IceCastSourceDto {
		$this->bitrate = $bitrate;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getChannels(): int {
		return $this->channels;
	}

	/**
	 * @param int $channels
	 *
	 * @return IceCastSourceDto
	 */
	public function setChannels(int $channels): IceCastSourceDto {
		$this->channels = $channels;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getGenre(): string {
		return $this->genre;
	}

	/**
	 * @param string $genre
	 *
	 * @return IceCastSourceDto
	 */
	public function setGenre(string $genre): IceCastSourceDto {
		$this->genre = $genre;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getListenerPeak(): int {
		return $this->listenerPeak;
	}

	/**
	 * @param int $listenerPeak
	 *
	 * @return IceCastSourceDto
	 */
	public function setListenerPeak(int $listenerPeak): IceCastSourceDto {
		$this->listenerPeak = $listenerPeak;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getListeners(): int {
		return $this->listeners;
	}

	/**
	 * @param int $listeners
	 *
	 * @return IceCastSourceDto
	 */
	public function setListeners(int $listeners): IceCastSourceDto {
		$this->listeners = $listeners;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getListenurl(): string {
		return $this->listenurl;
	}

	/**
	 * @param string $listenurl
	 *
	 * @return IceCastSourceDto
	 */
	public function setListenurl(string $listenurl): IceCastSourceDto {
		$this->listenurl = $listenurl;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getSamplerate(): int {
		return $this->samplerate;
	}

	/**
	 * @param int $samplerate
	 *
	 * @return IceCastSourceDto
	 */
	public function setSamplerate(int $samplerate): IceCastSourceDto {
		$this->samplerate = $samplerate;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getServerDescription(): string {
		return $this->serverDescription;
	}

	/**
	 * @param string $serverDescription
	 *
	 * @return IceCastSourceDto
	 */
	public function setServerDescription(string $serverDescription): IceCastSourceDto {
		$this->serverDescription = $serverDescription;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getServerName(): string {
		return $this->serverName;
	}

	/**
	 * @param string $serverName
	 *
	 * @return IceCastSourceDto
	 */
	public function setServerName(string $serverName): IceCastSourceDto {
		$this->serverName = $serverName;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getServerType(): string {
		return $this->serverType;
	}

	/**
	 * @param string $serverType
	 *
	 * @return IceCastSourceDto
	 */
	public function setServerType(string $serverType): IceCastSourceDto {
		$this->serverType = $serverType;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getServerUrl(): string {
		return $this->serverName;
	}

	/**
	 * @param string $serverUrl
	 *
	 * @return IceCastSourceDto
	 */
	public function setServerUrl(string $serverUrl): IceCastSourceDto {
		$this->serverUrl = $serverUrl;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getStreamStart(): string {
		return $this->streamStart;
	}

	/**
	 * @param string $streamStart
	 *
	 * @return IceCastSourceDto
	 */
	public function setStreamStart(string $streamStart): IceCastSourceDto {
		$this->streamStart = $streamStart;

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
	 * @return IceCastSourceDto
	 */
	public function setTitle(string $title): IceCastSourceDto {
		$this->title = $title;

		return $this;
	}
}
