<?php

namespace JaroslawZielinski\Runner\Plugins;

/**
 * Interface FastRouterRoutingsInterface
 * @package JaroslawZielinski\Runner\Plugins
 */
interface FastRouterRoutingsInterface
{
    public function getDispatcher();

    public function get($id);

    public function getAttribute($id, $attribute);
}
