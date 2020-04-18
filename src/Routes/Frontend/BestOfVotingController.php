<?php

declare(strict_types=1);

namespace BRG\Panel\Routes\Frontend;

use BRG\Panel\Model\BestOfVote;
use BRG\Panel\Model\Setting;
use Carbon\Carbon;
use Gettext\Loader\PoLoader;
use Gettext\Translator;
use Gettext\TranslatorFunctions;
use InvalidArgumentException;
use JsonException;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\PhpRenderer;

class BestOfVotingController {
	/**
	 * @var array
	 */
	protected $cookieConfig;

	/**
	 * @var Messages
	 */
	protected $flashMessages;

	/**
	 * @var PhpRenderer
	 */
	protected $renderer;

	/**
	 * @var Router
	 */
	protected $router;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->cookieConfig = $container->config['best_of_voting']['cookie'];
		$this->flashMessages = $container->flashMessages;
		$this->renderer = $container->renderer;
		$this->router = $container->router;
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function __invoke(Request $request, Response $response, array $args): Response {
		$language = $args['language'] ?? 'de';
		$ipAddress = $request->getAttribute('ip_address');

		$this->loadTranslations($language);

		$votingStartDateSetting = Setting::where('key', '=', 'best_of_voting_start_date')->first();
		$votingEndDateSetting = Setting::where('key', '=', 'best_of_voting_end_date')->first();
		$votingPlaylistCodeSetting = Setting::where('key', '=', 'best_of_voting_playlist_code')->first();

		$votingStartDate = Carbon::createFromFormat('Y-m-d', $votingStartDateSetting->value);
		$votingEndDate = Carbon::createFromFormat('Y-m-d', $votingEndDateSetting->value);
		$votingPlaylistCode = $votingPlaylistCodeSetting->value;

		$currentDate = Carbon::now();

		if ($currentDate->greaterThanOrEqualTo($votingEndDate)) {
			$votingStartDate = $this->buildRecommendedNextStartDate($currentDate, true);
			$votingEndDate = $this->buildRecommendedNextEndDate($votingStartDate);
		}

		$isVotingActive = true;

		if (
			$currentDate->lessThan($votingStartDate)
			|| $currentDate->greaterThanOrEqualTo($votingEndDate)
		) {
			$isVotingActive = false;
		}

		$hasAlreadyVoted = BestOfVote::where('ip_address', '=', $ipAddress)->exists();

		if ($this->checkVotedCookie()) {
			$hasAlreadyVoted = true;
		}

		return $this->renderer->render($response, '/best-of-voting/best-of-voting.php', [
			'flashMessages' => $this->flashMessages->getMessages(),
			'hasAlreadyVoted' => $hasAlreadyVoted,
			'isVotingActive' => $isVotingActive,
			'language' => $language,
			'request' => $request,
			'router' => $this->router,
			'votingEndDate' => $votingEndDate,
			'votingStartDate' => $votingStartDate,
			'votingPlaylistCode' => $votingPlaylistCode
		]);
	}

	public function saveBestOfVoteAction(Request $request, Response $response, array $args): Response {
		$language = $request->getParsedBody()['language'] ?? 'de';
		$nickname = trim($request->getParsedBody()['nickname'] ?? '');
		$votes = $request->getParsedBody()['votes'] ?? [];
		$ipAddress = $request->getAttribute('ip_address');

		$this->loadTranslations($language);

		$bestOfVote = BestOfVote::where('ip_address', '=', $ipAddress)->first();

		if ($nickname !== '') {
			$bestOfVote = BestOfVote::where('nickname', '=', $nickname)->first();
		}

		if ($bestOfVote !== null || $this->checkVotedCookie()) {
			$this->flashMessages->addMessage(
				'Error',
				p__('best-of-voting', 'Du hast bereits abgestimmt!')
			);
			return $response->withRedirect($this->router->pathFor('best-of-voting'));
		}

		$bestOfVote = new BestOfVote();
		$bestOfVote->best_of_vote_id = Uuid::uuid4();
		$bestOfVote->nickname = ($nickname !== '') ? $nickname : '';
		$bestOfVote->link_1 = '';
		$bestOfVote->songname_1 = '';
		$bestOfVote->link_2 = '';
		$bestOfVote->songname_2 = '';
		$bestOfVote->link_3 = '';
		$bestOfVote->songname_3 = '';
		$bestOfVote->link_4 = '';
		$bestOfVote->songname_4 = '';
		$bestOfVote->link_5 = '';
		$bestOfVote->songname_5 = '';
		$bestOfVote->ip_address = $ipAddress;

		if (count($votes) !== 5) {
			$this->flashMessages->addMessage(
				'Error',
				p__('best-of-voting', 'Ungültige Anzahl Vote Felder übergeben')
			);
			return $response->withRedirect($this->router->pathFor('best-of-voting'));
		}

		foreach ($votes as $index => $vote) {
			$link = trim($vote['link']);
			$songname = trim($vote['songname']);

			if ($index === 0 && $link === '') {
				$this->flashMessages->addMessage(
					'Error',
					p__('best-of-voting', 'Der Link für den 1. Platz muss angegeben werden')
				);
				return $response->withRedirect($this->router->pathFor('best-of-voting'));
			}

			if ($index > 0 && $link === '' && $songname !== '') {
				$this->flashMessages->addMessage(
					'Error',
					p__('best-of-voting', sprintf(
						'Du hast einen Title - Interpet für den %s. Platz angegeben, bitte gib auch einen Link an',
						($index + 1)
					))
				);
				return $response->withRedirect($this->router->pathFor('best-of-voting'));
			}

			switch ($index) {
				case 0:
					$bestOfVote->link_1 = $link;
					if ($songname !== '') {
						$bestOfVote->songname_1 = $songname;
					}
					break;

				case 1:
					$bestOfVote->link_2 = $link;
					if ($songname !== '') {
						$bestOfVote->songname_2 = $songname;
					}
					break;

				case 2:
					$bestOfVote->link_3 = $link;
					if ($songname !== '') {
						$bestOfVote->songname_3 = $songname;
					}
					break;

				case 3:
					$bestOfVote->link_4 = $link;
					if ($songname !== '') {
						$bestOfVote->songname_4 = $songname;
					}
					break;

				case 4:
					$bestOfVote->link_5 = $link;
					if ($songname !== '') {
						$bestOfVote->songname_5 = $songname;
					}
					break;
			}
		}

		if (!$bestOfVote->save()) {
			$this->flashMessages->addMessage(
				'Error',
				p__('best-of-voting', 'Fehler beim speichern')
			);
			return $response->withRedirect($this->router->pathFor('best-of-voting'));
		}

		$this->flashMessages->addMessage(
			p__('best-of-voting', 'Erfolgreich abgestimmt'),
			p__('best-of-voting', 'Vielen Dank für deine Teilnahme! Wir wünschen dir viel Spaß bei der kommenden Best-of Sendung.')
		);

		$this->setVotedCookie($bestOfVote);

		return $response->withRedirect($this->router->pathFor('best-of-voting'));
	}

