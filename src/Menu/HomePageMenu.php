<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Menu;

class HomePageMenu extends AbstractMenu
{
    /**
     * @inheritDoc
     */
    public function getLink(): string
    {
        return $this->routerRoutings->get('homepage');
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Home';
    }
}
