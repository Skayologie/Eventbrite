-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 12 fév. 2025 à 08:45
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
-- Base de données : `eventbrite`
--
CREATE DATABASE IF NOT EXISTS `eventbrite` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `eventbrite`;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `categorie_id` int(11) NOT NULL,
  `categorie_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`categorie_id`, `categorie_name`) VALUES
(26, 'Religious Ceremony'),
(28, 'Robotics Competition'),
(27, 'Science Fair'),
(2, 'Seminar'),
(18, 'Theater Play'),
(5, 'Trade Show'),
(12, 'Training Session'),
(9, 'Web Development Workshop'),
(30, 'Wine Tasting'),
(3, 'Workshop'),
(22, 'Yoga Session');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `comment_content` varchar(255) DEFAULT NULL,
  `commented_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_creator` int(11) DEFAULT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `event_city` varchar(255) DEFAULT NULL,
  `event_link` varchar(255) DEFAULT NULL,
  `event_price` float(10,2) DEFAULT 0.00,
  `event_address` varchar(255) NOT NULL,
  `event_capacity` int(11) DEFAULT 10,
  `event_category` int(11) NOT NULL,
  `event_type` enum('vip','free','paid','earlybird') DEFAULT NULL,
  `event_status` enum('accepted','rejected','pending') DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `promo_code` int(11) DEFAULT -1,
  `available_seats` int(11) DEFAULT `event_capacity`,
  `thumbnail` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `event_tags`
--

CREATE TABLE `event_tags` (
  `event_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `notification_message` varchar(255) DEFAULT NULL,
  `notification_time` time DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `receiver_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `promo_codes`
--

CREATE TABLE `promo_codes` (
  `code_id` int(11) NOT NULL,
  `code` varchar(25) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `discount` int(2) DEFAULT NULL,
  `expiring_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `promo_codes`
--

INSERT INTO `promo_codes` (`code_id`, `code`, `event_id`, `discount`, `expiring_date`) VALUES
(1, 'U41', 0, 1, '2025-01-04'),
(2, 'NZWR', 0, 2, '2024-06-07'),
(3, 'LIPZ', 0, 3, '2024-02-15'),
(4, 'USPP', 0, 4, '2024-05-14'),
(5, 'OEJB', 0, 5, '2024-11-23'),
(6, 'AGGH', 0, 6, '2025-01-01'),
(7, 'UESK', 0, 7, '2024-05-31'),
(8, 'SAOS', 0, 8, '2024-12-22'),
(9, 'WABB', 0, 9, '2024-06-03'),
(10, 'ZSLQ', 0, 10, '2024-10-20'),
(11, 'FMSF', 0, 11, '2025-01-02'),
(12, 'LEAM', 0, 12, '2024-08-30'),
(13, NULL, 0, 13, '2025-02-02'),
(14, 'OPRK', 0, 14, '2024-05-30'),
(15, 'DAFH', 0, 15, '2024-11-06'),
(16, 'NTKT', 0, 16, '2024-05-23'),
(17, 'KLHW', 0, 17, '2024-08-19'),
(18, 'KDUJ', 0, 18, '2024-06-01'),
(19, 'FYLZ', 0, 19, '2024-11-27'),
(20, 'LRCL', 0, 20, '2024-07-12'),
(21, 'YBRU', 0, 21, '2025-01-06'),
(22, 'FYKM', 0, 22, '2024-04-09'),
(23, 'CYFC', 0, 23, '2024-05-26'),
(24, 'HKGA', 0, 24, '2024-09-02'),
(25, 'FAKN', 0, 25, '2025-01-25'),
(26, 'KORS', 0, 26, '2024-08-26'),
(27, 'KFBR', 0, 27, '2024-12-12'),
(28, 'WMKA', 0, 28, '2024-09-18'),
(29, 'KPWK', 0, 29, '2024-09-24'),
(30, 'WIII', 0, 30, '2024-06-17'),
(31, 'FLSN', 0, 31, '2024-12-04'),
(32, 'ORBD', 0, 32, '2025-01-09'),
(33, 'SNOE', 0, 33, '2024-04-25'),
(34, 'LGMT', 0, 34, '2024-03-12'),
(35, 'KPVZ', 0, 35, '2024-06-12'),
(36, 'KSDM', 0, 36, '2024-11-15'),
(37, 'KFRG', 0, 37, '2024-09-14'),
(38, 'FYLS', 0, 38, '2024-09-01'),
(39, 'KASH', 0, 39, '2024-11-09'),
(40, 'AYTR', 0, 40, '2024-03-18'),
(41, 'YGLB', 0, 41, '2024-07-10'),
(42, '07FA', 0, 42, '2025-02-10'),
(43, 'FXSH', 0, 43, '2024-05-11'),
(44, 'HSGN', 0, 44, '2024-10-20'),
(45, 'RPUS', 0, 45, '2024-03-12'),
(46, 'SAAV', 0, 46, '2025-01-18'),
(47, 'OPMT', 0, 47, '2024-07-05'),
(48, 'FZFU', 0, 48, '2025-01-19'),
(49, 'YDRH', 0, 49, '2024-12-02'),
(50, 'SBPF', 0, 50, '2024-12-06'),
(51, 'LFRE', 0, 51, '2024-10-15'),
(52, 'YCCT', 0, 52, '2024-08-19'),
(53, 'LEZL', 0, 53, '2024-11-14'),
(54, 'FZKA', 0, 54, '2024-06-20'),
(55, 'KBWP', 0, 55, '2024-02-17'),
(56, 'SAVQ', 0, 56, '2024-04-02'),
(57, 'KLBX', 0, 57, '2024-12-26'),
(58, 'PARY', 0, 58, '2024-08-11'),
(59, 'YARA', 0, 59, '2024-08-18'),
(60, 'KCGX', 0, 60, '2024-03-31'),
(61, 'NGTE', 0, 61, '2024-12-17'),
(62, 'PAED', 0, 62, '2024-12-04'),
(63, 'KDGW', 0, 63, '2024-10-26'),
(64, 'YMWA', 0, 64, '2024-12-15'),
(65, NULL, 0, 65, '2024-08-24'),
(66, 'MP00', 0, 66, '2024-06-19'),
(67, 'CYGX', 0, 67, '2024-02-11'),
(68, 'VLSK', 0, 68, '2024-12-20'),
(69, 'GLMR', 0, 69, '2024-05-17'),
(70, 'FNCV', 0, 70, '2024-11-09'),
(71, 'CYFE', 0, 71, '2024-09-10'),
(72, 'ESNX', 0, 72, '2024-03-21'),
(73, 'WAWS', 0, 73, '2024-03-21'),
(74, 'KBLI', 0, 74, '2024-09-27'),
(75, 'KKU', 0, 75, '2024-07-04'),
(76, 'KAHC', 0, 76, '2024-07-01'),
(77, 'VCCC', 0, 77, '2024-03-08'),
(78, 'HKOM', 0, 78, '2024-07-19'),
(79, 'KS33', 0, 79, '2025-01-03'),
(80, 'PAOH', 0, 80, '2024-08-28'),
(81, 'YPDA', 0, 81, '2024-11-17'),
(82, 'LPSI', 0, 82, '2024-08-01'),
(83, 'SDRS', 0, 83, '2024-02-27'),
(84, 'KCGZ', 0, 84, '2024-08-31'),
(85, 'KSJC', 0, 85, '2024-12-20'),
(86, 'KMZZ', 0, 86, '2024-07-22'),
(87, 'KSMF', 0, 87, '2024-05-27'),
(88, 'YKIR', 0, 88, '2024-05-06'),
(89, 'KPMD', 0, 89, '2024-05-18'),
(90, 'GUKU', 0, 90, '2024-04-20'),
(91, 'YCDR', 0, 91, '2025-02-01'),
(92, 'WAMR', 0, 92, '2024-02-26'),
(93, 'NZMO', 0, 93, '2024-04-02'),
(94, 'SARP', 0, 94, '2024-09-04'),
(95, 'KHTL', 0, 95, '2024-08-29'),
(96, 'KPBG', 0, 96, '2024-12-11'),
(97, 'PAMO', 0, 97, '2024-11-18'),
(98, 'LWOH', 0, 98, '2024-03-03'),
(99, 'KGNV', 0, 99, '2024-06-14'),
(100, 'UT25', 0, 100, '2024-11-08');

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `region` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `region`
--

