<?php
class DB {
    protected $pdo;

    public function __construct($db = "shop", $user = "root", $pwd = "", $host = "localhost") {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pwd);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Connection failed: " . $e->getMessage());
            die("Database connection error.");
        }
    }

    public function run($sql, $args = null) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($args);
            return $stmt;
        } catch (PDOException $e) {
            error_log("SQL error: " . $e->getMessage());
            die("A database error occurred.");
        }
    }
}