	public function getBestOfVotingButtonAction(Request $request, Response $response, array $args): Response {
		$language = $args['language'] ?? 'de';

		$this->loadTranslations($language);

		$votingStartDateSetting = Setting::where('key', '=', 'best_of_voting_start_date')->first();
		$votingEndDateSetting = Setting::where('key', '=', 'best_of_voting_end_date')->first();

		$votingStartDate = Carbon::createFromFormat('Y-m-d', $votingStartDateSetting->value);
		$votingEndDate = Carbon::createFromFormat('Y-m-d', $votingEndDateSetting->value);

		$currentDate = Carbon::now();

		if ($currentDate->greaterThanOrEqualTo($votingEndDate)) {
			$votingStartDate = $this->buildRecommendedNextStartDate($currentDate, true);
			$votingEndDate = $this->buildRecommendedNextEndDate($votingStartDate);
		}

		$isVotingActive = true;

		if (
			$currentDate->lessThan($votingStartDate)
			|| $currentDate->greaterThanOrEqualTo($votingEndDate)
		) {
			$isVotingActive = false;
		}

		return $this->renderer->render($response, '/best-of-voting/best-of-voting-button.php', [
			'isVotingActive' => $isVotingActive,
			'language' => $language,
			'request' => $request,
			'router' => $this->router,
			'votingEndDate' => $votingEndDate
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

	protected function checkVotedCookie(): bool {
		if (isset($_COOKIE[$this->cookieConfig['name']])) {
			$cookie = null;
			$votedAt = null;

			try {
				$cookie = json_decode(
					$_COOKIE[$this->cookieConfig['name']],
					false,
					512,
					JSON_THROW_ON_ERROR
				);
			}
			catch (JsonException $exception) {
				$this->unsetVotedCookie();
				return false;
			}

			try {
				$votedAt = Carbon::createFromFormat('Y-m-d H:i:s', $cookie->voted_at);
			}
			catch (InvalidArgumentException $exception) {
				$this->unsetVotedCookie();
				return false;
			}

			$votingEndDateSetting = Setting::where('key', '=', 'best_of_voting_end_date')->first();
			$votingEndDate = Carbon::createFromFormat('Y-m-d', $votingEndDateSetting->value);

			if (!$votedAt->isSameMonth($votingEndDate)) {
				$this->unsetVotedCookie();
				return false;
			}

			if (isset($cookie->best_of_vote_id)) {
				if (BestOfVote::where('best_of_vote_id', '=', $cookie->best_of_vote_id)->exists()) {
					return true;
				}
			}

			$this->unsetVotedCookie();
		}

		return false;
	}

	protected function setVotedCookie(BestOfVote $bestOfVote): void {
		setcookie(
			$this->cookieConfig['name'],
			json_encode([
				'best_of_vote_id' => $bestOfVote->best_of_vote_id,
				'voted_at' => $bestOfVote->created_at->toDateTimeString(),
			]),
			time() + $this->cookieConfig['expire'],
			'/',
			$this->cookieConfig['domain'],
			$this->cookieConfig['secure'],
			$this->cookieConfig['httponly']
		);
	}

	protected function unsetVotedCookie(): void {
		unset($_COOKIE[$this->cookieConfig['name']]);
		setcookie(
			$this->cookieConfig['name'],
			'',
			time() - 3600,
			'/',
			$this->cookieConfig['domain'],
			$this->cookieConfig['secure'],
			$this->cookieConfig['httponly']
		);
	}

	protected function loadTranslations(string $language): void {
		$loader = new PoLoader();

		$translations = $loader->loadFile(
			__DIR__ . '/../../../config/translations/' . $language . '/frontend.po'
		);

		$translator = Translator::createFromTranslations($translations);

		TranslatorFunctions::register($translator);
	}
}
