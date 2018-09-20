<?php

namespace BRG\Panel\Routes\Frontend\Dashboard;

use BRG\Panel\Model\Message;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class MessageController {
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

		$messagesQuery = Message::orderBy('created_at')->orderBy('message_id');

		$pages = max([ceil($messagesQuery->count() / $entriesPerPage), 1]);

		$messages = $messagesQuery
			->take($entriesPerPage)
			->skip(($page - 1) * $entriesPerPage)
			->get();

		return $this->container->renderer->render($response, '/dashboard/message/message.php', [
			'auth' => $this->container->auth,
			'messages' => $messages,
			'page' => $page,
			'pages' => $pages,
			'path' => $request->getUri()->getPath(),
			'request' => $request
		]);
	}
}
