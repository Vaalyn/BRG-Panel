<?php

namespace Service\Auth;

use Carbon\Carbon;
use Model\AuthToken;
use Model\User;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;
use WhichBrowser\Parser;

class Auth implements AuthInterface {
	/**
	 * @var \Psr\Container\ContainerInterface
	 */
	private $container;

	/**
	 * @param \Psr\Container\ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
	}

	/**
	 * @return null|\Model\User
	 */
	public function user(): ?User {
		return User::where('user_id', '=', $this->container->session->get('user_id'))->first();
	}

	/**
	 * @return bool
	 */
	public function check(): bool {
		if (!$this->container->session->exists('user_id')) {
			$this->checkLoginCookie();
		}

		if (!User::where('user_id', '=', $this->container->session->get('user_id'))->exists()) {
			$this->logout();
		}

		return $this->container->session->exists('user_id');
	}

	/**
	 * @return bool
	 */
	public function isAdmin(): bool {
		if ($this->user()->is_admin === 1) {
			return true;
		}

		return false;
	}

	/**
	 * @param string $username
	 * @param string $password
	 * @param bool $rememberMe
	 *
	 * @return bool
	 */
	public function attempt(string $username, string $password, bool $rememberMe = false): bool {
		$user = User::where('username', '=', $username)->first();

		if (!isset($user)) {
			return false;
		}

		if (password_verify($password, $user->password)) {
			$this->container->session->set('user_id', $user->user_id);

			if ($rememberMe) {
				$this->setLoginCookie($user);
			}

			return true;
		}

		return false;
	}

	/**
	 * @return void
	 */
	public function invalidateAuthTokens(): void {
		$invalidationDateTime = new Carbon();
		$invalidationDateTime->subSeconds($this->container->config['auth']['cookie']['expire']);

		$authTokens = AuthToken::where('created_at', '<', $invalidationDateTime->toDateTimeString())->get();

		foreach ($authTokens as $authToken) {
			$this->invalidateAuthToken($authToken);
		}
	}

	/**
	 * @param \Model\AuthToken $authToken
	 *
	 * @return void
	 */
	public function invalidateAuthToken(AuthToken $authToken): void {
		$authToken->delete();
	}

	/**
	 * @return void
	 */
	public function logout(): void {
		unset($_COOKIE[$this->container->config['auth']['cookie']['name']]);
		setcookie(
			$this->container->config['auth']['cookie']['name'],
			'',
			time() - 3600,
			'/',
			$this->container->config['auth']['cookie']['domain'],
			$this->container->config['auth']['cookie']['secure'],
			$this->container->config['auth']['cookie']['httponly']
		);

		$this->container->session->destroy();
	}

	/**
	 * @param \Model\User $user
	 *
	 * @return void
	 */
	private function setLoginCookie(User $user): void {
		setcookie(
			$this->container->config['auth']['cookie']['name'],
			json_encode([
				'username' => $user->username,
				'token' => $this->generateLoginCookieToken($user)
			]),
			time() + $this->container->config['auth']['cookie']['expire'],
			'/',
			$this->container->config['auth']['cookie']['domain'],
			$this->container->config['auth']['cookie']['secure'],
			$this->container->config['auth']['cookie']['httponly']
		);
	}

	/**
	 * @param \Model\User $user
	 *
	 * @return string
	 */
	private function generateLoginCookieToken(User $user): string {
		$token = bin2hex(random_bytes(16));

		$browserParser = new Parser(getallheaders());

		$browser = sprintf(
			"Browser: %s\nVersion: %s\nOS: %s\nVersion: %s\nGerät: %s - %s\n",
			$browserParser->browser->name,
			$browserParser->browser->version->value,
			$browserParser->os->alias,
			$browserParser->os->version->nickname,
			$browserParser->device->manufacturer,
			$browserParser->device->model
		);

		$authToken                = new AuthToken();
		$authToken->auth_token_id = Uuid::uuid4()->toString();
		$authToken->user_id       = $user->user_id;
		$authToken->token         = password_hash($token, PASSWORD_DEFAULT);
		$authToken->browser       = $browser;
		$authToken->save();

		$this->container->session->set('auth_token_id', $authToken->auth_token_id);

		return $token;
	}

	/**
	 * @return void
	 */
	private function checkLoginCookie(): void {
		$this->invalidateAuthTokens();

		if (isset($_COOKIE[$this->container->config['auth']['cookie']['name']])) {
			$cookie     = json_decode($_COOKIE[$this->container->config['auth']['cookie']['name']]);
			$authTokens = User::where('username', '=', $cookie->username)->first()->authTokens;

			foreach ($authTokens as $authToken) {
				if (password_verify($cookie->token, $authToken->token)) {
					$this->container->session
						->set('user_id', $authToken->user->user_id)
						->set('auth_token_id', $authToken->auth_token_id);

					break;
				}
			}
		}
	}
}
