<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\Authorization\Authorizer;

use BRG\Panel\Model\User;
use BRG\Panel\Model\AuthorizationToken;
use Slim\Http\Request;

class AuthorizationTokenAuthorizer implements AuthorizerInterface {
	public const AUTHORIZATION_TOKEN_PARAMETER = 'authorizationToken';

	/**
	 * @inheritDoc
	 */
	public function isAuthorized(?User $user, ?Request $request): bool {
		$authorizationTokenValue = $request->getQueryParam(self::AUTHORIZATION_TOKEN_PARAMETER);

		if ($authorizationTokenValue === null) {
			return false;
		}

		$authorizationTokens = AuthorizationToken::get();

		foreach ($authorizationTokens as $authorizationToken) {
			if (!password_verify($authorizationTokenValue, $authorizationToken->token)) {
				continue;
			}
			
			foreach ($authorizationToken->authorizedRoutes as $authorizedRoute) {
				if ($authorizedRoute->route_name === $this->getRouteNameFromRequest($request)) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	protected function getRouteNameFromRequest(Request $request): string {
		$currentRoute = $request->getAttribute('route');

		if ($currentRoute === null) {
			return '';
		}

		return $currentRoute->getName();
	}
}
