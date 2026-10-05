-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2026 at 05:01 AM
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
-- Database: `quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `catagories`
--

CREATE TABLE `catagories` (
  `id` int(11) NOT NULL,
  `catagorie_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `totalques` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catagories`
--

INSERT INTO `catagories` (`id`, `catagorie_name`, `description`, `totalques`, `is_active`) VALUES
(3, 'English', 'Grammar and Verbs', 9, 1),
(5, 'Math', 'Algebra and Derivatives', 0, 0),
(6, 'English', 'VERBS', 0, 0),
(7, 'English', 'Conjunction', 2, 1),
(8, 'Nepali', 'Grammar', 0, 1),
(9, 'Science', 'Biology', 0, 1),
(10, 'Math', 'Statistics', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `optionss`
--

CREATE TABLE `optionss` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `option_` varchar(255) DEFAULT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `question_id` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `optionss`
--

INSERT INTO `optionss` (`id`, `category_id`, `category_name`, `option_`, `is_correct`, `question_id`, `is_active`) VALUES
(1, 3, 'English', 'am', 1, 12, 0),
(2, 3, 'English', 'tiny', 0, 12, 0),
(3, 3, 'English', 'is', 0, 12, 0),
(4, 3, 'English', 'scrutinized', 0, 12, 0),
(5, 3, 'English', 'am', 1, 13, 0),
(6, 3, 'English', 'tiny', 0, 13, 0),
(7, 3, 'English', 'is', 0, 13, 0),
(8, 3, 'English', 'scrutinized', 0, 13, 0),
(9, 3, 'English', 'am', 1, 14, 0),
(10, 3, 'English', 'tiny', 0, 14, 0),
(11, 3, 'English', 'is', 0, 14, 0),
(12, 3, 'English', 'scrutinized', 0, 14, 0),
(13, 3, 'English', 'am', 1, 15, 0),
(14, 3, 'English', 'tiny', 0, 15, 0),
(15, 3, 'English', 'is', 0, 15, 0),
(16, 3, 'English', 'scrutinized', 0, 15, 0),
(17, 3, 'English', 'is', 1, 16, 0),
(18, 3, 'English', 'am', 0, 16, 0),
(19, 3, 'English', 'her', 0, 16, 0),
(20, 3, 'English', 'bd', 0, 16, 0),
(21, 3, 'English', 'is', 1, 17, 0),
(22, 3, 'English', 'am', 0, 17, 0),
(23, 3, 'English', 'her', 0, 17, 0),
(24, 3, 'English', 'bd', 0, 17, 0),
(25, 3, 'English', 'is', 0, 18, 0),
(26, 3, 'English', 'am', 1, 18, 0),
(27, 3, 'English', 'her', 0, 18, 0),
(28, 3, 'English', 'bd', 0, 18, 0),
(29, 3, 'English', 'is', 0, 19, 0),
(30, 3, 'English', 'am', 1, 19, 0),
(31, 3, 'English', 'her', 0, 19, 0),
(32, 3, 'English', 'bd', 0, 19, 0),
(33, 3, 'English', 'is', 1, 20, 0),
(34, 3, 'English', 'am', 0, 20, 0),
(35, 3, 'English', 'her', 0, 20, 0),
(36, 3, 'English', 'bd', 0, 20, 0),
(37, 3, 'English', 'is', 0, 21, 0),
(38, 3, 'English', 'am', 1, 21, 0),
(39, 3, 'English', 'her', 0, 21, 0),
(40, 3, 'English', 'bd', 0, 21, 0),
(41, 7, 'English', 'noise', 0, 22, 1),
(42, 7, 'English', 'tiny', 0, 22, 1),
(43, 7, 'English', 'her', 0, 22, 1),
(44, 7, 'English', 'scrutinized', 1, 22, 1),
(45, 3, 'English', 'in', 0, 23, 1),
(46, 3, 'English', 'at', 0, 23, 1),
(47, 3, 'English', 'on', 0, 23, 1),
(48, 3, 'English', 'onto', 1, 23, 1),
(49, 3, 'English', 'A pack of wolves are howling in the distance.', 0, 24, 1),
(50, 3, 'English', 'Each of the players has a special uniform.', 1, 24, 1),
(51, 3, 'English', 'The group of musicians perform tonight.', 0, 24, 1),
(52, 3, 'English', 'Everybody are ready for the test', 0, 24, 1),
(53, 3, 'English', 'loudiest', 0, 25, 1),
(54, 3, 'English', 'more loudly', 1, 25, 1),
(55, 3, 'English', 'most loudly', 0, 25, 1),
(56, 3, 'English', 'loudlier', 0, 25, 1),
(57, 3, 'English', 'fastest', 0, 26, 1),
(58, 3, 'English', 'more fastest', 0, 26, 1),
(59, 3, 'English', 'faster', 1, 26, 1),
(60, 3, 'English', 'most fast', 0, 26, 1),
(61, 3, 'English', 'cheerful', 0, 27, 0),
(62, 3, 'English', 'the more cheerfully', 0, 27, 0),
(63, 3, 'English', 'cheerfulliest', 0, 27, 0),
(64, 3, 'English', 'the most cheerfully', 1, 27, 0),
(65, 7, 'English', 'brightlier', 0, 28, 1),
(66, 7, 'English', 'brightliest', 0, 28, 1),
(67, 7, 'English', 'more brightly', 0, 28, 1),
(68, 7, 'English', 'most brightly', 1, 28, 1);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `catagorie_id` int(11) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `correct_answer` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `category_name`, `catagorie_id`, `question`, `correct_answer`, `is_active`) VALUES
(12, 'English', 3, 'I ____ Gaurav', 'am', 0),
(13, 'English', 3, 'I ____ Hari', 'am', 0),
(14, 'English', 3, 'I ____ Hari', 'am', 0),
(15, 'English', 3, 'I ____ Hari', 'am', 0),
(16, 'English', 3, 'who ____ don', 'is', 0),
(17, 'English', 3, 'I ____ Gaurav', 'is', 0),
(18, 'English', 3, 'I ____ Gaurav', 'am', 0),
(19, 'English', 3, 'I ____ Hari', 'am', 0),
(20, 'English', 3, 'I ____ Hari', 'is', 0),
(21, 'English', 3, 'I ____ DON', 'am', 0),
(22, 'English', 7, 'Which word in the following sentence functions as an action verb? \"Despite the loud noise, the detective scrutinized the tiny clues on the carpet.\"', 'scrutinized', 1),
(23, 'English', 3, 'Choose the correct preposition to complete the sentence: \"The cat jumped __________ the table and knocked over a vase.\"', 'onto', 1),
(24, 'English', 3, 'Identify the sentence with the correct subject-verb agreement.', 'Each of the players has a special uniform.', 1),
(25, 'English', 3, 'The girl yelled ____ than her sister.', 'more loudly', 1),
(26, 'English', 3, 'Who is the ____ runner in the world?', 'faster', 1),
(27, 'English', 3, 'Missy said hello ____ of everyone in her group of friends.', 'the most cheerfully', 0),
(28, 'English', 7, 'This light shines ____ in a dim room.', 'most brightly', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `attempt_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`id`, `user_id`, `category_id`, `attempt_id`, `score`) VALUES
(1, 2, 3, 1, 0),
(2, 2, 3, 2, 0),
(3, 2, 3, 3, 0),
(4, 2, 3, 4, 0),
(5, 2, 3, 5, 0),
(6, 2, 3, 6, 0),
(7, 2, 3, 7, 0),
(8, 2, 3, 8, 0),
(9, 2, 5, 1, 0),
(10, 3, 3, 1, 0),
(11, 2, 3, 9, 0),
(12, 2, 3, 10, 0),
(13, 1, 3, 1, 0),
(14, 2, 3, 11, 0),
(15, 1, 3, 2, 0),
(16, 1, 3, 3, 0),
(17, 1, 3, 4, 0),
(18, 2, 3, 12, 0),
(19, 2, 3, 13, 0),
(20, 2, 3, 14, 0),
(21, 2, 3, 15, 0),
(22, 2, 3, 16, 0),
(23, 2, 3, 17, 0),
(24, 2, 3, 18, 0),
(25, 2, 3, 19, 0),
(26, 2, 3, 20, 0),
(27, 2, 3, 21, 0),
(28, 2, 3, 22, 0),
(29, 2, 3, 23, 0),
(30, 2, 3, 24, 0),
(31, 2, 3, 25, 0),
(32, 2, 3, 26, 0),
(33, 2, 3, 27, 0),
(34, 2, 3, 28, 0),
(35, 2, 3, 29, 0),
(36, 1, 3, 5, 0),
(37, 1, 3, 6, 0),
(38, 1, 3, 7, 0),
(39, 1, 3, 8, 0),
(40, 1, 3, 9, 0),
(41, 1, 3, 10, 0),
(42, 1, 3, 11, 0),
(43, 1, 3, 12, 0),
(44, 1, 3, 13, 0),
(45, 2, 3, 30, 0),
(46, 2, 7, 1, 0),
(47, 2, 7, 2, 0),
(48, 2, 7, 3, 0),
(49, 2, 7, 4, 0),
(50, 2, 3, 31, 0),
(51, 2, 3, 32, 0),
(52, 2, 3, 33, 0);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_result`
--

CREATE TABLE `quiz_result` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attempt_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_result`
--

