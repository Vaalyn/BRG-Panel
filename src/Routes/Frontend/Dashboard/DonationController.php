<?php

namespace BRG\Panel\Routes\Frontend\Dashboard;

use BRG\Panel\Model\Donation;
use BRG\Panel\Model\Setting;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;
use Vaalyn\AuthenticationService\AuthenticationInterface;

class DonationController {
	/**
	 * @var AuthenticationInterface
	 */
	protected $authentication;

	/**
	 * @var PhpRenderer
	 */
	protected $renderer;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->authentication = $container->authentication;
		$this->renderer       = $container->renderer;
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

		return $this->renderer->render($response, '/dashboard/donation/donation.php', [
			'authentication' => $this->authentication,
			'currentlyNeededDonationAmount' => $currentlyNeededAmountSetting,
			'donations' => $donations,
			'request' => $request
		]);
	}
}
