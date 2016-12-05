-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 04, 2016 at 11:43 AM
-- Server version: 5.5.51-38.2
-- PHP Version: 5.4.31
DROP DATABASE chulien_thesis_db;
CREATE DATABASE chulien_thesis_db;
USE chulien_thesis_db;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `chulien_thesis_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ACTIVITY_LOG_TB`
--

CREATE TABLE IF NOT EXISTS `ACTIVITY_LOG_TB` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `processed_date` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=619 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ACTIVITY_LOG_TB`
--

INSERT INTO `ACTIVITY_LOG_TB` (`id`, `user_id`, `description`, `processed_date`) VALUES
(1, 1, 'Logged out', '2016-11-04 05:08:28'),
(2, 1, 'Logged in', '2016-11-04 05:09:59'),
(3, 1, 'Created ''daily plan'' plan', '2016-11-04 09:57:36'),
(4, 1, 'Updated ''day'' duration', '2016-11-04 09:58:02'),
(5, 1, 'Deleted ''daily plan'' plan', '2016-11-04 10:02:38'),
(6, 1, 'Updated ''day'' duration', '2016-11-04 10:07:28'),
(7, 1, 'Logged in', '2016-11-04 11:53:02'),
(8, 1, 'Logged in', '2016-11-04 14:42:28'),
(9, 1, 'Logged in', '2016-11-04 17:02:34'),
(10, 1, 'Logged in', '2016-11-04 17:03:22'),
(11, 1, 'Updated ''other'' duration', '2016-11-04 17:04:11'),
(12, 1, 'Logged in', '2016-11-04 18:52:34'),
(13, 1, 'Logged in', '2016-11-04 18:54:36'),
(14, 1, 'Added Cesar Nazario as an Admin.', '2016-11-04 18:58:37'),
(15, 1, 'Logged out', '2016-11-04 18:59:16'),
(16, 2, 'Logged in', '2016-11-04 18:59:32'),
(17, 2, 'Logged out', '2016-11-04 19:00:50'),
(18, 1, 'Logged in', '2016-11-04 19:01:04'),
(19, 1, 'Logged in', '2016-11-04 20:44:56'),
(20, 1, 'Logged in', '2016-11-04 23:21:23'),
(21, 1, 'Created ''Weekly Plan Small'' plan', '2016-11-04 23:25:19'),
(22, 1, 'Deleted ''Weekly Plan Small'' plan', '2016-11-04 23:28:20'),
(23, 1, 'Created ''Weekly Plan Small'' plan', '2016-11-04 23:30:20'),
(24, 1, 'Updated ''week'' duration', '2016-11-04 23:32:07'),
(25, 1, 'Logged in', '2016-11-04 23:40:47'),
(26, 3, 'Registered to One Coin', '2016-11-04 23:41:55'),
(27, 3, 'Logged in', '2016-11-04 23:41:55'),
(28, 1, 'Created ''afadad'' plan', '2016-11-04 23:44:10'),
(29, 1, 'Deleted ''afadad'' plan', '2016-11-04 23:50:59'),
(30, 1, 'Deleted ''Weekly Plan Small'' plan', '2016-11-04 23:53:48'),
(31, 1, 'Created ''Weekly Plan Small'' plan', '2016-11-04 23:54:13'),
(32, 1, 'Created ''Weekly Plan Medium'' plan', '2016-11-05 00:05:13'),
(33, 1, 'Created ''Weekly Plan Large'' plan', '2016-11-05 00:09:22'),
(34, 1, 'Created ''Monthly Plan Small'' plan', '2016-11-05 00:11:36'),
(35, 1, 'Created ''Monthly Plan Medium'' plan', '2016-11-05 00:14:25'),
(36, 1, 'Created ''Monthly Plan Large'' plan', '2016-11-05 00:17:32'),
(37, 1, 'Created ''Yearly Plan Small'' plan', '2016-11-05 00:20:03'),
(38, 1, 'Created ''Yearly Plan Medium'' plan', '2016-11-05 00:25:30'),
(39, 1, 'Created ''Yearly Plan Large'' plan', '2016-11-05 00:27:30'),
(40, 1, 'Created ''Mid-Year Pioneer Promo'' plan', '2016-11-05 01:01:47'),
(41, 1, 'Logged out', '2016-11-05 01:29:30'),
(42, 1, 'Logged in', '2016-11-05 01:29:37'),
(43, 1, 'Changed Password', '2016-11-05 01:30:39'),
(44, 1, 'Logged out', '2016-11-05 01:30:46'),
(45, 1, 'Logged in', '2016-11-05 01:30:56'),
(46, 1, 'Logged out', '2016-11-05 02:25:30'),
(47, 1, 'Logged in', '2016-11-05 02:29:57'),
(48, 1, 'Blocked Business Owner ken lopez', '2016-11-05 02:30:13'),
(49, 1, 'Logged out', '2016-11-05 02:36:21'),
(50, 1, 'Logged in', '2016-11-05 02:43:21'),
(51, 1, 'Logged out', '2016-11-05 02:45:33'),
(52, 1, 'Logged in', '2016-11-05 02:52:50'),
(53, 1, 'Logged out', '2016-11-05 02:53:42'),
(54, 4, 'Registered to One Coin', '2016-11-05 03:13:26'),
(55, 5, 'Registered to One Coin', '2016-11-05 03:22:09'),
(56, 7, 'Registered to One Coin', '2016-11-05 03:26:08'),
(57, 8, 'Registered to One Coin', '2016-11-05 03:27:55'),
(58, 8, 'Verified Account.', '2016-11-05 03:28:12'),
(59, 8, 'Logged in', '2016-11-05 03:28:31'),
(60, 8, 'Logged out', '2016-11-05 03:28:50'),
(61, 1, 'Logged in', '2016-11-05 03:29:04'),
(62, 9, 'Registered to One Coin', '2016-11-05 03:32:01'),
(63, 1, 'Logged out', '2016-11-05 03:32:33'),
(64, 1, 'Logged in', '2016-11-05 03:59:22'),
(65, 1, 'Logged out', '2016-11-05 03:59:59'),
(66, 2, 'Logged in', '2016-11-05 04:00:08'),
(67, 2, 'Logged out', '2016-11-05 04:25:29'),
(68, 1, 'Logged in', '2016-11-05 04:27:13'),
(69, 1, 'Logged out', '2016-11-05 10:09:55'),
(70, 1, 'Logged in', '2016-11-05 10:57:15'),
(71, 1, 'Updated ''day'' duration', '2016-11-05 12:45:22'),
(72, 1, 'Updated ''week'' duration', '2016-11-05 12:45:49'),
(73, 1, 'Updated ''month'' duration', '2016-11-05 12:46:02'),
(74, 1, 'Updated ''year'' duration', '2016-11-05 12:46:15'),
(75, 1, 'Updated ''other'' duration', '2016-11-05 12:47:19'),
(76, 1, 'Updated Fast Food category', '2016-11-05 12:50:35'),
(77, 1, 'Updated Fast Food category', '2016-11-05 12:51:24'),
(78, 1, 'Updated Hospital category', '2016-11-05 12:52:10'),
(79, 1, 'Updated Hotel category', '2016-11-05 12:52:51'),
(80, 1, 'Updated Salon category', '2016-11-05 12:54:25'),
(81, 1, 'Updated Bank category', '2016-11-05 12:55:05'),
(82, 1, 'Logged out', '2016-11-05 12:57:05'),
(83, 9, 'Verified Account.', '2016-11-05 12:59:18'),
(84, 9, 'Logged in', '2016-11-05 12:59:56'),
(85, 9, 'Logged out', '2016-11-05 13:00:39'),
(86, 9, 'Logged in', '2016-11-05 13:01:05'),
(87, 9, 'Purchased a subscription: 1 ESTABLISHMENTS, 3 BRANCHES PER BUSINESS for: JPY 10000 [PlanID - 8]', '2016-11-05 13:02:13'),
(88, 9, 'Added an Establishment: BPI [EstablishmentID - 1]', '2016-11-05 13:10:38'),
(89, 9, 'Plotted a branch of BPI at 76 Paseo del Congreso St, Malolos, 3000 Bulacan, Philippines [branchID - 1]', '2016-11-05 13:13:17'),
(90, 10, 'Registered to One Coin', '2016-11-05 13:22:23'),
(91, 1, 'Logged in', '2016-11-05 13:34:21'),
(92, 1, 'Logged in', '2016-11-05 13:34:56'),
(93, 1, 'Logged out', '2016-11-05 13:35:12'),
(94, 9, 'Logged in', '2016-11-05 13:35:24'),
(95, 9, 'Logged out', '2016-11-05 13:36:06'),
(96, 9, 'Logged in', '2016-11-05 13:36:18'),
(97, 9, 'Logged out', '2016-11-05 13:36:49'),
(98, 9, 'Logged in', '2016-11-05 13:37:03'),
(99, 9, 'Logged in', '2016-11-05 13:58:43'),
(100, 9, 'Logged in', '2016-11-05 14:00:48'),
(101, 9, 'Logged out', '2016-11-05 14:01:03'),
(102, 9, 'Logged in', '2016-11-05 14:02:52'),
(103, 9, 'Logged out', '2016-11-05 14:04:33'),
(104, 1, 'Logged in', '2016-11-05 14:04:51'),
(105, 1, 'Logged out', '2016-11-05 14:34:12'),
(106, 9, 'Logged in', '2016-11-05 14:34:31'),
(107, 9, 'Purchased a subscription: 3 ESTABLISHMENTS, 10 BRANCHES PER BUSINESS for: JPY 50000 [PlanID - 9]', '2016-11-05 14:44:57'),
(108, 9, 'Logged out', '2016-11-05 14:45:20'),
(109, 1, 'Logged in', '2016-11-05 14:45:37'),
(110, 1, 'Purchased a subscription: 1 ESTABLISHMENTS, 3 BRANCHES PER BUSINESS for: JPY 3000 [PlanID - 5]', '2016-11-05 14:47:39'),
(111, 1, 'Logged out', '2016-11-05 14:48:14'),
(112, 9, 'Logged in', '2016-11-05 14:48:45'),
(113, 9, 'Purchased a subscription: 1 ESTABLISHMENTS, 3 BRANCHES PER BUSINESS for: JPY 3000 [PlanID - 5]', '2016-11-05 14:49:13'),
(114, 9, 'Logged out', '2016-11-05 14:49:21'),
(115, 1, 'Logged in', '2016-11-05 14:49:31'),
(116, 9, 'Logged in', '2016-11-05 15:31:45'),
(117, 9, 'Updated branch contact number of BPI [branchID - 1] from none to 09363424180', '2016-11-05 15:32:46'),
(118, 9, 'Configured Branch Business Hours of BPI [branchID - 1] at 76 Paseo del Congreso St, Malolos, 3000 Bulacan, Philippines', '2016-11-05 15:33:04'),
(119, 9, 'Updated branch description of BPI [branchID - 1] from none to Make the best happen.', '2016-11-05 15:33:19'),
(120, 1, 'Logged out', '2016-11-05 15:50:18'),
(121, 9, 'Logged in', '2016-11-05 15:52:37'),
(122, 9, 'Logged out', '2016-11-05 16:08:00'),
(123, 1, 'Logged in', '2016-11-05 16:08:47'),
(124, 11, 'Registered to One Coin', '2016-11-05 17:17:46'),
(125, 12, 'Registered to One Coin', '2016-11-05 17:29:15'),
(126, 13, 'Registered to One Coin', '2016-11-05 17:42:19'),
(127, 14, 'Registered to One Coin', '2016-11-05 17:57:33'),
(128, 1, 'Logged out', '2016-11-05 18:03:01'),
(129, 9, 'Logged in', '2016-11-05 18:03:48'),
(130, 9, 'Logged out', '2016-11-05 18:19:11'),
(131, 9, 'Logged in', '2016-11-05 18:24:31'),
(132, 9, 'Plotted a branch of BPI at 3 Paseo del Congreso St, Malolos, 3000 Bulacan, Philippines [branchID - 2]', '2016-11-05 18:26:48'),
(133, 15, 'Registered to One Coin', '2016-11-06 00:46:41'),
(134, 1, 'Logged in', '2016-11-06 00:53:49'),
(135, 1, 'Logged in', '2016-11-06 00:54:23'),
(136, 9, 'Logged in', '2016-11-06 01:56:12'),
(137, 9, 'Logged in', '2016-11-06 01:56:43'),
(138, 9, 'Logged in', '2016-11-06 02:12:54'),
(139, 9, 'Logged in', '2016-11-06 02:13:06'),
(140, 9, 'Logged in', '2016-11-06 02:32:54'),
(141, 9, 'Logged in', '2016-11-06 02:33:11'),
(142, 9, 'Logged in', '2016-11-06 14:54:48'),
(143, 9, 'Logged in', '2016-11-06 14:55:04'),
(144, 9, 'Added a photo to a branch gallery of BPI [branchID - 1]', '2016-11-06 15:18:02'),
(145, 9, 'Added a photo to a branch gallery of BPI [branchID - 1]', '2016-11-06 15:18:06'),
(146, 9, 'Logged out', '2016-11-06 15:36:53'),
(147, 1, 'Logged in', '2016-11-06 15:37:16'),
(148, 9, 'Logged in', '2016-11-06 17:18:48'),
(149, 9, 'Logged out', '2016-11-06 17:37:32'),
(150, 9, 'Logged in', '2016-11-06 17:57:37'),
(151, 1, 'Logged in', '2016-11-06 18:50:14'),
(152, 1, 'Logged in', '2016-11-06 18:50:49'),
(153, 1, 'Logged out', '2016-11-06 19:20:53'),
(154, 16, 'Registered to One Coin', '2016-11-06 20:03:25'),
(155, 17, 'Registered to One Coin', '2016-11-06 20:14:01'),
(156, 1, 'Logged in', '2016-11-06 22:11:06'),
(157, 1, 'Logged out', '2016-11-06 22:26:08'),
(158, 1, 'Logged in', '2016-11-06 22:37:02'),
(159, 1, 'Added Aljon Cruz as an Admin.', '2016-11-06 22:38:12'),
(160, 1, 'Logged out', '2016-11-06 22:41:29'),
(161, 1, 'Logged in', '2016-11-06 22:50:13'),
(162, 1, 'Logged out', '2016-11-06 22:50:51'),
(163, 19, 'Registered to One Coin', '2016-11-06 23:00:08'),
(164, 20, 'Registered to One Coin', '2016-11-06 23:01:17'),
(165, 1, 'Logged in', '2016-11-06 23:01:29'),
(166, 1, 'Logged in', '2016-11-06 23:04:03'),
(167, 1, 'Blocked Business Owner edward edward', '2016-11-06 23:04:46'),
(168, 21, 'Registered to One Coin', '2016-11-06 23:08:09'),
(169, 21, 'Verified Account.', '2016-11-06 23:14:50'),
(170, 21, 'Logged in', '2016-11-06 23:17:33'),
(171, 1, 'Logged out', '2016-11-06 23:17:53'),
(172, 9, 'Logged in', '2016-11-06 23:29:33'),
(173, 21, 'Purchased a subscription: 1 ESTABLISHMENTS, 3 BRANCHES PER BUSINESS for: JPY 10000 [PlanID - 8]', '2016-11-06 23:29:40'),
(174, 9, 'Logged out', '2016-11-06 23:31:31'),
(175, 1, 'Logged in', '2016-11-06 23:31:41'),
(176, 1, 'Logged out', '2016-11-06 23:32:57'),
(177, 21, 'Added an Establishment: ABC''s Cafe [EstablishmentID - 2]', '2016-11-06 23:40:06'),
(178, 21, 'Plotted a branch of ABC''s Cafe at SM City Clark Bldg., Clark Freeport, Angeles, Pampanga, Philippines [branchID - 3]', '2016-11-06 23:41:58'),
(179, 21, 'Updated a branch of ABC''s Cafe [branchID - 3] coordinates from position[15.168748,120.581055] to position[15.162576008095611,120.57298781528323]', '2016-11-06 23:43:13'),
(180, 21, 'Updated a branch of ABC''s Cafe [branchID - 3] coordinates from position[15.162576,120.572990] to position[15.152966035233254,120.55393340244143]', '2016-11-06 23:43:27'),
(181, 21, 'Updated a branch of ABC''s Cafe [branchID - 3] coordinates from position[15.152966,120.553932] to position[15.062809903346018,120.56491973056643]', '2016-11-06 23:43:53'),
(182, 21, 'Updated a branch of ABC''s Cafe [branchID - 3] coordinates from position[15.062810,120.564919] to position[15.062146848902835,120.66379668369143]', '2016-11-06 23:44:15'),
(183, 21, 'Plotted a branch of ABC''s Cafe at Sampaguita Main Road, San Fernando, Pampanga, Philippines [branchID - 4]', '2016-11-06 23:44:27'),
(184, 21, 'Updated a branch of ABC''s Cafe [branchID - 3] coordinates from position[15.062147,120.663795] to position[15.058209920620111,120.64791800632327]', '2016-11-06 23:44:56'),
(185, 21, 'Updated a branch of ABC''s Cafe [branchID - 3] coordinates from position[15.058210,120.647919] to position[15.061732438827244,120.65027835025637]', '2016-11-06 23:44:58'),
(186, 21, 'Deleted a branch of ABC''s Cafe [branchID - 3]', '2016-11-06 23:45:09'),
(187, 21, 'Updated a branch of ABC''s Cafe [branchID - 4] coordinates from position[15.055361,120.658607] to position[15.059463547224336,120.64680755138397]', '2016-11-06 23:45:21'),
(188, 21, 'Updated a branch of ABC''s Cafe [branchID - 4] coordinates from position[15.059464,120.646805] to position[14.856469747247328,120.81434905529022]', '2016-11-06 23:46:22'),
(189, 21, 'Updated a branch of ABC''s Cafe [branchID - 4] coordinates from position[14.856470,120.814346] to position[14.861198499141757,120.81022918224335]', '2016-11-06 23:47:13'),
(190, 21, 'Updated a branch of ABC''s Cafe [branchID - 4] coordinates from position[14.861198,120.810226] to position[14.861074059629054,120.80870568752289]', '2016-11-06 23:47:53'),
(191, 21, 'Updated a branch of ABC''s Cafe [branchID - 4] coordinates from position[14.861074,120.808708] to position[14.861063689666436,120.80887198448181]', '2016-11-06 23:47:55'),
(192, 21, 'Updated a branch of ABC''s Cafe [branchID - 4] coordinates from position[14.861064,120.808868] to position[14.860762960533545,120.80935478210449]', '2016-11-06 23:47:58'),
(193, 21, 'Updated a branch of ABC''s Cafe [branchID - 4] coordinates from position[14.860763,120.809357] to position[14.856946775160338,120.8131742477417]', '2016-11-06 23:48:28'),
(194, 21, 'Updated a branch of ABC''s Cafe [branchID - 4] coordinates from position[14.856947,120.813171] to position[14.856780852527475,120.81437587738037]', '2016-11-06 23:48:30'),
(195, 21, 'Updated a branch of ABC''s Cafe [branchID - 4] coordinates from position[14.856781,120.814377] to position[14.856739371849345,120.81368923187256]', '2016-11-06 23:48:32'),
(196, 21, 'Updated branch description of ABC''s Cafe [branchID - 4] from none to Visit us!', '2016-11-06 23:49:40'),
(197, 21, 'Configured Branch Business Hours of ABC''s Cafe [branchID - 4] at MacArthur Hwy, Malolos, Bulacan, Philippines', '2016-11-06 23:50:12'),
(198, 21, 'Configured Branch Business Hours of ABC''s Cafe [branchID - 4] at MacArthur Hwy, Malolos, Bulacan, Philippines', '2016-11-06 23:50:37'),
(199, 21, 'Configured Branch Business Hours of ABC''s Cafe [branchID - 4] at MacArthur Hwy, Malolos, Bulacan, Philippines', '2016-11-06 23:50:40'),
(200, 21, 'Added a photo to a branch gallery of ABC''s Cafe [branchID - 4]', '2016-11-06 23:50:50'),
(201, 21, 'Added a photo to a branch gallery of ABC''s Cafe [branchID - 4]', '2016-11-06 23:50:51'),
(202, 21, 'Updated branch contact number of ABC''s Cafe [branchID - 4] from none to 09265190527', '2016-11-06 23:52:55'),
(203, 21, 'Plotted a branch of ABC''s Cafe at SM City Clark Bldg., Clark Freeport, Angeles, Pampanga, Philippines [branchID - 5]', '2016-11-06 23:55:31'),
(204, 21, 'Updated branch description of ABC''s Cafe [branchID - 5] from none to All sweets are here!', '2016-11-06 23:56:20'),
(205, 21, 'Updated branch contact number of ABC''s Cafe [branchID - 5] from none to 09265190527', '2016-11-06 23:56:30'),
(206, 21, 'Configured Branch Business Hours of ABC''s Cafe [branchID - 5] at SM City Clark Bldg., Clark Freeport, Angeles, Pampanga, Philippines', '2016-11-06 23:56:43'),
(207, 21, 'Added a photo to a branch gallery of ABC''s Cafe [branchID - 5]', '2016-11-06 23:56:46'),
(208, 21, 'Added a photo to a branch gallery of ABC''s Cafe [branchID - 5]', '2016-11-06 23:56:49'),
(209, 1, 'Logged out', '2016-11-06 23:57:49'),
(210, 9, 'Logged in', '2016-11-06 23:57:59'),
(211, 9, 'Logged out', '2016-11-06 23:59:07'),
(212, 1, 'Logged in', '2016-11-06 23:59:24'),
(213, 21, 'Plotted a branch of ABC''s Cafe at 86 Hangga St, Malolos, Bulacan, Philippines [branchID - 6]', '2016-11-07 00:02:39'),
(214, 21, 'Updated a branch of ABC''s Cafe [branchID - 6] coordinates from position[14.854313,120.802292] to position[14.857942308280693,120.8043497800827]', '2016-11-07 00:02:46'),
(215, 21, 'Updated a branch of ABC''s Cafe [branchID - 6] coordinates from position[14.857942,120.804352] to position[14.859788180465202,120.8044570684433]', '2016-11-07 00:02:48'),
(216, 21, 'Deleted a branch of ABC''s Cafe [branchID - 6]', '2016-11-07 00:02:55'),
(217, 21, 'Plotted a branch of ABC''s Cafe at MacArthur Hwy, Apalit, Pampanga, Philippines [branchID - 7]', '2016-11-07 00:03:52'),
(218, 21, 'Updated branch description of ABC''s Cafe [branchID - 7] from none to Visit us!', '2016-11-07 00:04:13'),
(219, 21, 'Updated branch contact number of ABC''s Cafe [branchID - 7] from none to 09265190527', '2016-11-07 00:04:21'),
(220, 21, 'Configured Branch Business Hours of ABC''s Cafe [branchID - 7] at MacArthur Hwy, Apalit, Pampanga, Philippines', '2016-11-07 00:04:51'),
(221, 21, 'Added a photo to a branch gallery of ABC''s Cafe [branchID - 7]', '2016-11-07 00:04:56'),
(222, 21, 'Added a photo to a branch gallery of ABC''s Cafe [branchID - 7]', '2016-11-07 00:04:58'),
(223, 1, 'Logged out', '2016-11-07 00:05:56'),
(224, 21, 'Logged out', '2016-11-07 00:33:55'),
(225, 21, 'Logged in', '2016-11-07 01:29:14'),
(226, 1, 'Logged in', '2016-11-07 02:16:55'),
(227, 21, 'Purchased a subscription: 1 ESTABLISHMENTS, 3 BRANCHES PER BUSINESS for: JPY 100000 [PlanID - 11]', '2016-11-07 02:58:11'),
(228, 1, 'Logged in', '2016-11-07 12:15:19'),
(229, 1, 'Logged in', '2016-11-07 12:15:34'),
(230, 1, 'Logged in', '2016-11-07 15:38:46'),
(231, 9, 'Logged in', '2016-11-07 15:40:33'),
(232, 9, 'Logged out', '2016-11-07 15:50:07'),
(233, 1, 'Logged in', '2016-11-07 15:57:07'),
(234, 1, 'Logged out', '2016-11-07 15:57:12'),
(235, 1, 'Logged in', '2016-11-07 16:02:35'),
(236, 1, 'Logged out', '2016-11-07 16:02:49'),
(237, 18, 'Logged in', '2016-11-07 17:21:24'),
(238, 18, 'Purchased a subscription: 3 ESTABLISHMENTS, 10 BRANCHES PER BUSINESS for: JPY 50000 [PlanID - 9]', '2016-11-07 17:28:45'),
(239, 18, 'Created Unspecified category', '2016-11-07 17:32:35'),
(240, 18, 'Added an Establishment: Mindblendr''s Devs [EstablishmentID - 3]', '2016-11-07 17:34:04'),
(241, 18, 'Plotted a branch of Mindblendr''s Devs at Sevilla St, Malolos, Bulacan, Philippines [branchID - 8]', '2016-11-07 17:37:00'),
(242, 18, 'Configured Branch Business Hours of Mindblendr''s Devs [branchID - 8] at Sevilla St, Malolos, Bulacan, Philippines', '2016-11-07 17:38:44'),
(243, 18, 'Updated branch contact number of Mindblendr''s Devs [branchID - 8] from none to 09363424180', '2016-11-07 17:38:57'),
(244, 21, 'Logged out', '2016-11-07 17:39:25'),
(245, 18, 'Updated branch description of Mindblendr''s Devs [branchID - 8] from none to Mindblendr''s Devs main branch.', '2016-11-07 17:39:30'),
(246, 22, 'Registered to One Coin', '2016-11-07 17:46:13'),
(247, 18, 'Created Try category', '2016-11-07 17:46:36'),
(248, 18, 'Deleted ''Try'' category', '2016-11-07 17:46:58'),
(249, 18, 'Updated Others category', '2016-11-07 17:49:19'),
(250, 18, 'Created Try ulet category', '2016-11-07 17:50:06'),
(251, 18, 'Deleted ''Try ulet'' category', '2016-11-07 17:50:43'),
(252, 18, 'Added a photo to a branch gallery of Mindblendr''s Devs [branchID - 8]', '2016-11-07 17:58:19'),
(253, 18, 'Added a photo to a branch gallery of Mindblendr''s Devs [branchID - 8]', '2016-11-07 17:58:21'),
(254, 18, 'Added a photo to a branch gallery of Mindblendr''s Devs [branchID - 8]', '2016-11-07 17:58:25'),
(255, 18, 'Added a photo to a branch gallery of Mindblendr''s Devs [branchID - 8]', '2016-11-07 17:58:26'),
(256, 18, 'Added a photo to a branch gallery of Mindblendr''s Devs [branchID - 8]', '2016-11-07 17:58:27'),
(257, 18, 'Added a photo to a branch gallery of Mindblendr''s Devs [branchID - 8]', '2016-11-07 17:58:31'),
(258, 18, 'Removed a photo from a branch gallery of Mindblendr''s Devs [branchID - 8]', '2016-11-07 18:00:26'),
(259, 18, 'Removed a photo from a branch gallery of Mindblendr''s Devs [branchID - 8]', '2016-11-07 18:00:28'),
(260, 18, 'Added a photo to a branch gallery of Mindblendr''s Devs [branchID - 8]', '2016-11-07 18:00:29'),
(261, 18, 'Removed a photo from a branch gallery of Mindblendr''s Devs [branchID - 8]', '2016-11-07 18:00:32'),
(262, 18, 'Removed a photo from a branch gallery of Mindblendr''s Devs [branchID - 8]', '2016-11-07 18:00:34'),
(263, 18, 'Removed a photo from a branch gallery of Mindblendr''s Devs [branchID - 8]', '2016-11-07 18:00:34'),
(264, 18, 'Plotted a branch of Mindblendr''s Devs at Unnamed Road, Hagonoy, Bulacan, Philippines [branchID - 9]', '2016-11-07 18:06:10'),
(265, 9, 'Logged in', '2016-11-07 19:11:50'),
(266, 22, 'Verified Account.', '2016-11-07 20:37:35'),
(267, 22, 'Logged in', '2016-11-07 20:38:06'),
(268, 22, 'Purchased a subscription: 3 ESTABLISHMENTS, 10 BRANCHES PER BUSINESS for: JPY 50000 [PlanID - 9]', '2016-11-07 20:42:41'),
(269, 22, 'Added an Establishment: The Establishment Hotel [EstablishmentID - 4]', '2016-11-07 20:50:37'),
(270, 22, 'Plotted a branch of The Establishment Hotel at Unnamed Road, Mayantoc, Tarlac, Philippines [branchID - 10]', '2016-11-07 20:55:08'),
(271, 22, 'Updated a branch of The Establishment Hotel [branchID - 10] coordinates from position[15.570128,120.314331] to position[14.59421560250121,120.9570311754942]', '2016-11-07 20:55:55'),
(272, 22, 'Updated branch address of The Establishment Hotel [branchID - 10] from MICT S Access Rd, Tondo, Manila, Metro Manila, Philippines to MICT S Access Rd, Tondo, Manila, Metro Manila, Philippines', '2016-11-07 20:56:00'),
(273, 22, 'Updated a branch of The Establishment Hotel [branchID - 10] coordinates from position[14.594216,120.957031] to position[14.870469081612104,120.9515380114317]', '2016-11-07 20:56:11'),
(274, 22, 'Updated branch contact number of The Establishment Hotel [branchID - 10] from none to 09265678140', '2016-11-07 20:56:31'),
(275, 22, 'Configured Branch Business Hours of The Establishment Hotel [branchID - 10] at E De Guzman St, Pandi, Bulacan, Philippines', '2016-11-07 20:56:46'),
(276, 22, 'Added a photo to a branch gallery of The Establishment Hotel [branchID - 10]', '2016-11-07 20:56:52'),
(277, 22, 'Added a photo to a branch gallery of The Establishment Hotel [branchID - 10]', '2016-11-07 20:56:55'),
(278, 22, 'Added a photo to a branch gallery of The Establishment Hotel [branchID - 10]', '2016-11-07 20:56:59'),
(279, 22, 'Added a photo to a branch gallery of The Establishment Hotel [branchID - 10]', '2016-11-07 20:57:09'),
(280, 22, 'Added a photo to a branch gallery of The Establishment Hotel [branchID - 10]', '2016-11-07 20:57:11'),
(281, 22, 'Plotted a branch of The Establishment Hotel at Philippines [branchID - 11]', '2016-11-07 20:59:46'),
(282, 22, 'Updated a branch of The Establishment Hotel [branchID - 11] coordinates from position[8.540281,120.457611] to position[10.285193760871739,118.74374371021986]', '2016-11-07 21:00:01'),
(283, 22, 'Updated branch address of The Establishment Hotel [branchID - 11] from Unnamed Road, Puerto Princesa, Palawan, Philippines to Puerto Princesa, Palawan, Philippines', '2016-11-07 21:00:12'),
(284, 22, 'Updated branch contact number of The Establishment Hotel [branchID - 11] from none to 09265678140', '2016-11-07 21:00:25'),
(285, 22, 'Configured Branch Business Hours of The Establishment Hotel [branchID - 11] at Puerto Princesa, Palawan, Philippines', '2016-11-07 21:00:38'),
(286, 22, 'Added a photo to a branch gallery of The Establishment Hotel [branchID - 11]', '2016-11-07 21:00:48'),
(287, 22, 'Added a photo to a branch gallery of The Establishment Hotel [branchID - 11]', '2016-11-07 21:00:50'),
(288, 22, 'Added a photo to a branch gallery of The Establishment Hotel [branchID - 11]', '2016-11-07 21:00:58'),
(289, 22, 'Updated a branch of The Establishment Hotel [branchID - 10] coordinates from position[14.870469,120.951538] to position[15.101294658418702,120.60272209346294]', '2016-11-07 21:02:56'),
(290, 22, 'Updated branch address of The Establishment Hotel [branchID - 10] from Market Curve, Bacolor, Pampanga, Philippines to Bacolor, Pampanga, Philippines', '2016-11-07 21:03:09'),
(291, 22, 'Plotted a branch of The Establishment Hotel at Sicsican - Sto. Domingo Road, San Pascual, Talavera, Nueva Ecija, Philippines [branchID - 12]', '2016-11-07 21:03:21'),
(292, 22, 'Updated a branch of The Establishment Hotel [branchID - 12] coordinates from position[15.604520,120.916290] to position[15.652130960477153,120.90255735442042]', '2016-11-07 21:03:36'),
(293, 22, 'Updated a branch of The Establishment Hotel [branchID - 12] coordinates from position[15.652131,120.902557] to position[15.660065002155712,120.91903684660792]', '2016-11-07 21:03:51'),
(294, 22, 'Updated branch address of The Establishment Hotel [branchID - 12] from Unnamed Road, Talavera, Nueva Ecija, Philippines to Talavera, Nueva Ecija, Philippines', '2016-11-07 21:03:57'),
(295, 22, 'Updated branch contact number of The Establishment Hotel [branchID - 12] from none to 09265678140', '2016-11-07 21:04:11'),
(296, 22, 'Configured Branch Business Hours of The Establishment Hotel [branchID - 12] at Talavera, Nueva Ecija, Philippines', '2016-11-07 21:04:19'),
(297, 22, 'Added a photo to a branch gallery of The Establishment Hotel [branchID - 12]', '2016-11-07 21:04:29'),
(298, 22, 'Added a photo to a branch gallery of The Establishment Hotel [branchID - 12]', '2016-11-07 21:04:33'),
(299, 22, 'Edited Profile', '2016-11-07 21:09:59'),
(300, 22, 'Edited Profile', '2016-11-07 21:11:04'),
(301, 22, 'Logged out', '2016-11-07 21:15:17'),
(302, 22, 'Logged in', '2016-11-07 21:15:35'),
(303, 22, 'Edited Profile', '2016-11-07 21:16:24'),
(304, 9, 'Logged in', '2016-11-07 21:18:04'),
(305, 9, 'Logged in', '2016-11-07 21:18:14'),
(306, 9, 'Edited Profile', '2016-11-07 21:18:37'),
(307, 22, 'Edited Profile', '2016-11-07 21:19:13'),
(308, 22, 'Edited Profile', '2016-11-07 21:19:58'),
(309, 9, 'Edited Profile', '2016-11-07 21:21:30'),
(310, 22, 'Logged out', '2016-11-07 21:22:28'),
(311, 21, 'Logged in', '2016-11-07 21:22:40'),
(312, 21, 'Edited Profile', '2016-11-07 21:23:08'),
(313, 21, 'Logged out', '2016-11-07 21:23:48'),
(314, 22, 'Logged in', '2016-11-07 21:24:12'),
(315, 9, 'Logged out', '2016-11-07 21:24:26'),
(316, 22, 'Edited Profile', '2016-11-07 21:24:27'),
(317, 1, 'Logged in', '2016-11-07 21:24:34'),
(318, 1, 'Logged out', '2016-11-07 21:25:19'),
(319, 22, 'Logged in', '2016-11-07 21:25:42'),
(320, 22, 'Edited Profile', '2016-11-07 21:25:51'),
(321, 22, 'Logged out', '2016-11-07 21:25:57'),
(322, 22, 'Logged out', '2016-11-07 21:28:48'),
(323, 1, 'Logged in', '2016-11-07 21:28:59'),
(324, 1, 'Logged out', '2016-11-07 21:29:57'),
(325, 22, 'Logged in', '2016-11-07 21:30:12'),
(326, 22, 'Edited Profile', '2016-11-07 21:30:40'),
(327, 22, 'Edited Profile', '2016-11-07 21:31:08'),
(328, 22, 'Edited Profile', '2016-11-07 21:31:32'),
(329, 22, 'Edited Profile', '2016-11-07 21:31:41'),
(330, 22, 'Edited Profile', '2016-11-07 21:32:07'),
(331, 22, 'Edited Profile', '2016-11-07 21:32:16'),
(332, 22, 'Logged out', '2016-11-07 21:32:52'),
(333, 9, 'Logged in', '2016-11-07 22:07:36'),
(334, 9, 'Removed a photo from a branch gallery of BPI [branchID - 1]', '2016-11-07 22:10:00'),
(335, 9, 'Logged out', '2016-11-07 22:10:10'),
(336, 1, 'Logged in', '2016-11-07 22:10:24'),
(337, 1, 'Logged out', '2016-11-07 22:17:15'),
(338, 9, 'Logged in', '2016-11-07 22:17:23'),
(339, 9, 'Plotted a branch of BPI at Unnamed Road, Bulacan, Philippines [branchID - 13]', '2016-11-07 22:17:48'),
(340, 9, 'Removed a photo from a branch gallery of BPI [branchID - 1]', '2016-11-07 22:17:54'),
(341, 9, 'Added a photo to a branch gallery of BPI [branchID - 1]', '2016-11-07 22:18:00'),
(342, 9, 'Deleted a branch of BPI [branchID - 13]', '2016-11-07 22:18:25'),
(343, 9, 'Added a photo to a branch gallery of BPI [branchID - 1]', '2016-11-07 22:19:50'),
(344, 9, 'Logged out', '2016-11-07 22:21:43'),
(345, 9, 'Logged in', '2016-11-07 22:27:05'),
(346, 23, 'Registered to One Coin', '2016-11-07 22:29:49'),
(347, 24, 'Registered to One Coin', '2016-11-07 22:37:16'),
(348, 24, 'Verified Account.', '2016-11-07 23:08:37'),
(349, 24, 'Logged in', '2016-11-07 23:08:47'),
(350, 24, 'Purchased a subscription: 1 ESTABLISHMENTS, 3 BRANCHES PER BUSINESS for: JPY 10000 [PlanID - 8]', '2016-11-07 23:28:56'),
(351, 24, 'Purchased a subscription: 10 ESTABLISHMENTS, 100 BRANCHES PER BUSINESS for: JPY 1000000 [PlanID - 20]', '2016-11-07 23:36:38'),
(352, 24, 'Cancelled a subscription at period end: [SubscriptionID - 9]', '2016-11-07 23:43:53'),
(353, 24, 'Renewed a terminated subscription: [SubscriptionID - 9]', '2016-11-08 00:00:10'),
(354, 24, 'Cancelled a subscription at period end: [SubscriptionID - 9]', '2016-11-08 00:00:21'),
(355, 24, 'Reactivated recurring payments for a subscription: [SubscriptionID - 9]', '2016-11-08 00:00:29'),
(356, 24, 'Added an Establishment: Mcdonald''s [EstablishmentID - 5]', '2016-11-08 00:34:23'),
(357, 24, 'Added an Establishment: Mercury Drug [EstablishmentID - 6]', '2016-11-08 00:35:16'),
(358, 24, 'Added an Establishment: Philippine''s Children Medical Center [EstablishmentID - 7]', '2016-11-08 00:53:55'),
(359, 24, 'Deleted an Establishment: Philippine''s Children Medical Center [EstablishmentID - 7]', '2016-11-08 00:54:39'),
(360, 24, 'Added an Establishment: Philippine''s Children Medical Center [EstablishmentID - 8]', '2016-11-08 00:55:44'),
(361, 24, 'Updated an Establishment: Mercury Drug[EstablishmentID - 6] category from Fast Food to Others', '2016-11-08 00:57:08'),
(362, 24, 'Deleted an Establishment: Mercury Drug [EstablishmentID - 6]', '2016-11-08 00:57:23'),
(363, 24, 'Plotted a branch of Mcdonald''s at Diversion Road, Malolos, Bulacan, Philippines [branchID - 14]', '2016-11-08 01:56:16'),
(364, 24, 'Updated a branch of Mcdonald''s [branchID - 14] coordinates from position[14.857924,120.813644] to position[14.859085249606673,120.81166669416507]', '2016-11-08 01:56:22'),
(365, 24, 'Plotted a branch of Mcdonald''s at 76 Paseo del Congreso St, Malolos, 3000 Bulacan, Philippines [branchID - 15]', '2016-11-08 01:56:35'),
(366, 24, 'Plotted a branch of Mcdonald''s at 112 Plaridel-Pulilan Diversion Rd, Pulilan, 3005 Bulacan, Philippines [branchID - 16]', '2016-11-08 01:56:48'),
(367, 24, 'Deleted a branch of Mcdonald''s [branchID - 14]', '2016-11-08 01:57:30'),
(368, 24, 'Deleted a branch of Mcdonald''s [branchID - 15]', '2016-11-08 01:57:35'),
(369, 24, 'Deleted a branch of Mcdonald''s [branchID - 16]', '2016-11-08 01:57:42'),
(370, 24, 'Plotted a branch of Mcdonald''s at Diversion Road, Malolos, Bulacan, Philippines [branchID - 17]', '2016-11-08 02:04:18'),
(371, 24, 'Plotted a branch of Mcdonald''s at Lot 698A Paseo del Congreso St, Malolos, 3000 Bulacan, Philippines [branchID - 18]', '2016-11-08 02:04:37'),
(372, 24, 'Updated a branch of Mcdonald''s [branchID - 18] coordinates from position[14.847365,120.814041] to position[14.84968754079306,120.81472992897034]', '2016-11-08 02:04:40'),
(373, 24, 'Plotted a branch of Mcdonald''s at 112 Plaridel-Pulilan Diversion Rd, Pulilan, 3005 Bulacan, Philippines [branchID - 19]', '2016-11-08 02:04:55'),
(374, 24, 'Updated a branch of Mcdonald''s [branchID - 19] coordinates from position[14.898126,120.871422] to position[14.88995601862994,120.86721309626466]', '2016-11-08 02:17:20'),
(375, 24, 'Deleted a branch of Mcdonald''s [branchID - 19]', '2016-11-08 02:17:25'),
(376, 24, 'Updated branch contact number of Mcdonald''s [branchID - 17] from none to 09069081822', '2016-11-08 02:17:54'),
(377, 24, 'Updated branch description of Mcdonald''s [branchID - 17] from none to I''m lovin it.', '2016-11-08 02:17:55'),
(378, 24, 'Configured Branch Business Hours of Mcdonald''s [branchID - 17] at Diversion Road, Malolos, Bulacan, Philippines', '2016-11-08 02:18:08'),
(379, 24, 'Added a photo to a branch gallery of Mcdonald''s [branchID - 17]', '2016-11-08 02:18:13'),
(380, 24, 'Added a photo to a branch gallery of Mcdonald''s [branchID - 17]', '2016-11-08 02:18:16'),
(381, 24, 'Added a photo to a branch gallery of Mcdonald''s [branchID - 17]', '2016-11-08 02:18:19'),
(382, 24, 'Added a photo to a branch gallery of Mcdonald''s [branchID - 18]', '2016-11-08 02:18:32'),
(383, 24, 'Added a photo to a branch gallery of Mcdonald''s [branchID - 18]', '2016-11-08 02:18:34'),
(384, 24, 'Logged in', '2016-11-08 02:26:52'),
(385, 24, 'Logged in', '2016-11-08 02:27:06'),
(386, 24, 'Logged out', '2016-11-08 02:55:59'),
(387, 24, 'Logged in', '2016-11-08 02:56:19'),
(388, 24, 'Changed Password', '2016-11-08 02:58:14'),
(389, 24, 'Changed Password', '2016-11-08 02:59:10'),
(390, 24, 'Changed Password', '2016-11-08 03:02:56'),
(391, 24, 'Edited Profile', '2016-11-08 03:08:43'),
(392, 24, 'Edited Profile', '2016-11-08 03:09:17'),
(393, 24, 'Edited Profile', '2016-11-08 03:10:37'),
(394, 24, 'Changed Password', '2016-11-08 03:10:57'),
(395, 24, 'Logged out', '2016-11-08 03:11:46'),
(396, 1, 'Logged in', '2016-11-08 03:17:36'),
(397, 1, 'Logged out', '2016-11-08 13:18:10'),
(398, 1, 'Logged in', '2016-11-08 13:18:49'),
(399, 1, 'Added Emmanuel Yasa as an Admin.', '2016-11-08 13:19:21'),
(400, 1, 'Blocked admin Emmanuel Yasa', '2016-11-08 13:19:31'),
(401, 1, 'Logged out', '2016-11-08 13:28:04'),
(402, 1, 'Logged in', '2016-11-08 13:28:39'),
(403, 1, 'Logged out', '2016-11-08 13:28:59'),
(404, 1, 'Logged in', '2016-11-08 13:29:19'),
(405, 1, 'Unblocked admin Emmanuel Yasa', '2016-11-08 13:29:30'),
(406, 1, 'Logged out', '2016-11-08 13:29:34'),
(407, 25, 'Logged in', '2016-11-08 13:29:45'),
(408, 25, 'Logged out', '2016-11-08 13:36:43'),
(409, 1, 'Logged in', '2016-11-08 13:38:18'),
(410, 1, 'Created Pizza category', '2016-11-08 13:49:38'),
(411, 1, 'Updated Police Station category', '2016-11-08 13:50:00'),
(412, 1, 'Deleted ''Police Station'' category', '2016-11-08 13:50:07'),
(413, 9, 'Logged in', '2016-11-08 13:57:08'),
(414, 9, 'Logged in', '2016-11-08 13:57:23'),
(415, 9, 'Logged out', '2016-11-08 13:57:28'),
(416, 1, 'Logged in', '2016-11-08 13:57:35'),
(417, 1, 'Created ''2 Month Promo'' plan', '2016-11-08 14:21:15'),
(418, 1, 'Updated ''2 Month Promo'' plan', '2016-11-08 14:21:44'),
(419, 1, 'Updated ''2 Month Promo'' plan', '2016-11-08 14:26:57'),
(420, 1, 'Deleted ''2 Month Promo'' plan', '2016-11-08 14:28:16'),
(421, 1, 'Created ''2 Month Promo'' plan', '2016-11-08 14:28:49'),
(422, 1, 'Updated ''2 Month Promo'' plan', '2016-11-08 14:29:08'),
(423, 1, 'Deleted ''2 Month Promo'' plan', '2016-11-08 14:29:29'),
(424, 1, 'Updated ''other'' duration', '2016-11-08 14:33:39'),
(425, 1, 'Updated ''other'' duration', '2016-11-08 14:34:00'),
(426, 1, 'Logged out', '2016-11-08 14:38:24'),
(427, 24, 'Logged in', '2016-11-08 14:40:52'),
(428, 9, 'Logged in', '2016-11-08 15:22:56'),
(429, 2, 'Logged in', '2016-11-08 21:25:16'),
(430, 24, 'Logged in', '2016-11-08 22:44:30'),
(431, 24, 'Logged out', '2016-11-08 22:44:49'),
(432, 9, 'Logged in', '2016-11-08 22:44:57'),
(433, 1, 'Logged in', '2016-11-09 00:50:47'),
(434, 1, 'Logged in', '2016-11-09 00:51:29'),
(435, 1, 'Logged out', '2016-11-09 00:51:33'),
(436, 18, 'Logged in', '2016-11-09 13:16:40'),
(437, 1, 'Logged in', '2016-11-11 01:13:01'),
(438, 1, 'Logged in', '2016-11-11 01:13:17'),
(439, 1, 'Logged out', '2016-11-11 01:14:47'),
(440, 21, 'Logged in', '2016-11-13 00:52:04'),
(441, 9, 'Logged in', '2016-11-13 02:23:48'),
(442, 1, 'Logged in', '2016-11-13 02:24:07'),
(443, 24, 'Logged in', '2016-11-14 00:35:08'),
(444, 24, 'Logged out', '2016-11-14 00:35:43'),
(445, 9, 'Logged in', '2016-11-14 00:35:51'),
(446, 9, 'Added an Establishment: National Book Store [EstablishmentID - 9]', '2016-11-14 00:54:12'),
(447, 9, 'Logged in', '2016-11-15 23:49:13'),
(448, 9, 'Purchased a subscription: 5 ESTABLISHMENTS, 50 BRANCHES PER BUSINESS for: JPY 72500 [PlanID - 7]', '2016-11-15 23:50:35'),
(449, 9, 'Logged out', '2016-11-15 23:53:57'),
(450, 1, 'Logged in', '2016-11-16 16:05:00'),
(451, 1, 'Logged in', '2016-11-16 16:08:08'),
(452, 1, 'Logged in', '2016-11-16 16:14:38'),
(453, 1, 'Logged out', '2016-11-16 16:15:33'),
(454, 9, 'Logged in', '2016-11-16 16:15:52'),
(455, 9, 'Logged out', '2016-11-16 16:22:44'),
(456, 1, 'Logged in', '2016-11-16 16:23:15'),
(457, 1, 'Created buburahinkodin category', '2016-11-16 16:33:05'),
(458, 1, 'Logged out', '2016-11-16 16:33:15'),
(459, 9, 'Logged in', '2016-11-16 16:33:23'),
(460, 9, 'Updated an Establishment: National Book Store[EstablishmentID - 9] category from Others to buburahinkodin', '2016-11-16 16:34:05'),
(461, 9, 'Logged out', '2016-11-16 16:34:14'),
(462, 1, 'Logged in', '2016-11-16 16:34:25'),
(463, 1, 'Deleted ''buburahinkodin'' category', '2016-11-16 16:34:42'),
(464, 1, 'Logged out', '2016-11-16 16:34:57'),
(465, 9, 'Logged in', '2016-11-16 16:35:07'),
(466, 1, 'Logged out', '2016-11-16 16:39:25'),
(467, 21, 'Logged in', '2016-11-16 16:43:06'),
(468, 9, 'Logged out', '2016-11-16 16:54:45'),
(469, 1, 'Logged in', '2016-11-16 16:55:00'),
(470, 1, 'Created buburahinkodin category', '2016-11-16 16:55:33'),
(471, 1, 'Logged out', '2016-11-16 16:55:39'),
(472, 9, 'Logged in', '2016-11-16 16:55:48'),
(473, 9, 'Updated an Establishment: National Book Store[EstablishmentID - 9] category from  to buburahinkodin', '2016-11-16 16:56:17'),
(474, 9, 'Logged out', '2016-11-16 16:56:23'),
(475, 1, 'Logged in', '2016-11-16 16:56:36'),
(476, 1, 'Deleted ''buburahinkodin'' category', '2016-11-16 16:56:51'),
(477, 1, 'Logged out', '2016-11-16 16:57:11'),
(478, 9, 'Logged in', '2016-11-16 16:57:18'),
(479, 9, 'Logged out', '2016-11-16 17:01:04'),
(480, 9, 'Logged in', '2016-11-16 17:01:27'),
(481, 9, 'Logged out', '2016-11-16 17:01:45'),
(482, 1, 'Logged in', '2016-11-16 17:01:55'),
(483, 1, 'Created bookstore category', '2016-11-16 17:02:24'),
(484, 1, 'Logged out', '2016-11-16 17:02:30'),
(485, 9, 'Logged in', '2016-11-16 17:02:38'),
(486, 9, 'Updated an Establishment: National Book Store[EstablishmentID - 9] category from  to bookstore', '2016-11-16 17:03:01'),
(487, 9, 'Logged out', '2016-11-16 17:03:05'),
(488, 1, 'Logged in', '2016-11-16 17:03:26'),
(489, 1, 'Deleted ''bookstore'' category', '2016-11-16 17:03:42'),
(490, 1, 'Logged out', '2016-11-16 17:03:56'),
(491, 9, 'Logged in', '2016-11-16 17:04:14'),
(492, 9, 'Updated an Establishment: National Book Store[EstablishmentID - 9] category from  to Others', '2016-11-16 17:04:49'),
(493, 9, 'Logged out', '2016-11-16 17:15:10'),
(494, 1, 'Logged in', '2016-11-16 17:15:19'),
(495, 1, 'Created Bookstore category', '2016-11-16 17:15:54'),
(496, 1, 'Logged out', '2016-11-16 17:15:59'),
(497, 9, 'Logged in', '2016-11-16 17:16:06'),
(498, 9, 'Updated an Establishment: National Book Store[EstablishmentID - 9] category from Others to Bookstore', '2016-11-16 17:16:23'),
(499, 9, 'Logged out', '2016-11-16 17:16:27'),
(500, 1, 'Logged in', '2016-11-16 17:16:41'),
(501, 21, 'Logged in', '2016-11-16 17:17:08'),
(502, 21, 'Logged in', '2016-11-16 17:17:57'),
(503, 1, 'Updated Bookstores category', '2016-11-16 17:18:52'),
(504, 1, 'Logged out', '2016-11-16 17:19:01'),
(505, 9, 'Logged in', '2016-11-16 17:19:14'),
(506, 9, 'Logged out', '2016-11-16 17:19:29'),
(507, 21, 'Logged out', '2016-11-16 17:19:40'),
(508, 21, 'Logged in', '2016-11-16 17:20:48'),
(509, 9, 'Logged in', '2016-11-16 17:40:00'),
(510, 21, 'Logged out', '2016-11-16 17:41:27'),
(511, 9, 'Logged out', '2016-11-16 17:42:20'),
(512, 1, 'Logged in', '2016-11-16 17:42:37'),
(513, 1, 'Logged out', '2016-11-16 17:43:21'),
(514, 2, 'Logged in', '2016-11-16 17:43:28'),
(515, 2, 'Logged out', '2016-11-16 17:43:34'),
(516, 1, 'Logged in', '2016-11-16 17:43:43'),
(517, 2, 'Logged in', '2016-11-16 17:44:19'),
(518, 2, 'Logged in', '2016-11-18 03:00:10'),
(519, 2, 'Logged out', '2016-11-18 03:15:04'),
(520, 9, 'Logged in', '2016-11-20 01:58:36'),
(521, 9, 'Cancelled a subscription at period end: [SubscriptionID - 11]', '2016-11-20 02:19:32'),
(522, 9, 'Reactivated recurring payments for a subscription: [SubscriptionID - 11]', '2016-11-20 02:19:40'),
(523, 1, 'Logged in', '2016-11-21 22:06:32'),
(524, 1, 'Updated Bookstores category', '2016-11-21 22:08:17'),
(525, 24, 'Logged in', '2016-11-22 12:44:09'),
(526, 21, 'Logged in', '2016-11-23 00:06:32'),
(527, 21, 'Edited Profile', '2016-11-23 00:11:02'),
(528, 21, 'Edited Profile', '2016-11-23 00:11:40'),
(529, 21, 'Edited Profile', '2016-11-23 00:11:51'),
(530, 21, 'Logged out', '2016-11-23 00:14:04'),
(531, 1, 'Logged in', '2016-11-23 00:14:19'),
(532, 1, 'Logged out', '2016-11-23 00:52:28'),
(533, 2, 'Logged in', '2016-11-23 00:52:44'),
(534, 2, 'Logged out', '2016-11-23 17:22:40'),
(535, 21, 'Logged in', '2016-11-23 17:23:04'),
(536, 21, 'Logged out', '2016-11-23 17:25:15'),
(537, 22, 'Logged in', '2016-11-23 17:25:23'),
(538, 22, 'Logged out', '2016-11-23 17:26:25'),
(539, 24, 'Logged in', '2016-11-23 17:45:37'),
(540, 24, 'Logged in', '2016-11-23 17:46:03'),
(541, 24, 'Logged out', '2016-11-23 17:46:28'),
(542, 24, 'Logged in', '2016-11-23 17:46:38'),
(543, 21, 'Logged in', '2016-11-23 18:01:53'),
(544, 24, 'Updated branch contact number of Mcdonald''s [branchID - 18] from none to none', '2016-11-23 18:02:16'),
(545, 24, 'Updated branch description of Mcdonald''s [branchID - 18] from none to none', '2016-11-23 18:02:30'),
(546, 24, 'Plotted a branch of Mcdonald''s at Commercial Building, 16 Capitol Compound, Malolos, 3000 Bulacan, Pilipinas [branchID - 20]', '2016-11-23 18:02:35'),
(547, 24, 'Plotted a branch of Mcdonald''s at Grandtown VIllage, Malolos, Bulacan, Pilipinas [branchID - 21]', '2016-11-23 18:02:37'),
(548, 24, 'Plotted a branch of Mcdonald''s at Grandtown VIllage, Malolos, Bulacan, Pilipinas [branchID - 22]', '2016-11-23 18:02:38'),
(549, 24, 'Updated a branch of Mcdonald''s [branchID - 22] coordinates from position[14.853172,120.822563] to position[14.854706808862648,120.80539584159851]', '2016-11-23 18:02:40'),
(550, 26, 'Registered to One Coin', '2016-11-23 18:14:46'),
(551, 24, 'Logged out', '2016-11-23 18:28:57'),
(552, 1, 'Logged in', '2016-11-23 18:29:14'),
(553, 24, 'Logged in', '2016-11-23 21:39:37'),
(554, 1, 'Logged out', '2016-11-23 23:36:51'),
(555, 24, 'Logged in', '2016-11-23 23:40:36'),
(556, 24, 'Added an Establishment: Mik''s Pet shop [EstablishmentID - 10]', '2016-11-23 23:49:30'),
(557, 24, 'Plotted a branch of Mik''s Pet shop at 53 Paseo de Roxas, Makati, 1225 Metro Manila, Pilipinas [branchID - 23]', '2016-11-23 23:50:41'),
(558, 24, 'Updated branch contact number of Mik''s Pet shop [branchID - 23] from none to 09265678140', '2016-11-23 23:52:03'),
(559, 24, 'Configured Branch Business Hours of Mik''s Pet shop [branchID - 23] at 53 Paseo de Roxas, Makati, 1225 Metro Manila, Pilipinas', '2016-11-23 23:53:21'),
(560, 24, 'Added a photo to a branch gallery of Mik''s Pet shop [branchID - 23]', '2016-11-23 23:53:31'),
(561, 24, 'Removed a photo from a branch gallery of Mik''s Pet shop [branchID - 23]', '2016-11-23 23:53:34'),
(562, 24, 'Updated a branch of Mik''s Pet shop [branchID - 23] coordinates from position[14.559659,121.030197] to position[14.354869561024975,121.15379333496094]', '2016-11-23 23:55:46'),
(563, 24, 'Updated a branch of Mik''s Pet shop [branchID - 23] coordinates from position[14.354870,121.153793] to position[14.57826720924045,121.48338317871094]', '2016-11-23 23:55:52'),
(564, 24, 'Updated a branch of Mik''s Pet shop [branchID - 23] coordinates from position[14.578267,121.483383] to position[14.727073444965137,121.02470397949219]', '2016-11-23 23:55:54'),
(565, 24, 'Updated a branch of Mik''s Pet shop [branchID - 23] coordinates from position[14.727073,121.024704] to position[14.72599429986221,121.0270643234253]', '2016-11-23 23:56:17'),
(566, 24, 'Updated a branch of Mik''s Pet shop [branchID - 23] coordinates from position[14.725994,121.027061] to position[14.72570375988327,121.02667808532715]', '2016-11-23 23:56:26'),
(567, 24, 'Deleted a branch of Mik''s Pet shop [branchID - 23]', '2016-11-23 23:56:38'),
(568, 24, 'Plotted a branch of Mik''s Pet shop at Diversion Road, Malolos, Bulacan, Pilipinas [branchID - 24]', '2016-11-23 23:58:09'),
(569, 24, 'Updated a branch of Mik''s Pet shop [branchID - 24] coordinates from position[14.857932,120.813637] to position[14.855608982136003,120.81350685396728]', '2016-11-23 23:58:15'),
(570, 24, 'Updated a branch of Mik''s Pet shop [branchID - 24] coordinates from position[14.855609,120.813507] to position[14.860005912694884,120.81385017672119]', '2016-11-23 23:58:16'),
(571, 24, 'Updated a branch of Mik''s Pet shop [branchID - 24] coordinates from position[14.860006,120.813850] to position[14.858263743369678,120.81324936190185]', '2016-11-23 23:58:18'),
(572, 24, 'Updated a branch of Mik''s Pet shop [branchID - 24] coordinates from position[14.858264,120.813248] to position[14.858388184501871,120.81333519259033]', '2016-11-23 23:58:19'),
(573, 24, 'Updated a branch of Mik''s Pet shop [branchID - 24] coordinates from position[14.858388,120.813332] to position[14.858471145216814,120.81290603914795]', '2016-11-23 23:58:21'),
(574, 24, 'Updated a branch of Mik''s Pet shop [branchID - 24] coordinates from position[14.858471,120.812904] to position[14.857268211730979,120.81432224550781]', '2016-11-23 23:58:22'),
(575, 24, 'Updated a branch of Mik''s Pet shop [branchID - 24] coordinates from position[14.857268,120.814323] to position[14.85813930216581,120.8136356]', '2016-11-23 23:58:23'),
(576, 24, 'Plotted a branch of Mik''s Pet shop at 125 A. Mabini St, Malolos, 3000 Bulacan, Pilipinas [branchID - 25]', '2016-11-23 23:58:34'),
(577, 24, 'Plotted a branch of Mik''s Pet shop at 1635 Malanggam Road, Malolos, 3000 Bulakan, Pilipinas [branchID - 26]', '2016-11-23 23:58:41'),
(578, 24, 'Plotted a branch of Mik''s Pet shop at Kabihasnan Road, Malolos, Bulacan, Pilipinas [branchID - 27]', '2016-11-23 23:58:53'),
(579, 24, 'Plotted a branch of Mik''s Pet shop at Sumapa Ligas Rd, Malolos, Bulacan, Pilipinas [branchID - 28]', '2016-11-23 23:59:02'),
(580, 24, 'Plotted a branch of Mik''s Pet shop at Ilang-Ilang St, Malolos, Bulacan, Pilipinas [branchID - 29]', '2016-11-23 23:59:10'),
(581, 24, 'Updated a branch of Mik''s Pet shop [branchID - 29] coordinates from position[14.862007,120.807030] to position[14.861260718871208,120.80642580986023]', '2016-11-23 23:59:16'),
(582, 24, 'Updated a branch of Mik''s Pet shop [branchID - 29] coordinates from position[14.861261,120.806427] to position[14.862214752477692,120.80522418022156]', '2016-11-23 23:59:19'),
(583, 24, 'Logged out', '2016-11-24 00:01:16'),
(584, 1, 'Logged in', '2016-11-24 00:02:31'),
(585, 1, 'Added Mikhael Maclang as an Admin.', '2016-11-24 00:04:08'),
(586, 1, 'Blocked admin Aljon Cruz', '2016-11-24 00:04:55'),
(587, 1, 'Logged in', '2016-11-24 00:08:10'),
(588, 1, 'Created Pizza Parlor category', '2016-11-24 00:16:12'),
(589, 1, 'Updated Pizza Parlor category', '2016-11-24 00:17:07'),
(590, 1, 'Created ''Customized plan'' plan', '2016-11-24 00:19:50'),
(591, 1, 'Updated ''day'' duration', '2016-11-24 00:22:01'),
(592, 1, 'Updated ''day'' duration', '2016-11-24 00:22:27'),
(593, 1, 'Updated ''day'' duration', '2016-11-24 00:22:51'),
(594, 1, 'Updated ''other'' duration', '2016-11-24 00:22:55'),
(595, 1, 'Updated ''other'' duration', '2016-11-24 00:23:16'),
(596, 1, 'Updated ''Customized plan'' plan', '2016-11-24 00:24:15'),
(597, 1, 'Logged out', '2016-11-24 00:25:10'),
(598, 24, 'Logged in', '2016-11-24 00:32:10'),
(599, 24, 'Plotted a branch of Mik''s Pet shop at Sta Barbara St, Malolos, Bulacan, Pilipinas [branchID - 30]', '2016-11-24 00:35:06'),
(600, 24, 'Plotted a branch of Mik''s Pet shop at Mickey St, Malolos, Bulacan, Pilipinas [branchID - 31]', '2016-11-24 00:35:08'),
(601, 24, 'Plotted a branch of Mik''s Pet shop at Oak Leaf St, Malolos, Bulacan, Pilipinas [branchID - 32]', '2016-11-24 00:35:09'),
(602, 24, 'Plotted a branch of Mik''s Pet shop at Dama De Noche St, Malolos, Bulacan, Pilipinas [branchID - 33]', '2016-11-24 00:35:19'),
(603, 24, 'Plotted a branch of Mik''s Pet shop at Tabing Ilog, Street, Malolos, Bulakan, Pilipinas [branchID - 34]', '2016-11-24 00:35:21'),
(604, 24, 'Plotted a branch of Mik''s Pet shop at Carmen V. De Luna St, Malolos, Bulacan, Pilipinas [branchID - 35]', '2016-11-24 00:35:25'),
(605, 24, 'Plotted a branch of Mik''s Pet shop at Basil 2 St, Malolos, Bulacan, Pilipinas [branchID - 36]', '2016-11-24 00:35:26'),
(606, 24, 'Updated a branch of Mik''s Pet shop [branchID - 36] coordinates from position[14.879677,120.806587] to position[14.880257637447293,120.80856084823608]', '2016-11-24 00:35:34'),
(607, 24, 'Updated a branch of Mik''s Pet shop [branchID - 36] coordinates from position[14.880258,120.808563] to position[14.877022472548543,120.8271861076355]', '2016-11-24 00:35:37'),
(608, 24, 'Deleted a branch of Mik''s Pet shop [branchID - 36]', '2016-11-24 00:35:42'),
(609, 24, 'Deleted a branch of Mik''s Pet shop [branchID - 33]', '2016-11-24 00:35:44'),
(610, 24, 'Deleted a branch of Mik''s Pet shop [branchID - 35]', '2016-11-24 00:35:45'),
(611, 24, 'Plotted a branch of Mik''s Pet shop at Chrysanthemum 2 St, Malolos, Bulacan, Pilipinas [branchID - 37]', '2016-11-24 00:35:48'),
(612, 24, 'Updated branch address of Mik''s Pet shop [branchID - 37] from Chrysanthemum 2 St, Malolos, Bulacan, Pilipinas to Chrysanthemum 2 St, Malolos, Bulacan, Pilipinas', '2016-11-24 00:36:09'),
(613, 24, 'Updated branch description of Mik''s Pet shop [branchID - 37] from none to none', '2016-11-24 00:36:12'),
(614, 24, 'Updated branch contact number of Mik''s Pet shop [branchID - 37] from none to 09363424180', '2016-11-24 00:36:36'),
(615, 24, 'Configured Branch Business Hours of Mik''s Pet shop [branchID - 37] at Chrysanthemum 2 St, Malolos, Bulacan, Pilipinas', '2016-11-24 00:36:48'),
(616, 24, 'Plotted a branch of Mik''s Pet shop at Unnamed Road, Malolos, Bulacan, Pilipinas [branchID - 38]', '2016-11-24 00:39:32'),
(617, 24, 'Logged in', '2016-11-24 07:42:11'),
(618, 24, 'Logged in', '2016-11-24 07:42:30');

-- --------------------------------------------------------

--
-- Table structure for table `BOOKMARK_TB`
--

CREATE TABLE IF NOT EXISTS `BOOKMARK_TB` (
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `BOOKMARK_TB`
--

INSERT INTO `BOOKMARK_TB` (`user_id`, `branch_id`) VALUES
(9, 1),
(14, 1),
(24, 17),
(26, 7);

-- --------------------------------------------------------

--
-- Table structure for table `BRANCHES_GALLERY_TB`
--

CREATE TABLE IF NOT EXISTS `BRANCHES_GALLERY_TB` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `BRANCHES_GALLERY_TB`
--

INSERT INTO `BRANCHES_GALLERY_TB` (`id`, `branch_id`, `gallery_id`) VALUES
(26, 1, 1),
(27, 1, 20),
(3, 4, 4),
(4, 4, 5),
(5, 5, 4),
(6, 5, 5),
(7, 7, 4),
(8, 7, 5),
(15, 8, 11),
(19, 10, 19),
(18, 10, 17),
(17, 10, 15),
(16, 10, 16),
(14, 8, 10),
(20, 10, 18),
(21, 11, 19),
(22, 11, 18),
(23, 11, 16),
(24, 12, 16),
(25, 12, 18),
(28, 17, 21),
(29, 17, 23),
(30, 17, 24),
(31, 18, 21),
(32, 18, 22);

-- --------------------------------------------------------

--
-- Table structure for table `BRANCHES_TB`
--

CREATE TABLE IF NOT EXISTS `BRANCHES_TB` (
  `id` int(11) NOT NULL,
  `estab_id` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `contact_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `BRANCHES_TB`
