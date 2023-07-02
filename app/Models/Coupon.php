<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class Coupon extends Database
{
    private $id;
    private string $name;
    private string $description;
    private int $discount;
    private $usage_limit;
    private $created_at;
    private $updated_at;


    function __construct()
    {
        parent::__construct();
    }

    public function findByName($name)
    {
        $query = "SELECT * FROM coupons WHERE name = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    public function save()
    {
        $query = "INSERT INTO coupons (name, description, discount, usage_limit) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->getName(), PDO::PARAM_STR);
        $stmt->bindParam(2, $this->getDescription(), PDO::PARAM_STR);
        $stmt->bindParam(3, $this->getDiscount(), PDO::PARAM_INT);
        $stmt->bindParam(4, $this->getUsageLimit(), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchObject(Coupon::class);
    }

    public function setCouponSession($coupon)
    {
        $_SESSION['cart']['coupon'] = $coupon;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }

    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function setUsageLimit($usageLimit)
    {
        $this->usage_limit = $usageLimit;
    }

    public function getUsageLimit()
    {
        return $this->usage_limit;
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
