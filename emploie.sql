-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 01 avr. 2026 à 11:45
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `emploi`
--
CREATE DATABASE IF NOT EXISTS `emploi` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `emploi`;

-- --------------------------------------------------------

--
-- Structure de la table `ADMIN`
--

CREATE TABLE `ADMIN` (
  `id_admin` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `date_creation` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ADMIN`
--

INSERT INTO `ADMIN` (`id_admin`, `nom`, `prenom`, `email`, `mot_de_passe`, `date_creation`) VALUES
(1, 'Dupont', 'Jean', 'admin@ecole.fr', 'mk', '2026-01-31 17:10:29'),
(2, 'Martin', 'Sophie', 'admin2@ecole.fr', '$2y$10$abcdefghijklmnopqrstuv', '2026-01-31 17:10:29');

-- --------------------------------------------------------

--
-- Structure de la table `ASSISTER`
--

CREATE TABLE `ASSISTER` (
  `id_personne` int(11) NOT NULL,
  `id_creneau` int(11) NOT NULL,
  `presence` enum('présent','absent','non_défini') DEFAULT 'non_défini',
  `date_inscription` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ASSISTER`
--

INSERT INTO `ASSISTER` (`id_personne`, `id_creneau`, `presence`, `date_inscription`) VALUES
(1, 1, 'non_défini', '2026-01-31 17:10:30'),
(1, 5, 'non_défini', '2026-01-31 17:10:30'),
(1, 6, 'non_défini', '2026-01-31 17:10:30'),
(3, 2, 'non_défini', '2026-01-31 17:10:30'),
(3, 4, 'non_défini', '2026-01-31 17:10:30'),
(3, 7, 'non_défini', '2026-01-31 17:10:30'),
(4, 1, 'non_défini', '2026-01-31 17:10:30'),
(4, 2, 'non_défini', '2026-01-31 17:10:30'),
(4, 3, 'non_défini', '2026-01-31 17:10:30'),
(4, 4, 'non_défini', '2026-01-31 17:10:30'),
(5, 1, 'non_défini', '2026-01-31 17:10:30'),
(5, 2, 'non_défini', '2026-01-31 17:10:30'),
(5, 5, 'non_défini', '2026-01-31 17:10:30'),
(5, 6, 'non_défini', '2026-01-31 17:10:30'),
(6, 3, 'non_défini', '2026-01-31 17:10:30'),
(6, 4, 'non_défini', '2026-01-31 17:10:30'),
(6, 7, 'non_défini', '2026-01-31 17:10:30'),
(6, 8, 'non_défini', '2026-01-31 17:10:30'),
(7, 1, 'non_défini', '2026-01-31 17:10:30'),
(7, 4, 'non_défini', '2026-01-31 17:10:30'),
(7, 5, 'non_défini', '2026-01-31 17:10:30'),
(7, 6, 'non_défini', '2026-01-31 17:10:30');

-- --------------------------------------------------------

--
-- Structure de la table `COURS`
--

CREATE TABLE `COURS` (
  `id_cours` int(11) NOT NULL,
  `nom_cours` varchar(200) NOT NULL,
  `code_cours` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `COURS`
--

INSERT INTO `COURS` (`id_cours`, `nom_cours`, `code_cours`, `description`, `date_creation`) VALUES
(1, 'Mathématiques Avancées', 'MATH301', 'Cours de mathématiques niveau L3', '2026-01-31 17:10:30'),
(2, 'Physique Quantique', 'PHYS402', 'Introduction à la physique quantique', '2026-01-31 17:10:30'),
(3, 'Programmation Python', 'INFO201', 'Programmation orientée objet en Python', '2026-01-31 17:10:30'),
(4, 'Base de Données', 'INFO305', 'Conception et gestion de bases de données', '2026-01-31 17:10:30'),
(5, 'Algorithmique', 'INFO202', 'Algorithmes et structures de données', '2026-01-31 17:10:30');

-- --------------------------------------------------------

--
-- Structure de la table `CRENEAU`
--

CREATE TABLE `CRENEAU` (
  `id_creneau` int(11) NOT NULL,
  `date` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `salle` varchar(50) NOT NULL,
  `id_cours` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `date_creation` timestamp NULL DEFAULT current_timestamp(),
  `date_modification` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `filiere` varchar(20) NOT NULL,
  `id_personne` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `CRENEAU`
--

INSERT INTO `CRENEAU` (`id_creneau`, `date`, `heure_debut`, `heure_fin`, `salle`, `id_cours`, `id_admin`, `date_creation`, `date_modification`, `filiere`, `id_personne`) VALUES
(1, '2025-02-03', '08:00:00', '10:00:00', 'A101', 1, 1, '2026-01-31 17:10:30', '2026-02-19 19:16:16', 'IGL', 1),
(2, '2025-02-03', '10:15:00', '12:15:00', 'B205', 3, 1, '2026-01-31 17:10:30', '2026-02-19 19:17:01', 'BAT', 3),
(3, '2025-02-03', '14:00:00', '16:00:00', 'C303', 2, 1, '2026-01-31 17:10:30', '2026-02-19 19:17:14', '2nde C', 9),
(4, '2025-02-04', '08:00:00', '10:00:00', 'A102', 4, 1, '2026-01-31 17:10:30', '2026-02-19 19:17:40', 'GTO', 9),
(5, '2025-02-04', '10:15:00', '12:15:00', 'B206', 5, 1, '2026-01-31 17:10:30', '2026-02-19 19:17:52', 'FCL', 3),
(6, '2025-02-05', '08:00:00', '10:00:00', 'A101', 1, 2, '2026-01-31 17:10:30', '2026-02-19 19:18:08', '2nde C', 1),
(7, '2025-02-05', '14:00:00', '16:00:00', 'C304', 3, 2, '2026-01-31 17:10:30', '2026-02-19 19:18:21', '2nde A', 3),
(8, '2025-02-06', '10:15:00', '12:15:00', 'B205', 2, 2, '2026-01-31 17:10:30', '2026-02-19 19:18:32', 'BAT', 9),
(10, '2026-03-23', '12:30:00', '15:50:00', 'AMPHI', 4, 1, '2026-03-23 03:58:29', '2026-03-23 03:58:29', 'IGL', 18),
(11, '2026-04-11', '12:22:00', '12:26:00', 'AMPHI', 2, 1, '2026-04-01 09:21:36', '2026-04-01 09:21:36', 'FCL1', 28);

-- --------------------------------------------------------

--
-- Structure de la table `DISPONIBILITE`
--

CREATE TABLE `DISPONIBILITE` (
  `id_dispo` int(11) NOT NULL,
  `id_personne` int(11) NOT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `DISPONIBILITE`
--

INSERT INTO `DISPONIBILITE` (`id_dispo`, `id_personne`, `date`, `heure`) VALUES
(1, 1, '2026-03-11', '13:10:51');

-- --------------------------------------------------------

--
-- Structure de la table `ENSEIGNER`
--

CREATE TABLE `ENSEIGNER` (
  `id_personne` int(11) NOT NULL,
  `id_cours` int(11) NOT NULL,
  `date_affectation` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ENSEIGNER`
--

INSERT INTO `ENSEIGNER` (`id_personne`, `id_cours`, `date_affectation`) VALUES
(1, 1, '2026-01-31 17:10:30'),
(1, 5, '2026-01-31 17:10:30'),
(3, 3, '2026-01-31 17:10:30'),
(3, 4, '2026-01-31 17:10:30');

-- --------------------------------------------------------

--
-- Structure de la table `LEÇON`
--

CREATE TABLE `LEÇON` (
  `id_leçon` int(11) NOT NULL,
  `id_personne` int(11) NOT NULL,
  `id_cours` int(11) NOT NULL,
  `filiere` varchar(20) NOT NULL,
  `corps` text NOT NULL,
  `titre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `LEÇON`
--

INSERT INTO `LEÇON` (`id_leçon`, `id_personne`, `id_cours`, `filiere`, `corps`, `titre`) VALUES
(2, 1, 1, 'IGL', 'jg vtrxrtd7tfttezdxrcfgctrxxdx', 'Les probabilites'),
(3, 1, 1, 'BAT', 'yrsteutuhiyfu6fhgyt', 'La gravitation'),
(6, 1, 1, 'IGL', 'ydr6dtffytgt7f76ftuv6rydrtcfctrd5rtdrtgf', 'Nomenclature'),
(7, 1, 2, 'BAT', 'Tout corps possède une masse et cette masse est soumise a une loi d\'attraction vers un corps plus massif.', 'La gravitation'),
(8, 18, 4, 'IGL', 'y8f5g65ffbyf6ffhrdrctfcxufcfxctu', 'Base de donnees'),
(9, 1, 1, 'BAT', 'utf77g97t8ttruiguygugu', 'La trigo'),
(10, 18, 1, '8', 'iygyyyb gytyuygy7bf76f76g776gygy7g7t', 'La trigo'),
(11, 18, 1, '8', 'iygyyyb gytyuygy7bf76f76g776gygy7g7t', 'La trigo'),
(12, 18, 4, '1', 'yg7fgg7g767g7tffygvtr', 'La programmation'),
(13, 18, 4, '1', 'yg7fgg7g767g7tffygvtr', 'La programmation'),
(14, 18, 2, '5', 'yrd5vf6f6f655thftrde', 'La vitesse de la lumiere'),
(15, 25, 1, 'IGL2', 'RAS\r\nRAS\r\nRAs', 'RAS'),
(16, 28, 2, 'IGL2', 'sdsdsd', 'qsdsqd'),
(17, 28, 1, 'IGL2', 'Le terme bizarre qualifie quelque chose d\'étrange, d\'anormal ou d\'insolite qui surprend par son caractère excentrique. Il s\'emploie pour décrire des comportements déroutants, des situations inattendues ou desapparences insolites, souvent synonyme de chelou, étrange, saugrenu, ou singulier. \r\nYouTube\r\nYouTube\r\n +2\r\nExemples d\'usage :\r\nComportement : « Il a eu une réaction vraiment bizarre lors de la réunion ».\r\nSituation : « C\'est bizarre de voir la rue aussi déserte un samedi ».\r\nApparence : « Elle portait un chapeau assez bizarre ». \r\nYouTube\r\nYouTube\r\n +1\r\nSynonymes courants :\r\nÉtrange\r\nChelou (familier)\r\nSingulier\r\nSaugrenu\r\nExcentrique\r\nInsolite\r\nBizarre (dans le sens de \"bizarre, bizarre\", étrange et inexpliqué). \r\nYouTube\r\nYouTube\r\n +2\r\nHiro - Bizarre Ft. Mauvais Djo\r\n20 mars 2026 — bizarre. mais j\'ai comme une impression. bizarre. bizar biz chelou bizar Biz son Biz sont bizar Bizar.\r\n\r\n\r\nYouTube\r\n·\r\nHiro officiel\r\n\r\n50s\r\nBizarre\r\n1 mai 2025 — bizarre bizarre bizarre ouais ouais mon c\'est bizarre bizarre bizarre bizarre il vécur heureux beaucoup d\'enfants mais beaucoup d\'\r\n\r\n\r\nYouTube\r\n·\r\nAntes & Madzes - Topic\r\n\r\n58s\r\nBizarre - meaning & definition in Lingvanex Dictionary\r\nMeaning & Definition Which is strange, which is out of the ordinary. His bizarre behavior surprised everyone. Son comportement biz...\r\n\r\nLingvanex\r\n', 'cour bizare');

-- --------------------------------------------------------

--
-- Structure de la table `PERSONNE`
--

CREATE TABLE `PERSONNE` (
  `id_personne` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `enseignant` tinyint(1) NOT NULL DEFAULT 1,
  `date_inscription` timestamp NULL DEFAULT current_timestamp(),
  `filiere` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `PERSONNE`
--

INSERT INTO `PERSONNE` (`id_personne`, `nom`, `prenom`, `email`, `mot_de_passe`, `enseignant`, `date_inscription`, `filiere`) VALUES
(1, 'Lepain', 'patricia', 'patrice.Lepain@ecole.fr', '$2y$10$IAwyy0/tRn/AZu6zxn/Ajuvy7WmD9Ju6dpEOpqlSam9ICTOFpn7zq', 1, '2026-01-31 17:10:29', ''),
(3, 'Moreau', 'Luc', 'luc.moreau@ecole.fr', '$2y$10$rPaiOfTuNCEAuyTb3GqWm.Fw3PqCSeiMXPuJ19n5ZOujGOJFpXHUi', 1, '2026-01-31 17:10:29', ''),
(4, 'Bernard', 'Alice', 'alice.bernard@ecole.fr', '$2y$10$019ZfR5wBPldap/sK99tLuoRkeqs9JdWW/OuLc6AADFKzMdrQi0vq', 0, '2026-01-31 17:10:30', 'IGL'),
(5, 'Petit', 'Thomas', 'thomas.petit@ecole.fr', '$2y$10$X6oW2Dbuqf1o5SkPI5ovQeMgLkKVrueu9xjQslgoJ2r716x8zjLqe', 0, '2026-01-31 17:10:30', 'BAT'),
(6, 'Roux', 'Emma', 'emma.roux@ecole.fr', '$2y$10$abcdefghijklmnopqrstuv', 0, '2026-01-31 17:10:30', '2nde C'),
(7, 'Lambert', 'Hugo', 'hugo.lambert@ecole.fr', '$2y$10$abcdefghijklmnopqrstuv', 0, '2026-01-31 17:10:30', 'GTO'),
(9, 'MBAPPE', 'Andre', 'Andre@ecole.fr', '$2y$10$JIWpAmrHfGC3zTJczQNErOgD/uD7rVIRnYp.9yvqTOsV6B/.hfuBC', 1, '2026-02-16 07:01:43', NULL),
(10, 'YOMBI', 'MIKE', 'Michaelson@mike', '$2y$10$/PIhM1Q999rKHPA/xSgkUesJWmyDIBwsH8JCa4zE9.pmQJ67JWiG.', 0, '2026-02-16 07:48:02', NULL),
(11, 'MBELE', 'MIKE', 'mike@gmail.com', '$2y$10$KUryU4MWLGLxHXEykAIrjO7JnW8PS54yYTIf06G7FfveAEEtBptYa', 0, '2026-03-18 23:00:00', 'IGL'),
(15, 'Pedri', 'versachi', 'Barsa@gmail.com', '$2y$10$dY9rEAGGJ932L1Aq9CPjIODdfpA2s2ztjGFPMMzcoHh1sBzpreZyC', 1, '2026-03-18 23:00:00', NULL),
(17, 'Spencer', 'Martin', 'Martin@gmail.com', '$2y$10$k5TbqeFIiJzHDu/DT1J0ZeIftbJqaV4vTOYRzU2FbUdMt7xevrakG', 1, '2026-03-19 23:00:00', NULL),
(18, 'Essoh', 'Michael', 'Essoh@gmail.com', '$2y$10$KqzkmigCuhfbcVIgmE/BaOx64pWHo5dtPgHCpmGtOLr3u1rBlwfLi', 1, '2026-03-21 23:00:00', NULL),
(20, 'MOMO', 'Edie', 'Edie@ecole.fr', '$2y$10$tC3udN7aN8qVRa1zjyp6QeH/aW9ouB8BRz5/i.pmhAKNQEeKVFxFG', 0, '2026-03-21 23:00:00', 'IGL'),
(21, 'Braun', 'Richard', 'Richard@ecole.fr', '$2y$10$zb6gEynnym02wrJqtt94.e158yJg6NBi9oifnMDkWoW7aA3yBY3KO', 1, '2026-03-23 23:00:00', NULL),
(22, 'beauty', 'dan', 'admin@ecole.fr', '$2y$10$L3WBYSdPqIFrHTfeDgaPrOq8T7M/bhePeBgWapJjf.6h.TsNfBCBG', 1, '2026-04-01 08:33:46', NULL),
(25, 'dany', 'francko', 'dan@gmail.com', '$2y$10$/UsxiXaCwiBs8VPtC4G/L.RwFOOCadms6mo7hYzrOW1soBtNNfap2', 1, '2026-04-01 08:36:02', NULL),
(27, 'Test Erreur', 'francko', 'etudiant@gmail.com', '$2y$10$mBHmzReVYFOhkd3UUuAYteLQZOWVkcaCbzmL461M8pb53cNNDng6q', 0, '2026-04-01 08:37:53', 'IGL1'),
(28, 'Test Erreur', 'francko', 'en@gmail.com', '$2y$10$lcr9xu773YfsYc3SK80hSecojFxwb78nlvbxz4EwnWrHiWEzz00zK', 1, '2026-04-01 08:46:27', NULL),
(29, 'dans', 'dans', 'etu@gmail.com', '$2y$10$grRrKEUzmbxN4.6lVry8b.xk/TtBORIe5QgzS7ZqWLhpuEOwIyyFW', 0, '2026-04-01 08:48:32', 'IGL2');

-- --------------------------------------------------------

--
-- Structure de la table `REQUETE`
--

CREATE TABLE `REQUETE` (
  `id_requete` int(11) NOT NULL,
  `objet` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `date_envoi` timestamp NULL DEFAULT current_timestamp(),
  `statut` enum('en_attente','acceptee','refusee') DEFAULT 'en_attente',
  `reponse` text DEFAULT NULL,
  `date_traitement` timestamp NULL DEFAULT NULL,
  `id_personne` int(11) NOT NULL,
  `id_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `REQUETE`
--

INSERT INTO `REQUETE` (`id_requete`, `objet`, `message`, `date_envoi`, `statut`, `reponse`, `date_traitement`, `id_personne`, `id_admin`) VALUES
(2, 'Annulation de cours', 'Je dois annuler mon cours du 05/02 pour raison médicale.', '2026-01-31 17:10:30', 'acceptee', 'Requête approuvée. Le cours est annulé.', '2026-02-20 17:45:30', 1, 1),
(4, 'Demande de matériel', 'J\'aimerais avoir accès au projecteur réserver aux filières informatique.', '2026-02-19 13:00:23', 'refusee', 'Accès refusé', '2026-02-24 17:28:58', 1, 1),
(6, 'Absence le 28/02/2026', 'Je ne me sens pas bien\r\n', '2026-02-27 23:00:00', 'refusee', NULL, '2026-03-10 19:33:29', 1, NULL),
(9, 'Aimerais commencer les cours', 'Bonjour j\'aimerais donner des cours le plus tôt possible avec ma classe ', '2026-03-19 23:00:00', 'refusee', NULL, '2026-03-20 10:25:31', 17, NULL),
(10, 'Avoir acces au Laboratoire', 'L\'AMPHI seras occuper pendant mon cour je souhaite pouvoir avoir acces au labo s\'il vous plait', '2026-03-22 23:00:00', 'refusee', NULL, '2026-03-23 04:09:58', 18, NULL),
(11, 'Flemme de faire le cour au day ', 'moi je suis fatigué je veux aller dormir ', '2026-03-31 23:00:00', 'acceptee', NULL, NULL, 28, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `SALLE`
--

CREATE TABLE `SALLE` (
  `id_salle` int(11) NOT NULL,
  `nom_salle` varchar(20) NOT NULL,
  `capacité` int(11) NOT NULL,
  `disponible` tinyint(1) NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `jour` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `SALLE`
--

INSERT INTO `SALLE` (`id_salle`, `nom_salle`, `capacité`, `disponible`, `heure_debut`, `heure_fin`, `jour`) VALUES
(2, 'AMPHI', 150, 1, '11:30:13', '15:47:00', '2026-03-24');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `v_emploi_temps`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `v_emploi_temps` (
`id_creneau` int(11)
,`date` date
,`heure_debut` time
,`heure_fin` time
,`salle` varchar(50)
,`nom_cours` varchar(200)
,`code_cours` varchar(20)
,`enseignant` varchar(201)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `v_emploi_temps_personne`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `v_emploi_temps_personne` (
`id_personne` int(11)
,`nom_complet` varchar(201)
,`enseignant` tinyint(1)
,`date` date
,`heure_debut` time
,`heure_fin` time
,`salle` varchar(50)
,`nom_cours` varchar(200)
,`code_cours` varchar(20)
,`presence` enum('présent','absent','non_défini')
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `v_requetes_en_attente`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `v_requetes_en_attente` (
`id_requete` int(11)
,`objet` varchar(200)
,`message` text
,`date_envoi` timestamp
,`enseignant` varchar(201)
,`email` varchar(150)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `v_statistiques_cours`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `v_statistiques_cours` (
`id_cours` int(11)
,`nom_cours` varchar(200)
,`code_cours` varchar(20)
,`nb_creneaux` bigint(21)
,`nb_participants` bigint(21)
,`nb_enseignants` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure de la vue `v_emploi_temps`
--
DROP TABLE IF EXISTS `v_emploi_temps`;

CREATE ALGORITHM=UNDEFINED DEFINER=`phpmyadmin`@`localhost` SQL SECURITY DEFINER VIEW `v_emploi_temps`  AS SELECT `cr`.`id_creneau` AS `id_creneau`, `cr`.`date` AS `date`, `cr`.`heure_debut` AS `heure_debut`, `cr`.`heure_fin` AS `heure_fin`, `cr`.`salle` AS `salle`, `co`.`nom_cours` AS `nom_cours`, `co`.`code_cours` AS `code_cours`, concat(`p`.`prenom`,' ',`p`.`nom`) AS `enseignant` FROM (((`CRENEAU` `cr` join `COURS` `co` on(`cr`.`id_cours` = `co`.`id_cours`)) left join `ENSEIGNER` `e` on(`co`.`id_cours` = `e`.`id_cours`)) left join `PERSONNE` `p` on(`e`.`id_personne` = `p`.`id_personne`)) ORDER BY `cr`.`date` ASC, `cr`.`heure_debut` ASC ;

-- --------------------------------------------------------

--
-- Structure de la vue `v_emploi_temps_personne`
--
DROP TABLE IF EXISTS `v_emploi_temps_personne`;

CREATE ALGORITHM=UNDEFINED DEFINER=`phpmyadmin`@`localhost` SQL SECURITY DEFINER VIEW `v_emploi_temps_personne`  AS SELECT `p`.`id_personne` AS `id_personne`, concat(`p`.`prenom`,' ',`p`.`nom`) AS `nom_complet`, `p`.`enseignant` AS `enseignant`, `cr`.`date` AS `date`, `cr`.`heure_debut` AS `heure_debut`, `cr`.`heure_fin` AS `heure_fin`, `cr`.`salle` AS `salle`, `co`.`nom_cours` AS `nom_cours`, `co`.`code_cours` AS `code_cours`, `a`.`presence` AS `presence` FROM (((`PERSONNE` `p` join `ASSISTER` `a` on(`p`.`id_personne` = `a`.`id_personne`)) join `CRENEAU` `cr` on(`a`.`id_creneau` = `cr`.`id_creneau`)) join `COURS` `co` on(`cr`.`id_cours` = `co`.`id_cours`)) ORDER BY `p`.`id_personne` ASC, `cr`.`date` ASC, `cr`.`heure_debut` ASC ;

-- --------------------------------------------------------

--
-- Structure de la vue `v_requetes_en_attente`
--
DROP TABLE IF EXISTS `v_requetes_en_attente`;

CREATE ALGORITHM=UNDEFINED DEFINER=`phpmyadmin`@`localhost` SQL SECURITY DEFINER VIEW `v_requetes_en_attente`  AS SELECT `r`.`id_requete` AS `id_requete`, `r`.`objet` AS `objet`, `r`.`message` AS `message`, `r`.`date_envoi` AS `date_envoi`, concat(`p`.`prenom`,' ',`p`.`nom`) AS `enseignant`, `p`.`email` AS `email` FROM (`REQUETE` `r` join `PERSONNE` `p` on(`r`.`id_personne` = `p`.`id_personne`)) WHERE `r`.`statut` = 'en_attente' ORDER BY `r`.`date_envoi` ASC ;

-- --------------------------------------------------------

--
-- Structure de la vue `v_statistiques_cours`
--
DROP TABLE IF EXISTS `v_statistiques_cours`;

CREATE ALGORITHM=UNDEFINED DEFINER=`phpmyadmin`@`localhost` SQL SECURITY DEFINER VIEW `v_statistiques_cours`  AS SELECT `co`.`id_cours` AS `id_cours`, `co`.`nom_cours` AS `nom_cours`, `co`.`code_cours` AS `code_cours`, count(distinct `cr`.`id_creneau`) AS `nb_creneaux`, count(distinct `a`.`id_personne`) AS `nb_participants`, count(distinct `e`.`id_personne`) AS `nb_enseignants` FROM (((`COURS` `co` left join `CRENEAU` `cr` on(`co`.`id_cours` = `cr`.`id_cours`)) left join `ASSISTER` `a` on(`cr`.`id_creneau` = `a`.`id_creneau`)) left join `ENSEIGNER` `e` on(`co`.`id_cours` = `e`.`id_cours`)) GROUP BY `co`.`id_cours`, `co`.`nom_cours`, `co`.`code_cours` ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ADMIN`
--
ALTER TABLE `ADMIN`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `ASSISTER`
--
ALTER TABLE `ASSISTER`
  ADD PRIMARY KEY (`id_personne`,`id_creneau`),
  ADD KEY `id_creneau` (`id_creneau`),
  ADD KEY `idx_presence` (`presence`);

--
-- Index pour la table `COURS`
--
ALTER TABLE `COURS`
  ADD PRIMARY KEY (`id_cours`),
  ADD UNIQUE KEY `code_cours` (`code_cours`);

--
-- Index pour la table `CRENEAU`
--
ALTER TABLE `CRENEAU`
  ADD PRIMARY KEY (`id_creneau`),
  ADD KEY `id_cours` (`id_cours`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `idx_date` (`date`),
  ADD KEY `idx_salle` (`salle`),
  ADD KEY `id_personne` (`id_personne`);

--
-- Index pour la table `DISPONIBILITE`
--
ALTER TABLE `DISPONIBILITE`
  ADD PRIMARY KEY (`id_dispo`);

--
-- Index pour la table `ENSEIGNER`
--
ALTER TABLE `ENSEIGNER`
  ADD PRIMARY KEY (`id_personne`,`id_cours`),
  ADD KEY `id_cours` (`id_cours`);

--
-- Index pour la table `LEÇON`
--
ALTER TABLE `LEÇON`
  ADD PRIMARY KEY (`id_leçon`),
  ADD KEY `id_cours` (`id_cours`),
  ADD KEY `id_personne` (`id_personne`);

--
-- Index pour la table `PERSONNE`
--
ALTER TABLE `PERSONNE`
  ADD PRIMARY KEY (`id_personne`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_enseignant` (`enseignant`);

--
-- Index pour la table `REQUETE`
--
ALTER TABLE `REQUETE`
  ADD PRIMARY KEY (`id_requete`),
  ADD KEY `id_personne` (`id_personne`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `idx_statut` (`statut`),
  ADD KEY `idx_date_envoi` (`date_envoi`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `CRENEAU`
--
ALTER TABLE `CRENEAU`
  MODIFY `id_creneau` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `LEÇON`
--
ALTER TABLE `LEÇON`
  MODIFY `id_leçon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `PERSONNE`
--
ALTER TABLE `PERSONNE`
  MODIFY `id_personne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `REQUETE`
--
ALTER TABLE `REQUETE`
  MODIFY `id_requete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
