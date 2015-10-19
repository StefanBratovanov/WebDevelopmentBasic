<?php

namespace SF;


use SF\Sessions\ISession;
use SF\Sessions\NativeSession;

class DefaultController
{
    /**
     * @var App
     */
    protected $app;

    /**
     * @var View
     */
    protected $view;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var InputData
     */
    protected $input;

    /**
     * @var Validation
     */
    protected $validation;

    /**
     * @var ISession
     */
    protected $session;

    public function __construct()
    {
        $this->app = App::getInstance();
        $this->view = View::getInstance();
        $this->config = $this->app->getConfig();
        $this->input = InputData::getInstance();
        $this->validator = new Validation();
        $this->session = $this->app->getSession();
    }

    protected function redirect($uri)
    {
        header("Location: $uri");
    }
}