INSERT INTO `region` (`id`, `region`) VALUES
(1, 'Tanger-Tétouan-Al Hoceïma'),
(2, 'l\'Oriental'),
(3, 'Fès-Meknès'),
(4, 'Rabat-Salé-Kénitra'),
(5, 'Béni Mellal-Khénifra'),
(6, 'Casablanca-Settat'),
(7, 'Marrakech-Safi'),
(8, 'Drâa-Tafilalet'),
(9, 'Souss-Massa'),
(10, 'Guelmim-Oued Noun'),
(11, 'Laâyoune-Sakia El Hamra'),
(12, 'Dakhla-Oued Ed Dahab');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'user'),
(2, 'organizer'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `sponsors`
--

CREATE TABLE `sponsors` (
  `sponsor_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `sponsor_name` varchar(25) DEFAULT NULL,
  `sponsor_logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_name`) VALUES
(43, 'ddsss'),
(48, 'dzdz'),
(45, 'dzzd'),
(51, 'new tag'),
(49, 'Tagname'),
(32, 'tegTest Post Man'),
(33, 'tegTest Post Man Again'),
(44, 'this is test form'),
(46, 'zddz'),
(37, 'zdzdzdzdz');

-- --------------------------------------------------------

--
-- Structure de la table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `promo_code_id` int(11) DEFAULT NULL,
  `QR_code` varchar(255) DEFAULT NULL,
  `bought_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','suspend') DEFAULT 'active',
  `role_id` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `fname`, `lname`, `email`, `password`, `status`, `role_id`, `photo`, `birthdate`, `bio`, `joined_at`) VALUES
(1, 'Declan Rivera', 'Hilary Stevens', 'bejubago@mailinator.com', '$2y$10$Ik7HRd8YVkBweFcmVD16Du.cvQ4PZKBpDxmDU4qw..NqMaHZ23YGm', 'active', NULL, NULL, '1981-06-30', 'Sed cum adipisci exe', '2025-02-09 13:54:32'),
(3, 'Declan Riverasds', 'Hilary Stedsdvens', 'bejubassgo@maiddlinator.com', '$2y$10$qncdy0wVzRrMGEmgfun8fey4TnTUbZPIJgCjPZGKGmCxSTRevfPiW', 'active', NULL, NULL, '1981-06-30', 'Sed cum adipisci exedsdsd', '2025-02-09 13:58:17'),
(5, 'Anika Levy', 'Lev Hebert', 'jaqem@mailinator.com', '$2y$10$kIt.aKYl9Pz37RE8H0W0cueB8nnG0lQp.Eqm1Y2InP6efbO1mcUk2', 'active', NULL, NULL, '1988-08-29', 'Nihil ut pariatur R', '2025-02-09 14:00:04'),
(6, '', '', '', '$2y$10$OaHgOVDR7VkwSsYe.Yh3aeYwZ9tCtgHjJOP4JfeRdvOqSPNUetbdW', 'active', NULL, NULL, '0000-00-00', '', '2025-02-09 15:09:17'),
(19, 'Branden Shepard', 'Fay Clark', 'jawadboulmal@gmail.com', '$2y$10$Zc9/d/wDK3uHdLQXNQ4RDOCJa7pPaq66Qq2oGAUvfgCDTbsayV8oO', 'active', NULL, NULL, '0000-00-00', '', '2025-02-09 15:41:02'),
(20, 'Felicia Guy', 'Dahlia Butler', 'dyjaqup@mailinator.com', '$2y$10$LSER7WGlVRVcjKgzh2qW6.EbGiOtkV0FC17OmWtMybJoGWgv4xor2', 'active', NULL, NULL, '0000-00-00', '', '2025-02-09 16:06:19'),
(21, 'Bryar Stein', 'Lareina Reid', 'tylawajire@gmail.ccococococo', '$2y$10$tYwG.Y4.Iyw5VVZR5hCkI.RTGAgnysoa.oOGzrEPe2zWNbwQNEgQW', 'active', NULL, NULL, '0000-00-00', '', '2025-02-09 16:06:49'),
(22, 'Hall Foreman', 'Berk Schwartz', 'lymakum@mailinator.comcomcomcomcomcomcomcomcomcomcomcom', '$2y$10$HwKjAgwKm1MFfcLd4NBtAeI2U/odIJTH1BJPbX2aPwijgaD/Qn5oe', 'active', NULL, NULL, '0000-00-00', '', '2025-02-09 16:07:54'),
(24, 'Brenda Hopper', 'Kaitlin Wolfe', 'vecu@mailinator.com', '$2y$10$tEeL5VYOgB5UUPgW.YynVu6AqhPynyEWCZyYKiV1gmPNsEclePTTS', 'active', NULL, NULL, '0000-00-00', '', '2025-02-09 16:10:10'),
(25, 'Hakeem Keller', 'Cooper Lee', 'gegucysiza@mailinator.comddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', '$2y$10$2Os80YV3lzk0FPglezMbMOiL7gXirpmcecTEquz4cFNszYOMDk0Ge', 'active', NULL, NULL, '0000-00-00', '', '2025-02-09 16:10:24'),
(27, 'Charity Miles', 'Molly Young', 'zuqazyb@mailinator.com', '$2y$10$5LpOl.9PrCywOE9qkdfUHusjZ43mwza5HaBMIRlYeIIL640D5TR3u', 'active', NULL, NULL, '0000-00-00', '', '2025-02-09 16:12:31'),
(28, 'Fallon Simpson', 'Hanna Lamb', 'tapyh@mailinator.comcomcommcomcomcom', '$2y$10$NOoKaHc2TepiJdxJJ5Y.luwDexWqAAJfJs6YuPYJh0tLK4eybYxaK', 'active', NULL, NULL, '0000-00-00', '', '2025-02-09 16:12:52'),
(29, 'Sydnee Weaver', 'Brody Harrell', 'samafe@mailinator.com', '$2y$10$lsAI3To071pYTdltEnUwPOxp5kJ6wi1e/3CGEU2STEcox5dEGg.ay', 'active', NULL, NULL, '0000-00-00', '', '2025-02-09 16:16:16'),
(30, 'Indira Holmes', 'Colton Frost', 'zisa@mailinator.com', '$2y$10$8YGamwzIPlOxXH4scfIHBOc8YsMo/CsTyL5FpG/oaApddZ/.wOq2G', 'active', 1, NULL, '0000-00-00', '', '2025-02-09 16:25:30'),
(32, 'Keefe Hardy', 'Asher Savage', 'bimiba@mailinator.com', '$2y$10$DGVSR8ycYSE7NVVdgjiaTeUyeBknrsX0UHwFMiMzWfrxQXL8GGMCW', 'active', 1, NULL, '0000-00-00', '', '2025-02-09 16:26:08'),
(33, 'Quamar James', 'Akeem Osborn', 'mydi@mailinator.com', '$2y$10$YKDjW.J2x523af5IgFSgKuRribECIAV/XYjez3QZa0pvI9RolHfd2', 'active', 1, NULL, '1971-05-11', 'Praesentium id dolor', '2025-02-09 16:31:01'),
(36, 'Uriah Chambers', 'Roary Michael', 'dawucexy@mailinator.com', '$2y$10$uDVL4Uatd3slP.kIW0W/YOSeK/EsTXexGxOGTFR0BUkNBWN4IPnqm', 'active', 1, NULL, '2006-04-25', 'Ratione nulla conseq', '2025-02-09 16:46:04'),
(38, 'Aileen Estes', 'Walter Oconnor', 'xukyt@mailinator.com', '$2y$10$kYRe5Xj3gRBsHhSQaXMBQ.5vs/b9uPoyDEx4p1vwWVJzOnkFWE0Dm', 'active', 1, NULL, '1981-12-04', 'Occaecat corporis du', '2025-02-09 18:34:44'),
(40, 'Tanisha Mayer', 'Liberty Serrano', 'jygosuxog@mailinator.com', '$2y$10$WPerAJGwr1oEEJ/4itIyruaTYhFOOlLM/4kqirn9jAP/Zv14VBKEK', 'active', 1, NULL, '2022-08-01', 'Et debitis dolor bla', '2025-02-09 18:36:36'),
(42, 'Merrill Tate', 'Hayden Hicks', 'sisamuse@mailinator.com', '$2y$10$VEmPNUr5t18HtTiSCKTgUOyRazctLqN4k/s4FyqkGkX/xHIXIzcD2', 'active', 1, NULL, '1992-04-01', 'Quasi voluptas paria', '2025-02-09 18:37:18'),
(43, 'Alisa Park', 'David Conway', 'mosylif@mailinator.com', '$2y$10$u8mfS36D4lSGlMwdQy2a3Ol/xpZmv5o1aHCjoxb1u0pyXAoJHkgnO', 'active', 1, NULL, '1983-01-06', 'Fugiat accusantium ', '2025-02-09 18:37:28'),
(45, 'Alika Frye', 'Lev Mclaughlin', 'conek@mailinator.com', '$2y$10$36OReq9nkp3FLNLdRHOnxe8lhOnykZ7UZL3Qmy9HFbNrKpF8a914e', 'active', 1, NULL, '1980-10-13', 'Numquam vel temporib', '2025-02-09 18:37:43'),
(46, 'Serena Camacho', 'Alyssa Nelson', 'xupybilyre@mailinator.com', '$2y$10$qtL5VTjWTWn4cMmHOfEHqOzqAVTrMuAhfHHdPSi0GSc8wqDU6K9GC', 'active', 1, NULL, '2005-10-29', 'Reprehenderit dolor', '2025-02-09 18:38:22'),
(47, 'Violet Love', 'Caldwell Neal', 'lubikehocy@mailinator.com', '$2y$10$.Yvnx6g48OaGRdHvLjEpEuwUyxdbK/Ek7IfzcF.1lznQoMDMv7G0W', 'active', 1, NULL, '1991-08-25', 'Placeat eos dolore', '2025-02-09 18:39:05'),
(48, 'Addison Trevino', 'Alfreda Thompson', 'wakynel@mailinator.com', '$2y$10$ERbV9xwFvmnmuUfHGxWvAO06k6.j5zakNHpB8EoyGk198BrsJYivi', 'active', 1, NULL, '2008-11-10', 'Harum illo error et ', '2025-02-09 18:53:56'),
(49, 'Maite Huffman', 'Barry Golden', 'hybaq@mailinator.com', '$2y$10$SB5yZf81eGOqLob.n1h/AuOsSgR2lHwaz1/LU1gytT8jmd36QpVZ6', 'active', 1, NULL, '2006-04-30', 'Quo excepteur commod', '2025-02-09 18:56:40'),
(50, 'Marny Bates', 'Veronica Larson', 'tybinabavy@mailinator.com', '$2y$10$1w8xzxTEsHjYkaRi3oKci.T2ZAP1CDh.sfIqsQPJwWq962Ej/OUqy', 'active', 1, NULL, '2024-12-14', 'Commodi do ipsum at', '2025-02-09 19:11:15'),
(51, 'Hammett Moss', 'Jamalia Wiley', 'pebozumo@mailinator.com', '$2y$10$PTgk5SGckxA3binn1bXDMOImRyIrlHoROxmRHWETsr.wMR2HNZ.D2', 'active', 1, NULL, '1973-04-02', 'Magna eos quis dolor', '2025-02-10 00:48:39'),
(52, 'Ignacia', 'Mckenzie', 'mygoj@mailinator.com', '$2y$10$4wFufpIHUEy.xf5XY75aq.F6B1Uq1LsxQdW0UFzi012DhfoHbrYey', 'active', 1, NULL, '1986-03-26', 'Officia occaecat exc', '2025-02-10 14:57:19'),
(53, 'Abel', 'Crane', 'cytinivi@mailinator.com', '$2y$10$aZDUNF1RdXF4HHayeXu6Feh5jxjxcxDVukpsmdVAUE2YQipwJqJRy', 'active', 1, NULL, '1998-08-29', 'Commodi nisi sed asp', '2025-02-10 14:57:35'),
(54, 'Fatima', 'Peterson', 'biref@mailinator.com', '$2y$10$BdQUXWHf7GFI8ctWXHClDObeqgbRBGSQ9V4MBVD/eWMdhXvK3yPIS', 'active', 1, NULL, '2004-11-20', 'Lorem qui atque dolo', '2025-02-10 14:58:31'),
(55, 'Price Walters', 'Clayton Leon', 'qolihimyh@mailinator.com', '$2y$10$tFsoXeBR7x3uaLJ4yP2/lul1i8ozghaWpjN0i0X7xa4ND6CJScYO2', 'active', 3, NULL, '1993-05-03', 'Consequat Rerum rep', '2025-02-10 20:11:51'),
(59, 'Callie Barrera', 'Dante Fox', 'xenywyb@mailinator.com', '$2y$10$zkXo75bHM7T4HvF6pmZYnue4a03KFrrEa9WpdR7Pyc4f05itKMpxK', 'active', 1, NULL, '2002-02-17', 'Soluta laborum expli', '2025-02-10 22:52:47'),
(61, 'Hayes Kennedy', 'Josiah Harrell', 'thisisatestt@mailinator.com', '$2y$10$tsDoZ.Kfu2ZfpSy9MKNDyOunsbWjUhfKwevffbiqvQj4uqJx9JXzy', 'active', 1, NULL, '2009-09-29', 'Quo officia est labo', '2025-02-10 23:19:31'),
(62, 'Nicholas Jones', 'Aidan Hinton', 'testAgain@mailinator.com', '$2y$10$l6wm2VVXpWdmLSq5BttfBOKpDtVgc/b.f2EWf/3DOfIyuGkolixUu', 'active', 1, NULL, '2022-08-20', 'Dolor tenetur ullamc', '2025-02-10 23:21:34'),
(69, 'Quamar Alexander', 'Martha Gamble', 'boulmal.jawad@gmail.com', '$2y$10$fUOR2.2XBUlW9IJAG5PgfukqafSpdUGIl5hENE0QoooctwcWwwTbC', 'active', 1, NULL, '1985-07-15', 'Proident reprehende', '2025-02-11 00:34:11'),
(72, 'Skay37', 'Hello', 'boulmal.jawad@student.youcode.ma', '$2y$10$RYGMu5At7I560rHAopwGk.eWFZRTo.CO6ATMeEdxLWTqbnnZdjgOa', 'active', 1, NULL, '1995-06-12', 'Voluptas quam porro ', '2025-02-11 00:47:52'),
(75, 'Kylan Fleming', 'Linda Macdonald', 'vmbox37@gmail.com', '$2y$10$EYPL8C/fxrQjJ8yOiLvAD.MH9PXT3AIwF0h3AjihhH.5bwd.rfho6', 'active', 1, NULL, '1996-03-23', 'Exercitation qui ali', '2025-02-11 01:11:51'),
(76, 'Thor Hernandez', 'Kim Espinoza', 'bypamasago@mailinator.com', '$2y$10$e90FmS36Lo/2OiGvmInmhOP8NL4VuDq7NrTmo7WgHXra0VRcBjrCe', 'active', 1, NULL, '1992-05-06', 'Quasi temporibus vol', '2025-02-11 09:29:17'),
(81, 'William Landry', 'Orlando Rutledge', 'tipoda@mailinator.com', '$2y$10$GMxj8BBjZwV47hx4es4gnOo4QUJsP.uvLJpIquvoUuSRTFg006wp6', 'active', 1, NULL, '1982-08-11', 'Nobis architecto eli', '2025-02-11 09:41:45'),
(82, 'BOULMAL', 'JAWAD', 'scenistick@gmail.com', '$2y$10$WZJzDjeVbPqG7vflrvHp7O1HThCHXwDetX6lA7hGLJeclBAXJz8ny', 'active', 1, NULL, '1993-07-18', 'Voluptas sint provi', '2025-02-11 09:42:45'),
(83, 'Blaine Holland', 'Jillian Irwin', 'ricaf@mailinator.com', '$2y$10$TBPwofChMQ3aVsBAFpzodusmED/Z13F6v11sxC5kPC5uCKwo4Gw9G', 'active', 1, NULL, '2013-02-19', 'Sunt qui ratione ver', '2025-02-11 10:40:52');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `id` int(11) NOT NULL,
  `ville` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `region` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`id`, `ville`, `region`) VALUES
