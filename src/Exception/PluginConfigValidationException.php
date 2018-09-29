<?php

declare(strict_types = 1);

namespace BRG\Panel\Exception;

class PluginConfigValidationException extends \Exception {
	/**
	 * @var string[]
	 */
	protected $validationErrors;

	/**
	 * @return string[]
	 */
	public function getValidationErrors(): array {
		return $this->validationErrors;
	}

	/**
	 * @param string $error
	 *
	 * @return PluginConfigValidationException
	 */
	public function addValidationError(string $error): PluginConfigValidationException {
		if ($this->validationErrors === null) {
			$this->validationErrors = [];
		}

		$this->validationErrors[] = $error;

		$this->updateErrorMessage();

		return $this;
	}

	/**
	 * @return void
	 */
	protected function updateErrorMessage(): void {
		$errorMessage = sprintf(
			'Validation of plugin config failed due to the following validation errors:%s%s',
			PHP_EOL,
			implode(PHP_EOL, $this->validationErrors)
		);

		$this->message = $errorMessage;
	}
}
