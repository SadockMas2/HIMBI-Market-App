-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 21 août 2025 à 12:34
-- Version du serveur : 8.3.0
-- Version de PHP : 8.1.2-1ubuntu2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `himbi_laravel022`
--

-- --------------------------------------------------------

--
-- Structure de la table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `id` bigint UNSIGNED NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_status` enum('non_payé','payé') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'non_payé',
  `table_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id`, `phone`, `name`, `guest`, `date`, `time`, `created_at`, `updated_at`, `payment_status`, `table_id`) VALUES
(4, '0996644356', 'Aaron LUKALU', '3', '2025-06-20', '14:30', '2025-06-19 19:46:21', '2025-07-02 08:18:54', 'payé', 1),
(6, '0996644356', 'Aaron LUKALU', '4', '2025-06-27', '08:00', '2025-06-21 00:01:17', '2025-07-02 13:23:18', 'payé', 1),
(8, '+243 56 78 43 432', 'David Bolamu', '3', '2025-07-03', '10:00', '2025-07-02 04:59:01', '2025-07-02 17:13:36', 'payé', 1),
(11, '+243 56 78 43 432', 'Aaron LUKALU', '3', '2025-07-25', '13:00', '2025-07-24 09:01:33', '2025-07-30 11:44:26', 'payé', 1),
(12, '0974323786', 'Christian', '6', '2025-08-13', '12:30', '2025-08-04 11:51:38', '2025-08-04 11:51:38', 'non_payé', 3),
(13, '+243 56 78 43 432', 'Assan CO', '5', '2025-08-29', '01:00', '2025-08-20 10:24:22', '2025-08-20 10:24:22', 'non_payé', 4);

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('himbi_market_cache_0481653e729be2d4cd447d1ddea7e225', 'i:1;', 1755771051),
('himbi_market_cache_0481653e729be2d4cd447d1ddea7e225:timer', 'i:1755771048;', 1755771049),
('himbi_market_cache_57f251433e3eff3d8b1050492783fc2b', 'i:1;', 1754559418),
('himbi_market_cache_57f251433e3eff3d8b1050492783fc2b:timer', 'i:1754559415;', 1754559416),
('himbi_market_cache_69db285a07b833947ce61db96526faaa', 'i:1;', 1755770923),
('himbi_market_cache_69db285a07b833947ce61db96526faaa:timer', 'i:1755770921;', 1755770922),
('himbi_market_cache_86ab917221f04520ab6f55d6f11b741a', 'i:1;', 1755701118),
('himbi_market_cache_86ab917221f04520ab6f55d6f11b741a:timer', 'i:1755701115;', 1755701116),
('himbi_market_cache_aa10043bdd5f944580bdb601778abd53', 'i:1;', 1754318357),
('himbi_market_cache_aa10043bdd5f944580bdb601778abd53:timer', 'i:1754318355;', 1754318356),
('himbi_market_cache_b94b31a256edb4309664571f818840ae', 'i:1;', 1755685449),
('himbi_market_cache_b94b31a256edb4309664571f818840ae:timer', 'i:1755685445;', 1755685447),
('himbi_market_cache_c525a5357e97fef8d3db25841c86da1a', 'i:1;', 1755770400),
('himbi_market_cache_c525a5357e97fef8d3db25841c86da1a:timer', 'i:1755770398;', 1755770399),
('laravel_cache_2d6b9e79796f614a52d4f4e3b2b754f3', 'i:1;', 1753325256),
('laravel_cache_2d6b9e79796f614a52d4f4e3b2b754f3:timer', 'i:1753325255;', 1753325255),
('laravel_cache_40e1ab1c887f94555b49fba43b197664', 'i:1;', 1755507866),
('laravel_cache_40e1ab1c887f94555b49fba43b197664:timer', 'i:1755507864;', 1755507865),
('laravel_cache_9187e66d21582410861966a92e999fb5', 'i:2;', 1754456466),
('laravel_cache_9187e66d21582410861966a92e999fb5:timer', 'i:1754456465;', 1754456465),
('laravel_cache_christian@gmail.com|::1', 'i:1;', 1754469835),
('laravel_cache_christian@gmail.com|::1:timer', 'i:1754469834;', 1754469834),
('laravel_cache_d0d214021f6120b090a8d1694b8d5b3a', 'i:1;', 1754469831),
('laravel_cache_d0d214021f6120b090a8d1694b8d5b3a:timer', 'i:1754469828;', 1754469828),
('laravel_cache_eef95f658febcee12b41ea8ec1bace29', 'i:1;', 1755714620),
('laravel_cache_eef95f658febcee12b41ea8ec1bace29:timer', 'i:1755714617;', 1755714619),
('laravel_cache_f583685cd141626ee606760971690765', 'i:1;', 1755508419),
('laravel_cache_f583685cd141626ee606760971690765:timer', 'i:1755508417;', 1755508418);

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `food_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `carts`
--

INSERT INTO `carts` (`id`, `food_id`, `title`, `details`, `quantity`, `image`, `price`, `userid`, `created_at`, `updated_at`) VALUES
(113, 2, 'Shawarma', 'Au poulet', '2', '1749672076.webp', '20', '13', '2025-08-07 09:47:00', '2025-08-07 09:47:31'),
(114, 17, 'Amstel', 'Boisson', '2', '1752076703.JPG', '4', '13', '2025-08-07 09:47:02', '2025-08-07 09:47:33'),
(115, 7, 'frites de banane', 'bananes', '3', '1752076167.JPG', '15', '11', '2025-08-18 08:32:57', '2025-08-18 08:32:57'),
(116, 9, 'Cuisse de poulet', 'poulet', '2', '1752076290.JPG', '10', '11', '2025-08-18 08:32:58', '2025-08-18 08:32:58'),
(117, 18, 'Beaufort', 'Boisson', '6', '1752076736.JPG', '12', '11', '2025-08-18 08:32:59', '2025-08-18 08:41:40'),
(118, 3, 'Frites Ketchup', 'Au ketchup', '1', '1749672121.webp', '15', '11', '2025-08-18 08:41:39', '2025-08-18 08:41:39');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `food`
--

