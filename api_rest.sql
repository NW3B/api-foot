-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  lun. 13 juil. 2020 à 19:04
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `api_foot`
--

-- --------------------------------------------------------

--
-- Structure de la table `confrontation`
--

DROP TABLE IF EXISTS `confrontation`;
CREATE TABLE IF NOT EXISTS `confrontation` (
  `id_match` int(255) NOT NULL AUTO_INCREMENT,
  `id_equipe1` int(255) NOT NULL,
  `id_equipe2` int(255) NOT NULL,
  `cote1` float NOT NULL,
  `coteN` float NOT NULL,
  `cote2` float NOT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL,
  `resultat` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_match`),
  KEY `INX_EQUIPE1` (`id_equipe1`) USING BTREE,
  KEY `INX_EQUIPE2` (`id_equipe2`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Structure de la table `equipes`
--

DROP TABLE IF EXISTS `equipes`;
CREATE TABLE IF NOT EXISTS `equipes` (
  `id_equipe` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_equipe` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_league` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_equipe`),
  KEY `INX_league` (`id_league`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipes`
--

INSERT INTO `equipes` (`id_equipe`, `libelle_equipe`, `id_league`) VALUES
(1, 'Atalanta', 1),
(2, 'Bologne', 1),
(3, 'Brescia', 1),
(4, 'Cagliari', 1),
(5, 'Fiorentina', 1),
(6, 'Genoa', 1),
(7, 'Inter Milan', 1),
(8, 'Juventus', 1),
(9, 'Lazio', 1),
(10, 'Lecce', 1),
(11, 'Milan', 1),
(12, 'Naples', 1),
(13, 'Parma', 1),
(14, 'AS Roma', 1),
(15, 'Sampdoria', 1),
(16, 'Sassuolo', 1),
(17, 'Spal', 1),
(18, 'Torino', 1),
(19, 'Udinese', 1),
(20, 'Hellas Vérone', 1),
(21, 'Arsenal', 2),
(22, 'Aston Villa', 2),
(23, 'Bournemouth', 2),
(24, 'Brighton', 2),
(25, 'Burnley', 2),
(26, 'Chelsea', 2),
(27, 'Crystal Palace', 2),
(28, 'Everton', 2),
(29, 'Leicester', 2),
(30, 'Liverpool', 2),
(31, 'Manchester City', 2),
(32, 'Manchester United', 2),
(33, 'Newcastle', 2),
(34, 'Norwich', 2),
(35, 'Sheffield United', 2),
(36, 'Southampton', 2),
(37, 'Tottenham', 2),
(38, 'Watford', 2),
(39, 'West Ham', 2),
(40, 'Wolverhampton', 2);

-- --------------------------------------------------------

--
-- Structure de la table `ligues`
--

DROP TABLE IF EXISTS `ligues`;
CREATE TABLE IF NOT EXISTS `ligues` (
  `id_league` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_ligue` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_league`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ligues`
--

INSERT INTO `ligues` (`id_league`, `libelle_ligue`) VALUES
(1, 'Serie A'),
(2, 'Premier League'),
(3, 'Bundesliga'),
(4, 'Primera Division');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `confrontation`
--
ALTER TABLE `confrontation`
  ADD CONSTRAINT `confrontation_ibfk_1` FOREIGN KEY (`id_equipe1`) REFERENCES `equipes` (`id_equipe`),
  ADD CONSTRAINT `confrontation_ibfk_2` FOREIGN KEY (`id_equipe2`) REFERENCES `equipes` (`id_equipe`);

--
-- Contraintes pour la table `equipes`
--
ALTER TABLE `equipes`
  ADD CONSTRAINT `equipes_ibfk_1` FOREIGN KEY (`id_league`) REFERENCES `ligues` (`id_league`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
