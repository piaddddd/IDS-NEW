-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2026 at 06:58 AM
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
-- Database: `app_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dial_num`
--

CREATE TABLE `dial_num` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dial_num`
--

INSERT INTO `dial_num` (`id`, `phone_number`, `timestamp`) VALUES
(1, '09639594415', '2025-04-25 00:08:50'),
(2, '09486339668', '2025-08-03 16:17:55'),
(3, '09486339668', '2025-08-03 16:18:02'),
(4, '09486339668', '2025-08-03 18:55:32'),
(5, '09486339668', '2025-10-06 19:05:23'),
(6, '09639594415', '2025-10-27 18:17:55'),
(7, '09518618241', '2025-10-28 22:31:24'),
(8, '09518618241', '2025-10-30 16:06:04'),
(9, '09518618241', '2025-11-06 17:26:02'),
(10, '09482018131', '2025-11-07 10:59:10'),
(11, '09518618241', '2025-11-07 11:49:13'),
(12, '9852238245', '2026-03-28 17:43:38');

-- --------------------------------------------------------

--
-- Table structure for table `motion_alerts`
--

CREATE TABLE `motion_alerts` (
  `id` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `sensor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `motion_alerts`
--

INSERT INTO `motion_alerts` (`id`, `location`, `timestamp`, `sensor_id`) VALUES
(2, 'LivingRoom', '2025-11-07 03:30:20', 1),
(3, 'LivingRoom', '2025-11-07 03:33:56', 1),
(6, 'LivingRoom', '2025-11-07 03:34:40', 1),
(8, 'LivingRoom', '2025-11-07 03:35:19', 1),
(9, 'LivingRoom', '2025-11-07 03:35:29', 1),
(12, 'LivingRoom', '2025-11-07 03:36:24', 1),
(19, 'LivingRoom', '2025-11-07 03:37:16', 1),
(21, 'LivingRoom', '2025-11-07 03:37:28', 1),
(26, 'LivingRoom', '2025-11-07 03:39:48', 1),
(27, 'LivingRoom', '2025-11-07 03:39:59', 1),
(28, 'LivingRoom', '2025-11-07 03:40:01', 1),
(29, 'LivingRoom', '2025-11-07 03:40:12', 1),
(30, 'LivingRoom', '2025-11-07 03:40:16', 1),
(31, 'LivingRoom', '2025-11-07 03:40:26', 1),
(32, 'LivingRoom', '2025-11-07 03:40:30', 1),
(33, 'LivingRoom', '2025-11-07 03:41:08', 1),
(34, 'LivingRoom', '2025-11-07 03:41:11', 1),
(35, 'LivingRoom', '2025-11-07 03:41:40', 1),
(36, 'LivingRoom', '2025-11-07 03:41:45', 1),
(37, 'LivingRoom', '2025-11-07 03:42:25', 1),
(38, 'LivingRoom', '2025-11-07 03:42:28', 1),
(39, 'LivingRoom', '2025-11-07 03:43:10', 1),
(40, 'LivingRoom', '2025-11-07 03:43:15', 1),
(41, 'LivingRoom', '2025-11-07 03:44:02', 1),
(42, 'LivingRoom', '2025-11-07 03:44:08', 1),
(43, 'LivingRoom', '2025-11-07 03:45:00', 1),
(44, 'LivingRoom', '2025-11-07 03:45:05', 1),
(45, 'LivingRoom', '2025-11-07 03:45:51', 1),
(46, 'LivingRoom', '2025-11-07 03:45:58', 1),
(47, 'LivingRoom', '2025-11-07 03:46:50', 1),
(48, 'LivingRoom', '2025-11-07 03:46:53', 1),
(49, 'LivingRoom', '2025-11-07 03:47:43', 1),
(51, 'LivingRoom', '2025-11-07 03:48:40', 1),
(53, 'LivingRoom', '2025-11-07 03:49:35', 1),
(54, 'LivingRoom', '2025-11-07 03:49:38', 1),
(55, 'LivingRoom', '2025-11-07 05:44:14', 1),
(56, 'LivingRoom', '2025-11-07 05:44:44', 1),
(57, 'LivingRoom', '2025-11-07 06:14:42', 1),
(58, 'LivingRoom', '2025-11-07 06:15:07', 1),
(59, 'LivingRoom', '2025-11-07 06:15:09', 1),
(60, 'LivingRoom', '2025-11-07 06:15:59', 1),
(61, 'LivingRoom', '2025-11-07 06:16:04', 1),
(62, 'LivingRoom', '2026-03-11 08:11:22', 1),
(63, 'LivingRoom', '2026-03-11 08:18:49', 1),
(64, 'LivingRoom', '2026-03-11 08:18:55', 1),
(65, 'LivingRoom', '2026-03-11 08:19:43', 1),
(66, 'LivingRoom', '2026-03-11 08:19:47', 1),
(67, 'LivingRoom', '2026-03-11 08:20:37', 1),
(68, 'LivingRoom', '2026-03-11 08:20:41', 1),
(69, 'LivingRoom', '2026-03-11 08:21:30', 1),
(70, 'LivingRoom', '2026-03-11 08:21:34', 1),
(71, 'LivingRoom', '2026-03-11 08:22:23', 1),
(72, 'LivingRoom', '2026-03-11 08:22:26', 1),
(73, 'LivingRoom', '2026-03-11 08:23:15', 1),
(74, 'LivingRoom', '2026-03-11 08:23:21', 1),
(75, 'LivingRoom', '2026-03-11 08:24:10', 1),
(76, 'LivingRoom', '2026-03-11 08:24:14', 1),
(77, 'LivingRoom', '2026-03-11 08:25:03', 1),
(78, 'LivingRoom', '2026-03-11 08:25:07', 1),
(79, 'LivingRoom', '2026-03-11 08:25:56', 1),
(80, 'LivingRoom', '2026-03-11 08:26:01', 1),
(81, 'LivingRoom', '2026-03-11 08:26:50', 1),
(82, 'LivingRoom', '2026-03-11 08:26:55', 1),
(83, 'LivingRoom', '2026-03-11 08:31:18', 1),
(84, 'LivingRoom', '2026-03-11 08:31:23', 1),
(85, 'LivingRoom', '2026-03-11 08:32:12', 1),
(86, 'LivingRoom', '2026-03-11 08:34:08', 1),
(87, 'LivingRoom', '2026-03-11 08:34:54', 1),
(88, 'LivingRoom', '2026-03-11 08:35:01', 1),
(89, 'LivingRoom', '2026-03-11 08:35:51', 1),
(90, 'LivingRoom', '2026-03-11 08:36:37', 1),
(91, 'LivingRoom', '2026-03-11 08:36:41', 1),
(92, 'LivingRoom', '2026-03-11 08:37:30', 1),
(93, 'LivingRoom', '2026-03-11 08:45:39', 1),
(94, 'LivingRoom', '2026-03-11 08:46:31', 1),
(95, 'LivingRoom', '2026-03-11 08:47:19', 1),
(96, 'LivingRoom', '2026-03-11 08:47:30', 1),
(97, 'LivingRoom', '2026-03-11 08:48:19', 1),
(98, 'LivingRoom', '2026-03-11 08:48:23', 1),
(99, 'LivingRoom', '2026-03-11 08:49:12', 1),
(100, 'LivingRoom', '2026-03-11 08:49:16', 1),
(101, 'LivingRoom', '2026-03-11 08:50:06', 1),
(102, 'LivingRoom', '2026-03-11 08:50:10', 1),
(103, 'LivingRoom', '2026-03-11 08:52:02', 1),
(104, 'LivingRoom', '2026-03-11 08:54:24', 1),
(105, 'LivingRoom', '2026-03-11 08:55:29', 1),
(106, 'LivingRoom', '2026-03-11 09:01:56', 1),
(107, 'LivingRoom', '2026-03-11 09:03:02', 1),
(108, 'LivingRoom', '2026-03-11 09:04:48', 1),
(109, 'LivingRoom', '2026-03-11 09:05:53', 1),
(110, 'LivingRoom', '2026-03-11 09:06:59', 1),
(111, 'LivingRoom', '2026-03-11 09:08:08', 1),
(112, 'LivingRoom', '2026-03-11 09:09:13', 1),
(113, 'LivingRoom', '2026-03-12 07:24:10', 1),
(114, 'LivingRoom', '2026-03-12 07:25:15', 1),
(115, 'LivingRoom', '2026-03-12 07:26:21', 1),
(116, 'LivingRoom', '2026-03-12 07:27:36', 1),
(117, 'LivingRoom', '2026-03-12 07:28:42', 1),
(118, 'LivingRoom', '2026-03-12 07:29:47', 1),
(119, 'LivingRoom', '2026-03-12 07:30:53', 1),
(120, 'LivingRoom', '2026-03-12 07:32:02', 1),
(121, 'LivingRoom', '2026-03-12 07:33:08', 1),
(122, 'LivingRoom', '2026-03-16 04:30:17', 1),
(123, 'LivingRoom', '2026-03-16 04:45:15', 1),
(124, 'LivingRoom', '2026-03-15 19:32:15', 1),
(125, 'LivingRoom', '2026-03-15 17:30:17', 1),
(126, 'LivingRoom', '2026-03-15 16:33:05', 1),
(127, 'LivingRoom', '2026-03-15 16:44:19', 1),
(128, 'LivingRoom', '2026-03-16 16:31:12', 1),
(129, 'LivingRoom', '2026-03-16 17:31:17', 1),
(130, 'LivingRoom', '2026-03-16 18:26:13', 1),
(131, 'LivingRoom', '2026-03-16 19:54:16', 1),
(132, 'LivingRoom', '2026-03-16 22:24:12', 1),
(133, 'LivingRoom', '2026-03-16 23:08:15', 1),
(134, 'LivingRoom', '2026-03-16 23:56:12', 1),
(135, 'LivingRoom', '2026-03-17 16:24:19', 1),
(136, 'LivingRoom', '2026-03-17 17:12:16', 1),
(137, 'LivingRoom', '2026-03-17 17:25:15', 1),
(138, 'LivingRoom', '2026-03-17 19:16:16', 1),
(139, 'LivingRoom', '2026-03-17 21:13:14', 1),
(140, 'LivingRoom', '2026-03-17 21:17:18', 1),
(141, 'LivingRoom', '2026-03-17 21:32:12', 1),
(142, 'LivingRoom', '2026-03-17 22:13:16', 1),
(143, 'LivingRoom', '2026-03-17 22:35:16', 1),
(144, 'LivingRoom', '2026-03-17 22:56:34', 1),
(145, 'LivingRoom', '2026-03-17 23:12:14', 1),
(146, 'LivingRoom', '2026-03-18 17:45:35', 1),
(147, 'LivingRoom', '2026-03-18 17:50:12', 1),
(148, 'LivingRoom', '2026-03-18 17:57:23', 1),
(149, 'LivingRoom', '2026-03-18 18:22:55', 1),
(150, 'LivingRoom', '2026-03-18 19:09:12', 1),
(151, 'LivingRoom', '2026-03-18 19:35:16', 1),
(152, 'LivingRoom', '2026-03-18 19:56:11', 1),
(153, 'LivingRoom', '2026-03-18 20:32:12', 1),
(154, 'LivingRoom', '2026-03-19 17:12:12', 1),
(155, 'LivingRoom', '2026-03-19 17:50:44', 1),
(156, 'LivingRoom', '2026-03-19 18:25:15', 1),
(157, 'LivingRoom', '2026-03-19 19:34:30', 1),
(158, 'LivingRoom', '2026-03-19 19:50:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sensors`
--

CREATE TABLE `sensors` (
  `sensor_id` int(11) NOT NULL,
  `sensor_name` varchar(100) NOT NULL,
  `homeowner_name` varchar(100) NOT NULL,
  `block` varchar(20) NOT NULL,
  `lot` varchar(20) NOT NULL,
  `location_name` varchar(150) NOT NULL,
  `house_area` varchar(100) NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'offline',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `mac_address` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sensors`
--

INSERT INTO `sensors` (`sensor_id`, `sensor_name`, `homeowner_name`, `block`, `lot`, `location_name`, `house_area`, `latitude`, `longitude`, `status`, `created_at`, `mac_address`) VALUES
(1, 'Sensor 1', 'Charlie', '12', '2', 'Amaia Scapes', 'Livingroom', NULL, NULL, 'offline', '2026-04-26 04:37:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sensor_status`
--

CREATE TABLE `sensor_status` (
  `sensor` varchar(50) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `last_ping` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sensor_status`
--

INSERT INTO `sensor_status` (`sensor`, `status`, `last_ping`) VALUES
('PIR_LivingRoom', 'online', '2026-03-12 15:37:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `FULLNAME` varchar(255) DEFAULT NULL,
  `EMAIL` varchar(255) DEFAULT NULL,
  `CONTACT_NUM` int(11) DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'user',
  `reset_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `FULLNAME`, `EMAIL`, `CONTACT_NUM`, `PASSWORD`, `role`, `reset_code`) VALUES
(5, 'Gabriel Limsiaco', 'admin@gmail.com', 2147483647, '$2y$10$k9Gx59pjqjctnQ1ZrcSzp.xg3Fls7raA1fZJd5fRO74W3SDry32Q2', 'user', NULL),
(6, 'Gabriel Limsiaco', 'admin2@gmail.com', 2147483647, '$2y$10$OJaFGjTT8dk5tRsqaKxhNOWMiH4H/BF7PU.YYzjYMO4ss1lwaPcge', 'user', NULL),
(7, 'akunah', 'akunah@gmail.com', 2147483647, '$2y$10$GG9ZI973IIxfkL5/56iKdux1CnmXPNIHFmYZ.hzExBej/0cuIJTnC', 'user', NULL),
(8, 'janreb', 'janreb@gmail.com', 2147483647, '$2y$10$zd5vtPEB4hGkg8N1Zffwc.q/bu.ON8iZBTYYDibM56PEyyHLWOlii', 'user', NULL),
(9, 'Janreb', 'piad@gmail.com', 2147483647, '$2y$10$Qse9ff53Bp5P9F3dhKj4h.fAztctvsMgydIAEH9LjJHU1Lv77OH8K', 'user', NULL),
(10, 'carlluis', 'cama.gonzales.ui@phinmaed.com', 2147483647, '$2y$10$K4yr4f9IyoGfmBGBtg7eAOi3/alo2MCsQVnrr.k5V7peC0H6yJXi2', 'user', NULL),
(11, 'Charlie Antolino', 'c.antolino23@gmail.com', 2147483647, '$2y$10$35JtbIfW4yTnXwQWNKP71.XZpkrbDYUCaIqNrNtEUD1GMhPn0cKBe', 'user', NULL),
(12, 'janreb', 'janreb123@gmail.com', 2147483647, '$2y$10$o7y1wXcMvh5zo3ZXHYMmFOlbmsYqIFPK2YJZKPxB9k1CwZrzTBili', 'user', NULL),
(13, 'Janreb', 'piad12@gmail.com', 2147483647, '$2y$10$kxW0y3WMOv2sdeG1yXW1rOrpab..PrLVp/QwMRujcTgL0TDED02xm', 'user', NULL),
(14, 'Admin', 'admin@system.com', 2147483647, '$2y$10$y/SkrOAgDwJRnEw6LbMc/epLHDbbglu91qkKKOtx8TUmSxXrmSpX2', 'admin', NULL),
(15, 'JANREB', 'piadj08@gmail.com', 2147483647, '$2y$10$SQ2kBTYmFdWn3kX1fZwade1KP5JeunXsQADx/oPM1ZUPznAAeYbp2', 'user', '180605');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dial_num`
--
ALTER TABLE `dial_num`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `motion_alerts`
--
ALTER TABLE `motion_alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sensors`
--
ALTER TABLE `sensors`
  ADD PRIMARY KEY (`sensor_id`);

--
-- Indexes for table `sensor_status`
--
ALTER TABLE `sensor_status`
  ADD PRIMARY KEY (`sensor`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dial_num`
--
ALTER TABLE `dial_num`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `motion_alerts`
--
ALTER TABLE `motion_alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `sensors`
--
ALTER TABLE `sensors`
  MODIFY `sensor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
