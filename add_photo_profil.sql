-- Ajouter la colonne photo_profil à la table utilisateurs
ALTER TABLE utilisateurs ADD COLUMN photo_profil VARCHAR(255) NULL AFTER email;

-- Mettre à jour les utilisateurs existants avec une valeur NULL
UPDATE utilisateurs SET photo_profil = NULL WHERE photo_profil IS NULL;
