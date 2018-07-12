<?php

namespace Routes\Cron;

use Dto\ApiResponse\JsonApiResponseDto;
use Jobby\Jobby;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class CronController {
	/**
	 * @var \Psr\Container\ContainerInterface
	 */
	protected $container;

	/**
	 * @var \Jobby\Jobby
	 */
	protected $cronManager;

	/**
	 * @param \Psr\Container\ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function __invoke(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$this->cronManager = new Jobby();

		$this->registerCrons();

		$this->cronManager->run();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success');

		return $response->write(json_encode($apiResponse));
	}

	/**
	 * @return void
	 */
	protected function registerCrons(): void {
		$this->addCurrentEventCron();
		$this->addHistoryCron();
		$this->addStreaminfoCron();
		$this->addTrackCron();
	}

	/**
	 * @return void
	 */
	protected function addCurrentEventCron(): void {
		for ($executions = 0; $executions < 6; $executions++) {
			$cronCommand = sprintf(
				'sleep %s; curl %s/cron/current/event/update',
				$executions * 10,
				$this->container->config['host']['url']
			);

			$cronName = sprintf('CurrentEventUpdate-%s', $executions + 1);

			$this->cronManager->add($cronName, [
				'command' => $cronCommand,
				'schedule' => function() {
					return true;
				}
			]);
		}
	}

	/**
	 * @return void
	 */
	protected function addHistoryCron(): void {
		$cronCommand = sprintf(
			'curl %s/cron/history/update',
			$this->container->config['host']['url']
		);

		$this->cronManager->add('HistoryUpdate', [
			'command' => $cronCommand,
			'schedule' => '* * * * *'
		]);
	}

	/**
	 * @return void
	 */
	protected function addStreaminfoCron(): void {
		$mountpoints = $this->container->config['icecast']['mountpoints'];

		foreach ($mountpoints as $mountpoint) {
			for ($executions = 0; $executions < 6; $executions++) {
				$cronCommand = sprintf(
					'sleep %s; curl %s/cron/streaminfo/update/%s',
					$executions * 10,
					$this->container->config['host']['url'],
					$mountpoint['mountpoint']
				);

				$cronName = sprintf(
					'StreaminfoUpdate-%s-%s',
					$mountpoint['mountpoint'],
					$executions + 1
				);

				$this->cronManager->add($cronName, [
					'command' => $cronCommand,
					'schedule' => function() {
						return true;
					}
				]);
			}
		}
	}

	/**
	 * @return void
	 */
	protected function addTrackCron(): void {
		$cronCommand = sprintf(
			'curl %s/cron/track/autodj/update',
			$this->container->config['host']['url']
		);

		$this->cronManager->add('TrackUpdate', [
			'command' => $cronCommand,
			'schedule' => '*/10 * * * *'
		]);
	}
}
