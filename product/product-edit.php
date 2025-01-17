<?php
require "../includes/product-class.php";
echo "<a class='btn btn-danger' href='../user/user-logout.php'>Logout</a>";

session_start();
if ($_SESSION['login_status'] != true) {
    header("Location: ../index.php");
    die();
}

if (!isset($_GET['productId'])) {
    echo "Selecteer eerst een product!";
    header("refresh:2, url = product-view.php");
}



try {
    $product = new Product();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $productCode = $_POST['productCode'];
        $price = $_POST['price'];
        $id = $_POST['productId']; 
        $product->editProduct($id, $name, $description, $price, $productCode);
        echo "Product edited!";
        header("refresh:2, url = product-view.php");
    } else {
        $id = $_GET['productId'];
        $thisProduct = $product->getProduct($id);
        $name = $thisProduct['name'];
        $description = $thisProduct['description'];
        $productCode = $thisProduct['productCode'];
        $price = $thisProduct['price'];        
    } 
}catch (Exception $e) {
    echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <h2>Edit product</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="productId" value="<?php echo $id; ?>"> 
        <input type="text" name="name" value="<?php echo $name; ?>" placeholder="Name" required>
        <input type="text" name="description" value="<?php echo $description; ?>" placeholder="Description" required>
        <input type="text" name="productCode" value="<?php echo $productCode; ?>" placeholder="ProductCode" required>
        <input type="number" name="price" value="<?php echo $price; ?>" min="1" step="any" required>
        <input type="submit">
    </form>
</body>
</html>