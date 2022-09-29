<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Menu;

class LoginMenu extends AbstractMenu
{
    /**
     * @inheritDoc
     */
    public function getLink(): string
    {
        return $this->routerRoutings->get('login.frontend');
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Log in';
    }

    /**
     * @inheritDoc
     */
    public function isVisible() : bool
    {
        return !$this->isLoggedUser();
    }
}
