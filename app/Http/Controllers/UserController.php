<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;

class UserController
{
    private $userModel;
    private $cartModel;

    function __construct()
    {
        $this->userModel = new User();
        $this->cartModel = new Cart();
    }

    public function view()
    {
        $user = $this->userModel->findById($_SESSION['user']['id']);
        $carts = $this->cartModel->findCartByUserId($_SESSION['user']['id']);

        require dirname(__DIR__, 3) . '/pages/profile.php';
    }
}
