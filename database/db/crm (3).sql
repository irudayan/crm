-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2025 at 11:49 AM
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
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(2, 'default', '{\"uuid\":\"d6ba4948-311e-4259-9da1-29e28a2e3ff5\",\"displayName\":\"App\\\\Jobs\\\\SendFollowupEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendFollowupEmailJob\",\"command\":\"O:29:\\\"App\\\\Jobs\\\\SendFollowupEmailJob\\\":1:{s:7:\\\"\\u0000*\\u0000lead\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Leads\\\";s:2:\\\"id\\\";i:14;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}\"}}', 0, NULL, 1746016303, 1746016303),
(3, 'default', '{\"uuid\":\"03e8f6f5-2144-4c68-8fe0-33a6396a02d2\",\"displayName\":\"App\\\\Jobs\\\\SendFollowupEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendFollowupEmailJob\",\"command\":\"O:29:\\\"App\\\\Jobs\\\\SendFollowupEmailJob\\\":1:{s:7:\\\"\\u0000*\\u0000lead\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Leads\\\";s:2:\\\"id\\\";i:14;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}\"}}', 0, NULL, 1746017185, 1746017185);

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `product_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`product_ids`)),
  `status` enum('New','Qualified','Follow Up','Online Demo','Offline Demo','Onsite Visit','Quotation / Ready To Buy','Closed or Won','Dropped or Cancel','Dealers') NOT NULL DEFAULT 'New',
  `source` varchar(255) DEFAULT NULL,
  `assigned_by_id` bigint(20) DEFAULT NULL,
  `assigned_name` varchar(255) DEFAULT NULL,
  `remarks` longtext DEFAULT NULL,
  `assigned_to_remarks` longtext DEFAULT NULL,
  `mail_status` tinyint(1) NOT NULL DEFAULT 0,
  `is_pinned` tinyint(1) DEFAULT 0,
  `demo_date` date DEFAULT NULL,
  `demo_time` time DEFAULT NULL,
  `demo_mail_status` tinyint(4) DEFAULT 0,
  `follow_date` date DEFAULT NULL,
  `follow_time` time DEFAULT NULL,
  `follow_mail_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_updated_by` bigint(20) DEFAULT NULL,
  `opened_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `user_id`, `name`, `email`, `mobile`, `address`, `industry`, `purpose`, `product_ids`, `status`, `source`, `assigned_by_id`, `assigned_name`, `remarks`, `assigned_to_remarks`, `mail_status`, `is_pinned`, `demo_date`, `demo_time`, `demo_mail_status`, `follow_date`, `follow_time`, `follow_mail_status`, `created_at`, `updated_at`, `last_updated_by`, `opened_at`, `deleted_at`) VALUES
