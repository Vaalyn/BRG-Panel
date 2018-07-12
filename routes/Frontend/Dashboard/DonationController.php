<?php

namespace Routes\Frontend\Dashboard;

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
