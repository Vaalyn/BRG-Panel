<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\Authorization;

use BRG\Panel\Exception\UnknownAuthorizerException;
use BRG\Panel\Service\Authorization\Authorizer\AuthorizerInterface;

class AuthorizerFactory implements AuthorizerFactoryInterface {
	/**
	 * @var array
	 */
	protected $authorizers;

	/**
	 * @param array $authorizers
	 */
	public function __construct(array $authorizers) {
		$this->authorizers = $authorizers;
	}

	/**
	 * @inheritDoc
	 */
	public function create(string $authorizerType): AuthorizerInterface {
		if (!array_key_exists($authorizerType, $this->authorizers)) {
			throw new UnknownAuthorizerException(
				sprintf(
					'There is no known Authorizer of the type %s',
					$authorizerType
				)
			);
		}

		$authorizerClass = $this->authorizers[$authorizerType];

		$authorizer = new $authorizerClass;

		return $authorizer;
	}
}
