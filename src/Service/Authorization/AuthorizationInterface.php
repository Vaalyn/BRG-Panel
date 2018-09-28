<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\Authorization;

use BRG\Panel\Model\User;
use Slim\Http\Request;

interface AuthorizationInterface {
	/**
	 * @param string $routeName
	 *
	 * @return bool
	 */
	public function needsAuthorizationForRoute(string $routeName): bool;

	/**
	 * @param User|null $user
	 * @param string $routeName
	 * @param Request $request
	 *
	 * @return bool
	 */
	public function hasAuthorizationForRoute(?User $user, string $routeName, Request $request): bool;
}