(1, 'Aïn Harrouda', 6),
(2, 'Ben Yakhlef', 6),
(3, 'Bouskoura', 6),
(4, 'Casablanca', 6),
(5, 'Médiouna', 6),
(6, 'Mohammadia', 6),
(7, 'Tit Mellil', 6),
(8, 'Ben Yakhlef', 6),
(9, 'Bejaâd', 5),
(10, 'Ben Ahmed', 6),
(11, 'Benslimane', 6),
(12, 'Berrechid', 6),
(13, 'Boujniba', 5),
(14, 'Boulanouare', 5),
(15, 'Bouznika', 6),
(16, 'Deroua', 6),
(17, 'El Borouj', 6),
(18, 'El Gara', 6),
(19, 'Guisser', 6),
(20, 'Hattane', 5),
(21, 'Khouribga', 5),
(22, 'Loulad', 6),
(23, 'Oued Zem', 5),
(24, 'Oulad Abbou', 6),
(25, 'Oulad H\'Riz Sahel', 6),
(26, 'Oulad M\'rah', 6),
(27, 'Oulad Saïd', 6),
(28, 'Oulad Sidi Ben Daoud', 6),
(29, 'Ras El Aïn', 6),
(30, 'Settat', 6),
(31, 'Sidi Rahhal Chataï', 6),
(32, 'Soualem', 6),
(33, 'Azemmour', 6),
(34, 'Bir Jdid', 6),
(35, 'Bouguedra', 7),
(36, 'Echemmaia', 7),
(37, 'El Jadida', 6),
(38, 'Hrara', 7),
(39, 'Ighoud', 7),
(40, 'Jamâat Shaim', 7),
(41, 'Jorf Lasfar', 6),
(42, 'Khemis Zemamra', 6),
(43, 'Laaounate', 6),
(44, 'Moulay Abdallah', 6),
(45, 'Oualidia', 6),
(46, 'Oulad Amrane', 6),
(47, 'Oulad Frej', 6),
(48, 'Oulad Ghadbane', 6),
(49, 'Safi', 7),
(50, 'Sebt El Maârif', 6),
(51, 'Sebt Gzoula', 7),
(52, 'Sidi Ahmed', 7),
(53, 'Sidi Ali Ban Hamdouche', 6),
(54, 'Sidi Bennour', 6),
(55, 'Sidi Bouzid', 6),
(56, 'Sidi Smaïl', 6),
(57, 'Youssoufia', 7),
(58, 'Fès', 3),
(59, 'Aïn Cheggag', 3),
(60, 'Bhalil', 3),
(61, 'Boulemane', 3),
(62, 'El Menzel', 3),
(63, 'Guigou', 3),
(64, 'Imouzzer Kandar', 3),
(65, 'Imouzzer Marmoucha', 3),
(66, 'Missour', 3),
(67, 'Moulay Yaâcoub', 3),
(68, 'Ouled Tayeb', 3),
(69, 'Outat El Haj', 3),
(70, 'Ribate El Kheir', 3),
(71, 'Séfrou', 3),
(72, 'Skhinate', 3),
(73, 'Tafajight', 3),
(74, 'Arbaoua', 4),
(75, 'Aïn Dorij', 1),
(76, 'Dar Gueddari', 4),
(77, 'Had Kourt', 4),
(78, 'Jorf El Melha', 4),
(79, 'Kénitra', 4),
(80, 'Khenichet', 4),
(81, 'Lalla Mimouna', 4),
(82, 'Mechra Bel Ksiri', 4),
(83, 'Mehdia', 4),
(84, 'Moulay Bousselham', 4),
(85, 'Sidi Allal Tazi', 4),
(86, 'Sidi Kacem', 4),
(87, 'Sidi Slimane', 4),
(88, 'Sidi Taibi', 4),
(89, 'Sidi Yahya El Gharb', 4),
(90, 'Souk El Arbaa', 4),
(91, 'Akka', 9),
(92, 'Assa', 10),
(93, 'Bouizakarne', 10),
(94, 'El Ouatia', 10),
(95, 'Es-Semara', 11),
(96, 'Fam El Hisn', 9),
(97, 'Foum Zguid', 9),
(98, 'Guelmim', 10),
(99, 'Taghjijt', 10),
(100, 'Tan-Tan', 10),
(101, 'Tata', 9),
(102, 'Zag', 10),
(103, 'Marrakech', 7),
(104, 'Ait Daoud', 7),
(115, 'Amizmiz', 7),
(116, 'Assahrij', 7),
(117, 'Aït Ourir', 7),
(118, 'Ben Guerir', 7),
(119, 'Chichaoua', 7),
(120, 'El Hanchane', 7),
(121, 'El Kelaâ des Sraghna', 7),
(122, 'Essaouira', 7),
(123, 'Fraïta', 7),
(124, 'Ghmate', 7),
(125, 'Ighounane', 8),
(126, 'Imintanoute', 7),
(127, 'Kattara', 7),
(128, 'Lalla Takerkoust', 7),
(129, 'Loudaya', 7),
(130, 'Lâattaouia', 7),
(131, 'Moulay Brahim', 7),
(132, 'Mzouda', 7),
(133, 'Ounagha', 7),
(134, 'Sid L\'Mokhtar', 7),
(135, 'Sid Zouin', 7),
(136, 'Sidi Abdallah Ghiat', 7),
(137, 'Sidi Bou Othmane', 7),
(138, 'Sidi Rahhal', 7),
(139, 'Skhour Rehamna', 7),
(140, 'Smimou', 7),
(141, 'Tafetachte', 7),
(142, 'Tahannaout', 7),
(143, 'Talmest', 7),
(144, 'Tamallalt', 7),
(145, 'Tamanar', 7),
(146, 'Tamansourt', 7),
(147, 'Tameslouht', 7),
(148, 'Tanalt', 9),
(149, 'Zeubelemok', 7),
(150, 'Meknès‎', 3),
(151, 'Khénifra', 5),
(152, 'Agourai', 3),
(153, 'Ain Taoujdate', 3),
(154, 'MyAliCherif', 8),
(155, 'Rissani', 8),
(156, 'Amalou Ighriben', 5),
(157, 'Aoufous', 8),
(158, 'Arfoud', 8),
(159, 'Azrou', 3),
(160, 'Aïn Jemaa', 3),
(161, 'Aïn Karma', 3),
(162, 'Aïn Leuh', 3),
(163, 'Aït Boubidmane', 3),
(164, 'Aït Ishaq', 5),
(165, 'Boudnib', 8),
(166, 'Boufakrane', 3),
(167, 'Boumia', 8),
(168, 'El Hajeb', 3),
(169, 'Elkbab', 5),
(170, 'Er-Rich', 5),
(171, 'Errachidia', 8),
(172, 'Gardmit', 8),
(173, 'Goulmima', 8),
(174, 'Gourrama', 8),
(175, 'Had Bouhssoussen', 5),
(176, 'Haj Kaddour', 3),
(177, 'Ifrane', 3),
(178, 'Itzer', 8),
(179, 'Jorf', 8),
(180, 'Kehf Nsour', 5),
(181, 'Kerrouchen', 5),
(182, 'M\'haya', 3),
(183, 'M\'rirt', 5),
(184, 'Midelt', 8),
(185, 'Moulay Ali Cherif', 8),
(186, 'Moulay Bouazza', 5),
(187, 'Moulay Idriss Zerhoun', 3),
(188, 'Moussaoua', 3),
(189, 'N\'Zalat Bni Amar', 3),
(190, 'Ouaoumana', 5),
(191, 'Oued Ifrane', 3),
(192, 'Sabaa Aiyoun', 3),
(193, 'Sebt Jahjouh', 3),
(194, 'Sidi Addi', 3),
(195, 'Tichoute', 8),
(196, 'Tighassaline', 5),
(197, 'Tighza', 5),
(198, 'Timahdite', 3),
(199, 'Tinejdad', 8),
(200, 'Tizguite', 3),
(201, 'Toulal', 3),
(202, 'Tounfite', 8),
(203, 'Zaouia d\'Ifrane', 3),
(204, 'Zaïda', 8),
(205, 'Ahfir', 2),
(206, 'Aklim', 2),
(207, 'Al Aroui', 2),
(208, 'Aïn Bni Mathar', 2),
(209, 'Aïn Erreggada', 2),
(210, 'Ben Taïeb', 2),
(211, 'Berkane', 2),
(212, 'Bni Ansar', 2),
(213, 'Bni Chiker', 2),
(214, 'Bni Drar', 2),
(215, 'Bni Tadjite', 2),
(216, 'Bouanane', 2),
(217, 'Bouarfa', 2),
(218, 'Bouhdila', 2),
(219, 'Dar El Kebdani', 2),
(220, 'Debdou', 2),
(221, 'Douar Kannine', 2),
(222, 'Driouch', 2),
(223, 'El Aïoun Sidi Mellouk', 2),
(224, 'Farkhana', 2),
(225, 'Figuig', 2),
(226, 'Ihddaden', 2),
(227, 'Jaâdar', 2),
(228, 'Jerada', 2),
(229, 'Kariat Arekmane', 2),
(230, 'Kassita', 2),
(231, 'Kerouna', 2),
(232, 'Laâtamna', 2),
(233, 'Madagh', 2),
(234, 'Midar', 2),
(235, 'Nador', 2),
(236, 'Naima', 2),
(237, 'Oued Heimer', 2),
(238, 'Oujda', 2),
(239, 'Ras El Ma', 2),
(240, 'Saïdia', 2),
(241, 'Selouane', 2),
(242, 'Sidi Boubker', 2),
(243, 'Sidi Slimane Echcharaa', 2),
(244, 'Talsint', 2),
(245, 'Taourirt', 2),
(246, 'Tendrara', 2),
(247, 'Tiztoutine', 2),
(248, 'Touima', 2),
(249, 'Touissit', 2),
(250, 'Zaïo', 2),
(251, 'Zeghanghane', 2),
(252, 'Rabat', 4),
(253, 'Salé', 4),
(254, 'Ain El Aouda', 4),
(255, 'Harhoura', 4),
(256, 'Khémisset', 4),
(257, 'Oulmès', 4),
(258, 'Rommani', 4),
(259, 'Sidi Allal El Bahraoui', 4),
(260, 'Sidi Bouknadel', 4),
(261, 'Skhirate', 4),
(262, 'Tamesna', 4),
(263, 'Témara', 4),
(264, 'Tiddas', 4),
(265, 'Tiflet', 4),
(266, 'Touarga', 4),
(267, 'Agadir', 9),
(268, 'Agdz', 8),
(269, 'Agni Izimmer', 9),
(270, 'Aït Melloul', 9),
(271, 'Alnif', 8),
(272, 'Anzi', 9),
(273, 'Aoulouz', 9),
(274, 'Aourir', 9),
(275, 'Arazane', 9),
(276, 'Aït Baha', 9),
(277, 'Aït Iaâza', 9),
(278, 'Aït Yalla', 8),
(279, 'Ben Sergao', 9),
(280, 'Biougra', 9),
(281, 'Boumalne-Dadès', 8),
(282, 'Dcheira El Jihadia', 9),
(283, 'Drargua', 9),
(284, 'El Guerdane', 9),
(285, 'Harte Lyamine', 8),
(286, 'Ida Ougnidif', 9),
(287, 'Ifri', 8),
(288, 'Igdamen', 9),
(289, 'Ighil n\'Oumgoun', 8),
(290, 'Imassine', 8),
(291, 'Inezgane', 9),
(292, 'Irherm', 9),
(293, 'Kelaat-M\'Gouna', 8),
(294, 'Lakhsas', 9),
(295, 'Lakhsass', 9),
(296, 'Lqliâa', 9),
(297, 'M\'semrir', 8),
(298, 'Massa (Maroc)', 9),
(299, 'Megousse', 9),
(300, 'Ouarzazate', 8),
(301, 'Oulad Berhil', 9),
(302, 'Oulad Teïma', 9),
(303, 'Sarghine', 8),
(304, 'Sidi Ifni', 10),
(305, 'Skoura', 8),
(306, 'Tabounte', 8),
(307, 'Tafraout', 9),
(308, 'Taghzout', 1),
(309, 'Tagzen', 9),
(310, 'Taliouine', 9),
(311, 'Tamegroute', 8),
(312, 'Tamraght', 9),
(313, 'Tanoumrite Nkob Zagora', 8),
(314, 'Taourirt ait zaghar', 8),
(315, 'Taroudannt', 9),
(316, 'Temsia', 9),
(317, 'Tifnit', 9),
(318, 'Tisgdal', 9),
(319, 'Tiznit', 9),
(320, 'Toundoute', 8),
(321, 'Zagora', 8),
(322, 'Afourar', 5),
(323, 'Aghbala', 5),
(324, 'Azilal', 5),
(325, 'Aït Majden', 5),
(326, 'Beni Ayat', 5),
(327, 'Béni Mellal', 5),
(328, 'Bin elouidane', 5),
(329, 'Bradia', 5),
(330, 'Bzou', 5),
(331, 'Dar Oulad Zidouh', 5),
(332, 'Demnate', 5),
(333, 'Dra\'a', 8),
(334, 'El Ksiba', 5),
(335, 'Foum Jamaa', 5),
(336, 'Fquih Ben Salah', 5),
(337, 'Kasba Tadla', 5),
(338, 'Ouaouizeght', 5),
(339, 'Oulad Ayad', 5),
(340, 'Oulad M\'Barek', 5),
(341, 'Oulad Yaich', 5),
(342, 'Sidi Jaber', 5),
(343, 'Souk Sebt Oulad Nemma', 5),
(344, 'Zaouïat Cheikh', 5),
(345, 'Tanger‎', 1),
(346, 'Tétouan‎', 1),
(347, 'Akchour', 1),
(348, 'Assilah', 1),
(349, 'Bab Berred', 1),
(350, 'Bab Taza', 1),
(351, 'Brikcha', 1),
(352, 'Chefchaouen', 1),
(353, 'Dar Bni Karrich', 1),
(354, 'Dar Chaoui', 1),
(355, 'Fnideq', 1),
(356, 'Gueznaia', 1),
(357, 'Jebha', 1),
(358, 'Karia', 3),
(359, 'Khémis Sahel', 1),
(360, 'Ksar El Kébir', 1),
(361, 'Larache', 1),
(362, 'M\'diq', 1),
(363, 'Martil', 1),
(364, 'Moqrisset', 1),
(365, 'Oued Laou', 1),
(366, 'Oued Rmel', 1),
(367, 'Ouazzane', 1),
(368, 'Point Cires', 1),
(369, 'Sidi Lyamani', 1),
(370, 'Sidi Mohamed ben Abdallah el-Raisuni', 1),
(371, 'Zinat', 1),
(372, 'Ajdir‎', 1),
(373, 'Aknoul‎', 3),
(374, 'Al Hoceïma‎', 1),
(375, 'Aït Hichem‎', 1),
(376, 'Bni Bouayach‎', 1),
(377, 'Bni Hadifa‎', 1),
(378, 'Ghafsai‎', 3),
(379, 'Guercif‎', 2),
(380, 'Imzouren‎', 1),
(381, 'Inahnahen‎', 1),
(382, 'Issaguen (Ketama)‎', 1),
(383, 'Karia (El Jadida)‎', 6),
(384, 'Karia Ba Mohamed‎', 3),
(385, 'Oued Amlil‎', 3),
(386, 'Oulad Zbair‎', 3),
(387, 'Tahla‎', 3),
(388, 'Tala Tazegwaght‎', 1),
(389, 'Tamassint‎', 1),
(390, 'Taounate‎', 3),
(391, 'Targuist‎', 1),
(392, 'Taza‎', 3),
(393, 'Taïnaste‎', 3),
(394, 'Thar Es-Souk‎', 3),
(395, 'Tissa‎', 3),
(396, 'Tizi Ouasli‎', 3),
(397, 'Laayoune‎', 11),
(398, 'El Marsa‎', 11),
(399, 'Tarfaya‎', 11),
(400, 'Boujdour‎', 11),
(401, 'Awsard', 12),
(402, 'Oued-Eddahab', 12),
(403, 'Stehat', 1),
(404, 'Aït Attab', 5);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categorie_id`),
  ADD UNIQUE KEY `categorie_name` (`categorie_name`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `event_creator` (`event_creator`),
  ADD KEY `event_category` (`event_category`),
  ADD KEY `promo_code` (`promo_code`);

--
-- Index pour la table `event_tags`
--
ALTER TABLE `event_tags`
  ADD PRIMARY KEY (`event_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Index pour la table `promo_codes`
