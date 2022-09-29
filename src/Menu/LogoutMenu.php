<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Menu;

class LogoutMenu extends AbstractMenu
{
    public function getLink(): string
    {
        return $this->routerRoutings->get('logout.backend');
    }

    public function getName(): string
    {
        return 'Log out';
    }

    public function isVisible() : bool
    {
        return $this->isLoggedUser();
    }
}
