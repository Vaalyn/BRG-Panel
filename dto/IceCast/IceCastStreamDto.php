<?php

namespace Dto\IceCast;

class IceCastStreamDto {
	/**
	 * @var string $host
	 */
	protected $host;

	/**
	 * @var \Dto\IceCast\IceCastSourceDto[] $sources
	 */
	protected $sources;

	/**
	 * @param string $host
	 * @param \Dto\IceCast\IceCastSourceDto[] $sources
	 */
	public function __construct(string $host, array $sources = []) {
		$this->setHost($host)
			->setSources($sources);
	}

	/**
	 * @return string
	 */
	public function getHost(): string {
		return $this->host;
	}

	/**
	 * @param string $host
	 *
	 * @return \Dto\IceCast\IceCastStreamDto
	 */
	public function setHost(string $host): IceCastStreamDto {
		$this->host = $host;

		return $this;
	}

	/**
	 * @return \Dto\IceCast\IceCastSourceDto[]
	 */
	public function getSources(): array {
		return $this->sources;
	}

	/**
	 * @param \Dto\IceCast\IceCastSourceDto[] $sources
	 *
	 * @return \Dto\IceCast\IceCastStreamDto
	 */
	public function setSources(array $sources): IceCastStreamDto {
		$this->sources = [];

		foreach ($sources as $source) {
			$this->addSource($source);
		}

		return $this;
	}

	/**
	 * @param \Dto\IceCast\IceCastSourceDto $iceCastSourceDto
	 *
	 * @return \Dto\IceCast\IceCastStreamDto
	 */
	public function addSource(IceCastSourceDto $iceCastSourceDto): IceCastStreamDto {
		$this->sources[] = $iceCastSourceDto;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getListeners(): int {
		$listeners = 0;

		foreach ($this->getSources() as $source) {
			$listeners += $source->getListeners();
		}

		return $listeners;
	}

	/**
	 * @return string
	 */
	public function getArtist(): string {
		$artist = '';

		foreach ($this->getSources() as $source) {
			$sourceTitle = $source->getTitle();

			if ($sourceTitle === '') {
				continue;
			}

			$titleParts = explode(' - ', $sourceTitle);

			$artist = array_shift($titleParts);

			break;
		}

		return $artist;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string {
		$title = '';

		foreach ($this->getSources() as $source) {
			$sourceTitle = $source->getTitle();

			if ($sourceTitle === '') {
				continue;
			}

			$titleParts = explode(' - ', $sourceTitle);

			array_shift($titleParts);

			$title = implode(' - ', $titleParts);

			break;
		}

		return $title;
	}
}
