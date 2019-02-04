<?php

namespace JaroslawZielinski\Runner\Menu;

/**
 * Class HomePageMenu
 * @package JaroslawZielinski\Runner\Menu
 */
class HomePageMenu extends AbstractMenu
{
    /**
     *
     */
    public function getLink()
    {
        return $this->routerRoutings->get('homepage');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "Home";
    }
}
