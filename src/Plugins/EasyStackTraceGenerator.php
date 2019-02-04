<?php

namespace JaroslawZielinski\Runner\Plugins;

use Exception;
use Invoker\InvokerInterface;
use Smarty;

class EasyStackTraceGenerator implements InvokerInterface
{
    /**
     * @var TemplatesInterface
     */
    protected $templates;

    /**
     * @var Smarty
     */
    protected $templateHandler;

    /**
     * EasyStackTraceGenerator constructor.
     * @param TemplatesInterface $templates
     */
    public function __construct(TemplatesInterface $templates)
    {
        $this->templates = $templates;

        $this->templateHandler = $this->templates->getHandler();
    }


    /**
     * Call the given function using the given parameters.
     *
     * @param Exception $exception
     * @param array $parameters Parameters to use.
     *
     * @return mixed Result of the function.
     * @throws \SmartyException
     */
    public function call($exception, array $parameters = array())
    {
        $trace = explode("\n", $exception->getTraceAsString());

        // reverse array to make steps line up chronologically
        $trace = array_reverse($trace);

        array_shift($trace); // remove {main}
        array_pop($trace); // remove call to this method

        $length = count($trace);
        $result = [];

        for ($i = 0; $i < $length; $i++) {
            $result[] = ($i + 1) . ')' . substr($trace[$i], strpos($trace[$i], ' ')); // replace '#someNum' with '$i)', set the right ordering
        }

        $this->templateHandler->assign('message', $exception->getMessage());
        $this->templateHandler->assign('results', implode("\n", $result));

        $this->templateHandler->display($this->templates->getTemplateDir() . 'exception.tpl');
    }
}
