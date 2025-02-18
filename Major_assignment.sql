-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 23, 2024 at 01:41 PM
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
-- Database: `Major_assignment`
-- 
CREATE DATABASE Major_assignment;
USE Major_assignment;

-- --------------------------------------------------------

--
-- Table structure for table `Parking`
--

CREATE TABLE `Parking` (
  `parking_id` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `parking_space` int(11) NOT NULL,
  `cost_per_hour` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Parking`
--

INSERT INTO `Parking` (`parking_id`, `location`, `description`, `parking_space`, `cost_per_hour`) VALUES
(1, 'Central Park A', 'Conveniently located near the city center. Open 24/7.', 10, 4.50),
(2, 'Elm Street Parking', 'Spacious parking with security cameras. Close to shopping district.', 15, 5.00),
(3, 'Oakwood Parking', 'Affordable parking near public transport.', 10, 3.30),
(4, 'Pine Plaza Parking', 'Secure parking with attendants. Near major office buildings.', 22, 6.00),
(5, 'Maple Grove Parking', 'Economical parking in a quiet neighborhood.', 20, 4.00),
(6, 'Birch Street Garage', 'Modern facility with EV charging stations.', 25, 6.50),
(7, 'Cedar Parkade', 'Parking lot with wide spaces. Near the university.', 30, 5.50),
(8, 'Willow Lane Parking', 'Large parking lot with shade. Close to the stadium.', 50, 7.00),
(9, 'Ashwood Parking', 'Multi-level parking with good lighting.', 30, 4.50),
(10, 'Fir Tree Parking', 'Well-maintained parking. Close to restaurants and cafes.', 20, 5.50);

-- --------------------------------------------------------

--
-- Table structure for table `Parking_history`
--

CREATE TABLE `Parking_history` (
  `history_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parking_id` int(11) NOT NULL,
  `checkin_date_time` datetime NOT NULL,
  `checkout_date_time` datetime DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Parking_history`
--

INSERT INTO `Parking_history` (`history_id`, `user_id`, `parking_id`, `checkin_date_time`, `checkout_date_time`, `cost`) VALUES
(1, 2, 1, '2024-05-20 20:58:57', '2024-05-20 22:40:34', 9.00),
(2, 3, 1, '2024-05-20 21:01:35', '2024-05-20 22:40:38', 9.00),
(3, 4, 1, '2024-05-20 21:02:12', NULL, NULL),
(4, 5, 1, '2024-05-20 21:02:55', NULL, NULL),
(5, 5, 4, '2024-05-20 21:03:15', NULL, NULL),
(6, 6, 1, '2024-05-20 21:04:03', NULL, NULL),
(7, 6, 9, '2024-05-20 21:04:06', NULL, NULL),
(8, 7, 1, '2024-05-20 21:04:55', NULL, NULL),
(9, 7, 6, '2024-05-20 21:04:59', NULL, NULL),
(10, 8, 1, '2024-05-20 21:05:36', NULL, NULL),
(11, 8, 9, '2024-05-20 21:05:39', NULL, NULL),
(12, 9, 1, '2024-05-20 21:06:25', NULL, NULL),
(13, 9, 4, '2024-05-20 21:06:29', NULL, NULL),
(14, 10, 1, '2024-05-20 21:07:04', NULL, NULL),
(15, 11, 1, '2024-05-20 21:08:00', NULL, NULL),
(16, 7, 7, '2024-05-23 13:38:22', NULL, NULL),
(17, 2, 8, '2024-05-23 13:39:39', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`user_id`, `name`, `surname`, `phone`, `email`, `password`, `type`) VALUES
(1, 'admin', 'admin', '0433222111', 'admin@example.com', '295ce6711606eaea5a2e8f0c4703e7b7', 'admin'),
(2, 'John', 'Smith', '0411222333', 'john@example.com', '7829b307dbeecd1e172548c5da3002bd', 'user'),
(3, 'Mary', 'Johnson', '0400999888', 'mary@example.com', 'b40ae88393f46644d8faa068cf98f340', 'user'),
(4, 'David', 'Williams', '0411233444', 'david@example.com', 'd002f828d1936c15fd73df6740ff1ae3', 'user'),
(5, 'Sarah', 'Brown', '0499766544', 'sarah@example.com', 'ac5ad09b7279320da498dbab3f554cbd', 'user'),
(6, 'Michael', 'Jones', '0498123546', 'michael@example.com', 'eb7071bf790054b29c3764fac5618fdc', 'user'),
(7, 'Emily', 'Davis', '0422857942', 'emily@example.com', '0fa40cec7da31bbae5e889a8ea0ff8bc', 'user'),
(8, 'James', 'Miller', '0487255733', 'james@example.com', '832af0c7d9a592997708160342c4b6b6', 'user'),
(9, 'Jessica', 'Wilson', '0489652490', 'jessica@example.com', '47a51fa874d123b7f815d958ea3e7924', 'user'),
(10, 'Andrew', 'Moore', '0477398854', 'andrew@example.com', 'c03cc596cf9e8d164d7c1de57a2db085', 'user'),
(11, 'Jeniffer', 'Tayler', '0499005376', 'jennifer@example.com', '947d8623a19013038159e819f0db0c2c', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Parking`
--
ALTER TABLE `Parking`
  ADD PRIMARY KEY (`parking_id`);

--
-- Indexes for table `Parking_history`
--
ALTER TABLE `Parking_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parking_id` (`parking_id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Parking`
--
ALTER TABLE `Parking`
  MODIFY `parking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Parking_history`
--
ALTER TABLE `Parking_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Parking_history`
--
ALTER TABLE `Parking_history`
  ADD CONSTRAINT `parking_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`),
  ADD CONSTRAINT `parking_history_ibfk_2` FOREIGN KEY (`parking_id`) REFERENCES `Parking` (`parking_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
