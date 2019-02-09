<?php

namespace JaroslawZielinski\Runner\Menu;

/**
 * Class LogoutMenu
 * @package JaroslawZielinski\Runner\Menu
 */
class CustomFeatureMenu extends AbstractMenu
{
    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->routerRoutings->get('customfeature.frontend');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "Custom Feature";
    }

    /**
     * @return bool
     */
    public function isVisible() : bool
    {
        return $this->isLoggedUser();
    }
}
