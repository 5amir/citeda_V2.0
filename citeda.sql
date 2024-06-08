-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  sam. 08 juin 2024 à 11:05
-- Version du serveur :  10.4.6-MariaDB
-- Version de PHP :  7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `citeda`
--

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE `historique` (
  `id_his` int(10) NOT NULL,
  `idimpr` int(10) NOT NULL,
  `d_i_phbn` int(10) NOT NULL,
  `n_i_phbn` int(10) NOT NULL,
  `d_i_phclr` int(10) NOT NULL,
  `n_i_phclr` int(10) NOT NULL,
  `d_i_impbn` int(10) NOT NULL,
  `n_i_impbn` int(10) NOT NULL,
  `d_i_impclr` int(10) NOT NULL,
  `n_i_impclr` int(10) NOT NULL,
  `date_his` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `historique`
--

INSERT INTO `historique` (`id_his`, `idimpr`, `d_i_phbn`, `n_i_phbn`, `d_i_phclr`, `n_i_phclr`, `d_i_impbn`, `n_i_impbn`, `d_i_impclr`, `n_i_impclr`, `date_his`) VALUES
(1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2024-06-08 09:59:03'),
(2, 4, 0, 0, 0, 0, 0, 0, 0, 0, '2024-06-08 16:34:00'),
(3, 6, 0, 0, 0, 0, 0, 0, 0, 0, '2024-06-08 07:29:45'),
(4, 7, 0, 0, 0, 0, 0, 0, 0, 0, '2024-06-08 09:29:03');

-- --------------------------------------------------------

--
-- Structure de la table `imprimente`
--

CREATE TABLE `imprimente` (
  `idimpr` int(10) NOT NULL,
  `nomimpr` varchar(30) NOT NULL,
  `prixphbn` int(10) NOT NULL,
  `priximbn` int(10) NOT NULL,
  `prixphclr` int(10) NOT NULL,
  `priximclr` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `imprimente`
--

INSERT INTO `imprimente` (`idimpr`, `nomimpr`, `prixphbn`, `priximbn`, `prixphclr`, `priximclr`) VALUES
(1, 'HP', 10, 25, 50, 100),
(4, 'Laser2', 40, 50, 30, 100),
(6, 'Ascii', 20, 40, 20, 50),
(7, 'Dell', 20, 50, 40, 30);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `iduser` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `passworduser` varchar(100) NOT NULL,
  `profil` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`iduser`, `nom`, `email`, `passworduser`, `profil`) VALUES
(1, 'FANOU', 'fanou@gmail.com', '$2y$10$VCDpX1d0IQ1Y98q4j7JVx.D7IGBhQ1Iug9r.q4A0AtpESTsHME1gG', 'PDG'),
(2, 'OYEOLA', 'celeste@gmail.com', '$2y$10$J1aXpiX3wzW648wje6PEK.ioK4At.7SC68UVmiUS9HTWGp747MId2', 'Secretaire');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`id_his`),
  ADD KEY `id_imp` (`idimpr`);

--
-- Index pour la table `imprimente`
--
ALTER TABLE `imprimente`
  ADD PRIMARY KEY (`idimpr`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `historique`
--
ALTER TABLE `historique`
  MODIFY `id_his` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `imprimente`
--
ALTER TABLE `imprimente`
  MODIFY `idimpr` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `historique`
--
ALTER TABLE `historique`
  ADD CONSTRAINT `historique_ibfk_1` FOREIGN KEY (`idimpr`) REFERENCES `imprimente` (`idimpr`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
