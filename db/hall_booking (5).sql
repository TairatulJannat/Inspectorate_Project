-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2023 at 07:17 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hall_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(86) DEFAULT NULL,
  `lastname` varchar(86) DEFAULT NULL,
  `mobile` varchar(16) DEFAULT NULL,
  `email` varchar(124) DEFAULT NULL,
  `password` varchar(124) DEFAULT NULL,
  `status_id` tinyint(1) DEFAULT 1 COMMENT '1=Active,0=Inactive,2=Deleted',
  `created_at` datetime NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `lastname`, `mobile`, `email`, `password`, `status_id`, `created_at`, `created_by`, `updated_at`, `version`, `remember_token`, `role_id`, `type`) VALUES
(92, 'Super Admin', '', '01761955765', 'admin@gmail.com', '$2y$10$qBVDA/DLRKUVAS9bW39H9OBorvEDhS6MJGIqut.eZPCidaDLz4MEC', 1, '2021-02-07 11:07:04', 85, '2021-12-23 09:07:10', 1, '53tBzgdXyHfDV7iILWRydoAdOwLq28qIrcCCj6eEYBJU3dtbFeiYhHNOzSdy', 11, 'admin'),
(111, 'job fair admin', NULL, '01761955765', 'job_fair_admin@gmail.com', '$2y$10$LiZ4t.Jx06GzrQzJ5rDx9unFOKWN6rR5.apPnz1SIPDnd/M3Nh0xS', 2, '2022-05-19 05:44:13', 92, '2023-10-16 16:10:21', NULL, NULL, 11, 'admin'),
(112, 'asdad', NULL, '123123', 'shuvo@gmail.com', '$2y$10$6zgT/gZSe8Nm8AgFiWLk6uMosN7kgc9HO8FJ4QNpBqFSA2ZcOfmEe', 2, '2023-09-12 03:45:44', 92, '2023-10-22 16:06:04', NULL, NULL, 11, 'admin'),
(113, 'happy', NULL, '123123', 'shuvo@gmail.com', '$2y$10$WlWmbKIUQ7hR6GnJbRe/A.I73bDRk/7aBDigIrPFWd5bGShc58oxm', 2, '2023-09-12 03:46:56', 92, '2023-10-22 16:06:00', NULL, NULL, 12, 'admin'),
(114, 'viewer', NULL, '123123', 'manjur@gmail.com', '$2y$10$W8Mu6MvfKpJUGuOR8k15SOY9rrc1EE7Oinyrala4Xz5K8kFqHXiWe', 2, '2023-10-16 16:15:29', 92, '2023-10-22 16:05:57', NULL, NULL, 20, 'admin'),
(115, 'shuvo', NULL, '123123', 'shuvo@gmail.com', '$2y$10$ti3bZxFcUgHAuOWpNHaeQ.MDPrEBwxN7E5fl4Bn5FHY3q2pMxEtvi', 1, '2023-10-22 16:06:39', 92, '2023-10-22 16:06:39', NULL, NULL, 12, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_routes`
--

CREATE TABLE `dynamic_routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `controller_action` varchar(255) DEFAULT NULL,
  `function_name` varchar(255) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL COMMENT 'get,post',
  `route_type` tinyint(1) DEFAULT 1 COMMENT '1=main,0=public',
  `parameter` varchar(255) DEFAULT NULL,
  `route_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active,0=not active',
  `show_in_menu` int(11) DEFAULT 0 COMMENT '0=no,1=yes',
  `ajax` varchar(255) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `dynamic_routes`
--

INSERT INTO `dynamic_routes` (`id`, `title`, `url`, `model_name`, `content`, `controller_action`, `function_name`, `method`, `route_type`, `parameter`, `route_status`, `show_in_menu`, `ajax`, `created_at`, `updated_at`) VALUES
(1, 'adminDashboard', 'adminDashboard', 'AdminDashboard', NULL, 'AdminDashboarController', 'index', 'get', 1, NULL, 1, 0, '0', NULL, '2021-01-17 22:36:57'),
(3, 'Show Routs', 'dynamic_route', 'Route', NULL, 'RouteController', 'dynamic_route', 'get', 1, NULL, 1, 1, '0', '2020-12-23 17:11:03', '2021-03-18 09:19:43'),
(4, 'ADD Route', 'dynamic_route', 'Route', NULL, 'RouteController', 'save_dynamic_route', 'Post', 1, NULL, 1, 0, '0', '2020-12-23 17:13:07', '2020-12-23 17:13:07'),
(5, 'Roles', 'role/all_role', 'Role', NULL, 'RoleController', 'all_role', 'get', 1, NULL, 1, 1, '0', '2020-12-23 17:35:33', '2021-06-10 07:00:32'),
(6, 'Add Role', 'role/add_role', 'Role', NULL, 'RoleController', 'add_role', 'get', 1, NULL, 1, 1, '0', '2020-12-23 17:36:01', '2021-06-10 06:59:12'),
(8, 'save role', 'save_role', 'Role', NULL, 'RoleController', 'save_role', 'Post', 1, NULL, 1, 0, '0', '2020-12-23 21:10:26', '2020-12-26 17:36:28'),
(9, 'Show Users', 'all_user', 'User', NULL, 'UserController', 'all_user', 'get', 1, NULL, 1, 1, '0', '2020-12-23 21:40:53', '2021-03-18 09:20:11'),
(10, 'save user', 'save_user', 'User', NULL, 'UserController', 'save_user', 'Post', 1, NULL, 1, 0, '0', '2020-12-23 21:54:33', '2020-12-23 21:54:33'),
(11, 'Edit Role', 'edit_role', 'Role', NULL, 'RoleController', 'edit_role', 'get', 1, '{id}', 1, 0, '0', '2020-12-26 16:22:10', '2020-12-26 17:28:54'),
(12, 'Update Role', 'update_role', 'Role', NULL, 'RoleController', 'update_role', 'Post', 1, '{id}', 1, 0, '0', '2020-12-26 16:46:07', '2021-01-11 22:25:35'),
(13, 'Delete Role', 'delete_role', 'Role', NULL, 'RoleController', 'delete_role', 'get', 1, '{id}', 1, 0, '0', '2020-12-26 16:56:05', '2020-12-26 16:56:05'),
(14, 'Delete Route', 'delete_route', 'Route', NULL, 'RouteController', 'delete_route', 'get', 1, '{id}', 1, 0, '0', '2020-12-26 16:59:22', '2020-12-26 16:59:22'),
(16, 'Edit Route', 'edit_route', 'Route', NULL, 'RouteController', 'edit_route', 'get', 0, '{id}', 1, 0, '0', '2020-12-26 17:03:02', '2020-12-26 17:16:35'),
(19, 'Update Route', 'update_route', 'Route', NULL, 'RouteController', 'update_route', 'Post', 1, '{id}', 1, 0, '0', '2020-12-26 17:13:20', '2020-12-26 17:13:20'),
(91, 'Chnage Password', 'admin/change_password', 'AdminDashboard', NULL, 'AdminDashboarController', 'change_password', 'get', 1, NULL, 1, 0, '0', '2021-01-17 22:38:34', '2021-01-18 18:20:41'),
(92, 'Save Change Password', 'admin/save_change_password', 'AdminDashboard', NULL, 'AdminDashboarController', 'save_change_password', 'Post', 1, NULL, 1, 0, '0', '2021-01-19 18:04:46', '2021-01-19 18:04:46'),
(93, 'Edit User', 'edit_user', 'User', NULL, 'UserController', 'edit_user', 'get', 1, '{id}', 1, 0, '1', '2021-01-20 21:42:58', '2021-01-20 21:42:58'),
(94, 'Upadte User', 'upadte_user', 'User', NULL, 'UserController', 'upadte_user', 'Post', 1, NULL, 1, 0, '0', '2021-01-20 22:11:40', '2021-01-20 22:27:28'),
(95, 'Suspend user', 'suspend_user', 'User', NULL, 'UserController', 'suspend_user', 'get', 1, '{id}', 1, 0, '0', '2021-01-20 22:34:00', '2021-01-20 22:34:00'),
(96, 'unsuspend user', 'unsuspend_user', 'User', NULL, 'UserController', 'unsuspend_user', 'get', 1, '{id}', 1, 0, '0', '2021-01-20 22:58:06', '2021-01-20 22:58:06'),
(127, 'Delete user', 'delete_user', 'User', NULL, 'UserController', 'delete_user', 'get', 1, '{id}', 1, 0, '0', '2021-06-10 06:50:43', '2021-06-10 06:50:43'),
(130, 'Test Menu', 'test', 'ModelMenu', NULL, 'MenuController', 'getLevel3Childern', 'get', 1, '{id}', 1, 1, '1', '2021-06-24 06:27:04', '2021-06-24 06:27:04'),
(131, 'Create menu', 'menu/menu_create', 'Menu', NULL, 'MenuController', 'create_menu', 'get', 1, NULL, 1, 1, '0', '2021-06-29 17:33:06', '2021-06-29 17:33:06'),
(133, 'Save Menu', 'menu/menu_save', 'Menu', NULL, 'MenuController', 'menu_save', 'Post', 1, NULL, 1, 0, '0', '2021-07-04 15:03:45', '2021-07-04 15:49:37'),
(134, 'ALL Menu', 'menu/all_menu', 'Menu', NULL, 'MenuController', 'all_menu', 'get', 1, NULL, 1, 1, '0', '2021-07-04 16:03:13', '2021-07-04 16:03:13'),
(135, 'Search Menu', 'menu/menu_search', 'Menu', NULL, 'MenuController', 'menu_search', 'Post', 1, NULL, 1, 0, '1', '2021-07-04 17:15:11', '2021-07-04 17:15:11'),
(138, 'Edit Menu', 'menu/edit_menu', 'Menu', NULL, 'MenuController', 'edit_menu', 'get', 1, '{id}', 1, 0, '0', '2021-07-05 11:49:25', '2021-07-05 11:49:25'),
(139, 'Update Menu', 'menu/update_menu', 'Menu', NULL, 'MenuController', 'update_menu', 'Post', 1, '{id}', 1, 0, '0', '2021-07-05 11:50:06', '2021-07-05 11:58:36'),
(274, 'Change Password form', 'password/change_pasword', 'passwordChange', NULL, 'AdminDashboarController', 'change_pasword', 'get', 1, NULL, 1, 1, '0', '2021-12-23 02:34:00', '2021-12-23 02:34:00'),
(275, 'Save Change Password', 'password/save_change_password', 'passwordChange', NULL, 'AdminDashboarController', 'save_change_password', 'Post', 1, NULL, 1, 0, '0', '2021-12-23 02:34:57', '2021-12-23 03:05:49');

-- --------------------------------------------------------

--
-- Table structure for table `master_menu`
--

CREATE TABLE `master_menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_name` varchar(100) NOT NULL,
  `menu_name_bn` varchar(100) NOT NULL,
  `menu_parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `menu_is_active` int(11) DEFAULT NULL,
  `menu_icon_class` varchar(100) DEFAULT NULL,
  `menu_dynamic_route_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `master_menu`
--

INSERT INTO `master_menu` (`id`, `menu_name`, `menu_name_bn`, `menu_parent_id`, `menu_is_active`, `menu_icon_class`, `menu_dynamic_route_id`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Dashboard', 'ড্যাশবোর্ড', NULL, 0, 'ik-home', 1, '2023-09-11 17:27:05', '2023-09-11 11:27:05', 1, 92);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_09_18_033200_create_floors_table', 2),
(6, '2023_09_19_032952_create_halls_table', 3),
(7, '2023_09_20_042546_create_shifts_table', 4),
(8, '2023_09_20_062818_create_hall_accessories_facilities_table', 5),
(9, '2023_09_21_034616_create_user_categories_table', 6),
(10, '2023_09_21_052021_create_hall_prices_table', 7),
(11, '2023_09_24_051424_create_others_prices_table', 8),
(12, '2023_09_24_063127_create_settings_table', 9),
(13, '2023_09_25_032226_create_booking_cancellation_rules_table', 10),
(14, '2023_09_25_054810_create_booking_change_rules_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('user@gmail.com', 'kOhs7z3ESVOCZMtRtya5ZcYkfwk8GVRBIprSLHZyM6KY9LaAcTaXQ3apZv4TP7YY', '2022-05-22 00:37:08'),
('user@gmail.com', 'MMmiu9fBl8IRGkf6PJA6SDjff4GSPGHIoEp8DIHTFIXSkeh6kubDy4Lga68lAS7r', '2022-05-22 00:38:19'),
('user@gmail.com', 'LIfTsKgvWNigkwFxonbhtUrBFTKzId908bLirwRThMY9D6w5kN4NZHLDzvXfQjoU', '2022-05-22 00:38:29'),
('user@gmail.com', 'rBuNN7X6pdcRYGrXtFVjbbbwTkSiksQfKoDDsZh2zWhaeUhSHhDMNYcH2peJWkQd', '2022-05-22 00:39:06'),
('user@gmail.com', 'apMaBrO9CbSFvCRVG26bVC85QcTyv3JsLXB1cHuCT53rNommbFWAdpIBTmqwRHqq', '2022-05-22 00:39:35'),
('user@gmail.com', 'XXO1M6XBaEfzvNabByWfYVu307KCTQl6FU8bkN6qxHEFZb6REa733fLj5LOYEn8v', '2022-05-22 00:40:02'),
('rhythms@outlook.com', 'bxlrulG4eG7yTv3nXTBtcWxvuHbILWlCpDfzq6L2SjDrBnS6XQ1gDIw95kNiaexE', '2022-05-22 22:01:00'),
('rhythms@outlook.com', '6lvEqaGysQpuy2JbN0OVoXvmGWaDtgeAK5MyRuNwZT4fpLRxHqXyUSLFcnMRvdir', '2022-05-22 22:05:28'),
('rhythms@outlook.com', 'jJ1oE2sPFjsgmf0DwPlm1fbRxxAeIDgojxvkMhYSGzQi9dcwo3qsO2C9sYDCHa2V', '2022-05-22 22:06:17'),
('rhythms@outlook.com', 'WqytRUclAiNYmjWTMYKst3pSzGOvXnyzCpc4TlcvTp6eaHydPPPt9lr7xBfSTQyH', '2022-05-22 22:07:17'),
('rhythms@outlook.com', 'RTS5zKRx7LqaCEwMXknmcYzoJcYLUmK6Jj5mbec5I0NjNI4KDihIYqYqosINcu7I', '2022-05-22 22:07:20'),
('rhythms@outlook.com', 'KscypHsHe6KYtNFOxEEwDs2pQZefDNCknfuqIcTa6ChpJgcECpbildRAqYHZjYiN', '2022-05-22 22:07:47'),
('khasrur8@gmail.com', 'CrhW9E75ckpPk2VgdztcMMumQZ9UzZtVCfX23IVHrVpltOM8gN23gog6BnxLpWP8', '2022-05-22 22:42:17'),
('3434@sdds', 'qJxuVUaWRWbD4T68keMzT80HdzGWh3mK7P7dSRYUXDrbmzdpgkIxPesLQneklyxZ', '2022-05-22 22:45:11'),
('khasrur8@gmail.com', 'fDTT1sso1nMPvV0zKWjUTuTfLun9vZQFLRtvodYgTdv4eaItF2vOeyfRQggBaBQj', '2022-05-22 22:46:06'),
('khasrur8@gmail.com', 'cGUqE3BHV5dP8Hh30wFigi6SUpjCQ4xFhBfEjarFWcEDcAHj4pJGScN44E0bk0JB', '2022-05-22 22:58:46'),
('khasrur8@gmail.com', 'vxCGETQiYA7CgEzrMCbzMLJklnWF5jJGfOpjI3GprWUzDMJckfCnz4xlZeVUb0s7', '2022-05-22 22:59:22'),
('rhythms@outlook.com', 'b3N8UaLnESp8aI7W3DQjybSOnu5omgghRCJrWcOW26GiyZdh27d1h61eRR8NE45h', '2022-05-22 23:03:27'),
('rhythms@outlook.com', 'wYm92Gv1hbEbPE1H9fZVmU06bsrU0wtd4weO1hXzKdVnmLqpClkB3YMUQbcXR56q', '2022-05-22 23:03:50'),
('rhythms@outlook.com', 'hb680E4eXdfLBWU9DcOBBCXUToJGSaGq3C5cX93iyasgaafDtsp6r67fRmRZm2cK', '2022-05-22 23:05:34'),
('rhythms@outlook.com', 'a4Jhba5fmZ8okVHJGfOICtLGY80nJvMQpdmdsWhr8jPl0xpfPeqC2G6dnLHkSYGw', '2022-05-22 23:11:14'),
('rhythms@outlook.com', 'ksA3kgPwy2u6sD9wi7WE7bzs0jBWFhnucnNu6EPivclr9Mcjih2G89VUm3rcVIwD', '2022-05-22 23:11:53'),
('rhythms@outlook.com', 'arGpG0T640t7GuONcjoCEcQMqTzDbtcU37JFgcB3547cu1p4Zx9plDUDnv5aruBj', '2022-05-22 23:12:22'),
('khasrur8@gmail.com', 'zPkQFcgaHvf3sU2coXIPZx7X6e3OoYcziAb6lz8O1o3ijBysCocJjIq7AgPyDjFJ', '2022-05-22 23:12:50'),
('khasrur8@gmail.com', '5tfnIjLw2bSfuKmTY8aVjcz2Rlg9XvfUkIDVAoQujsIUbKx1zGpC5lwjokEsWALS', '2022-05-22 23:33:35'),
('user@gmail.com', 'kOhs7z3ESVOCZMtRtya5ZcYkfwk8GVRBIprSLHZyM6KY9LaAcTaXQ3apZv4TP7YY', '2022-05-22 00:37:08'),
('user@gmail.com', 'MMmiu9fBl8IRGkf6PJA6SDjff4GSPGHIoEp8DIHTFIXSkeh6kubDy4Lga68lAS7r', '2022-05-22 00:38:19'),
('user@gmail.com', 'LIfTsKgvWNigkwFxonbhtUrBFTKzId908bLirwRThMY9D6w5kN4NZHLDzvXfQjoU', '2022-05-22 00:38:29'),
('user@gmail.com', 'rBuNN7X6pdcRYGrXtFVjbbbwTkSiksQfKoDDsZh2zWhaeUhSHhDMNYcH2peJWkQd', '2022-05-22 00:39:06'),
('user@gmail.com', 'apMaBrO9CbSFvCRVG26bVC85QcTyv3JsLXB1cHuCT53rNommbFWAdpIBTmqwRHqq', '2022-05-22 00:39:35'),
('user@gmail.com', 'XXO1M6XBaEfzvNabByWfYVu307KCTQl6FU8bkN6qxHEFZb6REa733fLj5LOYEn8v', '2022-05-22 00:40:02'),
('rhythms@outlook.com', 'bxlrulG4eG7yTv3nXTBtcWxvuHbILWlCpDfzq6L2SjDrBnS6XQ1gDIw95kNiaexE', '2022-05-22 22:01:00'),
('rhythms@outlook.com', '6lvEqaGysQpuy2JbN0OVoXvmGWaDtgeAK5MyRuNwZT4fpLRxHqXyUSLFcnMRvdir', '2022-05-22 22:05:28'),
('rhythms@outlook.com', 'jJ1oE2sPFjsgmf0DwPlm1fbRxxAeIDgojxvkMhYSGzQi9dcwo3qsO2C9sYDCHa2V', '2022-05-22 22:06:17'),
('rhythms@outlook.com', 'WqytRUclAiNYmjWTMYKst3pSzGOvXnyzCpc4TlcvTp6eaHydPPPt9lr7xBfSTQyH', '2022-05-22 22:07:17'),
('rhythms@outlook.com', 'RTS5zKRx7LqaCEwMXknmcYzoJcYLUmK6Jj5mbec5I0NjNI4KDihIYqYqosINcu7I', '2022-05-22 22:07:20'),
('rhythms@outlook.com', 'KscypHsHe6KYtNFOxEEwDs2pQZefDNCknfuqIcTa6ChpJgcECpbildRAqYHZjYiN', '2022-05-22 22:07:47'),
('khasrur8@gmail.com', 'CrhW9E75ckpPk2VgdztcMMumQZ9UzZtVCfX23IVHrVpltOM8gN23gog6BnxLpWP8', '2022-05-22 22:42:17'),
('3434@sdds', 'qJxuVUaWRWbD4T68keMzT80HdzGWh3mK7P7dSRYUXDrbmzdpgkIxPesLQneklyxZ', '2022-05-22 22:45:11'),
('khasrur8@gmail.com', 'fDTT1sso1nMPvV0zKWjUTuTfLun9vZQFLRtvodYgTdv4eaItF2vOeyfRQggBaBQj', '2022-05-22 22:46:06'),
('khasrur8@gmail.com', 'cGUqE3BHV5dP8Hh30wFigi6SUpjCQ4xFhBfEjarFWcEDcAHj4pJGScN44E0bk0JB', '2022-05-22 22:58:46'),
('khasrur8@gmail.com', 'vxCGETQiYA7CgEzrMCbzMLJklnWF5jJGfOpjI3GprWUzDMJckfCnz4xlZeVUb0s7', '2022-05-22 22:59:22'),
('rhythms@outlook.com', 'b3N8UaLnESp8aI7W3DQjybSOnu5omgghRCJrWcOW26GiyZdh27d1h61eRR8NE45h', '2022-05-22 23:03:27'),
('rhythms@outlook.com', 'wYm92Gv1hbEbPE1H9fZVmU06bsrU0wtd4weO1hXzKdVnmLqpClkB3YMUQbcXR56q', '2022-05-22 23:03:50'),
('rhythms@outlook.com', 'hb680E4eXdfLBWU9DcOBBCXUToJGSaGq3C5cX93iyasgaafDtsp6r67fRmRZm2cK', '2022-05-22 23:05:34'),
('rhythms@outlook.com', 'a4Jhba5fmZ8okVHJGfOICtLGY80nJvMQpdmdsWhr8jPl0xpfPeqC2G6dnLHkSYGw', '2022-05-22 23:11:14'),
('rhythms@outlook.com', 'ksA3kgPwy2u6sD9wi7WE7bzs0jBWFhnucnNu6EPivclr9Mcjih2G89VUm3rcVIwD', '2022-05-22 23:11:53'),
('rhythms@outlook.com', 'arGpG0T640t7GuONcjoCEcQMqTzDbtcU37JFgcB3547cu1p4Zx9plDUDnv5aruBj', '2022-05-22 23:12:22'),
('khasrur8@gmail.com', 'zPkQFcgaHvf3sU2coXIPZx7X6e3OoYcziAb6lz8O1o3ijBysCocJjIq7AgPyDjFJ', '2022-05-22 23:12:50'),
('khasrur8@gmail.com', '5tfnIjLw2bSfuKmTY8aVjcz2Rlg9XvfUkIDVAoQujsIUbKx1zGpC5lwjokEsWALS', '2022-05-22 23:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `permission_roles`
--

CREATE TABLE `permission_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `dynamic_route_id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `permission_roles`
--

INSERT INTO `permission_roles` (`id`, `role_id`, `dynamic_route_id`, `url`, `created_at`, `updated_at`) VALUES
(10467, 16, 1, 'adminDashboard', '2021-06-24 06:43:48', '2021-06-24 06:43:48'),
(10468, 16, 91, 'admin/change_password', '2021-06-24 06:43:48', '2021-06-24 06:43:48'),
(10469, 16, 92, 'admin/save_change_password', '2021-06-24 06:43:48', '2021-06-24 06:43:48'),
(10470, 16, 9, 'all_user', '2021-06-24 06:43:48', '2021-06-24 06:43:48'),
(10471, 16, 93, 'edit_user', '2021-06-24 06:43:48', '2021-06-24 06:43:48'),
(10472, 16, 94, 'upadte_user', '2021-06-24 06:43:48', '2021-06-24 06:43:48'),
(10473, 16, 95, 'suspend_user', '2021-06-24 06:43:48', '2021-06-24 06:43:48'),
(10474, 16, 96, 'unsuspend_user', '2021-06-24 06:43:48', '2021-06-24 06:43:48'),
(10475, 16, 130, 'test', '2021-06-24 06:43:48', '2021-06-24 06:43:48'),
(13970, 12, 1, 'adminDashboard', '2021-12-29 22:37:31', '2021-12-29 22:37:31'),
(13971, 12, 91, 'admin/change_password', '2021-12-29 22:37:31', '2021-12-29 22:37:31'),
(13972, 12, 92, 'admin/save_change_password', '2021-12-29 22:37:31', '2021-12-29 22:37:31'),
(13986, 12, 274, 'password/change_pasword', '2021-12-29 22:37:31', '2021-12-29 22:37:31'),
(13987, 12, 275, 'password/save_change_password', '2021-12-29 22:37:31', '2021-12-29 22:37:31'),
(17735, 11, 1, 'adminDashboard', '2023-10-15 21:18:09', '2023-10-15 21:18:09'),
(17736, 11, 91, 'admin/change_password', '2023-10-15 21:18:09', '2023-10-15 21:18:09'),
(17737, 11, 92, 'admin/save_change_password', '2023-10-15 21:18:09', '2023-10-15 21:18:09'),
(17738, 11, 3, 'dynamic_route', '2023-10-15 21:18:09', '2023-10-15 21:18:09'),
(17739, 11, 4, 'dynamic_route', '2023-10-15 21:18:09', '2023-10-15 21:18:09'),
(17740, 11, 14, 'delete_route', '2023-10-15 21:18:09', '2023-10-15 21:18:09'),
(17741, 11, 16, 'edit_route', '2023-10-15 21:18:09', '2023-10-15 21:18:09'),
(17742, 11, 19, 'update_route', '2023-10-15 21:18:09', '2023-10-15 21:18:09'),
(17743, 11, 5, 'role/all_role', '2023-10-15 21:18:09', '2023-10-15 21:18:09'),
(17744, 11, 6, 'role/add_role', '2023-10-15 21:18:09', '2023-10-15 21:18:09'),
(17745, 11, 8, 'save_role', '2023-10-15 21:18:09', '2023-10-15 21:18:09'),
(17746, 11, 11, 'edit_role', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17747, 11, 12, 'update_role', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17748, 11, 13, 'delete_role', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17749, 11, 9, 'all_user', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17750, 11, 10, 'save_user', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17751, 11, 93, 'edit_user', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17752, 11, 94, 'upadte_user', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17753, 11, 95, 'suspend_user', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17754, 11, 96, 'unsuspend_user', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17755, 11, 127, 'delete_user', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17756, 11, 130, 'test', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17757, 11, 131, 'menu/menu_create', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17758, 11, 133, 'menu/menu_save', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17759, 11, 134, 'menu/all_menu', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17760, 11, 135, 'menu/menu_search', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17761, 11, 138, 'menu/edit_menu', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17762, 11, 139, 'menu/update_menu', '2023-10-15 21:18:10', '2023-10-15 21:18:10'),
(17763, 11, 274, 'password/change_pasword', '2023-10-15 21:18:11', '2023-10-15 21:18:11'),
(17764, 11, 275, 'password/save_change_password', '2023-10-15 21:18:11', '2023-10-15 21:18:11');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slag` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slag`, `created_at`, `updated_at`) VALUES
(11, 'Super Admin', 'super_admin', '2021-01-12 00:43:52', '2021-01-12 00:43:52'),
(12, 'Admin', 'admin', '2021-01-21 02:25:27', '2021-01-21 02:25:27'),
(16, 'SubAdmin', 'subadmin', '2021-04-26 17:53:50', '2021-04-26 17:53:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(86) DEFAULT NULL,
  `lastname` varchar(86) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(124) DEFAULT NULL,
  `password` varchar(124) DEFAULT NULL,
  `submit_status` varchar(255) DEFAULT '0' COMMENT '1=sumited, 0=not submited, 2=pending , 3 = Approved',
  `gender` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0 COMMENT '1=Active,0=Inactive,2=Deleted',
  `country` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `disapproval_reason` longtext DEFAULT NULL,
  `passport_status` varchar(255) DEFAULT NULL,
  `submit_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `mobile`, `email`, `password`, `submit_status`, `gender`, `status`, `country`, `course`, `year`, `disapproval_reason`, `passport_status`, `submit_date`, `created_at`, `created_by`, `updated_at`, `version`, `remember_token`) VALUES
