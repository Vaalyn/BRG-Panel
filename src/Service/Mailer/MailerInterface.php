<?php

namespace BRG\Panel\Service\Mailer;

use BRG\Panel\Exception\InvalidMailerConfigurationException;
use BRG\Panel\Exception\MailNotSendException;

interface MailerInterface {
	/**
	 * @param array $config
	 *
	 * @throws InvalidMailerConfigurationException
	 */
	public function __construct(array $config);

	/**
	 * @param string $subject
	 * @param string $toEmail
	 * @param string $toName
	 * @param string $message
	 *
	 * @return void
	 *
	 * @throws MailNotSendException
	 */
	public function sendMail(string $subject, string $toEmail, string $toName, string $message): void;
}
