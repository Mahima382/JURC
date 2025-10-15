-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2025 at 10:24 PM
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
-- Database: `jurc_events`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('workshop','competition') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `type`, `start_date`, `end_date`, `description`, `image_url`) VALUES
(1, 'Robotics 101', 'workshop', '2025-10-10', '2025-10-12', 'Introduction to robotics and automation.', ''),
(2, 'Robo Race', 'competition', '2025-10-05', '2025-10-06', 'Compete in our annual robot racing challenge.', ''),
(3, 'Arduino Workshop', 'workshop', '2025-09-20', '2025-09-22', 'Hands-on session on Arduino programming for robotics.', ''),
(4, 'Line Follower Challenge', 'competition', '2025-10-06', '2025-10-06', 'Test your robot’s speed and accuracy in a track.', ''),
(5, 'AI & Robotics', 'workshop', '2025-11-01', '2025-11-03', 'Learn basics of AI for robotics applications.', 'images/AI_Robotics.jpg'),
(6, 'Drone Race', 'competition', '2025-11-05', '2025-11-06', 'Compete with other members in our drone race event.', 'images/drone_race.jpg'),
(13, 'IoT Workshop', 'workshop', '2025-10-07', '2025-10-10', 'Hands-on Internet of Things session.', ''),
(14, 'Mini Drone Competition', 'competition', '2025-10-06', '2025-10-09', 'Compete in building and racing mini drones.', ''),
(15, 'AI Chatbot Workshop', 'workshop', '2025-10-05', '2025-10-12', 'Learn to build AI chatbots using Python.', '');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `category` enum('Supporter','Mentor','Leader','Member') NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `email`, `Name`, `password`, `category`, `image_url`, `created_at`) VALUES
(1, 'Zahidur111', 'rmzahid@juniv.edu', 'Dr. Mohammad Zahidur Rahman', 'password123', 'Supporter', 'images/s1.jpeg', '2025-10-10 21:50:19'),
(2, 'Masum112', 'charlie@example.com', 'Md. Masum Bhuiyan', 'password123', 'Mentor', 'images/s2.jpg', '2025-10-10 21:50:19'),
(3, 'Diana', 'diana@example.com', 'Diana Riddhi', 'password123', 'Mentor', 'images/mentor2.jpg', '2025-10-10 21:50:19'),
(4, 'Ethan', 'ethan@example.com', 'Ethan Mark', 'password123', 'Leader', 'images/leader1.jpg', '2025-10-10 21:50:19'),
(5, 'Fiona', 'fiona@example.com', 'Fiona Fransico', 'password123', 'Leader', 'images/leader2.jpg', '2025-10-10 21:50:19'),
(6, 'George', 'george@example.com', 'George Washigton', 'password123', 'Member', 'images/member1.jpg', '2025-10-10 21:50:19'),
(7, 'Hannah', 'hannah@example.com', 'Hannah Raichand', 'password123', 'Member', 'images/member2.jpg', '2025-10-10 21:50:19');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
