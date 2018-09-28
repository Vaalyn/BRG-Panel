<?php

declare(strict_types = 1);

namespace BRG\Panel\Middleware\Menu;

use BRG\Panel\Service\MenuBuilder\MenuBuilder;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class MenuMiddleware {
	/**
	 * @var MenuBuilder
	 */
	protected $menuBuilder;

	/**
	 * @var array
	 */
	protected $menuConfigs;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
        $this->menuBuilder = $container->menuBuilder;
		$this->menuConfigs = $container->config['menu'];
    }

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param callable $next
	 *
	 * @return Response
	 */
	public function __invoke(Request $request, Response $response, callable $next): Response {
		$menus = [];

		foreach ($this->menuConfigs as $menuName => $menuConfig) {
			$menu = $this->menuBuilder->buildMenufromConfig($menuName, $menuConfig, $request);
			$menus[$menu->getName()] = $menu;
		}

		$request = $request->withAttribute('menus', $menus);

		return $next($request, $response);
	}
}
