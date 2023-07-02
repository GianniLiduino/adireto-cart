<?php

use App\Classes\Router;

$router = new Router();

// Auth routes
$router->newRouter('GET', '/login', 'AuthController', 'showLoginForm');
$router->newRouter('POST', '/login', 'AuthController', 'login');
$router->newRouter('GET', '/register', 'AuthController', 'showRegisterForm');
$router->newRouter('POST', '/register', 'AuthController', 'register');
$router->newRouter('GET', '/logout', 'AuthController', 'logout');

// Home routes
$router->newRouter('GET', '/', 'HomeController', 'index');

// Cart routes
$router->newRouter('GET', '/cart', 'CartController', 'index', 'isAuth');
$router->newRouter('GET', '/cart-store', 'CartController', 'store', 'isAuth');
$router->newRouter('GET', '/cart-add', 'CartController', 'add', 'isAuth');
$router->newRouter('GET', '/cart-subtract', 'CartController', 'subtract', 'isAuth');
$router->newRouter('GET', '/cart-remove', 'CartController', 'remove', 'isAuth');
$router->newRouter('POST', '/cart', 'CartController', 'save', 'isAuth');

// Profile routes
$router->newRouter('GET', '/profile', 'UserController', 'view', 'isAuth');

// Coupon routes
$router->newRouter('POST', '/coupon-add', 'CouponController', 'store', 'isAuth');

$router->init();