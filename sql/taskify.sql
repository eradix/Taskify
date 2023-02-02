-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2023 at 04:14 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taskify`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_description` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_description`, `created_date`, `updated_date`) VALUES
(1, 'Web Development', 'Any task regarding to web development.', '2023-01-30 01:49:11', '2023-01-30 01:49:11'),
(2, 'Business Management', 'Notice the green play buttons showing up after each URL. Clicking those will fire off the request and display the raw response on the right side of the document.', '2023-01-31 00:00:20', '2023-01-31 00:00:20');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_description` text NOT NULL,
  `task_slug` varchar(255) NOT NULL,
  `due_date` date NOT NULL,
  `status` tinyint(10) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_name`, `task_description`, `task_slug`, `due_date`, `status`, `category_id`, `user_id`, `created_date`, `updated_date`) VALUES
(1, 'Landing Page Mockup', 'Make a landing page mockup. Atleast five entries with different designs and color schemes.', 'landing-page-mockup', '2023-02-10', 1, 1, 1, '2023-01-30 09:52:11', '2023-01-30 09:52:11'),
(2, 'Design the database structure', 'Design the database structure. Create tables and columns.', 'design-the-database-structure', '2023-02-03', 1, 1, 1, '2023-01-30 13:38:54', '2023-01-30 13:38:54'),
(4, 'Project Meeting', 'Be aware of that any JavaScript code can be added inside the &lt;script&gt; tag! A hacker can redirect the user to a file on another server, and that file can hold malicious code that can alter the global variables or submit the form to another address to save the user data, for example.', 'project-meeting', '2023-02-07', 1, 2, 1, '2023-01-31 08:46:45', '2023-01-31 08:50:32'),
(6, 'Business Technique', 'This code adds a script tag and an alert command. And when the page loads, the JavaScript code will be executed (the user will see an alert box). This is just a simple and harmless example how the PHP_SELF variable can be exploited.', 'business-technique', '2023-02-07', 1, 2, 1, '2023-01-31 09:03:54', '2023-01-31 09:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(10) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `created_date`, `updated_date`) VALUES
(1, 'Lebron James', 'lebron@email.com', '2e3f29f5f4314d26894c093686e4d5645f59db0d', 2, '2023-01-30 01:50:45', '2023-01-31 02:22:42'),
(2, 'Ricardo Dalisay', 'dalisay@email.com', '2ea7198a88aaf05c60a2d0104eb0f72c920030ff', 2, '2023-01-31 02:00:27', '2023-01-31 02:00:27'),
(3, 'Admin', 'admin@email.com', 'fdb30ac8ee8340f7bc9ffb8ccd5b3ff4fa5c27ec', 1, '2023-01-31 02:03:55', '2023-01-31 02:03:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
