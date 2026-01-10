-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2025 at 08:14 PM
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
-- Database: `rps_game`
--

-- --------------------------------------------------------

--
-- Table structure for table `game_log`
--

CREATE TABLE `game_log` (
  `id` int(11) NOT NULL,
  `player_name` varchar(50) DEFAULT NULL,
  `player_move` varchar(20) NOT NULL,
  `computer_move` varchar(20) NOT NULL,
  `result` varchar(20) NOT NULL,
  `played_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game_log`
--

INSERT INTO `game_log` (`id`, `player_name`, `player_move`, `computer_move`, `result`, `played_at`) VALUES
(1, 'N', 'Scissors', 'Paper', 'You Win', '2025-12-29 17:46:51'),
(2, 'N', 'Scissors', 'Rock', 'Computer Wins', '2025-12-29 17:46:56'),
(3, 'N', 'Scissors', 'Paper', 'You Win', '2025-12-29 17:47:00'),
(4, 'N', 'Scissors', 'Paper', 'You Win', '2025-12-29 17:47:04'),
(5, 'N', 'Rock', 'Paper', 'Computer Wins', '2025-12-29 17:47:05'),
(6, 'N', 'Rock', 'Scissors', 'You Win', '2025-12-29 19:01:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game_log`
--
ALTER TABLE `game_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game_log`
--
ALTER TABLE `game_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
