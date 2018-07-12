<?php

namespace Routes\Cron;

use Dto\ApiResponse\JsonApiResponseDto;
use Model\Setting;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class CurrentEventController {
	/**
	 * @var \Psr\Container\ContainerInterface
	 */
	protected $container;

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

		/** @var \Google_Service_Calendar_Event $calendarCurrentEvent */
		$calendarCurrentEvent = $this->container->googleCalendarApiClient->fetchCurrentEvent();

		$currentEventSetting = Setting::where('key', '=', 'current_event')->first();

		if ($calendarCurrentEvent !== null) {
			$currentEventSetting->value = $calendarCurrentEvent->getSummary();
		}
		else {
			$currentEventSetting->value = 'DJ-Pony Lucy';
		}

		$currentEventSetting->save();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success');

		return $response->write(json_encode($apiResponse));
	}
}
