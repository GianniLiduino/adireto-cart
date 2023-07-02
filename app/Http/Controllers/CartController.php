<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;

class CartController
{
    private $productModel;
    private $cartModel;

    function __construct()
    {
        $this->productModel = new Product();
        $this->cartModel = new Cart();
    }

    public function index()
    {
        if (isset($_SESSION['cart']['coupon'])) {
            $cart = $this->cartModel->getCart();
            $discount = $cart['total'] * ($cart['coupon']['discount'] / 100);
            $cart['discount'] = $discount;
            $cart['total_payable'] = $cart['total'] - $discount;
            $this->cartModel->setCart($cart);
        }
        $cart = new Cart();
        require dirname(__FILE__, 4) . '/pages/cart.php';
    }

    public function store()
    {
        $productId = filter_input(INPUT_GET, 'productId', FILTER_SANITIZE_NUMBER_INT);
        $product = $this->productModel->findById($productId);

        $cartProducts = $this->cartModel->getCartProductsSession();
        $cartTotal = $this->cartModel->getTotalCartSession();
        $cartQuantity = $this->cartModel->getCartQuantity();

        $productExists = false;

        if (array_key_exists($productId, $cartProducts)) {
            $cartProducts[$productId]['price'] = $cartProducts[$productId]['price'] + $product->price;
            $cartProducts[$productId]['quantity'] = $cartProducts[$productId]['quantity'] + 1;
            $productExists = true;
        }
        if ($productExists === false) {
            $cartProducts[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'quantity' => 1
            ];
        }

        $this->cartModel->setTotalCartSession($cartTotal + $product->price);
        $this->cartModel->setCartQuantity($cartQuantity + 1);
        $this->cartModel->setCartProductsSession($cartProducts);

        return redirect('/');
    }

    public function add()
    {
        $productId = filter_input(INPUT_GET, 'productId', FILTER_SANITIZE_NUMBER_INT);
        $product = $this->productModel->findById($productId);

        $cartProducts = $this->cartModel->getCartProductsSession();
        $cartTotal = $this->cartModel->getTotalCartSession();
        $cartQuantity = $this->cartModel->getCartQuantity();

        $productExists = false;

        if (array_key_exists($productId, $cartProducts)) {
            $cartProducts[$productId]['price'] = $cartProducts[$productId]['price'] + $product->price;
            $cartProducts[$productId]['quantity'] = $cartProducts[$productId]['quantity'] + 1;
            $productExists = true;
        }
        if ($productExists === false) {
            $cartProducts[$product->getId()] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->price,
                'quantity' => 1
            ];
        }

        $this->cartModel->setTotalCartSession($cartTotal + $product->price);
        $this->cartModel->setCartQuantity($cartQuantity + 1);
        $this->cartModel->setCartProductsSession($cartProducts);

        return redirect('/cart');
    }

    public function subtract()
    {
        $productId = filter_input(INPUT_GET, 'productId', FILTER_SANITIZE_NUMBER_INT);
        $product = $this->productModel->findById($productId);

        $cartProducts = $this->cartModel->getCartProductsSession();
        $cartTotal = $this->cartModel->getTotalCartSession();
        $cartQuantity = $this->cartModel->getCartQuantity();

        $cartProducts[$productId]['price'] = $cartProducts[$productId]['price'] - $product->price;
        $cartProducts[$productId]['quantity'] = $cartProducts[$productId]['quantity'] - 1;

        $this->cartModel->setTotalCartSession($cartTotal - $product->price);
        $this->cartModel->setCartQuantity($cartQuantity - 1);
        $this->cartModel->setCartProductsSession($cartProducts);

        return redirect('/cart');
    }

    public function remove()
    {
        $productId = filter_input(INPUT_GET, 'productId', FILTER_SANITIZE_NUMBER_INT);
        $product = $this->productModel->findById($productId);

        $cartProducts = $this->cartModel->getCartProductsSession();
        $cartTotal = $this->cartModel->getTotalCartSession();
        $cartQuantity = $this->cartModel->getCartQuantity();

        $productPrice = $cartProducts[$productId]['price'];
        $productQuantity = $cartProducts[$productId]['quantity'];

        unset($cartProducts[$productId]);

        $this->cartModel->setTotalCartSession($cartTotal - $productPrice);
        $this->cartModel->setCartQuantity($cartQuantity - $productQuantity);
        $this->cartModel->setCartProductsSession($cartProducts);


        return redirect('/cart');
    }

    public function save()
    {
        $cart = new Cart();
        $cart->setUserId($_SESSION['user']['id']);
        $cart->setProducts($_SESSION['cart']['products']);
        $cart->setTotal($_SESSION['cart']['total']);
        $cart->setTotalPayable($_SESSION['cart']['total_payable']);
        $cart->setCouponId($_SESSION['cart']['coupon']['id']);
        $cart->save();

        $cart->initCartSession();
        unset($_SESSION['cart']['coupon']);

        return redirect('/profile');
    }
}
