<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/2/2015
 * Time: 10:54
 */

namespace Controllers;


use Models\BindingModels\LoginBindingModel;
use SF\DB\SimpleDB;
use SF\DefaultController;

class UserController extends DefaultController
{

    public function login()
    {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        $loginArray = [];
        $loginArray[] = $user;
        $loginArray[] = $pass;

        $db = new SimpleDB();

        $db->prepare("SELECT id, username, isAdmin
                      FROM users
                      WHERE username = ? AND password = ?",
                      $loginArray);

        $response = $db->execute()->fetchAllAssoc();

        if (!$response) {
            throw new \Exception('No user matching provided username and password!', 400);

        }
        $id = $response[0]['id'];
        $username = $response['username'];
        $this->session->_login = $id;
        $this->session->_username = $user;

        $isAdmin = $response[0]['isAdmin'];

        if ($isAdmin == 1) {
            $this->redirect('http://localhost/PHP_Project/Shopping_Cart/Public/index.php/administration');

        } else {
            $this->redirect('http://localhost/PHP_Project/Shopping_Cart/Public/index.php/products/view');
        }

    }

    public function register()
    {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        $nameArray = [];
        $nameArray[] = $user;

        $db = new SimpleDB();

        $db->prepare("SELECT id
                      FROM users u
                      WHERE u.username = ?",
                      $nameArray);

        $response = $db->execute()->fetchRowAssoc();

        $id = $response['id'];

        if ($id !== null) {
            $username = $user;
            throw new \Exception("Username $username already taken!", 400);
        }
        $db->prepare("INSERT
                      INTO users
                      (username, password, money, isadmin,iseditor)
                      VALUES (?, ?, ?, ?, ?)",
                      array($user, $pass, 1500, 1, 0))->execute();

        $this->redirect('http://localhost/PHP_Project/Shopping_Cart/Public/index.php/products/view');
    }

}





