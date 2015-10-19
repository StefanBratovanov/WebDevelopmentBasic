<?php

namespace Controllers;

use SF\DefaultController;
use SF\View;

class IndexController extends DefaultController
{

    public function index()
    {
//        $this->app->getInstance()->displayError(404);
        //  \SF\InputData::getInstance()->get(0, 'int');


        $this->view->appendToLayout('body', 'index');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->appendToLayout('header', 'header');

        $this->view->display('Layouts.default');
//        $this->view->display('Layouts.default', array('c' => array('pesho', 'gosho', 'mincho')), false);


//        $this->view->appendToLayout('body', 'Admin.index');
//        $this->view->appendToLayout('header', 'header');
//        $this->view->appendToLayout('footer', 'footer');
//        $this->view->display('Layouts.Admin.home', array('a', 'b', 'c'));

    }

}