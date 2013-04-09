<?php
/**
 * Loader
 *
 * @author Piotr Olaszewski
 */
namespace Psf;

class Loader
{
    private $_includePath = array();

    public function setIncludePath($path)
    {
        $this->_includePath[] = $path;
        return $this;
    }

    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
        return $this;
    }

    public function loadClass($loadClassName)
    {
        $classPath = $this->_getPathFromClassName($loadClassName);

        try {
            $this->tryIncludeClass($classPath);
        } catch (LoaderException $e) {
            print_r($e->getMessage() . PHP_EOL);
        }
    }

    public function tryIncludeClass($classPath)
    {
        $this->_includeFromClassPath($classPath);
    }

    private function _getPathFromClassName($className)
    {
        $fileClassPath = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        return $fileClassPath;
    }

    private function _includeFromClassPath($classPath)
    {
        foreach ($this->_includePath as $registredPath) {
            $filename = ROOT_PATH . $registredPath . $classPath . '.php';

            if (file_exists($filename)) {
                /** @noinspection PhpIncludeInspection */
                return require_once($filename);
            }
        }

        throw new LoaderException("Couldn't load class file - non path found");
    }
}

class LoaderException extends \Exception
{
}