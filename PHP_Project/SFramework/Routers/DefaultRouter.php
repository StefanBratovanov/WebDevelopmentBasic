<?php

namespace SF\Routers;

class DefaultRouter implements IRouter
{
    public function getUri()
    {
//        echo $_SERVER['PHP_SELF'] . '<br>';
//        echo $_SERVER['SCRIPT_NAME'] . '<br>';

//        var_dump(strtolower(substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1)));
//       var_dump(strtolower(ltrim ($_SERVER['REQUEST_URI'], '/')));
//        die;

        //return strtolower(ltrim ($_SERVER['REQUEST_URI'], '/'));
        return strtolower(substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1));


//        echo $uri. '<br>';

//        $params = explode('/', $uri);
    }

    public function getPost()
    {
        return $_POST;
    }

    public function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}

