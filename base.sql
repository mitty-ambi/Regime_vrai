CREATE DATABASE regime_app;
USE regime_app;

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    mot_de_passe VARCHAR(255),
    genre ENUM('Homme', 'Femme'),
    is_gold BOOLEAN DEFAULT FALSE,
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
    type ENUM('augmentation', 'reduction', 'IMC ideal'),
    prix DECIMAL(10,2),
    duree INT,
    variation_poids FLOAT
);

CREATE TABLE aliments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    calories INT,
    type VARCHAR(50)
);

CREATE TABLE regime_aliments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    regime_id INT,
    aliment_id INT,
    FOREIGN KEY (regime_id) REFERENCES regimes(id) ON DELETE CASCADE,
    FOREIGN KEY (aliment_id) REFERENCES aliments(id) ON DELETE CASCADE
);

CREATE TABLE activites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    date_activite DATE,
    calories_brulees INT
);

CREATE TABLE historique_activites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    activite_id INT,
    date_historique TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (activite_id) REFERENCES activites(id) ON DELETE CASCADE
);

CREATE TABLE portefeuille (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    solde DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

CREATE TABLE codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE,
    montant DECIMAL(10,2),
    est_utilise BOOLEAN DEFAULT FALSE
);

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    code_id INT,
    montant DECIMAL(10,2),
    date_transaction TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (code_id) REFERENCES codes(id)
);

CREATE TABLE paiements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    offre VARCHAR(100),
    prix DECIMAL(10,2),
    benefice DECIMAL(10,2),
    statut ENUM('en_attente', 'valide', 'refuse') DEFAULT 'en_attente',
    date_paiement TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

CREATE TABLE achats_regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    regime_id INT,
    prix_paye DECIMAL(10,2),
    date_achat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (regime_id) REFERENCES regimes(id)
);

CREATE TABLE parametres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cle VARCHAR(100),
    valeur VARCHAR(255)
);
