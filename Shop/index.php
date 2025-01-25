<?php
require "includes/user-class.php";
session_start();


if (isset($_SESSION['login_status']) && $_SESSION['login_status'] == true) {
    header("Location: user/user-dashboard.php");
    exit();
}

try {
  
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = new User();

      
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];

        if (!$email) {
            throw new Exception("Ongeldig e-mailadres.");
        }

        
        $userData = $user->loginUser($email);

        if ($userData && password_verify($password, $userData['password'])) {
         
            session_regenerate_id(true);

            
            $_SESSION['login_status'] = true;
            $_SESSION['name'] = $userData['naam'];

            
            header("Location: user/user-dashboard.php");
            exit();
        } else {
            echo "Ongeldige email of wachtwoord!";
            header("refresh:2, url = user/user-login.php");
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
    <title>Login</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Login</h2>
        <form method="POST">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Inloggen</button>
        </form>
        <br>
        <a href="user/user-register.php">Nog geen account? Registreer hier!</a>
    </div>
</body>
</html>
