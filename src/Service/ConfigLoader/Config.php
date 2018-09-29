<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\ConfigLoader;

class Config implements ConfigInterface {
	/**
	 * @var array
	 */
	protected $config;

	/**
	 * @param array $config
	 */
	public function __construct(array $config = []) {
		$this->setConfig($config);
	}

	/**
	 * @inheritDoc
	 */
	public function getConfig(): array {
		return $this->config;
	}

	/**
	 * @inheritDoc
	 */
	public function setConfig(array $config): ConfigInterface {
		$this->config = $config;

		return $this;
	}
}
