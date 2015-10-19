<?php

namespace SF;

use SF\App;
use SF\InputData;
use SF\Routers\IRouter;

class FrontController
{
    const DEFAULT_CONTROLLER = 'Index';
    const DEFAULT_METHOD = 'index';

    private static $instance = null;
    private $namespace = null;
    private $controller = null;
    private $method = null;
    private $params = array();
    /**
     * @var IRouter
     */
    private $router = null;


    private function __construct()
    {
    }

    public function dispatch()
    {
        if ($this->router == null) {
            throw new \Exception('No valid router found', 500);
        }
        $uri = $this->router->getUri();

        $routesConfig = App::getInstance()->getConfig()->routes;
        $areaConfig = null;
//         var_dump($routesConfig);

        if (is_array($routesConfig) && count($routesConfig) > 0) {
            //check for areas -> higher precedence
            foreach ($routesConfig as $area => $content) {
                $area = strtolower($area);
                // check if the key(the area) of a rout is in the beginning of the uri
                if (stripos($uri, $area) === 0 &&
                    // check if area/  is in the beginning of the uri
                    ($uri == $area || stripos($uri, $area . '/') === 0) &&
                    $content['namespace']
                ) {
                    $this->namespace = $content['namespace'];
                    $areaConfig = $content;

                    // remove area from uri
                    $uri = substr($uri, strlen($area) + 1);
//                    var_dump($uri);
                    break;
                }
            }
        } else {
            throw new \Exception('Default route missing', 500);
        }

        //default routing(no areas)
        if ($this->namespace == null && $routesConfig['*']['namespace']) {
            $this->namespace = $routesConfig['*']['namespace'];
            $areaConfig = $routesConfig['*'];

        } else if ($this->namespace == null && !$routesConfig['*']['namespace']) {
            throw new \Exception('Default route missing', 500);
        }

        $input = InputData::getInstance();

        $params = explode('/', strtolower($uri));
//        var_dump($params);

        if ($params[0]) {
            $this->controller = ($params[0]);
            if ($params[1]) {
                $this->method = strtolower(trim($params[1]));

                unset($params[0], $params[1]);


                $this->params = array_values($params);
                $input->setGet(array_values($params));
            }
        } else {
            $this->controller = $this->getDefaultController();
            $this->method = $this->getDefaultMethod();
        }

        if (is_array($areaConfig) && $areaConfig['controllers']) {

            if ($areaConfig['controllers'][$this->controller]['methods'][$this->method]) {

                $this->method = strtolower($areaConfig['controllers'][$this->controller]['methods'][$this->method]);
            }
            if (isset($areaConfig['controllers'][$this->controller]['mapTo'])) {

                $this->controller = strtolower($areaConfig['controllers'][$this->controller]['mapTo']);
            }
        }

        $input->setPost($this->router->getPost());

//        var_dump($this->namespace);
//        var_dump($this->controller);
//        var_dump($this->method);
//        var_dump($this->params);


        $controllerFile = ucfirst($this->namespace) . '\\' . ucfirst($this->controller) . 'Controller';
//        var_dump($controllerFile);

        $controllerObject = new $controllerFile();
//        var_dump($controllerObject);

        $controllerObject->{$this->method}();
    }

    public
    function getDefaultController()
    {
        $controller = App::getInstance()->getConfig()->app['default_controller'];
        if ($controller) {
            return strtolower($controller);
        }
        return self::DEFAULT_CONTROLLER;
    }

    public
    function getDefaultMethod()
    {
        $method = App::getInstance()->getConfig()->app['default_method'];
        if ($method) {
            return strtolower($method);
        }
        return self::DEFAULT_METHOD;
    }

    /**
     * @return \SF\FrontController
     */
    public
    static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new FrontController();
        }
        return self::$instance;
    }

    /**
     * @return IRouter
     */
    public function getRouter()
    {
        return $this->router;
    }

    public function setRouter(IRouter $router)
    {
        $this->router = $router;
    }

}