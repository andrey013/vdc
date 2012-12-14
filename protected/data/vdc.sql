-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 24, 2012 at 08:45 PM
-- Server version: 5.5.27-0ubuntu2
-- PHP Version: 5.4.6-1ubuntu1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vdc`
--

-- --------------------------------------------------------

--
-- Table structure for table `vdc_AuthAssignment`
--

CREATE TABLE IF NOT EXISTS `vdc_AuthAssignment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemname` varchar(64) NOT NULL,
  `userid` int(11) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `itemname` (`itemname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `vdc_AuthAssignment`
--

INSERT INTO `vdc_AuthAssignment` (`id`, `itemname`, `userid`, `bizrule`, `data`) VALUES
(1, 'Admin', 1, NULL, 'N;'),
(3, 'Guest', 2, NULL, 'N;'),
(6, 'Manager', 3, NULL, 'N;'),
(7, 'Designer', 4, NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `vdc_AuthItem`
--

CREATE TABLE IF NOT EXISTS `vdc_AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vdc_AuthItem`
--

INSERT INTO `vdc_AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('Admin', 2, 'Администратор', NULL, 'N;'),
('Authenticated', 2, NULL, NULL, 'N;'),
('Designer', 2, 'Дизайнер', NULL, 'N;'),
('Guest', 2, NULL, NULL, 'N;'),
('Manager', 2, 'Менеджер', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `vdc_AuthItemChild`
--

CREATE TABLE IF NOT EXISTS `vdc_AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vdc_chromaticity`
--

CREATE TABLE IF NOT EXISTS `vdc_chromaticity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `vdc_chromaticity`
--

INSERT INTO `vdc_chromaticity` (`id`, `name`) VALUES
(1, '123'),
(2, '789'),
(3, '345'),
(4, '1');

-- --------------------------------------------------------

--
-- Table structure for table `vdc_client`
--

CREATE TABLE IF NOT EXISTS `vdc_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `vdc_client`
--

INSERT INTO `vdc_client` (`id`, `name`, `code`) VALUES
(0, 'Клин', 'kl');

-- --------------------------------------------------------

--
-- Table structure for table `vdc_comment`
--

CREATE TABLE IF NOT EXISTS `vdc_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(1024) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `thread` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`,`user_id`,`order_id`),
  KEY `user_id` (`user_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `vdc_comment`
--

INSERT INTO `vdc_comment` (`id`, `text`, `parent_id`, `thread`, `user_id`, `order_id`, `create_date`) VALUES
(24, '123', NULL, '01', 1, 22, '2012-10-23 20:17:28'),
(25, '12', 24, '01.00', 1, 22, '2012-10-23 20:17:30'),
(26, '3', 24, '01.01', 1, 22, '2012-10-23 20:17:34'),
(27, '1', 25, '01.00.00', 1, 22, '2012-10-23 20:17:38'),
(28, '2', 25, '01.00.01', 1, 22, '2012-10-23 20:17:42'),
(29, 'sdf dsf sdf  sgfdgsdg fd gfd g ds  вп ывп вы п  авыпавыпвадлоавлыдопдвы ывалплдвып  валдпоавдлы  ывалдпвбавыю.авыбп юав.ыав авыплоавып выапвы ваыпавыпва авкеу343 пав ', 28, '01.00.01.00', 1, 22, '2012-10-24 18:22:56'),
(30, '5', 29, '01.00.01.00.00', 1, 22, '2012-10-24 18:42:05'),
(31, '45', 30, '01.00.01.00.00.00', 1, 22, '2012-10-24 18:42:08'),
(32, '65', 31, '01.00.01.00.00.00.00', 1, 22, '2012-10-24 18:42:10'),
(33, 'tr', 32, '01.00.01.00.00.00.00.00', 1, 22, '2012-10-24 18:42:13'),
(34, '34', 33, '01.00.01.00.00.00.00.00.00', 1, 22, '2012-10-24 18:43:29'),
(35, 'rt', 34, '01.00.01.00.00.00.00.00.00.00', 1, 22, '2012-10-24 18:43:32'),
(36, '434', 34, '01.00.01.00.00.00.00.00.00.01', 1, 22, '2012-10-24 18:44:52'),
(37, 'fdgfdg', 34, '01.00.01.00.00.00.00.00.00.02', 1, 22, '2012-10-24 18:45:02'),
(38, '11111111', 29, '01.00.01.00.01', 1, 22, '2012-10-24 18:47:36'),
(39, '3443', NULL, '02', 4, 22, '2012-10-24 18:51:11'),
(40, '900', 24, '01.02', 4, 22, '2012-10-24 18:51:16'),
(41, '123 23\n545\n\n788', NULL, '01', 4, 23, '2012-10-24 19:59:10'),
(42, '56', NULL, '02', 4, 23, '2012-10-24 19:59:33'),
(43, 'fsdjshfds\n\ndfgsdfgfdsg\ndf\ndfgfdgfdgfdgfdgfdgfdgfdg\n\ndfgfdgfdgfdg\n\n\n\ndfggfgd', NULL, '03', 4, 23, '2012-10-24 20:10:48'),
(44, 'ret\n\nr', 43, '03.00', 4, 23, '2012-10-24 20:32:36');

-- --------------------------------------------------------

--
-- Table structure for table `vdc_customer`
--

CREATE TABLE IF NOT EXISTS `vdc_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `vdc_customer`
--

INSERT INTO `vdc_customer` (`id`, `name`) VALUES
(1, 'ddd'),
(2, 'qwe'),
(3, 'asdff'),
(4, '123'),
(5, '234'),
(6, '45463'),
(7, '45634'),
(8, '3543'),
(9, 'увцй'),
(10, '123'),
(11, '32432'),
(12, '456'),
(13, '4545'),
(14, 'asdffgfere'),
(15, 'ewrew'),
(16, '3243'),
(17, '324'),
(18, '4334'),
(19, 'qwertyuio dgfdgsfdfdg fdgfdg'),
(20, 'qwertyuio fdgfdg'),
(21, '34');

-- --------------------------------------------------------

--
-- Table structure for table `vdc_density`
--

CREATE TABLE IF NOT EXISTS `vdc_density` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `vdc_density`
--

INSERT INTO `vdc_density` (`id`, `name`) VALUES
(1, '123'),
(2, '098'),
(3, '2');

-- --------------------------------------------------------

--
-- Table structure for table `vdc_difficulty`
--

CREATE TABLE IF NOT EXISTS `vdc_difficulty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `vdc_difficulty`
--

INSERT INTO `vdc_difficulty` (`id`, `name`, `sort_order`) VALUES
(1, 'низкая', 1),
(2, 'средняя', 2),
(3, 'высокая', 3);

-- --------------------------------------------------------

--
-- Table structure for table `vdc_measure_unit`
--

CREATE TABLE IF NOT EXISTS `vdc_measure_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `vdc_measure_unit`
--

INSERT INTO `vdc_measure_unit` (`id`, `name`, `sort_order`) VALUES
(1, 'мм', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vdc_order`
--

CREATE TABLE IF NOT EXISTS `vdc_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_date` datetime NOT NULL,
  `global_number` int(11) NOT NULL,
  `client_number` varchar(20) NOT NULL,
  `client_id` int(11) NOT NULL,
  `manager_id` int(11) NOT NULL,
  `designer_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_type_id` int(11) NOT NULL,
  `difficulty_id` int(11) NOT NULL,
  `priority_id` int(11) NOT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `chromaticity_id` int(11) DEFAULT NULL,
  `density_id` int(11) DEFAULT NULL,
  `size_x` int(11) DEFAULT NULL,
  `size_y` int(11) DEFAULT NULL,
  `measure_unit_id` int(11) DEFAULT NULL,
  `text` text,
  `designer_paid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `manager_id` (`manager_id`),
  KEY `designer_id` (`designer_id`),
  KEY `customer_id` (`customer_id`),
  KEY `order_type_id` (`order_type_id`),
  KEY `difficulty_id` (`difficulty_id`),
  KEY `priority_id` (`priority_id`),
  KEY `chromaticity_id` (`chromaticity_id`),
  KEY `density_id` (`density_id`),
  KEY `measure_unit_id` (`measure_unit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `vdc_order`
--

INSERT INTO `vdc_order` (`id`, `create_date`, `global_number`, `client_number`, `client_id`, `manager_id`, `designer_id`, `customer_id`, `order_type_id`, `difficulty_id`, `priority_id`, `comment`, `chromaticity_id`, `density_id`, `size_x`, `size_y`, `measure_unit_id`, `text`, `designer_paid`) VALUES
(9, '2012-10-06 22:09:30', 70, '5678', 0, 3, 4, 5, 1, 1, 1, 'dfgs fdgsfg', NULL, NULL, NULL, NULL, 1, NULL, 0),
(10, '2012-10-06 22:11:32', 71, '565', 0, 3, 4, 6, 1, 1, 1, '45373', NULL, NULL, NULL, NULL, 1, NULL, 0),
(11, '2012-10-07 14:55:02', 93, '4564', 0, 3, 4, 7, 1, 1, 1, '43663', NULL, NULL, NULL, NULL, 1, NULL, 0),
(12, '2012-10-07 18:02:05', 95, '2432', 0, 3, 4, 8, 1, 1, 1, '345365', NULL, NULL, 90, 4, 1, NULL, 0),
(13, '2012-10-07 20:30:30', 98, '1231', 0, 3, 4, 9, 1, 1, 1, 'ыфпавыпавы', NULL, NULL, NULL, NULL, 1, NULL, 0),
(15, '2012-10-07 20:56:20', 101, '123', 0, 3, 4, 5, 1, 3, 2, '123', 2, 2, 345, 123, 1, NULL, 0),
(16, '2012-10-10 00:07:45', 145, '1234342', 0, 3, 4, 11, 1, 1, 1, '324324 и очень длинный комментарий продолжается дальше g g  jhgfjytryj  ty', 3, NULL, 12, 32, 1, '<p>dsfsdfs</p>', 0),
(18, '2012-10-20 15:50:03', 163, '123', 0, 3, 4, 15, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0),
(19, '2012-10-20 16:03:20', 164, '123', 0, 3, 4, 16, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0),
(20, '2012-10-20 16:04:40', 165, '123', 0, 3, 4, 17, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0),
(21, '2012-10-20 16:38:25', 166, '123', 0, 3, 4, 18, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0),
(22, '2012-10-21 17:13:36', 167, '23', 0, 3, 4, 20, 1, 2, 2, '123 234 456 876 908 ', 4, 3, 3, 4, 1, '<p>234324324234</p>', 0),
(23, '2012-10-21 19:24:02', 179, '23-цw', 0, 3, 4, 20, 1, 2, 2, '123 234 456 876 908 ', 4, 3, 3, 4, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vdc_order_status`
--

CREATE TABLE IF NOT EXISTS `vdc_order_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `key` varchar(30) NOT NULL,
  `color` varchar(30) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `vdc_order_status`
--

INSERT INTO `vdc_order_status` (`id`, `name`, `key`, `color`, `sort_order`) VALUES
(2, 'на утверждение', 'confirm', '', 1),
(3, 'в разработку', 'work', '', 2),
(4, 'согласовано', 'agreed', '', 3),
(5, 'изменения', 'changed', '', 4),
(6, 'отменено', 'cancelled', '', 5),
(7, 'приостановлено', 'paused', '', 6),
(8, 'готово', 'done', '', 7);

-- --------------------------------------------------------

--
-- Table structure for table `vdc_order_status_history`
--

CREATE TABLE IF NOT EXISTS `vdc_order_status_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `change_date` datetime NOT NULL,
  `order_status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `change_date` (`change_date`,`order_status_id`),
  KEY `order_id` (`order_id`),
  KEY `order_status_id` (`order_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `vdc_order_status_history`
--

INSERT INTO `vdc_order_status_history` (`id`, `order_id`, `change_date`, `order_status_id`) VALUES
(1, 9, '0000-00-00 00:00:00', 5),
(2, 10, '2012-10-06 22:11:43', 7),
(3, 11, '2012-10-07 15:26:18', 2),
(4, 12, '2012-10-07 18:02:18', 8),
(5, 13, '2012-10-07 20:30:47', 4),
(6, 15, '2012-10-07 21:04:44', 6),
(7, 16, '2012-10-10 00:08:03', 3),
(13, 16, '2012-10-10 22:44:14', 2),
(14, 16, '2012-10-10 22:44:29', 4),
(15, 16, '2012-10-10 22:44:39', 8),
(16, 16, '2012-10-20 12:04:16', 3),
(17, 18, '2012-10-20 15:51:00', 2),
(18, 19, '2012-10-20 16:04:30', 8),
(19, 20, '2012-10-20 16:05:01', 8),
(20, 21, '2012-10-20 16:38:42', 4),
(21, 9, '2012-10-20 17:48:43', 8),
(22, 10, '2012-10-21 15:54:49', 8),
(23, 10, '2012-10-21 16:00:58', 7),
(24, 10, '2012-10-21 16:01:03', 3),
(25, 10, '2012-10-21 16:01:10', 8),
(26, 11, '2012-10-21 16:15:45', 3),
(27, 11, '2012-10-21 16:15:55', 2),
(28, 18, '2012-10-21 16:16:17', 3),
(29, 18, '2012-10-21 16:16:25', 2),
(30, 21, '2012-10-21 16:58:34', 5),
(31, 18, '2012-10-21 17:07:46', 6),
(32, 22, '2012-10-21 17:14:11', 2),
(33, 22, '2012-10-21 18:51:03', 3),
(34, 22, '2012-10-21 18:55:57', 2),
(35, 22, '2012-10-21 19:09:26', 4),
(36, 23, '2012-10-21 19:24:06', 4);

-- --------------------------------------------------------

--
-- Table structure for table `vdc_order_type`
--

CREATE TABLE IF NOT EXISTS `vdc_order_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `vdc_order_type`
--

INSERT INTO `vdc_order_type` (`id`, `name`) VALUES
(1, 'афиша');

-- --------------------------------------------------------

--
-- Table structure for table `vdc_payment`
--

CREATE TABLE IF NOT EXISTS `vdc_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `designer_price` int(11) NOT NULL,
  `client_price` int(11) NOT NULL,
  `debt` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `vdc_payment`
--

INSERT INTO `vdc_payment` (`id`, `order_id`, `create_date`, `designer_price`, `client_price`, `debt`) VALUES
(1, 11, '2012-10-07 15:26:18', 0, 0, 1),
(2, 12, '2012-10-07 18:02:18', 100, 100, 1),
(3, 13, '2012-10-07 20:30:47', 5000, 10000, 1),
(4, 15, '2012-10-07 21:04:44', 12, 10000, 1),
(5, 15, '2012-10-08 21:35:19', 3, 10, 1),
(6, 15, '2012-10-08 21:35:22', 1, 20, 1),
(31, 15, '2012-10-08 21:38:55', 0, 0, 1),
(32, 15, '2012-10-08 23:10:32', 0, 0, 1),
(33, 16, '2012-10-10 00:08:03', 1000, 20000, 1),
(34, 16, '2012-10-10 20:22:35', 0, 0, 1),
(35, 16, '2012-10-10 22:32:30', 0, 0, 1),
(36, 16, '2012-10-20 14:16:36', 0, 0, 1),
(37, 16, '2012-10-20 14:16:37', 0, 0, 1),
(38, 18, '2012-10-20 15:51:00', 0, 0, 1),
(39, 19, '2012-10-20 16:04:30', 0, 0, 1),
(40, 21, '2012-10-20 16:38:42', 2, 100, 1),
(41, 10, '2012-10-21 16:01:27', 0, 0, 1),
(42, 22, '2012-10-21 17:14:11', 0, 70, 1),
(43, 23, '2012-10-21 19:24:06', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vdc_payment_history`
--

CREATE TABLE IF NOT EXISTS `vdc_payment_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_id` (`payment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `vdc_payment_history`
--

INSERT INTO `vdc_payment_history` (`id`, `payment_id`, `create_date`, `amount`) VALUES
(1, 4, '2012-10-10 00:00:00', 100),
(2, 4, '0000-00-00 00:00:00', 0),
(3, 4, '0000-00-00 00:00:00', 0),
(4, 4, '0000-00-00 00:00:00', 0),
(5, 5, '0000-00-00 00:00:00', 0),
(6, 5, '0000-00-00 00:00:00', 10),
(7, 4, '0000-00-00 00:00:00', 200),
(8, 6, '0000-00-00 00:00:00', 7000),
(9, 4, '0000-00-00 00:00:00', -70),
(10, 4, '2012-10-09 00:00:00', 1000),
(11, 4, '0000-00-00 00:00:00', 100),
(12, 4, '0000-00-00 00:00:00', 100),
(13, 4, '0000-00-00 00:00:00', 100),
(14, 4, '0000-00-00 00:00:00', -100),
(15, 4, '0000-00-00 00:00:00', 100),
(16, 5, '0000-00-00 00:00:00', 200),
(17, 33, '2012-10-02 00:00:00', 1000),
(18, 33, '2012-10-10 22:02:46', 200),
(19, 33, '2012-10-10 22:23:44', 2000),
(20, 34, '2012-10-10 22:30:51', 100),
(21, 34, '2012-10-10 22:30:53', 100),
(22, 34, '2012-10-10 22:30:55', 200),
(23, 34, '2012-10-10 22:30:57', 300),
(24, 34, '2012-10-10 22:30:59', 400),
(25, 34, '2012-10-10 22:31:01', 3),
(26, 34, '2012-10-10 22:31:02', 4),
(27, 34, '2012-10-10 22:31:04', 43),
(28, 34, '2012-10-10 22:31:06', 45),
(29, 34, '2012-10-10 22:31:07', 45),
(30, 34, '2012-10-10 22:31:08', 45),
(31, 34, '2012-10-10 22:31:10', 34),
(32, 34, '2012-10-10 22:31:11', 546),
(33, 34, '2012-10-10 22:31:14', 0),
(34, 34, '2012-10-10 22:31:14', 0),
(35, 34, '2012-10-10 22:31:26', 0),
(36, 34, '2012-10-10 22:31:27', 0),
(37, 34, '2012-10-10 22:31:29', 1),
(38, 34, '2012-10-10 22:31:30', 1),
(39, 34, '2012-10-10 22:31:31', 1),
(40, 34, '2012-10-10 22:31:32', 1),
(41, 34, '2012-10-10 22:31:33', 0),
(42, 34, '2012-10-10 22:31:34', 1),
(43, 34, '2012-10-10 22:31:35', 1),
(44, 34, '2012-10-10 22:31:36', 0),
(45, 34, '2012-10-10 22:31:37', 1),
(46, 34, '2012-10-10 22:31:38', 0),
(47, 34, '2012-10-10 22:31:39', 0),
(48, 34, '2012-10-10 22:31:40', 1),
(49, 34, '2012-10-10 22:31:41', 1),
(50, 34, '2012-10-10 22:31:42', 0),
(51, 34, '2012-10-10 22:31:43', 1),
(52, 42, '2012-10-21 18:41:34', 2);

-- --------------------------------------------------------

--
-- Table structure for table `vdc_price`
--

CREATE TABLE IF NOT EXISTS `vdc_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_type_id` int(11) NOT NULL,
  `difficulty_id` int(11) NOT NULL,
  `designer_price` int(11) NOT NULL,
  `client_price` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_type_id` (`order_type_id`,`difficulty_id`),
  KEY `difficulty_id` (`difficulty_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vdc_priority`
--

CREATE TABLE IF NOT EXISTS `vdc_priority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `code` varchar(10) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `vdc_priority`
--

INSERT INTO `vdc_priority` (`id`, `name`, `code`, `sort_order`) VALUES
(1, '1', '1', 1),
(2, '2', '2', 2),
(3, '3', '3', 3);

-- --------------------------------------------------------

--
-- Table structure for table `vdc_profile`
--

CREATE TABLE IF NOT EXISTS `vdc_profile` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `client_id` int(11) NOT NULL DEFAULT '0',
  `user_status_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `client_id` (`client_id`),
  KEY `user_status_id` (`user_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `vdc_profile`
--

INSERT INTO `vdc_profile` (`user_id`, `lastname`, `firstname`, `client_id`, `user_status_id`) VALUES
(1, 'Admin', 'Administrator', 0, 0),
(2, 'Demo', 'Demo', 0, 0),
(3, 'Лапшина', 'Ольга', 0, 0),
(4, 'Виктория К.', 'Виктория', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vdc_profiles_field`
--

CREATE TABLE IF NOT EXISTS `vdc_profiles_field` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` varchar(15) NOT NULL DEFAULT '0',
  `field_size_min` varchar(15) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` varchar(5000) NOT NULL DEFAULT '',
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` varchar(5000) NOT NULL DEFAULT '',
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`,`widget`,`visible`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `vdc_profiles_field`
--

INSERT INTO `vdc_profiles_field` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
(1, 'lastname', 'Last Name', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
(2, 'firstname', 'First Name', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3),
(3, 'client_id', 'Client', 'INTEGER', '11', '0', 1, '', '', '', '', '0', '', '', 3, 3),
(4, 'user_status_id', 'Status', 'INTEGER', '11', '0', 1, '', '', '', '', '0', '', '', 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `vdc_Rights`
--

CREATE TABLE IF NOT EXISTS `vdc_Rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vdc_user`
--

CREATE TABLE IF NOT EXISTS `vdc_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `vdc_user`
--

INSERT INTO `vdc_user` (`id`, `username`, `password`, `email`, `activkey`, `create_at`, `lastvisit_at`, `superuser`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'webmaster@example.com', '9a24eff8c15a6a141ece27eb6947da0f', '2012-09-26 17:39:22', '2012-10-07 10:55:00', 1, 1),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@example.com', 'c95fd44f19ccd98168ab255b455a485b', '2012-09-26 17:39:22', '2012-10-05 15:32:39', 0, 1),
(3, 'demo1', 'fe01ce2a7fbac8fafaed7c982a04e229', 'aaa@aaa.aaa', 'ab3b89f556462f2fe8c5d45aff819a9a', '2012-10-05 15:56:05', '0000-00-00 00:00:00', 0, 1),
(4, 'demo2', 'fe01ce2a7fbac8fafaed7c982a04e229', 'aaa1@aaa.aaa', 'a46788cf967476fc4624e2e9d28fd012', '2012-10-05 15:57:19', '0000-00-00 00:00:00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vdc_user_status`
--

CREATE TABLE IF NOT EXISTS `vdc_user_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `key` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `vdc_user_status`
--

INSERT INTO `vdc_user_status` (`id`, `name`, `key`) VALUES
(0, 'Занят', 'busy'),
(1, 'Свободен', 'free');

-- --------------------------------------------------------

--
-- Table structure for table `vdc_variables`
--

CREATE TABLE IF NOT EXISTS `vdc_variables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `max_global_number` int(11) NOT NULL,
  `prev_designer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `vdc_variables`
--

INSERT INTO `vdc_variables` (`id`, `max_global_number`, `prev_designer_id`) VALUES
(1, 181, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `vdc_AuthAssignment`
--
ALTER TABLE `vdc_AuthAssignment`
  ADD CONSTRAINT `vdc_AuthAssignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `vdc_AuthItem` (`name`),
  ADD CONSTRAINT `vdc_AuthAssignment_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `vdc_user` (`id`);

--
-- Constraints for table `vdc_AuthItemChild`
--
ALTER TABLE `vdc_AuthItemChild`
  ADD CONSTRAINT `vdc_AuthItemChild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `vdc_AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vdc_AuthItemChild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `vdc_AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vdc_comment`
--
ALTER TABLE `vdc_comment`
  ADD CONSTRAINT `vdc_comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `vdc_user` (`id`),
  ADD CONSTRAINT `vdc_comment_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `vdc_order` (`id`),
  ADD CONSTRAINT `vdc_comment_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `vdc_comment` (`id`);

--
-- Constraints for table `vdc_order`
--
ALTER TABLE `vdc_order`
  ADD CONSTRAINT `vdc_order_ibfk_11` FOREIGN KEY (`measure_unit_id`) REFERENCES `vdc_measure_unit` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_12` FOREIGN KEY (`client_id`) REFERENCES `vdc_client` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_13` FOREIGN KEY (`manager_id`) REFERENCES `vdc_user` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_14` FOREIGN KEY (`designer_id`) REFERENCES `vdc_user` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_4` FOREIGN KEY (`customer_id`) REFERENCES `vdc_customer` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_5` FOREIGN KEY (`order_type_id`) REFERENCES `vdc_order_type` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_6` FOREIGN KEY (`difficulty_id`) REFERENCES `vdc_difficulty` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_7` FOREIGN KEY (`priority_id`) REFERENCES `vdc_priority` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_8` FOREIGN KEY (`chromaticity_id`) REFERENCES `vdc_chromaticity` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_9` FOREIGN KEY (`density_id`) REFERENCES `vdc_density` (`id`);

--
-- Constraints for table `vdc_order_status_history`
--
ALTER TABLE `vdc_order_status_history`
  ADD CONSTRAINT `vdc_order_status_history_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `vdc_order` (`id`),
  ADD CONSTRAINT `vdc_order_status_history_ibfk_2` FOREIGN KEY (`order_status_id`) REFERENCES `vdc_order_status` (`id`);

--
-- Constraints for table `vdc_payment`
--
ALTER TABLE `vdc_payment`
  ADD CONSTRAINT `vdc_payment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `vdc_order` (`id`);

--
-- Constraints for table `vdc_payment_history`
--
ALTER TABLE `vdc_payment_history`
  ADD CONSTRAINT `vdc_payment_history_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `vdc_payment` (`id`);

--
-- Constraints for table `vdc_price`
--
ALTER TABLE `vdc_price`
  ADD CONSTRAINT `vdc_price_ibfk_1` FOREIGN KEY (`order_type_id`) REFERENCES `vdc_order_type` (`id`),
  ADD CONSTRAINT `vdc_price_ibfk_2` FOREIGN KEY (`difficulty_id`) REFERENCES `vdc_difficulty` (`id`);

--
-- Constraints for table `vdc_profile`
--
ALTER TABLE `vdc_profile`
  ADD CONSTRAINT `user_profile_id` FOREIGN KEY (`user_id`) REFERENCES `vdc_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vdc_profile_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `vdc_client` (`id`),
  ADD CONSTRAINT `vdc_profile_ibfk_2` FOREIGN KEY (`user_status_id`) REFERENCES `vdc_user_status` (`id`);

--
-- Constraints for table `vdc_Rights`
--
ALTER TABLE `vdc_Rights`
  ADD CONSTRAINT `vdc_Rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `vdc_AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
