<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Plugins;

interface TemplatesInterface
{
    /**
     * get handler
     */
    public function getHandler(): \Smarty;

    /**
     * @get template dir
     */
    public function getTemplateDir(): string;
}
