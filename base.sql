CREATE DATABASE regime_app;

USE regime_app;

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    mot_de_passe VARCHAR(255),
    genre ENUM('Homme', 'Femme'),
    is_gold BOOLEAN DEFAULT FALSE,
    solde DECIMAL(10, 2) DEFAULT 0.00,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sante (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    taille FLOAT,
    poids FLOAT,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

CREATE TABLE objectifs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL,
    nom VARCHAR(50)
);

CREATE TABLE utilisateur_objectifs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    objectif_id INT NOT NULL,
    statut ENUM('actif', 'atteint', 'abandonne') DEFAULT 'actif',
    date_debut DATETIME DEFAULT CURRENT_TIMESTAMP,
    duree INT,
    poids_initial DECIMAL(5, 2) NULL,
    poids_cible DECIMAL(5, 2) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (objectif_id) REFERENCES objectifs(id) ON DELETE CASCADE
);

CREATE TABLE regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    type ENUM('augmentation', 'reduction', 'IMC ideal'),
    prix DECIMAL(10, 2),
    duree INT,
    variation_poids FLOAT,
    pourcentage_viande DECIMAL(5, 2),
    pourcentage_poisson DECIMAL(5, 2),
    pourcentage_volaille DECIMAL(5, 2)
);

CREATE TABLE activites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    calories_brulees INT
);

CREATE TABLE regime_activite (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_regime INT,
    id_activite INT,
    FOREIGN KEY (id_regime) REFERENCES regimes(id) ON DELETE CASCADE,
    FOREIGN KEY (id_activite) REFERENCES activites(id) ON DELETE CASCADE
);

CREATE TABLE aliments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    calories INT,
    type VARCHAR(50)
);

CREATE TABLE achats_regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    regime_id INT,
    prix_original DECIMAL(10, 2),
    prix_paye DECIMAL(10, 2),
    date_achat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    statu ENUM('en cours', 'termine', 'annule') DEFAULT 'en cours',
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (regime_id) REFERENCES regimes(id)
);

CREATE TABLE codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE,
    montant DECIMAL(10, 2),
    est_utilise BOOLEAN DEFAULT FALSE
);

CREATE TABLE transactions_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    code_id INT,
    montant_credite DECIMAL(10, 2),
    date_transaction TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (code_id) REFERENCES codes(id)
);

INSERT INTO
    objectifs (code, nom)
VALUES
    ('AUG', 'Augmenter son poids'),
    ('RED', 'Réduire son poids'),
    ('IMC-IDEAL', 'Atteindre son IMC idéal');

CREATE TABLE parametre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    imc_ideal DECIMAL(10, 2)
);

INSERT INTO
    parametre (imc_ideal)
VALUES
    (22);

INSERT INTO
    activites (nom, calories_brulees)
VALUES
    ('Course à pied', 600),
    ('Musculation', 400),
    ('Natation', 500),
    ('Vélo', 550),
    ('Yoga', 200);

INSERT INTO
    regimes (
        nom,
        type,
        prix,
        duree,
        variation_poids,
        pourcentage_viande,
        pourcentage_poisson,
        pourcentage_volaille
    )
VALUES
    (
        'Hyper Protéiné',
        'augmentation',
        49.99,
        4,
        3.5,
        50,
        20,
        30
    ),
    (
        'Équilibré',
        'IMC ideal',
        39.99,
        4,
        0,
        33,
        33,
        34
    ),
    (
        'Pescetarien',
        'reduction',
        44.99,
        4,
        -1.5,
        0,
        60,
        40
    ),
    (
        'Light Volaille',
        'reduction',
        34.99,
        4,
        -2.5,
        10,
        20,
        70
    ),
    (
        'Mixte Complet',
        'IMC ideal',
        44.99,
        4,
        0,
        40,
        20,
        40
    );

INSERT INTO
    utilisateurs (nom, email, mot_de_passe, genre, is_gold, solde)
VALUES
    (
        'Alice Martin',
        'alice@email.com',
        'password',
        'Femme',
        0,
        50.00
    ),
    (
        'Thomas Durand',
        'thomas@email.com',
        'password',
        'Homme',
        0,
        0.00
    ),
    (
        'Julie Petit',
        'julie@email.com',
        'password',
        'Femme',
        1,
        120.00
    ),
    (
        'Marc Lefevre',
        'marc@email.com',
        'password',
        'Homme',
        0,
        10.00
    ),
    (
        'Sophie Bernard',
        'sophie@email.com',
        'password',
        'Femme',
        0,
        30.00
    );

INSERT INTO
    sante (utilisateur_id, taille, poids)
VALUES
    (1, 165, 70),
    (2, 180, 85),
    (3, 170, 62),
    (4, 175, 95),
    (5, 160, 55);

INSERT INTO
    utilisateur_objectifs (utilisateur_id, objectif_id)
VALUES
    (1, 2),
    (1, 3),
    (2, 1),
    (2, 3),
    (3, 2),
    (4, 1),
    (5, 2),
    (5, 3);

INSERT INTO
    achats_regimes (
        utilisateur_id,
        regime_id,
        prix_original,
        prix_paye
    )
VALUES
    (1, 4, 34.99, 34.99),
    (2, 1, 49.99, 49.99),
    (3, 4, 34.99, 29.74),
    (4, 1, 49.99, 49.99),
    (5, 3, 44.99, 44.99);

INSERT INTO
    codes (code, montant, est_utilise)
VALUES
    ('CODE10', 10.00, 0),
    ('CODE20', 20.00, 0),
    ('CODE05', 5.00, 0),
    ('CODE15', 15.00, 0),
    ('CODE25', 25.00, 0),
    ('WELCOME', 10.00, 0),
    ('SANTE10', 10.00, 0),
    ('GOLD15', 15.00, 0),
    ('REGIME5', 5.00, 0),
    ('SPORT10', 10.00, 0),
    ('CODE30', 30.00, 0),
    ('CODE08', 8.00, 0),
    ('CODE12', 12.00, 0),
    ('CODE18', 18.00, 0),
    ('CODE22', 22.00, 0);

INSERT INTO
    transactions_codes (utilisateur_id, code_id, montant_credite)
VALUES
    (1, 1, 10.00),
    (3, 7, 10.00),
    (5, 3, 5.00);

-- Ajouter la colonne photo_profil à la table utilisateurs
ALTER TABLE
    utilisateurs
ADD
    COLUMN photo_profil VARCHAR(255) NULL
AFTER
    email;

-- Mettre à jour les utilisateurs existants avec une valeur NULL
UPDATE
    utilisateurs
SET
    photo_profil = NULL
WHERE
    photo_profil IS NULL;