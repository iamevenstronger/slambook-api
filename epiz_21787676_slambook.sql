-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 09, 2018 at 06:42 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_21787676_slambook`
--

-- --------------------------------------------------------

--
-- Table structure for table `slampages`
--

CREATE TABLE `slampages` (
  `uid` varchar(36) NOT NULL,
  `spid` varchar(36) NOT NULL,
  `slamname` varchar(36) NOT NULL,
  `slamdescription` text NOT NULL,
  `content` text NOT NULL,
  `createdat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deletedat` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `slamwrites`
--

CREATE TABLE `slamwrites` (
  `swid` varchar(36) NOT NULL,
  `spid` varchar(36) NOT NULL,
  `uid` varchar(36) DEFAULT NULL,
  `content` text NOT NULL,
  `createdat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deletedat` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `uid` varchar(36) NOT NULL,
  `username` varchar(36) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `token` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `slampages`
--
ALTER TABLE `slampages`
  ADD PRIMARY KEY (`spid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `slamwrites`
--
ALTER TABLE `slamwrites`
  ADD PRIMARY KEY (`swid`),
  ADD KEY `spid` (`spid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `slampages`
--
ALTER TABLE `slampages`
  ADD CONSTRAINT `slampages_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `userdata` (`uid`);

--
-- Constraints for table `slamwrites`
--
ALTER TABLE `slamwrites`
  ADD CONSTRAINT `fk_spid` FOREIGN KEY (`spid`) REFERENCES `slampages` (`spid`) ON DELETE CASCADE,
  ADD CONSTRAINT `slamwrites_ibfk_1` FOREIGN KEY (`spid`) REFERENCES `slampages` (`spid`),
  ADD CONSTRAINT `slamwrites_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `userdata` (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
