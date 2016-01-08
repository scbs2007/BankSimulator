-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 04, 2011 at 09:47 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbbanksimulator`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_details`
--

CREATE TABLE IF NOT EXISTS `tbl_customer_details` (
  `cust_id` int(15) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(15) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`cust_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_customer_details`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_manager_details`
--

CREATE TABLE IF NOT EXISTS `tbl_manager_details` (
  `man_id` int(15) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `full_name` varchar(15) NOT NULL,
  PRIMARY KEY (`man_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_manager_details`
--

INSERT INTO `tbl_manager_details` (`man_id`, `username`, `password`, `full_name`) VALUES
(1, 'manager', '123456789', 'A.S.Bose');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teller_details`
--

CREATE TABLE IF NOT EXISTS `tbl_teller_details` (
  `tell_id` int(15) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `full_name` varchar(15) NOT NULL,
  PRIMARY KEY (`tell_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_teller_details`
--

INSERT INTO `tbl_teller_details` (`tell_id`, `username`, `password`, `full_name`) VALUES
(1, 'teller1', '123456789', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transactions`
--

CREATE TABLE IF NOT EXISTS `tbl_transactions` (
  `trans_id` int(15) NOT NULL AUTO_INCREMENT,
  `trans_date` varchar(15) NOT NULL,
  `debit_credit` char(1) NOT NULL,
  `trans_amount` int(15) NOT NULL,
  `cust_id` int(15) NOT NULL,
  `modifier` char(1) NOT NULL,
  `modifier_id` int(15) NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_transactions`
--

