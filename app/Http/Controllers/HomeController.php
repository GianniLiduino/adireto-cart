<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController
{
    private $createdAt;
    private $updatedAt;

    private $productModel;

    function __construct()
    {
        $this->productModel = new Product();
    }

    public function index()
    {
        $products = $this->productModel->all();
        require dirname(__FILE__, 4) . '/pages/home.php';
    }
}
