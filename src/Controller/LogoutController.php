<?php

namespace JaroslawZielinski\Runner\Controller;


/**
 * Class LoginController
 * @package JaroslawZielinski\Runner\Controller
 */
class LogoutController extends AbstractController
{
    /**
     *
     */
    public function send()
    {
        if ($this->checkIfSecurityIssueForAnonymous()) {
            return;
        }

        $this->logger->info(LogoutController::class . ' has called function register with POST');

        //log-in user
        $this->logOut();
        $this->before();

        //success
        $this->logger->info(LogoutController::class . ' User logged out');
        $this->setMessage(self::ALERT_SUCCESS, "User logout.");

        header("Location: " . $this->routerRoutings->get('homepage'));
    }

    public function during()
    {
        // TODO: Implement during() method.
    }
}

