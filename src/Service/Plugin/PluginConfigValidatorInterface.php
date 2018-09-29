<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\Plugin;

use BRG\Panel\Exception\PluginConfigValidationException;

interface PluginConfigValidatorInterface {
	/**
	 * @param array $config
	 *
	 * @return void
	 *
	 * @throws PluginConfigValidationException
	 */
	public function validate(array $config): void;
}
