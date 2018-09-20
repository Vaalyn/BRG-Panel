<?php

namespace BRG\Panel\Routes\Api\Dashboard;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Exception\InfoException;
use BRG\Panel\Model\Donation;
use BRG\Panel\Model\Donor;
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
	public function createDonationAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$name   = trim($request->getParsedBody()['name']) ?? null;
		$amount = $request->getParsedBody()['amount'] ?? null;

		try {
			if (!$this->container->validator::stringType()->length(1, null)->validate($name)) {
				throw new InfoException('Der Name muss mindestens 1 Zeichen lang sein');
			}

			if (!$this->container->validator->numeric()->min(0, true)->validate($amount)) {
				throw new InfoException('Keine gültige Spendensumme');
			}

			$donor = Donor::where('name', '=', $name)->first();

			if (!isset($donor)) {
				$donor       = new Donor();
				$donor->name = $name;
				$donor->save();
			}

			$donation           = new Donation();
			$donation->amount   = $amount;
			$donation->donor_id = $donor->donor_id;
			$donation->save();

			$apiResponse = (new JsonApiResponseDto())
				->setStatus('success');

			return $response->write(json_encode($apiResponse));
		}
		catch (InfoException $exception) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage($exception->getMessage());

			return $response->write(json_encode($apiResponse));
		}
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function updateCurrentlyNeededDonationAmountAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$amount = $request->getParsedBody()['amount'] ?? null;

		if (!$this->container->validator->numeric()->min(0, true)->validate($amount)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Keine gültige Spendensumme');

			return $response->write(json_encode($apiResponse));
		}

		$currentlyNeededAmountSetting = Setting::where('key', '=', 'currently_needed_donation_amount')->first();
		$currentlyNeededAmountSetting->value = $amount;
		$currentlyNeededAmountSetting->save();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success');

		return $response->write(json_encode($apiResponse));
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function deleteDonationAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$id = $args['id'];

		$donation = Donation::find($id);

		if (!isset($donation)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Spende nicht gefunden');

			return $response->write(json_encode($apiResponse));
		}

		$donation->delete();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success');

		return $response->write(json_encode($apiResponse));
	}
}
