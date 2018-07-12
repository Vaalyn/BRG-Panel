<?php

namespace Service\Mailer;

use Exception\InvalidMailArgumentException;
use Exception\InvalidMailerConfigurationException;
use Exception\MailNotSendException;
use Respect\Validation\Validator;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Mailer implements MailerInterface {
	/**
	 * @var array
	 */
	protected $config;

	/**
	 * @param array $config
	 *
	 * @throws \Exception\InvalidMailerConfigurationException
	 */
	public function __construct(array $config) {
		$this->config = $config;

		$this->validateConfig();
	}

	/**
	 * @param string $subject
	 * @param string $toEmail
	 * @param string $toName
	 * @param string $message
	 * @param bool $isHtmlMessage
	 *
	 * @return void
	 *
	 * @throws \Exception\MailNotSendException
	 */
	public function sendMail(string $subject, string $toEmail, string $toName, string $message, bool $isHtmlMessage = true): void {
		$this->validateMailArguments($subject, $toEmail);

		$swiftMessage = new Swift_Message();

		$swiftMessage->setSubject($subject)
			->setFrom([
				$this->config['fromAddress'] => $this->config['from']
			])
			->setTo([$toEmail => $toName])
			->setBody($message);

		if ($isHtmlMessage) {
			$swiftMessage->setContentType('text/html');
		}

		$mailer = $this->createMailer();

		$failedRecipients = [];

		$mailer->send($swiftMessage, $failedRecipients);

		if (count($failedRecipients)) {
			throw new MailNotSendException(
				sprintf(
					'Mail could not be send for the following recipients: %s',
					implode(', ', $failedRecipients)
				)
			);
		}
	}

	/**
	 * @return Swift_Mailer
	 */
	protected function createMailer(): Swift_Mailer {
		$smtpTransport = $this->buildSmtpTransport(
			$this->config['username'],
			$this->config['password'],
			$this->config['host'],
			$this->config['port'],
			$this->config['security'],
			$this->config['authMode']
		);

		return new Swift_Mailer($smtpTransport);
	}

	/**
	 * @param string $username
	 * @param string $password
	 * @param string $host
	 * @param int $port
	 * @param string $security
	 * @param string $authMode
	 *
	 * @return Swift_SmtpTransport
	 */
	protected function buildSmtpTransport(
		string $username,
		string $password,
		string $host,
		int $port,
		string $security,
		string $authMode
	): Swift_SmtpTransport {
		$smtpTransport = (new Swift_SmtpTransport($host, $port, $security))
			->setUsername($username)
			->setPassword($password)
			->setAuthMode($authMode);

		return $smtpTransport;
	}

	/**
	 * @return void
	 *
	 * @throws \Exception\InvalidMailerConfigurationException
	 */
	protected function validateConfig(): void {
		if (!Validator::email()->validate($this->config['fromAddress'])) {
			throw new InvalidMailerConfigurationException(
				sprintf(
					'From address "%s" is an invalid e-mail address',
					$toEmail
				)
			);
		}

		if ($this->config['username'] === '') {
			throw new InvalidMailerConfigurationException('Empty username given');
		}

		if ($this->config['password'] === '') {
			throw new InvalidMailerConfigurationException('Empty password given');
		}

		if ($this->config['host'] === '') {
			throw new InvalidMailerConfigurationException('Empty host given');
		}

		if (!is_int($this->config['port'])) {
			throw new InvalidMailerConfigurationException(
				sprintf(
					'Invalid port "%s" must be an integer',
					$this->config['port']
				)
			);
		}

		if (!in_array($this->config['security'], [null, 'ssl', 'tls'])) {
			throw new InvalidMailerConfigurationException(
				sprintf(
					'Unkown security setting "%s"',
					$this->config['security']
				)
			);
		}

		if (!in_array($this->config['authMode'], [null, 'plain', 'login', 'cram-md5'])) {
			throw new InvalidMailerConfigurationException(
				sprintf(
					'Unkown auth mode "%s"',
					$this->config['authMode']
				)
			);
		}
	}

	/**
	 * @param string $subject
	 * @param string $toEmail
	 *
	 * @return void
	 *
	 * @throws \Exception\InvalidMailArgumentException
	 */
	protected function validateMailArguments(string $subject, string $toEmail): void {
		if (trim($subject) === '') {
			throw new InvalidMailArgumentException('The given "subject" is empty');
		}

		if (!Validator::email()->validate($toEmail)) {
			throw new InvalidMailArgumentException(
				sprintf(
					'The given receiver e-mail address "%s" is not a valid e-mail address',
					$toEmail
				)
			);
		}
	}
}
