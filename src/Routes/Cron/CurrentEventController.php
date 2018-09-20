<?php

namespace BRG\Panel\Routes\Cron;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Model\Setting;
use Google_Service_Calendar_Event;
use BRG\Panel\Service\Google\Calendar\GoogleCalendarApiClient;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class CurrentEventController {
	/**
	 * @var GoogleCalendarApiClient
	 */
	protected $googleCalendarApiClient;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->googleCalendarApiClient = $container->googleCalendarApiClient;
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function __invoke(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		/** @var Google_Service_Calendar_Event $calendarCurrentEvent */
		$calendarCurrentEvent = $this->googleCalendarApiClient->fetchCurrentEvent();

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
