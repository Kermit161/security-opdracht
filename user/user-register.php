<?php
require "../includes/user-class.php";

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = new User();

        // Haal de formuliergegevens op en ontsmet ze voor XSS bescherming
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitize email input
        $password = $_POST['password'];

        // E-mail validatie
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Ongeldig e-mailadres.");
        }

        // Hash het wachtwoord veilig
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Registreer de gebruiker
        $user->registerUser($name, $email, $hashedPassword);
        echo "Registratie gelukt!";
        header("refresh:2, url=user-login.php");
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
    <title>Account aanmaken</title>
</head>
<body>
    <h2>Account aanmaken</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Register">
    </form>
</body>
</html>
