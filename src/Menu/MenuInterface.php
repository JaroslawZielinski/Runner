<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Menu;

interface MenuInterface
{
    /**
     * Returns link
     */
    public function getLink(): string;
    /**
     * Returns Name
     */
    public function getName(): string;
    /**
     * Returns visibility
     */
    public function isVisible() : bool;
}
