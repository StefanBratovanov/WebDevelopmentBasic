<?php
/**
 * custom routing rules
 */

//the namespace we want to load  for administration area is 'Controllers\Admin'
$cnf['admin']['namespace'] = 'Controllers\Admin';
$cnf['administration']['namespace'] = 'Controllers\Admin';


//overriding the methods -> new method to be mapped to 'test'
$cnf['administration']['controllers']['index']['mapTo'] = 'index';
$cnf['administration']['controllers']['index']['methods']['new'] = '_newMethod';

//

//

//proucts
//overriding the methods -> view or list method to be mapped to 'index'
$cnf['*']['controllers']['products']['methods']['view'] = 'index';
$cnf['*']['controllers']['products']['methods']['list'] = 'index';

//default route
$cnf['*']['namespace'] = 'Controllers';
//
//
$cnf['*']['controllers']['user']['mapTo'] = 'user';
$cnf['*']['controllers']['user']['methods']['login'] = 'login';




return $cnf;




//$cnf['administration']['controllers']['index']['mapTo'] = 'test';
//$cnf['administration']['controllers']['index']['methods']['new'] = '_newMethod';
//http://localhost/PHP_Project/Shopping_Cart/Public/index.php/administration/index/new   -> test controller; _newMethod method

//$cnf['administration']['controllers']['new']['mapTo'] = 'create';
//$cnf['administration']['controllers']['new']['methods']['new'] = '_createMethod';
//http://localhost/PHP_Project/Shopping_Cart/Public/index.php/administration/new      -> create controller; '_createMethod'


http://localhost/PHP_Project/Shopping_Cart/Public/index.php/administration/