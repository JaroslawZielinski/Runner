<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Menu;

class CustomFeatureMenu extends AbstractMenu
{
    /**
     * @inheritDoc
     */
    public function getLink(): string
    {
        return $this->routerRoutings->get('customfeature.frontend');
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Custom Feature';
    }

    /**
     * @inheritDoc
     */
    public function isVisible() : bool
    {
        return $this->isLoggedUser();
    }
}
