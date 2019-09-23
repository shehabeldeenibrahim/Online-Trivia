-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2019 at 02:37 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `su-trivia`
--

-- --------------------------------------------------------

--
-- Table structure for table `timer`
--

CREATE TABLE `timer` (
  `id` int(11) NOT NULL,
  `question` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `h` varchar(20) NOT NULL,
  `m` varchar(20) NOT NULL,
  `s` varchar(20) NOT NULL,
  `Answer1` text NOT NULL,
  `Answer2` text NOT NULL,
  `Answer3` text NOT NULL,
  `Answer4` text NOT NULL,
  `CorrectAnswer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `timer`
--

INSERT INTO `timer` (`id`, `question`, `date`, `h`, `m`, `s`, `Answer1`, `Answer2`, `Answer3`, `Answer4`, `CorrectAnswer`) VALUES
(1, 'name?', '2019-09-23', '1', '30', '0', 'ahmed', 'mostafa', 'Bobawy', 'Shixawy', '1'),
(2, 'bday?', '2019-09-23', '1', '31', '10', '1 - 1 - 2019', '2 - 1 - 2019', '3 - 1 - 2019', '4 - 1 - 2019', '2'),
(3, 'status?', '2019-09-23', '1', '32', '20', 'Single', 'Ready', 'To', 'Mingle', '3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `timer`
--
ALTER TABLE `timer`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
