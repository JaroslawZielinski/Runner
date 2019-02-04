<?php

namespace JaroslawZielinski\Runner\Controller;

/**
 * Class IndexController
 * @package JaroslawZielinski\Runner\Controller
 */
class IndexController extends AbstractController
{
    /**
     *
     */
    public function during()
    {
        //show page
        $this->templateHandler
            ->assign('path', $this->routerRoutings->get('index'))
            ->display($this->templates->getTemplateDir() . 'index.tpl');

        $this->logger->info(IndexController::class . ' has called function execute');
    }
}
