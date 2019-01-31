<?php

require_once __DIR__ . '/autoload.php';

use DI\Container;
use DI\ContainerBuilder;
use function DI\create;
use function DI\factory;
use function DI\get;
use Dotenv\Dotenv;
use Invoker\InvokerInterface;
use JaroslawZielinski\Runner\Plugins\EasyStackTraceGenerator;
use JaroslawZielinski\Runner\Plugins\FastRouter;
use JaroslawZielinski\Runner\Plugins\FastRouterRoutings;
use JaroslawZielinski\Runner\Plugins\FastRouterRoutingsInterface;
use JaroslawZielinski\Runner\Plugins\Templates;
use JaroslawZielinski\Runner\Plugins\TemplatesInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\PDO\Database;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Application
 */
class Application implements InvokerInterface
{
    /**
     * @var array
     */
    protected $definitions;

    /**
     *
     * @var Container
     */
    protected $container;

    /**
     * Application constructor.
     * @param array $definitions
     * @param Container $container
     */
    public function __construct(array $definitions, Container $container)
    {
        $this->definitions = $definitions;
        $this->container = $container;

        session_start();
    }

    /**
     * @throws Exception
     */
    public static function create()
    {
        $definitions = [
            'log_file' => '../log/runner.log',
            'routes_file' => '../src/routes.yaml',
            'template_dir' => '../src/templates/',
            LoggerInterface::class => factory(function (ContainerInterface $c) {
                $logger = new Logger('Runner');

                $fileHandler = new StreamHandler($c->get('log_file'), Logger::DEBUG);
                $fileHandler->setFormatter(new LineFormatter());
                $logger->pushHandler($fileHandler);

                return $logger;
            }),
            FastRouterRoutingsInterface::class => factory(function (ContainerInterface $c) {
                //routes configuration file
                $routes = Yaml::parseFile($c->get('routes_file'));

                $fastRouterRoutings = new FastRouterRoutings($routes);

                return $fastRouterRoutings;
            }),
            FastRouter::class => create(FastRouter::class)
                ->constructor(
                    get(FastRouterRoutingsInterface::class),
                    get(TemplatesInterface::class)
                ),
            TemplatesInterface::class => factory(function (ContainerInterface $c) {
                //templating system
                return new Templates(new Smarty, $c->get('template_dir'));
            }),
            EasyStackTraceGenerator::class => create(EasyStackTraceGenerator::class)
                ->constructor(
                    get(TemplatesInterface::class)
                ),
            DataBase::class => factory(function (ContainerInterface $c) {
                $dotEnv = Dotenv::create('../');
                $envArr = $dotEnv->load();

                //dbase
                return new DataBase(sprintf("mysql:host=%s;dbname=%s;charset=utf8", $envArr['DB_HOST'], $envArr['DB_DATABASE']), "root", $envArr['DB_ROOT_PASSWORD']);
            })
        ];

        $containerBuilder = new ContainerBuilder;
        $container = $containerBuilder
            ->addDefinitions($definitions)
            ->useAutowiring(true)
            ->useAnnotations(false)
            ->build();

        return new Application($definitions, $container);
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return void
     * @throws Exception
     */
    public static function run()
    {
        $app = Application::create();
        $app->call('', []);
    }

    /**
     * @param callable $callable
     * @param array $parameters
     * @return mixed|void
     * @throws SmartyException
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function call($callable, array $parameters = array())
    {
        try {
            $router = $this->container->get(FastRouter::class);
            $router->call($this->container);
        } catch (Exception $exception) {
            $logger = $this->container->get(LoggerInterface::class);
            $logger->error($exception->getMessage(), $exception->getTrace());
            $this->container->get(EasyStackTraceGenerator::class)->call($exception);
        }
    }
}
