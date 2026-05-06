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
    nom VARCHAR(100),
    description TEXT,
    pourcentage_viande INT,
    pourcentage_poisson INT,
    pourcentage_volaille INT,
    duree INT,
    variation_poids FLOAT,
    prix DECIMAL(10,2)
);

CREATE TABLE activites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    description TEXT,
    calories_brulees_par_jour INT
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

CREATE TABLE achats_regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    regime_id INT,
    prix_paye DECIMAL(10,2),
    date_achat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (regime_id) REFERENCES regimes(id)
);




