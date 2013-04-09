<?php
/**
 * Dispatcher
 *
 * @author Piotr Olaszewski
 */
namespace Psf;

use Psf\Input\ArgvParser;

class Dispatcher
{
    private $_userPassedArgv = array();

    static public function runScript($argv)
    {
        $dispatcher = new Dispatcher($argv);
        $dispatcher->dispatch();
    }

    public function __construct($argv)
    {
        $this->_userPassedArgv = $argv;
    }

    public function dispatch()
    {
        $this->parseInputArgv();

//        $executeShellScript = new \Console\HelloShell();
//        $executeShellScript->main();
    }

    public function parseInputArgv(array $argv = array())
    {
        $paramsToParse = (!empty($argv) ? $argv : $this->_userPassedArgv);

        $argvParsed = new ArgvParser($paramsToParse);
        $argvParsed
            ->parseParameters();
//        $argvParsed->getParsedParameters();
    }
}