<?php

namespace JaroslawZielinski\Runner\Menu;

/**
 * Class IndexMenu
 * @package JaroslawZielinski\Runner\Menu
 */
class IndexMenu extends AbstractMenu
{
    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->routerRoutings->get('index');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "";
    }
}
