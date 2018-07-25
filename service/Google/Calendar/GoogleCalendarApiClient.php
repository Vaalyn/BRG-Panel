<?php

namespace Service\Google\Calendar;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_Events;

class GoogleCalendarApiClient {
	/**
	 * @var \Google_Service_Calendar
	 */
	protected $service;

	/**
	 * @var string
	 */
	protected $calendarId;

	/**
	 * @param array $config
	 */
	public function __construct(array $config) {
		$this->calendarId = $config['calendar_id'];

		$client = new Google_Client();
		$client->setApplicationName('BRG - Panel');
		$client->setDeveloperKey($config['api_key']);

		$this->service = new Google_Service_Calendar($client);
	}

	/**
	 * @return \Google_Service_Calendar_Event|null
	 */
	public function fetchCurrentEvent(): ?Google_Service_Calendar_Event {
		$optParams = array(
			'maxResults' => 1,
			'orderBy' => 'startTime',
			'singleEvents' => true,
			'timeMin' => date(\DateTime::RFC3339)
		);

		/** @var Google_Service_Calendar_Events $events */
		$events = $this->service->events->listEvents(
			'bronyradiogermany@gmail.com',
			$optParams
		);

		$eventItems = $events->getItems();

		if (empty($eventItems)) {
			return null;
		}

		return reset($eventItems);
	}
}
