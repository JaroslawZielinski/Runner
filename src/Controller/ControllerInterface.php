<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Controller;

interface ControllerInterface
{
    /**
     * Execute call
     */
    public function execute();
    /**
     * Before Execute
     */
    public function before();
    /**
     * During Execute
     */
    public function during();
    /**
     * After
     */
    public function after();
}
