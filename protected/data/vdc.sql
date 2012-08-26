-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 26, 2012 at 12:38 PM
-- Server version: 5.5.24-0ubuntu0.12.04.1
-- PHP Version: 5.3.10-1ubuntu3.2

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
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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

--
-- Constraints for dumped tables
--

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
