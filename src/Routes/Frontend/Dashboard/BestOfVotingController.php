<?php

declare(strict_types=1);

namespace BRG\Panel\Routes\Frontend\Dashboard;

use BRG\Panel\Model\BestOfVote;
use BRG\Panel\Model\Setting;
use Carbon\Carbon;
use Psr\Container\ContainerInterface;
use Respect\Validation\Validator;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;
use Vaalyn\AuthenticationService\AuthenticationInterface;

class BestOfVotingController {
	/**
	 * @var AuthenticationInterface
	 */
	protected $authentication;

	/**
	 * @var PhpRenderer
	 */
	protected $renderer;

	/**
	 * @var Validator
	 */
	protected $validator;

	public function __construct(ContainerInterface $container) {
		$this->authentication = $container->authentication;
		$this->renderer       = $container->renderer;
		$this->validator      = $container->validator;
	}

	public function __invoke(Request $request, Response $response, array $args): Response {
		$currentDate = Carbon::now();
		$recommendedNextStartDate = $this->buildRecommendedNextStartDate($currentDate);
		$recommendedNextEndDate = $this->buildRecommendedNextEndDate($recommendedNextStartDate);

		if ($currentDate->greaterThanOrEqualTo($recommendedNextEndDate)) {
			$recommendedNextStartDate = $this->buildRecommendedNextStartDate($currentDate, true);
			$recommendedNextEndDate = $this->buildRecommendedNextEndDate($recommendedNextStartDate);
		}

		$votingStartDateSetting = Setting::where('key', '=', 'best_of_voting_start_date')->first();
		$votingEndDateSetting = Setting::where('key', '=', 'best_of_voting_end_date')->first();
		$votingPlaylistCodeSetting = Setting::where('key', '=', 'best_of_voting_playlist_code')->first();

		$votingStartDate = Carbon::createFromFormat('Y-m-d', $votingStartDateSetting->value);
		$votingEndDate = Carbon::createFromFormat('Y-m-d', $votingEndDateSetting->value);

		$bestOfVotes = BestOfVote::all();

		return $this->renderer->render($response, '/dashboard/best-of-voting/best-of-voting.php', [
			'authentication' => $this->authentication,
			'bestOfVotes' => $bestOfVotes,
			'carbon' => new Carbon(),
			'path' => $request->getUri()->getPath(),
			'recommendedNextStartDate' => $recommendedNextStartDate,
			'recommendedNextEndDate' => $recommendedNextEndDate,
			'request' => $request,
			'validator' => $this->validator,
			'votingStartDate' => $votingStartDate,
			'votingEndDate' => $votingEndDate,
			'votingPlaylistCode' => $votingPlaylistCodeSetting->value
		]);
	}

	protected function buildRecommendedNextStartDate(Carbon $monthDate, bool $nextMonth = false): Carbon {
		$startDate = $monthDate->copy();

		if ($nextMonth) {
			$startDate->addMonthsNoOverflow(1);
		}

		return $startDate->startOfMonth();
	}

	protected function buildRecommendedNextEndDate(Carbon $startDate): Carbon {
		return $startDate->copy()
			->nextWeekendDay()
			->addWeeks(1)
			->subDays(1);
	}
}
