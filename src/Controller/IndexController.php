<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Controller;

class IndexController extends AbstractController
{
    /**
     * {@inheritDoc}
     * @throws \SmartyException
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
