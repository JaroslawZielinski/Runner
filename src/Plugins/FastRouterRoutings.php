<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Plugins;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class FastRouterRoutings implements FastRouterRoutingsInterface
{
    public const DEFAULT_FUNCTION = 'execute';
    public const ATTRIBUTE_CONTROLLER = 'controller';
    public const ATTRIBUTE_METHOD = 'method';
    public const ATTRIBUTE_PATH = 'path';

    /**
     * @var array
     */
    private $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @inheritDoc
     */
    public function getDispatcher()
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $r) {
            foreach ($this->routes as $name => $route) {
                $controller = $route[self::ATTRIBUTE_CONTROLLER];
                $r->addRoute(
                    $route[self::ATTRIBUTE_METHOD],
                    $route[self::ATTRIBUTE_PATH],
                    is_array($controller) ? $controller : [$controller, self::DEFAULT_FUNCTION]
                );
            }
        });

        return $dispatcher;
    }

    /**
     * @inheritDoc
     */
    public function get(string $id): string
    {
        return $this->getAttribute($id);
    }

    /**
     * @inheritDoc
     */
    public function getAttribute(string $id, string $attribute = self::ATTRIBUTE_PATH): string
    {
        return $this->routes[$id][$attribute];
    }
}
