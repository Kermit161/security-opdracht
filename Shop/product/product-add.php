<?php
require "../includes/product-class.php";

session_start();
if (empty($_SESSION['login_status'])) {
    header("Location: ../index.php");
    die();
}

echo "<a class='btn btn-danger' href='../user/user-logout.php'>Logout</a>";
echo "<a class='btn btn-info' href='product-view.php'>Product overzicht</a>";

$product = new Product();
$message = "";

try {
    // CSRF-token genereren
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            throw new Exception("Ongeldig CSRF-token!");
        }

        // Validatie en sanitisatie
        $name = htmlspecialchars(trim($_POST['name']));
        $productcode = htmlspecialchars(trim($_POST['productcode']));
        $description = htmlspecialchars(trim($_POST['description']));
        $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
        $categoryId = filter_var($_POST['categoryId'], FILTER_VALIDATE_INT);

        if (!$price || !$categoryId) {
            throw new Exception("Ongeldige invoer voor prijs of categorie.");
        }

        $product->addProduct($name, $description, $price, $productcode, $categoryId);
        $message = "<div class='alert alert-success'>Product succesvol toegevoegd!</div>";
    }
} catch (Exception $e) {
    $message = "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Product toevoegen</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Product toevoegen</h2>
        <?= $message ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Naam" required>
            </div>
            <div class="mb-3">
                <input type="text" name="productcode" class="form-control" placeholder="Productcode" required>
            </div>
            <div class="mb-3">
                <input type="text" name="description" class="form-control" placeholder="Beschrijving" required>
            </div>
            <div class="mb-3">
                <input type="number" name="price" class="form-control" min="1" step="any" placeholder="Prijs" required>
            </div>
            <div class="mb-3">
                <select name="categoryId" class="form-select" required>
                    <option value="">Selecteer een categorie</option>
                    <?php 
                        $categories = $product->getCategory();
                        foreach ($categories as $category) {
                            echo "<option value='" . $category['id'] . "'>" . 
                            htmlspecialchars($category['name']) . "</option>";
                        }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Toevoegen</button>
        </form>
    </div>
</body>
</html>
