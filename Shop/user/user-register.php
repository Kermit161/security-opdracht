<?php
require "../includes/user-class.php";

try {
    
    session_start();
    
   
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $csrf_token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrf_token;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            throw new Exception("Invalid CSRF token.");
        }

        $user = new User();

        
        $name = htmlspecialchars(trim($_POST['name']));
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];

        if (!$email) {
            throw new Exception("Ongeldig e-mailadres.");
        }

     
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        $user->registerUser($name, $email, $hashed_password);

        echo "Registratie gelukt!";
        header("refresh:2, url=user-login.php");
        exit();
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
      
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Registreer">
    </form>
</body>
</html>
