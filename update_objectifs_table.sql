-- Supprimer l'ancienne table objectifs si elle existe
DROP TABLE IF EXISTS objectifs;

-- Créer la nouvelle table objectifs avec la bonne structure
CREATE TABLE objectifs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    type_objectif ENUM('augmentation', 'reduction', 'imc_ideal') NOT NULL,
    poids_cible DECIMAL(5,2) NULL COMMENT 'Poids cible en kg',
    imc_cible DECIMAL(4,2) NULL COMMENT 'IMC cible',
    date_objectif DATE NULL COMMENT 'Date limite pour atteindre l\'objectif',
    statut ENUM('actif', 'atteint', 'abandonne') DEFAULT 'actif',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    INDEX idx_utilisateur (utilisateur_id),
    INDEX idx_statut (statut)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
