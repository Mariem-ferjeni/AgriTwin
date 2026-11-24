-- =====================================================================
-- AgriTwin — Migration 001 : ancienne base (5 tables) -> version finale
-- A EXECUTER UNE SEULE FOIS, sur la base « agritwin » deja existante
-- (phpMyAdmin > base agritwin > onglet Importer). FAITES UNE SAUVEGARDE AVANT.
-- Les donnees existantes sont conservees.
-- =====================================================================

SET NAMES utf8mb4;

-- 1) Utilisateurs : roles normalises (admin / agriculteur), date d'inscription,
--    espaces parasites supprimes, mots de passe haches (bcrypt).
UPDATE utilisateur SET role = CASE WHEN LOWER(TRIM(role)) = 'admin' THEN 'admin' ELSE 'agriculteur' END;
UPDATE utilisateur SET nom = TRIM(nom), prenom = TRIM(prenom), email = LOWER(TRIM(email));

ALTER TABLE utilisateur
  MODIFY role ENUM('admin','agriculteur') NOT NULL DEFAULT 'agriculteur',
  MODIFY telephone VARCHAR(20) NOT NULL DEFAULT '',
  ADD COLUMN date_inscription DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;

-- Le compte de test existant (ahmed@email.com / 111222) garde son mot de passe, mais haché.
UPDATE utilisateur SET mot_de_passe = '$2y$10$cqEuEKGqXWggRnQ2Hb9f7.8Zcwa09AEj5IKpfe34T0kk718aVrWZa' WHERE mot_de_passe = '111222';
-- Tout autre mot de passe encore en clair est invalide (compte verrouille) :
-- un administrateur doit definir un nouveau mot de passe (Back Office > Utilisateurs > Modifier).
UPDATE utilisateur SET mot_de_passe = '!' WHERE mot_de_passe NOT LIKE '$2y$%';

-- 2) Conseils : la categorie texte devient une vraie relation (cle etrangere)
ALTER TABLE conseil ADD COLUMN id_categorie INT(11) NULL AFTER contenu;
INSERT IGNORE INTO categorie (nom_categorie)
  SELECT DISTINCT TRIM(categorie) FROM conseil WHERE categorie IS NOT NULL AND TRIM(categorie) <> '';
UPDATE conseil c JOIN categorie k ON k.nom_categorie = TRIM(c.categorie) SET c.id_categorie = k.id_categorie;
ALTER TABLE conseil
  DROP COLUMN categorie,
  ADD KEY idx_conseil_categorie (id_categorie),
  ADD CONSTRAINT fk_conseil_categorie FOREIGN KEY (id_categorie) REFERENCES categorie (id_categorie) ON DELETE SET NULL ON UPDATE CASCADE;

-- 3) Nouvelles tables : parcelles, suivi, messages de contact
CREATE TABLE parcelle (
  id_parcelle INT(11) NOT NULL AUTO_INCREMENT,
  id_exploitation INT(11) NOT NULL,
  nom VARCHAR(100) NOT NULL,
  superficie DECIMAL(10,2) NOT NULL,
  type_sol VARCHAR(50) DEFAULT NULL,
  id_culture INT(11) DEFAULT NULL,
  date_plantation DATE DEFAULT NULL,
  etat ENUM('en_preparation','plantee','en_croissance','recoltee') NOT NULL DEFAULT 'en_preparation',
  PRIMARY KEY (id_parcelle),
  KEY idx_parcelle_exploitation (id_exploitation),
  KEY idx_parcelle_culture (id_culture),
  CONSTRAINT fk_parcelle_exploitation FOREIGN KEY (id_exploitation) REFERENCES exploitation (id_exploitation) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_parcelle_culture FOREIGN KEY (id_culture) REFERENCES culture (id_culture) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE suivi_parcelle (
  id_suivi INT(11) NOT NULL AUTO_INCREMENT,
  id_parcelle INT(11) NOT NULL,
  date_suivi DATE NOT NULL,
  humidite_sol DECIMAL(5,2) DEFAULT NULL,
  temperature DECIMAL(5,2) DEFAULT NULL,
  ph_sol DECIMAL(3,1) DEFAULT NULL,
  observation TEXT DEFAULT NULL,
  PRIMARY KEY (id_suivi),
  KEY idx_suivi_parcelle (id_parcelle, date_suivi),
  CONSTRAINT fk_suivi_parcelle FOREIGN KEY (id_parcelle) REFERENCES parcelle (id_parcelle) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE message_contact (
  id_message INT(11) NOT NULL AUTO_INCREMENT,
  nom VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  sujet VARCHAR(150) NOT NULL,
  message TEXT NOT NULL,
  date_envoi DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  lu TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (id_message)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4) Compte administrateur de test : admin@agritwin.tn / Admin@2026
INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, telephone, role, date_inscription)
SELECT 'Administrateur', 'AgriTwin', 'admin@agritwin.tn', '$2y$10$oyRF.qw51W71RqZgYiM2BeFXEv3S9eMiuzJBJWOz757FOZ9f0Q5lC', '', 'admin', '2026-09-01 09:00:00' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM utilisateur WHERE email = 'admin@agritwin.tn');
