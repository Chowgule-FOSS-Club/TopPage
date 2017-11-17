-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 14, 2017 at 05:17 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `TopPaper`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `aid` int(11) NOT NULL,
  `name` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `oid` int(11) NOT NULL,
  `name` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`oid`, `name`) VALUES
(70, 'Cat'),
(71, 'Cat'),
(72, 'Dog'),
(73, 'Monkey'),
(74, 'Donkey'),
(75, 'Cat'),
(76, 'Dog'),
(77, 'Monkey'),
(78, 'Donkey'),
(79, 'Cat'),
(80, 'Dog'),
(81, 'Monkey'),
(82, 'Donkey'),
(83, 'Cat'),
(84, 'Dog'),
(85, 'Monkey'),
(86, 'Donkey'),
(87, 'Cat'),
(88, 'Dog'),
(89, 'Monkey'),
(90, 'Donkey'),
(91, 'Cat'),
(92, 'Dog'),
(93, 'Monkey'),
(94, 'Donkey'),
(95, 'Cat'),
(96, 'Dog'),
(97, 'Monkey'),
(98, 'Donkey'),
(99, 'Cat'),
(100, 'Cat'),
(101, 'Dog'),
(102, 'Monkey'),
(103, 'Donkey'),
(104, 'Cat'),
(105, 'Dog'),
(106, 'Mumbai'),
(107, 'Delhi'),
(108, 'Pune'),
(109, 'JandK'),
(110, 'True'),
(111, 'False'),
(112, '29'),
(113, '55'),
(114, '16'),
(115, 'Mumbai'),
(116, 'Delhi'),
(117, 'Pune'),
(118, 'JandK');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `qid` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`qid`, `name`) VALUES
(43, 'What is the name of the animal?'),
(44, 'What is the name of the animal?'),
(45, 'What is the name of the animal?'),
(46, 'What is the name of the animal?'),
(47, 'What is the name of the animal?'),
(48, 'What is the name of the animal?'),
(49, 'What is the name of the animal?'),
(50, 'What is the name of the animal?'),
(51, 'What is the name of the animal?'),
(52, 'What is the name of the animal?'),
(53, 'What is the capital of India'),
(54, 'Is India the largest cuntry?'),
(55, 'I am a teen. What is my age?'),
(56, 'What is the capital of India');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `email`, `password`) VALUES
(1, 'castorgodinho@yahoo.in', 'guitar');

-- --------------------------------------------------------

--
-- Table structure for table `users_options_answers`
--

CREATE TABLE `users_options_answers` (
  `uid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `oid` int(11) NOT NULL,
  `flag` enum('true','false') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_options_answers`
--

INSERT INTO `users_options_answers` (`uid`, `qid`, `oid`, `flag`) VALUES
(1, 43, 71, 'false'),
(1, 43, 72, 'false'),
(1, 43, 73, 'false'),
(1, 43, 74, 'false'),
(1, 44, 75, 'false'),
(1, 44, 76, 'false'),
(1, 44, 78, 'true'),
(1, 45, 79, 'false'),
(1, 45, 80, 'false'),
(1, 45, 82, 'true'),
(1, 46, 83, 'false'),
(1, 46, 84, 'false'),
(1, 46, 86, 'true'),
(1, 47, 87, 'false'),
(1, 47, 88, 'false'),
(1, 47, 90, 'true'),
(1, 48, 91, 'false'),
(1, 48, 92, 'false'),
(1, 48, 94, 'true'),
(1, 49, 95, 'false'),
(1, 49, 96, 'false'),
(1, 49, 98, 'true'),
(1, 51, 100, 'true'),
(1, 51, 101, 'false'),
(1, 51, 102, 'false'),
(1, 51, 103, 'false'),
(1, 52, 104, 'true'),
(1, 52, 105, 'false'),
(1, 53, 106, 'false'),
(1, 53, 107, 'true'),
(1, 53, 108, 'false'),
(1, 53, 109, 'false'),
(1, 54, 110, 'false'),
(1, 54, 111, 'true'),
(1, 55, 112, 'false'),
(1, 55, 113, 'false'),
(1, 55, 114, 'true'),
(1, 56, 115, 'false'),
(1, 56, 116, 'true'),
(1, 56, 117, 'true'),
(1, 56, 118, 'false');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`oid`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`qid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `users_options_answers`
--
ALTER TABLE `users_options_answers`
  ADD PRIMARY KEY (`uid`,`qid`,`oid`),
  ADD KEY `oid_uqa` (`oid`),
  ADD KEY `qid_uqa` (`qid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `qid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_options_answers`
--
ALTER TABLE `users_options_answers`
  ADD CONSTRAINT `oid_uqa` FOREIGN KEY (`oid`) REFERENCES `options` (`oid`),
  ADD CONSTRAINT `qid_uqa` FOREIGN KEY (`qid`) REFERENCES `questions` (`qid`),
  ADD CONSTRAINT `uid_uqa` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
