<?php

namespace JaroslawZielinski\Runner\Controller;

/**
 * Class LoginController
 * @package JaroslawZielinski\Runner\Controller
 */
class LoginController extends AbstractController
{
    /**
     *
     */
    public function during()
    {
        //show page
        $this->templateHandler
            ->assign('backendPath', $this->routerRoutings->get('login.backend'))
            ->display($this->templates->getTemplateDir() . 'login.tpl');

        $this->logger->info(LoginController::class . ' has called function execute');
    }

    /**
     *
     */
    public function send()
    {
        //TODO

        $this->setMessage(self::ALERT_SUCCESS, "Welcome <a class=\"alert-link\">Jarosław Zieliński</a>!");

        $this->logger->info(LoginController::class . ' has called function register with POST');

        header("Location: /homepage");
    }
}

