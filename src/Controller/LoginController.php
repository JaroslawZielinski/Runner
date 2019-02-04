<?php

namespace JaroslawZielinski\Runner\Controller;

use Exception;

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
        $this->setCsrfProtection();

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
        $this->logger->info(LoginController::class . ' has called function register with POST');

        //security check
        if ($this->isCSRFAttempt()) {
            $this->setMessage(self::ALERT_DANGER, "Possible CSRF Attempt!!!");

            $this->logger->info(LoginController::class . ' CSRF Attempt detected', [
                'backend token' => $this->csrfToken,
                'check_token' => $_COOKIE[self::CSRF_TOKEN]
            ]);

            header("Location: " . $this->routerRoutings->get('login.front'));
            return true;
        }

        //collect data
        $login = isset($_POST['email']) ? $_POST['email'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        //read user
        try {
            $user = $this->userRepository->readByLoginAndPassword($login, $password);
        } catch (Exception $e) {
            $this->logger->error(LoginController::class . ': ' . $e->getMessage(), [$e->getTrace()]);
            $this->setMessage(self::ALERT_DANGER, sprintf("Reading user was not accomplished because: %s", $e->getMessage()));

            header("Location: " . $this->routerRoutings->get('login.front'));
            return true;
        }

        //log-in user
        $this->logIn($user);

        //success
        $this->logger->info(LoginController::class . ' Form was validated', [$user->__toString()]);
        $this->setMessage(self::ALERT_SUCCESS, sprintf("User <a class=\"alert-link\">\"%s\"</a> has been logged!", $user->__toString()));

        header("Location: " . $this->routerRoutings->get('homepage'));
    }
}

