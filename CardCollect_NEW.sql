-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 05 juin 2024 à 11:54
-- Version du serveur : 8.0.36-0ubuntu0.22.04.1
-- Version de PHP : 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `CardCollect`
--

-- --------------------------------------------------------

--
-- Structure de la table `BoosterInventory`
--

CREATE TABLE `BoosterInventory` (
  `id` int NOT NULL,
  `ownerId` int NOT NULL,
  `boosterId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `BoosterInventory`
--

INSERT INTO `BoosterInventory` (`id`, `ownerId`, `boosterId`) VALUES
(26, 32, 2);

-- --------------------------------------------------------

--
-- Structure de la table `Boosters`
--

CREATE TABLE `Boosters` (
  `id` int NOT NULL,
  `name` varchar(30) NOT NULL,
  `cost` int NOT NULL,
  `nbCommon` int NOT NULL,
  `nbUncommon` int NOT NULL,
  `nbEpic` int NOT NULL,
  `nbLegendary` int NOT NULL,
  `nbRandom` int NOT NULL,
  `inShop` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Boosters`
--

INSERT INTO `Boosters` (`id`, `name`, `cost`, `nbCommon`, `nbUncommon`, `nbEpic`, `nbLegendary`, `nbRandom`, `inShop`) VALUES
(2, 'Starter', 50, 5, 1, 0, 0, 1, 1),
(3, 'Légendaire', 800, 10, 5, 3, 1, 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Cards`
--

CREATE TABLE `Cards` (
  `id` int NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `idCreator` int NOT NULL,
  `minia_path` varchar(100) NOT NULL,
  `poster_path` varchar(100) NOT NULL,
  `rarity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Cards`
--

INSERT INTO `Cards` (`id`, `name`, `description`, `idCreator`, `minia_path`, `poster_path`, `rarity`) VALUES
(17, 'Terrils_de_Loos', 'Une magnifique vue nous attend', 2, '240603113809_Terrils_de_Loos_minia.jpg', '240603113809_Terrils_de_Loos_poster.jpg', 2),
(18, 'Sitckman', 'Pour ceux qui ont du mal avec le dessin', 2, '240604185900_Sitckman_minia.png', '240604185900_Sitckman_poster.png', 1),
(19, 'IG2I', 'La meilleur école d\'ingénieur.', 1, '240604191606_IG2I_minia.jpg', '240604191606_IG2I_poster.jpg', 3),
(21, 'Herbe', 'Va un peu dehors au lieu de tryhard', 2, '240604204149_Herbe_minia.jpg', '240604204149_Herbe_poster.jpg', 0),
(23, 'Base_du_11_19', 'Un air de vieillesse', 1, '240604205051_Base_du_11_19_minia.jpg', '240604205051_Base_du_11_19_poster.jpg', 1),
(24, 'Rubiks', 'T\'es chaud si t\'arrives à le résoudre !', 1, '240604210030_Rubiks_minia.jpg', '240604210030_Rubiks_poster.jpg', 1),
(25, 'd100', 'Ce dé est maudit en campagne...', 2, '240604210717_d100_minia.jpg', '240604210717_d100_poster.jpg', 0),
(26, 'Papillon', 'Un des développeur les adore... A voir de voir lequel.', 2, '240604211544_Papillon_minia.jpg', '240604211544_Papillon_poster.jpg', 2),
(27, 'Origami', 'On peut faire beaucoup de choses avec du papier... L\'un de nous y arrive, l\'autre non.', 32, '240604230510_Origami_minia.jpg', '240604230510_Origami_poster.jpg', 2),
(28, 'Eau', 'Dans 20-30 ans, y\'en aura plus', 32, '240605094153_Eau_minia.jpg', '240605094153_Eau_poster.jpg', 0),
(29, 'Carte', 'Une carte dans une carte', 32, '240605095040_Carte_minia.jpg', '240605095040_Carte_poster.jpg', 1),
(30, '4', 'Un 4 tout à fait normal, pas vrai ?', 32, '240605101440_4_minia.png', '240605101440_4_poster.png', 3),
(31, 'Ping-pong', 'Un des nombreux sports de 2I', 32, '240605102748_Ping-pong_minia.jpg', '240605102748_Ping-pong_poster.jpg', 1),
(32, 'Cahier', 'Très utile pour les cours ce truc', 32, '240605104051_Cahier_minia.jpg', '240605104051_Cahier_poster.jpg', 0),
(33, 'Lunettes', 'Avec le supplément anti lumière bleue s\'il vous plait', 32, '240605110319_Lunettes_minia.jpg', '240605110319_Lunettes_poster.jpg', 0),
(34, 'Babyfoot', 'Moins populaire que le ping-pong à 2I, c\'est quand même sympa', 32, '240605110940_Babyfoot_minia.jpg', '240605110940_Babyfoot_poster.jpg', 0);

-- --------------------------------------------------------

--
-- Structure de la table `Circulation`
--

CREATE TABLE `Circulation` (
  `id` int NOT NULL,
  `ownerId` int NOT NULL,
  `cardId` int NOT NULL,
  `inMarket` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `MarketOffers`
--

CREATE TABLE `MarketOffers` (
  `id` int NOT NULL,
  `isTrade` int NOT NULL,
  `soldCardId` int NOT NULL,
  `cost` int DEFAULT NULL,
  `tradedCardId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Publications`
--

CREATE TABLE `Publications` (
  `id` int NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `idCreator` int NOT NULL,
  `minia_path` varchar(100) NOT NULL,
  `poster_path` varchar(100) NOT NULL,
  `rarity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Publications`
--

INSERT INTO `Publications` (`id`, `name`, `description`, `idCreator`, `minia_path`, `poster_path`, `rarity`) VALUES
(10, 'Placeholder', 'Ce n\'est que pour la démo.', 32, '240605115222_Placeholder_minia.png', '240605115222_Placeholder_poster.png', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Questions`
--

CREATE TABLE `Questions` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `content` varchar(3000) NOT NULL,
  `answer` varchar(100) NOT NULL,
  `reward` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Questions`
--

INSERT INTO `Questions` (`id`, `name`, `content`, `answer`, `reward`) VALUES
(2, 'Diode', 'La tension de seuil d\'une diode ? (en V)', '0,6', 4),
(3, 'Loi d\'Ohm', 'Compléter : U=R/?', 'I', 3);

-- --------------------------------------------------------

--
-- Structure de la table `UserQuestions`
--

CREATE TABLE `UserQuestions` (
  `id` int NOT NULL,
  `userId` int NOT NULL,
  `questionId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Users`
--

CREATE TABLE `Users` (
  `id` int NOT NULL,
  `mail` varchar(100) NOT NULL UNIQUE,
  `pseudo` varchar(20) NOT NULL UNIQUE,
  `pass` varchar(50) NOT NULL,
  `privileges` int NOT NULL DEFAULT '0',
  `allowed` int DEFAULT '1',
  `coins` int DEFAULT '200'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Users`
--

INSERT INTO `Users` (`id`, `mail`, `pseudo`, `pass`, `privileges`, `allowed`, `coins`) VALUES
(1, 'duthoit.thomas9@gmail.com', 'Thomas', 'mdpsecurise', 2, 1, 150),
(2, 'ewen.b.2005@gmail.com', 'Ewen', 'motdepasse', 1, 1, 200),
(3, 'bob@gmail.com', 'Bob', 'itsmebob', 0, 1, 200),
(32, 'ubuntu', 'test', 'mdp', 2, 1, 5000);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `BoosterInventory`
--
ALTER TABLE `BoosterInventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ownerId` (`ownerId`),
  ADD KEY `boosterId` (`boosterId`);

--
-- Index pour la table `Boosters`
--
ALTER TABLE `Boosters`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Cards`
--
ALTER TABLE `Cards`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Circulation`
--
ALTER TABLE `Circulation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ownerId` (`ownerId`),
  ADD KEY `cardId` (`cardId`);

--
-- Index pour la table `MarketOffers`
--
ALTER TABLE `MarketOffers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `soldCardId` (`soldCardId`),
  ADD KEY `tradedCardId` (`tradedCardId`);

--
-- Index pour la table `Publications`
--
ALTER TABLE `Publications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCreator` (`idCreator`);

--
-- Index pour la table `Questions`
--
ALTER TABLE `Questions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `UserQuestions`
--
ALTER TABLE `UserQuestions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `questionId` (`questionId`);

--
-- Index pour la table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `BoosterInventory`
--
ALTER TABLE `BoosterInventory`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `Boosters`
--
ALTER TABLE `Boosters`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `Cards`
--
ALTER TABLE `Cards`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `Circulation`
--
ALTER TABLE `Circulation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT pour la table `MarketOffers`
--
ALTER TABLE `MarketOffers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Publications`
--
ALTER TABLE `Publications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `Questions`
--
ALTER TABLE `Questions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `UserQuestions`
--
ALTER TABLE `UserQuestions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `BoosterInventory`
--
ALTER TABLE `BoosterInventory`
  ADD CONSTRAINT `BoosterInventory_ibfk_1` FOREIGN KEY (`ownerId`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `BoosterInventory_ibfk_2` FOREIGN KEY (`boosterId`) REFERENCES `Boosters` (`id`);

--
-- Contraintes pour la table `Circulation`
--
ALTER TABLE `Circulation`
  ADD CONSTRAINT `Circulation_ibfk_1` FOREIGN KEY (`ownerId`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `Circulation_ibfk_2` FOREIGN KEY (`cardId`) REFERENCES `Cards` (`id`);

--
-- Contraintes pour la table `MarketOffers`
--
ALTER TABLE `MarketOffers`
  ADD CONSTRAINT `MarketOffers_ibfk_1` FOREIGN KEY (`soldCardId`) REFERENCES `Circulation` (`id`),
  ADD CONSTRAINT `MarketOffers_ibfk_2` FOREIGN KEY (`tradedCardId`) REFERENCES `Cards` (`id`);

--
-- Contraintes pour la table `Publications`
--
ALTER TABLE `Publications`
  ADD CONSTRAINT `Publications_ibfk_1` FOREIGN KEY (`idCreator`) REFERENCES `Users` (`id`);

--
-- Contraintes pour la table `UserQuestions`
--
ALTER TABLE `UserQuestions`
  ADD CONSTRAINT `UserQuestions_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `UserQuestions_ibfk_2` FOREIGN KEY (`questionId`) REFERENCES `Questions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
