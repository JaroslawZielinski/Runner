<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Controller;

class LogoutController extends AbstractController
{
    public function send(): bool
    {
        // to prevent non logged user reach this site
        if ($this->checkIfSecurityIssueForAnonymous()) {
            return false;
        }

        $this->logger->info(LogoutController::class . ' has called function register with POST');

        //log-out user
        $this->logOut();

        //success
        $this->logger->info(LogoutController::class . ' User logged out');
        $this->setMessage(self::ALERT_SUCCESS, "User logout.");

        header('Location: ' . $this->routerRoutings->get('homepage'));
    }

    /**
     * @inheritDoc
     */
    public function during()
    {
    }
}
