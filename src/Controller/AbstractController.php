<?php

namespace JaroslawZielinski\Runner\Controller;

use JaroslawZielinski\Runner\Plugins\FastRouterRoutingsInterface;
use JaroslawZielinski\Runner\Plugins\TemplatesInterface;
use Psr\Log\LoggerInterface;
use Smarty;

/**
 * Class AbstractController
 * @package JaroslawZielinski\Runner\Controller
 */
abstract class AbstractController implements ControllerInterface
{
    /**
     *
     */
    const CSRF_TOKEN = 'csrf-token';

    /**
     *
     */
    const SESSION_MESSAGE = 'mymsg';

    /**
     *
     */
    const ALERT_PRIMARY = "alert-primary";

    /**
     *
     */
    const ALERT_SECONDARY = "alert-secondary";

    /**
     *
     */
    const ALERT_SUCCESS = "alert-success";

    /**
     *
     */
    const ALERT_DANGER = "alert-danger";

    /**
     *
     */
    const ALERT_WARNING = "alert-warning";

    /**
     *
     */
    const ALERT_INFO = "alert-info";

    /**
     *
     */
    const ALERT_LIGHT = "alert-light";

    /**
     *
     */
    const ALERT_DARK = "alert-dark";

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
     * @var Smarty
     */
    protected $templateHandler;

    /**
     * @var
     */
    protected $csrfToken;

    /**
     * IndexController constructor.
     * @param LoggerInterface $logger
     * @param FastRouterRoutingsInterface $routerRoutings
     * @param TemplatesInterface $templates
     */
    public function __construct(LoggerInterface $logger, FastRouterRoutingsInterface $routerRoutings, TemplatesInterface $templates)
    {
        $this->logger = $logger;
        $this->routerRoutings = $routerRoutings;
        $this->templates = $templates;
        $this->templateHandler = $this->templates->getHandler();
        $templateDir = '../' . $this->templates->getTemplateDir();

        $this->templateHandler
            ->assign('templateDir', $templateDir)
            ->assign('homepage', $templateDir . 'homepage.tpl')
            ->assign('message', $_SESSION[self::SESSION_MESSAGE])
        ;
    }

    /**
     * CSRF Protection
     */
    public function setCsrfProtection()
    {
        //create Token
        $this->csrfToken = md5(microtime(true));

        //save Token to Cookie
        setcookie(self::CSRF_TOKEN, $this->csrfToken, time() + 60);//60s live

        //save Token to Form variable
        $this->templateHandler->assign('csrfToken', $this->csrfToken);
    }

    /**
     * Check is CSRF Attempt
     * @return bool
     */
    public function isCSRFAttempt()
    {
        //get Token from Cookie
        $cookie = $_COOKIE[self::CSRF_TOKEN];

        //get Token from Form variable
        $this->csrfToken = isset($_POST[self::CSRF_TOKEN]) ? $_POST[self::CSRF_TOKEN] : null;

        //comparison
        return $cookie !== $this->csrfToken;
    }

    /**
     * @param string $type
     * @param string $content
     */
    public function setMessage($type = self::ALERT_INFO, $content = "Empty")
    {
        $_SESSION[self::SESSION_MESSAGE] = [
            'type' => $type,
            'content' => $content
        ];
    }

    /**
     *
     */
    public function flushMessage()
    {
        unset($_SESSION[self::SESSION_MESSAGE]);
    }

    /**
     *
     */
    public final function execute()
    {
        $this->during();
        $this->after();
    }

    /**
     *
     */
    public final function after()
    {
        $this->flushMessage();
    }
}
