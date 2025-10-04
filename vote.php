<?php
// Fichier: vote.php
// API pour gérer les votes

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit();
}

// Récupérer les données JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Données invalides']);
    exit();
}

// Validation des champs obligatoires
$required = ['email', 'anneeLicence', 'voteCapitaine', 'voteSousCapitaine', 'voteCoach', 'voteCoordinateur'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => "Le champ $field est obligatoire"
        ]);
        exit();
    }
}

// Validation de l'année de licence
if ($data['anneeLicence'] != 2) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Seule l\'année 2 est autorisée pour voter'
    ]);
    exit();
}

// Validation de l'email
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Email invalide'
    ]);
    exit();
}

try {
    $conn = getDBConnection();
    
    // Insérer le vote
    $sql = "INSERT INTO votes (
        email, annee_licence, vote_capitaine, 
        vote_sous_capitaine, vote_coach, vote_coordinateur
    ) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([
        $data['email'],
        $data['anneeLicence'],
        $data['voteCapitaine'],
        $data['voteSousCapitaine'],
        $data['voteCoach'],
        $data['voteCoordinateur']
    ]);
    
    if ($result) {
        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Vote enregistré avec succès! Merci pour votre participation.',
            'id' => $conn->lastInsertId()
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Erreur lors de l\'enregistrement du vote'
        ]);
    }
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erreur serveur: ' . $e->getMessage()
    ]);
}
?>