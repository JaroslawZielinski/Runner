<?php

declare(strict_types=1);

require_once __DIR__ . '/autoload.php';

use DI\Container;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use FaaPz\PDO\Database;
use Invoker\InvokerInterface;
use JaroslawZielinski\Runner\Plugins\DotEnvSettings;
use JaroslawZielinski\Runner\Plugins\EasyStackTraceGenerator;
use JaroslawZielinski\Runner\Plugins\FastRouter;
use JaroslawZielinski\Runner\Plugins\FastRouterRoutings;
use JaroslawZielinski\Runner\Plugins\FastRouterRoutingsInterface;
use JaroslawZielinski\Runner\Plugins\MenuItems;
use JaroslawZielinski\Runner\Plugins\MenuItemsInterface;
use JaroslawZielinski\Runner\Plugins\Templates;
use JaroslawZielinski\Runner\Plugins\TemplatesInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Yaml\Yaml;
use function DI\create;
use function DI\factory;
use function DI\get;

class Application implements InvokerInterface
{
    /**
     * @var array
     */
    private $definitions;
    /**
     *
     * @var Container
     */
    private $container;

    public function __construct(array $definitions, Container $container)
    {
        $this->definitions = $definitions;
        $this->container = $container;

        session_start();

        ini_set('display_errors', '0');
    }

    /**
     * @throws Exception
     */
    public static function create(): Application
    {
        $definitions = [
            'log_file' => '../log/runner.log',
            'routes_file' => '../src/routes.yaml',
            'menuitems_file' => '../src/menu.yaml',
            'template_dir' => '../src/templates/',
            'env_path' => ['../', '.'],
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

                return new FastRouterRoutings($routes);
            }),
            TemplatesInterface::class => factory(function (ContainerInterface $c) {
                //templating system
                return new Templates(new Smarty(), $c->get('template_dir'));
            }),
            FastRouter::class => create(FastRouter::class)
                ->constructor(
                    get(FastRouterRoutingsInterface::class),
                    get(TemplatesInterface::class)
                ),
            EasyStackTraceGenerator::class => create(EasyStackTraceGenerator::class)
                ->constructor(
                    get(TemplatesInterface::class)
                ),
            DotEnvSettings::class => factory(function (ContainerInterface $c) {
                $dotEnv = Dotenv::create($c->get('env_path'));
                $envArr = $dotEnv->load();
                return new DotEnvSettings($envArr);
            }),
            DataBase::class => factory(function (ContainerInterface $c) {
                $dotEnvSettings = $c->get(DotEnvSettings::class);
                //dbase
                return new DataBase(
                    sprintf(
                        'mysql:host=%s;dbname=%s;charset=utf8',
                        $dotEnvSettings->get('DB_HOST'),
                        $dotEnvSettings->get('DB_DATABASE')
                    ),
                    'root',
                    $dotEnvSettings->get('DB_ROOT_PASSWORD')
                );
            }),
            MenuItemsInterface::class => factory(function (FastRouterRoutingsInterface $routerRoutings, ContainerInterface $c) {
                //menu Items configuration file
                $menuItems = Yaml::parseFile($c->get('menuitems_file'));

                return new MenuItems($routerRoutings, $menuItems);
            })
        ];

        $containerBuilder = new ContainerBuilder();

        $container = $containerBuilder
            ->addDefinitions($definitions)
            ->useAutowiring(true)
            ->useAnnotations(false)
            ->build();

        return new Application($definitions, $container);
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @throws Exception
     */
    public static function run(): int
    {
        $app = Application::create();
        $app->call('', []);
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function call($callable, array $parameters = [])
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
