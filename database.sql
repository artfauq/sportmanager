-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Client :  db644889029.db.1and1.com
-- Généré le :  Lun 04 Juin 2018 à 22:31
-- Version du serveur :  5.5.60-0+deb7u1-log
-- Version de PHP :  5.4.45-0+deb7u14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `db644889029`
--

-- --------------------------------------------------------

--
-- Structure de la table `bonds`
--

CREATE TABLE IF NOT EXISTS `bonds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` char(36) NOT NULL,
  `member2_id` char(36) NOT NULL,
  `trusted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bonds_id1_idx` (`member_id`),
  KEY `bonds_id2_idx` (`member2_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `contests`
--

CREATE TABLE IF NOT EXISTS `contests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `type` varchar(45) NOT NULL,
  `description` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` char(36) NOT NULL,
  `serial` varchar(45) NOT NULL,
  `description` varchar(45) NOT NULL,
  `trusted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `devices_id1_idx` (`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `devices`
--

INSERT INTO `devices` (`id`, `member_id`, `serial`, `description`, `trusted`) VALUES
(1, '56eb38a4-ee50-421f-bf6e-26beb38f37ff', 'serial123', 'premier device validÃ©', 1),
(2, '56eb38a4-ee50-421f-bf6e-26beb38f37ff', 'serial456', 'second device pas encore validÃ©', 0);

-- --------------------------------------------------------

--
-- Structure de la table `earnings`
--

CREATE TABLE IF NOT EXISTS `earnings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` char(36) NOT NULL,
  `sticker_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `earnings_id1_idx` (`member_id`),
  KEY `earnings_id2_idx` (`sticker_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `earnings`
--

INSERT INTO `earnings` (`id`, `member_id`, `sticker_id`, `date`) VALUES
(1, '57c28a18-f7a8-4d2b-b021-74f7d4e31826', 1, '2016-08-28 08:52:08'),
(2, '58932165-d574-4526-bcb0-0b9ed4e31826', 1, '2017-02-02 13:09:09'),
(3, '57c28a18-f7a8-4d2b-b021-74f7d4e31826', 13, '2017-02-02 13:26:34'),
(4, '58932165-d574-4526-bcb0-0b9ed4e31826', 2, '2017-02-02 13:29:33'),
(5, '58932165-d574-4526-bcb0-0b9ed4e31826', 8, '2017-02-02 13:29:33'),
(6, '5893267e-6090-4280-96d8-737ed4e31826', 1, '2017-02-02 13:30:54'),
(7, '58932165-d574-4526-bcb0-0b9ed4e31826', 13, '2017-02-14 19:03:31'),
(8, '57c28a18-f7a8-4d2b-b021-74f7d4e31826', 2, '2017-06-13 16:49:51'),
(9, '57c28a18-f7a8-4d2b-b021-74f7d4e31826', 7, '2017-06-13 16:49:51'),
(10, '596b4a0f-4a5c-4d42-819c-118fd4e31826', 1, '2017-07-16 13:12:15'),
(11, '5aac07f3-f798-421a-a2ce-3f78d4e31826', 1, '2018-03-16 19:07:47'),
(12, '5aac0831-1ad8-4e53-89f0-5048d4e31826', 1, '2018-03-16 19:08:49');

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` char(36) NOT NULL,
  `workout_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `location_latitude` float NOT NULL,
  `location_logitude` float NOT NULL,
  `log_type` varchar(45) NOT NULL,
  `log_value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `logs_id1_idx` (`member_id`),
  KEY `logs_id2_idx` (`workout_id`),
  KEY `logs_id3_idx` (`device_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `logs`
--

INSERT INTO `logs` (`id`, `member_id`, `workout_id`, `device_id`, `date`, `location_latitude`, `location_logitude`, `log_type`, `log_value`) VALUES
(1, '56eb38a4-ee50-421f-bf6e-26beb38f37ff', 1, 1, '2016-03-13 08:16:00', 48.49, 2.26, 'Pas couru', 2640),
(2, '56eb38a4-ee50-421f-bf6e-26beb38f37ff', 1, 1, '2016-03-13 07:11:00', 48.49, 2.26, 'Pompes', 74);

-- --------------------------------------------------------

--
-- Structure de la table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` char(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `members`
--

INSERT INTO `members` (`id`, `email`, `password`) VALUES
('56eb38a4-ee50-421f-bf6e-26beb38f37ff', 'user1@test.fr', 'pass'),
('56eb38b4-04b0-4667-ba54-0796b38f37ff', 'user2@test.fr', 'pass'),
('56eb38c1-e384-48c1-a0bc-33f1b38f37ff', 'user3@test.fr', 'pass'),
('57c28a18-f7a8-4d2b-b021-74f7d4e31826', 'arthurfauquenot@yahoo.com', 'ff4e264a0f555fa1cf711cd11ba958c4b65aa6e6'),
('58932165-d574-4526-bcb0-0b9ed4e31826', 'arthurfauquenot@gmail.com', '47cf6f5678b87ec18ca4545ee444269df192a798'),
('5893267e-6090-4280-96d8-737ed4e31826', 'email@test.com', '87974e3d1866467fc34502042b89329d15e5da15'),
('596b4a0f-4a5c-4d42-819c-118fd4e31826', 'adeklosolomon@gmail.com', '491c47586f666c22936df3357ff110540ebc964d'),
('5aac07f3-f798-421a-a2ce-3f78d4e31826', 'rajr97333@gmail.com', '92def1b3f87ded6f469859892c5e5e26ca97f36c'),
('5aac0831-1ad8-4e53-89f0-5048d4e31826', 'rajr97555@gmail.com', '338bccc7ba7dee9c4a8b6636367dcc05996d6cff');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` char(36) NOT NULL,
  `member2_id` char(36) NOT NULL,
  `date` datetime NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `read` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_id1_idx` (`member_id`),
  KEY `messages_id2_idx` (`member2_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `stickers`
--

CREATE TABLE IF NOT EXISTS `stickers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `stickers`
--

INSERT INTO `stickers` (`id`, `name`, `description`) VALUES
(1, 'First Connection', 'You are now a full member of Sport Manager !'),
(2, 'First Workout', 'Congratulations for you very first workout !'),
(3, 'First Log', 'You have just saved your first log !'),
(4, 'Connected Device', 'You can now send logs from a connected object !'),
(5, 'Tenth Workout', 'Don''t stop me now !'),
(6, 'Top 1', 'Killer Queen ! You are or have been first in a ranking !'),
(7, 'First Workout - 100m hurdles', 'You have just finished your first workout of 100m hurdles !'),
(8, 'First Workout - Beer Pong', 'You have just finished your first workout of beer pong !'),
(9, 'First Workout - Cricket', 'You have just finished your first workout of cricket !'),
(10, 'First Workout - Quidditch', 'You have just finished your first workout of quidditch !'),
(11, 'First Workout - Soccer', 'You have just finished your first workout of soccer !'),
(12, 'First Workout - Tennis', ' You have just finished your first workout of tennis !'),
(13, '24h Member', ' It''s already been one day since your registration !');

-- --------------------------------------------------------

--
-- Structure de la table `workouts`
--

CREATE TABLE IF NOT EXISTS `workouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` char(36) NOT NULL,
  `date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `location_name` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `sport` varchar(45) NOT NULL,
  `contest_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_id_idx` (`member_id`),
  KEY `sessions_id1_idx` (`contest_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `workouts`
--

INSERT INTO `workouts` (`id`, `member_id`, `date`, `end_date`, `location_name`, `description`, `sport`, `contest_id`) VALUES
(1, '56eb38a4-ee50-421f-bf6e-26beb38f37ff', '2016-03-13 06:00:00', '2016-03-13 09:00:00', 'Paris - Vincennes', 'SÃ©ance du dimanche matin', 'Course', NULL),
(2, '56eb38a4-ee50-421f-bf6e-26beb38f37ff', '2017-04-30 10:00:00', '2017-04-30 11:00:00', 'Paris - buttes chaumont', 'SÃ©ance prÃ©vue', 'Entrainement', NULL),
(3, '58932165-d574-4526-bcb0-0b9ed4e31826', '2017-02-02 16:00:00', '2017-02-02 17:00:00', 'Home', 'Record du monde !', 'Beer Pong', NULL),
(4, '57c28a18-f7a8-4d2b-b021-74f7d4e31826', '2017-06-09 00:30:00', '2017-06-09 04:00:00', 'df', 'fsdfs', '100m hurdles', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
