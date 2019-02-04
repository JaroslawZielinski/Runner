<?php

namespace JaroslawZielinski\Runner\Menu;

use JaroslawZielinski\Runner\Controller\AbstractController;
use JaroslawZielinski\Runner\Plugins\FastRouterRoutingsInterface;

/**
 * Class AbstractMenu
 * @package JaroslawZielinski\Runner\Menu
 */
abstract class AbstractMenu implements MenuInterface
{
    /**
     * @var FastRouterRoutingsInterface
     */
    protected $routerRoutings;

    /**
     * AbstractMenu constructor.
     * @param FastRouterRoutingsInterface $routerRoutings
     */
    public function __construct(FastRouterRoutingsInterface $routerRoutings)
    {
        $this->routerRoutings = $routerRoutings;
    }

    /**
     * @return bool
     */
    public function isVisible() : bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isLoggedUser()
    {
        return isset($_SESSION[AbstractController::SESSION_USER_LOGGED]);
    }
}
