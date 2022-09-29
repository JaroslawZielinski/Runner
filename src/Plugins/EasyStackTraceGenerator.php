<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Plugins;

use Invoker\InvokerInterface;

class EasyStackTraceGenerator implements InvokerInterface
{
    /**
     * @var TemplatesInterface
     */
    protected $templates;

    /**
     * @var \Smarty
     */
    protected $templateHandler;

    public function __construct(TemplatesInterface $templates)
    {
        $this->templates = $templates;

        $this->templateHandler = $this->templates->getHandler();
    }

    /**
     * {@inheritDoc}
     * @param \Exception $exception
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
