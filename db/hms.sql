-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 24, 2025 at 01:49 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hms`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `room_id` int(10) UNSIGNED NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `status` enum('booked','checked_in','checked_out','cancelled') DEFAULT 'booked',
  `notes` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `room_id`, `check_in`, `check_out`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '2025-12-26', '2026-01-08', 'booked', 'some notes', '2025-12-24 11:30:27', '2025-12-24 11:30:27'),
(2, 1, 7, '2025-12-24', '2025-12-26', 'checked_out', 'soome dvs', '2025-12-24 11:31:18', '2025-12-24 11:34:36'),
(3, 1, 7, '2025-12-24', '2025-12-25', 'cancelled', 'some notes here', '2025-12-24 11:42:37', '2025-12-24 12:18:05'),
(4, 1, 8, '2025-12-25', '2025-12-26', 'booked', 'hhs', '2025-12-24 12:16:32', '2025-12-24 12:16:32');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) UNSIGNED NOT NULL,
  `room_number` varchar(20) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `floor` int(11) DEFAULT NULL,
  `status` enum('available','booked','maintenance') DEFAULT 'available',
  `notes` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `room_type_id`, `floor`, `status`, `notes`, `image`, `created_at`, `updated_at`) VALUES
(5, '101', 4, 1, 'booked', 'sfsf', 'room_694bbd845d8175.60876197.png', '2025-12-24 10:48:40', '2025-12-24 12:26:58'),
(6, '102', 3, 1, 'booked', 'ff', NULL, '2025-12-24 10:49:21', '2025-12-24 10:49:21'),
(7, '104', 4, 1, 'booked', 'fvef', NULL, '2025-12-24 11:05:05', '2025-12-24 11:42:37'),
(8, '105', 3, 2, 'booked', 'sssff', NULL, '2025-12-24 11:53:56', '2025-12-24 12:16:32'),
(9, '109', 3, 2, 'available', 'sff', NULL, '2025-12-24 11:54:20', '2025-12-24 11:54:20'),
(10, '108', 3, 2, 'available', 'fwf', NULL, '2025-12-24 12:31:53', '2025-12-24 12:31:53'),
(11, '111', 3, 2, 'available', 'fef', NULL, '2025-12-24 12:36:26', '2025-12-24 12:36:26'),
(12, '234', 3, 3, 'available', 'cdsds', NULL, '2025-12-24 12:42:03', '2025-12-24 12:42:03');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `name`, `description`, `price`, `created_at`) VALUES
(3, 'Double', 'some des', 120.00, '2025-12-24 09:16:34'),
(4, 'Single', 'acad', 60.00, '2025-12-24 09:47:36');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `price`, `created_at`) VALUES
(1, 'Massage', 'good massage', 20.00, '2025-12-24 09:55:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('guest','receptionist','admin') NOT NULL DEFAULT 'guest',
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `account_status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `role`, `password`, `created_at`, `updated_at`, `account_status`) VALUES
(1, 'Mabior Deng', 'mabiorgraham48@gmail.com', 'guest', '$2y$10$kto6zzx33lOTLJkxeCJG2.iwuYvwnVKO3o6DkWCEmJsb4948NY/VO', '2025-12-22 12:33:59', '2025-12-22 12:33:59', 'active'),
(2, 'mapath samuel', 'samuelmapath00@gmail.com', 'admin', '$2y$10$28BClVznElVyryBvs07rvun/i9qiUspwpTY4zgWuflmw930yrZKgG', '2025-12-22 12:44:45', '2025-12-22 12:45:35', 'active'),
(3, 'Mary Adeng', 'mary@gmail.com', 'receptionist', '$2y$10$DrxGciHszbZuwZqcpubtruY93lkyY7/fc8q1wWogXLBhfBVKMkFtC', '2025-12-22 12:49:32', '2025-12-24 10:56:49', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_booking_user` (`user_id`),
  ADD KEY `fk_booking_room` (`room_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_number` (`room_number`),
  ADD KEY `fk_room_type` (`room_type_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_booking_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `fk_room_type` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
