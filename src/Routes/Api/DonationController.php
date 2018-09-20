<?php

namespace BRG\Panel\Routes\Api;

use BRG\Panel\Dto\ApiResponse\DonationDto;
use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Model\Donation;
use BRG\Panel\Model\Setting;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class DonationController {
	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
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
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
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
