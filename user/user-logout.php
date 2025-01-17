<?php
session_start();

// Verwijder alle sessievariabelen
session_unset();

// Vernietig de sessie
session_destroy();

// Redirect naar de inlogpagina
header("Location: ../index.php");
exit(); // Zorg ervoor dat de scriptuitvoering stopt na de redirect
?>
