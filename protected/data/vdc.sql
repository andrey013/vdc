-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 26, 2012 at 10:40 PM
-- Server version: 5.5.24-0ubuntu0.12.04.1
-- PHP Version: 5.3.10-1ubuntu3.4

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
-- Table structure for table `AuthAssignment`
--

CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `AuthAssignment`
--

INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('Admin', '1', NULL, 'N;'),
('Authenticated', '2', NULL, 'N;'),
('Guest', '2', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `AuthItem`
--

CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `AuthItem`
--

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('Admin', 2, NULL, NULL, 'N;'),
('Authenticated', 2, NULL, NULL, 'N;'),
('Guest', 2, NULL, NULL, 'N;'),
('Order.View', 0, NULL, NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `AuthItemChild`
--

CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Rights`
--

CREATE TABLE IF NOT EXISTS `Rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vdc_chromatisity`
--

CREATE TABLE IF NOT EXISTS `vdc_chromatisity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `vdc_customer`
--

CREATE TABLE IF NOT EXISTS `vdc_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vdc_density`
--

CREATE TABLE IF NOT EXISTS `vdc_density` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vdc_designer`
--

CREATE TABLE IF NOT EXISTS `vdc_designer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `designer_status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `client_id` (`client_id`),
  KEY `designer_status_id` (`designer_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vdc_designer_status`
--

CREATE TABLE IF NOT EXISTS `vdc_designer_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `key` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vdc_difficulty`
--

CREATE TABLE IF NOT EXISTS `vdc_difficulty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vdc_manager`
--

CREATE TABLE IF NOT EXISTS `vdc_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vdc_measure_unit`
--

CREATE TABLE IF NOT EXISTS `vdc_measure_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vdc_order`
--

CREATE TABLE IF NOT EXISTS `vdc_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_date` datetime NOT NULL,
  `global_number` int(11) NOT NULL,
  `client_number` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `manager_id` int(11) NOT NULL,
  `designer_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_type_id` int(11) NOT NULL,
  `difficulty_id` int(11) NOT NULL,
  `priority_id` int(11) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `chromaticity_id` int(11) DEFAULT NULL,
  `density_id` int(11) DEFAULT NULL,
  `size_x` int(11) DEFAULT NULL,
  `size_y` int(11) DEFAULT NULL,
  `measure_unit_id` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vdc_order_type`
--

CREATE TABLE IF NOT EXISTS `vdc_order_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vdc_payment`
--

CREATE TABLE IF NOT EXISTS `vdc_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `amount` int(11) NOT NULL,
  `designer_price` int(11) NOT NULL,
  `client_price` int(11) NOT NULL,
  `debt` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vdc_profiles`
--

CREATE TABLE IF NOT EXISTS `vdc_profiles` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `vdc_profiles`
--

INSERT INTO `vdc_profiles` (`user_id`, `lastname`, `firstname`) VALUES
(1, 'Admin', 'Administrator'),
(2, 'Demo', 'Demo');

-- --------------------------------------------------------

--
-- Table structure for table `vdc_profiles_fields`
--

CREATE TABLE IF NOT EXISTS `vdc_profiles_fields` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `vdc_profiles_fields`
--

INSERT INTO `vdc_profiles_fields` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
(1, 'lastname', 'Last Name', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
(2, 'firstname', 'First Name', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `vdc_user`
--

CREATE TABLE IF NOT EXISTS `vdc_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vdc_users`
--

CREATE TABLE IF NOT EXISTS `vdc_users` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `vdc_users`
--

INSERT INTO `vdc_users` (`id`, `username`, `password`, `email`, `activkey`, `create_at`, `lastvisit_at`, `superuser`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'webmaster@example.com', '9a24eff8c15a6a141ece27eb6947da0f', '2012-09-26 17:39:22', '2012-09-26 17:59:53', 1, 1),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@example.com', '099f825543f7850cc038b90aaff39fac', '2012-09-26 17:39:22', '0000-00-00 00:00:00', 0, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AuthAssignment`
--
ALTER TABLE `AuthAssignment`
  ADD CONSTRAINT `AuthAssignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `AuthItemChild`
--
ALTER TABLE `AuthItemChild`
  ADD CONSTRAINT `AuthItemChild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AuthItemChild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Rights`
--
ALTER TABLE `Rights`
  ADD CONSTRAINT `Rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vdc_designer`
--
ALTER TABLE `vdc_designer`
  ADD CONSTRAINT `vdc_designer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `vdc_user` (`id`),
  ADD CONSTRAINT `vdc_designer_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `vdc_client` (`id`),
  ADD CONSTRAINT `vdc_designer_ibfk_3` FOREIGN KEY (`designer_status_id`) REFERENCES `vdc_designer_status` (`id`);

--
-- Constraints for table `vdc_manager`
--
ALTER TABLE `vdc_manager`
  ADD CONSTRAINT `vdc_manager_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `vdc_user` (`id`),
  ADD CONSTRAINT `vdc_manager_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `vdc_client` (`id`);

--
-- Constraints for table `vdc_order`
--
ALTER TABLE `vdc_order`
  ADD CONSTRAINT `vdc_order_ibfk_10` FOREIGN KEY (`client_id`) REFERENCES `vdc_client` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_11` FOREIGN KEY (`measure_unit_id`) REFERENCES `vdc_measure_unit` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_2` FOREIGN KEY (`designer_id`) REFERENCES `vdc_designer` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_3` FOREIGN KEY (`manager_id`) REFERENCES `vdc_manager` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_4` FOREIGN KEY (`customer_id`) REFERENCES `vdc_customer` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_5` FOREIGN KEY (`order_type_id`) REFERENCES `vdc_order_type` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_6` FOREIGN KEY (`difficulty_id`) REFERENCES `vdc_difficulty` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_7` FOREIGN KEY (`priority_id`) REFERENCES `vdc_priority` (`id`),
  ADD CONSTRAINT `vdc_order_ibfk_8` FOREIGN KEY (`chromaticity_id`) REFERENCES `vdc_chromatisity` (`id`),
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
-- Constraints for table `vdc_profiles`
--
ALTER TABLE `vdc_profiles`
  ADD CONSTRAINT `user_profile_id` FOREIGN KEY (`user_id`) REFERENCES `vdc_users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
