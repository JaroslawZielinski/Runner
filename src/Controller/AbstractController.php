<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Controller;

use JaroslawZielinski\Runner\Model\User;
use JaroslawZielinski\Runner\Model\UserRepository;
use JaroslawZielinski\Runner\Plugins\DotEnvSettings;
use JaroslawZielinski\Runner\Plugins\FastRouterRoutingsInterface;
use JaroslawZielinski\Runner\Plugins\MenuItemsInterface;
use JaroslawZielinski\Runner\Plugins\TemplatesInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractController implements ControllerInterface
{
    public const USER_LOGIN = 'login';
    public const USER_ID = 'user_id';
    public const CSRF_TOKEN = 'csrf-token';
    public const SESSION_USER_LOGGED = 'current_user';
    public const SESSION_USER_MESSAGE = 'mymsg';
    public const ALERT_PRIMARY = "alert-primary";
    public const ALERT_SECONDARY = "alert-secondary";
    public const ALERT_SUCCESS = "alert-success";
    public const ALERT_DANGER = "alert-danger";
    public const ALERT_WARNING = "alert-warning";
    public const ALERT_INFO = "alert-info";
    public const ALERT_LIGHT = "alert-light";
    public const ALERT_DARK = "alert-dark";

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var FastRouterRoutingsInterface
     */
    protected $routerRoutings;

    /**
     * @var TemplatesInterface
     */
    protected $templates;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var MenuItemsInterface
     */
    protected $menuItems;

    /**
     * @var DotEnvSettings
     */
    protected $dotEnvSettings;

    /**
     * @var \Smarty
     */
    protected $templateHandler;

    /**
     * @var
     */
    protected $csrfToken;

    public function __construct(
        LoggerInterface $logger,
        FastRouterRoutingsInterface $routerRoutings,
        TemplatesInterface $templates,
        UserRepository $userRepository,
        MenuItemsInterface $menuItems,
        DotEnvSettings $dotEnvSettings
    ) {
        $this->logger = $logger;
        $this->routerRoutings = $routerRoutings;
        $this->templates = $templates;
        $this->userRepository = $userRepository;
        $this->menuItems = $menuItems;
        $this->dotEnvSettings = $dotEnvSettings;
        $this->templateHandler = $this->templates->getHandler();
        $templateDir = '../' . $this->templates->getTemplateDir();

        $this->templateHandler
            ->assign('templateDir', $templateDir)
            ->assign('homepage', $templateDir . 'homepage.tpl')
            ->assign('message', $_SESSION[self::SESSION_USER_MESSAGE])
            ->assign('menus', $this->menuItems->getMenuItemsArray());
    }

    protected function checkIfSecurityIssueForLogged(): bool
    {
        if ($this->isLoggedUser()) {
            $this->logger->warning("Logged user's unnecessary action");

            $this->setMessage(self::ALERT_DANGER, "This was not neccessary!");

            header('Location: ' . $this->routerRoutings->get('index'));
            die;
        }

        return false;
    }

    protected function checkIfSecurityIssueForAnonymous(): bool
    {
        if (!$this->isLoggedUser()) {
            $this->logger->warning('Anonymous user tried to gain unauthorized access...');

            $this->setMessage(self::ALERT_DANGER, "Action denied. This is forbidden.");

            header('Location: ' . $this->routerRoutings->get('index'));
            die;
        }

        return false;
    }

    protected function setCsrfProtection(): void
    {
        //create Token
        $this->csrfToken = md5((string)microtime(true));

        //save Token to Cookie
        setcookie(self::CSRF_TOKEN, $this->csrfToken, time() + 60);//60s live

        //save Token to Form variable
        $this->templateHandler->assign('csrfToken', $this->csrfToken);
    }

    protected function isCSRFAttempt(): bool
    {
        //get Token from Cookie
        $cookie = $_COOKIE[self::CSRF_TOKEN];

        //get Token from Form variable
        $this->csrfToken = $_POST[self::CSRF_TOKEN] ?? null;

        //comparison
        return $cookie !== $this->csrfToken;
    }

    protected function setMessage(string $type = self::ALERT_INFO, string $content = 'Empty'): void
    {
        $_SESSION[self::SESSION_USER_MESSAGE] = [
            'type' => $type,
            'content' => $content
        ];
    }

    protected function getLoggedUser(): ?array
    {
        return $this->isLoggedUser() ? $_SESSION[self::SESSION_USER_LOGGED] : null;
    }

    protected function isLoggedUser(): bool
    {
        return isset($_SESSION[self::SESSION_USER_LOGGED]);
    }

    protected function logIn(User $user): void
    {
        $_SESSION[self::SESSION_USER_LOGGED] = [
            self::USER_ID => $user->getUserId(),
            self::USER_LOGIN => $user->getEmail()
        ];
    }

    protected function logOut(): void
    {
        unset($_SESSION[self::SESSION_USER_LOGGED]);
    }

    protected function flushMessage(): void
    {
        unset($_SESSION[self::SESSION_USER_MESSAGE]);
    }

    /**
     * @inheritDoc
     */
    public final function before()
    {
        //Logging state should be checked and refreshed before calling given controller
        $loggedUser = $this->getLoggedUser();
        if (!empty($loggedUser)) {
            $this->templateHandler
                ->assign('userLogged', $loggedUser);
        } else {
            $this->templateHandler
                ->clearAssign('userLogged');
        }
    }

    /**
     * @inheritDoc
     */
    public final function execute()
    {
        //Heart of frontend controller
        $this->before();
        $this->during();
        $this->after();
    }

    /**
     * @inheritDoc
     */
    public final function after()
    {
        //The message should be cleared after showing it
        $this->flushMessage();
    }
}
