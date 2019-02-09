<?php

namespace JaroslawZielinski\Runner\Controller;

/**
 * Class CustomFeatureController
 * @package JaroslawZielinski\Runner\Controller
 */
class CustomFeatureController extends AbstractController
{
    /**
     *
     */
    public function during()
    {
        // to prevent non logged user reach this site
        if ($this->checkIfSecurityIssueForAnonymous()) {
            return;
        }

        //show page
        $this->templateHandler
            ->assign('path', $this->routerRoutings->get('customfeature.frontend'))
            ->display($this->templates->getTemplateDir() . 'customfeature.tpl');

        $this->logger->info(CustomFeatureController::class . ' has called function execute');
    }
}

