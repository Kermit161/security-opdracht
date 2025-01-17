<?php
session_start();

// Controleer of de gebruiker ingelogd is
if ($_SESSION['login_status'] != true) {
    header("Location: ../index.php");
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Product Overzicht</title>
</head>
<body>
    <h2>Product overzicht</h2>
    <a class="btn btn-info" href="product-add.php">Toevoegen</a>
    <a class="btn btn-danger" href="../user/user-logout.php">Logout</a>

    <br><br>

    <table class="table table-dark">
        <tr>
            <th>ID</th>
            <th>ProductCode</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th colspan="2">Action</th>
        </tr>
        <?php
        require "../includes/product-class.php";

        try {
            $product = new Product();
            $products = $product->getProducts();

            foreach ($products as $product) {
                // Voorkom XSS door htmlspecialchars te gebruiken
                echo "<tr>";
                echo "<td>" . htmlspecialchars($product['id']) . "</td>";
                echo "<td>" . htmlspecialchars($product['productCode']) . "</td>";
                echo "<td>" . htmlspecialchars($product['name']) . "</td>";
                echo "<td>" . htmlspecialchars($product['description']) . "</td>";
                echo "<td>" . htmlspecialchars($product['price']) . "</td>";
                echo "<td><a class='btn btn-primary' href='product-edit.php?productId=" . htmlspecialchars($product['id']) . "'>Edit</a></td>";
                echo "<td><a class='btn btn-danger' href='product-delete.php?productId=" . htmlspecialchars($product['id']) . "'>Delete</a></td>";
                echo "</tr>";
            }
        } catch (Exception $e) {
            // Foutmeldingen loggen, maar niet aan de gebruiker tonen
            error_log("Fout bij ophalen van producten: " . $e->getMessage());
            echo "<tr><td colspan='7'>Er is een fout opgetreden bij het ophalen van de producten. Probeer het later opnieuw.</td></tr>";
        }
       ?>
    </table>
</body>
</html>
