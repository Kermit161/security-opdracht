<?php
require  "../includes/product-class.php";

session_start();
if ($_SESSION['login_status'] != true) {
    header("Location: ../index.php");
    die();
}
echo "<a class='btn btn-danger' href='../user/user-logout.php'>Logout</a>";
echo "<a class='btn btn-info' href='product-view.php'>Product overzicht</a>";

// CSRF Token genereren
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

try {
    $product = new Product();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // CSRF-token controleren
        if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('CSRF-token mismatch!');
        }

        // Verkrijg en valideren van de ingevoerde gegevens
        $name = htmlspecialchars(trim($_POST['name'])); // Voorkom XSS
        $productcode = htmlspecialchars(trim($_POST['productcode']));
        $description = htmlspecialchars(trim($_POST['description']));
        $price = floatval($_POST['price']);
        $categoryId = intval($_POST['categoryId']); // Zorg ervoor dat dit een integer is

        // Basis validatie
        if (empty($name) || empty($productcode) || empty($description) || empty($price) || empty($categoryId)) {
            echo "Alle velden moeten worden ingevuld.";
            exit();
        }

        // Voeg product toe
        $product->addProduct($name, $description, $price, $productcode, $categoryId);
        echo "Product toegevoegd!";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

