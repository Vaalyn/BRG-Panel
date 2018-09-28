<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\Authorization;

use BRG\Panel\Service\Authorization\Authorizer\AuthorizerInterface;

interface AuthorizerFactoryInterface {
	/**
	 * @param string $authorizerType
	 *
	 * @return AuthorizerInterface
	 */
	public function create(string $authorizerType): AuthorizerInterface;
}
