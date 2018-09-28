<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\Authorization;

use BRG\Panel\Model\User;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;

class Authorization implements AuthorizationInterface {
	/**
	 * @var array
	 */
	protected $routesWithAuthorization;

	/**
	 * @var AuthorizerFactory
	 */
	protected $authorizerFactory;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->routesWithAuthorization = $container->config['authorization']['routes'];
		$this->authorizerFactory       = new AuthorizerFactory($container->config['authorization']['authorizers']);
	}

	/**
	 * @inheritDoc
	 */
	public function needsAuthorizationForRoute(string $routeName): bool {
		return array_key_exists($routeName, $this->routesWithAuthorization);
	}

	/**
	 * @inheritDoc
	 */
	public function hasAuthorizationForRoute(?User $user, string $routeName, Request $request): bool {
		if (!$this->needsAuthorizationForRoute($routeName)) {
			return true;
		}

		foreach ($this->routesWithAuthorization[$routeName] as $authorizerType) {
			$authorizer = $this->authorizerFactory->create($authorizerType);

			if ($authorizer->isAuthorized($user, $request)) {
				return true;
			}
		}

		return false;
	}
}
