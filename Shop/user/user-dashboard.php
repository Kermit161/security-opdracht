<?php
session_start();


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
    <title>Dashboard</title>
</head>
<body>

    <div class="container mt-5">
        <h2>Welkom, <?php echo htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8'); ?>!</h2>
        <p>U bent ingelogd.</p>

        <a class="btn btn-info" href="../product/product-add.php">Producten pagina</a>
        <br><br>
        
    
        <?php
      
        $csrf_token = bin2hex(random_bytes(32)); 
        $_SESSION['csrf_token'] = $csrf_token;
        ?>
        <a class="btn btn-danger" href="user-logout.php?csrf_token=<?php echo $csrf_token; ?>">Logout</a>
    </div>

</body>
</html>
