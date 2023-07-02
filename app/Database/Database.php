<?php

namespace App\Database;

use Exception;
use PDO;

class Database
{
    protected $conn;

    function __construct()
    {
        $this->conn = $this->newConnection();
    }

    public function newConnection()
    {
        try {
            $conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';', DB_USER, DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
