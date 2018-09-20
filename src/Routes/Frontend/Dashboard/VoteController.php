<?php

namespace BRG\Panel\Routes\Frontend\Dashboard;

use BRG\Panel\Model\Track;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class VoteController {
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
		$page           = 1;
		$entriesPerPage = 20;

		if (isset($args['page'])) {
			$page = $args['page'];
		}

		$tracksQuery = Track::selectRaw(
				'track.*,
				SUM(upvote) AS upvotes,
				SUM(downvote) AS downvotes'
			)
			->with('artist')
			->leftJoin('vote', 'vote.track_id', '=', 'track.track_id')
			->where('ignore_votes', '=', false)
			->groupBy('track.track_id');

		$pages = max([ceil($tracksQuery->count() / $entriesPerPage), 1]);

		$tracks = $tracksQuery
			->orderBy('upvotes', 'DESC')
			->orderBy('downvotes')
			->take($entriesPerPage)
			->skip(($page - 1) * $entriesPerPage)
			->get();

		return $this->container->renderer->render($response, '/dashboard/vote/vote.php', [
			'auth' => $this->container->auth,
			'page' => $page,
			'pages' => $pages,
			'path' => $request->getUri()->getPath(),
			'request' => $request,
			'tracks' => $tracks
		]);
	}
}
