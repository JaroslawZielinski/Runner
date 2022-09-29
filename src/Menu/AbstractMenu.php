<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Menu;

use JaroslawZielinski\Runner\Controller\AbstractController;
use JaroslawZielinski\Runner\Plugins\FastRouterRoutingsInterface;

abstract class AbstractMenu implements MenuInterface
{
    /**
     * @var FastRouterRoutingsInterface
     */
    protected $routerRoutings;

    public function __construct(FastRouterRoutingsInterface $routerRoutings)
    {
        $this->routerRoutings = $routerRoutings;
    }

    /**
     * @inheritDoc
     */
    public function isVisible() : bool
    {
        return true;
    }

    public function isLoggedUser(): bool
    {
        return isset($_SESSION[AbstractController::SESSION_USER_LOGGED]);
    }
}
