<?php
$host = "localhost"; // ou l'adresse donnée par ton hébergeur
$user = "root";      // sur XAMPP
$pass = "";          // mot de passe MySQL
$db   = "club_IAI";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Erreur connexion MySQL: " . mysqli_connect_error());
}
?>
