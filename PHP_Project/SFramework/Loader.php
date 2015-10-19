<?php

namespace SF;

final class Loader
{
    private static $namespaces = array();

    private function __construct()
    {
    }

    public static function registerAutoload()
    {
        spl_autoload_register(array('\SF\Loader', "autoload"));
    }

    public static function autoload($class)
    {
        self::loadClass($class);
    }

    public static function registerNamespace($namespace, $path)
    {
        $namespace = trim($namespace);
        if (strlen($namespace) > 0) {
            if (!$path) {
                throw new \Exception('Invalid path.');
            }
            $realPath = realpath($path);
            if ($realPath && is_dir($realPath) && is_readable($realPath)) {
                self::$namespaces[$namespace . '\\'] = $realPath . DIRECTORY_SEPARATOR;
            }
        } else {
            throw new \Exception('Invalid namespace: ' . $namespace . '.');
        }
    }

    public static function registerNamespaces($namespaces) {
        if(is_array($namespaces)){
            foreach ($namespaces as $namespace => $path) {
                self::registerNamespace($namespace, $path);
            }
        } else {
            throw new \Exception('Invalid namespaces');
        }
    }

    private static function loadClass($class)
    {
        foreach (self::$namespaces as $namespace => $value) {
            if (strpos($class, $namespace) === 0) {
//                echo $namespace.'<br>'.$value.'<br>'.$class.'<br>';
                $file = str_replace('\\', DIRECTORY_SEPARATOR, $class);
                $file = substr_replace($file, $value, 0, strlen($namespace)) . '.php';
                $file = realpath($file);
                if($file && is_readable($file)){
                    include $file;
                } else {
                    throw new \Exception('File can not be included: ' . $file,404);
                }
//                echo $file;
                break;


            }
        }

    }
}