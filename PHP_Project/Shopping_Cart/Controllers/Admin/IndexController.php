<?php

namespace Controllers\Admin;

use SF\DefaultController;
use SF\Validation;

class IndexController extends DefaultController
{
    public function index()
    {
        $this->view->appendToLayout('adminBody', 'layouts.admin.main');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('addProduct', 'add');

        $this->view->display('layouts.admin.addProductLayout');
    }

    public function _newMethod()
    {
        echo 'New method comes here';
    }
}

//public function index()
//{
//
//    $model = 'test model';
//    $validaton = new Validation();
//    $validModel = $validaton->setRules('minlength', $model, 20, 'invalid lenght')->validate();
//    if (!$validModel) {
//        $model = $validaton->getErrors()[0];
//    }
//
//
//    $this->view->appendToLayout('adminBody', 'layouts.admin.main');
//    $this->view->appendToLayout('footer', 'footer');
//    $this->view->appendToLayout('header', 'header');
//
//    $this->view->display('layouts.admin.adminLayout',array('model' => $model, 0 => 1, 'Admin' => "no"));
//}