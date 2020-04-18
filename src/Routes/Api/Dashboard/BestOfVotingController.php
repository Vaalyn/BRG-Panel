<?php

declare(strict_types=1);

namespace BRG\Panel\Routes\Api\Dashboard;

use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Model\BestOfVote;
use BRG\Panel\Model\Setting;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator;
use Slim\Http\Request;
use Slim\Http\Response;

class BestOfVotingController {
	public function __construct(ContainerInterface $container) {
	}

	public function setBestOfVotingConfigAction(Request $request, Response $response, array $args): Response {
		$votingStartDateParameter = $request->getParsedBody()['start_date'] ?? '';
		$votingEndDateParameter = $request->getParsedBody()['end_date'] ?? '';
		$votingPlaylistCodeParameter = $request->getParsedBody()['playlist_code'] ?? '';

		if (!$this->isDateStringValid($votingStartDateParameter)) {
			return $response->withJson($this->buildErrorJsonApiResponseDto(
				'Voting Start Datum ist nicht im richtigen Format'
			));
		}

		if (!$this->isDateStringValid($votingEndDateParameter)) {
			return $response->withJson($this->buildErrorJsonApiResponseDto(
				'Voting End Datum ist nicht im richtigen Format'
			));
		}

		$votingStartDateSetting = Setting::where('key', '=', 'best_of_voting_start_date')->first();
		$votingStartDateSetting->value = $votingStartDateParameter;
		$votingStartDateSetting->save();

		$votingEndDateSetting = Setting::where('key', '=', 'best_of_voting_end_date')->first();
		$votingEndDateSetting->value = $votingEndDateParameter;
		$votingEndDateSetting->save();

		$votingPlaylistCodeSetting = Setting::where('key', '=', 'best_of_voting_playlist_code')->first();
		$votingPlaylistCodeSetting->value = $votingPlaylistCodeParameter;
		$votingPlaylistCodeSetting->save();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success')
			->setMessage('Einstellungen gespeichert');

		return $response->withJson($apiResponse);
	}

	public function deleteBestOfVoteAction(Request $request, Response $response, array $args): Response {
		$bestOfVoteId = $args['id'];

		$bestOfVote = BestOfVote::find($bestOfVoteId);

		if (!isset($bestOfVote)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Best-of Vote nicht gefunden');

			return $response->withJson($apiResponse);
		}

		$bestOfVote->delete();

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success')
			->setMessage('Best-of Vote wurde gelöscht');

		return $response->withJson($apiResponse);
	}

	protected function isDateStringValid(string $dateString): bool {
		return (new Validator())->date('Y-m-d')->validate($dateString);
	}

	protected function buildErrorJsonApiResponseDto(string $message): JsonApiResponseDto {
		$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage($message);

		return $apiResponse;
	}
}
