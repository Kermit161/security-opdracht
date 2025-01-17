<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

<?php
    session_start();

    // Controleer of de gebruiker ingelogd is
    if (!isset($_SESSION['login_status']) || $_SESSION['login_status'] !== true) {
        // Redirect naar de loginpagina als de gebruiker niet ingelogd is
        header("Location: ../index.php");
        exit();
    }

    // Ontsnappen van de gebruikersnaam voor XSS-bescherming
    $username = htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8');

    echo "Welkom, $username! U bent ingelogd.";
    echo "<br><br>";
    echo "<a class='btn btn-info' href='../product/product-add.php'>Producten pagina</a>";
    echo "<br><br>";

    // Beveiligde logout link
    echo "<a class='btn btn-danger' href='user-logout.php'>Logout</a>";
?>

</body>
</html>
