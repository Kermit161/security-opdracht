<?php
require "db.php";

class User {
    private $pdo;

    public function __construct() {
        $this->pdo = new DB();
    }

    /**
     * Registreer een gebruiker, met veilige wachtwoord-hashing (bcrypt)
     * 
     * @param string $name
     * @param string $email
     * @param string $password
     */
    public function registerUser(String $name, String $email, String $password) {
        // Gebruik bcrypt voor het hashen van het wachtwoord
        $hash = password_hash($password, PASSWORD_BCRYPT);
        
        // Gebruik prepared statements om SQL-injectie te voorkomen
        $sql = "INSERT INTO user (name, email, password) VALUES (:name, :email, :password)";
        $args = [
            ':name' => $name,
            ':email' => $email,
            ':password' => $hash
        ];

        // Voer de query uit
        $this->pdo->run($sql, $args);
    }

    /**
     * Log een gebruiker in door het wachtwoord te controleren
     * 
     * @param string $email
     * @param string $password
     * @return mixed
     */
    public function loginUser($email, $password) {
        // Haal de gebruiker op via hun emailadres
        $sql = "SELECT * FROM user WHERE email = :email";
        $args = [':email' => $email];
        $user = $this->pdo->run($sql, $args)->fetch();

        // Controleer of het wachtwoord overeenkomt met de hash in de database
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Gebruiker ingelogd
        } else {
            return null; // Fout wachtwoord
        }
    }
}
?>
