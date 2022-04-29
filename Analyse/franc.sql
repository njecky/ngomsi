-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 29 avr. 2022 à 15:53
-- Version du serveur :  8.0.22
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `franc`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `nom`, `phone`, `email`, `password`, `avatar`) VALUES
(1, 'Njecky Félix Désiré', '655779711', 'njecky@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1.png');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `admin_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`libelle`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `libelle`, `admin_id`) VALUES
(1, 'Cosmétique', 1),
(2, 'Produit de Santé', 1),
(3, 'Meuble', 1);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `sexe` varchar(5) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'avatar-10.png',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `nom`, `telephone`, `sexe`, `email`, `password`, `avatar`) VALUES
(1, 'Karem bébé', '655779711', 'Homme', 'az@tet.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1.jpg'),
(2, 'Lucia Rosie', '+237655779711', 'Femme', 'njecky.felix17@myiuc.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2.jpg'),
(3, 'Stephane Pierre', '655779711', 'Homme', 'njecky@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '4.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantite` int NOT NULL,
  `prix` float NOT NULL,
  `date` datetime NOT NULL,
  `client_id` int NOT NULL,
  `produit_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `produit_id` (`produit_id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL,
  `seen` tinyint(1) DEFAULT '0',
  `produit_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `produit_id` (`produit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `nom`, `email`, `comment`, `date`, `seen`, `produit_id`) VALUES
(1, 'Xu Zhiwei', 'aze@tet.com', 'bien mon petit continue comme ça ', '2021-05-13 22:06:33', 0, 1),
(2, 'Lucia', 'kotto_immeuble@yahoo.fr', 'Hmm le produit ici est super merci', '2021-05-13 22:09:08', 0, 2),
(3, 'Karem', 'aze@tet.com', 'Il est bien ce produit le conseil à tous le monde car je l\'ai testé et ça marche', '2021-05-14 11:05:04', 0, 4),
(4, 'JEAN PIERRE CHRIS', 'njecky@gmail.com', 'voicie un commentaire', '2021-05-14 11:37:42', 0, 3),
(5, 'Stephanie Rosie', 'kotto_immeuble@yahoo.fr', 'très bien', '2021-05-14 12:00:38', 0, 5),
(6, 'Lucia Rosie', 'njecky.felix17@myiuc.com', 'Quel lait de corps nourrissant vraiment les produits de cette catégorie sont super', '2021-05-14 12:04:10', 0, 6),
(7, 'Njecky Félix Désiré', 'njeckyf1@gmail.com', 'Ce produit est un produit miracle j\'ai testé et j\'approuve merci beaucoup l\'administrateur', '2021-06-11 09:44:56', 0, 1),
(8, 'Xu Zhiwei', 'aze@tet.com', 'Vraiment les gars je suis fière de vous par le travail a battu', '2021-06-11 09:47:33', 0, 2),
(9, 'Karem bébé', 'az@tet.com', 'Bien ce produit je l\'ai testé et l\'a prouve', '2021-08-13 10:28:56', 0, 3);

-- --------------------------------------------------------

--
-- Structure de la table `partenaire`
--

DROP TABLE IF EXISTS `partenaire`;
CREATE TABLE IF NOT EXISTS `partenaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `noms` varchar(255) DEFAULT NULL,
  `site` text,
  `phone` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`noms`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `partenaire`
--

INSERT INTO `partenaire` (`id`, `noms`, `site`, `phone`, `photo`, `admin_id`) VALUES
(1, 'Xu Zhiwei', 'https://www.longrichfrancenk.fr/445723058', '(+33)0625949812', 'JEAN PIERRE.jpg', 1),
(2, 'Burkina Faso-Ouagadougou', 'https://www.longrichbusinesssante.com/', '+226 07 54 28 28', 'Burkina Faso-Ouagadougoujpg', 1),
(3, 'Biosciences', 'https://longrichopportunitycameroon.wordpress.com/', '+237 698 205 550', 'Biosciencesjpg', 1),
(4, 'Danilo', 'https://daniloduchesnes.com/blog/', '562-809-1687', 'Danilopng', 1);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `prix` float NOT NULL,
  `quantite` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `categorie_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `titre` (`titre`),
  KEY `categorie_id` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `titre`, `description`, `prix`, `quantite`, `image`, `categorie_id`) VALUES
(1, 'Savon Noir', 'Contient des extraits raffinés de charbon de bambou, nettoie efficacement la saleté, la crasse et la graisse excessive de la peau, et laisse la peau propre et fraîche.', 7500, 12, 'Savon Noirjpg', 1),
(2, 'Nutri Vrich Bleu', 'Réduire efficacement le risque d\'apparition de certains types de cancers ainsi que les maladies cardiaques, les inflammations et arthrose rhumatisal', 6000, 14, 'Nutri Vrich Bleujpg', 2),
(3, 'Evergreen', 'Riche en polyphénols et anthocyanes extraits de grenade rouge\r\n Apporte à  la peau plus de nutriments, de vitalité, d\'éclat et de finesse.', 10000, 20, 'Evergreenjpg', 2),
(4, 'Berry', 'Protège les reins des attaques chimiques\r\nRend jeune, renforce la peau et les cheveux\r\nEfficace dans le traitement du l\'hépatite et des ulcères et empêche les plaquettes sanguines de se rassembler', 31000, 10, 'Berryjpg', 2),
(5, 'Gel Douche + Shampoing(bébé)', 'Fait à base de mais\r\nNettoyage doux\r\nProtection de la peau par une couche hydratante', 7000, 5, 'Gel Douche + Shampoing(bébé)jpg', 2),
(6, 'Lait Corporel', 'Fait à base de PLACENTA de BREBIS, de vitamine E et d’autres nutriments, le lait de Longrich pénètre en profondeur et aide à réparer les problèmes de la peau.', 5400, 18, 'Lait Corporeljpg', 1),
(7, 'Brightening', 'La crème pour les mains de longrich a été spécialement conçue pour combattre les problèmes d’irritations de la peau, des réactions allergiques qui peuvent avoir pour origine les produits chimiques contenus dans nos savons', 4500, 8, 'Brighteningjpg', 1),
(8, 'Hand Crean', 'Contient de la vitamine A, C, E qui permet à la main d\'être lisse, fraîche et aide la main à rester jeune', 4000, 4, 'Hand Creanpng', 1),
(13, 'Lait de corps au placenta de mouton', 'Lait de corps à base de placenta de brebis (200 ml)\r\n\r\nFait à base de placenta de brebis, de vitamine E et d’autres nutriments, le lait de Longrich pénètre en profondeur et aide à réparer les problèmes de la peau.', 7000, 14, 'Lait de corps au placenta de moutonjpg', 3);

-- --------------------------------------------------------

--
-- Structure de la table `recuperation`
--

DROP TABLE IF EXISTS `recuperation`;
CREATE TABLE IF NOT EXISTS `recuperation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD CONSTRAINT `categorie_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `partenaire`
--
ALTER TABLE `partenaire`
  ADD CONSTRAINT `partenaire_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
