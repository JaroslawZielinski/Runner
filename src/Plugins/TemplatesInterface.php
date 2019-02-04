<?php
/**
 * Created by PhpStorm.
 * User: jarosawzielinski
 * Date: 01.02.19
 * Time: 16:07
 */

namespace JaroslawZielinski\Runner\Plugins;

/**
 * Interface TemplatesInterface
 * @package JaroslawZielinski\Runner\Plugins
 */
interface TemplatesInterface
{
    public function getHandler();
    public function getTemplateDir();
}
