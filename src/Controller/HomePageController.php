<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Controller;

class HomePageController extends AbstractController
{
    /**
     * {@inheritDoc}
     * @throws \SmartyException
     */
    public function during()
    {
        //show page
        $this->templateHandler
            ->assign('path', $this->routerRoutings->get('homepage'))
            ->display($this->templates->getTemplateDir() . 'homepage.tpl');

        $this->logger->info(HomePageController::class . ' has called function execute');
    }
}
