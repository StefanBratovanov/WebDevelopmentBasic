<?php

namespace SF;


use SF\App;

class View
{
    private static $instance = null;
    private $viewPath = null;
    private $viewData = array();
    private $viewDir = null;
    private $fileExtension = '.php';
    private $layoutParts = array();
    private $layoutData = array();

    private function __construct()
    {
        $this->viewPath = App::getInstance()->getConfig()->app['viewsDir'];
        if ($this->viewPath == null) {
            $this->viewPath = realpath('../Views/');
        }

    }

    /**
     * @return \SF\View
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new View();
        }

        return self::$instance;
    }

    public function __get($name)
    {
        return $this->viewData[$name];
    }

    public function __set($name, $value)
    {
        $this->viewData[$name] = $value;
    }

    public function setViewDirectory($path)
    {
        $path = trim($path);
        if ($path) {
            $path = realpath($path) . DIRECTORY_SEPARATOR;
            if (is_dir($path) && is_readable($path)) {
                $this->viewDir = $path;
            } else {
                throw new \Exception('Invalid view path', 500);
            }
        } else {
            throw new \Exception('Invalid view path', 500);
        }
    }

    public function display($name, $data = array(), $returnAsString = false)
    {
        if (is_array($data)) {
            $this->viewData = array_merge($this->viewData, $data);
        }

        if (count($this->layoutParts) > 0) {

            foreach ($this->layoutParts as $key => $template) {
                $templateContent = $this->includeFile($template);

                if ($templateContent) {
                    $this->layoutData[$key] = $templateContent;

                }
            }
//            var_dump($this->layoutData);
//            die();
        }

        if ($returnAsString) {
            return $this->includeFile($name);
        } else {
            echo $this->includeFile($name);
        }
    }

    private function includeFile($file)
    {
        if ($this->viewDir == null) {
            $this->setViewDirectory($this->viewPath);
        }
        $fullFileName = $this->viewDir . str_replace('.', DIRECTORY_SEPARATOR, $file) . $this->fileExtension;

        if (file_exists($fullFileName) && is_readable($fullFileName)) {
            //Turn on output buffering
            ob_start();

            include $fullFileName;

            //Get current buffer contents
            return ob_get_clean();
        } else {
            throw new \Exception('View ' . $file . ' cannot included', 500);
        }
    }

    public function appendToLayout($key, $template)
    {
        if ($key && $template) {
            $this->layoutParts[$key] = $template;
        } else {
            throw new \Exception('Layout key and template are required', 500);
        }
    }

    public function getLayoutData($layoutName)
    {
        return $this->layoutData[$layoutName];
    }
}