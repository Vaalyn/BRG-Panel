<?php

namespace Routes\Api;

use Dto\ApiResponse\DonationDto;
use Dto\ApiResponse\JsonApiResponseDto;
use Model\Donation;
use Model\Setting;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class DonationController {
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
	public function getDonationsAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$donations = Donation::with('donor')->get();

		$donationDtos = [];

		foreach ($donations as $donation) {
			$donationDtos[] = new DonationDto(
				$donation->donation_id,
				$donation->donor->name,
				$donation->amount
			);
		}

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success')
			->setResult($donationDtos);

		return $response->write(json_encode($apiResponse));
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function getCurrentlyNeededAmountAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$currentlyNeededAmountSetting = Setting::where('key', '=', 'currently_needed_donation_amount')->first();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success')
			->setResult($currentlyNeededAmountSetting->value);

		return $response->write(json_encode($apiResponse));
	}
}
