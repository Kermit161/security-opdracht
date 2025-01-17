<?php
require "db.php";

class Product {
    private $pdo;

    public function __construct() {
        $this->pdo = new DB();
    }

    // Voeg product toe, gebruik parameterized query om SQL-injectie te voorkomen
    public function addProduct($name, $description, $price, $productcode, $categoryId) 
    {
        $sql = "INSERT INTO product (name, description, price, productcode, category_id) 
                VALUES (:name, :description, :price, :productcode, :categoryId)";
        $args = [
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':productcode' => $productcode,
            ':categoryId' => $categoryId
        ];
        $this->pdo->run($sql, $args);
    }

    // Haal een product op via ID, gebruik parameterized query
    public function getProduct($productId) {
        $sql = "SELECT * FROM product WHERE id = :productId";
        $args = [':productId' => $productId];
        return $this->pdo->run($sql, $args)->fetch();
    }

    // Haal alle producten op, gebruik parameterized query
    public function getProducts() {
        $sql = "SELECT * FROM product";
        return $this->pdo->run($sql)->fetchAll();
    }

    // Haal alle categorieën op
    public function getCategory() {
        $sql = "SELECT * FROM category";
        return $this->pdo->run($sql)->fetchAll();
    }

    // Werk een product bij, gebruik parameterized query
    public function editProduct($id, $name, $description, $price, $productCode) {
        $sql = "UPDATE product SET 
                    name = :name, 
                    description = :description, 
                    price = :price, 
                    productCode = :productCode 
                WHERE id = :id";
        $args = [
            ':id' => $id,
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':productCode' => $productCode
        ];
        $this->pdo->run($sql, $args);
    }

    // Verwijder een product, gebruik parameterized query
    public function deleteProduct($productCode) {
        $sql = "DELETE FROM product WHERE productCode = :productCode";
        $args = [':productCode' => $productCode];
        $this->pdo->run($sql, $args);
    }
}
?>
