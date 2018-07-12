<?php

namespace Service\Auth;

use Model\User;
use Psr\Container\ContainerInterface;

interface AuthInterface {
	/**
	 * @param \Psr\Container\ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container);

	/**
	 * @return null|\Model\User
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
	public function logout(): void;
}
