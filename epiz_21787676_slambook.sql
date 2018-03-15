-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2018 at 08:21 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

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
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slampages`
--

INSERT INTO `slampages` (`uid`, `spid`, `slamname`, `slamdescription`, `content`) VALUES
('37327314-08ef-4a4d-b311-0183061b9182', '414f4082-2822-11e8-99d8-c89cdca46351', 'haribalaji', 'Its is for test', '{\"customfields\": [\"age\",\"fname\",\"mname\"]}'),
('37327314-08ef-4a4d-b311-0183061b9182', 'e4dee299-0ad9-4a05-838c-fa71e7f3968f', 'haribalaji', 'tst desc', '{\"customfields\": [\"age\",\"fname\",\"mname\"]}');

-- --------------------------------------------------------

--
-- Table structure for table `slamwrites`
--

CREATE TABLE `slamwrites` (
  `swid` varchar(36) NOT NULL,
  `spid` varchar(36) NOT NULL,
  `uid` varchar(36) DEFAULT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slamwrites`
--

INSERT INTO `slamwrites` (`swid`, `spid`, `uid`, `content`) VALUES
('66a8e303-2822-11e8-99d8-c89cdca46351', '414f4082-2822-11e8-99d8-c89cdca46351', '37327314-08ef-4a4d-b311-0183061b9182', '{\"nickname\":\"hari\",\"first meet\":\"bus\",\"first fight\":\"cllg\",\"Tell me about something\":\"goodguy\",\"link dedicated to me\":\"http://google.com\",\"your location\":{\"long\":234.43,\"lat\":23.443},\"customfields\":{\"age\":\"21\",\"fname\":\"ravi\",\"mname\":\"sasi\"}}');

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
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`uid`, `username`, `email`, `password`, `token`, `status`) VALUES
('37327314-08ef-4a4d-b311-0183061b9182', 'haribalaji', 'haribalajiravi@gmail.com', 'password', 'b3cfac8f-cdb5-4b0b-84a5-b307a7376c32', '');

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
  ADD CONSTRAINT `slamwrites_ibfk_1` FOREIGN KEY (`spid`) REFERENCES `slampages` (`spid`),
  ADD CONSTRAINT `slamwrites_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `userdata` (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
