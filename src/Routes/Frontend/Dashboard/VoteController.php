<?php

namespace BRG\Panel\Routes\Frontend\Dashboard;

use BRG\Panel\Model\Track;
use Illuminate\Database\Eloquent\Builder;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;
use Vaalyn\AuthenticationService\AuthenticationInterface;

class VoteController {
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
		$page           = 1;
		$entriesPerPage = 20;

		if (isset($args['page'])) {
			$page = $args['page'];
		}

		$tracksQuery = $this->createFetchTracksWithVotesQuery($request);

		$pages = max([ceil($tracksQuery->getQuery()->getCountForPagination() / $entriesPerPage), 1]);

		$tracks = $tracksQuery
			->take($entriesPerPage)
			->skip(($page - 1) * $entriesPerPage)
			->get();

		return $this->renderer->render($response, '/dashboard/vote/vote.php', [
			'authentication' => $this->authentication,
			'page' => $page,
			'pages' => $pages,
			'path' => $request->getUri()->getPath(),
			'request' => $request,
			'tracks' => $tracks
		]);
	}

	/**
	 * @param Request $request
	 *
	 * @return Builder
	 */
	protected function createFetchTracksWithVotesQuery(Request $request): Builder {
		$title         = $request->getQueryParams()['title'] ?? null;
		$artist        = $request->getQueryParams()['artist'] ?? null;
		$minVotes      = (int) ($request->getQueryParams()['min_votes'] ?? 0);
		$includeHidden = isset($request->getQueryParams()['include_hidden']);
		$sortBy        = $request->getQueryParams()['sort_by'] ?? null;

		$tracksWithVotesQuery = Track::selectRaw(
				'track.*,
				SUM(upvote) AS upvotes,
				SUM(downvote) AS downvotes,
				SUM(upvote) + SUM(downvote) AS score'
			)
			->with('artist')
			->leftJoin('vote', 'vote.track_id', '=', 'track.track_id');

		if (!empty($title)) {
			$tracksWithVotesQuery->where('title', 'LIKE', $title);
		}

		if (!empty($artist)) {
			$tracksWithVotesQuery->whereHas('artist', function($query) use($artist) {
				$query->where('name', 'LIKE', $artist);
			});
		}

		if (!$includeHidden) {
			$tracksWithVotesQuery->where('ignore_votes', '=', false);
		}

		$tracksWithVotesQuery->groupBy('track.track_id');

		if ($minVotes > 0) {
			$tracksWithVotesQuery->havingRaw('SUM(upvote) + SUM(downvote) >= ' . $minVotes);
		}

		switch ($sortBy) {
			case 'upvotes':
				return $tracksWithVotesQuery->orderBy('upvotes');

			case 'downvotes':
				return $tracksWithVotesQuery->orderBy('downvotes');

			case 'upvotes_desc':
				return $tracksWithVotesQuery->orderBy('upvotes', 'DESC');

			case 'downvotes_desc':
				return $tracksWithVotesQuery->orderBy('downvotes', 'DESC');

			default:
				return $tracksWithVotesQuery->orderByRaw('score');
		}
	}
}
