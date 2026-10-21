<?php

declare(strict_types = 1);

namespace BRG\Panel\Service\Cron;

use Cron\CronExpression;
use DateTimeImmutable;

class CronScheduler {
	/**
	 * @var array<string, array{command: string, schedule: CronExpression}>
	 */
	protected $jobs = [];

	/**
	 * @param string $name
	 * @param string $command
	 * @param string $schedule
	 *
	 * @return CronScheduler
	 */
	public function add(string $name, string $command, string $schedule): CronScheduler {
		$this->jobs[$name] = [
			'command' => $command,
			'schedule' => new CronExpression($schedule)
		];

		return $this;
	}

	/**
	 * @return void
	 */
	public function run(): void {
		$now = new DateTimeImmutable();

		foreach ($this->jobs as $name => $job) {
			if ($job['schedule']->isDue($now)) {
				$this->runInBackground($name, $job['command']);
			}
		}
	}

	/**
	 * @param string $name
	 * @param string $command
	 *
	 * @return void
	 */
	protected function runInBackground(string $name, string $command): void {
		// flock skips the job while its previous run still holds the lock
		exec(sprintf(
			'flock --nonblock %s sh -c %s > /dev/null 2>&1 &',
			escapeshellarg($this->getLockFilePath($name)),
			escapeshellarg($command)
		));
	}

	/**
	 * @param string $name
	 *
	 * @return string
	 */
	protected function getLockFilePath(string $name): string {
		return sprintf(
			'%s/brg-panel-cron-%s.lock',
			sys_get_temp_dir(),
			preg_replace('/[^A-Za-z0-9_-]/', '_', $name)
		);
	}
}
