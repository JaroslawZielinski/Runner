<?php

namespace JaroslawZielinski\Runner\Bootstrap;

require __DIR__ . '/../vendor/autoload.php';

use ArrayAccess;
use DI\Container;
use DI\ContainerBuilder;
use Exception;
use Smarty;

class Application {

    /**
     * Configuration
     */
    protected $configuration;

    /**
     * DI Container
     *
     * @var Container
     */
    protected $container;

    /**
     * Application constructor.
     * @param ArrayAccess $configuration
     * @param Container $container
     * @throws \Exception
     */
    public function __construct(ArrayAccess $configuration, Container $container)
    {
        $this->configuration = $configuration;
        $this->container = $container;
    }

    /**
     *
     */
    public static function run()
    {
        try {
            $configuration = new Configuration([
                // Configure Templates
                Smarty::class => function () {
                    $smarty = new Smarty();

                    return $smarty;
                },
            ]);

            $containerBuilder = new ContainerBuilder;
            $container = $containerBuilder
                ->addDefinitions($configuration)
                ->useAutowiring(true)
                ->useAnnotations(false)
                ->build()
            ;

            $app = new Application($configuration, $container);

            return $app;
        } catch (Exception $exception) {

        }
    }

    /**
     * @return ArrayAccess
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param ArrayAccess $configuration
     * @return Application
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
        return $this;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param Container $container
     * @return Application
     */
    public function setContainer($container)
    {
        $this->container = $container;
        return $this;
    }
}