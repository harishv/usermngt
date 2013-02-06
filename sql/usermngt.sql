-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 06, 2013 at 09:51 AM
-- Server version: 5.5.29
-- PHP Version: 5.4.6-1ubuntu1.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `usermngt`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `field_types`
--

CREATE TABLE IF NOT EXISTS `field_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(225) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `field_types`
--

INSERT INTO `field_types` (`id`, `name`, `description`) VALUES
(1, 'Numeric', 'Numeric Data'),
(2, 'String', 'String Data'),
(3, 'Date', 'Date Types');

-- --------------------------------------------------------

--
-- Table structure for table `login_users`
--

CREATE TABLE IF NOT EXISTS `login_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_from` varchar(20) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` datetime NOT NULL,
  `modified_from` varchar(20) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `login_users`
--

INSERT INTO `login_users` (`user_id`, `email`, `password`, `first_name`, `last_name`, `type_id`, `status_id`, `created_at`, `created_from`, `created_by`, `modified_at`, `modified_from`, `modified_by`) VALUES
(1, 'superadmin@gmail.com', 'e99a18c428cb38d5f260853678922e03', 'Super', 'Administrator', 1, 1, '2012-03-15 18:40:39', '192.168.30.211', 1, '2012-03-15 18:40:39', '192.168.30.211', 1);

-- --------------------------------------------------------

--
-- Table structure for table `standard_user_fields`
--

CREATE TABLE IF NOT EXISTS `standard_user_fields` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('0','1','2') NOT NULL,
  `description` varchar(50) NOT NULL,
  `field_type_id` int(11) NOT NULL,
  `mandatory` enum('0','1') NOT NULL,
  PRIMARY KEY (`field_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `standard_user_fields`
--

INSERT INTO `standard_user_fields` (`field_id`, `status`, `description`, `field_type_id`, `mandatory`) VALUES
(1, '1', 'First Name', 2, '1'),
(2, '1', 'Last Name', 2, '0'),
(3, '2', 'Middle Name', 1, '0'),
(4, '1', 'Date of Birth', 3, '0'),
(5, '1', 'Address', 2, '1'),
(6, '1', 'abc', 2, '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` varchar(225) NOT NULL,
  `status` enum('0','1','2') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `field_id`, `value`, `status`) VALUES
(1, 1, 1, 'Harish', '1'),
(2, 1, 2, 'Varada', '1'),
(3, 2, 1, 'Gouthami', '1'),
(4, 1, 5, 'rtererertr', '1'),
(5, 2, 2, 'last', '1'),
(6, 2, 5, 'sdsdss', '1'),
(11, 3, 2, 'Test Last', '1'),
(10, 3, 1, 'Test First', '1'),
(12, 3, 5, 'rterer', '1'),
(13, 4, 1, 'fname', '1'),
(14, 4, 2, 'lname', '1'),
(15, 4, 5, 'epping', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
