<?php
require "../includes/product-class.php";


session_start();
if (empty($_SESSION['login_status'])) {
    header("Location: ../index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['csrf_token'])) {
    if (!hash_equals($_SESSION['csrf_token'], $_GET['csrf_token'])) {
        die("Ongeldig verzoek! CSRF-token mismatch.");
    }
} else {
    die("Ongeldig verzoek! CSRF-token ontbreekt.");
}


if (empty($_GET['productCode'])) {
    echo "Selecteer eerst een product!";
    header("refresh:2; url=product-view.php");
    exit();
}


try {
    $product = new Product();


    $productCode = htmlspecialchars($_GET['productCode'], ENT_QUOTES, 'UTF-8');

    $product->deleteProduct($productCode);
    echo "Product succesvol verwijderd!";
    header("refresh:2; url=product-view.php");
    exit();
} catch (Exception $e) {
    echo "Fout bij het verwijderen van het product.";
    error_log("Delete product error: " . $e->getMessage());
    exit();
}
?>
