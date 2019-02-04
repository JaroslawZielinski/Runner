<?php

namespace JaroslawZielinski\Runner\Menu;

/**
 * Interface MenuInterface
 * @package JaroslawZielinski\Runner\Menu
 */
interface MenuInterface
{
    public function getLink();
    public function getName();
    public function isVisible() : bool;
}
