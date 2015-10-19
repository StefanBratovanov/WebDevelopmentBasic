<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/3/2015
 * Time: 11:48
 */

namespace Models\BindingModels;


use SF\DataNormalizer;

class ProductBindingModel
{
    private $name;
    private $price;
    private $category;

    function __construct(array $params)
    {
        $this->setName($params['name']);
        $this->setPrice($params['price']);
        $this->setCategory($params['category']);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }


    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = DataNormalizer::normalize($price, 'trim|double');
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }
}