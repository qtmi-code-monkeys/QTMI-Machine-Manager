-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2015 at 03:12 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hmi_plc_mgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` date NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(20) NOT NULL,
  `has_hc` varchar(10) NOT NULL,
  `has_fusion` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_machine`
--

CREATE TABLE IF NOT EXISTS `customer_machine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `machine_type` varchar(15) NOT NULL,
  `created_on` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `last_hmi_update` date NOT NULL,
  `current_hmi_file_id` int(11) NOT NULL,
  `current_hmi` varchar(255) DEFAULT NULL,
  `current_hmi_version` varchar(10) DEFAULT NULL,
  `current_hmi_ip` varchar(15) NOT NULL,
  `last_plc_update` date NOT NULL,
  `current_plc_file_id` int(11) NOT NULL,
  `current_plc` varchar(255) DEFAULT NULL,
  `current_plc_version` varchar(10) DEFAULT NULL,
  `current_plc_ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_machine_archive`
--

CREATE TABLE IF NOT EXISTS `customer_machine_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `machine_type` varchar(15) NOT NULL,
  `code_base` varchar(15) NOT NULL,
  `customer_machine_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `file_update` date NOT NULL,
  `file_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_version` varchar(10) DEFAULT NULL,
  `file_ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_machine_contacts`
--

CREATE TABLE IF NOT EXISTS `customer_machine_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_machine_id` int(11) NOT NULL,
  `c1_name` varchar(500) NOT NULL,
  `c1_number` varchar(500) NOT NULL,
  `c1_email` varchar(500) NOT NULL,
  `c2_name` varchar(500) NOT NULL,
  `c2_number` varchar(500) NOT NULL,
  `c2_email` varchar(500) NOT NULL,
  `c3_name` varchar(500) NOT NULL,
  `c3_number` varchar(500) NOT NULL,
  `c3_email` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_machine_error`
--

CREATE TABLE IF NOT EXISTS `customer_machine_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `created_on_date` date NOT NULL,
  `created_on_time` time NOT NULL,
  `type` varchar(30) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40475 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_machine_error_file_log`
--

CREATE TABLE IF NOT EXISTS `customer_machine_error_file_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `machine_type` varchar(10) DEFAULT NULL,
  `filename` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1649 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_machine_hours`
--

CREATE TABLE IF NOT EXISTS `customer_machine_hours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_machine_id` int(11) NOT NULL,
  `customer_machine_type` varchar(15) NOT NULL,
  `created_on` date NOT NULL,
  `turbo_on` int(11) NOT NULL,
  `water_chiller_run_time` int(11) NOT NULL,
  `glow_hydro_rp_on` int(11) NOT NULL,
  `dep_rp_on` int(11) NOT NULL,
  `dep_motor_run_time` int(11) NOT NULL,
  `rotation_motor_o_ring` int(11) NOT NULL,
  `glow_hydro_rp_oil_life_meter` int(11) NOT NULL,
  `dep_rough_pump_oil_life` int(11) NOT NULL,
  `lens_count` int(11) NOT NULL,
  `lens_count_setpoint` int(11) NOT NULL,
  `machine_on_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_machine_note`
--

CREATE TABLE IF NOT EXISTS `customer_machine_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` date NOT NULL,
  `machine_type` varchar(10) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `code_base` varchar(10) DEFAULT NULL,
  `created_by` varchar(200) NOT NULL,
  `division` varchar(200) NOT NULL,
  `note_subject` varchar(500) NOT NULL,
  `note` varchar(2000) DEFAULT NULL,
  `timeAdded` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=151 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_machine_note_pic`
--

CREATE TABLE IF NOT EXISTS `customer_machine_note_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_date` date NOT NULL,
  `customer_note_id` int(11) NOT NULL,
  `machine_type` varchar(10) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_machine_upgrade`
--

CREATE TABLE IF NOT EXISTS `customer_machine_upgrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` date NOT NULL,
  `machine_type` varchar(10) DEFAULT NULL,
  `created_by` varchar(200) NOT NULL,
  `upgrade_subject` varchar(500) NOT NULL,
  `upgrade` varchar(500) DEFAULT NULL,
  `timeAdded` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `machine_note`
--

CREATE TABLE IF NOT EXISTS `machine_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` date NOT NULL,
  `machine_type` varchar(10) DEFAULT NULL,
  `code_base` varchar(10) DEFAULT NULL,
  `created_by` varchar(200) NOT NULL,
  `division` varchar(200) NOT NULL,
  `note` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `machine_note_pic`
--

CREATE TABLE IF NOT EXISTS `machine_note_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_date` date NOT NULL,
  `note_id` int(11) NOT NULL,
  `machine_type` varchar(10) DEFAULT NULL,
  `code_base` varchar(10) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `machine_upgrade_linker`
--

CREATE TABLE IF NOT EXISTS `machine_upgrade_linker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` date NOT NULL,
  `timeAdded` time NOT NULL,
  `machine_type` varchar(10) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `upgrade_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `my_last_machine_note`
--

CREATE TABLE IF NOT EXISTS `my_last_machine_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` date NOT NULL,
  `machine_type` varchar(10) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `code_base` varchar(10) DEFAULT NULL,
  `created_by` varchar(200) NOT NULL,
  `division` varchar(200) NOT NULL,
  `note_subject` varchar(500) NOT NULL,
  `note` varchar(500) DEFAULT NULL,
  `timeAdded` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `my_last_machine_upgrade`
--

CREATE TABLE IF NOT EXISTS `my_last_machine_upgrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` date NOT NULL,
  `machine_type` varchar(10) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `code_base` varchar(10) DEFAULT NULL,
  `created_by` varchar(200) NOT NULL,
  `upgrade_subject` varchar(500) NOT NULL,
  `upgrade` varchar(500) DEFAULT NULL,
  `timeAdded` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `saved_file`
--

CREATE TABLE IF NOT EXISTS `saved_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_date` date NOT NULL,
  `machine_type` varchar(10) DEFAULT NULL,
  `code_base` varchar(10) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `description_of_changes` varchar(1000) DEFAULT NULL,
  `release_type` varchar(10) DEFAULT NULL,
  `version` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=134 ;

-- --------------------------------------------------------

--
-- Table structure for table `system_rev`
--

CREATE TABLE IF NOT EXISTS `system_rev` (
  `full_rev` int(11) NOT NULL,
  `inc_rev` int(11) NOT NULL,
  `machine_type` varchar(10) NOT NULL,
  `code_base` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
