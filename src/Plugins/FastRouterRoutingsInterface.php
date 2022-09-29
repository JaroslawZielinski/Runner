<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Plugins;

interface FastRouterRoutingsInterface
{
    /**
     * get dispatcher
     */
    public function getDispatcher();

    /**
     * get by id
     */
    public function get(string $id): string;

    /**
     * get by attribute
     */
    public function getAttribute(string $id, string $attribute): string;
}
