<?php

namespace JaroslawZielinski\Runner\Plugins;

/**
 * Class Templates
 * @package JaroslawZielinski\Runner\Plugins
 */
class Templates implements TemplatesInterface
{
    /**
     * @var
     */
    protected $handler;

    /**
     * @var
     */
    protected $templateDir;

    /**
     * Templates constructor.
     * @param $handler
     * @param $templateDir
     */
    public function __construct($handler, $templateDir)
    {
        $this->handler = $handler;
        $this->templateDir = $templateDir;
    }

    /**
     * @return mixed
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @return mixed
     */
    public function getTemplateDir()
    {
        return $this->templateDir;
    }
}
