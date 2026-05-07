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
    nom VARCHAR(50)
);

CREATE TABLE utilisateur_objectifs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    objectif_id INT,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (objectif_id) REFERENCES objectifs(id) ON DELETE CASCADE
);

CREATE TABLE regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    type ENUM('augmentation', 'reduction', 'IMC ideal'),
    prix DECIMAL(10, 2),
    date_debut DATE,
    date_fin DATE,
    variation_poids FLOAT,
    pourcentage_viande DECIMAL(5, 2),
    pourcentage_poisson DECIMAL(5, 2),
    pourcentage_volaille DECIMAL(5, 2)
);

CREATE TABLE regime_activite (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_regime INT,
    id_activite INT,
    FOREIGN KEY (id_regime) REFERENCES regimes(id) ON DELETE CASCADE,
    FOREIGN KEY (activites) REFERENCES activites(id) ON DELETE CASCADE
);

CREATE TABLE aliments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    calories INT,
    type VARCHAR(50)
);

CREATE TABLE activites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    date_activite DATE,
    calories_brulees INT
);

CREATE TABLE achats_regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    regime_id INT,
    prix_original DECIMAL(10, 2),
    prix_paye DECIMAL(10, 2),
    date_achat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
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