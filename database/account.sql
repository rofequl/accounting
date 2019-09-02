-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2019 at 08:44 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `account`
--

-- --------------------------------------------------------

--
-- Table structure for table `credits`
--

CREATE TABLE `credits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(11) NOT NULL,
  `income_source_id` int(11) NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` int(11) NOT NULL,
  `previous_amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `credits`
--

INSERT INTO `credits` (`id`, `date`, `voucher_no`, `department_id`, `income_source_id`, `amount`, `payment_id`, `previous_amount`, `total_amount`, `remarks`, `created_at`, `updated_at`) VALUES
(4, '2019-09-01', '9120', 1, 3, '1000', 1, '1000', '2000', NULL, '2019-08-31 15:55:21', '2019-08-31 15:55:21'),
(6, '2019-09-01', '2652', 4, 8, '2000', 1, '2500', '4500', NULL, '2019-08-31 15:55:48', '2019-08-31 15:55:48'),
(7, '2019-09-01', '8272', 5, 7, '50', 1, '4000', '4050', NULL, '2019-08-31 15:56:54', '2019-08-31 15:56:54');

-- --------------------------------------------------------

--
-- Table structure for table `debits`
--

CREATE TABLE `debits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(11) NOT NULL,
  `expenditure_id` int(11) NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` int(11) NOT NULL,
  `previous_amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `debits`
--

INSERT INTO `debits` (`id`, `date`, `voucher_no`, `department_id`, `expenditure_id`, `amount`, `payment_id`, `previous_amount`, `total_amount`, `remarks`, `created_at`, `updated_at`) VALUES
(2, '2019-09-01', '8820', 2, 1, '1000', 1, '4050', '3050', NULL, '2019-08-31 16:17:17', '2019-08-31 16:17:17');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Golf Club', '2019-08-23 19:58:06', '2019-08-23 19:58:06'),
(2, 'Driving Range', '2019-08-23 19:58:17', '2019-08-23 19:58:17'),
(3, 'Swimming Pool', '2019-08-23 19:58:28', '2019-08-23 19:58:28'),
(4, 'Restaurant', '2019-08-23 19:58:37', '2019-08-23 19:58:37'),
(5, 'Golf Garden', '2019-08-23 19:58:47', '2019-08-23 19:58:47'),
(6, 'Guest House', '2019-08-23 19:58:54', '2019-08-23 19:58:54');

-- --------------------------------------------------------

--
-- Table structure for table `expenditures`
--

CREATE TABLE `expenditures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenditures`
--

INSERT INTO `expenditures` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Audit Fees', '2019-08-25 13:29:29', '2019-08-25 13:29:29'),
(2, 'Bank Charge', '2019-08-25 13:29:44', '2019-08-25 13:29:44'),
(3, 'Bonus', '2019-08-25 13:29:52', '2019-08-25 13:29:52'),
(4, 'Business Development', '2019-08-25 13:30:00', '2019-08-25 13:30:00'),
(5, 'Cable TV Bill', '2019-08-25 13:30:14', '2019-08-25 13:30:14'),
(6, 'Cleaning Bill', '2019-08-25 13:30:17', '2019-08-25 13:30:17'),
(7, 'Computer Accessories', '2019-08-25 13:30:26', '2019-08-25 13:30:26'),
(8, 'Conveyance', '2019-08-25 13:30:36', '2019-08-25 13:30:36'),
(9, 'Electricity Bill', '2019-08-25 13:30:47', '2019-08-25 13:30:47'),
(10, 'Entertainment Bill', '2019-08-25 13:30:53', '2019-08-25 13:30:53'),
(11, 'Furniture Bill', '2019-08-25 13:31:02', '2019-08-25 13:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `income_sources`
--

CREATE TABLE `income_sources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `income_source` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(11) NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `income_sources`
--

INSERT INTO `income_sources` (`id`, `income_source`, `department_id`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'Daily Entry', 1, NULL, '2019-08-23 19:59:37', '2019-08-23 19:59:37'),
(2, 'Monthly Subscription', 1, NULL, '2019-08-23 19:59:52', '2019-08-23 19:59:52'),
(3, 'Tournament Registration', 1, NULL, '2019-08-23 20:00:06', '2019-08-23 20:00:06'),
(4, 'Member entry subscription', 1, NULL, '2019-08-23 20:00:19', '2019-08-23 20:00:19'),
(5, 'Rent of Ball', 2, NULL, '2019-08-23 20:00:38', '2019-08-23 20:00:38'),
(6, 'Rent of Equipments', 2, NULL, '2019-08-23 20:00:49', '2019-08-23 20:00:49'),
(7, 'Daily Entry', 5, NULL, '2019-08-27 11:10:50', '2019-08-27 11:10:50'),
(8, 'Monthly Subscription', 4, NULL, '2019-08-27 11:11:00', '2019-08-27 11:11:00'),
(9, 'Rent of Ball', 6, NULL, '2019-08-27 11:11:08', '2019-08-27 11:11:08'),
(10, 'Rent of Ball', 3, NULL, '2019-08-27 11:11:15', '2019-08-27 11:11:15'),
(11, 'Rent of Ball', 4, NULL, '2019-08-27 11:11:58', '2019-08-27 11:11:58');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_22_121933_create_departments_table', 1),
(4, '2019_08_22_211305_create_income_sources_table', 1),
(5, '2019_08_24_130520_create_expenditures_table', 1),
(10, '2019_08_31_151838_create_payments_table', 3),
(11, '2019_08_24_211019_create_credits_table', 4),
(12, '2019_08_25_073103_create_debits_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `name`, `amount`, `created_at`, `updated_at`) VALUES
(1, 'Bikash', 3050, '2019-08-31 10:21:36', '2019-08-31 16:17:17'),
(2, 'Rocket', 50, '2019-08-31 11:06:22', '2019-08-31 15:34:34'),
(5, 'DBBL', NULL, '2019-08-31 11:52:32', '2019-08-31 15:34:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$Dkz5/6V8Uz7Y9serDYoMpOKCtTrMhf.o9RbTQem4NJKVAGmm/q32e', 'mI8qAdwXItknZIfdwa8VCtul1xvdK2AbfcYb46Hc61ZwGJrAjJ4vPoaBy3Kf', '2019-08-25 13:28:16', '2019-08-25 13:28:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `credits`
--
ALTER TABLE `credits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `debits`
--
ALTER TABLE `debits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenditures`
--
ALTER TABLE `expenditures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income_sources`
--
ALTER TABLE `income_sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `credits`
--
ALTER TABLE `credits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `debits`
--
ALTER TABLE `debits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `expenditures`
--
ALTER TABLE `expenditures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `income_sources`
--
ALTER TABLE `income_sources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
