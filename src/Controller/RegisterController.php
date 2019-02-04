<?php

namespace JaroslawZielinski\Runner\Controller;

use Exception;
use JaroslawZielinski\Runner\Model\User;

/**
 * Class RegisterController
 * @package JaroslawZielinski\Runner\Controller
 */
class RegisterController extends AbstractController
{
    /**
     *
     */
    public function during()
    {
        if ($this->checkIfSecurityIssueForLogged()) {
            return;
        }

        $this->setCsrfProtection();

        //show page
        $this->templateHandler
            ->assign('path', $this->routerRoutings->get('register.frontend'))
            ->assign('backendPath', $this->routerRoutings->get('register.backend'))
            ->display($this->templates->getTemplateDir() . 'register.tpl');

        $this->logger->info(RegisterController::class . ' has called function execute');
    }

    /**
     *
     */
    public function send()
    {
        if ($this->checkIfSecurityIssueForLogged()) {
            return;
        }

        $this->logger->info(RegisterController::class . ' has called function register with POST');

        //security check
        if ($this->isCSRFAttempt()) {
            $this->setMessage(self::ALERT_DANGER, "Possible CSRF Attempt!!!");

            $this->logger->info(RegisterController::class . ' CSRF Attempt detected', [
                'backend token' => $this->csrfToken,
                'check_token' => $_COOKIE[self::CSRF_TOKEN]
            ]);

            header("Location: " . $this->routerRoutings->get('register.frontend'));
            return true;
        }

        //collect data
        $user = User::createFromArray($_POST);

        //create user
        try {
            $lastId = $this->userRepository->create($user);
            $this->logger->info(RegisterController::class . ': User has been created!', ["lastId" => $lastId, "user" => $user->__toString()]);
        } catch (Exception $e) {
            $this->logger->error(RegisterController::class . ': ' . $e->getMessage(), [$e->getTrace()]);
            $this->setMessage(self::ALERT_DANGER, sprintf("Creating user was not accomplished because: %s", $e->getMessage()));

            header("Location: " . $this->routerRoutings->get('register.frontend'));
            return true;
        }

        //success
        //login
        $this->logIn($user);
        $this->logger->info(RegisterController::class . ' User has been logged in', [$user->__toString()]);

        $this->setMessage(self::ALERT_SUCCESS, sprintf("Welcome <a class=\"alert-link\">\"%s\"</a>", $user->__toString()));

        header("Location: " . $this->routerRoutings->get('homepage'));
    }
}
