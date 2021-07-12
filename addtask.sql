-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2021 at 01:53 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `addtask`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `icons` varchar(100) DEFAULT NULL,
  `color_hex` varchar(9) DEFAULT '#0000FF',
  `user_created` int(10) UNSIGNED DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `icons`, `color_hex`, `user_created`, `created_date`) VALUES
(2, 'school', 'daily tasks & assignment', 'school', '#FF0000', 1, '2021-07-05 04:40:56'),
(3, 'work', 'daily tasks to be done at office', 'work', '#2a9df4', 1, '2021-07-05 04:42:50');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `due_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `location` varchar(255) DEFAULT NULL,
  `attachments` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `cat_id` int(10) UNSIGNED DEFAULT NULL,
  `user_created` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `due_date`, `location`, `attachments`, `status`, `created_date`, `cat_id`, `user_created`) VALUES
(3, 'Drop user account resign', '2021-06-16 03:00:00', NULL, NULL, 0, '2021-07-05 04:43:25', 2, 1),
(4, 'Drop user account resign', '2021-06-16 03:00:00', NULL, NULL, 0, '2021-07-05 04:43:25', 3, 1),
(5, 'add new task test', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 10:36:08', 3, 1),
(6, 'add new task test ', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 10:38:57', 2, 1),
(7, 'test', '2021-05-20 03:00:00', NULL, NULL, 0, '2021-07-05 10:41:44', 2, 1),
(8, '', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 10:52:12', 2, 1),
(9, '', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 10:59:23', 2, 1),
(10, '', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 10:59:42', 2, 1),
(11, '', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 10:59:48', 2, 1),
(12, '', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 11:00:52', 2, 1),
(13, 'add new ', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 11:01:16', 2, 1),
(14, '', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 11:01:46', 2, 1),
(15, 'sdaf', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 11:01:50', 2, 1),
(16, 'fff', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 11:02:02', 2, 1),
(17, '', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 11:03:10', 2, 1),
(18, 'saf', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 11:03:13', 2, 1),
(19, '', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 11:05:15', 2, 1),
(20, 'ddd', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 11:05:20', 2, 1),
(21, '', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 11:05:45', 2, 1),
(22, 'dsaf', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 11:05:48', 2, 1),
(23, 'safd', '0000-00-00 00:00:00', NULL, NULL, 0, '2021-07-05 11:09:01', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `created_date`) VALUES
(1, 'saven@gmail.com', 'saven', '202cb962ac59075b964b07152d234b70', '2021-07-05 04:39:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_created` (`user_created`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `user_created` (`user_created`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`user_created`) REFERENCES `users` (`id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`user_created`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
