<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;

class CouponController
{

    private $couponModel;
    private $cartModel;

    function __construct()
    {
        $this->couponModel = new Coupon();
        $this->cartModel = new Cart();
    }

    public function store()
    {
        $couponPOST = filter_input(INPUT_POST, 'coupon', FILTER_DEFAULT);
        if (!$couponPOST || !is_string($couponPOST)) {
            return redirect('/cart', ['errors' => ['Cupom' => 'Cupom inválido!']]);
        }
        $coupon = $this->couponModel->findByName($couponPOST);
        if (!$coupon) {
            return redirect('/cart', ['errors' => ['Cupom' => 'Cupom inválido!']]);
        }
        $clientUsageCoupon = $this->cartModel->findCartByCouponAndUserId($coupon->id, $_SESSION['user']['id']);

        if ($clientUsageCoupon) {
            return redirect('/cart', ['errors' => ['Cupom' => 'Cupom já utilizado!']]);
        }
        
        $this->couponModel->setCouponSession([
            'id' => $coupon->id,
            'name' => $coupon->name,
            'discription' => $coupon->description,
            'discount' => $coupon->discount,
            'usage_limit' => $coupon->usage_limit
        ]);
        return redirect('/cart');
    }
}
