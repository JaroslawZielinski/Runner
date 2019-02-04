<?php

namespace JaroslawZielinski\Runner\Menu;

/**
 * Class LogoutMenu
 * @package JaroslawZielinski\Runner\Menu
 */
class LogoutMenu extends AbstractMenu
{
    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->routerRoutings->get('logout.backend');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "Log out";
    }

    /**
     * @return bool
     */
    public function isVisible() : bool
    {
        return $this->isLoggedUser();
    }
}
