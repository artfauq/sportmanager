-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 18, 2016 at 12:20 AM
-- Server version: 5.6.28-0ubuntu0.15.10.1
-- PHP Version: 5.6.11-1ubuntu3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportmanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `bonds`
--

CREATE TABLE IF NOT EXISTS `bonds` (
  `id` int(11) NOT NULL,
  `member_id` char(36) NOT NULL,
  `member2_id` char(36) NOT NULL,
  `trusted` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contests`
--

CREATE TABLE IF NOT EXISTS `contests` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `type` varchar(45) NOT NULL,
  `description` varchar(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
  `id` int(11) NOT NULL,
  `member_id` char(36) NOT NULL,
  `serial` varchar(45) NOT NULL,
  `description` varchar(45) NOT NULL,
  `trusted` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `member_id`, `serial`, `description`, `trusted`) VALUES
(1, '56eb38a4-ee50-421f-bf6e-26beb38f37ff', 'serial123', 'premier device validÃ©', 1),
(2, '56eb38a4-ee50-421f-bf6e-26beb38f37ff', 'serial456', 'second device pas encore validÃ©', 0);

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE IF NOT EXISTS `earnings` (
  `id` int(11) NOT NULL,
  `member_id` char(36) NOT NULL,
  `sticker_id` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL,
  `member_id` char(36) NOT NULL,
  `workout_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `location_latitude` float NOT NULL,
  `location_logitude` float NOT NULL,
  `log_type` varchar(45) NOT NULL,
  `log_value` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `member_id`, `workout_id`, `device_id`, `date`, `location_latitude`, `location_logitude`, `log_type`, `log_value`) VALUES
(1, '56eb38a4-ee50-421f-bf6e-26beb38f37ff', 1, 1, '2016-03-13 08:16:00', 48.49, 2.26, 'Pas couru', 2640),
(2, '56eb38a4-ee50-421f-bf6e-26beb38f37ff', 1, 1, '2016-03-13 07:11:00', 48.49, 2.26, 'Pompes', 74);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` char(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `email`, `password`) VALUES
('56eb38a4-ee50-421f-bf6e-26beb38f37ff', 'user1@test.fr', 'pass'),
('56eb38b4-04b0-4667-ba54-0796b38f37ff', 'user2@test.fr', 'pass'),
('56eb38c1-e384-48c1-a0bc-33f1b38f37ff', 'user3@test.fr', 'pass');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL,
  `member_id` char(36) NOT NULL,
  `member2_id` char(36) NOT NULL,
  `date` datetime NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `read` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stickers`
--

CREATE TABLE IF NOT EXISTS `stickers` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `workouts`
--

CREATE TABLE IF NOT EXISTS `workouts` (
  `id` int(11) NOT NULL,
  `member_id` char(36) NOT NULL,
  `date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `location_name` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `sport` varchar(45) NOT NULL,
  `contest_id` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workouts`
--

INSERT INTO `workouts` (`id`, `member_id`, `date`, `end_date`, `location_name`, `description`, `sport`, `contest_id`) VALUES
(1, '56eb38a4-ee50-421f-bf6e-26beb38f37ff', '2016-03-13 06:00:00', '2016-03-13 09:00:00', 'Paris - Vincennes', 'SÃ©ance du dimanche matin', 'Course', NULL),
(2, '56eb38a4-ee50-421f-bf6e-26beb38f37ff', '2017-04-30 10:00:00', '2017-04-30 11:00:00', 'Paris - buttes chaumont', 'SÃ©ance prÃ©vue', 'Entrainement', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bonds`
--
ALTER TABLE `bonds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bonds_id1_idx` (`member_id`),
  ADD KEY `bonds_id2_idx` (`member2_id`);

--
-- Indexes for table `contests`
--
ALTER TABLE `contests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devices_id1_idx` (`member_id`);

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `earnings_id1_idx` (`member_id`),
  ADD KEY `earnings_id2_idx` (`sticker_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `logs_id1_idx` (`member_id`),
  ADD KEY `logs_id2_idx` (`workout_id`),
  ADD KEY `logs_id3_idx` (`device_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_id1_idx` (`member_id`),
  ADD KEY `messages_id2_idx` (`member2_id`);

--
-- Indexes for table `stickers`
--
ALTER TABLE `stickers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workouts`
--
ALTER TABLE `workouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_id_idx` (`member_id`),
  ADD KEY `sessions_id1_idx` (`contest_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bonds`
--
ALTER TABLE `bonds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contests`
--
ALTER TABLE `contests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stickers`
--
ALTER TABLE `stickers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `workouts`
--
ALTER TABLE `workouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;