(1, 4, 'test1', 'irudayan111@gmail.com', '08069451003', '#16, 4th Main Rd, 2nd Block, Dwaraka Nagar, Nagarabhavi,', NULL, NULL, '[\"1\"]', 'Qualified', 'Twitter', NULL, '4', 'admin', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 0, '2025-03-22 04:41:46', '2025-04-10 15:00:16', NULL, NULL, '2025-04-10 15:00:16'),
(2, 5, 'test2', 'irudayan111@gmail.com', '08069451003', '#16, 4th Main Rd, 2nd Block, Dwaraka Nagar, Nagarabhavi,', NULL, NULL, '[\"2\"]', '', 'Twitter', NULL, '5', 'test', NULL, 1, 0, '2025-03-25', '20:09:00', 1, NULL, NULL, 0, '2025-03-22 04:43:13', '2025-04-09 17:29:03', NULL, NULL, '2025-04-09 17:29:03'),
(4, 1, 'test3', 'test@gmail.com', '8760870314', '16 4th Main Road Byraveshwaranagar Naagarabhaavi', NULL, 'test@gmail.com', '[\"3\"]', '', 'Facebook', NULL, '1', 'test@gmail.com', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-03-27 04:43:37', '2025-04-09 17:29:08', NULL, NULL, '2025-04-09 17:29:08'),
(6, 5, '12345', 'irudayan111@gmail.com', '8760870314', '#16, 4th Main Rd, 2nd Block, Dwaraka Nagar, Nagarabhavi,', NULL, '12345', '[\"1\"]', 'Quotation / Ready To Buy', 'Twitter', NULL, '5', '12345', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-03-27 06:11:24', '2025-04-09 17:29:12', NULL, NULL, '2025-04-09 17:29:12'),
(7, 2, 'savaridfsghjk', 'irudayan111@gmail.com', '08760870314', 'Visuvasampatti (vill)', NULL, 's', '[\"2\"]', 'Closed or Won', 'Instagram', NULL, '2', 'szvxbcvnm,.', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-03-27 06:17:41', '2025-04-09 17:29:17', NULL, NULL, '2025-04-09 17:29:17'),
(8, 2, 'Savari Irudaya Raj X', 'irudayan111@gmail.com', '8760870314', 'Visuvasampatti (vill)', NULL, 'sd', '[\"2\"]', 'Dropped or Cancel', 'Facebook', NULL, '2', 'test', NULL, 1, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-03-27 06:53:52', '2025-04-10 14:59:43', NULL, NULL, '2025-04-10 14:59:43'),
(9, NULL, 'Bongu', 'rohithmr07@gmail.com', '8884944703', 'Dwaraka Grand, 42, 1st Cross Rd, near Treebo Trend, Teacher\'s Colony, Sharada Nagar, Kumaraswamy Layout, Bengaluru, Karnataka', NULL, 'test', '[\"2\"]', '', 'Facebook', NULL, '6', 'test', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-08 19:34:07', '2025-04-10 15:00:11', NULL, NULL, '2025-04-10 15:00:11'),
(10, 4, 'raj', 'irudayan111@gmail.com', '8760870314', '#16, 4th Main Rd, 2nd Block, Dwaraka Nagar, Nagarabhavi,', 'iSaral Business Solutions', 'test', '[\"4\"]', 'Follow Up', 'LinkedIn', NULL, '4', 'test', NULL, 0, 0, '2025-04-10', '01:05:00', 1, NULL, NULL, 0, '2025-04-09 11:00:53', '2025-04-10 14:59:39', NULL, NULL, '2025-04-10 14:59:39'),
(14, 10, 'Lakshmi S', 'kapil@isaral.in', '9380074438', '70/17/36, vrushabhavathi nagara,kamakshipalya, 9th main, Bangalore North, Bangalore, Karnataka, India - 560079', 'dfxcghjkl', NULL, '[\"4\"]', 'Quotation / Ready To Buy', 'Facebook', NULL, '10', NULL, NULL, 1, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-10 15:33:25', '2025-05-12 10:30:00', NULL, NULL, NULL),
(15, 1, 'Lakshmi S', 'kapil@isaral.in', '9380074438', '70/17/36, vrushabhavathi nagara,kamakshipalya, 9th main, Bangalore North, Bangalore, Karnataka, India - 560079', 'dfxcghjkl', NULL, '[\"6\"]', 'Dropped or Cancel', 'YouTube', NULL, '1', NULL, NULL, 0, 1, NULL, NULL, 0, NULL, NULL, 0, '2025-04-10 15:34:06', '2025-05-09 06:38:36', NULL, NULL, NULL),
(18, 1, 'mamatha', 'mamatha@isaral.in', '9380074438', '70/17/36, vrushabhavathi nagara,kamakshipalya, 9th main, Bangalore North, Bangalore, Karnataka, India - 560079', 'dfxcghjkl', 'sdfrykjhgfd', '[\"1\",\"3\",\"4\",\"5\"]', 'Online Demo', 'YouTube', NULL, '1', 'djjjhfdsdg', NULL, 1, 1, '2025-04-15', '01:01:00', 1, NULL, NULL, 0, '2025-04-10 15:51:00', '2025-05-09 06:20:48', NULL, NULL, NULL),
(21, 14, 'Satish Kumar', 'sharanpremnath98@gmail.co', '8884701639', 'geddalahalli', 'Gardenia', NULL, '[\"4\"]', 'Follow Up', 'Customer Reference', NULL, '14', 'Call Back need Bar Code', NULL, 0, 0, NULL, NULL, 0, '2025-04-12', '10:30:00', 0, '2025-04-11 13:47:14', '2025-04-12 15:25:48', NULL, NULL, NULL),
(26, 15, 'Sourabh Sayagaon', 'sourabhsayagaon1@gmail.co', '9193736110', NULL, 'SUPER MARKET', NULL, '[\"6\"]', 'Dropped or Cancel', 'Facebook', NULL, '15', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-11 18:11:38', '2025-04-26 11:49:11', NULL, NULL, NULL),
(27, 14, 'Accounts', 'accounts@armolpolymers.co', '7406011224', 'Magadi Road', 'Armol Polymers Pvt Ltd', 'Need Priseing', '[\"4\"]', 'Closed or Won', 'Customer Reference', NULL, '14', 'Need overdue popup & Mail', NULL, 0, 1, NULL, NULL, 0, NULL, NULL, 0, '2025-04-11 18:48:36', '2025-05-09 06:31:56', NULL, NULL, NULL),
(28, 14, 'Rishvitha', 'solutionsimpulseit@gmail.com', '9502145144', 'Flat No.302,Plot No.654, Vag Devi Apartments, Padma Nagar Phase 2 Road, Hyderabad, Royal Hair Shop, Hyderabad - 500054', 'Impulse It Solutions', 'Accounting', '[\"4\"]', 'New', 'Marketing', NULL, '14', 'Tekken 3 Month Rental', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-12 15:08:12', '2025-05-08 10:59:43', NULL, NULL, NULL),
(29, 14, 'Brijesh Mishra', 'mishraneeta543@gmail.com', '8733979452', '4th Floor, B - 404, Sai Siddhi Apartment, Ramjanwadi, Chharwada Road, Chharwada Vapi (Gujarat) - 396 191', 'Neeta Enterprises', NULL, '[\"4\"]', 'Dropped or Cancel', 'Marketing', NULL, '14', 'Prise  Issue', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-12 15:12:34', '2025-04-17 16:03:07', NULL, NULL, NULL),
(30, 14, 'meghana', 'Hindustansawmillsales@gmail.com', '7996222901', 'Mysour', 'Hindustan Saw Mill & Wood Industri', 'Tally Customisation', '[\"4\"]', 'Closed or Won', 'Marketing', NULL, '14', 'done', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-12 15:36:18', '2025-04-14 17:54:20', NULL, NULL, NULL),
(31, 14, 'Ravi Suvarna', 'rupesh@isaral.in', '9742663255', NULL, 'Sri Ganesha Grand', 'Need Tally New', '[\"4\"]', 'New', 'Customer Reference', NULL, '14', 'Call Back on 14.4.2025', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-12 16:05:55', '2025-04-12 16:05:55', NULL, NULL, NULL),
(32, 14, 'Nawal Kishor pandey', 'saswat.kiranindustres@gmail.com', '9835849729', 'Bihar', 'saswat Kiran Industries Pvt Ltd', 'Tally New Pack', '[\"4\"]', 'Closed or Won', 'CA / auditor', NULL, '14', 'Done And Closed', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-14 17:53:49', '2025-04-14 17:53:49', NULL, NULL, NULL),
(33, 15, 'Chila Venu Gopal', 'chila.1990@rediffmail.co.in', '9199515270', NULL, 'zerox', NULL, '[\"6\"]', 'Dropped or Cancel', 'Facebook', NULL, '15', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-14 18:00:27', '2025-04-26 11:49:26', NULL, NULL, NULL),
(34, 15, 'Santosh Danta', 'santoshkumardanta@gmail.com', '9199379947', NULL, NULL, NULL, '[\"14\"]', 'Dropped or Cancel', 'Facebook', NULL, '15', NULL, NULL, 0, 0, NULL, NULL, 0, '2025-04-15', NULL, 0, '2025-04-14 18:02:58', '2025-04-26 11:49:52', NULL, NULL, NULL),
(35, 14, 'Pallavi Rayapu', 'accounts@sellex.co.in', '8897843097', 'Bengalore', 'Sellex Incorp', NULL, '[\"4\"]', 'Closed or Won', 'Customer Reference', NULL, '14', 'Activation Done', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-14 18:44:25', '2025-04-22 11:09:50', NULL, NULL, NULL),
(36, 14, 'Sadanand', 'panchajanya1984@gmail.com', '9353242472', 'Rajajinagar', 'Prashanth R dhondale', 'Tally Silver', '[\"4\"]', 'Closed or Won', 'Marketing', NULL, '14', 'sold Tally ERP9 for 15000/- on 15-4-2025', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-16 09:57:37', '2025-04-16 09:57:37', NULL, NULL, NULL),
(37, 14, 'Sripal', 'nayana@isaral.in', '8421225225', 'Pune', 'Rupesh trading company', 'Biz analyst', '[\"4\"]', 'Quotation / Ready To Buy', 'Customer Reference', NULL, '14', 'After One Hower', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-16 10:28:55', '2025-04-17 15:49:43', NULL, NULL, NULL),
(38, 16, 'Ms Mary', 'balamarystethan97@gmail.c', '7348854792', 'Kanakapura Road', 'Small company', NULL, '[\"4\"]', 'Follow Up', 'Marketing', NULL, '16', 'collected  po need on next week', NULL, 0, 0, NULL, NULL, 0, '2025-04-16', '00:00:00', 0, '2025-04-16 11:03:26', '2025-04-25 13:16:18', NULL, NULL, NULL),
(39, 14, 'Nathmal Agarwal', 'n_agarwal06@yahoo.com', '9163377706', NULL, NULL, NULL, '[\"4\"]', 'Follow Up', 'Facebook', NULL, '14', NULL, NULL, 0, 0, NULL, NULL, 0, '2025-04-16', '12:30:00', 0, '2025-04-16 11:17:53', '2025-04-16 11:17:53', NULL, NULL, NULL),
(40, 14, 'Sarc Technology', 'sarc.tech@gmail.com', '8028390501', 'peenya', 'Sarc Technology', 'Tally AWS', '[\"1\"]', 'Dropped or Cancel', 'Marketing', NULL, '14', 'Network issue At Customer Place', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-16 14:37:11', '2025-04-19 11:59:40', NULL, NULL, NULL),
(41, 14, 'Bureau Of Indian', 'bnbo@bis.gov.in', '8028394955', 'peenya', 'Bureau Of Indian Standards', 'Tally AMC', '[\"5\"]', 'Follow Up', 'Marketing', NULL, '14', 'On Discussion', NULL, 0, 0, NULL, NULL, 0, '2025-05-01', '10:30:00', 0, '2025-04-16 14:46:07', '2025-04-22 10:03:29', NULL, NULL, NULL),
(42, 15, 'om murugaa enterpris', 'parandhamanas@gmail.com', '9189390807', NULL, NULL, NULL, '[\"6\"]', 'Dropped or Cancel', 'Facebook', NULL, '15', NULL, NULL, 0, 0, NULL, NULL, 0, '2025-04-17', NULL, 0, '2025-04-16 17:42:22', '2025-04-26 11:50:06', NULL, NULL, NULL),
(43, 14, 'Nayan Mehta', 'nayanmehta1000@gmail.com', '9435022212', 'Assam', 'Associated Agencies', 'Tally Invoice Customization', '[\"4\"]', 'Follow Up', 'Marketing', NULL, '14', 'Waiting For Payment  Confirmation', NULL, 0, 0, NULL, NULL, 0, '2025-04-21', '11:00:00', 0, '2025-04-17 14:05:04', '2025-04-19 11:58:09', NULL, NULL, NULL),
(44, 15, 'Mohammad Naushad Ala', 'dada.bhaimedical77@gmail.com', '9199030605', NULL, NULL, NULL, '[\"6\"]', 'Dropped or Cancel', 'Facebook', NULL, '15', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-17 16:36:26', '2025-04-26 11:50:22', NULL, NULL, NULL),
(45, 15, 'sj traders', 'ankalulakshman@gmail.com', '9199669060', NULL, NULL, NULL, '[\"6\"]', 'Follow Up', 'Facebook', NULL, '15', NULL, NULL, 0, 0, NULL, NULL, 0, '2025-04-18', '13:00:00', 0, '2025-04-17 16:39:45', '2025-04-17 16:39:45', NULL, NULL, NULL),
(46, 16, 'Chetannayak', 'kapil@isaral.in', '9035079892', NULL, NULL, NULL, '[\"4\"]', 'Follow Up', 'Just Dial', NULL, '16', NULL, NULL, 0, 0, NULL, NULL, 0, '2025-04-18', '14:40:00', 0, '2025-04-17 16:44:54', '2025-04-17 16:44:54', NULL, NULL, NULL),
(48, 15, 'Siddappa Pujari', 'palanduhfpcl@gmail.com', '9194484720', NULL, NULL, NULL, '[\"6\"]', 'Online Demo', 'Facebook', NULL, '15', NULL, NULL, 0, 1, NULL, NULL, 0, NULL, NULL, 0, '2025-04-18 12:46:10', '2025-05-09 06:21:09', NULL, NULL, NULL),
(49, 15, 'ashwin naren', 'ashyuga386@gmail.com', '9113233615', NULL, NULL, NULL, '[\"6\"]', 'Dropped or Cancel', 'Facebook', NULL, '15', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-18 12:52:55', '2025-04-26 11:48:39', NULL, NULL, NULL),
(50, 14, 'SHEKHAR kHIRAI', 'Shekhar.khirai@crepl.co.in', '9021751921', 'Mumbai-Pune', 'Continual Renewable Energy Private Limited', NULL, '[\"4\"]', 'Follow Up', 'Marketing', NULL, '14', 'call Back\r\nTallyAWS  Cloud', NULL, 0, 0, NULL, NULL, 0, '2025-04-19', '10:30:00', 0, '2025-04-18 18:16:52', '2025-04-19 11:53:46', NULL, NULL, NULL),
(51, 14, 'Ajay', 'ajay_shny@yahoo.co.in', '9880334152', 'BTM, Bangalore', 'Nisha Distributor', 'Tally Cloud', '[\"4\"]', 'Follow Up', 'Marketing', NULL, '14', 'need Best Prise', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-18 18:22:52', '2025-04-18 18:22:52', NULL, NULL, NULL),
(52, 14, 'Pankaj Kumar', 'pankaj71923@gmail.com', '9834071923', NULL, NULL, NULL, '[\"16\"]', 'Follow Up', 'Facebook', NULL, '14', NULL, NULL, 0, 0, NULL, NULL, 0, '2025-04-21', '17:00:00', 0, '2025-04-21 12:59:05', '2025-04-21 12:59:05', NULL, NULL, NULL),
(55, 16, 'Ahmed Khan', 'outfit78@gmail.com', '9591616966', NULL, NULL, NULL, '[\"4\"]', 'Follow Up', 'Just Dial', NULL, '16', 'price hicke', NULL, 0, 0, NULL, NULL, 0, '2025-04-21', '14:23:00', 0, '2025-04-21 14:30:11', '2025-04-25 13:23:34', NULL, NULL, NULL),
(56, 14, 'Bhavyashree', 'rupesh@isaral.in', '9916870073', 'peenya', 'Jio Technology', 'Tally Prime Gold & AWS Cloud', '[\"5\"]', 'New', 'Marketing', NULL, '14', 'Given Quotation', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-22 11:39:06', '2025-05-08 10:50:33', 14, '2025-04-29 16:49:30', NULL),
(58, 11, 'Sakti Pada Nag', 'saktipadanag7410@gmail.com', '9836089487', NULL, NULL, 'Need Tally Prime Software Silver / Gold Do Call', '[\"17\"]', 'Follow Up', 'Facebook', 12, '11', 'Do Follow up', NULL, 0, 0, NULL, NULL, 0, '2025-04-30', '11:30:00', 0, '2025-04-23 12:30:11', '2025-04-23 12:41:35', NULL, NULL, NULL),
(59, 11, 'Lobsang Arts', 'lobsangart84@gmail.com', '7259749990', NULL, NULL, 'Need Tally Prime Softwrae', '[\"17\"]', 'New', 'Facebook', 12, '11', NULL, NULL, 0, 0, NULL, NULL, 0, '2025-04-30', '11:30:00', 0, '2025-04-23 12:34:27', '2025-05-09 07:04:14', NULL, NULL, NULL),
(60, 11, 'Siddappa Pujari', 'palanduhfpcl@gmail.com', '9448472075', NULL, NULL, NULL, '[\"6\"]', 'Follow Up', 'Facebook', 12, '11', NULL, NULL, 0, 0, NULL, NULL, 0, '2025-04-23', '13:00:00', 0, '2025-04-23 12:48:48', '2025-04-23 12:52:58', NULL, NULL, NULL),
(61, 11, 'Bimal   Choraria', 'velvetcentre@hotmail.com', '8858902675', NULL, NULL, NULL, '[\"6\"]', 'New', 'Facebook', 12, '11', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-23 12:49:32', '2025-05-08 10:50:47', NULL, NULL, NULL),
(62, 11, 'Vinayak Shinde', 'vinayakshinde0955@gmail.com', '9035350955', NULL, NULL, NULL, '[\"6\"]', 'Follow Up', 'Facebook', 12, '11', NULL, NULL, 0, 0, NULL, NULL, 0, '2025-04-23', '16:00:00', 0, '2025-04-23 12:50:16', '2025-04-23 13:03:22', NULL, NULL, NULL),
(63, 11, 'Bala Krishna', 'balakrishna.sgp@gmail.com', '8790822812', NULL, NULL, NULL, '[\"6\"]', 'New', 'Facebook', 12, '11', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-23 12:50:56', '2025-05-09 07:04:10', NULL, NULL, NULL),
(64, 16, 'Antony', 'divyahn.87@gmail.com', '8867246398', NULL, NULL, NULL, '[\"18\"]', 'Follow Up', 'Just Dial', 8, '16', 'already  having tally trying to convert for cloude  need call back tuesday', NULL, 0, 0, NULL, NULL, 0, '2025-04-23', '14:00:00', 0, '2025-04-23 12:51:04', '2025-04-25 13:14:25', NULL, NULL, NULL),
(65, 11, 'Kamalesh Oswal', 'meetkamal2010@rediffmail.com', '8971611078', NULL, NULL, NULL, '[\"6\"]', 'New', 'Facebook', 12, '11', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-23 12:51:33', '2025-04-23 12:51:33', NULL, NULL, NULL),
(66, 15, 'DIGI IMF PVT LTD', 'digiudyog2024@gmail.com', '8597383582', NULL, NULL, 'Loan and finance', '[\"6\"]', 'Dropped or Cancel', 'Facebook', 12, '15', NULL, NULL, 0, 0, NULL, NULL, 0, '2025-04-26', '11:03:00', 0, '2025-04-23 12:52:11', '2025-04-26 11:47:59', NULL, NULL, NULL),
(67, 16, 'Nirali Meghani', 'nirali122304meghani@rediffmail.com', '8401005889', NULL, NULL, NULL, '[\"4\"]', 'Quotation / Ready To Buy', 'Just Dial', 8, '16', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-23 12:52:24', '2025-04-23 12:52:24', NULL, NULL, NULL),
(68, 15, 'Anil Gupta', 'Caanilg@gmail.com', '9811046546', NULL, NULL, NULL, '[\"6\"]', 'Dropped or Cancel', 'Facebook', 12, '15', 'they want cloud software and also asking  Busy software', NULL, 0, 0, NULL, NULL, 0, '2025-04-23', '14:00:00', 0, '2025-04-23 12:52:53', '2025-04-25 17:06:32', NULL, NULL, NULL),
(69, 11, 'A Anand Kumar', 'anandguruji21@gmail.com', '8892913480', NULL, NULL, NULL, '[\"6\"]', 'New', 'Facebook', 12, '11', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-23 12:53:37', '2025-04-23 12:53:37', NULL, NULL, NULL),
(70, 16, 'Bijaya kumar gowda', 'bijay19710203@gmail.com', '9198278508', NULL, NULL, NULL, '[\"4\"]', 'Online Demo', 'Facebook', 8, '16', 'free trial given', 't', 0, 1, NULL, NULL, 0, NULL, NULL, 0, '2025-04-23 12:53:43', '2025-05-14 11:29:15', 1, '2025-05-14 11:29:15', NULL),
(71, 11, 'Dalbir Singh Sidhu', 'dalbirabs@gmail.com', '7027466664', NULL, NULL, NULL, '[\"6\"]', 'New', 'Facebook', 12, '11', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-23 12:54:26', '2025-04-23 12:54:26', NULL, NULL, NULL),
(72, 11, 'Mahesh Hiroli', 'mahesh.s.hiroli11@gmail.com', '9686914038', NULL, NULL, NULL, '[\"6\"]', 'Follow Up', 'Facebook', 12, '11', NULL, NULL, 0, 0, NULL, NULL, 0, '2025-04-23', '16:00:00', 0, '2025-04-23 12:55:26', '2025-04-23 15:25:55', NULL, NULL, NULL),
(73, 11, 'Krishna Dg Krishna Dg', 'dgkrishna8@gmail.com', '9902342703', NULL, NULL, NULL, '[\"6\"]', 'New', 'Facebook', 12, '11', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-23 12:56:45', '2025-04-23 12:56:45', NULL, NULL, NULL),
(74, 11, 'babu', 'babu48736@gmail.com', '8015001444', NULL, NULL, NULL, '[\"6\"]', 'New', 'Facebook', 12, '11', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-23 12:57:22', '2025-04-23 12:57:22', NULL, NULL, NULL),
(75, 11, 'vinay', 'vin.bagalkot@yahoo.in', '9004014959', NULL, NULL, NULL, '[\"6\"]', 'Dropped or Cancel', 'Facebook', 12, '11', 'there are only providing billing software , we are not enquire anything', NULL, 0, 0, NULL, NULL, 0, '2025-04-23', '14:34:00', 0, '2025-04-23 12:57:55', '2025-04-26 10:57:16', NULL, NULL, NULL),
(77, 11, 'No Name', 'nomail@isaral.in', '9344226527', NULL, NULL, 'they want search for tally learning', '[\"19\"]', 'Dropped or Cancel', 'WhatsApp', 12, '11', 'they didn\'t want new license', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-23 13:08:02', '2025-04-23 15:05:52', NULL, NULL, NULL),
(78, 11, 'Jaya', 'nomail@isaral.in', '6382380354', NULL, NULL, NULL, '[\"19\"]', 'Dropped or Cancel', 'WhatsApp', 12, '11', 'JoB requirement', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-23 13:09:45', '2025-04-23 13:38:54', NULL, NULL, NULL),
(79, 8, 'Jagdish Ahuja', 'anita_agenciess@rediffmail.com', '9370644556', NULL, NULL, NULL, '[\"16\"]', 'Online Demo', 'Facebook', 8, '8', 'demo done yessterday', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-23 13:24:39', '2025-04-24 18:24:09', NULL, NULL, NULL),
(80, 15, 'sj traders', 'ankalulakshman@gmail.com', '9199669060', NULL, NULL, NULL, '[\"6\"]', 'Dropped or Cancel', 'Just Dial', 8, '15', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-23 13:39:52', '2025-04-25 17:07:59', NULL, NULL, NULL),
(81, 11, 'No Name', 'nomail@isaral.in', '6363784264', NULL, NULL, NULL, '[\"20\"]', 'Dropped or Cancel', 'WhatsApp', 12, '11', 'Mistakely searching', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-23 15:14:27', '2025-04-23 15:19:00', NULL, NULL, NULL),
(82, 15, 'harsha bhudolia', 'ganesh@isaral.in', '9304054340', NULL, NULL, 'billing', '[\"8\"]', 'Follow Up', 'YouTube', 13, '15', 'demo on 24/04/2025 at 3 PM', NULL, 0, 0, NULL, NULL, 0, '2025-04-24', '17:07:00', 0, '2025-04-23 15:39:21', '2025-04-25 17:07:38', NULL, NULL, NULL),
(83, 14, 'Riya aShaw', 'billing@exprorealtors.com', '8017689221', 'Kolkata West Bengal', 'EXPROLAB INFOTECH PVT LTD', 'Tally New pack', '[\"4\"]', 'Follow Up', 'Marketing', 14, '14', 'Serial number	:	739855368\r\nSilver Rental', NULL, 0, 0, NULL, NULL, 0, '2025-07-20', '10:10:00', 0, '2025-04-23 16:01:11', '2025-04-23 16:01:11', NULL, NULL, NULL),
(84, 15, 'babu', 'babu48736@gmail.com', '8015001444', NULL, NULL, 'for juice shop ,billing purpose', '[\"8\"]', 'Qualified', 'Facebook', 13, '15', 'Ganesh please call him tomorrow 24/04  morning 9.30 once,  and fix a demo', 'u', 0, 1, NULL, NULL, 0, NULL, NULL, 0, '2025-04-23 17:08:55', '2025-05-14 11:41:20', 1, NULL, NULL),
(85, 14, 'Mr Vishnu', NULL, '9450137592', NULL, NULL, 'tours & transport', '[\"4\"]', 'Follow Up', 'Just Dial', 8, '14', 'already tell the price on both silver & Gold', NULL, 0, 0, NULL, NULL, 0, '2025-04-24', NULL, 0, '2025-04-24 10:06:23', '2025-04-24 10:06:23', NULL, NULL, NULL),
(86, 15, 'Mr Adi', 'ganesh@isaral.in', '9972298111', NULL, NULL, 'Taxi and Airport Cabs', '[\"6\"]', 'Dropped or Cancel', 'Just Dial', 8, '15', 'Tomorrow fixed the Demo onsite at 2pm', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-24 10:11:54', '2025-04-28 12:31:39', NULL, NULL, NULL),
(87, 15, 'PRAKASH', 'ganesh@isaral.in', '7625053307', 'KADABAGERE', 'SUPER MART', 'SUPER MART MANAGEMENT - BILLING & BARCODING', '[\"9\"]', 'Offline Demo', 'Marketing', 15, '15', '27/04 @ 10:00AM', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-24 10:59:00', '2025-04-28 15:48:30', NULL, '2025-04-28 15:48:30', NULL),
(88, 15, 'JALALUDDIN', 'jkentdia@gmail.com', '9910912119', NULL, 'Manufactoring and trading company', 'they want busy software\r\n-manufactoring and trading company', '[\"6\"]', 'Follow Up', 'Facebook', 11, '15', 'u should explain price and all sir', NULL, 0, 0, NULL, NULL, 0, '2025-04-24', '13:35:00', 0, '2025-04-24 13:38:43', '2025-04-24 13:38:43', NULL, NULL, NULL),
(89, 16, 'Snayanraja Snayanraja', 'nayanrajans@gmail.com', '8970886677', NULL, NULL, 'They want new license tally prime gold', '[\"5\"]', 'Follow Up', 'Customer Reference', 11, '16', 'call disconnecting', NULL, 0, 0, NULL, NULL, 0, '2025-04-24', '16:22:00', 0, '2025-04-24 16:23:25', '2025-04-25 13:10:54', NULL, NULL, NULL),
(90, 14, 'Sait', 'sait906635@gmail.com', '8310961055', NULL, 'Temple', 'Billing', '[\"6\"]', 'Dropped or Cancel', 'Just Dial', 8, '14', 'Customer Not Required', NULL, 0, 1, NULL, NULL, 0, NULL, NULL, 0, '2025-04-24 17:08:10', '2025-05-09 07:13:24', NULL, NULL, NULL),
(91, 14, 'lakshmi Prakash', 'gklprakash@yahoo.co.in', '9845385715', 'Rajagopal Nagar', 'EKTA CNC Pvt Ltd', 'Tally New Pack', '[\"4\"]', 'Follow Up', 'Marketing', 14, '14', 'One Month Rental Giver', NULL, 0, 0, NULL, NULL, 0, '2025-05-20', '10:10:00', 0, '2025-04-24 18:11:41', '2025-04-24 18:12:32', NULL, NULL, NULL),
(94, 8, 'Pankaj Kumar', 'pankaj71923@gmail.com', '9199340719', NULL, NULL, 'Tally customization  collect the quotation form by vendors today', '[\"16\"]', 'Follow Up', 'Just Dial', 8, '8', NULL, NULL, 0, 0, NULL, NULL, 0, '2025-04-25', '14:00:00', 0, '2025-04-25 10:54:23', '2025-05-12 06:32:10', NULL, NULL, NULL),
(95, 15, 'Lakshmi Vidyadhara Raju Polepa', 'rajusaiganesh@gmail.com', '9949005014', NULL, 'Retail Medial', 'for maintaing medical shop\r\ncustomer wants;-stock summary,expired date,reports,batch wise report etc', '[\"6\"]', 'Dropped or Cancel', 'WhatsApp', 11, '15', 'already told price \r\nbusy- 1500+tax\r\nERP-1200+tax', NULL, 0, 0, NULL, NULL, 0, '2025-04-25', '12:07:00', 0, '2025-04-25 12:10:17', '2025-04-25 17:23:21', NULL, NULL, NULL),
(96, 14, 'Syed', 'qaswinternational777@gmail.com', '9740738514', 'Ullal , Bangalore', 'Qaswa International', 'Tally Old', '[\"4\"]', 'Closed or Won', 'Marketing', 14, '14', 'sold Tally Prime for 18000/- on 25-4-2025', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-25 18:02:36', '2025-04-25 18:03:48', NULL, NULL, NULL),
(97, 14, 'Chaitanya', NULL, '9606973718', 'Bengalore', 'Unique Builds', 'Need Tally  Silver', '[\"4\"]', 'Follow Up', 'Marketing', 14, '14', 'follow Up', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-25 18:29:17', '2025-04-25 18:29:17', NULL, NULL, NULL),
(98, 14, 'kalyan Chakravati', NULL, '9248048480', NULL, 'Trust Fintech limited', 'Tally To  GST Connet', '[\"16\"]', 'Follow Up', 'Marketing', 14, '14', 'Under Discussion', NULL, 0, 0, NULL, NULL, 0, '2025-04-28', '10:30:00', 0, '2025-04-25 18:56:46', '2025-04-25 19:18:22', NULL, NULL, NULL),
(99, 15, 'Tahir', 'tahirhanagodu@gmail.com', '9972371336', NULL, 'Mobile shop, electronic shop', 'electronic shop with furniture', '[\"6\"]', 'Follow Up', 'Facebook', 11, '15', NULL, 'dd', 0, 0, NULL, NULL, 0, '2025-04-26', '12:19:00', 0, '2025-04-26 12:22:13', '2025-05-14 11:56:11', 1, NULL, NULL),
(100, 15, 'Imtiyaz', NULL, '9741873794', NULL, 'Chicken shop', 'Billing', '[\"6\"]', 'Offline Demo', 'Just Dial', 8, '15', 'demo fixed Monday offline. customer sent the location', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-26 14:41:48', '2025-04-26 14:41:48', NULL, NULL, NULL),
(101, 14, 'Nikhil', 'nikhil_exton@yahoo.com', '9448386062', NULL, NULL, NULL, '[\"5\"]', 'Onsite Visit', 'Just Dial', 8, '14', 'today visit the customer place S P road. HE sent the location', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-28 12:35:08', '2025-04-28 12:35:08', NULL, NULL, NULL),
(102, 15, 'Mr Prabhakar', 'irudayan111@gmail.com', '8760870314', NULL, NULL, 'SCHOOL MANAGEMENT', '[\"6\"]', 'Quotation / Ready To Buy', 'Just Dial', 8, '15', 'INTRESTED , SEND QUOTATION', 'rt', 1, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-28 16:22:48', '2025-05-14 11:49:54', 1, '2025-05-14 11:49:54', NULL),
(103, 15, 'Arjun sagar', NULL, '7483986324', NULL, 'Restaurant', 'Billing', '[\"6\"]', 'Follow Up', 'Just Dial', 8, '15', NULL, NULL, 0, 0, NULL, NULL, 0, '2025-04-29', NULL, 0, '2025-04-28 16:26:00', '2025-04-28 16:26:00', NULL, NULL, NULL),
(104, 16, 'Ms Sushmitha', NULL, '7625026412', NULL, 'security gurd', 'Billing', '[\"4\"]', 'Onsite Visit', 'Just Dial', 8, '16', 'customer sent the location. she is already used a tally silver but she want another tally silver', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-28 16:30:58', '2025-04-28 16:30:58', NULL, NULL, NULL),
(105, 15, 'Thanushree', 'irudayan111@gmail.com', '8197820920', NULL, NULL, 'Records maintaining', '[\"1\",\"2\",\"3\"]', 'Online Demo', 'Just Dial', 8, '15', 'tomorrow fixed the DEMO time', NULL, 0, 0, '2025-04-30', '14:03:00', 1, NULL, NULL, 0, '2025-04-28 16:34:52', '2025-04-30 09:48:57', 1, '2025-04-30 09:48:57', NULL),
(106, 15, 'Rajesh Gold', 'Rajeshgold9@gmail.com', '9591234888', NULL, 'Jwellery Shop', 'ERP software', '[\"6\"]', 'Closed or Won', 'Facebook', 11, '15', 'Followup Demo', NULL, 0, 1, NULL, NULL, 0, NULL, NULL, 0, '2025-04-28 17:54:34', '2025-05-09 06:31:25', 1, NULL, NULL),
(107, 16, 'Mr Sathish', 'sati.co.28@gmail.com', '9980691143', 'Yallenka', 'Medical store', 'Billing', '[\"4\"]', 'Follow Up', 'Just Dial', 8, '16', 'tomorrow callback,  customer send the location and visit on onsite tomorrow', NULL, 0, 0, NULL, NULL, 0, '2025-04-30', '10:00:00', 0, '2025-04-29 10:00:02', '2025-04-29 10:00:02', 8, NULL, NULL),
(108, 15, 'SIddu', NULL, '9845972853', 'Marathahalli', 'SUPER MARKET', 'Billing', '[\"6\"]', 'Follow Up', 'Just Dial', 8, '15', 'callback today 2pm', NULL, 0, 0, NULL, NULL, 0, '2025-04-29', '14:00:00', 0, '2025-04-29 10:59:07', '2025-05-12 06:33:11', 8, NULL, NULL),
(109, 11, 'SANTOSH UNACHAGI', 'ugsant@gmail.com', '9845424208', NULL, NULL, NULL, '[\"21\"]', 'New', 'Facebook', 12, '11', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-04-29 11:28:29', '2025-05-09 07:04:06', 12, NULL, NULL),
(110, 11, 'raj', 'irudayan111@gmail.com', '8760870314', NULL, NULL, NULL, '[\"21\"]', 'Follow Up', 'Facebook', 12, '11', NULL, NULL, 0, 0, NULL, NULL, 0, '2025-05-02', '15:00:00', 0, '2025-04-29 11:29:10', '2025-05-02 09:03:23', 1, '2025-05-02 09:03:23', NULL),
(111, 16, 'T. Radhakrishna', NULL, '9600935184', 'Madhuri', 'Automobile', 'GST filling', '[\"4\"]', 'Follow Up', 'Just Dial', 8, '16', 'callback', NULL, 0, 0, NULL, NULL, 0, '2025-04-29', '13:00:00', 0, '2025-04-29 12:20:51', '2025-05-12 06:32:27', 8, NULL, NULL),
(112, 15, 'Mr Gopinath12', 'irudayan111@gmail.com', '9886419193', NULL, 'Trust Computer Solutions', 'Stock management and Billing', '[\"6\"]', 'Follow Up', 'Just Dial', 8, '15', 'customer wants to tomorrow demo at 11 am', NULL, 0, 0, NULL, NULL, 0, '2025-04-30', '18:50:00', 0, '2025-04-29 14:34:05', '2025-05-14 08:51:19', 1, '2025-05-14 08:51:19', NULL),
(113, 12, 'raj', 'superadmin@admin.com', '8069451003', '#16, 4th Main Rd, 2nd Block, Dwaraka Nagar, Nagarabhavi,', 'iSaral Business Solutions Pvt Ltd', 'test', '[\"2\"]', 'New', 'CA / auditor', 12, '12', 'test', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-08 10:47:33', '2025-05-08 10:59:36', 12, NULL, NULL),
(114, 1, 'test', 'irudayan111@gmail.com', '8760870314', '#16, GF, 4th Main Road, Dwarakanagar Nagarabhavi', 'iSaral Business Solutions Pvt Ltd', 'test', '[\"1\"]', 'New', 'Instagram', 1, '1', 'test', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-08 13:30:01', '2025-05-09 13:50:32', 1, NULL, NULL),
(115, 14, 'raj', 'irudayan111@gmail.com', '8760870314', '#16, 4th Main Rd, 2nd Block, Dwaraka Nagar, Nagarabhavi,', 'd', 'd', '[\"2\"]', 'New', 'Twitter', 1, '14', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-09 12:28:11', '2025-05-09 12:28:11', 1, NULL, NULL),
(116, 14, 'test', NULL, '8760870314', NULL, NULL, NULL, '[\"1\"]', 'New', 'CA / auditor', 1, '14', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-09 12:29:21', '2025-05-14 09:33:35', 1, NULL, NULL),
(117, 14, 'test', 'irudayan111@gmail.com', '8760870314', NULL, NULL, NULL, '[\"2\"]', 'New', 'CA / auditor', 1, '14', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-09 12:42:03', '2025-05-09 12:42:03', 1, NULL, NULL),
(118, 14, 'test', 'irudayan111@gmail.com', '8069451003', '#16, 4th Main Rd, 2nd Block, Dwaraka Nagar, Nagarabhavi,', NULL, NULL, '[\"2\"]', 'New', 'YouTube', 1, '14', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-09 13:50:07', '2025-05-09 13:50:07', 1, NULL, NULL),
(119, 1, 'dfgf', 'irudayan111@gmail.com', '8069451003', '#16, 4th Main Rd, 2nd Block, Dwaraka Nagar, Nagarabhavi,', 'iSaral Business Solutions Pvt Ltd', 'd', '[\"4\"]', 'New', 'Instagram', 1, '1', 'd', 'ADFDVFVSDXSXX', 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-13 13:18:43', '2025-05-14 11:16:28', 1, NULL, NULL),
(120, 9, 'John Doe2', 'john@example.com', '1234567890', '123 Street', 'IT', 'Enquiry', '[\"1\",\"3\",\"5\"]', 'New', 'Website', NULL, '9', 'Interested in demo', NULL, 0, 0, NULL, NULL, 0, '2025-05-14', '15:30:00', 0, '2025-05-13 13:55:14', '2025-05-14 08:50:53', 1, NULL, NULL),
(121, 14, 'SF', 'irudayan111@gmail.com', '8069451003', '#16, 4th Main Rd, 2nd Block, Dwaraka Nagar, Nagarabhavi,', 'D', 'D', '[\"2\"]', 'New', 'Twitter', 1, '14', 'D', 'D', 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-14 11:19:47', '2025-05-14 11:22:57', 1, '2025-05-14 11:22:57', NULL),
(122, 2, 'Johne', 'irudayan111@gmail.com', '8760870314', '123 Street', 'IT', 'Enquiry', '[1,3,5]', 'New', 'Website', NULL, '2', 'Interested in demo', NULL, 0, 0, NULL, NULL, 0, '2025-05-14', '15:30:00', 0, '2025-05-14 13:08:24', '2025-05-14 13:08:24', NULL, NULL, NULL),
(123, 1, 'sdcczczdc', 'superadmin@admin.com', '8760870314', '#16, GF, 4th Main Road, Dwarakanagar Nagarabhavi', 'iSaral Business Solutions Pvt Ltd', '1', '[\"1\"]', 'New', 'Website', NULL, '1', 'ddd', NULL, 0, 0, NULL, NULL, 0, '2025-05-14', '15:30:00', 0, '2025-05-14 13:34:35', '2025-05-14 13:34:35', NULL, NULL, NULL),
(124, NULL, 'rohith', 'admin@admin.com', '8760870314', '#16, 4th Main Rd, 2nd Block, Dwaraka Nagar, Nagarabhavi,', 'iSaral Business Solutions Pvt Ltd', NULL, '[\"1\"]', 'New', 'Patner', NULL, NULL, 'sewfrf', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-14 13:38:09', '2025-05-14 13:38:09', NULL, NULL, NULL),
(125, 1, 'ganesh', 'ganesh@isaral.in', '9042379218', 'Address', 'Company Name', NULL, '[\"1\"]', 'New', 'Dealers', NULL, '1', 'Remarks', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-15 12:50:25', '2025-05-15 12:50:25', NULL, NULL, NULL),
(126, 14, 'v', 'superadmin@admin.com', '8069451003', '#16, 4th Main Rd, 2nd Block, Dwaraka Nagar, Nagarabhavi,', NULL, 'fv', '[\"2\"]', 'New', 'CA / auditor', 1, '14', 'fv', NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-15 13:21:37', '2025-05-15 13:21:37', 1, NULL, NULL),
(127, 1, 'sdfghjyku', 'test@gmail.com', '09743189880', NULL, NULL, 'ertyuiop[', '[1]', 'New', 'Website', NULL, '1', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-16 07:24:36', '2025-05-16 07:24:36', NULL, NULL, NULL),
(128, 1, 'raj', 'raj@gmail.com', '8760870314', NULL, NULL, 'test', '[1]', 'New', 'Website', NULL, '1', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-16 08:40:29', '2025-05-16 08:40:29', NULL, NULL, NULL),
(129, 1, 'test', 'test@gmail.com', '8760870312', NULL, NULL, 'fcgfcgff', '[1]', 'New', 'Website', NULL, '1', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-16 10:52:31', '2025-05-16 10:52:31', NULL, NULL, NULL),
(130, 1, 'rohit', 'rohit@gmail.com', '09743189880', NULL, NULL, 'ed', '[1]', 'New', 'Website', NULL, '1', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-16 12:22:12', '2025-05-16 12:22:12', NULL, NULL, NULL),
(131, 1, 'rebel', 'rebel@gmail.com', '9606024299', NULL, NULL, 'erp', '[1]', 'New', 'Website', NULL, '1', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-16 12:28:51', '2025-05-16 12:28:51', NULL, NULL, NULL),
(132, 1, 'testtest', 'test@gmail.com', '09743189880', NULL, NULL, 'testtesttesttest', '[1]', 'New', 'Website', NULL, '1', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-17 06:08:55', '2025-05-17 06:08:55', NULL, NULL, NULL),
(133, 1, 'testtesttesttesttesttest', 'test@gmail.com', '08069451003', NULL, NULL, 'test', '[1]', 'New', 'Website', NULL, '1', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-17 06:10:44', '2025-05-17 06:10:44', NULL, NULL, NULL),
(134, 1, 'testtesttesttesttesttest', 'test@gmail.com', 'test@gmail.com', NULL, NULL, 'test', '[1]', 'New', 'Website', NULL, '1', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-17 06:10:57', '2025-05-17 06:10:57', NULL, NULL, NULL),
(135, 1, 'test', 'teste@gmail.com', '9743189880', NULL, NULL, 'ewrewrrr', '[1]', 'New', 'Website', NULL, '1', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, 0, '2025-05-17 07:10:10', '2025-05-17 07:10:10', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lead_product`
--

CREATE TABLE `lead_product` (
  `lead_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_product`
--

INSERT INTO `lead_product` (`lead_id`, `product_id`) VALUES
(1, 1),
(2, 2),
(4, 3),
(8, 2),
(9, 2),
(10, 4),
(14, 4),
(15, 6),
(18, 1),
(18, 3),
(18, 4),
(18, 5),
(21, 4),
(26, 6),
(27, 4),
(28, 4),
(29, 4),
(30, 4),
(31, 4),
(32, 4),
(33, 6),
(34, 14),
(35, 4),
(36, 4),
(37, 4),
(38, 4),
(39, 4),
(40, 1),
(41, 5),
(42, 6),
(43, 4),
(44, 6),
(45, 6),
(46, 4),
(48, 6),
(49, 6),
(50, 4),
(51, 4),
(52, 16),
(55, 4),
(56, 5),
(58, 17),
(59, 17),
(60, 6),
(61, 6),
(62, 6),
(63, 6),
(64, 18),
(65, 6),
(66, 6),
(67, 4),
(68, 6),
(69, 6),
(70, 4),
(71, 6),
(72, 6),
(73, 6),
(74, 6),
(75, 6),
(77, 19),
(78, 19),
(79, 16),
(80, 6),
(81, 20),
(82, 8),
(83, 4),
(84, 8),
(85, 4),
(86, 6),
(87, 9),
(88, 6),
(89, 5),
(90, 6),
(91, 4),
(94, 16),
(95, 6),
(96, 4),
(97, 4),
(98, 16),
(99, 6),
(100, 6),
(101, 5),
(102, 6),
(103, 6),
(104, 4),
(105, 1),
(105, 2),
(105, 3),
(106, 6),
(107, 4),
(108, 6),
(109, 21),
(110, 21),
(111, 4),
(112, 6),
(113, 2),
(114, 1),
(115, 2),
(116, 1),
(117, 2),
(118, 2),
(119, 4),
(120, 1),
(120, 3),
(120, 5),
(121, 2),
(122, 1),
(122, 3),
(122, 5),
(123, 1),
(124, 1),
(125, 1),
(126, 2),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1);

-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

CREATE TABLE `licenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `license_key` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `plan` enum('trial','1year','2years') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `licenses`
--

INSERT INTO `licenses` (`id`, `license_key`, `email`, `plan`, `start_date`, `end_date`, `is_active`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'X7WR-FZ5D-TC3G-NCAM', 'irudayan111@gmail.com', 'trial', '2025-05-05', '2025-05-15', 1, 'train', '2025-05-05 11:01:50', '2025-05-05 11:15:52', NULL),
(2, 'EIB8-LSS7-AIG4-OUOQ', 'rohi@isaral.in', '1year', '2025-05-05', '2026-05-05', 0, 'test', '2025-05-05 11:04:39', '2025-05-05 13:41:10', NULL),
(3, 'IUSB-QKN0-HBTC-MPMM', 'Rajeshgold9@gmail.com', 'trial', '2025-05-05', '2025-05-15', 1, 'rr', '2025-05-05 13:48:43', '2025-05-05 13:50:41', NULL);

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
(5, '2025_03_12_092930_create_sessions_table', 1),
(6, '2025_03_12_125610_create_contacts_table', 1),
(7, '2025_03_13_113532_create_leads_table', 1),
(8, '2025_03_22_050915_create_product_categories_table', 2),
(9, '2025_03_21_121836_create_lead_product_table', 3),
(10, '2025_05_02_162842_create_licenses_table', 4);

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
('Kapil@isaral.in', '$2y$10$fh.McLNPSvsRLC4xojjlO.PjHbxCPpvpXWu82tKXI/AT32EKOM7EG', '2025-04-24 14:14:11');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'user_management_access', NULL, NULL, NULL),
(2, 'permission_create', NULL, NULL, NULL),
(3, 'permission_edit', NULL, NULL, NULL),
(4, 'permission_show', NULL, NULL, NULL),
(5, 'permission_delete', NULL, NULL, NULL),
(6, 'permission_access', NULL, NULL, NULL),
(7, 'role_create', NULL, NULL, NULL),
(8, 'role_edit', NULL, NULL, NULL),
(9, 'role_show', NULL, NULL, NULL),
(10, 'role_delete', NULL, NULL, NULL),
(11, 'role_access', NULL, NULL, NULL),
(12, 'user_create', NULL, NULL, NULL),
(13, 'user_edit', NULL, NULL, NULL),
(14, 'user_show', NULL, NULL, NULL),
(15, 'user_delete', NULL, NULL, NULL),
(16, 'user_access', NULL, NULL, NULL),
(17, 'product_management_access', NULL, NULL, NULL),
(18, 'product_category_create', NULL, NULL, NULL),
(19, 'product_category_edit', NULL, NULL, NULL),
(20, 'product_category_show', NULL, NULL, NULL),
(21, 'product_category_delete', NULL, NULL, NULL),
(22, 'product_category_access', NULL, NULL, NULL),
(28, 'product_create', NULL, NULL, NULL),
(29, 'product_edit', NULL, NULL, NULL),
(30, 'product_show', NULL, NULL, NULL),
(31, 'product_delete', NULL, NULL, NULL),
(33, 'catalogue_management_access', NULL, '2025-03-26 11:03:32', NULL),
(38, 'quotation_management_access', NULL, '2025-03-26 11:06:36', NULL),
(39, 'quotation_create', NULL, '2025-03-26 11:17:49', NULL),
(40, 'quotation_edit', NULL, '2025-03-26 11:18:18', NULL),
(41, 'quotation_show', NULL, '2025-03-26 11:20:07', NULL),
(42, 'quotation_delete', NULL, '2025-03-26 11:20:18', NULL),
(43, 'appointment_management_access', NULL, '2025-03-26 11:05:00', NULL),
(44, 'appointment_create', NULL, '2025-03-26 11:21:11', NULL),
(45, 'appointment_edit', NULL, '2025-03-26 11:22:22', NULL),
(46, 'appointment_show', NULL, '2025-03-26 11:22:33', NULL),
(47, 'appointment_delete', NULL, '2025-03-26 11:22:47', NULL),
(48, 'lead_management_access', NULL, '2025-03-26 11:07:08', NULL),
(49, 'lead_create', NULL, '2025-03-26 11:23:14', NULL),
(50, 'lead_edit', NULL, '2025-03-26 11:23:25', NULL),
(51, 'lead_show', NULL, '2025-03-26 11:23:35', NULL),
(69, 'contact_create', NULL, NULL, NULL),
(70, 'contact_edit', NULL, NULL, NULL),
(71, 'contact_show', NULL, NULL, NULL),
(72, 'contact_delete', NULL, NULL, NULL),
(73, 'contact_management_access', NULL, '2025-03-26 11:01:52', NULL),
(97, 'dashboard_access', NULL, '2025-03-26 11:07:42', NULL),
(128, 'qualified_management_access', '2025-04-08 09:17:15', '2025-04-08 09:17:15', NULL),
(129, 'flowup_management_access', '2025-04-08 09:17:56', '2025-04-08 09:17:56', NULL),
(130, 'closedorwon_management_access', '2025-04-08 09:18:25', '2025-04-08 09:18:25', NULL),
(131, 'droppedorcancel_management_access', '2025-04-08 09:18:40', '2025-04-08 09:18:40', NULL),
(132, 'flowup_delete', '2025-04-08 12:38:34', '2025-04-08 12:38:34', NULL),
(133, 'lead_delete', '2025-04-08 12:39:51', '2025-04-08 12:39:51', NULL),
(134, 'qualified_delete', '2025-04-08 12:40:16', '2025-04-08 12:40:16', NULL),
(135, 'quotation_delete', '2025-04-08 12:40:57', '2025-04-08 12:40:57', NULL),
(136, 'appointment_delete', '2025-04-08 12:41:13', '2025-04-08 12:41:13', NULL),
(137, 'closedorwon_delete', '2025-04-08 12:41:27', '2025-04-08 12:41:27', NULL),
(138, 'droppedorcancel_delete', '2025-04-08 12:42:14', '2025-04-08 12:42:14', NULL),
(140, 'reports_management_access', '2025-04-15 18:13:36', '2025-04-15 18:13:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 33),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(1, 51),
(1, 69),
(1, 70),
(1, 71),
(1, 72),
(1, 73),
(1, 97),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(2, 33),
(2, 38),
(2, 39),
(2, 40),
(2, 41),
(2, 42),
(2, 43),
(2, 44),
(2, 45),
(2, 46),
(2, 47),
(2, 48),
(2, 49),
(2, 50),
(2, 51),
(2, 69),
(2, 70),
(2, 71),
(2, 72),
(2, 73),
(2, 97),
(5, 17),
(5, 18),
(5, 19),
(5, 20),
(5, 21),
(5, 22),
(5, 28),
(5, 29),
(5, 30),
(5, 31),
(5, 38),
(5, 39),
(5, 40),
(5, 41),
(5, 42),
(5, 43),
(5, 44),
(5, 45),
(5, 46),
(5, 47),
(5, 48),
(5, 49),
(5, 50),
(5, 51),
(5, 69),
(5, 70),
(5, 71),
(5, 72),
(5, 73),
(5, 97),
(1, 128),
(1, 129),
(1, 130),
(1, 131),
(2, 128),
(2, 129),
(2, 130),
(5, 128),
(5, 129),
(5, 130),
(1, 132),
(1, 133),
(1, 134),
(1, 135),
(1, 136),
(1, 137),
(1, 138),
(1, 140);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `tax` decimal(5,2) NOT NULL,
  `assigned_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category_id`, `price`, `tax`, `assigned_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Tally Software Services - Silver', 'Tally Software Services - Silver', 1, 4500.00, 18.00, 'raj', '2025-03-22 02:53:37', '2025-03-28 14:07:38', NULL),
(2, 'Tally Software Services - Silver 2 Years', 'Tally Software Services - Silver 2 Years', 1, 8100.00, 18.00, 'savari', '2025-03-22 03:30:01', '2025-03-28 14:08:03', NULL),
(3, 'Tally Software Services - Auditor', 'Tally Software Services - Auditor', 1, 6250.00, 18.00, NULL, '2025-03-22 05:10:16', '2025-03-28 14:08:36', NULL),
(4, 'TallyPrime Silver', NULL, 1, 22500.00, 18.00, NULL, '2025-03-28 13:47:40', '2025-03-28 13:47:40', NULL),
(5, 'TallyPrime Gold', NULL, 1, 67500.00, 18.00, NULL, '2025-03-28 13:48:07', '2025-03-28 13:48:07', NULL),
(6, 'Busy Basic - Single User', NULL, 2, 9999.00, 18.00, NULL, '2025-03-28 13:50:54', '2025-03-28 13:50:54', NULL),
(7, 'Busy Basic - Multi User', NULL, 2, 24999.00, 18.00, NULL, '2025-03-28 13:51:21', '2025-03-28 13:51:21', NULL),
(8, 'Busy Standard - Single User', NULL, 2, 14999.00, 18.00, NULL, '2025-03-28 13:51:44', '2025-03-28 13:51:44', NULL),
(9, 'Busy Standard - Multi User', NULL, 2, 39999.00, 18.00, NULL, '2025-03-28 13:52:05', '2025-03-28 13:52:05', NULL),
(10, 'Busy Enterprise - Single User', NULL, 2, 19999.00, 18.00, NULL, '2025-03-28 13:52:49', '2025-03-28 13:52:49', NULL),
(11, 'Busy Enterprise - Multi User', NULL, 2, 57999.00, 18.00, NULL, '2025-03-28 13:53:13', '2025-03-28 13:53:13', NULL),
(12, 'One Plus - Single User', 'India\'s First GST Ready Business ERP Software for Supermarkets, Mobile Shops / Computers / Electronics / FMCG Dealers, Retailers / Wholesalers / Manufacturers etc.', 3, 7500.00, 18.00, NULL, '2025-03-28 13:54:43', '2025-03-28 13:54:43', NULL),
(13, 'One Plus - Multi User', 'India\'s First GST Ready Business ERP Software for Supermarkets, Mobile Shops / Computers / Electronics / FMCG Dealers, Retailers / Wholesalers / Manufacturers etc.', 3, 12499.00, 18.00, NULL, '2025-03-28 13:55:28', '2025-03-28 13:55:28', NULL),
(14, 'My School - Single User', 'ERP Software for Schools & Colleges to handle Enquiry, Admission, Fee Management, Library, Attendance, Time Table, Certificates, ID Card, Reminder Letters, Demand Register.', 3, 12499.00, 18.00, NULL, '2025-03-28 13:57:21', '2025-03-28 13:57:21', NULL),
(15, 'My School - Multi User', 'ERP Software for Schools & Colleges to handle enquiries, Admission, Fee Management, Library, Attendance, timetables, Certificates, ID cards, Reminder Letters, and demand registers.', 3, 24999.00, 18.00, NULL, '2025-03-28 13:58:26', '2025-03-28 13:58:26', NULL),
(16, 'Tally Customizations', NULL, 1, 2500.00, 18.00, NULL, '2025-04-21 12:51:33', '2025-04-21 12:51:33', NULL),
(17, 'TallyPrime', 'TallyPrime to select gold or silver', 1, 90000.00, 36.00, NULL, '2025-04-23 12:27:03', '2025-04-23 12:27:31', NULL),
(18, 'Tally Clould', 'Access Tally anytime, anywhere with secure, fast, and reliable cloud hosting – no installations needed!', 1, 7800.00, 18.00, NULL, '2025-04-23 12:49:20', '2025-04-23 12:49:20', NULL),
(19, 'Products and Services', NULL, 2, 0.00, 0.00, NULL, '2025-04-23 13:03:36', '2025-04-23 13:03:36', NULL),
(20, 'Billing Softwares', NULL, 3, 0.00, 0.00, NULL, '2025-04-23 13:04:41', '2025-04-23 13:04:41', NULL),
(21, 'Business ERP software', NULL, 4, 9999.00, 18.00, NULL, '2025-04-28 17:50:01', '2025-04-28 17:50:01', NULL),
(22, 'Gold ERP software', NULL, 4, 4999.00, 18.00, NULL, '2025-04-28 17:50:51', '2025-04-28 17:50:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'tally', 'tally list', '2025-03-22 02:46:42', '2025-03-22 02:46:42', NULL),
(2, 'Enquiry', 'Products', '2025-04-23 13:02:27', '2025-04-23 13:02:27', NULL),
(3, 'Billing Softwares', 'Billing Softwares products', '2025-04-23 13:02:54', '2025-04-23 13:02:54', NULL),
(4, 'ERP', NULL, '2025-04-28 17:48:26', '2025-04-28 17:48:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SuperAdmin', NULL, NULL, NULL),
(2, 'Admin', NULL, NULL, NULL),
(5, 'User', '2025-03-26 11:38:25', '2025-03-26 11:38:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(5, 5),
(4, 5),
(6, 5),
(7, 5),
(8, 5),
(9, 5),
(10, 5),
(11, 5),
(12, 5),
(13, 5),
(14, 5),
(15, 5),
(16, 5),
(17, 5),
(18, 2),
(18, 5),
(19, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `approved` tinyint(1) DEFAULT 0,
  `verified` tinyint(1) DEFAULT 0,
  `verified_at` datetime DEFAULT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `profile_image`, `email_verified_at`, `approved`, `verified`, `verified_at`, `verification_token`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin', 'superadmin@admin.com', NULL, NULL, 1, 1, '2024-04-02 07:27:41', '', '$2y$10$iD2Z2mGtvQofQsaTq1j93elVjHRkWvGTMAn50BOsVjL1sgTyQOVny', 'UHPbnEh9MAXtJ4DM0rROGdAwVJWBEmynF61IPgC2aoPy0V1arWIqBjT9UM0K', NULL, '2025-04-08 19:24:36', NULL),
(2, 'Admin', 'admin@admin.com', NULL, NULL, 1, 1, '2024-04-02 07:27:41', '', '$2y$10$RN51r7/CpPFCaS/ZNKvWNO.i16Vn21kZFIvivsBvbvM7cQhSyno1S', NULL, NULL, NULL, NULL),
(4, 'Savari Irudaya Raj X', 'irudayan@isaral.in', NULL, NULL, 1, 1, NULL, NULL, '$2y$10$LMTguHSPFCiwW5tzTvbvBee6Nn5ofKa7mTaqbSiQGHEZmS48p3Mx6', NULL, '2025-03-26 10:18:05', '2025-04-10 15:23:51', NULL),
(8, 'Divya S. S', 'sales@isaral.in', NULL, NULL, 1, 1, '2025-04-10 15:07:49', NULL, '$2y$10$XWAiT7ZIZugoGRfPHuZLX.bBYigssTFQ/aByu9R6dL9/jofEVJn5.', 'ySvAJiYSnPaYqOmwwPUE5s9fxaUv0y8CkqczhZWGdeS54R6Lp0q82iYTQTAh', '2025-04-10 15:07:49', '2025-04-10 15:07:49', NULL),
(9, 'Mamatha', 'mamatha@isaral.in', NULL, NULL, 1, 1, '2025-04-10 15:09:42', NULL, '$2y$10$/9Ej5DsfNYul2rgKM6E1hOrLFeC/D3593kwOReQ1end8mBx14gime', NULL, '2025-04-10 15:09:42', '2025-04-10 15:09:42', NULL),
(10, 'Nayana G S', 'nayana@isaral.in', NULL, NULL, 1, 1, '2025-04-10 15:10:29', NULL, '$2y$10$SiRGWFKSsmVaX2/glnIFt.6hXXuYK5cxtq8aoY6jsjLaqasFT2RV2', NULL, '2025-04-10 15:10:29', '2025-04-10 15:10:29', NULL),
(11, 'Ankitha  S', 'customercare@isaral.in', NULL, NULL, 1, 1, '2025-04-10 15:11:22', NULL, '$2y$10$sj27glEGaCMb9BevUnddduuAnVZ5W32aNcZYtJPJEHHZLyIsd3o9m', 'bgJtb6alY5C3gJ3E1D5KJlvJzwwLJzTTp6QeHMcC9AY4vlVwFfOkRteQHDy0', '2025-04-10 15:11:22', '2025-04-23 11:59:32', NULL),
(12, 'Rohith', 'rohith@isaral.in', 'profile_images/hjdB0VzWhvbC6y3euceT.png', NULL, 1, 1, '2025-04-10 15:12:12', NULL, '$2y$10$B.p/IFGfVZcrguVkRDeGy.qESF0j2i3vzaKlFj6yN.GbpMjtfJEqq', 'o8cLjoxWHc24S6Ub7XHHHqN9J7np0oFdBBnpmYlguVfj8iKIXlKjD7MRJa9V', '2025-04-10 15:12:12', '2025-04-11 14:49:58', NULL),
(13, 'Pavithra M', 'info@isaral.in', NULL, NULL, 1, 1, '2025-04-10 15:21:08', NULL, '$2y$10$6WRPmCpyYYpfU4OwH1oUAeiS0XtUUcYKbtjRT7G7lDLJIZ/YhLAD2', 'VVGPF3v8vMFrapz0qjtrEpm2bXnK1PMUQSTe9zZHXyfh1GYuQuPjd0FUGHrO', '2025-04-10 15:21:08', '2025-04-10 15:21:08', NULL),
(14, 'Rupesh Kumar N', 'rupesh@isaral.in', 'profile_images/fndwYDXcoKkFvkGzM00m.jpg', NULL, 1, 1, '2025-04-10 15:38:50', NULL, '$2y$10$vni2EuHTcBHj2l6QDn1jmuzHQDz3c95DcqG.lDMEHJsEtTW2ByQUa', 'V2UvKPs8PGdVZhqGwJMJRUfz8mLpy1QIci8WEuD9HTUaIYlR38pnJoooeQ0h', '2025-04-10 15:38:50', '2025-04-12 16:09:48', NULL),
(15, 'Ganesh M', 'ganesh@isaral.in', 'profile_images/p4s7lPD2Mow8xP1hImxI.jpg', NULL, 1, 1, '2025-04-10 15:39:27', NULL, '$2y$10$hhNJ.6mQG2nKYjZGbtqolO1t4A1QFLEGGQypJ..Ghpc7v2yTp5zfW', 'FofUInpKjvJ3B5hrzAe3wV6379j2sP6WCHTmGwahXbV9P32lC66OVUKk8tXv', '2025-04-10 15:39:27', '2025-04-26 11:40:43', NULL),
(16, 'Kapil Yadav', 'Kapil@isaral.in', NULL, NULL, 1, 1, '2025-04-10 15:39:55', NULL, '$2y$10$ZkBXvE9Vpcpd6pRmSitwLeZE68X5ytDFuH7IrPUZFt/on.FKgKSLa', NULL, '2025-04-10 15:39:55', '2025-04-10 15:39:55', NULL),
(18, 'Rajesha H B', 'rajesh@isaral.in', 'profile_images/CiP9kqFb4sNNv5ZB1YDV.png', NULL, 1, 1, '2025-04-22 19:42:44', NULL, '$2y$10$oZsq3gEWsICf0.4OhqLKMue4UmvV25PYJkct0d2Ac/dRuARQd5jmS', NULL, '2025-04-22 19:42:44', '2025-04-22 19:45:32', NULL),
(19, 'swetha', 'swetha@isaral.in', NULL, NULL, 1, 1, '2025-05-10 16:03:08', NULL, '$2y$10$Ygx8Uxncy8u22ZWwGrK.ZO1Ya9USO3dWntKVBCh59Xirk62GLdApy', NULL, '2025-05-10 10:33:08', '2025-05-10 10:33:08', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_product`
--
ALTER TABLE `lead_product`
  ADD PRIMARY KEY (`lead_id`,`product_id`),
  ADD KEY `lead_product_product_id_foreign` (`product_id`);

--
-- Indexes for table `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `licenses_license_key_unique` (`license_key`);

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
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD KEY `role_id_fk_9655172` (`role_id`),
  ADD KEY `permission_id_fk_9655172` (`permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD KEY `user_id_fk_9655181` (`user_id`),
  ADD KEY `role_id_fk_9655181` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `licenses`
--
ALTER TABLE `licenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lead_product`
--
ALTER TABLE `lead_product`
  ADD CONSTRAINT `lead_product_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lead_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_id_fk_9655172` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_id_fk_9655172` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
