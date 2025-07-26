-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2025 at 10:32 AM
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
-- Database: `rommelgarciaappointments`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$SC5Av6b9/IqCGVWFIqqC.exWfg5YNOP1Jr2eO5yiSo7UiFUxc8L5W', '2025-06-15 20:18:26');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `full_name`, `email`, `phone`, `appointment_date`, `appointment_time`, `status_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'duo duo', 'dodue@bilibli.com', '123412341234', '2025-06-16', '16:18:00', 1, 'DUO Package', '2025-06-15 20:18:26', '2025-06-15 20:18:26'),
(2, 'today', 'today@mail.to', '090912341234', '2025-06-17', '11:33:00', 1, 'SOLO Package', '2025-06-16 22:33:49', '2025-06-16 22:33:49'),
(3, 'LF Kaduo', 'kaduo@gmail.com', '090912341234', '2025-06-17', '10:38:00', 1, 'DUO Package', '2025-06-16 22:38:26', '2025-06-16 22:38:26'),
(4, 'duo testing', 'duotesting@gmail.com', '090912341234', '2025-06-16', '14:41:00', 1, 'DUO Package', '2025-06-16 22:40:43', '2025-06-16 22:40:43'),
(5, 'test', 'test@gmail.com', '0909123123', '2025-06-19', '15:20:00', 1, 'TRIO Package', '2025-06-18 10:20:44', '2025-06-18 10:20:44'),
(6, 'solo', 'solotest@admin.com', '0909123123', '2025-06-19', '09:40:00', 1, 'SOLO Package', '2025-06-18 10:40:02', '2025-06-18 10:40:02'),
(7, 'duo', 'duo@duo.com', '0909123412341234', '2025-06-25', '10:27:00', 1, 'DUO Package', '2025-06-24 20:27:44', '2025-06-24 20:27:44');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_statuses`
--

CREATE TABLE `appointment_statuses` (
  `id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_statuses`
--

INSERT INTO `appointment_statuses` (`id`, `status`) VALUES
(1, 'pending'),
(2, 'confirmed'),
(3, 'completed'),
(4, 'cancelled');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `appointment_statuses`
--
ALTER TABLE `appointment_statuses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `appointment_statuses`
--
ALTER TABLE `appointment_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `appointment_statuses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
