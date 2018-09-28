<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\Authorization\Authorizer;

use BRG\Panel\Model\User;
use Slim\Http\Request;

interface AuthorizerInterface {
	/**
	 * @param User|null $user
	 * @param Request|null $request
	 *
	 * @return bool
	 */
	public function isAuthorized(?User $user, ?Request $request): bool;
}
