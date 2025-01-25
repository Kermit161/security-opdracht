<?php
require "../includes/product-class.php";
session_start();


if (empty($_SESSION['login_status'])) {
    header("Location: ../index.php");
    exit();
}


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


if (empty($_GET['productId'])) {
    echo "Selecteer eerst een product!";
    header("refresh:2; url=product-view.php");
    exit();
}

try {
    $product = new Product();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      
        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Ongeldig verzoek! CSRF-token mismatch.");
        }

      
        $id = intval($_POST['productId']);
        $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8');
        $productCode = htmlspecialchars(trim($_POST['productCode']), ENT_QUOTES, 'UTF-8');
        $price = floatval($_POST['price']);

    
        $product->editProduct($id, $name, $description, $price, $productCode);
        echo "Product succesvol aangepast!";
        header("refresh:2; url=product-view.php");
        exit();
    } else {
       
        $id = intval($_GET['productId']);
        $thisProduct = $product->getProduct($id);

        $name = htmlspecialchars($thisProduct['name'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($thisProduct['description'], ENT_QUOTES, 'UTF-8');
        $productCode = htmlspecialchars($thisProduct['productCode'], ENT_QUOTES, 'UTF-8');
        $price = htmlspecialchars($thisProduct['price'], ENT_QUOTES, 'UTF-8');
    }
} catch (Exception $e) {
    echo "Fout: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>edit product</title>
</head>
<body>
    <div class="container">
        <h2>edit product</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="productId" value="<?= $id; ?>">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Naam</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $name; ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Beschrijving</label>
                <input type="text" class="form-control" id="description" name="description" value="<?= $description; ?>" required>
            </div>

            <div class="mb-3">
                <label for="productCode" class="form-label">Productcode</label>
                <input type="text" class="form-control" id="productCode" name="productCode" value="<?= $productCode; ?>" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Prijs</label>
                <input type="number" class="form-control" id="price" name="price" value="<?= $price; ?>" min="0.01" step="0.01" required>
            </div>

            <button type="submit" class="btn btn-primary">Opslaan</button>
            <a href="product-view.php" class="btn btn-secondary">Annuleren</a>
        </form>
    </div>
</body>
</html>
