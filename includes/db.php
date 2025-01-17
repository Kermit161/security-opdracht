<?php
class DB {
    protected $pdo;
    
    public function __construct($db = "shop", $user="root", $pwd="", $host="localhost") {
        try {
            // Verbeterde foutafhandeling
            $this->pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pwd, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Fouten als exceptions werpen
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Zorgt ervoor dat de resultaten als associatieve arrays worden teruggegeven
                PDO::ATTR_EMULATE_PREPARES => false, // Voorkomt dat PDO zijn eigen prepared statements emuleert
            ]);
        } catch(PDOException $e) {
            // Toon geen technische details, maar log deze wel ergens
            error_log("DB Connection failed: " . $e->getMessage());
            die("Er is iets mis met de verbinding. Probeer het later opnieuw.");
        }
    }

    /**
     * Voer een SQL-query uit met voorbereid statement
     * 
     * @param string $sql De SQL-query die uitgevoerd moet worden
     * @param array|null $args De argumenten voor de query (optioneel)
     * @return PDOStatement
     */
    public function run($sql, $args = null) 
    {
        // Zorg ervoor dat args altijd een array is, zelfs als het null is
        if (is_null($args)) {
            $args = [];
        }

        // Voer de statement uit
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($args);
            return $stmt;
        } catch (PDOException $e) {
            // Log de fout en geef een generieke foutmelding weer
            error_log("SQL Error: " . $e->getMessage());
            die("Er is iets mis met de databasequery. Probeer het later opnieuw.");
        }
    }
}
?>
