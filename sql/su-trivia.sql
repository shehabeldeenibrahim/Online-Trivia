-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2019 at 02:09 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

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
(1, 'name?', '2019-09-30', '2', '6', '0', 'ahmed', 'mostafa', 'Bobawy', 'Shixawy', '1'),
(2, 'bday?', '2019-09-30', '2', '7', '10', '1 - 1 - 2019', '2 - 1 - 2019', '3 - 1 - 2019', '4 - 1 - 2019', '2'),
(3, 'status?', '2019-09-30', '2', '8', '20', 'Single', 'Ready', 'To', 'Mingle', '3');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `oauth_provider` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `oauth_uid` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `lost` text COLLATE utf8_unicode_ci,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `oauth_provider`, `oauth_uid`, `first_name`, `last_name`, `lost`, `email`, `gender`, `locale`, `picture`, `link`, `created`, `modified`) VALUES
(957, 'google', '116035433708754087407', 'Shehab', 'Ebrahim', '1', 'shehabtarek@aucegypt.edu', 'male', 'en', 'https://lh6.googleusercontent.com/-6dRkPtZhGJw/AAAAAAAAAAI/AAAAAAAAAAA/ACHi3reP_P355COURSbeEvIE5Q3WrjY2tQ/photo.jpg', 'https://plus.google.com/116035433708754087407', '2019-09-25 23:22:40', '2019-09-30 02:06:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `timer`
--
ALTER TABLE `timer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=958;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
