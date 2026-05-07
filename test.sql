CREATE DATABASE IF NOT EXISTS regime_alimentaire_s4;

USE regime_alimentaire_s4;

CREATE TABLE utilisateur (
    id_utilisateur INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    genre ENUM('Homme', 'Femme') NOT NULL,
    est_gold BOOLEAN DEFAULT FALSE,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_utilisateur)
);

CREATE TABLE sante_utilisateur (
    id_sante INT NOT NULL AUTO_INCREMENT,
    id_utilisateur INT NOT NULL,
    taille_cm DECIMAL(5, 2) NOT NULL,
    poids_kg DECIMAL(5, 2) NOT NULL,
    date_mise_a_jour DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_sante),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- Table objectif
-- --------------------------------------------------------
CREATE TABLE objectif (
    id_objectif INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(100) NOT NULL,
    code ENUM('augmenter', 'reduire', 'imc_ideal') NOT NULL,
    PRIMARY KEY (id_objectif)
);

-- --------------------------------------------------------
-- Table choix_objectif (un utilisateur peut choisir 3 objectifs)
-- --------------------------------------------------------
CREATE TABLE choix_objectif (
    id_utilisateur INT NOT NULL,
    id_objectif INT NOT NULL,
    PRIMARY KEY (id_utilisateur, id_objectif),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE,
    FOREIGN KEY (id_objectif) REFERENCES objectif(id_objectif) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- Table code_promo (pour recharger porte-monnaie)
-- --------------------------------------------------------
CREATE TABLE code_promo (
    id_code INT NOT NULL AUTO_INCREMENT,
    code VARCHAR(50) NOT NULL UNIQUE,
    valeur DECIMAL(10, 2) NOT NULL,
    utilise BOOLEAN DEFAULT FALSE,
    date_expiration DATE,
    PRIMARY KEY (id_code)
);

-- --------------------------------------------------------
-- Table porte_monnaie
-- --------------------------------------------------------
CREATE TABLE porte_monnaie (
    id_porte_monnaie INT NOT NULL AUTO_INCREMENT,
    id_utilisateur INT NOT NULL UNIQUE,
    solde DECIMAL(10, 2) DEFAULT 0.00,
    PRIMARY KEY (id_porte_monnaie),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- Table regime
-- --------------------------------------------------------
CREATE TABLE regime (
    id_regime INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    pourcentage_viande INT NOT NULL CHECK (
        pourcentage_viande BETWEEN 0
        AND 100
    ),
    pourcentage_poisson INT NOT NULL CHECK (
        pourcentage_poisson BETWEEN 0
        AND 100
    ),
    pourcentage_volaille INT NOT NULL CHECK (
        pourcentage_volaille BETWEEN 0
        AND 100
    ),
    variation_poids_kg DECIMAL(5, 2) NOT NULL COMMENT 'positif = prise, négatif = perte',
    actif BOOLEAN DEFAULT TRUE,
    PRIMARY KEY (id_regime)
);

-- --------------------------------------------------------
-- Table prix_regime_duree (prix variant selon la durée)
-- --------------------------------------------------------
CREATE TABLE prix_regime_duree (
    id_prix INT NOT NULL AUTO_INCREMENT,
    id_regime INT NOT NULL,
    duree_semaines INT NOT NULL,
    prix_euros DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (id_prix),
    FOREIGN KEY (id_regime) REFERENCES regime(id_regime) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- Table activite_sportive
-- --------------------------------------------------------
CREATE TABLE activite_sportive (
    id_activite INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    calories_heure INT NOT NULL,
    duree_recommandee_minutes INT,
    PRIMARY KEY (id_activite)
);

-- --------------------------------------------------------
-- Table suggestion_regime_activite (ce que l'appli suggère)
-- --------------------------------------------------------
CREATE TABLE suggestion_regime_activite (
    id_suggestion INT NOT NULL AUTO_INCREMENT,
    id_utilisateur INT NOT NULL,
    id_regime INT NOT NULL,
    id_activite INT NOT NULL,
    duree_semaines INT NOT NULL,
    date_suggestion DATETIME DEFAULT CURRENT_TIMESTAMP,
    genere_pdf BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (id_suggestion),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE,
    FOREIGN KEY (id_regime) REFERENCES regime(id_regime),
    FOREIGN KEY (id_activite) REFERENCES activite_sportive(id_activite)
);

-- --------------------------------------------------------
-- Table paiement_gold
-- --------------------------------------------------------
CREATE TABLE paiement_gold (
    id_paiement INT NOT NULL AUTO_INCREMENT,
    id_utilisateur INT NOT NULL,
    montant_paye DECIMAL(10, 2) NOT NULL,
    date_paiement DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_paiement),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- INSERTIONS MINIMALES (données de test)
-- --------------------------------------------------------
-- Objectifs
INSERT INTO
    objectif (libelle, code)
VALUES
    ('Augmenter mon poids', 'augmenter'),
    ('Réduire mon poids', 'reduire'),
    ('Atteindre mon IMC idéal', 'imc_ideal');

-- Régimes (avec % viande/poisson/volaille)
INSERT INTO
    regime (
        nom,
        description,
        pourcentage_viande,
        pourcentage_poisson,
        pourcentage_volaille,
        variation_poids_kg
    )
VALUES
    (
        'Protéine Max',
        'Régime hyperprotéiné pour prise de masse',
        50,
        20,
        30,
        3.5
    ),
    (
        'Équilibré',
        'Régime standard équilibré',
        33,
        33,
        34,
        0.5
    ),
    (
        'Pescetarien',
        'Régime sans viande rouge',
        0,
        60,
        40,
        -1.0
    ),
    (
        'Light Volaille',
        'Pour perte de poids',
        10,
        20,
        70,
        -2.5
    ),
    (
        'Mixte Complet',
        'Pour objectif IMC idéal',
        40,
        20,
        40,
        0.0
    );

-- Prix selon durée
INSERT INTO
    prix_regime_duree (id_regime, duree_semaines, prix_euros)
VALUES
    (1, 4, 49.99),
    (1, 8, 89.99),
    (1, 12, 119.99),
    (2, 4, 39.99),
    (2, 8, 69.99),
    (2, 12, 99.99),
    (3, 4, 44.99),
    (3, 8, 79.99),
    (3, 12, 109.99),
    (4, 4, 34.99),
    (4, 8, 59.99),
    (4, 12, 89.99),
    (5, 4, 44.99),
    (5, 8, 79.99),
    (5, 12, 109.99);

-- Activités sportives
INSERT INTO
    activite_sportive (
        nom,
        description,
        calories_heure,
        duree_recommandee_minutes
    )
VALUES
    (
        'Course à pied',
        'Idéal pour perte de poids',
        600,
        30
    ),
    (
        'Musculation',
        'Prise de masse musculaire',
        400,
        45
    ),
    (
        'Natation',
        'Complet et doux pour les articulations',
        500,
        40
    ),
    ('Vélo', 'Endurance et cardio', 550, 45),
    ('Yoga', 'Flexibilité et récupération', 200, 30);

-- 5 utilisateurs (mot de passe : password123 en bcrypt, à adapter selon votre hash)
-- Ici on met des hash factices, vous les recréerez avec password_hash() en PHP
INSERT INTO
    utilisateur (
        nom,
        email,
        mot_de_passe,
        genre,
        est_gold
    )
VALUES
    (
        'Alice Martin',
        'alice@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Femme',
        FALSE
    ),
    (
        'Thomas Durand',
        'thomas@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Homme',
        FALSE
    ),
    (
        'Julie Petit',
        'julie@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Femme',
        TRUE
    ),
    (
        'Marc Lefevre',
        'marc@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Homme',
        FALSE
    ),
    (
        'Sophie Bernard',
        'sophie@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Autre',
        FALSE
    );

-- Données santé pour les 5 utilisateurs
INSERT INTO
    sante_utilisateur (id_utilisateur, taille_cm, poids_kg)
VALUES
    (1, 165, 68.5),
    (2, 180, 85.0),
    (3, 170, 62.0),
    (4, 175, 95.0),
    (5, 160, 55.0);

-- Porte-monnaie
INSERT INTO
    porte_monnaie (id_utilisateur, solde)
VALUES
    (1, 50.00),
    (2, 0.00),
    (3, 120.00),
    (4, 10.00),
    (5, 30.00);

-- 15 codes promo
INSERT INTO
    code_promo (code, valeur, utilise, date_expiration)
VALUES
    ('WELCOME10', 10.00, FALSE, '2026-12-31'),
    ('SANTE20', 20.00, FALSE, '2026-12-31'),
    ('GOLD15', 15.00, FALSE, '2026-12-31'),
    ('REGIME5', 5.00, FALSE, '2026-12-31'),
    ('SPORT10', 10.00, FALSE, '2026-12-31'),
    ('CODE6', 25.00, FALSE, '2026-12-31'),
    ('CODE7', 30.00, FALSE, '2026-12-31'),
    ('CODE8', 8.00, FALSE, '2026-12-31'),
    ('CODE9', 12.00, FALSE, '2026-12-31'),
    ('CODE10', 18.00, FALSE, '2026-12-31'),
    ('CODE11', 22.00, FALSE, '2026-12-31'),
    ('CODE12', 14.00, FALSE, '2026-12-31'),
    ('CODE13', 9.00, FALSE, '2026-12-31'),
    ('CODE14', 11.00, FALSE, '2026-12-31'),
    ('CODE15', 7.00, FALSE, '2026-12-31');

-- Choix objectifs (chaque utilisateur peut en avoir 3 max)
INSERT INTO
    choix_objectif (id_utilisateur, id_objectif)
VALUES
    (1, 2),
    (1, 3),
    (2, 1),
    (2, 3),
    (3, 2),
    (4, 1),
    (5, 2),
    (5, 3);

-- Suggestions (exemples)
INSERT INTO
    suggestion_regime_activite (
        id_utilisateur,
        id_regime,
        id_activite,
        duree_semaines
    )
VALUES
    (1, 4, 1, 8),
    (2, 1, 2, 12),
    (3, 3, 3, 4),
    (4, 1, 2, 12),
    (5, 4, 1, 4);