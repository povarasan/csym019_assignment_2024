-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2024 at 06:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `premier`
--

-- --------------------------------------------------------

--
-- Table structure for table `football_team`
--

CREATE TABLE `football_team` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `played` int(11) NOT NULL,
  `won` int(11) NOT NULL,
  `drawn` int(11) NOT NULL,
  `lost` int(11) NOT NULL,
  `goals_for` int(11) NOT NULL,
  `goals_against` int(11) NOT NULL,
  `goal_difference` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `form` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `football_team`
--

INSERT INTO `football_team` (`id`, `name`, `played`, `won`, `drawn`, `lost`, `goals_for`, `goals_against`, `goal_difference`, `points`, `form`) VALUES
(1, 'Manchester City', 37, 27, 7, 3, 93, 33, 60, 88, 'www'),
(2, 'Arsenal', 37, 27, 5, 5, 89, 28, 61, 86, 'LLLL'),
(3, 'Liverpool', 37, 23, 10, 4, 84, 41, 43, 79, 'DWLL'),
(4, 'Aston Villa', 37, 20, 8, 9, 76, 56, 20, 68, 'DWWDD'),
(5, 'Tottenham Hotspur', 37, 19, 6, 12, 71, 61, 10, 63, 'DWWL');

-- --------------------------------------------------------

--
-- Table structure for table `new_teams`
--

CREATE TABLE `new_teams` (
  `id` int(11) NOT NULL,
  `club_name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `manager` varchar(255) NOT NULL,
  `team_size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `new_teams`
--

INSERT INTO `new_teams` (`id`, `club_name`, `city`, `manager`, `team_size`) VALUES
(1, 'Newcastle United', 'Newcastle', 'Eddie Howe', 25),
(2, 'Manchester United', 'Manchester', 'Erik ten Hag', 26);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `password`) VALUES
(2, 'User', '$2y$10$ZIiwYrR797DYLnCZyRjDRubr03Qp.7dJB1nFS23nhz3sVxe5Uug7C');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `football_team`
--
ALTER TABLE `football_team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_teams`
--
ALTER TABLE `new_teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
