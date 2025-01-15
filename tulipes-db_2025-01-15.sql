-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 15 jan. 2025 à 10:49
-- Version du serveur : 8.2.0
-- Version de PHP : 8.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tulipes`
--

-- --------------------------------------------------------

--
-- Structure de la table `tulipes`
--

CREATE TABLE `tulipes` (
  `id` int NOT NULL,
  `quantite` int NOT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `moyen_de_paiement` enum('cheque','espece','carte') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `est_paye` tinyint(1) NOT NULL,
  `idusers` int DEFAULT NULL,
  `signature` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `adresse` varchar(255) NOT NULL,
  `client` varchar(255) NOT NULL,
  `semaines` json DEFAULT NULL,
  `telephone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `remarque` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tulipes`
--

INSERT INTO `tulipes` (`id`, `quantite`, `prix`, `moyen_de_paiement`, `est_paye`, `idusers`, `signature`, `adresse`, `client`, `semaines`, `telephone`, `remarque`) VALUES
(1, 3, 30.00, 'cheque', 0, NULL, '', '', '', NULL, '', ''),
(2, 5, 50.00, 'cheque', 1, 4, 'signature_1728456333.png', 'Chez mwa', 'Junior', '[\"2\", \"3\"]', '', ''),
(3, 1, 10.00, 'cheque', 1, 4, 'signature_1728377092.png', 'baudimont', 'Mathieu', '[\"1\", \"2\"]', '', ''),
(6, 5, 50.00, 'cheque', 1, 4, 'signature_1728391905.png', 'La pharmacie', 'Pharmacie ', '[\"1\", \"2\", \"3\"]', '', ''),
(7, 5, 50.00, 'espece', 1, 3, 'signature_1728394151.png', 'Chez mwa', 'Junior', '[\"1\", \"2\", \"3\"]', '', ''),
(9, 5, 50.00, 'espece', 1, 6, 'signature_1728457898.png', 'La pharmacie', 'Junior', '[\"1\"]', '', ''),
(10, 10, 100.00, 'cheque', 1, 6, NULL, '2 rue de chez mwa', 'Mathieu', '[\"3\"]', '', ''),
(11, 12, 120.00, 'espece', 1, 6, NULL, 'baudimont', 'Junior', '[\"1\", \"2\", \"3\"]', '', ''),
(12, 12, 120.00, 'espece', 1, 5, 'signature_1728476924.png', 'baudimont', 'test', '[\"3\"]', '0624982404', ''),
(15, 4, 40.00, 'carte', 1, 5, 'signature_1731577321.png', 'nerjgnperiugnu', 'Jean', '[\"1\"]', '0546256252222222', 'non');

--
-- Déclencheurs `tulipes`
--
DELIMITER $$
CREATE TRIGGER `add_prix` BEFORE INSERT ON `tulipes` FOR EACH ROW BEGIN
    -- Calcul du prix basé sur la quantité
    SET NEW.prix = NEW.quantite * 10;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_prix` BEFORE UPDATE ON `tulipes` FOR EACH ROW BEGIN
    IF NEW.quantite <> OLD.quantite THEN
        SET NEW.prix = NEW.quantite * 10;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `groupe` varchar(255) NOT NULL,
  `role` enum('Eleve','Professeur') NOT NULL,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `groupe`, `role`, `login`, `email`, `password`) VALUES
(3, 'groupe 2', 'Eleve', 'groupe2', 'test@gmail.com', '$2y$10$QVbFkNgaR/bXBOqoGMfMt.BXHPiUC1GJjfpy6hqyhfi4yyhfHjB2e'),
(4, '1', 'Eleve', 'test', 'test@ui.com', '$2y$10$ytACbCnUQTIVniEFduhm0eoepekFiKCM0E2MRnc1V7S4akIaCt1lW'),
(5, 'Prof', 'Professeur', 'Prof', 'prof@outlook.com', '$2y$10$2KIl87gRO4O3bOOecQM3feHGZAjMAxuB5MdxZfYhf/Qh8ctkpFcrO'),
(6, 'groupe1', 'Eleve', 'groupe1', 'groupe1@gmail.com', '$2y$10$G4tjVoA86NsQpEC82lXEsO4IWsriuJGHY47Q0dreoo/kQXzrxibli');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tulipes`
--
ALTER TABLE `tulipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idusers` (`idusers`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tulipes`
--
ALTER TABLE `tulipes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
