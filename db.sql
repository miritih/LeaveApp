-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 17, 2016 at 11:17 PM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `leave`
--

-- --------------------------------------------------------

--
-- Table structure for table `Agents`
--

CREATE TABLE IF NOT EXISTS `Agents` (
  `agent_ID` varchar(12) NOT NULL,
  `agent_Name` varchar(100) NOT NULL,
  `project_ID` int(11) NOT NULL,
  `gender` varchar(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`agent_ID`),
  KEY `project_ID` (`project_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Agents`
--

INSERT INTO `Agents` (`agent_ID`, `agent_Name`, `project_ID`, `gender`, `updated_at`, `created_at`) VALUES
('SSDC-151', 'ERIC MWENDA MIRITI ', 2, 'M', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('SSDC-152', 'VICTOR SANG', 2, '', '2016-01-17 20:14:20', '2016-01-17 20:14:20'),
('SSDC-153', 'IRENE KAMENE MUMBU', 2, 'F', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `leave`
--

CREATE TABLE IF NOT EXISTS `leave` (
  `leave_ID` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `agent_ID` varchar(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`leave_ID`),
  KEY `agent_ID` (`agent_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `leave`
--

INSERT INTO `leave` (`leave_ID`, `date`, `agent_ID`, `updated_at`, `created_at`) VALUES
(18, '2016-01-18', 'SSDC-151', '2016-01-17 19:26:43', '2016-01-17 19:26:43'),
(19, '2016-01-19', 'SSDC-151', '2016-01-17 19:27:00', '2016-01-17 19:27:00'),
(20, '2016-01-20', 'SSDC-151', '2016-01-17 19:27:16', '2016-01-17 19:27:16'),
(21, '2016-01-18', 'SSDC-153', '2016-01-17 19:27:32', '2016-01-17 19:27:32'),
(22, '2016-01-20', 'SSDC-153', '2016-01-17 19:27:45', '2016-01-17 19:27:45'),
(23, '2016-01-19', 'SSDC-153', '2016-01-17 19:28:36', '2016-01-17 19:28:36'),
(24, '2016-01-20', 'SSDC-152', '2016-01-17 20:15:07', '2016-01-17 20:15:07'),
(25, '2016-01-21', 'SSDC-152', '2016-01-17 20:15:40', '2016-01-17 20:15:40'),
(26, '2016-01-22', 'SSDC-152', '2016-01-17 20:15:46', '2016-01-17 20:15:46'),
(27, '2016-01-22', 'SSDC-151', '2016-01-17 20:15:56', '2016-01-17 20:15:56'),
(28, '2016-01-28', 'SSDC-151', '2016-01-17 20:16:13', '2016-01-17 20:16:13');

-- --------------------------------------------------------

--
-- Table structure for table `Projects`
--

CREATE TABLE IF NOT EXISTS `Projects` (
  `project_ID` int(11) NOT NULL,
  `project_Name` varchar(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`project_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Projects`
--

INSERT INTO `Projects` (`project_ID`, `project_Name`, `created_at`, `updated_at`) VALUES
(1, 'GAR1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'GAR2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'GAR3', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Agents`
--
ALTER TABLE `Agents`
  ADD CONSTRAINT `Agents_ibfk_1` FOREIGN KEY (`project_ID`) REFERENCES `Projects` (`project_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leave`
--
ALTER TABLE `leave`
  ADD CONSTRAINT `leave_ibfk_1` FOREIGN KEY (`agent_ID`) REFERENCES `Agents` (`agent_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
