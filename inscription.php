<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenoms = $_POST['prenoms'];
    $dateNaissance = $_POST['dateNaissance'];
    $email = $_POST['email'];
    $poste = $_POST['poste'];
    $anneeLicence = $_POST['anneeLicence'];
    $maillot = $_POST['maillot'];
    $voteCapitaine = $_POST['voteCapitaine'];
    $voteSousCapitaine = $_POST['voteSousCapitaine'];
    $voteCoach = $_POST['voteCoach'];
    $voteCoordinateur = $_POST['voteCoordinateur'];

    $sql = "INSERT INTO joueurs (nom, prenoms, date_naissance, email, poste, annee_licence, maillot, vote_capitaine, vote_sous_capitaine, vote_coach, vote_coordinateur)
            VALUES ('$nom','$prenoms','$dateNaissance','$email','$poste','$anneeLicence','$maillot','$voteCapitaine','$voteSousCapitaine','$voteCoach','$voteCoordinateur')";

    if (mysqli_query($conn, $sql)) {
        echo "Inscription réussie!";
    } else {
        echo "Erreur: " . mysqli_error($conn);
    }
}
?>
