-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2024 at 05:10 PM
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
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `relative_name` varchar(100) NOT NULL,
  `death_date` date DEFAULT NULL,
  `confirmation_status` enum('Pending','Confirmed','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `first_name`, `middle_name`, `last_name`, `password`, `email`, `contact_number`, `relative_name`, `death_date`, `confirmation_status`, `created_at`) VALUES
(26, 'asdasd', 'asdasd', 'asdasdasd', 'admin1234', 'deguzmanandreivincent@gmail.com', '123123123123', 'asdasdasd', '2024-10-12', 'Pending', '2024-10-19 02:10:06');

-- --------------------------------------------------------

--
-- Table structure for table `deceased_table`
--

CREATE TABLE `deceased_table` (
  `relative_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `buried_date` date DEFAULT NULL,
  `death_date` date DEFAULT NULL,
  `grave_location` varchar(100) DEFAULT NULL,
  `status` enum('Active','For Expiration','Expired','To Confirm','Archived') DEFAULT 'To Confirm'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deceased_table`
--

INSERT INTO `deceased_table` (`relative_id`, `client_id`, `first_name`, `middle_name`, `last_name`, `buried_date`, `death_date`, `grave_location`, `status`) VALUES
(1, NULL, 'Juan', 'Dela', 'Cruz', '2023-05-15', '2023-05-10', 'Apartment: Section 1, Column 2, Row 3', 'Archived'),
(2, NULL, 'Maria', 'Santos', 'Reyes', '2022-11-22', '2022-11-18', 'Apartment: Section 2, Column 1, Row 4', 'Expired'),
(3, NULL, 'Jose', 'De', 'La Rosa', '2021-03-30', '2021-03-25', 'Apartment: Section 3, Column 3, Row 5', 'For Expiration'),
(4, NULL, 'Ana', 'Marquez', 'Santiago', '2020-08-10', '2020-08-05', 'Area A, Plot number 15', 'Active'),
(5, NULL, 'Carlos', 'Miguel', 'Alvarez', '2019-12-01', '2019-11-28', 'Apartment: Section 4, Column 2, Row 1', 'To Confirm');

-- --------------------------------------------------------

--
-- Table structure for table `relatives`
--

CREATE TABLE `relatives` (
  `relative_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `buried_date` date NOT NULL,
  `death_date` date NOT NULL,
  `grave_location` varchar(100) NOT NULL,
  `status` enum('Active','For Expiration','Expired','To Confirm') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `relatives`
--

INSERT INTO `relatives` (`relative_id`, `client_id`, `name`, `buried_date`, `death_date`, `grave_location`, `status`) VALUES
(9, 26, 'asdasdasd', '2024-10-12', '2024-10-12', '', 'To Confirm');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `position`, `user_name`, `password`, `email`, `date_of_birth`, `gender`, `address`, `date_created`, `last_login`, `is_active`) VALUES
(1, 'John', 'Doe', 'Manager', 'johndoe', 'hashedpassword123', 'john.doe@example.com', '1990-05-15', 'Male', '123 Main St, Cityville', '2024-09-21 06:33:42', '2024-10-06 14:08:01', 1),
(2, 'Rocel', 'Miras', 'Admin', 'rocelmiras', 'admin123', 'rocel.miras@gmail.com', '1992-08-22', 'Female', '456 Elm St, Townsville', '2024-09-21 06:33:42', '2024-10-26 13:11:23', 1),
(3, 'Alex', 'Taylor', 'Staff', 'alextaylor', 'hashedpassword789', 'alex.taylor@example.com', '1985-11-30', 'Other', '789 Oak St, Villagetown', '2024-09-21 06:33:42', '2024-10-09 12:20:12', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `deceased_table`
--
ALTER TABLE `deceased_table`
  ADD PRIMARY KEY (`relative_id`);

--
-- Indexes for table `relatives`
--
ALTER TABLE `relatives`
  ADD PRIMARY KEY (`relative_id`),
  ADD KEY `fk_client` (`client_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `deceased_table`
--
ALTER TABLE `deceased_table`
  MODIFY `relative_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `relatives`
--
ALTER TABLE `relatives`
  MODIFY `relative_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `relatives`
--
ALTER TABLE `relatives`
  ADD CONSTRAINT `fk_client` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `relatives_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
