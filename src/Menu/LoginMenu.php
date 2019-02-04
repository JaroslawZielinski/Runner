<?php

namespace JaroslawZielinski\Runner\Menu;

/**
 * Class LoginMenu
 * @package JaroslawZielinski\Runner\Menu
 */
class LoginMenu extends AbstractMenu
{
    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->routerRoutings->get('login.frontend');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "Log in";
    }

    /**
     * @return bool
     */
    public function isVisible() : bool
    {
        return !$this->isLoggedUser();
    }
}
