-- Supprimer la table si elle existe
DROP TABLE IF EXISTS utilisateur_objectifs;
DROP TABLE IF EXISTS objectifs;

-- Créer la table objectifs (simple)
CREATE TABLE objectifs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    code VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE utilisateur_objectifs;
DROP Table objectifs;

-- Insérer les 3 objectifs de base (sans description)
INSERT INTO objectifs (code,nom) VALUES
('AUG','Augmenter son poids'),
('RED','Réduire son poids'),
('IMC-IDEAL','Atteindre son IMC idéal');

-- Créer la table de liaison utilisateur_objectifs
CREATE TABLE utilisateur_objectifs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    objectif_id INT NOT NULL,
    statut ENUM('actif', 'atteint', 'abandonne') DEFAULT 'actif',
    date_debut DATETIME DEFAULT CURRENT_TIMESTAMP,
    poids_initial DECIMAL(5,2) NULL,
    poids_cible DECIMAL(5,2) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (objectif_id) REFERENCES objectifs(id) ON DELETE CASCADE
);