INSERT INTO `quiz_result` (`id`, `user_id`, `attempt_id`, `category_id`, `score`, `total_questions`) VALUES
(1, 2, 21, 3, 2, 3),
(2, 2, 22, 3, 0, 3),
(3, 2, 23, 3, 0, 3),
(4, 2, 24, 3, 2, 3),
(5, 2, 26, 3, 1, 3),
(6, 2, 27, 3, 1, 3),
(7, 2, 28, 3, 1, 3),
(8, 2, 29, 3, 1, 3),
(9, 1, 5, 3, 2, 4),
(10, 1, 6, 3, 2, 4),
(11, 1, 7, 3, 2, 4),
(12, 1, 8, 3, 3, 4),
(13, 1, 9, 3, 2, 4),
(14, 1, 10, 3, 2, 4),
(15, 1, 11, 3, 0, 4),
(16, 1, 12, 3, 1, 4),
(17, 1, 13, 3, 4, 4),
(18, 2, 30, 3, 2, 4),
(19, 2, 1, 7, 0, 1),
(20, 2, 2, 7, 0, 1),
(21, 2, 3, 7, 1, 1),
(22, 2, 4, 7, 0, 1),
(23, 2, 31, 3, 2, 4),
(24, 2, 32, 3, 3, 5),
(25, 2, 33, 3, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `role` varchar(20) NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `username`, `password`, `is_active`, `role`) VALUES
(1, 'admin', 'govindaphuyal40@gmail.com', 'admin', '$2y$10$JGn21MPaDS0zQlc7d9eyje57zfOlNC.rKDblFBDo2HjXEZgDTDpai', 1, 'admin'),
(2, 'gaurav', 'phuyalgaurab123@gmail.com', 'gaurav', '$2y$10$1vMhiZXau85.XCFqFeVGi.IXnCIvrHLh2eEpKya/YKLRuvpKdY/fi', 1, 'student'),
(3, 'ganga', 'gangaphuyal333@gmail.com', 'ganga', '$2y$10$8liYZfZBMcxoUfmA749UwOcQGJoFdaNUZSsm5tCIHKHRxiuV.c.Hm', 0, 'student'),
(4, 'Gaurav Phuyal', 'gangaphuyal33@gmail.com', 'Gaurav Phuyal', '$2y$10$5.ojSDCc3bCdvRZqOjzT6uHQ9wwiYOFGH6KjmaG..8JRwSH/bo1pG', 1, 'student');

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE `user_activity` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `activity` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_activity`
--

INSERT INTO `user_activity` (`id`, `session_id`, `user_id`, `activity`) VALUES
(1, '0', 1, 'login'),
(2, '0', 2, 'login'),
(3, '0', 1, 'login'),
(4, '0', 2, 'login'),
(5, '6', 1, 'login'),
(6, '4', 1, 'login'),
(7, '4', 1, 'login'),
(8, '4', 2, 'login'),
(9, '4', 2, 'login'),
(10, '4', 2, 'login'),
(11, '4', 2, 'login'),
(12, '4', 2, 'login'),
(13, '0', 2, 'login'),
(14, '0', 1, 'login'),
(15, '0', 2, 'login'),
(16, '0', 2, 'login'),
(17, '0', 1, 'login'),
(18, '0', 2, 'login'),
(19, '0', 2, 'logout'),
(20, '0', 1, 'login'),
(21, '0', 2, 'login'),
(22, '0', 2, 'logout'),
(23, '0', 1, 'login'),
(24, '0', 2, 'login'),
(25, '0', 2, 'logout'),
(26, '0', 2, 'login'),
(27, '0', 2, 'logout'),
(28, '0', 2, 'login'),
(29, '0', 2, 'logout'),
(30, '0', 2, 'login'),
(31, '0', 1, 'login'),
(32, '0', 2, 'login'),
(33, '0', 1, 'login'),
(34, '0', 2, 'login'),
(35, '3', 1, 'login'),
(36, '3', 3, 'login'),
(37, '0', 2, 'login'),
(38, '0', 1, 'login'),
(39, '0', 4, 'login'),
(40, '0', 4, 'logout'),
(41, '0', 1, 'login'),
(42, '0', 1, 'logout'),
(43, '0', 2, 'login'),
(44, '0', 1, 'login'),
(45, '0', 2, 'login'),
(46, '0', 1, 'login'),
(47, '0', 2, 'login'),
(48, '1', 2, 'login'),
(49, '1', 2, 'logout'),
(50, '1', 1, 'login'),
(51, '1', 1, 'logout'),
(52, '1', 1, 'login'),
(53, '1', 1, 'logout'),
(54, '1', 1, 'login'),
(55, '1', 1, 'login'),
(56, '1', 1, 'logout'),
(57, '1', 2, 'login'),
(58, '1', 2, 'logout'),
(59, '1', 1, 'login'),
(60, '1', 1, 'login'),
(61, '1', 1, 'login'),
(62, '1', 1, 'login'),
(63, '1', 1, 'logout'),
(64, '1', 1, 'login'),
(65, '0', 2, 'login'),
(66, '0', 2, 'login'),
(67, '0', 1, 'login'),
(68, '0', 2, 'login'),
(69, '0', 2, 'logout'),
(70, '0', 1, 'login'),
(71, '0', 1, 'login'),
(72, '0', 1, 'logout'),
(73, '0', 2, 'login'),
(74, '0', 1, 'login'),
(75, '0', 1, 'logout'),
(76, '0', 2, 'login'),
(77, '0', 1, 'login'),
(78, '0', 1, 'login'),
(79, '0', 1, 'logout'),
(80, '0', 2, 'login'),
(81, '0', 2, 'logout'),
(82, '0', 1, 'login'),
(83, '0', 1, 'logout'),
(84, '0', 2, 'login'),
(85, '0', 2, 'logout'),
(86, '0', 1, 'login'),
(87, '0', 1, 'logout'),
(88, '0', 2, 'login'),
(89, '0', 2, 'logout'),
(90, '0', 2, 'login'),
(91, '0', 2, 'logout'),
(92, '0', 1, 'login'),
(93, '0', 1, 'logout'),
(94, '0', 2, 'login'),
(95, '0', 2, 'logout'),
(96, '0', 2, 'login'),
(97, '0', 2, 'logout'),
(98, '0', 1, 'login'),
(99, '0', 1, 'logout'),
(100, '8', 1, 'login'),
(101, '8', 1, 'logout'),
(102, '76', 2, 'login'),
(103, '76', 2, 'logout'),
(104, '7', 1, 'login'),
(105, '7', 1, 'logout'),
(106, '0', 2, 'login'),
(107, '0', 2, 'logout');

-- --------------------------------------------------------

--
-- Table structure for table `user_answer`
--

CREATE TABLE `user_answer` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `attempt_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_answer`
--

INSERT INTO `user_answer` (`id`, `user_id`, `attempt_id`, `category_id`, `question_id`, `answer`, `is_correct`) VALUES
(1, 2, 21, 3, 18, 'is', 0),
(2, 2, 21, 3, 19, 'her', 0),
(3, 2, 21, 3, 21, 'am', 1),
(4, 2, 22, 3, 18, 'am', 1),
(5, 2, 22, 3, 19, 'am', 1),
(6, 2, 22, 3, 21, 'is', 0),
(7, 2, 23, 3, 18, 'am', 1),
(8, 2, 24, 3, 18, 'is', 0),
(9, 2, 24, 3, 19, 'am', 1),
(10, 2, 24, 3, 21, 'am', 1),
(11, 2, 26, 3, 18, 'bd', 0),
(12, 2, 26, 3, 19, 'am', 1),
(13, 2, 26, 3, 21, 'am', 1),
(14, 2, 27, 3, 18, 'am', 1),
(15, 2, 27, 3, 19, 'am', 1),
(16, 2, 27, 3, 21, 'am', 1),
(17, 2, 28, 3, 18, 'am', 1),
(18, 2, 28, 3, 19, 'am', 1),
(19, 2, 28, 3, 21, 'am', 1),
(20, 2, 29, 3, 18, 'am', 1),
(21, 2, 29, 3, 19, 'am', 1),
(22, 2, 29, 3, 21, 'am', 1),
(23, 1, 5, 3, 16, 'is', 1),
(24, 1, 5, 3, 18, 'am', 1),
(25, 1, 5, 3, 19, 'am', 1),
(26, 1, 5, 3, 21, 'am', 1),
(27, 1, 6, 3, 16, 'is', 1),
(28, 1, 6, 3, 18, 'am', 1),
(29, 1, 6, 3, 19, 'am', 1),
(30, 1, 6, 3, 21, 'am', 1),
(31, 1, 7, 3, 16, 'is', 1),
(32, 1, 7, 3, 18, 'is', 0),
(33, 1, 8, 3, 16, 'is', 1),
(34, 1, 8, 3, 18, 'am', 1),
(35, 1, 8, 3, 19, 'is', 0),
(36, 1, 8, 3, 21, 'am', 1),
(37, 1, 9, 3, 16, 'is', 1),
(38, 1, 9, 3, 18, 'am', 0),
(39, 1, 9, 3, 19, 'am', 1),
(40, 1, 9, 3, 21, 'am', 1),
(41, 1, 10, 3, 16, 'is', 1),
(42, 1, 10, 3, 18, 'am', 1),
(43, 1, 10, 3, 19, 'am', 1),
(44, 1, 10, 3, 21, 'am', 1),
(45, 1, 12, 3, 16, 'is', 1),
(46, 1, 12, 3, 18, 'is', 1),
(47, 1, 12, 3, 19, 'is', 1),
(48, 1, 12, 3, 21, 'is', 1),
(49, 1, 13, 3, 16, 'is', 1),
(50, 1, 13, 3, 18, 'am', 1),
(51, 1, 13, 3, 19, 'am', 1),
(52, 1, 13, 3, 21, 'am', 1),
(53, 2, 30, 3, 16, 'is', 1),
(54, 2, 30, 3, 18, 'am', 1),
(55, 2, 30, 3, 19, 'her', 0),
(56, 2, 3, 7, 22, 'scrutinized', 1),
(57, 2, 4, 7, 22, '', 0),
(58, 2, 31, 3, 16, '', 0),
(59, 2, 31, 3, 18, 'bd', 0),
(60, 2, 31, 3, 19, 'am', 1),
(61, 2, 31, 3, 21, 'am', 1),
(62, 2, 32, 3, 23, 'onto', 1),
(63, 2, 32, 3, 24, 'Each of the players has a special uniform.', 1),
(64, 2, 32, 3, 25, 'loudiest', 0),
(65, 2, 32, 3, 26, 'more fastest', 0),
(66, 2, 32, 3, 27, 'the most cheerfully', 1),
(67, 2, 33, 3, 23, 'at', 0),
(68, 2, 33, 3, 24, 'Each of the players has a special uniform.', 1),
(69, 2, 33, 3, 25, 'most loudly', 0),
(70, 2, 33, 3, 26, 'more fastest', 0),
(71, 2, 33, 3, 27, 'the more cheerfully', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catagories`
--
ALTER TABLE `catagories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `optionss`
--
ALTER TABLE `optionss`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_questions_category` (`catagorie_id`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `quiz_result`
--
ALTER TABLE `quiz_result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_results_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_answer`
--
ALTER TABLE `user_answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `question_id` (`question_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catagories`
--
ALTER TABLE `catagories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `optionss`
--
ALTER TABLE `optionss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `quiz_result`
--
ALTER TABLE `quiz_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_activity`
--
ALTER TABLE `user_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `user_answer`
--
ALTER TABLE `user_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `optionss`
--
ALTER TABLE `optionss`
  ADD CONSTRAINT `optionss_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `catagories` (`id`),
  ADD CONSTRAINT `optionss_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `fk_questions_category` FOREIGN KEY (`catagorie_id`) REFERENCES `catagories` (`id`);

--
-- Constraints for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD CONSTRAINT `quiz_attempts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `quiz_attempts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `catagories` (`id`);

--
-- Constraints for table `quiz_result`
--
ALTER TABLE `quiz_result`
  ADD CONSTRAINT `fk_results_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `user_activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_answer`
--
ALTER TABLE `user_answer`
  ADD CONSTRAINT `user_answer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_answer_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `catagories` (`id`),
  ADD CONSTRAINT `user_answer_ibfk_3` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
