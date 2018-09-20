<?php

namespace BRG\Panel\Routes\Frontend\Dashboard;

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
	public function __invoke(Request $request, Response $response, array $args): Response {
		$currentlyNeededAmountSetting = Setting::where('key', '=', 'currently_needed_donation_amount')
			->first();

		$donations = Donation::with('donor')->get();

		return $this->container->renderer->render($response, '/dashboard/donation/donation.php', [
			'auth' => $this->container->auth,
			'currentlyNeededDonationAmount' => $currentlyNeededAmountSetting,
			'donations' => $donations,
			'request' => $request
		]);
	}
}
