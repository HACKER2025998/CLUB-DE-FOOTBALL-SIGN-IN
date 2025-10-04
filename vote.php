<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $anneeLicence = $_POST['anneeLicence'];
    $capitaine = $_POST['voteCapitaine'];
    $sousCapitaine = $_POST['voteSousCapitaine'];
    $coach = $_POST['voteCoach'];
    $coordinateur = $_POST['voteCoordinateur'];

    $sql = "INSERT INTO votes (email, annee_licence, vote_capitaine, vote_sous_capitaine, vote_coach, vote_coordinateur)
            VALUES ('$email','$anneeLicence','$capitaine','$sousCapitaine','$coach','$coordinateur')";

    if (mysqli_query($conn, $sql)) {
        echo "Vote enregistré!";
    } else {
        echo "Erreur: " . mysqli_error($conn);
    }
}
?>
