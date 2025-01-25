<?php
session_start();


if ($_SESSION['login_status'] != true) {
    header("Location: ../index.php");
    die();
}

if ($_SESSION['user_role'] != 'admin') {
    die("Access denied. You don't have permission to view or modify products.");
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
    <h2>Product Overzicht</h2>
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

        
        $product = new Product($db); 
        $products = $product->getProducts();  

    
        foreach ($products as $product) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($product['id'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($product['productCode'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td><a class='btn btn-primary' href='product-edit.php?productId=" . htmlspecialchars($product['id'], ENT_QUOTES, 'UTF-8') . "'>Edit</a></td>";
            echo "<td><a class='btn btn-danger' href='product-delete.php?productId=" . htmlspecialchars($product['id'], ENT_QUOTES, 'UTF-8') . "'>Delete</a></td>";
            echo "</tr>";   
        }
        ?>
    </table>
</body>
</html>