CREATE TABLE `food` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `food`
--

INSERT INTO `food` (`id`, `title`, `detail`, `price`, `image`, `created_at`, `updated_at`, `stock`) VALUES
(1, 'Foufou', 'Au poulet', 6.00, '1749672036.webp', '2025-06-11 18:00:36', '2025-08-21 10:08:45', 3),
(2, 'Shawarma', 'Au poulet', 10.00, '1749672076.webp', '2025-06-11 18:01:16', '2025-08-21 10:08:48', 15),
(3, 'Frites Ketchup', 'Au ketchup', 15.00, '1749672121.webp', '2025-06-11 18:02:01', '2025-08-20 05:49:58', 13),
(4, 'Riz', 'Au haricots', 2.00, '1749672142.webp', '2025-06-11 18:02:22', '2025-07-30 10:32:51', 6),
(5, 'Sambussa', 'A la viande hachée', 7.00, '1749672183.webp', '2025-06-11 18:03:03', '2025-07-24 12:55:19', 9),
(6, 'Riz', 'Au poulet', 8.00, '1749672234.webp', '2025-06-11 18:03:54', '2025-06-21 00:27:58', 6),
(7, 'frites de banane', 'bananes', 5.00, '1752076167.JPG', '2025-07-09 15:49:27', '2025-08-20 08:01:22', 3),
(8, 'Brochettes', 'au boeuf', 2.00, '1752076233.JPG', '2025-07-09 15:50:33', '2025-08-06 06:08:11', -5),
(9, 'Cuisse de poulet', 'poulet', 5.00, '1752076290.JPG', '2025-07-09 15:51:30', '2025-08-04 13:31:52', -2),
(10, 'Viande grillée', 'porc', 4.50, '1752076344.JPG', '2025-07-09 15:52:24', '2025-07-24 12:52:01', -1),
(11, 'Shawarma', 'Top qualité', 3.50, '1752076417.PNG', '2025-07-09 15:53:37', '2025-07-09 15:53:37', 0),
(12, 'Pizza', 'Au fromages', 15.00, '1752076457.JPG', '2025-07-09 15:54:17', '2025-07-09 15:54:17', 0),
(13, 'Poisson grillé', 'Accompagné des frites', 10.00, '1752076517.JPG', '2025-07-09 15:55:17', '2025-07-09 15:55:17', 0),
(14, 'Porc grillé', 'Porc', 5.00, '1752076553.JPG', '2025-07-09 15:55:54', '2025-07-09 15:55:54', 0),
(15, 'Poulet grillé', 'Seul', 10.00, '1752076591.JPG', '2025-07-09 15:56:31', '2025-07-23 11:35:11', -2),
(16, 'Saucisse grillée', 'seule', 1.00, '1752076655.JPG', '2025-07-09 15:57:35', '2025-07-24 12:52:03', -4),
(17, 'Amstel', 'Boisson', 2.00, '1752076703.JPG', '2025-07-09 15:58:23', '2025-08-21 10:08:51', 9),
(18, 'Beaufort', 'Boisson', 2.00, '1752076736.JPG', '2025-07-09 15:58:56', '2025-08-20 14:37:08', -1),
(19, 'Coca cola', 'Boisson', 2.00, '1752076765.JPG', '2025-07-09 15:59:25', '2025-07-30 10:32:53', -9),
(20, 'Fanta Orange', 'Boisson', 2.00, '1752076803.JPG', '2025-07-09 16:00:03', '2025-08-04 11:54:09', -2),
(21, 'Fanta Sprit', 'Boisson', 2.00, '1752076845.JPG', '2025-07-09 16:00:45', '2025-07-30 10:41:19', -1),
(22, 'Heineken', 'Boisson', 3.00, '1752076879.JPG', '2025-07-09 16:01:19', '2025-08-06 08:58:12', -5),
(23, 'Primus GF', 'Boisson', 3.00, '1752076919.JPEG', '2025-07-09 16:01:59', '2025-08-20 08:00:05', 24),
(24, 'RedBul', 'Boisson', 3.00, '1752076954.JPG', '2025-07-09 16:02:34', '2025-07-24 12:55:28', -1),
(25, 'Savana', 'Boisson', 3.00, '1752076986.JPG', '2025-07-09 16:03:06', '2025-08-20 02:56:08', 0);

-- --------------------------------------------------------

--
-- Structure de la table `food_ingredients`
--