--

INSERT INTO `BRANCHES_TB` (`id`, `estab_id`, `address`, `lat`, `lng`, `description`, `contact_number`) VALUES
(1, 1, '76 Paseo del Congreso St, Malolos, 3000 Bulacan, Philippines', 14.847144, 120.813690, 'Make the best happen.', '09363424180'),
(2, 1, '3 Paseo del Congreso St, Malolos, 3000 Bulacan, Philippines', 14.844590, 120.811096, 'none', 'none'),
(5, 2, 'SM City Clark Bldg., Clark Freeport, Angeles, Pampanga, Philippines', 15.168596, 120.580101, 'All sweets are here!', '09265190527'),
(4, 2, 'MacArthur Hwy, Malolos, Bulacan, Philippines', 14.856739, 120.813690, 'Visit us!', '09265190527'),
(7, 2, 'MacArthur Hwy, Apalit, Pampanga, Philippines', 14.962759, 120.756348, 'Visit us!', '09265190527'),
(8, 3, 'Sevilla St, Malolos, Bulacan, Philippines', 14.829350, 120.823158, 'Mindblendr''s Devs main branch.', '09363424180'),
(9, 3, 'Unnamed Road, Hagonoy, Bulacan, Philippines', 14.869474, 120.771675, 'none', 'none'),
(10, 4, 'Bacolor, Pampanga, Philippines', 15.101295, 120.602722, 'none', '09265678140'),
(11, 4, 'Puerto Princesa, Palawan, Philippines', 10.285194, 118.743744, 'none', '09265678140'),
(12, 4, 'Talavera, Nueva Ecija, Philippines', 15.660065, 120.919037, 'none', '09265678140'),
(18, 5, '64 Paseo del Congreso St, Malolos, Bulacan, Philippines', 14.849688, 120.814728, 'none', 'none'),
(17, 5, 'Diversion Road, Malolos, Bulacan, Philippines', 14.857924, 120.813644, 'I''m lovin it.', '09069081822'),
(20, 5, 'Commercial Building, 16 Capitol Compound, Malolos, 3000 Bulacan, Pilipinas', 14.857154, 120.814407, 'none', 'none'),
(21, 5, 'Grandtown VIllage, Malolos, Bulacan, Pilipinas', 14.854458, 120.823036, 'none', 'none'),
(22, 5, 'Malanggam Road, Malolos, Bulakan, Pilipinas', 14.854707, 120.805397, 'none', 'none'),
(24, 10, 'Diversion Road, Malolos, Bulacan, Pilipinas', 14.858139, 120.813637, 'none', 'none'),
(25, 10, '125 A. Mabini St, Malolos, 3000 Bulacan, Pilipinas', 14.855412, 120.816338, 'none', 'none'),
(26, 10, '1635 Malanggam Road, Malolos, 3000 Bulakan, Pilipinas', 14.854375, 120.806938, 'none', 'none'),
(27, 10, 'Kabihasnan Road, Malolos, Bulacan, Pilipinas', 14.846867, 120.818657, 'none', 'none'),
(28, 10, 'Sumapa Ligas Rd, Malolos, Bulacan, Pilipinas', 14.858565, 120.831490, 'none', 'none'),
(29, 10, '130 Dahlia St, Malolos, 3000 Bulacan, Pilipinas', 14.862215, 120.805222, 'none', 'none'),
(30, 10, 'Sta Barbara St, Malolos, Bulacan, Pilipinas', 14.868976, 120.828987, 'none', 'none'),
(31, 10, 'Mickey St, Malolos, Bulacan, Pilipinas', 14.867814, 120.788048, 'none', 'none'),
(32, 10, 'Oak Leaf St, Malolos, Bulacan, Pilipinas', 14.867317, 120.815514, 'none', 'none'),
(34, 10, 'Tabing Ilog, Street, Malolos, Bulakan, Pilipinas', 14.859850, 120.793114, 'none', 'none'),
(37, 10, 'Chrysanthemum 2 St, Malolos, Bulacan, Pilipinas', 14.875778, 120.807617, 'none', '09363424180'),
(38, 10, 'Unnamed Road, Malolos, Bulacan, Pilipinas', 14.851554, 120.794098, 'none', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `BUSINESS_HOURS_TB`
--

CREATE TABLE IF NOT EXISTS `BUSINESS_HOURS_TB` (
  `id` int(11) NOT NULL,
  `day_no` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `opening_hour` time NOT NULL,
  `closing_hour` time NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `BUSINESS_HOURS_TB`
--

INSERT INTO `BUSINESS_HOURS_TB` (`id`, `day_no`, `branch_id`, `opening_hour`, `closing_hour`) VALUES
(1, 0, 1, '08:00:00', '17:00:00'),
(2, 1, 1, '08:00:00', '17:00:00'),
(3, 2, 1, '08:00:00', '17:00:00'),
(4, 3, 1, '08:00:00', '17:00:00'),
(5, 4, 1, '08:00:00', '17:00:00'),
(6, 5, 1, '00:00:00', '00:00:00'),
(7, 6, 1, '00:00:00', '00:00:00'),
(8, 0, 4, '08:00:00', '21:00:00'),
(9, 1, 4, '08:00:00', '21:00:00'),
(10, 2, 4, '08:00:00', '21:00:00'),
(11, 3, 4, '08:00:00', '21:00:00'),
(12, 4, 4, '08:00:00', '21:00:00'),
(13, 5, 4, '08:00:00', '21:00:00'),
(14, 6, 4, '00:00:00', '00:00:00'),
(15, 0, 5, '08:00:00', '21:00:00'),
(16, 1, 5, '08:00:00', '21:00:00'),
(17, 2, 5, '08:00:00', '21:00:00'),
(18, 3, 5, '08:00:00', '21:00:00'),
(19, 4, 5, '08:00:00', '21:00:00'),
(20, 5, 5, '08:00:00', '21:00:00'),
(21, 6, 5, '00:00:00', '00:00:00'),
(22, 0, 7, '08:00:00', '21:00:00'),
(23, 1, 7, '08:00:00', '21:00:00'),
(24, 2, 7, '08:00:00', '20:00:00'),
(25, 3, 7, '08:00:00', '21:00:00'),
(26, 4, 7, '08:00:00', '21:00:00'),
(27, 5, 7, '08:00:00', '21:00:00'),
(28, 6, 7, '00:00:00', '00:00:00'),
(29, 0, 8, '08:00:00', '17:00:00'),
(30, 1, 8, '08:00:00', '17:00:00'),
(31, 2, 8, '08:00:00', '17:00:00'),
(32, 3, 8, '08:00:00', '17:00:00'),
(33, 4, 8, '08:00:00', '17:00:00'),
(34, 5, 8, '00:00:00', '00:00:00'),
(35, 6, 8, '00:00:00', '00:00:00'),
(36, 0, 10, '00:00:00', '23:59:00'),
(37, 1, 10, '00:00:00', '23:59:00'),
(38, 2, 10, '00:00:00', '23:59:00'),
(39, 3, 10, '00:00:00', '23:59:00'),
(40, 4, 10, '00:00:00', '23:59:00'),
(41, 5, 10, '00:00:00', '23:59:00'),
(42, 6, 10, '00:00:00', '23:59:00'),
(43, 0, 11, '00:00:00', '23:59:00'),
(44, 1, 11, '00:00:00', '23:59:00'),
(45, 2, 11, '00:00:00', '23:59:00'),
(46, 3, 11, '00:00:00', '23:59:00'),
(47, 4, 11, '00:00:00', '23:59:00'),
(48, 5, 11, '00:00:00', '23:59:00'),
(49, 6, 11, '00:00:00', '23:59:00'),
(50, 0, 12, '00:00:00', '23:59:00'),
(51, 1, 12, '00:00:00', '23:59:00'),
(52, 2, 12, '00:00:00', '23:59:00'),
(53, 3, 12, '00:00:00', '23:59:00'),
(54, 4, 12, '00:00:00', '23:59:00'),
(55, 5, 12, '00:00:00', '23:59:00'),
(56, 6, 12, '00:00:00', '23:59:00'),
(57, 0, 17, '08:00:00', '20:00:00'),
(58, 1, 17, '08:00:00', '20:00:00'),
(59, 2, 17, '00:00:00', '23:59:00'),
(60, 3, 17, '08:00:00', '20:00:00'),
(61, 4, 17, '08:00:00', '20:00:00'),
(62, 5, 17, '00:00:00', '00:00:00'),
(63, 6, 17, '00:00:00', '00:00:00'),
(77, 6, 37, '00:00:00', '00:00:00'),
(76, 5, 37, '00:00:00', '00:00:00'),
(75, 4, 37, '00:00:00', '23:59:00'),
(74, 3, 37, '00:00:00', '23:59:00'),
(73, 2, 37, '00:00:00', '23:59:00'),
(72, 1, 37, '00:00:00', '23:59:00'),
(71, 0, 37, '00:00:00', '23:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `CATEGORY_TB`
--

CREATE TABLE IF NOT EXISTS `CATEGORY_TB` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `featured_category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_category_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `CATEGORY_TB`
--

INSERT INTO `CATEGORY_TB` (`id`, `name`, `featured_category`, `display_picture`, `description`) VALUES
(1, 'Fast Food', 'FEATURED', 'DISPLAY_PICTURES/categ_display_pic1', 'Fast food restaurants that caters speed fast meals.'),
(2, 'Hospital', 'FEATURED', 'DISPLAY_PICTURES/categ_display_pic2', 'Medical facilities that serve ill people.'),
(3, 'Hotel', 'FEATURED', 'DISPLAY_PICTURES/categ_display_pic3', 'Comfortable place to stay for a period of time.'),
(4, 'Salon', 'FEATURED', 'DISPLAY_PICTURES/categ_display_pic4', 'Hair cuts and other cosmetic services are served here.'),
(5, 'Bank', 'FEATURED', 'DISPLAY_PICTURES/categ_display_pic5', 'Banking establishments for financial and banking services.'),
(6, 'Others', 'FEATURED', 'DISPLAY_PICTURES/defaultCategIcon.png', 'Other unspecified type of establishments.'),
(13, 'Bookstores', 'NOT FEATURED', 'DISPLAY_PICTURES/defaultCategIcon.png', 'Quality books at your price'),
(14, 'Pizza Parlor', 'FEATURED', 'DISPLAY_PICTURES/categ_display_pic14', 'delicious and crunchy');

-- --------------------------------------------------------

--
-- Table structure for table `END_USER_TB`
--

CREATE TABLE IF NOT EXISTS `END_USER_TB` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hometown` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_attempt` int(11) DEFAULT NULL,
  `verification_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `END_USER_TB`
--

INSERT INTO `END_USER_TB` (`id`, `email`, `username`, `password`, `first_name`, `last_name`, `contact`, `hometown`, `display_picture`, `user_type`, `stripe_id`, `reset_code`, `account_status`, `login_attempt`, `verification_key`) VALUES
(1, 'codeyasam@gmail.com', 'root', '08a2c3ccf8741173a65fac9127d73b64', 'Emmanuel', 'Yasa', '09069081822', 'Malolos, Bulacan', 'http://www.codeyasam.com/capstone/Public/DISPLAY_PICTURES/defaultavatar.png', 'SUPERADMIN', 'cus_9VOlryCuBVMSZX', '', 'ACTIVE', 0, ''),
(2, 'cezarnazario@gmail.com', 'sircesar', '5ebe2294ecd0e0f08eab7690d2a6ee69', 'Cesar', 'Nazario', 'none', 'none', 'http://www.codeyasam.com/capstone/Public/DISPLAY_PICTURES/defaultavatar.png', 'ADMIN', '', '', 'ACTIVE', 0, ''),
(3, 'kenlopez123@yahoo.com', 'ken', '39cb6791805d31783ee010df8902f311', 'ken', 'lopez', '', '', 'http://www.codeyasam.com/capstone/Public/DISPLAY_PICTURES/profile_pic3', 'OWNER', 'cus_9VADQNt7jtF0kU', '', 'BLOCKED', 0, ''),
(11, 'aldrinyasa500@yahoo.com', 'aldrin', 'd1b5392b044d3ab57223bf5804482711', 'Aldrin', 'Yasa', 'none', 'none', 'http://www.codeyasam.com/capstone/Public/DISPLAY_PICTURES/defaultavatar.png', 'USER', '', '', 'ACTIVE', 0, '5521e0e8256543a39ffb7eaa984d1a89'),
(9, 'yasa_emmanuel777@yahoo.com', 'codeyasam', '5ebe2294ecd0e0f08eab7690d2a6ee69', 'Emmanuel', 'Yasa', 'none', 'none', 'http://www.codeyasam.com/capstone/Public/DISPLAY_PICTURES/profile_pic9', 'OWNER', 'cus_9VN3XAgUx7BXPz', '', 'ACTIVE', 0, ''),
(10, 'edwardhitohito@gmail.com', 'edward', 'a53f3929621dba1306f8a61588f52f55', 'edward', 'edward', '', '', 'http://www.codeyasam.com/capstone/Public/DISPLAY_PICTURES/defaultavatar.png', 'OWNER', '', '', 'BLOCKED', 0, '5676f1d91cc1d44797efd19730671aab'),
(14, 'mangolover_014@yahoo.com', 'amor_yasa', 'd1b5392b044d3ab57223bf5804482711', 'Rosario', 'Cruz', 'none', 'none', 'https://graph.facebook.com/1472110656137519/picture?type=large', 'USER', '', '', 'ACTIVE', 0, '969df13dbf63a8b3997e84f671b7ea83'),
(15, 'maryjoestrella@yahoo.com', 'joheyyy', 'c9ae5e5931033ca88b5a0a9b556017f3', 'Maryjo Estrella', 'Bautista', '', '', 'https://graph.facebook.com/1253076781380970/picture?type=large', 'OWNER', '', '', 'ACTIVE', 0, 'c125aa862c7afd008fded63d7a3eee95'),
(21, 'avpjimenez23@gmail.com', 'vanessa', '62c3673ffdc779eb08e1f3ae0ff40996', 'Vanessa', 'Jimenez', '', '', 'http://www.codeyasam.com/capstone/Public/DISPLAY_PICTURES/profile_pic21', 'OWNER', 'cus_9VuPp7XZBGfJ1f', '', 'ACTIVE', 0, ''),
(25, 'asaycodem@gmail.com', 'asaycodem', '5d7845ac6ee7cfffafc5fe5f35cf666d', 'Emmanuel', 'Yasa', 'none', 'none', 'http://www.codeyasam.com/capstone/Public/DISPLAY_PICTURES/defaultavatar.png', 'ADMIN', '', '', 'BLOCKED', 3, ''),
(18, 'mindblendr@gmail.com', 'mindblendr', 'a3445c9593892db27228904a04bec977', 'Aljon', 'Cruz', 'none', 'none', 'http://www.codeyasam.com/capstone/Public/DISPLAY_PICTURES/defaultavatar.png', 'ADMIN', 'cus_9WBoaMOzPc6RRb', '', 'BLOCKED', 0, ''),
(22, 'crisberruico19@gmail.com', 'cris', '3fd987f2fd456ca3badfbb60446afa8d', 'Cris Leandro', 'Berruico', '09265678140', '', 'http://www.codeyasam.com/capstone/Public/DISPLAY_PICTURES/profile_pic22', 'OWNER', 'cus_9WEwbJQJ8Lttpg', '', 'ACTIVE', 0, ''),
(24, 'coinone777@gmail.com', 'coinone', '5edb023cae7c00f792358e9c82db531d', 'Johnny', 'Doer', '', '', 'http://www.codeyasam.com/capstone/Public/DISPLAY_PICTURES/profile_pic24', 'OWNER', 'cus_9WHcF8dKmPkDMM', '2qdk3', 'ACTIVE', 0, ''),
(26, 'mikhaeljohnmmaclang@gmail.com', 'mik', 'af7d150efb144241e53d8dd66854f314', 'Mikhael', 'Maclang', 'none', 'none', 'https://graph.facebook.com/1101573433295505/picture?type=large', 'USER', '', '', 'ACTIVE', 0, '392630aed1c5ad9fd62a8dc6af4acb75'),
(27, 'mikhaeleds@gmail.com', 'mik123', 'af7d150efb144241e53d8dd66854f314', 'Mikhael', 'Maclang', 'none', 'none', 'http://www.codeyasam.com/capstone/Public/DISPLAY_PICTURES/profile_pic27', 'ADMIN', '', '', 'ACTIVE', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `ESTABLISHMENT_TB`
--

CREATE TABLE IF NOT EXISTS `ESTABLISHMENT_TB` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ESTABLISHMENT_TB`
--

INSERT INTO `ESTABLISHMENT_TB` (`id`, `owner_id`, `category_id`, `name`, `display_picture`, `description`, `tags`) VALUES
(1, 9, 5, 'BPI', 'DISPLAY_PICTURES/estab_display_pic1', 'In BPI, We make the best happen.', ''),
(2, 21, 1, 'ABC''s Cafe', 'DISPLAY_PICTURES/estab_display_pic2', 'Cakes, Candies, Chocolate,and other sweets are here! <3', ''),
(3, 18, 6, 'Mindblendr''s Devs', 'DISPLAY_PICTURES/estab_display_pic3', 'Web Development Firm', 'development, web, programmer'),
(4, 22, 3, 'The Establishment Hotel', 'DISPLAY_PICTURES/estab_display_pic4', '', ''),
(5, 24, 1, 'Mcdonald''s', 'DISPLAY_PICTURES/estab_display_pic5', 'Mcdonald''s is your kind of place.', ''),
(8, 24, 2, 'Philippine''s Children Medical Center', 'DISPLAY_PICTURES/estab_display_pic8', 'Medical center for children', ''),
(9, 9, 13, 'National Book Store', 'DISPLAY_PICTURES/estab_display_pic9', 'We''ve got it all for you.', ''),
(10, 24, 6, 'Mik''s Pet shop', 'DISPLAY_PICTURES/estab_display_pic10', 'Good and accomodating.', 'Animal');

-- --------------------------------------------------------

--
-- Table structure for table `GALLERY_TB`
--

CREATE TABLE IF NOT EXISTS `GALLERY_TB` (
  `id` int(11) NOT NULL,
  `estab_id` int(11) NOT NULL,
  `gallery_pic` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `GALLERY_TB`
--

INSERT INTO `GALLERY_TB` (`id`, `estab_id`, `gallery_pic`) VALUES
(1, 1, 'GALLERY/estabGallery1'),
(4, 2, 'GALLERY/estabGallery3'),
(33, 1, 'GALLERY/estabGallery33'),
(5, 2, 'GALLERY/estabGallery4'),
(6, 2, 'GALLERY/estabGallery5'),
(7, 3, 'GALLERY/estabGallery6'),
(8, 3, 'GALLERY/estabGallery7'),
(9, 3, 'GALLERY/estabGallery8'),
(10, 3, 'GALLERY/estabGallery9'),
(11, 3, 'GALLERY/estabGallery10'),
(12, 3, 'GALLERY/estabGallery11'),
(16, 4, 'GALLERY/estabGallery13'),
(15, 4, 'GALLERY/estabGallery12'),
(17, 4, 'GALLERY/estabGallery14'),
(18, 4, 'GALLERY/estabGallery15'),
(19, 4, 'GALLERY/estabGallery16'),
(20, 1, 'GALLERY/estabGallery17'),
(21, 5, 'GALLERY/estabGallery18'),
(22, 5, 'GALLERY/estabGallery19'),
(23, 5, 'GALLERY/estabGallery20'),
(24, 5, 'GALLERY/estabGallery21'),
(25, 5, 'GALLERY/estabGallery22'),
(26, 5, 'GALLERY/estabGallery23'),
(37, 10, 'GALLERY/estabGallery37'),
(36, 9, 'GALLERY/estabGallery36'),
(35, 9, 'GALLERY/estabGallery35'),
(34, 9, 'GALLERY/estabGallery34'),
(32, 8, 'GALLERY/estabGallery28'),
(38, 10, 'GALLERY/estabGallery38'),
(39, 10, 'GALLERY/estabGallery39');

-- --------------------------------------------------------

--
-- Table structure for table `PLAN_DURATION_TB`
--

CREATE TABLE IF NOT EXISTS `PLAN_DURATION_TB` (
  `id` int(11) NOT NULL,
  `duration_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `duration_visibility` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `PLAN_DURATION_TB`
--

INSERT INTO `PLAN_DURATION_TB` (`id`, `duration_name`, `description`, `duration_visibility`) VALUES
(1, 'day', 'Pay subscription payments daily.', 'VISIBLE'),
(2, 'week', 'A more flexible plan for small scale business. Recommended for starters.', 'VISIBLE'),
(3, 'month', 'The most common subscription plan. Usually for small to medium type of businesses.', 'VISIBLE'),
(4, 'year', 'Let''s you worry less for payments. Fix it annually for hassle free subscriptions. Great for large scale establishments.', 'VISIBLE'),
(5, 'other', 'Customized subscription promos for a more preferred subscription specifications.', 'VISIBLE');

-- --------------------------------------------------------

--
-- Table structure for table `PLAN_TB`
--

CREATE TABLE IF NOT EXISTS `PLAN_TB` (
  `id` int(11) NOT NULL,
  `plan_interval` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `plan_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `estab_no` int(11) NOT NULL,
  `branch_no` int(11) NOT NULL,
  `cost` decimal(19,4) NOT NULL,
  `visibility` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_interval` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interval_count` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `PLAN_TB`
--

INSERT INTO `PLAN_TB` (`id`, `plan_interval`, `plan_name`, `estab_no`, `branch_no`, `cost`, `visibility`, `custom_interval`, `interval_count`) VALUES
(5, '2', 'Weekly Plan Small', 1, 3, '3000.0000', 'VISIBLE', '', ''),
(6, '2', 'Weekly Plan Medium', 3, 10, '15000.0000', 'VISIBLE', '', ''),
(7, '2', 'Weekly Plan Large', 5, 50, '72500.0000', 'VISIBLE', '', ''),
(8, '3', 'Monthly Plan Small', 1, 3, '10000.0000', 'VISIBLE', '', ''),
(9, '3', 'Monthly Plan Medium', 3, 10, '50000.0000', 'VISIBLE', '', ''),
(10, '3', 'Monthly Plan Large', 5, 50, '200000.0000', 'VISIBLE', '', ''),
(11, '4', 'Yearly Plan Small', 1, 3, '100000.0000', 'VISIBLE', '', ''),
(12, '4', 'Yearly Plan Medium', 3, 10, '500000.0000', 'VISIBLE', '', ''),
(13, '4', 'Yearly Plan Large', 5, 50, '2500000.0000', 'VISIBLE', '', ''),
(20, '5', 'Mid-Year Pioneer Promo', 10, 100, '1000000.0000', 'VISIBLE', 'month', '6'),
(23, '5', 'Customized plan', 2, 2, '1000.0000', 'HIDDEN', 'month', '2');

-- --------------------------------------------------------

--
-- Table structure for table `REVIEW_TB`
--

CREATE TABLE IF NOT EXISTS `REVIEW_TB` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `submit_date` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `REVIEW_TB`
--

INSERT INTO `REVIEW_TB` (`id`, `user_id`, `branch_id`, `rating`, `comment`, `submit_date`) VALUES
(1, 1, 1, 5, 'Good banking services.', 1478328575),
(2, 14, 1, 4, 'Staffs are accomodating', 1478360394),
(3, 24, 7, 4, 'Ambiance is so great here!', 1478618168);

-- --------------------------------------------------------

--
-- Table structure for table `SUBSCRIBED_PLAN`
--

CREATE TABLE IF NOT EXISTS `SUBSCRIBED_PLAN` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `SUBSCRIBED_PLAN`
--

INSERT INTO `SUBSCRIBED_PLAN` (`id`, `owner_id`, `plan_id`, `status`, `stripe_id`) VALUES
(1, 9, 8, 'ACTIVE', 'sub_9VN3NHIn6LUGLV'),
(2, 9, 9, 'ACTIVE', 'sub_9VOiO7PU7uXC9d'),
(3, 1, 5, 'ACTIVE', 'sub_9VOlgGHJY2kBnu'),
(4, 9, 5, 'ACTIVE', 'sub_9VOm9jj57L4SPk'),
(5, 21, 8, 'ACTIVE', 'sub_9VuPlkcRJQ9scy'),
(6, 21, 11, 'ACTIVE', 'sub_9Vxl8EyjVvKcyc'),
(7, 18, 9, 'ACTIVE', 'sub_9WBof3TiDgQXu8'),
(8, 22, 9, 'ACTIVE', 'sub_9WEwYlbryt6E66'),
(9, 24, 8, 'ACTIVE', 'sub_9WI70dYZrD4cYZ'),
(10, 24, 20, 'ACTIVE', 'sub_9WHk00nQaBt5lH'),
(11, 9, 7, 'ACTIVE', 'sub_9ZHmigStSSedwu');

-- --------------------------------------------------------

--
-- Table structure for table `SUBSPLAN_ESTAB_TB`
--

CREATE TABLE IF NOT EXISTS `SUBSPLAN_ESTAB_TB` (
  `id` int(11) NOT NULL,
  `subs_plan_id` int(11) NOT NULL,
  `estab_id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `SUBSPLAN_ESTAB_TB`
--

INSERT INTO `SUBSPLAN_ESTAB_TB` (`id`, `subs_plan_id`, `estab_id`) VALUES
(1, 1, 1),
(2, 5, 2),
(3, 7, 3),
(4, 8, 4),
(5, 10, 5),
(9, 2, 9),
(8, 9, 8),
(10, 10, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ACTIVITY_LOG_TB`
--
ALTER TABLE `ACTIVITY_LOG_TB`
  ADD PRIMARY KEY (`id`), ADD KEY `activity_user_id` (`user_id`);

--
-- Indexes for table `BOOKMARK_TB`
--
ALTER TABLE `BOOKMARK_TB`
  ADD PRIMARY KEY (`user_id`,`branch_id`), ADD KEY `bookmark_branch_id` (`branch_id`);

--
-- Indexes for table `BRANCHES_GALLERY_TB`
--
ALTER TABLE `BRANCHES_GALLERY_TB`
  ADD PRIMARY KEY (`id`), ADD KEY `br_gal_branch_id_FK` (`branch_id`), ADD KEY `br_gal_gallery_id_FK` (`gallery_id`);

--
-- Indexes for table `BRANCHES_TB`
--
ALTER TABLE `BRANCHES_TB`
  ADD PRIMARY KEY (`id`,`estab_id`), ADD KEY `branch_estab_id_FK` (`estab_id`);

--
-- Indexes for table `BUSINESS_HOURS_TB`
--
ALTER TABLE `BUSINESS_HOURS_TB`
  ADD PRIMARY KEY (`id`,`day_no`), ADD KEY `bh_branch_id_FK` (`branch_id`);

--
-- Indexes for table `CATEGORY_TB`
--
ALTER TABLE `CATEGORY_TB`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `END_USER_TB`
--
ALTER TABLE `END_USER_TB`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `ESTABLISHMENT_TB`
--
ALTER TABLE `ESTABLISHMENT_TB`
  ADD PRIMARY KEY (`id`), ADD KEY `estab_owner_id_FK` (`owner_id`), ADD KEY `estab_category_id` (`category_id`);

--
-- Indexes for table `GALLERY_TB`
--
ALTER TABLE `GALLERY_TB`
  ADD PRIMARY KEY (`id`,`estab_id`), ADD KEY `gallery_estab_id_FK` (`estab_id`);

--
-- Indexes for table `PLAN_DURATION_TB`
--
ALTER TABLE `PLAN_DURATION_TB`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PLAN_TB`
--
ALTER TABLE `PLAN_TB`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `REVIEW_TB`
--
ALTER TABLE `REVIEW_TB`
  ADD PRIMARY KEY (`id`,`user_id`,`branch_id`), ADD KEY `review_user_id_FK` (`user_id`), ADD KEY `review_branch_id_FK` (`branch_id`);

--
-- Indexes for table `SUBSCRIBED_PLAN`
--
ALTER TABLE `SUBSCRIBED_PLAN`
  ADD PRIMARY KEY (`id`,`owner_id`), ADD KEY `subs_plan_owner_FK` (`owner_id`), ADD KEY `subs_plan_id_fk` (`plan_id`);

--
-- Indexes for table `SUBSPLAN_ESTAB_TB`
--
ALTER TABLE `SUBSPLAN_ESTAB_TB`
  ADD PRIMARY KEY (`id`), ADD KEY `subsplan_id_FK` (`subs_plan_id`), ADD KEY `subs_estab_id_FK` (`estab_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ACTIVITY_LOG_TB`
--
ALTER TABLE `ACTIVITY_LOG_TB`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=619;
--
-- AUTO_INCREMENT for table `BRANCHES_GALLERY_TB`
--
ALTER TABLE `BRANCHES_GALLERY_TB`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `BRANCHES_TB`
--
ALTER TABLE `BRANCHES_TB`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `BUSINESS_HOURS_TB`
--
ALTER TABLE `BUSINESS_HOURS_TB`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `CATEGORY_TB`
--
ALTER TABLE `CATEGORY_TB`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `END_USER_TB`
--
ALTER TABLE `END_USER_TB`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `ESTABLISHMENT_TB`
--
ALTER TABLE `ESTABLISHMENT_TB`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `GALLERY_TB`
--
ALTER TABLE `GALLERY_TB`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `PLAN_DURATION_TB`
--
ALTER TABLE `PLAN_DURATION_TB`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `PLAN_TB`
--
ALTER TABLE `PLAN_TB`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `REVIEW_TB`
--
ALTER TABLE `REVIEW_TB`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `SUBSCRIBED_PLAN`
--
ALTER TABLE `SUBSCRIBED_PLAN`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `SUBSPLAN_ESTAB_TB`
--
ALTER TABLE `SUBSPLAN_ESTAB_TB`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ESTABLISHMENT_TB`
--
ALTER TABLE `ESTABLISHMENT_TB`
ADD CONSTRAINT `estab_category_id` FOREIGN KEY (`category_id`) REFERENCES `CATEGORY_TB` (`id`);

--
-- Constraints for table `SUBSCRIBED_PLAN`
--
ALTER TABLE `SUBSCRIBED_PLAN`
ADD CONSTRAINT `subs_plan_id_fk` FOREIGN KEY (`plan_id`) REFERENCES `PLAN_TB` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
