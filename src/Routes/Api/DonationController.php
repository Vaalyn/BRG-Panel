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
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function getDonationsAction(Request $request, Response $response, array $args): Response {
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

		return $response->withJson($apiResponse);
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function getCurrentlyNeededAmountAction(Request $request, Response $response, array $args): Response {
		$currentlyNeededAmountSetting = Setting::where('key', '=', 'currently_needed_donation_amount')->first();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success')
			->setResult($currentlyNeededAmountSetting->value);

		return $response->withJson($apiResponse);
	}
}
