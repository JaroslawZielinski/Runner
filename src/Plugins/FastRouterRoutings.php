<?php

namespace JaroslawZielinski\Runner\Plugins;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

/**
 * Class FastRouterRoutings
 * @package JaroslawZielinski\Runner\Plugins
 */
class FastRouterRoutings implements FastRouterRoutingsInterface
{
    /**
     * Execute
     */
    const DEFAULT_FUNCTION = 'execute';

    /**
     * Controller
     */
    const ATTRIBUTE_CONTROLLER = 'controller';

    /**
     * Method
     */
    const ATTRIBUTE_METHOD = 'method';

    /**
     * Path
     */
    const ATTRIBUTE_PATH = 'path';

    /**
     * @var array
     */
    protected $routes;

    /**
     * FastRouter constructor.
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @return \FastRoute\Dispatcher
     */
    public function getDispatcher()
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $r) {
            foreach ($this->routes as $name => $route) {
                $controller = $route[self::ATTRIBUTE_CONTROLLER];
                $r->addRoute($route[self::ATTRIBUTE_METHOD], $route[self::ATTRIBUTE_PATH], is_array($controller) ? $controller : [$controller, self::DEFAULT_FUNCTION]);
            }
        });

        return $dispatcher;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->getAttribute($id);
    }

    /**
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function getAttribute($id, $attribute = self::ATTRIBUTE_PATH)
    {
        return $this->routes[$id][$attribute];
    }
}
