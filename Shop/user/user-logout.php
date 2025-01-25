<?php
session_start();


if (isset($_GET['csrf_token']) && $_GET['csrf_token'] === $_SESSION['csrf_token']) {
  
    session_unset();
    session_destroy();
    echo "Logged out. You will be redirected shortly.";
    header("Refresh: 2; url=../index.php");
    exit();
} else {
  
    die("Invalid request. CSRF token mismatch.");
}
?>
