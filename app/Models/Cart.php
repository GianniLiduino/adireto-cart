<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class Cart extends Database
{
    private $id;
    private $user_id;
    private array $products = [];
    private $total;
    private $total_payable;
    private $coupon_id;
    private $created_at;
    private $updated_at;

    function __construct()
    {
        parent::__construct();
    }


    public function findCartByUserId($userId)
    {
        $query = "SELECT * FROM carts WHERE user_id = ? ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();
        $carts = [];
        while($row = $stmt->fetch()){
            $carts[] = [
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'products' => json_decode($row['products']),
                'total' => $row['total'],
                'total_payable' => $row['total_payable'],
                'coupon_id' => $row['coupon_id']
            ];
        }
        return $carts;
    }

    public function findCartByCouponAndUserId($couponId, $userId)
    {
        $query = "SELECT * FROM carts WHERE coupon_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $couponId, PDO::PARAM_INT);
        $stmt->bindParam(2, $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    public function save()
    {
        $query = "INSERT INTO carts (user_id, products, total, total_payable, coupon_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->getUserId(), PDO::PARAM_INT);
        $stmt->bindParam(2, json_encode($this->getProducts()), PDO::PARAM_STR);
        $stmt->bindParam(3, $this->getTotal(), PDO::PARAM_INT);
        $stmt->bindParam(4, $this->getTotalPayable(), PDO::PARAM_INT);
        $stmt->bindParam(5, $this->getCounponId(), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchObject();
    }

    public function initCartSession()
    {
        $this->initCouponIdSession();
        $this->initProductSession();
        $this->initTotalSession();
        $this->initQuantitySession();
    }

    public function setCart($cart)
    {
        $_SESSION['cart'] = $cart;
    }

    public function getCart()
    {
        return $_SESSION['cart'];
    }

    public function setTotalCartSession($total)
    {
        $_SESSION['cart']['total'] = $total;
    }

    public function getTotalCartSession()
    {
        return $_SESSION['cart']['total'];
    }

    public function setCartQuantity($quantity)
    {
        $_SESSION['cart']['quantity'] = $quantity;
    }
    public function getCartQuantity()
    {
        return $_SESSION['cart']['quantity'];
    }

    public function getCartProductsSession()
    {
        return $_SESSION['cart']['products'];
    }

    public function setCartProductsSession($products)
    {
        $_SESSION['cart']['products'] = $products;
    }

    public function setCouponIdSession($couponName)
    {
        $query = "SELECT * FROM coupons WHERE name = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $couponName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    public function getCouponIdSession()
    {
        return $_SESSION['cart']['couponId'];
    }

    public function initCouponIdSession()
    {
        $_SESSION['cart']['couponId'] = null;
    }
    public function initTotalSession()
    {
        $_SESSION['cart']['total'] = 0;
    }
    public function initQuantitySession()
    {
        $_SESSION['cart']['quantity'] = 0;
    }
    public function initDiscountSession()
    {
        $_SESSION['cart']['discount'] = 0;
    }
    public function initProductSession()
    {
        $_SESSION['cart']['products'] = [];
    }


    public function getId()
    {
        return $this->id;
    }

    public function setUserId($userId)
    {
        $this->user_id = $userId;
    }
    public function getUserId()
    {
        return $this->user_id;
    }
    public function setProducts($products)
    {
        $this->products = $products;
    }
    public function getProducts()
    {
        return $this->products;
    }
    public function setTotal($total)
    {
        $this->total = $total;
    }
    public function getTotal()
    {
        return $this->total;
    }
    public function setTotalPayable($totalPayable)
    {
        $this->total_payable = $totalPayable;
    }
    public function getTotalPayable()
    {
        return $this->total_payable;
    }
    public function setCouponId($couponId)
    {
        $this->coupon_id = $couponId;
    }
    public function getCounponId()
    {
        return $this->coupon_id;
    }
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}
