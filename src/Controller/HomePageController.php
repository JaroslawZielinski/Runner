<?php

namespace JaroslawZielinski\Runner\Controller;

/**
 * Class HomePageController
 * @package JaroslawZielinski\Runner\Controller
 */
class HomePageController extends AbstractController
{
    /**
     *
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
