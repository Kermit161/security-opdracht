<?php
require "includes/user-class.php";
session_start();

// Redirect als gebruiker al ingelogd is
if (isset($_SESSION['login_status']) && $_SESSION['login_status'] == true) {
    header("Location: user/user-dashboard.php");
    exit();
}

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = new User();

        // Haal de formuliergegevens op en ontsmet ze voor XSS bescherming
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitize email
        $password = $_POST['password'];

        // Haal de gebruiker op uit de database op basis van het e-mailadres
        $userData = $user->loginUser($email);

        // Controleer of de gebruiker bestaat en het wachtwoord correct is
        if ($userData && password_verify($password, $userData['password'])) {
            $_SESSION['login_status'] = true;
            $_SESSION['name'] = htmlspecialchars($userData['naam'], ENT_QUOTES, 'UTF-8'); // Ontsmet de naam voor XSS bescherming
            header("Location: user/user-dashboard.php");
            exit();
        } else {
            echo "Ongeldige email of wachtwoord!";
            header("refresh:2, url=user/user-login.php");
            exit();
        }
    } 
} catch (Exception $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Inloggen</title>
</head>
<body>
<h2>Inloggen</h2>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Inloggen">
</form>
<a href="user/user-register.php">Nog geen account?</a>
</body>
</html>
