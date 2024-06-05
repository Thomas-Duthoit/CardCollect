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
  `mail` varchar(100) NOT NULL UNIQUE,
  `pseudo` varchar(20) NOT NULL UNIQUE,
  `pass` varchar(50) NOT NULL,
  `privileges` int NOT NULL DEFAULT 0,
  `allowed` int DEFAULT 1,
  `coins` int DEFAULT 200,

  PRIMARY KEY (id)
) ;

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
INSERT INTO `Users` (`mail`, `pseudo`, `pass`, `privileges`, `coins`) VALUES
("duthoit.thomas9@gmail.com", "Thomas", "mdpsecurise", 2, 1000),
("ewen.b.2005@gmail.com", "Ewen", "motdepasse", 1, 1000),
("bob@gmail.com", "Bob", "itsmebob", 0, 200),
("user@gmail.com", "Test", "mdp", 2, 5000);

--

--
-- Chargement des données de la table `Questions`
--
INSERT INTO `Questions` (`name`, `content`, `answer`, `reward`) VALUES
("Math élém !", "Que vaut 0!", "1", 200),
("Ohm", "Finir la loi d'Ohm: I=U/?. (donner la valeur de ? en majuscule)", "R", 300),
("Diode", "Quelle est la tension de seuil d'une diode ?", "0,6", 300);


--
-- Chargement des données de la table `UserQuestions`
--
-- Vide par défaut

--
-- Chargement des données de la table `Publications`
--
-- Vide par défaut

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
("Herbe", "Va un peu dehors au lieu de tryhard", 2, "240604204149_Herbe_minia.jpg", "240604204149_Herbe_poster.jpg", 0),
("d100", "Ce dé est maudit en campagne...", 2, "240604210717_d100_minia.jpg", "240604210717_d100_poster.jpg", 0),
("Eau", "Dans 20-30 ans, y'en aura plus", 2, "240605094153_Eau_minia.jpg", "240605094153_Eau_poster.jpg", 0),
("Cahier", "Très utile pour les cours ce truc", 2, "240605104051_Cahier_minia.jpg", "240605104051_Cahier_poster.jpg", 0),
("Lunettes", "Avec le supplément anti lumière bleue s'il vous plait", 2, "240605110319_Lunettes_minia.jpg", "240605110319_Lunettes_poster.jpg", 0),
("Babyfoot", "Moins populaire que le ping-pong à 2I, c'est quand même sympa", 2, "240605110940_Babyfoot_minia.jpg", "240605110940_Babyfoot_poster.jpg", 0),
("Stickman", "Pour ceux qui ont du mal avec le dessin", 2, "240604185900_Sitckman_minia.png", "240604185900_Sitckman_poster.png", 1),
("Base_du_11_19", "Un air de vieillesse", 2, "240604205051_Base_du_11_19_minia.jpg", "240604205051_Base_du_11_19_poster.jpg", 1),
("Rubiks", "T'es chaud si t'arrives à le résoudre !", 2, "240604210030_Rubiks_minia.jpg", "240604210030_Rubiks_poster.jpg", 1),
("Ping-pong", "Un des nombreux sports de 2I", 2, "240605102748_Ping-pong_minia.jpg", "240605102748_Ping-pong_poster.jpg", 1),
("Terrils_de_Loos", "Une magnifique vue nous attend", 2, "240603113809_Terrils_de_Loos_minia.jpg", "240603113809_Terrils_de_Loos_poster.jpg", 2),
("Papillon", "Un des développeurs les adore... A voir de voir lequel.", 2, "240604211544_Papillon_minia.jpg", "240604211544_Papillon_poster.jpg", 2),
("Origami", "On peut faire beaucoup de choses avec du papier... L'un de nous y arrive, l'autre non.", 2, "240604230510_Origami_minia.jpg", "240604230510_Origami_poster.jpg", 2),
("IG2I", "La meilleur école d'ingénieur.", 2, "240604191606_IG2I_minia.jpg", "240604191606_IG2I_poster.jpg", 3),
("4", "Un 4 tout à fait normal, pas vrai ?", 2, "240605101440_4_minia.png", "240605101440_4_poster.png", 3);

--
-- Chargement des données de la table `Circulation`
--
-- Vide par défaut

--
-- Chargement des données de la table `MarketOffers`
--
-- Vide par défaut
