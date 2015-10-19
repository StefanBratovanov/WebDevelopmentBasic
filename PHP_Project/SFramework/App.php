<?php

namespace SF;

use SF\Config;
use SF\FrontController;
use SF\Routers\DefaultRouter;
use SF\Routers\IRouter;
use SF\Sessions\ISession;
use SF\Sessions\NativeSession;
use SF\View;

include_once 'Loader.php';

class App
{
    private static $instance = null;
    /**
     * @var Config
     */
    private $config = null;
    /**
     * @var FrontController
     */
    private $frontController = null;
    private $router = null;
    private $dbConnections = array();
    /**
     * @var ISession
     */
    private $session = null;


    private function __construct()
    {
        set_exception_handler(array($this, 'exceptionHandler'));
        Loader::registerNamespace('SF', dirname(__FILE__) . DIRECTORY_SEPARATOR);
        Loader::registerAutoload();
        $this->config = Config::getInstance();
        if ($this->config->getConfigFolder() == null) {
            $this->setConfigFolder('../Config');
        }
    }

    public function run()
    {
        //if config folder is not set, use default config folder
        if ($this->config->getConfigFolder() == null) {
            $this->setConfigFolder('../Config');
        }

        $this->frontController = FrontController::getInstance();

        if ($this->router instanceof IRouter) {
            $this->frontController->setRouter($this->router);
        } else if ($this->router == 'JsonRPCRouter') {
            //TODO use JsonRPCRouter
            $this->frontController->setRouter(new DefaultRouter());
        } else if ($this->router == 'CLIRouter') {
            //TODO use CLIRouter
        } else {
            $this->frontController->setRouter(new DefaultRouter());
        }

        if ($this->session == null) {

            $session = $this->config->app['session'];
            if ($session['autostart']) {
                switch ($session['type']) {
                    case 'native':
                        $s = new NativeSession(
                            $session['name'],
                            $session['lifetime'],
                            $session['path'],
                            $session['domain'],
                            $session['secure']);
                        break;
                    default:
                        throw new \Exception('No valid session', 500);
                        break;
                }
                $this->setSession($s);
            }
        }


        $this->frontController->dispatch();
    }

    public function getDBConnection($connection = 'default')
    {
        if (!$connection) {
            throw new \Exception('No connection identifier provided', 500);
        }

        if ($this->dbConnections[$connection]) {
            return $this->dbConnections[$connection];
        }

        $dbConfig = $this->getConfig()->database;

        if (!$dbConfig[$connection]) {
            throw new \Exception('No valid connection identifier is provided in config file', 500);
        }

        $database = new \PDO(
            $dbConfig[$connection]['connection_uri'],
            $dbConfig[$connection]['username'],
            $dbConfig[$connection]['password'],
            $dbConfig[$connection]['pdo_options']
        );

        $this->dbConnections[$connection] = $database;
        return $database;
    }


    /**
     * @return App
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new App();
        }

        return self::$instance;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    public function getConfigFolder()
    {
        return $this->config->getConfigFolder();
    }

    public function setConfigFolder($path)
    {
        $this->config->setConfigFolder($path);
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function setRouter($router)
    {
        $this->router = $router;
    }

    public function  setSession(ISession $session)
    {
        $this->session = $session;
    }

    /**
     * @return ISession
     */
    public function getSession()
    {
        return $this->session;
    }

    public  function exceptionHandler(\Exception $ex){
        if($this->config && $this->config->app['displayException'] == true){
            echo '<p>' . print_r($ex, true) . '</p>';
        } else {
            $this->displayError($ex->getCode());
        }
    }

    public function displayError($errorCode)
    {
        try{
            $view = View::getInstance();
            $view->display($this->config->app['errorView'] , array($errorCode));
        } catch (\Exception $ex) {
            DataNormalizer::headerStatus($errorCode);
            echo "<h1> $errorCode </h1>";
            exit;
        }
    }
}