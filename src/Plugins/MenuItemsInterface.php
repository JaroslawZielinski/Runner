<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Plugins;

interface MenuItemsInterface
{
    /**
     * get menu items
     */
    public function getMenuItemsArray(): array;
}
