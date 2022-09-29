<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Menu;

class RegisterMenu extends AbstractMenu
{
    /**
     * @inheritDoc
     */
    public function getLink(): string
    {
        return $this->routerRoutings->get('register.frontend');
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Register';
    }

    /**
     * @inheritDoc
     */
    public function isVisible() : bool
    {
        return !$this->isLoggedUser();
    }
}
