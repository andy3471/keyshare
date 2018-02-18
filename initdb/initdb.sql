-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2018 at 12:50 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keyshare`
--

-- --------------------------------------------------------

--
-- Table structure for table `dlc`
--

CREATE TABLE `dlc` (
  `dlc_id` int(11) NOT NULL,
  `dlcname` varchar(45) NOT NULL,
  `game_id` varchar(45) NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_dttm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `game_id` int(11) NOT NULL,
  `gamename` varchar(45) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_user_id` int(11) DEFAULT NULL,
  `created_dttm` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE `keys` (
  `key_id` int(11) NOT NULL,
  `game_id` int(11) DEFAULT NULL,
  `dlc_id` int(11) DEFAULT NULL,
  `platform_id` int(11) DEFAULT NULL,
  `keycode` varchar(45) DEFAULT NULL,
  `owned_user` int(11) DEFAULT NULL,
  `removed` binary(1) DEFAULT NULL,
  `created_user_id` int(11) DEFAULT NULL,
  `created_dttm` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `platforms`
--

CREATE TABLE `platforms` (
  `platform_id` int(11) NOT NULL,
  `platformname` varchar(45) DEFAULT NULL,
  `created_dttm` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `platforms`
--

INSERT INTO `platforms` (`platform_id`, `platformname`, `created_dttm`) VALUES
(1, 'Steam', '2018-02-04'),
(2, 'Uplay', '2018-02-05'),
(3, 'Origin', '2018-02-05'),
(4, 'Windows Store', '2018-02-05'),
(5, 'Blizzard', '2018-02-05'),
(6, 'GOG', '2018-02-05'),
(7, 'PS3', '2018-02-05'),
(8, 'PS4', '2018-02-05'),
(9, 'PS Vita', '2018-02-05'),
(10, 'Switch', '2018-02-05'),
(11, 'Xbox 360', '2018-02-05'),
(12, 'Xbox One', '2018-02-05');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `Name`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` char(128) NOT NULL,
  `forename` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `approved` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dlc`
--
ALTER TABLE `dlc`
  ADD PRIMARY KEY (`dlc_id`) USING BTREE,
  ADD UNIQUE KEY `dlcname` (`dlcname`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `created_user_id` (`created_user_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`),
  ADD UNIQUE KEY `gamename` (`gamename`),
  ADD KEY `created_user_id` (`created_user_id`);

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`key_id`),
  ADD UNIQUE KEY `key` (`keycode`),
  ADD KEY `dlc_id` (`dlc_id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `platform_id` (`platform_id`),
  ADD KEY `created_user_id` (`created_user_id`),
  ADD KEY `owned_user` (`owned_user`);

--
-- Indexes for table `platforms`
--
ALTER TABLE `platforms`
  ADD PRIMARY KEY (`platform_id`),
  ADD UNIQUE KEY `platformname` (`platformname`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dlc`
--
ALTER TABLE `dlc`
  MODIFY `dlc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `key_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `platforms`
--
ALTER TABLE `platforms`
  MODIFY `platform_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `keys`
--
ALTER TABLE `keys`
  ADD CONSTRAINT `keys_ibfk_1` FOREIGN KEY (`dlc_id`) REFERENCES `dlc` (`dlc_id`),
  ADD CONSTRAINT `keys_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`),
  ADD CONSTRAINT `keys_ibfk_3` FOREIGN KEY (`platform_id`) REFERENCES `platforms` (`platform_id`),
  ADD CONSTRAINT `keys_ibfk_4` FOREIGN KEY (`created_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
