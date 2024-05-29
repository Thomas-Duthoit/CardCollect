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
-- Structure de la table `Users`
--

CREATE TABLE `Users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mail` varchar(100) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `privileges` int NOT NULL DEFAULT 0,
  `allowed` int DEFAULT 1,
  `coins` int DEFAULT 200,

  PRIMARY KEY (id)
) ;

-- Structure de la table `Verification`

CREATE TABLE `Verification` (
  `idUser` int NOT NULL,
  `code` int NOT NULL,

  PRIMARY KEY (idUser),
  FOREIGN KEY (idUser) REFERENCES Users(id)
);

-- Structure de la table `Questions`

CREATE TABLE `Questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `content` varchar(3000) NOT NULL,
  `answer` varchar(100) NOT NULL,
  `reward` int NOT NULL,

  PRIMARY KEY (id)
);

-- Structure de la table `UserQuestions', lien entre utilisateurs et questions

CREATE TABLE `UserQuestions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  `questionId` int NOT NULL,

  PRIMARY KEY (id),
  FOREIGN KEY (userId) REFERENCES Users(id),
  FOREIGN KEY (questionId) REFERENCES Questions(id)
);

-- Structure de la table `Publications`

CREATE TABLE `Publications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `description` varchar(200),
  `idCreator` int NOT NULL,
  `minia_path` varchar(100) NOT NULL,
  `poster_path` varchar(100) NOT NULL,
  `rarity` int NOT NULL,

  PRIMARY KEY (id),
  FOREIGN KEY (idCreator) REFERENCES Users(id)
);

-- Structure de la table `Boosters`

CREATE TABLE `Boosters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `cost` int NOT NULL,
  `nbCommon` int NOT NULL,
  `nbUncommon` int NOT NULL,
  `nbEpic` int NOT NULL,
  `nbLegendary` int NOT NULL,
  `nbRandom` int NOT NULL,
  `inShop` int NOT NULL DEFAULT 1,

  PRIMARY KEY (id)
);

-- Structure de la table `BoosterInventory`, lien entre utilisateurs et boosters

CREATE TABLE `BoosterInventory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ownerId` int NOT NULL,
  `boosterId` int NOT NULL,

  PRIMARY KEY (id),
  FOREIGN KEY (ownerId) REFERENCES Users(id),
  FOREIGN KEY (boosterId) REFERENCES Boosters(id)
);

-- Structure de la table `Cards`

CREATE TABLE `Cards` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `description` varchar(200),
  `idCreator` int NOT NULL,
  `minia_path` varchar(100) NOT NULL,
  `poster_path` varchar(100) NOT NULL,
  `rarity` int NOT NULL,
  
  PRIMARY KEY (id)
);

-- Structure de la table `Circulation`, lien entre utilisateurs et cards
CREATE TABLE `Circulation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ownerId` int NOT NULL,
  `cardId` int NOT NULL,
  `inMarket` int NOT NULL DEFAULT 0,

  PRIMARY KEY (id),
  FOREIGN KEY (ownerId) REFERENCES Users(id),
  FOREIGN KEY (cardId) REFERENCES Cards(id)
);

-- Structure de la table `MarketOffers`

CREATE TABLE `MarketOffers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `isTrade` int NOT NULL,
  `soldCardId` int NOT NULL,
  `cost` int,
  `tradedCardId` int,

  PRIMARY KEY (id),
  FOREIGN KEY (soldCardId) REFERENCES Circulation(id),
  FOREIGN KEY (tradedCardId) REFERENCES Cards(id)
);


--
-- C  hargement des données de la table `Users`
--
INSERT INTO `Users` (`mail`, `pseudo`, `pass`, `privileges`) VALUES
("duthoit.thomas9@gmail.com", "Thomas", "mdpsecurise", 2),
("ewen.b.2005@gmail.com", "Ewen", "motdepasse", 1),
("bob@gmail.com", "Bob", "itsmebob", 0);

--
-- Chargement des données de la table `Verification`
--
INSERT INTO `Verification` VALUES
(1, 1234),
(2, 4321),
(3, 0000);

--
-- Chargement des données de la table `Questions`
--
INSERT INTO `Questions` (`name`, `content`, `answer`, `reward`) VALUES
("Math élém !", "Que vaut 0!", "1", 5),
("Ohm", "Finir la loi d'Ohm: I=U/?. (donner la valeur de ? en majuscule)", "R", 5);

--
-- Chargement des données de la table `UserQuestions`
--
-- Vide par défaut

--
-- Chargement des données de la table `Publications`
--
INSERT INTO `Publications` (`name`, `description`, `idCreator`, `minia_path`, `poster_path`, `rarity`) VALUES
("Stade Bollaert", "Photo du stade Bollaert", 2, "bob_bollaert_minia.png", "bob_bollaert_poster.png", 1);

--
-- Chargement des données de la table `Boosters`
--
INSERT INTO `Boosters` (`name`, `cost`, `nbCommon`, `nbUncommon`, `nbEpic`, `nbLegendary`, `nbRandom`) VALUES
("Aléa", 50, 0, 0, 0, 0, 5),
("Starter", 50, 5, 1, 0, 0, 1),
("Légendaire", 800, 10, 5, 3, 1, 5);

-- Chargement des données de la table `BoosterInventory`
--
-- Vide par défaut

--
-- Chargement des données de la table `Cards`
--
INSERT INTO `Cards` (`name`, `description`, `idCreator`, `minia_path`, `poster_path`, `rarity`) VALUES
("IG2I", "L'IG2I dans toute sa splendeur", 1, "ig2i_minia.png", "ig2i_poster.png", 3),
("Base du 11/19", "Un air de vieillesse", 0, "base1119_minia.png", "base1119_poster.png", 1),
("Terrils de Loos", "Une vue spectaculaire !", 1, "terrilsLoos_minia.png", "terrilLoos_poster.png", 2),
("Douche", "Faut penser à se doucher quand on est informaticien...", 0, "douche_minia.png", "douche_poster.png", 0);

--
-- Chargement des données de la table `Circulation`
--
INSERT INTO `Circulation` (`ownerId`, `cardId`, `inMarket`) VALUES
(1, 1, 0),
(2, 1, 0),
(3, 2, 1);

--
-- Chargement des données de la table `MarketOffers`
--
INSERT INTO `MarketOffers` (`isTrade`, `soldCardId`, `cost`, `tradedCardId`) VALUES
(1, 2, 0, 3);
