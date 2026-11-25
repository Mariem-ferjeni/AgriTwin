-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 21 nov. 2026 à 11:20
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `agritwin`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(11) NOT NULL,
  `nom_categorie` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom_categorie`, `description`) VALUES
(1, 'Irrigation', 'Conseils pour optimiser l\'utilisation de l\'eau.');

-- --------------------------------------------------------

--
-- Structure de la table `conseil`
--

CREATE TABLE `conseil` (
  `id_conseil` int(11) NOT NULL,
  `titre` varchar(150) NOT NULL,
  `contenu` text NOT NULL,
  `categorie` varchar(100) DEFAULT NULL,
  `date_publication` date DEFAULT NULL,
  `statut` varchar(30) DEFAULT 'Publié'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `conseil`
--

INSERT INTO `conseil` (`id_conseil`, `titre`, `contenu`, `categorie`, `date_publication`, `statut`) VALUES
(1, 'Conseils pour une bonne irrigation', 'Il est important de contrôler régulièrement l’humidité du sol et d’adapter la quantité d’eau aux besoins des cultures. Privilégiez une irrigation efficace afin de limiter le gaspillage.', 'Irrigation', '2026-11-14', 'Publié');

-- --------------------------------------------------------

--
-- Structure de la table `culture`
--

CREATE TABLE `culture` (
  `id_culture` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `type_culture` varchar(100) NOT NULL,
  `variete` varchar(100) DEFAULT NULL,
  `saison` varchar(100) DEFAULT NULL,
  `duree_cycle` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `culture`
--

INSERT INTO `culture` (`id_culture`, `nom`, `type_culture`, `variete`, `saison`, `duree_cycle`, `description`) VALUES
(1, 'Oranger', 'Agrume', 'Maltaise', 'Automne', 365, 'Culture des oranges'),
(2, 'Citronnier', 'Agrume', 'Eureka', 'Toute l’année', 365, 'Culture des citrons'),
(3, 'Olivier', 'Arbre fruitier', 'Chemlali', 'Automne', 180, 'Culture des olives');

-- --------------------------------------------------------

--
-- Structure de la table `exploitation`
--

CREATE TABLE `exploitation` (
  `id_exploitation` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `localisation` varchar(150) NOT NULL,
  `superficie_totale` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `prenom`, `email`, `mot_de_passe`, `telephone`, `role`) VALUES
(3, 'Ben Ali ', 'Ahmed ', 'ahmed@email.com', '111222', '123456', 'Utilisateur');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`),
  ADD UNIQUE KEY `nom_categorie` (`nom_categorie`);

--
-- Index pour la table `conseil`
--
ALTER TABLE `conseil`
  ADD PRIMARY KEY (`id_conseil`);

--
-- Index pour la table `culture`
--
ALTER TABLE `culture`
  ADD PRIMARY KEY (`id_culture`);

--
-- Index pour la table `exploitation`
--
ALTER TABLE `exploitation`
  ADD PRIMARY KEY (`id_exploitation`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `conseil`
--
ALTER TABLE `conseil`
  MODIFY `id_conseil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `culture`
--
ALTER TABLE `culture`
  MODIFY `id_culture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `exploitation`
--
ALTER TABLE `exploitation`
  MODIFY `id_exploitation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `exploitation`
--
ALTER TABLE `exploitation`
  ADD CONSTRAINT `fk_exploitation_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
