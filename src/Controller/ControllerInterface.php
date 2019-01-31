<?php

namespace JaroslawZielinski\Runner\Controller;

/**
 * Interface ControllerInterface
 * @package JaroslawZielinski\Runner\Controller
 */
interface ControllerInterface
{
    public function execute();
    public function after();
    public function during();
}
