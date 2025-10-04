<?php

// Configuration de la connexion à la base de données

define('DB_HOST', 'localhost');
define('DB_USER', 'root');          
define('DB_PASS', '');              
define('DB_NAME', 'club_iai');

// Fonction pour créer la connexion
function getDBConnection() {
    try {
        $conn = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
        return $conn;
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Erreur de connexion à la base de données: ' . $e->getMessage()
        ]);
        exit();
    }
}
?>