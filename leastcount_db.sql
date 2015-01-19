-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 19, 2015 at 08:52 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `leastcount_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `game_track_details`
--

CREATE TABLE IF NOT EXISTS `game_track_details` (
  `table_id` int(8) NOT NULL,
  `game_round_no` int(3) NOT NULL,
  `round_no` int(2) NOT NULL,
  `player_name` varchar(30) NOT NULL,
  `game_round_status` int(2) NOT NULL,
  `round_status` int(2) NOT NULL,
  `current_hands` varchar(10000) NOT NULL,
  `current_hand_owner` varchar(30) NOT NULL,
  `current_open_card` int(3) NOT NULL,
  `last_drops` varchar(1000) NOT NULL,
  `show_caller_name` varchar(30) NOT NULL,
  `player_scores` varchar(1000) NOT NULL,
  `timestamp` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `player_details`
--

CREATE TABLE IF NOT EXISTS `player_details` (
  `player_name` varchar(30) NOT NULL,
  `picture` varchar(400) NOT NULL,
  `name` varchar(100) NOT NULL,
  `overall_score` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `player_details`
--

INSERT INTO `player_details` (`player_name`, `picture`, `name`, `overall_score`) VALUES
('avi123', 'http://www.avi.jpg/', 'Avinash', 550),
('nikki01', 'http://www.nikki.jpg/', 'Nik', 1350),
('pj420', 'http://www.pj.jpg/', 'PJ', 750),
('sasi87', 'http://www.sasi.jpg/', 'Sasi', 1250),
('summi5005', 'http://www.summi.jpg/', 'Sumanth', 1450),
('surya4357', 'http://www.surya.jpg/', 'Surya', 1220),
('xyz222', 'http://www.xyz.jpg/', 'Xyz', 1020);

-- --------------------------------------------------------

--
-- Table structure for table `poll_table_details`
--

CREATE TABLE IF NOT EXISTS `poll_table_details` (
  `table_id` int(8) NOT NULL,
  `game_round_no` int(2) NOT NULL,
  `round_no` int(2) NOT NULL,
  `current_hands` varchar(10000) NOT NULL,
  `current_hand_owner` varchar(100) NOT NULL,
  `current_open_card` int(3) NOT NULL,
  `last_drops` varchar(1000) NOT NULL,
  `show_caller_id` int(20) NOT NULL,
  `player_scores` varchar(1000) NOT NULL,
  `timestamp` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `poll_table_details`
--

INSERT INTO `poll_table_details` (`table_id`, `game_round_no`, `round_no`, `current_hands`, `current_hand_owner`, `current_open_card`, `last_drops`, `show_caller_id`, `player_scores`, `timestamp`) VALUES
(100, 1, 1, '4,104,95,39,20,36,84:51,15,54,34,87,76,17:27,43,26,46,14,89,52:42,101,25,98,74,53,8:29,9,59,40,58,97,69:93,11,88,18,65,44,55', 'surya4357', 78, '', 0, '0,0,0,0,0,0', 1420320306);

-- --------------------------------------------------------

--
-- Table structure for table `remaining_deck_details`
--

CREATE TABLE IF NOT EXISTS `remaining_deck_details` (
  `table_id` int(8) NOT NULL,
  `remaining_deck` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `remaining_deck_details`
--

INSERT INTO `remaining_deck_details` (`table_id`, `remaining_deck`) VALUES
(100, '34,6,56,14,37,4,95,19,91,20,26,5,29,73,24,59,33,82,22,42,68,31,89,104,76,46,55,77,83,80,72,86,40,52,88,94,66,45,49,79,38,47,15,100,60,62,12,71,18,7,84,87,54,67,70,27,64,53,102,23,32');

-- --------------------------------------------------------

--
-- Table structure for table `table_details`
--

CREATE TABLE IF NOT EXISTS `table_details` (
  `table_id` int(8) NOT NULL,
  `table_size` int(4) NOT NULL,
  `no_of_cards_per_hand` int(4) NOT NULL,
  `no_of_decks` int(2) NOT NULL,
  `players` varchar(1000) NOT NULL,
  `table_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_details`
--

INSERT INTO `table_details` (`table_id`, `table_size`, `no_of_cards_per_hand`, `no_of_decks`, `players`, `table_status`) VALUES
(100, 6, 7, 2, 'surya4357:summi5005:pj420:nikki01:sasi87:avi123', 1),
(101, 7, 7, 2, 'surya4358:summi5006:pj430:nikki11:sasi37:avi153:xyz222:xyz222', 0),
(103, 8, 8, 2, 'xyz222', 0),
(104, 8, 6, 2, 'xyz222:surya4357:surya4357:surya4357:surya4357:surya4357:surya4357:surya4357:surya4357:surya4357:surya4357:surya4357:surya4357:surya4357', 0);

-- --------------------------------------------------------

--
-- Table structure for table `table_status`
--

CREATE TABLE IF NOT EXISTS `table_status` (
  `table_id` int(8) NOT NULL,
  `timestamp` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wait_to_start_details`
--

CREATE TABLE IF NOT EXISTS `wait_to_start_details` (
  `table_id` int(6) NOT NULL,
  `player_list` varchar(1000) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wait_to_start_details`
--

INSERT INTO `wait_to_start_details` (`table_id`, `player_list`, `status`) VALUES
(100, 'summi5005:pj420:sasi87', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game_track_details`
--
ALTER TABLE `game_track_details`
 ADD PRIMARY KEY (`table_id`,`game_round_no`,`round_no`,`player_name`);

--
-- Indexes for table `player_details`
--
ALTER TABLE `player_details`
 ADD PRIMARY KEY (`player_name`);

--
-- Indexes for table `poll_table_details`
--
ALTER TABLE `poll_table_details`
 ADD PRIMARY KEY (`table_id`,`game_round_no`);

--
-- Indexes for table `remaining_deck_details`
--
ALTER TABLE `remaining_deck_details`
 ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `table_details`
--
ALTER TABLE `table_details`
 ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `table_status`
--
ALTER TABLE `table_status`
 ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `wait_to_start_details`
--
ALTER TABLE `wait_to_start_details`
 ADD PRIMARY KEY (`table_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
