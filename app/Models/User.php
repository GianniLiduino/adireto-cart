<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class User extends Database
{
    private $id;
    private $first_name;
    private $last_name;
    private $email;
    private $email_verified_at;
    private $password;
    private $created_at;
    private $updated_at;

    function __construct()
    {
        parent::__construct();
    }

    public function create($data)
    {
        $user = new User();
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->save();
    }

    public function findById($userId)
    {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $userId, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchObject(User::class);
    }

    public function findByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchObject(User::class);
    }

    public function save()
    {
        $query = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->getFirstName(), PDO::PARAM_STR);
        $stmt->bindParam(2, $this->getLastName(), PDO::PARAM_STR);
        $stmt->bindParam(3, $this->getEmail(), PDO::PARAM_STR);
        $stmt->bindParam(4, $this->getPassword(), PDO::PARAM_STR);
        $stmt->execute();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmailVerifiedAt($emailVerifiedAt)
    {
        $this->email_verified_at = $emailVerifiedAt;
    }

    public function getEmailVerifiedAt()
    {
        return $this->email_verified_at;
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getPassword()
    {
        return $this->password;
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
