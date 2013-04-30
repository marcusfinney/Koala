-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 21, 2013 at 01:36 AM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Koala`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admins`
--

CREATE TABLE IF NOT EXISTS `Admins` (
  `idadmins` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `tele` varchar(20) NOT NULL,
  `address` tinytext NOT NULL,
  `age` int(5) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `association` int(5) NOT NULL,
  PRIMARY KEY (`idadmins`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Admins`
--

INSERT INTO `Admins` (`idadmins`, `firstname`, `lastname`, `email`, `tele`, `address`, `age`, `username`, `password`, `gender`, `association`) VALUES
(1, 'John', 'Smith', 'jsmith@gmail.com', '4803953360', '1616 E La Jolla', 30, 'admin', '44', 'male', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Doctors`
--

CREATE TABLE IF NOT EXISTS `Doctors` (
  `iddoctor` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `tele` varchar(20) NOT NULL,
  `address` tinytext NOT NULL,
  `age` int(5) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `association` int(5) NOT NULL,
  PRIMARY KEY (`iddoctor`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Doctors`
--

INSERT INTO `Doctors` (`iddoctor`, `firstname`, `lastname`, `email`, `tele`, `address`, `age`, `username`, `password`, `gender`, `association`) VALUES
(1, 'Marcus', 'Finney', 'marcusfinney@gmail.com', '7343589617', '3721 S Dennis', 20, 'marcusfinney', '10', 'male', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Messages`
--

CREATE TABLE IF NOT EXISTS `Messages` (
  `iddoctor` int(11) NOT NULL,
  `idpatient` int(11) NOT NULL,
  `dateandtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Messages`
--


-- --------------------------------------------------------

--
-- Table structure for table `Notes`
--

CREATE TABLE IF NOT EXISTS `Notes` (
  `iddoctor` int(11) NOT NULL,
  `idnurse` int(11) NOT NULL,
  `idpatient` int(11) NOT NULL,
  `note` text NOT NULL,
  `timeanddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `Nurses`
--

CREATE TABLE IF NOT EXISTS `Nurses` (
  `idnurse` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `tele` varchar(20) NOT NULL,
  `address` varchar(40) NOT NULL,
  `association` int(5) NOT NULL,
  `age` int(5) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  PRIMARY KEY (`idnurse`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Nurses`
--

INSERT INTO `Nurses` (`idnurse`, `firstname`, `lastname`, `email`, `tele`, `address`, `association`, `age`, `username`, `password`, `gender`) VALUES
(1, 'Kristen', 'Wooster', 'kwooster1@gmail.com', '7346464630', '11403 tall shadows', 2, 20, 'kwooster', '10', 'female');

-- --------------------------------------------------------

--
-- Table structure for table `Patients`
--

CREATE TABLE IF NOT EXISTS `Patients` (
  `iddoctor` int(11) NOT NULL,
  `idnurse` int(11) NOT NULL,
  `idpatient` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `tele` varchar(20) NOT NULL,
  `address` varchar(40) NOT NULL,
  `age` int(5) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `association` int(5) NOT NULL,
  PRIMARY KEY (`idpatient`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Patients`
--

INSERT INTO `Patients` (`iddoctor`, `idnurse`, `idpatient`, `firstname`, `lastname`, `email`, `tele`, `address`, `age`, `username`, `password`, `gender`, `association`) VALUES
(1, 1, 1, 'Timmy', 'Finney', 'tfinney1@gmail.com', '7343589617', '', 1, 'tfinney', '10', 'male', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Vitals`
--

CREATE TABLE IF NOT EXISTS `Vitals` (
  `iddoctor` int(11) NOT NULL,
  `idnurse` int(11) NOT NULL,
  `idpatient` int(11) NOT NULL,
  `timeofday` int(10) NOT NULL,
  `timeanddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `heartrate` float NOT NULL,
  `bloodsugar` float NOT NULL,
  `bloodpressure` float NOT NULL,
  `weight` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Vitals`
--

