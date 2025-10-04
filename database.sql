CREATE TABLE inscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenoms VARCHAR(100) NOT NULL,
    date_naissance DATE NOT NULL,
    email VARCHAR(150) NOT NULL,
    poste VARCHAR(50) NOT NULL,
    annee_licence INT NOT NULL,
    vote_capitaine VARCHAR(100),
    vote_sous_capitaine VARCHAR(100),
    vote_coach VARCHAR(100),
    vote_coordinateur VARCHAR(100),
    maillot VARCHAR(20),
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL,
    annee_licence INT NOT NULL,
    vote_capitaine VARCHAR(100) NOT NULL,
    vote_sous_capitaine VARCHAR(100) NOT NULL,
    vote_coach VARCHAR(100) NOT NULL,
    vote_coordinateur VARCHAR(100) NOT NULL,
    date_vote TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