CREATE TABLE `food_ingredients` (
  `id` bigint UNSIGNED NOT NULL,
  `food_id` bigint UNSIGNED NOT NULL,
  `ingredient_id` bigint UNSIGNED NOT NULL,
  `quantity_required` decimal(8,2) NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `food_ingredients`
--

INSERT INTO `food_ingredients` (`id`, `food_id`, `ingredient_id`, `quantity_required`, `unit`, `created_at`, `updated_at`, `quantity`) VALUES
(1, 1, 1, 20.00, 'g', '2025-08-20 06:30:45', '2025-08-20 06:30:49', 1),
(3, 1, 4, 12.00, 'g', '2025-08-20 06:30:45', '2025-08-20 06:30:50', 1),
(4, 1, 6, 50.00, 'ml', '2025-08-20 06:30:46', '2025-08-20 06:30:50', 1),
(5, 1, 7, 3.00, 'g', '2025-08-20 06:30:47', '2025-08-20 06:30:52', 1),
(6, 1, 8, 1.00, 'ml', '2025-08-20 06:30:47', '2025-08-20 06:30:53', 1),
(7, 3, 4, 1.00, 'g', '2025-08-20 04:54:45', '2025-08-20 04:54:45', 1),
(8, 3, 6, 20.00, 'ml', '2025-08-20 04:54:46', '2025-08-20 04:54:46', 1),
(9, 3, 9, 1.00, 'kg', '2025-08-20 04:54:46', '2025-08-20 04:54:46', 1),
(10, 1, 10, 50.00, 'g', '2025-08-20 06:30:48', '2025-08-20 06:30:54', 1),
(11, 1, 24, 700.00, 'g', '2025-08-20 06:30:48', '2025-08-20 06:30:48', 1),
(12, 2, 4, 12.00, 'g', '2025-08-20 06:33:53', '2025-08-20 06:33:53', 1),
(13, 2, 6, 20.00, 'ml', '2025-08-20 06:33:54', '2025-08-20 06:33:54', 1),
(14, 2, 9, 500.00, 'g', '2025-08-20 06:33:54', '2025-08-20 06:33:54', 1),
(15, 2, 10, 45.00, 'kg', '2025-08-20 06:33:55', '2025-08-20 06:33:55', 1),
(16, 2, 15, 50.00, 'g', '2025-08-20 06:33:56', '2025-08-20 06:33:56', 1),
(17, 4, 4, 12.00, 'g', '2025-08-20 06:38:26', '2025-08-20 06:38:29', 1),
(18, 4, 6, 0.50, 'L', '2025-08-20 06:38:26', '2025-08-20 06:38:30', 1),
(19, 4, 13, 0.50, 'kg', '2025-08-20 06:38:27', '2025-08-20 06:38:30', 1),
(20, 4, 14, 0.30, 'kg', '2025-08-20 06:38:28', '2025-08-20 06:38:31', 1),
(21, 4, 1, 0.50, 'kg', '2025-08-20 06:38:25', '2025-08-20 06:38:25', 1),
(22, 5, 4, 12.00, 'g', '2025-08-20 06:41:34', '2025-08-20 06:41:34', 1),
(23, 5, 6, 0.50, 'L', '2025-08-20 06:41:35', '2025-08-20 06:41:35', 1),
(24, 5, 15, 10.00, 'g', '2025-08-20 06:41:36', '2025-08-20 06:41:36', 1),
(25, 5, 17, 0.40, 'kg', '2025-08-20 06:41:36', '2025-08-20 06:41:36', 1),
(26, 6, 1, 0.50, 'kg', '2025-08-20 06:44:13', '2025-08-20 06:44:13', 1),
(27, 6, 4, 12.00, 'g', '2025-08-20 06:44:13', '2025-08-20 06:44:13', 1),
(28, 6, 6, 0.25, 'L', '2025-08-20 06:44:14', '2025-08-20 06:44:14', 1),
(29, 6, 10, 0.25, 'kg', '2025-08-20 06:44:14', '2025-08-20 06:44:14', 1),
(30, 6, 13, 0.40, 'kg', '2025-08-20 06:44:15', '2025-08-20 06:44:15', 1),
(31, 7, 6, 0.50, 'L', '2025-08-20 06:45:38', '2025-08-20 06:45:38', 1),
(32, 7, 16, 0.50, 'kg', '2025-08-20 06:45:38', '2025-08-20 06:45:38', 1),
(33, 8, 4, 10.00, 'g', '2025-08-20 06:47:56', '2025-08-20 06:47:56', 1),
(34, 8, 6, 0.25, 'L', '2025-08-20 06:47:57', '2025-08-20 06:47:57', 1),
(35, 8, 8, 10.00, 'ml', '2025-08-20 06:47:57', '2025-08-20 06:47:57', 1),
(36, 8, 11, 10.00, 'g', '2025-08-20 06:47:58', '2025-08-20 06:47:58', 1),
(37, 8, 17, 1.00, 'kg', '2025-08-20 06:47:58', '2025-08-20 06:47:58', 1);

-- --------------------------------------------------------

--
-- Structure de la table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity_in_stock` decimal(8,2) NOT NULL DEFAULT '0.00',
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pcs',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `quantity_in_stock`, `unit`, `created_at`, `updated_at`) VALUES
(1, 'Tomates', 30.84, 'kg', '2025-08-18 18:13:23', '2025-08-20 07:48:03'),
(3, 'Sucre', 100.00, 'kg', '2025-08-19 04:19:54', '2025-08-19 06:26:29'),
(4, 'sel', 17.80, 'kg', '2025-08-19 04:29:46', '2025-08-20 14:42:27'),
(6, 'Huile', 9.39, 'L', '2025-08-19 04:42:18', '2025-08-20 14:42:28'),
(7, 'poivre', 7.98, 'kg', '2025-08-19 08:23:48', '2025-08-20 07:48:05'),
(8, 'Vinaigre', 493.00, 'ml', '2025-08-20 03:50:27', '2025-08-20 07:48:06'),
(9, 'Pomme de terre', 193.00, 'kg', '2025-08-20 04:49:47', '2025-08-20 14:42:29'),
(10, 'Poulet', 49.45, 'kg', '2025-08-20 06:19:48', '2025-08-20 14:42:29'),
(11, 'Ail', 5.00, 'kg', '2025-08-20 06:20:15', '2025-08-20 06:20:15'),
(12, 'Ketchup', 40.00, 'L', '2025-08-20 06:21:05', '2025-08-20 06:21:05'),
(13, 'Riz blanc', 100.00, 'kg', '2025-08-20 06:21:30', '2025-08-20 06:21:30'),
(14, 'Haricots noirs', 50.00, 'kg', '2025-08-20 06:21:51', '2025-08-20 06:21:51'),
(15, 'Pâte', 24.50, 'kg', '2025-08-20 06:22:26', '2025-08-20 14:42:30'),
(16, 'Bananes plantain', 20.00, 'kg', '2025-08-20 06:22:53', '2025-08-20 08:01:21'),
(17, 'Bœuf', 50.00, 'kg', '2025-08-20 06:23:25', '2025-08-20 06:23:25'),
(18, 'Cuisse de poulet', 20.00, 'kg', '2025-08-20 06:23:59', '2025-08-20 06:23:59'),
(19, 'Fromage râpé (mozzarella)', 25.00, 'kg', '2025-08-20 06:24:36', '2025-08-20 06:24:36'),
(20, 'Sauce tomate', 20.00, 'L', '2025-08-20 06:25:04', '2025-08-20 06:25:04'),
(21, 'Poisson entier', 20.00, 'pcs', '2025-08-20 06:25:38', '2025-08-20 06:25:38'),
(22, 'Filet de porc', 20.00, 'kg', '2025-08-20 06:26:11', '2025-08-20 06:26:11'),
(23, 'Saucisses', 25.00, 'kg', '2025-08-20 06:26:46', '2025-08-20 06:26:46'),
(24, 'Farine', 48.60, 'kg', '2025-08-20 06:29:19', '2025-08-20 07:48:07'),
(25, 'Eau', 100.00, 'L', '2025-08-20 06:29:43', '2025-08-20 06:29:43');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(10, '2025_06_06_154018_create_books_table', 2),
(13, '0001_01_01_000000_create_users_table', 3),
(14, '0001_01_01_000001_create_cache_table', 3),
(15, '0001_01_01_000002_create_jobs_table', 3),
(16, '2025_06_04_141222_add_two_factor_columns_to_users_table', 3),
(17, '2025_06_04_141340_create_personal_access_tokens_table', 3),
(18, '2025_06_04_221915_create_food_table', 3),
(19, '2025_06_05_235956_create_carts_table', 3),
(20, '2025_06_06_003818_add_userid_field_to_carts', 3),
(21, '2025_06_06_021514_create_orders_table', 3),
(22, '2025_06_06_194934_create_books_table', 3),
(23, '2025_06_11_192949_create_serveurs_table', 3),
(24, '2025_06_14_153156_create_bookings_table', 4),
(25, '2025_06_17_161107_add_name_to_books_table', 5),
(26, '2025_06_18_153241_create_tables_table', 6),
(27, '2025_06_18_155755_add_table_id_to_books_table', 7),
(28, '2025_06_19_223037_update_statut_enum_in_tables_table', 8),
(29, '2025_06_21_021458_add_stock_to_food_table', 9),
(30, '2025_06_21_033356_update_orders_table_add_foodid_quantity_integer', 10),
(31, '2025_06_21_043846_add_stock_insuffisant_to_orders_table', 11),
(32, '2025_06_27_095046_add_serveur_id_to_tables_table', 12),
(33, '2025_06_27_205242_create_server_orders_table', 13),
(34, '2025_06_28_155245_create_payments_table', 14),
(35, '2025_07_01_213608_add_payment_status_to_server_orders_table', 15),
(36, '2025_07_02_082555_add_payment_status_to_books_table', 16),
(37, '2025_07_03_011525_change_price_column_on_food_table', 17),
(38, '2025_07_08_062515_create_stocks_table', 18),
(39, '2025_07_13_100032_add_food_id_to_carts_table', 19),
(40, '2025_07_24_123914_alter_table_id_nullable_on_server_orders_table', 20),
(41, '2025_08_18_114329_create_ingredients_table', 21),
(42, '2025_08_18_114630_create_food_ingredients_table', 22),
(44, '2025_08_18_174029_add_quantity_to_food_ingredients_table', 23),
(45, '2025_08_19_091531_add_unit_to_food_ingredients_table', 24),
(46, '2025_08_20_065347_create_stock_history_table', 25),
(47, '2025_08_20_105133_add_table_id_to_orders_table', 26);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `table_id` bigint UNSIGNED DEFAULT NULL,
  `food_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int NOT NULL,
  `price` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'In\n            Progress',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stock_insuffisant` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `table_id`, `food_id`, `name`, `email`, `adress`, `phone`, `title`, `quantity`, `price`, `image`, `delivery_status`, `created_at`, `updated_at`, `stock_insuffisant`) VALUES
(78, NULL, 3, 'Christian', 'christian22@gmail.com', 'Goma, du lac 040', '0974323786', 'Frites Ketchup', 4, '15.00', NULL, 'Delivered', '2025-08-04 11:54:03', '2025-08-04 12:49:31', 0),
(79, NULL, 8, 'Christian', 'christian22@gmail.com', 'Goma, du lac 040', '0974323786', 'Brochettes', 1, '2.00', NULL, 'Delivered', '2025-08-04 11:54:05', '2025-08-04 12:49:33', 1),
(80, NULL, 20, 'Christian', 'christian22@gmail.com', 'Goma, du lac 040', '0974323786', 'Fanta Orange', 1, '2.00', NULL, 'Delivered', '2025-08-04 11:54:08', '2025-08-04 12:49:34', 1),
(81, NULL, 22, 'Christian', 'christian22@gmail.com', 'Goma, du lac 040', '0974323786', 'Heineken', 1, '3.00', NULL, 'Delivered', '2025-08-04 11:54:11', '2025-08-04 12:49:36', 1),
(82, NULL, 9, 'Christian', 'christian22@gmail.com', 'Goma, du lac 040', '0974323786', 'Cuisse de poulet', 2, '5.00', NULL, 'Delivered', '2025-08-04 13:31:51', '2025-08-04 14:00:12', 1),
(83, NULL, 25, 'Christian', 'christian22@gmail.com', 'Goma, du lac 040', '0974323786', 'Savana', 1, '3.00', NULL, 'Delivered', '2025-08-04 13:31:53', '2025-08-04 14:00:14', 1),
(84, NULL, 17, 'SAIDI MASUDI SADOCK', 'sadockmas@gmail.com', 'Goma Les volcans, 39', '0894455332', 'Amstel', 1, '2.00', NULL, 'Delivered', '2025-08-04 14:40:51', '2025-08-04 14:42:22', 1),
(85, NULL, 1, 'Christian', 'christian22@gmail.com', 'Murara 122', '0974323786', 'Foufou', 1, '6.00', NULL, 'Delivered', '2025-08-06 06:08:08', '2025-08-06 06:28:07', 1),
(86, NULL, 8, 'Christian', 'christian22@gmail.com', 'Murara 122', '0974323786', 'Brochettes', 3, '2.00', NULL, 'Delivered', '2025-08-06 06:08:11', '2025-08-06 06:28:09', 1),
(87, NULL, 22, 'john walker', 'johnwalk@gmail.com', 'himbi goma', '0975767780', 'Heineken', 2, '3.00', NULL, 'Delivered', '2025-08-06 08:58:11', '2025-08-18 09:11:22', 1),
(88, NULL, 1, 'Assan CO', 'assan@gmail.com', 'Goma, Murar 35', '+243 56 78 43 432', 'Foufou', 1, '6.00', NULL, 'Delivered', '2025-08-20 10:10:49', '2025-08-20 11:01:42', 0),
(89, NULL, 17, 'Assan CO', 'assan@gmail.com', 'Goma, Murar 35', '+243 56 78 43 432', 'Amstel', 2, '2.00', NULL, 'Delivered', '2025-08-20 10:10:51', '2025-08-20 11:01:44', 0),
(90, NULL, 1, 'Aaron LUKALU', 'aaronluk@gmail.com', 'Kinshasa , du fleuve 33', '0998765423', 'Foufou', 2, '6.00', NULL, 'Delivered', '2025-08-20 14:37:05', '2025-08-20 14:46:04', 0),
(91, NULL, 18, 'Aaron LUKALU', 'aaronluk@gmail.com', 'Kinshasa , du fleuve 33', '0998765423', 'Beaufort', 1, '2.00', NULL, 'Delivered', '2025-08-20 14:37:07', '2025-08-20 14:46:06', 1),
(92, NULL, 1, 'Josué', 'josue23@gmail.com', NULL, NULL, 'Foufou', 1, '6.00', NULL, 'livré', '2025-08-21 09:57:16', '2025-08-21 10:00:23', 0),
(93, NULL, 17, 'Josué', 'josue23@gmail.com', NULL, NULL, 'Amstel', 4, '2.00', NULL, 'livré', '2025-08-21 09:57:18', '2025-08-21 10:00:23', 0),
(94, NULL, 1, 'Josué', 'josue23@gmail.com', NULL, NULL, 'Foufou', 1, '6.00', NULL, 'livré', '2025-08-21 09:58:01', '2025-08-21 10:00:23', 0),
(95, NULL, 17, 'Josué', 'josue23@gmail.com', NULL, NULL, 'Amstel', 4, '2.00', NULL, 'livré', '2025-08-21 09:58:02', '2025-08-21 10:00:23', 0),
(96, NULL, 1, 'Aaron LUKALU', 'aaronluk@gmail.com', 'Kinshasa , du fleuve 33', '0998765423', 'Foufou', 1, '6.00', NULL, 'Delivered', '2025-08-21 10:08:44', '2025-08-21 10:10:55', 0),
(97, NULL, 2, 'Aaron LUKALU', 'aaronluk@gmail.com', 'Kinshasa , du fleuve 33', '0998765423', 'Shawarma', 1, '10.00', NULL, 'Delivered', '2025-08-21 10:08:47', '2025-08-21 10:10:57', 0),
(98, NULL, 17, 'Aaron LUKALU', 'aaronluk@gmail.com', 'Kinshasa , du fleuve 33', '0998765423', 'Amstel', 1, '2.00', NULL, 'Delivered', '2025-08-21 10:08:50', '2025-08-21 10:10:59', 0);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `serveur_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('en_attente','payé','annulé') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_attente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `server_orders`
--

CREATE TABLE `server_orders` (
  `id` bigint UNSIGNED NOT NULL,
  `serveur_id` bigint UNSIGNED NOT NULL,
  `table_id` bigint UNSIGNED DEFAULT NULL,
  `food_id` bigint UNSIGNED NOT NULL,
  `quantite` int NOT NULL,
  `statut` enum('en_attente','servie','annulée') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_attente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_status` enum('non_payé','payé') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'non_payé'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `server_orders`
--

INSERT INTO `server_orders` (`id`, `serveur_id`, `table_id`, `food_id`, `quantite`, `statut`, `created_at`, `updated_at`, `payment_status`) VALUES
(1, 4, 4, 3, 2, 'en_attente', '2025-06-27 19:15:53', '2025-07-02 23:33:12', 'payé'),
(2, 4, 5, 2, 1, 'en_attente', '2025-06-27 19:20:08', '2025-07-03 02:19:42', 'payé'),
(3, 4, 5, 2, 1, 'en_attente', '2025-06-27 19:23:53', '2025-07-03 02:19:42', 'payé'),
(4, 4, 5, 2, 1, 'en_attente', '2025-06-27 19:26:32', '2025-07-03 02:19:42', 'payé'),
(5, 4, 7, 5, 3, 'en_attente', '2025-06-27 19:26:59', '2025-08-04 14:01:46', 'payé'),
(6, 4, 4, 2, 2, 'en_attente', '2025-06-27 20:03:29', '2025-07-02 23:33:12', 'payé'),
(7, 4, 4, 1, 2, 'en_attente', '2025-06-27 20:10:55', '2025-07-02 23:33:12', 'payé'),
(8, 4, 2, 5, 2, 'en_attente', '2025-07-02 16:18:03', '2025-07-02 16:19:27', 'payé'),
(9, 9, 4, 6, 4, 'en_attente', '2025-07-02 22:29:15', '2025-07-02 23:33:12', 'payé'),
(10, 9, 3, 3, 1, 'en_attente', '2025-07-02 22:30:34', '2025-07-02 23:21:41', 'payé'),
(11, 9, 3, 6, 2, 'en_attente', '2025-07-02 22:31:36', '2025-07-02 23:21:41', 'payé'),
(12, 4, 7, 1, 2, 'en_attente', '2025-07-03 01:20:33', '2025-08-04 14:01:46', 'payé'),
(13, 4, 7, 2, 12, 'en_attente', '2025-07-03 01:20:33', '2025-08-04 14:01:46', 'payé'),
(14, 4, 7, 2, 6, 'en_attente', '2025-07-03 01:20:34', '2025-08-04 14:01:46', 'payé'),
(15, 4, 7, 1, 2, 'en_attente', '2025-07-03 01:44:42', '2025-08-04 14:01:46', 'payé'),
(16, 4, 7, 2, 12, 'en_attente', '2025-07-03 01:44:42', '2025-08-04 14:01:46', 'payé'),
(17, 4, 7, 2, 6, 'en_attente', '2025-07-03 01:44:42', '2025-08-04 14:01:46', 'payé'),
(18, 4, 7, 1, 2, 'en_attente', '2025-07-03 01:50:02', '2025-08-04 14:01:46', 'payé'),
(19, 4, 7, 2, 12, 'en_attente', '2025-07-03 01:50:02', '2025-08-04 14:01:46', 'payé'),
(20, 4, 7, 2, 6, 'en_attente', '2025-07-03 01:50:03', '2025-08-04 14:01:46', 'payé'),
(21, 4, 5, 1, 1, 'en_attente', '2025-07-03 02:17:40', '2025-07-03 02:19:42', 'payé'),
(22, 4, 5, 2, 1, 'en_attente', '2025-07-03 02:17:40', '2025-07-03 02:19:42', 'payé'),
(23, 4, 5, 2, 5, 'en_attente', '2025-07-03 02:17:40', '2025-07-03 02:19:42', 'payé'),
(24, 9, 3, 10, 1, 'en_attente', '2025-07-22 08:54:36', '2025-07-22 08:56:51', 'payé'),
(25, 9, 3, 8, 2, 'en_attente', '2025-07-22 08:54:37', '2025-07-22 08:56:51', 'payé'),
(26, 9, 3, 12, 3, 'en_attente', '2025-07-22 08:54:38', '2025-07-22 08:56:51', 'payé'),
(27, 9, 3, 19, 2, 'en_attente', '2025-07-22 08:54:40', '2025-07-22 08:56:51', 'payé'),
(28, 4, 1, 3, 1, 'en_attente', '2025-07-24 08:48:52', '2025-07-24 08:51:31', 'payé'),
(29, 4, 1, 14, 1, 'en_attente', '2025-07-24 08:48:53', '2025-07-24 08:51:31', 'payé'),
(30, 4, 1, 25, 4, 'en_attente', '2025-07-24 08:48:54', '2025-07-24 08:51:31', 'payé'),
(31, 4, NULL, 1, 2, 'en_attente', '2025-07-24 12:46:18', '2025-07-24 12:46:18', 'non_payé'),
(32, 4, NULL, 24, 1, 'en_attente', '2025-07-24 13:30:48', '2025-07-24 13:30:48', 'non_payé'),
(33, 4, NULL, 17, 3, 'en_attente', '2025-07-24 13:30:52', '2025-07-24 13:30:52', 'non_payé'),
(34, 4, NULL, 8, 1, 'en_attente', '2025-07-24 13:30:54', '2025-07-24 13:30:54', 'non_payé'),
(35, 4, NULL, 7, 1, 'en_attente', '2025-07-24 13:30:56', '2025-07-24 13:30:56', 'non_payé'),
(36, 4, NULL, 5, 1, 'en_attente', '2025-07-24 13:30:58', '2025-07-24 13:30:58', 'non_payé'),
(37, 4, NULL, 2, 3, 'en_attente', '2025-07-24 13:31:00', '2025-07-24 13:31:00', 'non_payé'),
(38, 4, NULL, 19, 1, 'en_attente', '2025-07-24 13:31:03', '2025-07-24 13:31:03', 'non_payé'),
(39, 4, NULL, 17, 1, 'en_attente', '2025-07-24 13:31:05', '2025-07-24 13:31:05', 'non_payé'),
(40, 4, NULL, 16, 4, 'en_attente', '2025-07-24 13:31:07', '2025-07-24 13:31:07', 'non_payé'),
(41, 4, NULL, 10, 1, 'en_attente', '2025-07-24 13:31:09', '2025-07-24 13:31:09', 'non_payé'),
(42, 4, NULL, 4, 1, 'en_attente', '2025-07-24 13:31:11', '2025-07-24 13:31:11', 'non_payé'),
(43, 4, NULL, 1, 1, 'en_attente', '2025-07-24 13:31:12', '2025-07-24 13:31:12', 'non_payé'),
(44, 9, 8, 3, 4, 'en_attente', '2025-08-04 12:49:31', '2025-08-04 14:32:15', 'payé'),
(45, 9, 8, 8, 1, 'en_attente', '2025-08-04 12:49:32', '2025-08-04 14:32:15', 'payé'),
(46, 9, 8, 20, 1, 'en_attente', '2025-08-04 12:49:34', '2025-08-04 14:32:15', 'payé'),
(47, 9, 8, 22, 1, 'en_attente', '2025-08-04 12:49:35', '2025-08-04 14:32:15', 'payé'),
(48, 4, 8, 9, 2, 'en_attente', '2025-08-04 14:00:12', '2025-08-04 14:32:15', 'payé'),
(49, 4, 8, 25, 1, 'en_attente', '2025-08-04 14:00:13', '2025-08-04 14:32:15', 'payé'),
(50, 9, 8, 17, 1, 'en_attente', '2025-08-04 14:42:21', '2025-08-04 14:43:50', 'payé'),
(51, 4, 7, 1, 1, 'en_attente', '2025-08-06 06:28:07', '2025-08-06 06:28:07', 'non_payé'),
(52, 4, 7, 8, 3, 'en_attente', '2025-08-06 06:28:08', '2025-08-06 06:28:08', 'non_payé'),
(53, 4, 2, 9, 2, 'en_attente', '2025-08-18 09:06:55', '2025-08-18 09:06:55', 'non_payé'),
(54, 4, 2, 7, 1, 'en_attente', '2025-08-18 09:06:55', '2025-08-18 09:06:55', 'non_payé'),
(55, 4, 2, 24, 2, 'en_attente', '2025-08-18 09:06:56', '2025-08-18 09:06:56', 'non_payé'),
(56, 4, 2, 9, 2, 'en_attente', '2025-08-18 09:07:43', '2025-08-18 09:07:43', 'non_payé'),
(57, 4, 2, 7, 1, 'en_attente', '2025-08-18 09:07:43', '2025-08-18 09:07:43', 'non_payé'),
(58, 4, 2, 24, 2, 'en_attente', '2025-08-18 09:07:44', '2025-08-18 09:07:44', 'non_payé'),
(59, 4, 1, 14, 2, 'en_attente', '2025-08-18 09:10:17', '2025-08-21 10:18:01', 'payé'),
(60, 4, 1, 18, 3, 'en_attente', '2025-08-18 09:10:17', '2025-08-21 10:18:01', 'payé'),
(61, 4, 2, 22, 2, 'en_attente', '2025-08-18 09:11:21', '2025-08-18 09:11:21', 'non_payé'),
(62, 4, 2, 22, 2, 'en_attente', '2025-08-18 09:11:24', '2025-08-18 09:11:24', 'non_payé'),
(63, 9, 5, 1, 1, 'en_attente', '2025-08-20 11:01:40', '2025-08-20 11:07:03', 'payé'),
(64, 9, 5, 17, 2, 'en_attente', '2025-08-20 11:01:44', '2025-08-20 11:07:03', 'payé'),
(65, 9, 6, 1, 2, 'en_attente', '2025-08-20 14:46:03', '2025-08-20 14:48:29', 'payé'),
(66, 9, 6, 18, 1, 'en_attente', '2025-08-20 14:46:05', '2025-08-20 14:48:29', 'payé'),
(67, 4, 1, 1, 1, 'en_attente', '2025-08-21 10:10:54', '2025-08-21 10:18:01', 'payé'),
(68, 4, 1, 2, 1, 'en_attente', '2025-08-21 10:10:56', '2025-08-21 10:18:01', 'payé'),
(69, 4, 1, 17, 1, 'en_attente', '2025-08-21 10:10:58', '2025-08-21 10:18:01', 'payé');

-- --------------------------------------------------------

--
-- Structure de la table `serveurs`
--

CREATE TABLE `serveurs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('fBVFomFPizWknbK2kXMeIAmjGEgAbXHE1J8CfPDZ', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYUJHbGVObkY3WnAzQXBMNnRnQnZvUHJCUVVEUFMzeGY4R05mZER5VCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaG93UmVzZXJ2YXRpb25zIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1755772242);

-- --------------------------------------------------------

--
-- Structure de la table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint UNSIGNED NOT NULL,
  `food_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `stocks`
--

INSERT INTO `stocks` (`id`, `food_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 7, '2025-07-08 06:29:27', '2025-08-20 05:39:52'),
(2, 2, 0, '2025-07-08 06:29:27', '2025-08-20 02:55:45'),
(3, 3, 15, '2025-07-08 06:29:27', '2025-07-08 06:29:27'),
(4, 4, 10, '2025-07-08 06:29:27', '2025-07-08 06:29:27'),
(5, 5, 10, '2025-07-08 06:29:27', '2025-07-08 13:03:23'),
(6, 6, 6, '2025-07-08 06:29:27', '2025-07-08 06:29:27'),
(8, 25, 0, '2025-08-20 02:56:09', '2025-08-20 02:56:09');

-- --------------------------------------------------------

--
-- Structure de la table `stock_histories`
--

CREATE TABLE `stock_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `food_id` bigint UNSIGNED NOT NULL,
  `type` enum('entrée','sortie') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tables`
--

CREATE TABLE `tables` (
  `id` bigint UNSIGNED NOT NULL,
  `nom_table` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `serveur_id` bigint UNSIGNED DEFAULT NULL,
  `capacite` int NOT NULL,
  `statut` enum('Disponible','Occupée','Réservée','Libérée') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Disponible',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tables`
--

INSERT INTO `tables` (`id`, `nom_table`, `serveur_id`, `capacite`, `statut`, `description`, `created_at`, `updated_at`) VALUES
(1, 'A1', 4, 4, 'Occupée', NULL, NULL, '2025-08-21 10:11:00'),
(2, 'B2', 4, 2, 'Occupée', NULL, NULL, '2025-08-18 09:11:25'),
(3, 'C3', 9, 6, 'Réservée', NULL, NULL, '2025-08-04 11:51:40'),
(4, 'D4', 9, 8, 'Réservée', NULL, NULL, '2025-08-20 10:24:24'),
(5, 'E5', 9, 10, 'Occupée', NULL, '2025-06-19 19:53:22', '2025-08-20 11:01:46'),
(6, 'F6', 9, 12, 'Occupée', NULL, '2025-06-20 11:29:37', '2025-08-20 14:46:08'),
(7, 'A8', 4, 20, 'Occupée', NULL, '2025-06-25 05:45:08', '2025-08-06 06:28:10'),
(8, 'Commande externe', NULL, 0, 'Disponible', NULL, '2025-07-24 14:30:55', '2025-07-24 14:30:55');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usertype` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `usertype`, `phone`, `adress`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'seed', 'admin@gmail.com', 'admin', '0993839402', 'Goma Tulipiers, 40', NULL, '$2y$12$5L/G0BaP1/ZJXkY3tbqxeuMfDqAh2TZp/bv3Axm6c2jDKJXqDJ0pm', NULL, NULL, NULL, 'RvFpls6n64OuffBFQ7xlN1VQbkUGW0OxC1WvwR9kwVSYagI55RfE3reG0O6g', NULL, NULL, '2025-06-11 17:40:58', '2025-06-11 17:40:58'),
(2, 'Nathan', 'nathan23@gmail.com', 'user', '0996644356', 'Goma, Murara 23', NULL, '$2y$12$pLhIT.1BLtr6tY6u5OKuUenRZ6pf6XmJzBtQryYYwETa2J9nHY6Ay', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-11 17:43:45', '2025-06-11 17:43:45'),
(3, 'Aaron LUKALU', 'aaronluk@gmail.com', 'user', '0998765423', 'Kinshasa , du fleuve 33', NULL, '$2y$12$wuiZ.Br.t34Fu52o26G77O5JjVDYEaRwr5JatlpAJX0f5rFEfvhL.', NULL, NULL, NULL, 'bck1y4l6Z7tBAtJdAfsPxvy3Gxv66IBbqC8NM6w7mYsPNOpxyeZoB9KHwiB9', NULL, NULL, '2025-06-11 17:44:52', '2025-06-11 17:44:52'),
(4, 'Elisée', 'elisee@gmail.com', 'serveur', '0993637354', 'Goma, Katoyi 45', NULL, '$2y$12$imyuG.PG1aKx1RpVO.wJxep8q44/6v9RMvSIiZ783F9wWeearl43K', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-11 17:46:22', '2025-06-11 17:46:22'),
(5, 'SAIDI MASUDI SADOCK', 'sadockmas@gmail.com', 'user', '0894455332', 'Goma Les volcans, 39', NULL, '$2y$12$5xXk/SxlMTDKrK2zAF6tteUGAYn.z0cNcTaQmHEWu9fNGZg5RKXsy', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-11 17:48:39', '2025-06-11 17:48:39'),
(6, 'David Bolamu', 'davidbolamu@gmail.com', 'user', '0850034254', 'Goma, Mabanga sud 43', NULL, '$2y$12$SO9fIWnFbsmOISRlsRmqkOhZhULX8wMvDirs44ZHJ5RsFnwfL8E6G', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-21 05:14:17', '2025-06-21 05:14:17'),
(9, 'emmanuel', 'emmanuel@gmail.com', 'serveur', '+243 56 78 43 432', 'Goma, Tulipier 01', NULL, '$2y$12$rpEcBOVbJ.VMa2sGAUnbXOG9FBmC1unPOjyLo0QWRA6MSAa34xjHy', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-28 13:34:35', '2025-06-28 13:34:35'),
(10, 'Grace', 'grace@gmail.com', 'user', '093848504', 'Goma', NULL, '$2y$12$KDfbwGZAHfOr3m19cWk5oOMP3Ylsw8KkR.gSojIXS1vXX7MF78asK', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-08 12:50:43', '2025-07-08 12:50:43'),
(11, 'john walker', 'johnwalk@gmail.com', 'user', '0975767780', 'himbi goma', NULL, '$2y$12$aRz6bDnyfYzqzCOLkifjuuPWv6IOPdPmRTKzPK6BU5MxE.v4DVrEi', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-11 15:49:09', '2025-07-11 15:49:09'),
(12, 'Assan CO', 'assan@gmail.com', 'user', '+243 56 78 43 432', 'Goma, Murar 35', NULL, '$2y$12$zOfcyYJ6FAJzfz2nLfhUPuPWQ53JOabiixmDXlW63t4OU6c4KvhOa', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-19 21:50:04', '2025-07-19 21:50:04'),
(13, 'Christian', 'christian22@gmail.com', 'user', '09733435363', 'Goma , Colibri 56', NULL, '$2y$12$x3f0L0d36NfDugUZGDpzkuazG3kyzb9KakIhQO5ArwbALpUicI0sa', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-04 11:46:56', '2025-08-07 08:59:06'),
(14, 'EL NATHAN', 'nathan11@gmail.com', 'user', '+243 56 78 43 311', 'Goma, mabanga 12', NULL, '$2y$12$KY65ygY2QZ67cixzYdw.sO8iQgDI2JIaPhk7xmEFlKPE8akLfjrl.', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-19 08:56:22', '2025-08-19 08:56:22'),
(15, 'Josué', 'josue23@gmail.com', 'user', NULL, NULL, NULL, '$2y$12$MojM0HVz1UnyJiYwWDR0d.7EL2n.emtkjYyGZb38qjZetAjSZRI/K', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-21 09:20:08', '2025-08-21 09:20:08');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `books_table_id_foreign` (`table_id`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `food_ingredients`
--
ALTER TABLE `food_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_ingredients_food_id_foreign` (`food_id`),
  ADD KEY `food_ingredients_ingredient_id_foreign` (`ingredient_id`);

--
-- Index pour la table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_food_id_foreign` (`food_id`),
  ADD KEY `orders_table_id_foreign` (`table_id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`),
  ADD KEY `payments_serveur_id_foreign` (`serveur_id`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `server_orders`
--
ALTER TABLE `server_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `server_orders_serveur_id_foreign` (`serveur_id`),
  ADD KEY `server_orders_table_id_foreign` (`table_id`),
  ADD KEY `server_orders_food_id_foreign` (`food_id`);

--
-- Index pour la table `serveurs`
--
ALTER TABLE `serveurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serveurs_email_unique` (`email`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_food_id_foreign` (`food_id`);

--
-- Index pour la table `stock_histories`
--
ALTER TABLE `stock_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_history_food_id_foreign` (`food_id`);

--
-- Index pour la table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tables_nom_table_unique` (`nom_table`),
  ADD KEY `tables_serveur_id_foreign` (`serveur_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `food`
--
ALTER TABLE `food`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `food_ingredients`
--
ALTER TABLE `food_ingredients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT pour la table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `server_orders`
--
ALTER TABLE `server_orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT pour la table `serveurs`
--
ALTER TABLE `serveurs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `stock_histories`
--
ALTER TABLE `stock_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `food_ingredients`
--
ALTER TABLE `food_ingredients`
  ADD CONSTRAINT `food_ingredients_food_id_foreign` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `food_ingredients_ingredient_id_foreign` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_food_id_foreign` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_serveur_id_foreign` FOREIGN KEY (`serveur_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `server_orders`
--
ALTER TABLE `server_orders`
  ADD CONSTRAINT `server_orders_food_id_foreign` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `server_orders_serveur_id_foreign` FOREIGN KEY (`serveur_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_food_id_foreign` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `stock_histories`
--
ALTER TABLE `stock_histories`
  ADD CONSTRAINT `stock_history_food_id_foreign` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tables`
--
ALTER TABLE `tables`
  ADD CONSTRAINT `tables_serveur_id_foreign` FOREIGN KEY (`serveur_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
