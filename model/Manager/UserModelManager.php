<?php

namespace Model\Manager;

use Exception\InfoException;
use ZxcvbnPhp\Zxcvbn;

class UserModelManager {
	/**
	 * @param string $password
	 *
	 * @return void
	 */
	public function validatePassword(string $password): void {
		if (trim($password) === '') {
			throw new InfoException('Es muss ein Passwort eingegeben werden');
		}

		if ($this->getPasswordStrength($password) < 2) {
			throw new InfoException('Das Passwort ist zu unsicher');
		}
	}

	/**
	 * @param string $password
	 * @param array $userData
	 *
	 * @return int
	 */
	protected function getPasswordStrength(string $password, array $userData = []): int {
		$zxcvbn = new Zxcvbn();
		$strength = $zxcvbn->passwordStrength($password, $userData);

		return $strength['score'];
	}
}
