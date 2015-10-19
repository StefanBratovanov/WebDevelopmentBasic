<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/3/2015
 * Time: 20:14
 */

namespace Controllers\Admin;

use SF\DataNormalizer;
use SF\DB\SimpleDB;
use SF\DefaultController;

class ProductsController extends DefaultController
{
    public function view()
    {
//        echo "ai";
        $db = new SimpleDB();

        $productName = $_POST['productName'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        $categoryArray = [];
        $productArray = [];
        $productNameArray = [];
        $categoryArray[] = $category;
        $productArray[] = $productName;
        $productArray[] = $price;
        $productNameArray[] = $productName;

        $db->prepare("SELECT  id, name
                      FROM categories
                      WHERE name = ?",
            $categoryArray);
        $response = $db->execute()->fetchRowAssoc();
//
//        var_dump($response);die;

        $categoryId = $response['id'];
        if (!$response) {
            throw new \Exception("No category '$category'!", 404);
        }
        $db->prepare("INSERT
                      INTO products
                      (name, price)
                      VALUES (?, ?)",
            $productArray);
        $db->execute();

        $db->prepare("SELECT id
                      FROM products
                      WHERE name = ?",
            $productNameArray);
        $response = $db->execute()->fetchRowAssoc();

        $productId = DataNormalizer::normalize($response['id'], 'trim|int');

        $db->prepare("INSERT
                      INTO products_categories
                      (product_id, category_id)
                      VALUES (?, ?)",
            array($productId, $categoryId));
        $db->execute();

        $response = $this->getProducts($db);

//        var_dump($response);

        //$this->redirect('http://localhost/PHP_Project/Shopping_Cart/Public/index.php/products/view');

        $this->view->appendToLayout('adminBody', 'layouts.admin.main');
        $this->view->appendToLayout('products', 'products.index');
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('footer', 'footer');


        $this->view->display('layouts.admin.adminLayout',$response);



    }

    public function getProducts($db)
    {
        $params = $this->input->get(0);

        if (!$params) {

            $response = $db->prepare("SELECT
                           p.id, p.name, p.price, c.name as category
                            FROM products p
                            JOIN products_categories pc
                            ON p.id = pc.product_id
                            JOIN categories c
                            ON pc.category_id = c.id")->execute()->fetchAllAssoc();
        } else {
            $response = $db->prepare("SELECT
                           p.id, p.name, p.price, c.name as category
                            FROM products p
                            JOIN products_categories pc
                            ON p.id = pc.product_id
                            JOIN categories c
                            ON pc.category_id = c.id
                            WHERE p.id = $params")->execute()->fetchAllAssoc();
        }
        return $response;
    }


}


//$this->view->appendToLayout('adminBody', 'layouts.admin.main');
//        $this->view->appendToLayout('header', 'header');
//        $this->view->appendToLayout('footer', 'footer');
//        $this->view->appendToLayout('addProduct', 'add');
//
//        $this->view->display('Layouts.Admin.addProductLayout');