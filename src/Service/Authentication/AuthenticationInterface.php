<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\Authentication;

use BRG\Panel\Model\AuthenticationToken;
use BRG\Panel\Model\User;

interface AuthenticationInterface {
	/**
	 * @return null|User
	 */
	public function user(): ?User;

	/**
	 * @return bool
	 */
	public function check(): bool;

	/**
	 * @return bool
	 */
	public function isAdmin(): bool;

	/**
	 * @param string $username
	 * @param string $password
	 * @param bool $rememberMe
	 *
	 * @return bool
	 */
	public function attempt(string $username, string $password, bool $rememberMe = false): bool;

	/**
	 * @return void
	 */
	public function invalidateAuthenticationTokens(): void;

	/**
	 * @param AuthenticationToken $authenticationToken
	 *
	 * @return void
	 */
	public function invalidateAuthenticationToken(AuthenticationToken $authenticationToken): void;

	/**
	 * @return void
	 */
	public function logout(): void;

	/**
	 * @param string $routeName
	 *
	 * @return bool
	 */
	public function routeNeedsAuthentication(string $routeName): bool;
}