--
ALTER TABLE `promo_codes`
  ADD PRIMARY KEY (`code_id`);

--
-- Index pour la table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Index pour la table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`sponsor_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tag_name` (`tag_name`);

--
-- Index pour la table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `promo_code_id` (`promo_code_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Index pour la table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`id`),
  ADD KEY `region` (`region`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `categorie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `promo_codes`
--
ALTER TABLE `promo_codes`
  MODIFY `code_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT pour la table `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `sponsor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT pour la table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=405;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`event_creator`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`event_category`) REFERENCES `categories` (`categorie_id`),
  ADD CONSTRAINT `events_ibfk_3` FOREIGN KEY (`promo_code`) REFERENCES `promo_codes` (`code_id`);

--
-- Contraintes pour la table `event_tags`
--
ALTER TABLE `event_tags`
  ADD CONSTRAINT `event_tags_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_tags_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sponsors`
--
ALTER TABLE `sponsors`
  ADD CONSTRAINT `sponsors_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);

--
-- Contraintes pour la table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`promo_code_id`) REFERENCES `promo_codes` (`code_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Contraintes pour la table `ville`
--
ALTER TABLE `ville`
  ADD CONSTRAINT `ville_ibfk_1` FOREIGN KEY (`region`) REFERENCES `region` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