(109, 'Test course Member', NULL, NULL, 'user@gmail.com', '$2y$10$aYztU1Lijx81Z8OW9LRe2OiSpORhbaFSPh6/rvd7IYWCmCF22BIba', '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-28 04:00:05', NULL, '2021-11-28 04:00:05', NULL, NULL),
(238, 'Jayme Morton', NULL, 'Ex sit sint duis of', 'rycecuwi@mailinator.com', '$2y$10$EguyK5cWKbem8a6st7glCOMZxriB9okfZNaPcaAgl51Aic9UG8OQ6', '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-18 13:08:45', NULL, '2022-05-18 13:08:45', NULL, NULL),
(239, 'MD Nazmus Sadat', NULL, '01769006627', 'sadat0311@gmail.com', '$2y$10$aU6tqkD.X8RndGzLiUORDOb8rJfVyIMlzB1Eqn77H6lL1OAcgSB8q', '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-18 15:50:52', NULL, '2022-05-18 15:50:52', NULL, NULL),
(240, 'sss', NULL, '01761955765', 'labony277@gmail.com', '$2y$10$KKErUAYQnP.6FW6Pro.vX.66bd9elN2G53B9KNSQ2X7t.aVxAWkh2', '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-19 03:32:05', NULL, '2022-05-19 03:32:05', NULL, NULL),
(241, 'Md.imam hossain', NULL, '01623898455', 'imam7bir@gmail.com', '$2y$10$MnWNk86WpHDPtbDbIvSbjuSKMaS0t0sUMDelriCIB6Y6k0yXOqTaW', '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-19 03:34:08', NULL, '2022-05-19 03:34:08', NULL, NULL),
(242, 'Scarlett Stafford', NULL, 'Exercitation saepe e', 'kareva@mailinator.com', '$2y$10$aKxvd.0uUiZbIM7b6jI0HOOHUP6KwP0I0zamaFrsGUuvGf3Hk.4yy', '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-19 03:39:13', NULL, '2022-05-19 03:39:13', NULL, NULL),
(243, 'Md Sahadad Bin Arif', NULL, '01811111820', 'bushratasin@gmail.com', '$2y$10$qv9D0Qgr.OOhAW2aT0LM6uny9e0A5xNguAzM5PDPvxxAbbxgIKKu6', '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-19 07:55:41', NULL, '2022-05-19 07:55:41', NULL, NULL),
(244, 'Md Delwar Hossain', NULL, '01720944859', 'delwarhossain28606@gmail.com', '$2y$10$CQy.BE22FRXskg4VPubqTey325w4KHhdI0vdRuUc9gVWzKdJpZMrG', '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-19 07:58:35', NULL, '2022-05-19 07:58:35', NULL, NULL),
(245, 'Md Enamul Haque', NULL, '01714707331', 'enamulhaque32453@gmail.com', '$2y$10$co64uKDtrysQYi3ErfqoEO7hGDHck6faYjVl5wReximYzNpfYF2CW', '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-19 08:13:57', NULL, '2022-05-19 08:13:57', NULL, NULL),
(246, 'MD. REZAUL KARIM', NULL, '01724731547', 'rezaulkarim45593@gmail.com', '$2y$10$WrghEIzkor3TBFF8kUeK4ura2vy/GaAKv0sxZ/qjk5iTrtFBp9YRi', '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-19 16:10:48', NULL, '2022-05-19 16:10:48', NULL, NULL),
(247, 'Mohammad Jakir Hossen', NULL, '01740738421', 'jakirchowdhury00848@gmail.com', '$2y$10$wtGZppFroqb9IgwtBLLWnuqtG/CVK10hAuZJi.rNYLGSlLeTSICN2', '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-19 16:58:44', NULL, '2022-05-19 16:58:44', NULL, NULL),
(248, 'Sumaiya Yesmin', NULL, '01762205907', 'sumaiya1096@gmail.com', '$2y$10$mQ/XGHTPDQ/9O6MTUS8q..bLD4gNV4m/POsrCqTfu6tPDPKLPbUNW', '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-22 07:21:18', NULL, '2022-05-22 07:21:18', NULL, NULL),
(249, 'Muhammad Rasel Mia', NULL, '01716-086829', 'raselahmed1823@gmail.com', '$2y$10$2q7Mr/3nDlKt5YonN7rzfuFMqP7a04.U3ncpEiE8feSCl5xHI6ify', '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-22 07:57:20', NULL, '2022-05-22 07:57:20', NULL, NULL),
(250, 'BADRUL ALAM', NULL, '008801616095116', 'badruluae@gmail.com', '$2y$10$EIo1.KNpOW5utbYDN/e16.F9ZTLLbN3Lkz9t24UEYnXxp8w0MyqV6', '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-22 10:49:04', NULL, '2022-05-22 10:49:04', NULL, NULL),
(251, 'Shazzadul Islam', NULL, '01914402850', 'shazzadbd@gmail.com', '$2y$10$GUMQKvLUyHk6jBfKp1X0VO7cH3kVkiVCO3Z7CbsExKK5R2iiuxEum', '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-23 03:20:51', NULL, '2022-05-23 03:20:51', NULL, NULL),
(252, 'Fardin Sabahat Khan', NULL, '01798324475', 'fardin41@gmail.com', '$2y$10$eIKL/X3M0KJKlqFuBmRpIuGrP/8mAnGoLK72JWgQKRlXJeJrjHil2', '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-23 04:56:15', NULL, '2022-05-23 04:56:15', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `role_id` (`role_id`) USING BTREE,
  ADD KEY `type` (`type`) USING BTREE;

--
-- Indexes for table `dynamic_routes`
--
ALTER TABLE `dynamic_routes`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `url` (`url`) USING BTREE,
  ADD KEY `model_name` (`model_name`) USING BTREE,
  ADD KEY `controller_action` (`controller_action`) USING BTREE,
  ADD KEY `method` (`method`) USING BTREE,
  ADD KEY `show_in_menu` (`show_in_menu`) USING BTREE,
  ADD KEY `ajax` (`ajax`) USING BTREE;

--
-- Indexes for table `master_menu`
--
ALTER TABLE `master_menu`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_menu_parent_id` (`menu_parent_id`) USING BTREE;

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permission_roles`
--
ALTER TABLE `permission_roles`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `permission_roles_role_id_foreign` (`role_id`) USING BTREE,
  ADD KEY `permission_roles_dynamic_route_id_foreign` (`dynamic_route_id`) USING BTREE,
  ADD KEY `dynamic_route_id` (`dynamic_route_id`) USING BTREE,
  ADD KEY `role_id` (`role_id`) USING BTREE;

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `roles_name_unique` (`name`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `dynamic_routes`
--
ALTER TABLE `dynamic_routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=402;

--
-- AUTO_INCREMENT for table `master_menu`
--
ALTER TABLE `master_menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `permission_roles`
--
ALTER TABLE `permission_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17901;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `master_menu`
--
ALTER TABLE `master_menu`
  ADD CONSTRAINT `fk_menu_parent_id` FOREIGN KEY (`menu_parent_id`) REFERENCES `master_menu` (`id`);

--
-- Constraints for table `permission_roles`
--
ALTER TABLE `permission_roles`
  ADD CONSTRAINT `permission_roles_ibfk_1` FOREIGN KEY (`dynamic_route_id`) REFERENCES `dynamic_routes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
