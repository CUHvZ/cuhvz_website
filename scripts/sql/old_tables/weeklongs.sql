-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 27, 2019 at 05:01 PM
-- Server version: 10.1.38-MariaDB-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cuhvmiwg_hvz`
--

-- --------------------------------------------------------

--
-- Table structure for table `weeklongs`
--

CREATE TABLE `weeklongs` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `display_dates` varchar(255) NOT NULL,
  `active` int(5) DEFAULT '0',
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weeklongs`
--

INSERT INTO `weeklongs` (`id`, `name`, `title`, `display_dates`, `active`, `start_date`, `end_date`) VALUES
(1, 'weeklongF18', 'Close Encounters of the Undead Kind', 'September 24th - 28th', 0, '2018-09-24 13:00:00', '2018-09-28 21:00:00'),
(2, 'weeklongF17', 'Lovecraft', 'November 12th - 16th', 0, '2017-11-12 16:00:00', '2017-11-20 00:00:00'),
(3, 'weeklongS17', 'Souljourn Preamble', 'March 20th - 24th', 0, '2017-04-20 15:00:00', '2017-03-24 23:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `weeklongs`
--
ALTER TABLE `weeklongs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `weeklongs`
--
ALTER TABLE `weeklongs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
