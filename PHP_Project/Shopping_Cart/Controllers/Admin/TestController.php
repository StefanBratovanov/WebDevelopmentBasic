<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/30/2015
 * Time: 13:21
 */

namespace Controllers\Admin;


use SF\DefaultController;

class TestController extends DefaultController
{
    public function _createMethod()
    {
        echo 'Create man';
    }

//    public function index()
//    {
//        echo 'Index';
//    }
}