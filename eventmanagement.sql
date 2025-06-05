-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2025 at 08:20 PM
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
-- Database: `eventmanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `picture` varchar(2000) NOT NULL,
  `password` varchar(202) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `picture`, `password`, `create_at`) VALUES
(1, 'admin', 'admin@gmail.com', '[value-4]', '$2y$10$qbU2yBxCdnFBizN9jbuA3O0lMR1M.uczIJoS9EjVocgGicqnjoAlO', '2025-05-16 21:12:10');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `matric` varchar(50) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `attended_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `event_id`, `user_id`, `name`, `matric`, `event_title`, `attended_at`) VALUES
(1, 2, 1, 'Favour Chinyere Obuagu', 'CMp2100456', 'The event', '2025-06-03 19:24:53');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(225) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `event_date` datetime NOT NULL,
  `end_time` time NOT NULL,
  `passcode` varchar(100) NOT NULL,
  `venue` varchar(200) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `end_time`, `passcode`, `venue`, `image_path`, `create_at`) VALUES
(1, 'Sug Election', 'iii.The interaction with the Ethereum blockchain was handled through JavaScript and Web3.js. On the server side, Laravel took care of routing, session management, and rendering the frontend through Blade templates, whereas in the browser, JavaScript handled blockchain interactions: registering properties, transferring ownership, and verification. This integration depended on MetaMask to sign and send transactions securely, thereby ensuring a decoupled architecture, where the Laravel backend was never directly concerned with smart contract invocations.', '2025-06-03 00:00:00', '00:00:00', '', '20 gus s m koswwe', 'uploads/1748548224_download (2).png', '2025-05-29 19:50:24'),
(2, 'The event', 'The Minister of Water Resources and Sanitation, Prof Joseph Utsev, stated this while reacting to the situation of flashfloods that hit Mokwa, a market town located in Nigeria’s north-central Niger State at the ministry’s headquarters in Abuja on Tuesday.\r\n\r\nAccording to the minister, the dams did not collapse during recent flooding. He, instead, attributed the overflow to climate change and unusually heavy rainfall.\r\nHe also said a team of technical experts from the ministry and various agencies are currently assessing the damage and working on solutions.\r\n\r\nThe minister urged state governments and stakeholders to follow early warning systems and implement preventive actions to reduce future flooding.\r\n\r\nMokwa is a key meeting and transit point for traders from the south and food growers in the north. It is about 350km (217 miles) by road east of Nigeria’s capital, Abuja.\r\nOver 200 bodies have been recovered from the town in the last few days after flash floods hit the area. Thousands ', '2025-06-03 00:20:25', '00:08:00', '427E18', '20 gus s m koswwe', 'uploads/1748977714_download (4).png', '2025-06-03 19:08:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `middlename` text NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `matric` varchar(10) NOT NULL,
  `department` varchar(100) NOT NULL,
  `faculty` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `hashed_password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `matric`, `department`, `faculty`, `email`, `phone`, `hashed_password`, `created_at`) VALUES
(1, 'Favour', 'Chinyere', 'Obuagu', 'CMp2100456', 'Computer science', 'Computing', 'favour@gmail.com', '0908970099', '$2y$10$qbU2yBxCdnFBizN9jbuA3O0lMR1M.uczIJoS9EjVocgGicqnjoAlO', '2025-05-29 18:57:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_attendance` (`event_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
