<?php

namespace JaroslawZielinski\Runner\Menu;

/**
 * Class RegisterMenu
 * @package JaroslawZielinski\Runner\Menu
 */
class RegisterMenu extends AbstractMenu
{
    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->routerRoutings->get('register.frontend');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "Register";
    }

    /**
     * @return bool
     */
    public function isVisible() : bool
    {
        return !$this->isLoggedUser();
    }
}
