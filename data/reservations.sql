-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Sam 19 Novembre 2016 à 07:58
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `reservations`
--

-- --------------------------------------------------------

--
-- Structure de la table `lieux`
--

CREATE TABLE `lieux` (
  `id` varchar(60) CHARACTER SET latin1 NOT NULL,
  `designation` varchar(255) CHARACTER SET latin1 NOT NULL,
  `adresse` varchar(255) CHARACTER SET latin1 NOT NULL,
  `localite` varchar(10) CHARACTER SET latin1 NOT NULL,
  `website` varchar(255) CHARACTER SET latin1 NOT NULL,
  `tel` varchar(30) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `lieux`
--

INSERT INTO `lieux` (`id`, `designation`, `adresse`, `localite`, `website`, `tel`) VALUES
('delvaux', 'Espace Delvaux / La Vénerie', '3 rue Gratès', '1170', '', ''),
('dexia', 'Dexia Art Center', '50 rue de l\'Ecuyer', '1000', '', ''),
('espacemagh', 'Espace Magh', '17 rue du Poinçon', '1000', 'http://www.espacemagh.be', '+32 (0)2 274 05 10'),
('samaritaine', 'La Samaritaine', '16 rue de la samaritaine', '1000', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `localites`
--

CREATE TABLE `localites` (
  `code` varchar(10) CHARACTER SET latin1 NOT NULL,
  `localite_fr` varchar(163) CHARACTER SET latin1 NOT NULL,
  `localite_nl` varchar(163) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `localites`
--

INSERT INTO `localites` (`code`, `localite_fr`, `localite_nl`) VALUES
('1000', 'Bruxelles', 'Brussel'),
('1020', 'Laeken', 'Laeken'),
('1050', 'Ixelles', 'Elsene'),
('1080', 'Etterbeek', 'Etterbeek'),
('1170', 'Watermael-Boitsfort', 'Watermaal-Bosvoorde'),
('1210', 'Saint-Josse-ten-Noode', 'Sint-joost-ten-node');

-- --------------------------------------------------------

--
-- Structure de la table `personnes`
--

CREATE TABLE `personnes` (
  `id` int(11) NOT NULL,
  `nom` varchar(60) CHARACTER SET latin1 NOT NULL,
  `prenom` varchar(60) CHARACTER SET latin1 NOT NULL,
  `dateNaiss` date NOT NULL,
  `sexe` char(1) CHARACTER SET latin1 NOT NULL,
  `abonne` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `personnes`
--

INSERT INTO `personnes` (`id`, `nom`, `prenom`, `dateNaiss`, `sexe`, `abonne`) VALUES
(1, 'Durand', 'Bob', '1978-12-05', 'h', 1),
(2, 'Hirogawa', 'Kenji', '1982-09-16', 'h', 0),
(3, 'Sylvestre', 'Juliette', '1980-05-01', 'f', 1);

-- --------------------------------------------------------

--
-- Structure de la table `representations`
--

CREATE TABLE `representations` (
  `id` int(11) NOT NULL,
  `id_spectacle` varchar(60) NOT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL,
  `id_lieu` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `representations`
--

INSERT INTO `representations` (`id`, `id_spectacle`, `date`, `heure`, `id_lieu`) VALUES
(1, 'ayiti', '2012-10-12', '13:30:00', 'delvaux'),
(6, 'ayiti', '2012-10-12', '20:30:00', 'dexia'),
(7, 'cible', '2012-10-02', '20:30:00', NULL),
(8, 'cible', '2012-10-03', '20:30:00', NULL),
(9, 'cible', '2012-10-04', '20:30:00', NULL),
(10, 'cible', '2012-10-05', '20:30:00', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `spectacles`
--

CREATE TABLE `spectacles` (
  `id` varchar(60) NOT NULL,
  `title` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `auteur` varchar(255) NOT NULL,
  `scenographie` varchar(255) NOT NULL,
  `distribution` varchar(400) NOT NULL,
  `lieu` varchar(60) NOT NULL,
  `tarifs` set('normal','senior','promo','') NOT NULL,
  `reservable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `spectacles`
--

INSERT INTO `spectacles` (`id`, `title`, `img`, `auteur`, `scenographie`, `distribution`, `lieu`, `tarifs`, `reservable`) VALUES
('ayiti', 'Ayiti', '/assets/images/ayiti.jpg', 'Daniel Marcelin et Philippe Laurent', 'Daniel Marcelin et Philippe Laurent', 'Daniel Marcelin', 'delvaux', 'senior', 1),
('chanteurbelge', 'Ceci n\'est pas un chanteur belge', '/assets/images/chanteurbelge.jpg', 'Claude Semal', 'Laurence Warin', 'Claude Semal', 'delvaux', '', 1),
('cible', 'Cible mouvante', '/assets/images/cible.jpg', 'Marius Von Mayenburg', 'Olivier Boudon', 'Anne Marie Loop, Pietro Varasso, Laurent Caron, Élena Perez et Guillaume Alexandre', 'dexia', '', 1),
('emigres', 'Émigrés', '/assets/images/emigres.jpg', 'Slawomir Mrozek', 'Najib Ghallale', 'Rachid Benbouchta et Mohamed Ouachen', 'espacemagh', '', 0),
('parvis', 'Les pavés du Parvis', '/assets/images/parvis.jpg', 'Pierre Wayburn et Gwendoline Gauthier', 'Philippe Laurent', 'Pierre Wayburn et Gwendoline Gauthier', 'samaritaine', '', 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `lieux`
--
ALTER TABLE `lieux`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `localites`
--
ALTER TABLE `localites`
  ADD PRIMARY KEY (`code`);

--
-- Index pour la table `personnes`
--
ALTER TABLE `personnes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `representations`
--
ALTER TABLE `representations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lieu` (`id_lieu`),
  ADD KEY `id_spectacle` (`id_spectacle`);

--
-- Index pour la table `spectacles`
--
ALTER TABLE `spectacles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `personnes`
--
ALTER TABLE `personnes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `representations`
--
ALTER TABLE `representations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
