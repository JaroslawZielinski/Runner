<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Plugins;

class Templates implements TemplatesInterface
{
    /**
     * @var \Smarty
     */
    private $handler;

    /**
     * @var string
     */
    private $templateDir;

    public function __construct(\Smarty $handler, $templateDir)
    {
        $this->handler = $handler;
        $this->templateDir = $templateDir;
    }

    /**
     * @inheritDoc
     */
    public function getHandler(): \Smarty
    {
        return $this->handler;
    }

    /**
     * @inheritDoc
     */
    public function getTemplateDir(): string
    {
        return $this->templateDir;
    }
}
