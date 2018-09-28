<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\Authorization\Authorizer;

use BRG\Panel\Model\User;
use Slim\Http\Request;

class AdminAuthorizer implements AuthorizerInterface {
	/**
	 * @inheritDoc
	 */
	public function isAuthorized(?User $user, ?Request $request): bool {
		if ($user === null) {
			return false;
		}

		if ($user->is_admin) {
			return true;
		}

		return false;
	}
}
