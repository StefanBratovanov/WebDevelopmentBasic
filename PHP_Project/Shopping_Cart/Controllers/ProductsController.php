<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/2/2015
 * Time: 15:32
 */

namespace Controllers;


use Models\BindingModels\ProductBindingModel;
use Models\ViewModels\ProductViewModel;
use SF\DataNormalizer;
use SF\DB\SimpleDB;
use SF\DefaultController;

class ProductsController extends DefaultController
{
    public function index()
    {
        $db = new SimpleDB();

        $params = $this->input->get(0);

        if (!$params) {

            $response = $db->prepare("SELECT
                           p.id, p.name, p.price, c.name as category
                            FROM products p
                            JOIN products_categories pc
                            ON p.id = pc.product_id
                            JOIN categories c
                            ON pc.category_id = c.id
                            ORDER BY p.id")->execute()->fetchAllAssoc();
        } else {
            $response = $db->prepare("SELECT
                           p.id, p.name, p.price, c.name as category
                            FROM products p
                            JOIN products_categories pc
                            ON p.id = pc.product_id
                            JOIN categories c
                            ON pc.category_id = c.id
                            WHERE p.id = $params
                            ORDER BY p.id")->execute()->fetchAllAssoc();
        }


//        var_dump($response);
        $products = array();
        foreach ($response as $p) {
            $product = new ProductViewModel(
                DataNormalizer::normalize($p['id'], 'xss|int'),
                $p['name'],
                DataNormalizer::normalize($p['price'], 'xss|double'),
                $p['category']);
            $products[] = $product;
        }
//        var_dump($products);


        $this->view->appendToLayout('products', 'products.index');
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('footer', 'footer');

        $this->view->display('layouts.products', $response);

    }
}


//http://localhost/PHP_Project/Shopping_Cart/Public/index.php/products/index