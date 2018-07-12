<?php

namespace Routes\Api;

use Model\Voter;

use Dto\ApiResponse\VoterDto;
use Dto\ApiResponse\JsonApiResponseDto;
use Dto\ApiResponse\VotedDto;
use Exception\InfoException;
use Model\Manager\TrackModelManager;
use Model\Stream;
use Model\Vote;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;
use Slim\Http\Request;
use Slim\Http\Response;

class VoteController {
	/**
	 * @var \Psr\Container\ContainerInterface
	 */
	protected $container;

	/**
	 * @var \Model\Manager\TrackModelManager
	 */
	protected $trackModelManager;

	/**
	 * @param \Psr\Container\ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->container = $container;

		$this->trackModelManager = new TrackModelManager();
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function getVotedForTrackOnMountpointAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$voterId    = $args['voterId'];
		$mountpoint = $args['mountpoint'];

		$stream = Stream::where('mountpoint', '=', $args['mountpoint'])->first();

		if (!isset($stream)) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage('Invalid mountpoint');

			return $response->write(json_encode($apiResponse));
		}

		$track = $this->trackModelManager->findTrackByTitleAndArtist(
			$stream->title,
			$stream->artist
		);

		$vote = Vote::where([
				['track_id', '=', $track->track_id],
				['voter_id', '=', $voterId]
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

		return $response->write(json_encode($apiResponse));
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function createVoterAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$requestOrigin = $request->getAttribute('origin');

		try {
			$voter           = new Voter();
			$voter->voter_id = Uuid::uuid4()->toString();
			$voter->origin   = $requestOrigin;

			if (!$voter->save()) {
				throw new InfoException('Fehler beim registrieren als Voter');
			}

			$voterDto = new VoterDto(
				$voter->voter_id
			);

			$apiResponse = (new JsonApiResponseDto())
				->setStatus('success')
				->setResult($voterDto);

			return $response->write(json_encode($apiResponse));
		}
		catch(InfoException $exception) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage($exception->getMessage());

			return $response->write(json_encode($apiResponse));
		}
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function voteAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

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

			return $response->write(json_encode($apiResponse));
		}
		catch(InfoException $exception) {
			$apiResponse = (new JsonApiResponseDto())
				->setStatus('error')
				->setMessage($exception->getMessage());

			return $response->write(json_encode($apiResponse));
		}
	}
}
