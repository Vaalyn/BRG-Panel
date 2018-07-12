<?php

namespace Service\Session;

class Session {
	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @param array $settings
	 */
	public function __construct(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function get(string $key) {
		return $this->exists($key) ? $_SESSION[$key] : null;
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 *
	 * @return \Service\Session\Session
	 */
	public function set(string $key, $value): Session {
		$_SESSION[$key] = $value;

		return $this;
	}

	/**
	 * @param string $key
	 *
	 * @return \Service\Session\Session
	 */
	public function delete(string $key): Session {
		if ($this->exists($key)) {
			unset($_SESSION[$key]);
		}

		return $this;
	}

	/**
	 * @return \Service\Session\Session
	 */
	public function clear(): Session {
		$_SESSION = [];

		return $this;
	}

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function exists(string $key): bool {
		return array_key_exists($key, $_SESSION);
	}

	/**
	 * @return string
	 */
	public function getId(): string {
		return session_id();
	}

	/**
	 * @return \Service\Session\Session
	 */
	public function start(): Session {
		session_set_cookie_params(
			$this->settings['lifetime'],
			$this->settings['path'],
			$this->settings['domain'],
			$this->settings['secure'],
			$this->settings['httponly']
		);

		session_name($this->settings['name']);
		session_cache_limiter(false);
		session_start();

		setcookie(
			session_name(),
			session_id(),
			time() + $this->settings['lifetime'],
			$this->settings['path'],
			$this->settings['domain'],
			$this->settings['secure'],
			$this->settings['httponly']
		);

		return $this;
	}

	/**
	 * @return void
	 */
	public function destroy(): void {
		if ($this->getId()) {
			session_unset();
			session_destroy();
			session_write_close();

			if (ini_get('session.use_cookies')) {
				$params = session_get_cookie_params();
				setcookie(
					session_name(),
					'',
					time() - 4200,
					$params['path'],
					$params['domain'],
					$params['secure'],
					$params['httponly']
				);
			}
		}
	}
}
