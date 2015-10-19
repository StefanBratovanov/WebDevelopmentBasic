<?php
//the only backend file web webServer has access to -> for security reasons
use SF\App;

error_reporting(E_ALL ^ E_NOTICE);

include "../../SFramework/App.php";

$app = App::getInstance();
//var_dump($app->getDBConnection('default'));


$db = new \SF\DB\SimpleDB();


//var_dump($s);

//$a = $db->prepare('SELECT * FROM products')->execute()->fetchAllAssoc();
//$b = $db->prepare('SELECT * FROM users WHERE id=?',array(1))->execute()->fetchAllAssoc();
//var_dump($a);

$app->run();

//$app->getSession()->counter += 1;
//echo $app->getSession()->counter;
