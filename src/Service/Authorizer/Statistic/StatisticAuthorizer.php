<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\Authorizer\Statistic;

use BRG\Panel\Model\Role;
use BRG\Panel\Model\User;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Vaalyn\AuthorizationService\AuthorizationUserInterface;
use Vaalyn\AuthorizationService\Authorizer\AuthorizerInterface;

class StatisticAuthorizer implements AuthorizerInterface {
	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
	}

	/**
	 * @inheritDoc
	 */
	public function isAuthorized(?AuthorizationUserInterface $user, ?Request $request): bool {
		/** @var User $userEntity */
		$userEntity = User::find($user->getUserId());

		if ($userEntity === null) {
			return false;
		}

		/** @var Role $role */
		foreach ($userEntity->roles as $role) {
			if ($this->isRoleInAuthorizedRoles($role)) {
				return true;
			}
		}

		return false;
	}

	protected function isRoleInAuthorizedRoles(Role $role): bool {
		foreach ($this->getAuthorizedRoleNames() as $authorizedRoleName) {
			if ($role->role_name === $authorizedRoleName) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @return string[]
	 */
	protected function getAuthorizedRoleNames(): array {
		return [
			'statistic.access'
		];
	}
}
