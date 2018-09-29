<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\Plugin;

use BRG\Panel\Exception\PluginConfigNotFoundException;

interface PluginConfigLoaderInterface {
	/**
	 * @return array
	 *
	 * @throws PluginConfigNotFoundException
	 */
	public function loadPluginConfig(): array;
}
