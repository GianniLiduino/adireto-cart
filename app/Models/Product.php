<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class Product extends Database
{

    private $id;
    private $name;
    private $price;
    private $description;
    private $image_path;
    private $created_at;
    private $updated_at;

    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        $query = "SELECT * FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $product = new Product();
            $product->setId($row['id']);
            $product->setName($row['name']);
            $product->setPrice($row['price']);
            $product->setDescription($row['description']);
            $product->setCreatedAt($row['created_at']);
            $product->setUpdatedAt($row['updated_at']);
            $products[] = $product;
        }
        return $products;
    }

    public function findById($productId)
    {
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    public function setId($id)
    {
        $this->id = $id;
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
    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }

    public function setImagePath($imagePath)
    {
        $this->image_path = $imagePath;
    }

    public function getImagePath()
    {
        return $this->image_path;
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
