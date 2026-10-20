-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 20 oct. 2026 à 05:22
-- Version du serveur : 8.0.44
-- Version de PHP : 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hellodb`
--

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `idMembre` bigint UNSIGNED NOT NULL,
  `pseudoMembre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emailMembre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `motDePasseMembre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` enum('hors ligne','en ligne') COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateInscription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `derniereConnexion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`idMembre`, `pseudoMembre`, `emailMembre`, `motDePasseMembre`, `statut`, `dateInscription`, `derniereConnexion`) VALUES
(1, 'Van', 'van2021@outlook.fr', '$2y$10$z8H6LlvQbAjPxkqCCBktduB7FEX7bg0ZsJPBSXbMZzdQ3SI5IFGj.', 'en ligne', '2026-09-06 21:27:05', NULL),
(2, 'linda', 'linda@gmail.com', '$2y$10$lZ30oUhfUVKo3ZGuQyvvQuTfi6JpptbbEFnMc07L4E3j8kPd2evCa', 'en ligne', '2026-09-10 12:04:49', '2026-09-11 15:39:59');

-- --------------------------------------------------------

--
-- Structure de la table `messageinbox`
--

CREATE TABLE `messageinbox` (
  `idMessageInbox` bigint UNSIGNED NOT NULL,
  `idMembreExpediteur` bigint UNSIGNED NOT NULL,
  `idMembreDestinataire` bigint UNSIGNED NOT NULL,
  `messagetext` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `datemessage` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statutMessage` enum('send','received','seen') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'send'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messageinbox`
--

INSERT INTO `messageinbox` (`idMessageInbox`, `idMembreExpediteur`, `idMembreDestinataire`, `messagetext`, `datemessage`, `statutMessage`) VALUES
(1, 1, 2, '\"bb\"', '2026-09-11 16:35:02', 'send'),
(2, 2, 1, 'bonjour Van', '2026-09-11 16:36:09', 'send'),
(3, 1, 2, 'comment tu vas, Linda ?', '2026-09-11 16:37:12', 'send'),
(4, 2, 1, 'tres bien. cc', '2026-09-11 16:37:32', 'send'),
(5, 1, 2, '\"bb\"', '2026-10-18 18:16:29', 'send');

-- --------------------------------------------------------

--
-- Structure de la table `presenceinbox`
--

CREATE TABLE `presenceinbox` (
  `idPresence` bigint UNSIGNED NOT NULL,
  `idMembreExpediteurInbox` bigint UNSIGNED DEFAULT NULL,
  `idMembreDestinataireInbox` bigint UNSIGNED DEFAULT NULL,
  `saisieExpediteurInbox` enum('true','false') COLLATE utf8mb4_unicode_ci DEFAULT 'false',
  `saisieDestinataireInbox` enum('true','false') COLLATE utf8mb4_unicode_ci DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`idMembre`);

--
-- Index pour la table `messageinbox`
--
ALTER TABLE `messageinbox`
  ADD PRIMARY KEY (`idMessageInbox`),
  ADD KEY `fk_messageinbox_membresExpediteur` (`idMembreExpediteur`),
  ADD KEY `fk_messageinbox_membresDestinataire` (`idMembreDestinataire`);

--
-- Index pour la table `presenceinbox`
--
ALTER TABLE `presenceinbox`
  ADD PRIMARY KEY (`idPresence`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `idMembre` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `messageinbox`
--
ALTER TABLE `messageinbox`
  MODIFY `idMessageInbox` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `presenceinbox`
--
ALTER TABLE `presenceinbox`
  MODIFY `idPresence` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `messageinbox`
--
ALTER TABLE `messageinbox`
  ADD CONSTRAINT `fk_messageinbox_membresDestinataire` FOREIGN KEY (`idMembreDestinataire`) REFERENCES `membres` (`idMembre`),
  ADD CONSTRAINT `fk_messageinbox_membresExpediteur` FOREIGN KEY (`idMembreExpediteur`) REFERENCES `membres` (`idMembre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
