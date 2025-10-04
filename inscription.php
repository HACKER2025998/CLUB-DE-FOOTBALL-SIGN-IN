<?php
// Fichier: inscription.php
// API pour gérer les inscriptions des joueurs

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
$required = ['nom', 'prenoms', 'dateNaissance', 'email', 'poste', 'anneeLicence', 'maillot'];
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
        'message' => 'Seule l\'année 2 est autorisée pour l\'inscription'
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

// Validation du poste
$postes_valides = ['Milieu', 'Ailier', 'Attaquant', 'Défenseur', 'Gardien'];
if (!in_array($data['poste'], $postes_valides)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Poste invalide'
    ]);
    exit();
}

try {
    $conn = getDBConnection();
    
    // Vérifier si l'email existe déjà
    $stmt = $conn->prepare("SELECT id FROM inscriptions WHERE email = ?");
    $stmt->execute([$data['email']]);
    
    if ($stmt->fetch()) {
        http_response_code(409);
        echo json_encode([
            'success' => false,
            'message' => 'Cet email est déjà inscrit'
        ]);
        exit();
    }
    
    // Insérer l'inscription
    $sql = "INSERT INTO inscriptions (
        nom, prenoms, date_naissance, email, poste, 
        annee_licence, vote_capitaine, vote_sous_capitaine, 
        vote_coach, vote_coordinateur, maillot
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([
        $data['nom'],
        $data['prenoms'],
        $data['dateNaissance'],
        $data['email'],
        $data['poste'],
        $data['anneeLicence'],
        $data['voteCapitaine'] ?? null,
        $data['voteSousCapitaine'] ?? null,
        $data['voteCoach'] ?? null,
        $data['voteCoordinateur'] ?? null,
        $data['maillot']
    ]);
    
    if ($result) {
        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Inscription réussie! Bienvenue au club.',
            'id' => $conn->lastInsertId()
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Erreur lors de l\'inscription'
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