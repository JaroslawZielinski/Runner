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
        $this->setCsrfProtection();

        //show page
        $this->templateHandler
            ->assign('backendPath', $this->routerRoutings->get('register.backend'))
            ->display($this->templates->getTemplateDir() . 'register.tpl');

        $this->logger->info(RegisterController::class . ' has called function execute');
    }

    /**
     *
     */
    public function send()
    {
        $this->logger->info(RegisterController::class . ' has called function register with POST');

        //security check
        if ($this->isCSRFAttempt()) {
            $this->setMessage(self::ALERT_DANGER, "Possible CSRF Attempt!!!");

            $this->logger->info(RegisterController::class . ' CSRF Attempt detected', [
                'backend token' => $this->csrfToken,
                'check_token' => $_COOKIE[self::CSRF_TOKEN]
            ]);

            header("Location: " . $this->routerRoutings->get('register.front'));
            return true;
        }

        //collect data
        $user = User::createFromArray($_POST);

        //create user
        try {
            $this->userRepository->create($user);
        } catch (Exception $e) {
            $this->logger->error(RegisterController::class . ': ' . $e->getMessage(), [$e->getTrace()]);
            $this->setMessage(self::ALERT_DANGER, sprintf("Creating user was not accomplished because: %s", $e->getMessage()));

            header("Location: " . $this->routerRoutings->get('register.front'));
            return true;
        }

        //success
        $this->logger->info(RegisterController::class . ' Form was validated', [$user->__toString()]);
        $this->setMessage(self::ALERT_SUCCESS, sprintf("Welcome <a class=\"alert-link\">\"%s\"</a>", $user->__toString()));

        header("Location: " . $this->routerRoutings->get('homepage'));
    }
}
