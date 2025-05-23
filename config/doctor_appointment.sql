-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2025 at 05:34 PM
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
-- Database: `doctor`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `status` enum('pending','confirmed','canceled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `doctor_id`, `schedule_id`, `status`, `created_at`) VALUES
(1, 1, 1, 1, 'confirmed', '2025-05-12 12:13:00'),
(2, 1, 1, 2, 'canceled', '2025-05-12 12:16:22'),
(3, 1, 1, 2, 'pending', '2025-05-12 12:18:20'),
(4, 4, 2, 3, 'canceled', '2025-05-12 15:06:14'),
(5, 4, 2, 3, 'pending', '2025-05-12 15:06:52'),
(6, 5, 2, 4, 'pending', '2025-05-12 15:10:59');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `specialty` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `specialty`) VALUES
(1, 2, 'Dentist '),
(2, 3, ' General Medicine');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `schedule_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_booked` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `doctor_id`, `schedule_date`, `start_time`, `end_time`, `is_booked`) VALUES
(1, 1, '2025-05-12', '05:11:00', '11:11:00', 1),
(2, 1, '2025-05-13', '05:15:00', '06:16:00', 1),
(3, 2, '2025-05-13', '08:50:00', '09:54:00', 1),
(4, 2, '2025-05-14', '08:10:00', '09:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('patient','doctor') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Abdullahi khalif Abdi', 'khalif@gmail.com', '$2y$10$40duTfXIc/90kwH2acRwl.aGM0/9xbk.acvuSS3KnCfVHAn7KuiF2', 'patient', '2025-05-12 12:01:18'),
(2, 'Dr Ali Hassan', 'Ali@gmail.com', '$2y$10$obLEpaI67QiOlwMtOqvsFuxRx7aOExDyNa0qbZ3/O/sqF0JJeOgRy', 'doctor', '2025-05-12 12:11:05'),
(3, 'Dr Mohamed Ali Farah', 'mohamed@gmail.com', '$2y$10$xHNMt1fWGWGXWwSanJWZ.ey55Dkh1KcHpSZqo6lMWXkKbslitDoGm', 'doctor', '2025-05-12 14:46:39'),
(4, 'Ahmed Abdulkadir Mohamed', 'ahmed@gmail.com', '$2y$10$ZCDRDrRkkd5t1qnL9e6AFeRRfMHhfpSemnAeLCjTdUTMi3zYODDym', 'patient', '2025-05-12 15:05:47'),
(5, 'Maryan Osman', 'maryan@gmail.com', '$2y$10$F7OH1LvDGL4grBo8Og4RhuxthHspx6Mk2.kraMDx7RaN5CeklLSWS', 'patient', '2025-05-12 15:09:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`);

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
