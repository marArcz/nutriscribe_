-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2024 at 03:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nutriscribe`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `verification_code` varchar(255) DEFAULT NULL,
  `verification_code_created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `firstname`, `lastname`, `username`, `password`, `image`, `email`, `email_verified_at`, `verification_code`, `verification_code_created_at`) VALUES
(1, 'Admin', 'User', 'admin', '$2y$10$neLu7IFnbj9dFK8NCC9lQOrU.85W0fxbe9F5irT7l5cFOsvfEaYQG', '', 'admin@email.com', '2023-10-26 14:59:47', '34B26D', '2023-10-26 13:43:27');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` int(11) NOT NULL,
  `scholar_id` int(11) NOT NULL,
  `type` enum('in','out') NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scholar_accounts`
--

CREATE TABLE `scholar_accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT 0,
  `change_password_on_login` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholar_accounts`
--

INSERT INTO `scholar_accounts` (`id`, `username`, `password`, `disabled`, `change_password_on_login`, `created_at`, `updated_at`) VALUES
(11, 'mzafe', '$2y$10$c2whosqZVlcuX.jGKH/PceoSXCRqR.Mpq9SxeigtRlCj7gau3esDq', 0, 1, '2024-04-14 10:26:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `scholar_activities`
--

CREATE TABLE `scholar_activities` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `beneficiaries` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('SUBMITTED','RECIEVED','','') NOT NULL DEFAULT 'SUBMITTED',
  `type` varchar(255) NOT NULL,
  `scholar_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scholar_infos`
--

CREATE TABLE `scholar_infos` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `birthday` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(12) NOT NULL,
  `scholar_account_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholar_infos`
--

INSERT INTO `scholar_infos` (`id`, `firstname`, `middlename`, `lastname`, `email`, `address`, `birthday`, `phone`, `scholar_account_id`, `created_at`, `updated_at`, `photo`) VALUES
(10, 'Marlo', 'Arcilla', 'Zafe', 'marlozafe13@gmail.com', 'Gogon Centro Virac, Catanduanes', '2024-04-14 10:26:02', '9979970920', 11, '2024-04-14 10:26:02', '2024-04-14 10:26:41', 'profile-pic.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scholar_id` (`scholar_id`);

--
-- Indexes for table `scholar_accounts`
--
ALTER TABLE `scholar_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `scholar_activities`
--
ALTER TABLE `scholar_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scholar_id` (`scholar_id`);

--
-- Indexes for table `scholar_infos`
--
ALTER TABLE `scholar_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scholar_account_id` (`scholar_account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `scholar_accounts`
--
ALTER TABLE `scholar_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `scholar_activities`
--
ALTER TABLE `scholar_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `scholar_infos`
--
ALTER TABLE `scholar_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_ibfk_1` FOREIGN KEY (`scholar_id`) REFERENCES `scholar_infos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `scholar_activities`
--
ALTER TABLE `scholar_activities`
  ADD CONSTRAINT `scholar_activities_ibfk_1` FOREIGN KEY (`scholar_id`) REFERENCES `scholar_infos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `scholar_infos`
--
ALTER TABLE `scholar_infos`
  ADD CONSTRAINT `scholar_infos_ibfk_1` FOREIGN KEY (`scholar_account_id`) REFERENCES `scholar_accounts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
