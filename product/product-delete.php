<?php
require "../includes/product-class.php";

// Controleer de login-status
session_start();
if ($_SESSION['login_status'] != true) {
    header("Location: ../index.php");
    die();
}

// Controleer of een productcode is meegegeven in de URL
if (!isset($_GET['productCode']) || !is_numeric($_GET['productCode'])) {
    echo "Selecteer eerst een geldig product!";
    header("refresh:2, url = product-view.php");
    exit();
}

try {
    $productCode = intval($_GET['productCode']); // Zorg ervoor dat de productcode een integer is

    $product = new Product();
    $product->deleteProduct($productCode); // Deleting the product by its productCode
    echo "Product verwijderd!";
    header("Location: product-view.php"); // Redirect naar product overzicht

} catch (\Exception $e) {
    // Foutafhandelingsbericht loggen, niet aan de gebruiker tonen
    error_log("Fout bij het verwijderen van product: " . $e->getMessage());
    echo "Er is een fout opgetreden bij het verwijderen van het product.";
    exit();
}
?>

