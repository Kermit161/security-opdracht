<?php
class Product {
    private $pdo;

    
    public function __construct(DB $db) {
        $this->pdo = $db;
    }

    
    public function addProduct($name, $description, $price, $productCode, $categoryId) {
        $stmt = $this->pdo->run(
            "INSERT INTO product (name, description, price, productcode, category_id) VALUES 
                (:name, :description, :price, :productCode, :categoryId)",
            [
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':productCode' => $productCode,
                ':categoryId' => $categoryId
            ]
        );
        return $stmt;
    }

    
    public function getProduct($productId) {
        return $this->pdo->run(
            "SELECT * FROM product WHERE id = :productId",
            [':productId' => $productId]
        )->fetch();
    }

    
    public function getProducts() {
        return $this->pdo->run("SELECT * FROM product")->fetchAll();
    }

    
    public function getCategory() {
        return $this->pdo->run("SELECT * FROM category")->fetchAll();
    }

    
    public function editProduct($id, $name, $description, $price, $productCode) {
        $stmt = $this->pdo->run(
            "UPDATE product SET name = :name, 
            description = :description, 
            price = :price,
            productCode = :productCode         
            WHERE id = :id",
            [
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':productCode' => $productCode,
                ':id' => $id
            ]
        );
        return $stmt;
    }

    
    public function deleteProduct($productCode) {
        return $this->pdo->run(
            "DELETE FROM product WHERE productCode = :productCode",
            [':productCode' => $productCode]
        );
    }
}
