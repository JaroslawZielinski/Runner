<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Menu;

class IndexMenu extends AbstractMenu
{
    /**
     * @inheritDoc
     */
    public function getLink(): string
    {
        return $this->routerRoutings->get('index');
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return '';
    }
}
