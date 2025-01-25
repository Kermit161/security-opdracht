<?php
require "db.php";

class User {
    private $pdo;

    
    public function __construct(DB $db) {
        $this->pdo = $db;
    }

    
    public function registerUser(string $name, string $email, string $password): bool {
        $hash = password_hash($password, PASSWORD_DEFAULT); 
        $stmt = $this->pdo->run(
            "INSERT INTO user (name, email, password) VALUES (:name, :email, :password)",
            [
                ':name' => $name,
                ':email' => $email,
                ':password' => $hash
            ]
        );
        return $stmt ? true : false;
    }

    
    public function loginUser(string $email, string $password): bool {
        $user = $this->pdo->run(
            "SELECT * FROM user WHERE email = :email",
            [':email' => $email]
        )->fetch();

        if ($user && password_verify($password, $user['password'])) {
            
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ];
            return true;
        }
        return false;
    }
}
