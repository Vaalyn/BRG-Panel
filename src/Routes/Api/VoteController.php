<?php

namespace BRG\Panel\Routes\Api;

use BRG\Panel\Dto\ApiResponse\VoterDto;
use BRG\Panel\Dto\ApiResponse\JsonApiResponseDto;
use BRG\Panel\Dto\ApiResponse\VotedDto;
use BRG\Panel\Exception\InfoException;
use BRG\Panel\Model\Manager\TrackModelManager;
use BRG\Panel\Model\Stream;
use BRG\Panel\Model\Vote;
use BRG\Panel\Model\Voter;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;
use Slim\Http\Request;
use Slim\Http\Response;

class VoteController {
	/**
	 * @var TrackModelManager
	 */
	protected $trackModelManager;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->trackModelManager = new TrackModelManager();
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function getVotedForTrackOnMountpointAction(Request $request, Response $response, array $args): Response {
		$voterId    = $args['voterId'];
		$mountpoint = $args['mountpoint'];
		$ipAddress  = $request->getAttribute('ip_address');

		$stream = Stream::where('mountpoint', '=', $mountpoint)->first();

		if (!isset($stream)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Invalid mountpoint');

			return $response->withJson($apiResponse);
		}

		$track = $this->trackModelManager->findTrackByTitleAndArtist(
			$stream->title,
			$stream->artist
		);

		$vote = Vote::where([
				['track_id', '=', $track->track_id],
				['voter_id', '=', $voterId]
			])
			->orWhere([
				['track_id', '=', $track->track_id],
				['ip_address', '=', $ipAddress]
			])
			->first();

		$votedDto = new VotedDto(isset($vote), '');

		if (isset($vote)) {
			if ($vote->upvote) {
				$votedDto->setDirection('up');
			}

			if ($vote->downvote) {
				$votedDto->setDirection('down');
			}
		}

		$apiResponse = (new JsonApiResponseDto())
			->setStatus('success')
			->setResult($votedDto);

		return $response->withJson($apiResponse);
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function createVoterAction(Request $request, Response $response, array $args): Response {
		$requestOrigin = $request->getAttribute('origin');
		$ipAddress = $request->getAttribute('ip_address');

		try {
			$voter             = new Voter();
			$voter->voter_id   = Uuid::uuid4()->toString();
			$voter->origin     = $requestOrigin;
			$voter->ip_address = $ipAddress;

			if (!$voter->save()) {
				throw new InfoException('Fehler beim registrieren als Voter');
			}

			$voterDto = new VoterDto(
				$voter->voter_id
			);

			$apiResponse = (new JsonApiResponseDto())
				->setStatus('success')
				->setResult($voterDto);

			return $response->withJson($apiResponse);
		}
		catch(InfoException $exception) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage($exception->getMessage());

			return $response->withJson($apiResponse);
		}
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param array $args
	 *
	 * @return Response
	 */
	public function voteAction(Request $request, Response $response, array $args): Response {
		$mountpoint = $args['mountpoint'];
		$voterId    = $request->getParsedBody()['voter_id'];
		$direction  = $request->getParsedBody()['direction'];
		$ipAddress  = $request->getAttribute('ip_address');

		try {
			if (!Uuid::isValid($voterId)) {
				throw new InfoException('Invalid uuid');
			}

			if ($direction !== 'up' && $direction !== 'down') {
				throw new InfoException('Invalid direction');
			}

			$stream = Stream::where('mountpoint', '=', $mountpoint)->first();

			if (!isset($stream)) {
				throw new InfoException('Invalid mountpoint');
			}

			if (!Voter::exists($voterId)) {
				throw new InfoException('Invalid Voter Uuid');
			}

			$track = $this->trackModelManager->findTrackByTitleAndArtist(
				$stream->title,
				$stream->artist
			);

			if (!isset($track)) {
				throw new InfoException('Es ist ein Fehler aufgetreten');
			}

			$vote = Vote::where([
					['track_id', '=', $track->track_id],
					['voter_id', '=', $voterId]
				])
				->orWhere([
					['track_id', '=', $track->track_id],
					['ip_address', '=', $ipAddress]
				])
				->first();

			if (!isset($vote)) {
				$vote = new Vote();
				$vote->track_id = $track->track_id;
			}

			if ($direction === 'up') {
				$vote->upvote = true;
				$vote->downvote = false;
			}
			else {
				$vote->upvote = false;
				$vote->downvote = true;
			}

			$vote->voter_id = $voterId;
			$vote->ip_address = $ipAddress;
			$vote->save();

			$apiResponse = (new JsonApiResponseDto())->setStatus('success');

			return $response->withJson($apiResponse);
		}
		catch(InfoException $exception) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage($exception->getMessage());

			return $response->withJson($apiResponse);
		}
	}
}
