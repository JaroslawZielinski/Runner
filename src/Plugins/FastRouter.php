<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Plugins;

use FastRoute\Dispatcher;
use Invoker\InvokerInterface;

class FastRouter implements InvokerInterface
{
    public const DEFAULT_FUNCTION = 'execute';

    /**
     * @var FastRouterRoutingsInterface
     */
    private $routes;

    /**
     * @var TemplatesInterface
     */
    private $templates;

    /**
     * @var \Smarty
     */
    private $templateHandler;

    public function __construct(
        FastRouterRoutingsInterface $routes,
        TemplatesInterface $templates
    ) {
        $this->routes = $routes;
        $this->templates = $templates;
        $this->templateHandler = $this->templates->getHandler();
        $this->templateHandler
            ->assign('homepage', '../' . $this->templates->getTemplateDir() . 'homepage.tpl');
    }

    /**
     * {@inheritDoc}
     * @param callable $container
     * @throws \SmartyException
     */
    public function call($container, array $parameters = array())
    {
        $dispatcher = $this->routes->getDispatcher();

        $route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

        switch ($route[0]) {
            case Dispatcher::NOT_FOUND:
                $this->templateHandler->display($this->templates->getTemplateDir() . '404page.tpl');
                break;

            case Dispatcher::METHOD_NOT_ALLOWED:
                $this->templateHandler->display($this->templates->getTemplateDir() . '405page.tpl');
                break;

            case Dispatcher::FOUND:
                $controller = $route[1];
                $parameters = $route[2];

                // We could do $container->get($controller) but $container->call()
                // does that automatically
                $container->call($controller, $parameters);
                break;
        }
    }
}
