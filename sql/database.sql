-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2026 at 04:52 AM
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
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catagories`
--

INSERT INTO `catagories` (`id`, `catagorie_name`, `description`, `is_active`) VALUES
(3, 'English', 'Grammar and Verbs', 1),
(5, 'Math', 'Algebra and Derivatives', 0);

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
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `optionss`
--

INSERT INTO `optionss` (`id`, `category_id`, `category_name`, `option_`, `is_correct`, `question_id`) VALUES
(1, 3, 'English', 'am', 1, 12),
(2, 3, 'English', 'tiny', 0, 12),
(3, 3, 'English', 'is', 0, 12),
(4, 3, 'English', 'scrutinized', 0, 12),
(5, 3, 'English', 'am', 1, 13),
(6, 3, 'English', 'tiny', 0, 13),
(7, 3, 'English', 'is', 0, 13),
(8, 3, 'English', 'scrutinized', 0, 13),
(9, 3, 'English', 'am', 1, 14),
(10, 3, 'English', 'tiny', 0, 14),
(11, 3, 'English', 'is', 0, 14),
(12, 3, 'English', 'scrutinized', 0, 14),
(13, 3, 'English', 'am', 1, 15),
(14, 3, 'English', 'tiny', 0, 15),
(15, 3, 'English', 'is', 0, 15),
(16, 3, 'English', 'scrutinized', 0, 15),
(17, 3, 'English', 'is', 1, 16),
(18, 3, 'English', 'am', 0, 16),
(19, 3, 'English', 'her', 0, 16),
(20, 3, 'English', 'bd', 0, 16),
(21, 3, 'English', 'is', 1, 17),
(22, 3, 'English', 'am', 0, 17),
(23, 3, 'English', 'her', 0, 17),
(24, 3, 'English', 'bd', 0, 17);

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
(17, 'English', 3, 'I ____ Gaurav', 'is', 0);

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
(9, 2, 5, 1, 0);

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
(1, 2, 1, 3, 1, 2),
(2, 2, 2, 3, 1, 2),
(3, 2, 3, 3, 2, 2),
(4, 2, 5, 3, 1, 1),
(5, 2, 6, 3, 1, 2);

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
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `username`, `password`, `is_active`) VALUES
(1, 'admin', 'govindaphuyal40@gmail.com', 'admin', '$2y$10$JGn21MPaDS0zQlc7d9eyje57zfOlNC.rKDblFBDo2HjXEZgDTDpai', 1),
(2, 'gaurav', 'phuyalgaurab123@gmail.com', 'gaurav', '$2y$10$1vMhiZXau85.XCFqFeVGi.IXnCIvrHLh2eEpKya/YKLRuvpKdY/fi', 1);

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
(35, '3', 1, 'login');

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
(1, 2, 1, 3, 12, 'am', 1),
(2, 2, 1, 3, 13, 'scrutinized', 0),
(3, 2, 2, 3, 12, 'am', 1),
(4, 2, 2, 3, 13, 'scrutinized', 0),
(5, 2, 3, 3, 12, 'am', 1),
(6, 2, 3, 3, 13, 'am', 1),
(7, 2, 5, 3, 12, 'am', 1),
(8, 2, 6, 3, 15, 'am', 1),
(9, 2, 6, 3, 17, 'am', 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `optionss`
--
ALTER TABLE `optionss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `quiz_result`
--
ALTER TABLE `quiz_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_activity`
--
ALTER TABLE `user_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `user_answer`
--
ALTER TABLE `user_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
