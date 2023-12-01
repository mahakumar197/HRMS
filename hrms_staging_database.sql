-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 15, 2023 at 11:41 AM
-- Server version: 5.7.23-23
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `temple8_hrmasdf`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `primary_project` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `secondary_project` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `attendance_date` date NOT NULL,
  `total_working_hours` int(11) DEFAULT NULL,
  `day_count` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `work_from` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'OD'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `user_id`, `primary_project`, `secondary_project`, `attendance_date`, `total_working_hours`, `day_count`, `created_at`, `updated_at`, `work_from`) VALUES
(1, 27, '[{\"name\":\"Sword\",\"hours\":\"8\"}]', '{\"1\":{\"project\":null,\"hours\":\"0\"}}', '2023-08-01', 8, 1.00, '2023-08-01 05:11:50', '2023-08-01 05:11:50', 'OD'),
(2, 198, '[{\"name\":\"Sword\",\"hours\":\"8\"}]', '{\"1\":{\"project\":null,\"hours\":\"0\"}}', '2023-08-03', 8, 1.00, '2023-08-03 08:37:38', '2023-08-03 08:37:38', 'OD'),
(3, 208, '[{\"name\":\"Sword\",\"hours\":\"8\"}]', '{\"1\":{\"project\":null,\"hours\":\"0\"}}', '2023-08-09', 8, 1.00, '2023-08-09 06:21:18', '2023-08-09 06:21:18', 'OD'),
(4, 209, '[{\"name\":\"Sword\",\"hours\":\"8\"}]', '{\"1\":{\"project\":null,\"hours\":\"0\"}}', '2023-08-11', 8, 1.00, '2023-08-11 07:46:57', '2023-08-11 07:46:57', 'OD'),
(5, 27, '[{\"name\":\"Sword\",\"hours\":\"8\"}]', '{\"1\":{\"project\":null,\"hours\":\"0\"}}', '2023-08-24', 8, 1.00, '2023-08-24 15:15:14', '2023-08-24 15:15:14', 'OD'),
(6, 27, '[{\"name\":\"Sword\",\"hours\":\"8\"}]', '{\"1\":{\"project\":null,\"hours\":\"0\"}}', '2023-09-13', 8, 1.00, '2023-09-13 11:29:00', '2023-09-13 11:29:00', 'P'),
(7, 27, '[{\"name\":\"Sword\",\"hours\":\"8\"}]', '{\"1\":{\"project\":null,\"hours\":\"0\"}}', '2023-09-14', 8, 1.00, '2023-09-14 06:05:08', '2023-09-14 06:05:08', 'P'),
(8, 27, '[{\"name\":\"Sword\",\"hours\":\"8\"}]', '{\"1\":{\"project\":null,\"hours\":\"0\"}}', '2023-10-24', 8, 1.00, '2023-10-24 11:15:37', '2023-10-24 11:15:37', 'OD'),
(9, 210, '[{\"name\":\"Sword\",\"hours\":\"8\"}]', '{\"1\":{\"project\":null,\"hours\":\"0\"}}', '2023-10-24', 8, 1.00, '2023-10-24 12:41:25', '2023-10-24 12:41:25', 'OD'),
(10, 118, '[{\"name\":\"Sword\",\"hours\":\"8\"}]', '{\"1\":{\"project\":null,\"hours\":\"0\"}}', '2023-10-26', 8, 1.00, '2023-10-26 05:55:07', '2023-10-26 05:55:07', 'OD');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `phone_number` varchar(10) NOT NULL,
  `alternate_phone_number` varchar(10) DEFAULT NULL,
  `candidate_location` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `total_experience` varchar(100) DEFAULT NULL,
  `relevant_experience` varchar(100) DEFAULT NULL,
  `current_position` varchar(200) DEFAULT NULL,
  `current_company` varchar(200) DEFAULT NULL,
  `notice_period` varchar(200) DEFAULT NULL,
  `current_ctc` varchar(200) DEFAULT NULL,
  `expected_ctc` varchar(200) DEFAULT NULL,
  `negotiation_salary` varchar(200) DEFAULT NULL,
  `skills` varchar(255) DEFAULT NULL,
  `language_known` varchar(255) DEFAULT NULL,
  `graduation_degree` varchar(255) DEFAULT NULL,
  `graduation_university` varchar(255) DEFAULT NULL,
  `marital_status` varchar(100) NOT NULL,
  `client_interaction_location` varchar(250) DEFAULT NULL,
  `individual_contributor` varchar(250) DEFAULT NULL,
  `hybrid_model` varchar(100) DEFAULT NULL,
  `outsourced_via` varchar(100) DEFAULT NULL,
  `candidate_created_date` date DEFAULT NULL,
  `recruiter_name` bigint(20) UNSIGNED DEFAULT NULL,
  `resume_upload` varchar(400) NOT NULL,
  `referred_by` varchar(100) DEFAULT NULL,
  `consultancy_id` bigint(20) UNSIGNED DEFAULT NULL,
  `emp_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `job_id`, `name`, `email`, `dob`, `gender`, `phone_number`, `alternate_phone_number`, `candidate_location`, `address`, `nationality`, `total_experience`, `relevant_experience`, `current_position`, `current_company`, `notice_period`, `current_ctc`, `expected_ctc`, `negotiation_salary`, `skills`, `language_known`, `graduation_degree`, `graduation_university`, `marital_status`, `client_interaction_location`, `individual_contributor`, `hybrid_model`, `outsourced_via`, `candidate_created_date`, `recruiter_name`, `resume_upload`, `referred_by`, `consultancy_id`, `emp_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Naresh', 'naresh@gmail.com', '1990-08-21', 'Male', '8988998800', NULL, 'Chennai', 'Chennai', 'Indian', '5', NULL, 'Analyst', 'CTS', '2 Months', '15LPA', '25LPA', '25LPA', 'JAVA', 'English, Tamil', 'BE', 'Anna University', '0', NULL, NULL, NULL, 'Naukri', '2023-07-31', 118, '1690800466.pdf', 's1', NULL, 207, '2023-07-31 10:47:46', '2023-08-08 05:46:56'),
(2, 1, 'Divya', 'divya@gmail.com', '2004-04-05', 'Female', '7788990089', '7788990089', 'Chennai', 'Chennai', 'Indian', '5', NULL, 'Analyst', 'CTS', '2 Months', '10LPA', '20LPA', '20LPA', 'JAVA', 'English', 'BE', 'Anna University', '0', NULL, NULL, NULL, 'Naukri', '2023-07-31', 118, '1690800924.pdf', 's1', NULL, 196, '2023-07-31 10:55:24', '2023-08-02 11:25:08'),
(3, 1, 'Jessy', 'jessy@gmail.com', '2004-05-19', 'Female', '9900890789', '9900890789', 'Chennai', 'Chennai', 'Indian', '5', NULL, 'Analyst', 'CTS', '2 Months', '20LPA', '25LPA', '25LPA', 'JAVA', 'English', 'BE', 'Anna University', '0', NULL, NULL, NULL, 'Naukri', '2023-07-31', 118, '1690801106.pdf', 's1', NULL, 197, '2023-07-31 10:58:26', '2023-08-03 08:09:09'),
(4, 1, 'Ram', 'ram@gmail.com', '1993-08-18', 'Male', '6789890000', '6789890000', 'Chennai', 'Chennai', 'Indian', '5', NULL, 'Analyst', 'CTS', '2 Months', '15LPA', '20LPA', '20LPA', 'JAVA', 'English', 'BE', 'Anna', '0', NULL, NULL, NULL, 'Naukri', '2023-08-03', 118, '1691051101.pdf', 's1', NULL, 198, '2023-08-03 08:25:01', '2023-08-03 08:32:33'),
(5, 1, 'Dona', 'dona@gmail.com', '1995-05-10', 'Female', '8899001234', NULL, 'Kerala', 'Kerala', 'Indian', '5', NULL, 'Analyst', 'CTS', '2 Months', '10LPA', '15LPA', '15LPA', 'React', 'English', 'BE', 'Amirtha', '0', NULL, NULL, NULL, 'Naukri', '2023-08-04', 118, '1691141962.pdf', 's1', NULL, 204, '2023-08-04 09:39:22', '2023-08-04 09:59:10'),
(6, 1, 'Ruben', 'ruben@gmail.com', '1997-02-05', 'Male', '5678906677', NULL, 'Kerala', 'Kerala', 'Indian', '10', NULL, 'Analyst', 'TCS', '3 Months', '20LPA', '25LPA', '25LPA', 'JAVA', 'English', 'BE', 'Anna', '0', NULL, NULL, NULL, 'Naukri', '2023-08-04', 118, '1691155365.pdf', 's1', NULL, NULL, '2023-08-04 13:22:45', '2023-08-04 13:22:45'),
(7, 1, 'Nivetha', 'nivetha@gmail.com', '1990-05-16', 'Female', '9900789090', NULL, 'Chennai', 'Chennai', 'Indian', '5+', NULL, 'Analyst', 'TCS', '2 Months', '20LPA', '25LPA', '25LPA', 'JAVA', 'English', 'BE', 'Anna', '0', NULL, NULL, NULL, 'Naukri', '2023-08-07', 118, '1691425872.pdf', 's1', NULL, 206, '2023-08-07 16:31:12', '2023-08-07 17:05:59'),
(8, 1, 'Kevin', 'kevin@gmail.com', '1999-05-12', 'Male', '5678990987', NULL, 'Chennai', 'Chennai', 'Indian', '7', NULL, 'Tester', 'Infosys', '3', '15', '20', '20', 'Dotnet', 'Englis', 'BE', 'Anna', '0', NULL, NULL, NULL, 'Naukri', '2023-08-08', 118, '1691478104.pdf', 's1', NULL, 208, '2023-08-08 07:01:44', '2023-08-09 06:14:56'),
(9, 1, 'Ganesh', 'ganesh@gmail.com', '1997-02-05', 'Male', '6788990000', NULL, 'Chennai', 'Chennai', 'Indian', '5', NULL, 'Analyst', 'CTS', '2 Months', '10LPA', '15LPA', '15LPA', 'JAVA', 'English', 'BE', 'Anna university', '0', NULL, NULL, NULL, 'Naukri', '2023-08-11', 118, '1691739162.pdf', 's1', NULL, 209, '2023-08-11 07:32:42', '2023-08-11 07:40:10'),
(10, 1, 'Shiny', 'shiny@gmail.com', '1989-05-17', 'Female', '8787878787', NULL, 'Kerala', 'Kerala', 'Indian', '5', '12+', 'Analyst', 'CTS', '2 Months', '20', '25', '25', 'English', 'English', 'BE', 'Anna University', 'Single', 'Yes', 'Yes', 'Yes', 'Naukri', '2023-09-13', 118, '1694169888.pdf', 's1', NULL, NULL, '2023-09-08 10:44:48', '2023-09-13 05:27:18'),
(11, 1, 'Dhanya', 'dhanya@gmail.com', '1991-05-08', 'Female', '8890765434', NULL, 'Chennai', 'Chennai', 'Indian', '5', '5', 'Analyst', 'CTS', '3', '15', '20', '20', 'JAVA', 'English', 'BE', 'Anna', 'Single', 'Yes', 'Yes', 'Yes', 'Employee Referral', '2023-10-25', 118, '1698226332.pdf', 's1', NULL, NULL, '2023-10-25 09:32:12', '2023-10-25 09:32:12'),
(12, 2, 'Sam', 's@sam.com', '1971-08-25', 'Male', '7589421365', '7895462158', 'chennai', 'chaledarasdd', 'Indian', '12', '12', 'sadawer', 'asdasd', '2', '123', '123', '123', 'asdasd', 'sdasds', 'qwe', 'qwe', 'Married', 'asd', 'asd', 'Yes', 'Naukri', '2023-10-26', 118, '1698299816.pdf', 's3', NULL, 211, '2023-10-26 05:56:56', '2023-10-26 07:02:19');

-- --------------------------------------------------------

--
-- Table structure for table `common_feedback`
--

CREATE TABLE `common_feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `interviewer` bigint(20) UNSIGNED DEFAULT NULL,
  `can_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `round` varchar(100) NOT NULL,
  `comment` longtext NOT NULL,
  `can_image` varchar(200) DEFAULT NULL,
  `schedule_id` bigint(20) UNSIGNED NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `common_feedback`
--

INSERT INTO `common_feedback` (`id`, `interviewer`, `can_id`, `job_id`, `round`, `comment`, `can_image`, `schedule_id`, `updated_at`, `created_at`) VALUES
(1, NULL, 1, 1, 'round_3', 'Selected', NULL, 536, '2023-08-01 06:38:29', '2023-08-01 06:38:29'),
(2, NULL, 2, 1, 'round_3', 'selected', NULL, 539, '2023-08-02 11:14:39', '2023-08-02 11:14:39'),
(3, NULL, 3, 1, 'round_3', 'selected', NULL, 542, '2023-08-03 08:01:29', '2023-08-03 08:01:29'),
(4, NULL, 4, 1, 'round_3', 'selected', NULL, 545, '2023-08-03 08:28:23', '2023-08-03 08:28:23'),
(5, NULL, 5, 1, 'round_3', 'selected', NULL, 548, '2023-08-04 09:46:52', '2023-08-04 09:46:52'),
(6, NULL, 7, 1, 'round_3', 'selected', NULL, 553, '2023-08-07 16:42:10', '2023-08-07 16:42:10'),
(7, NULL, 8, 1, 'round_3', 'selected', NULL, 556, '2023-08-09 06:10:33', '2023-08-09 06:10:33'),
(8, NULL, 9, 1, 'round_3', 'Selected', NULL, 559, '2023-08-11 07:36:07', '2023-08-11 07:36:07'),
(9, NULL, 12, 2, 'round_3', 'test', NULL, 562, '2023-10-26 06:49:30', '2023-10-26 06:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `consultancy`
--

CREATE TABLE `consultancy` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consultancy_name` varchar(200) NOT NULL,
  `contact_person` varchar(200) NOT NULL,
  `contact_number` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alternate_email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `password_change_at` timestamp NULL DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `consultancy`
--

INSERT INTO `consultancy` (`id`, `consultancy_name`, `contact_person`, `contact_number`, `email`, `alternate_email`, `password`, `email_verified_at`, `remember_token`, `password_change_at`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Jain Consultancy', 'Jeeva', '9900890989', 'judipreethi.johnpeter@swordgroup.in', NULL, '$2y$10$ZTLKWcVwwscOnNYlDTeCU.jvgsOvQTbO7GA3zKKj/w1PmJ/sr7IEq', NULL, NULL, NULL, '2023-10-25', NULL, 1, '2023-10-25 09:34:42', '2023-10-25 09:34:42');

-- --------------------------------------------------------

--
-- Table structure for table `consultancy_jobs`
--

CREATE TABLE `consultancy_jobs` (
  `consultancy_id` bigint(20) UNSIGNED NOT NULL,
  `jobs_id` bigint(20) UNSIGNED NOT NULL,
  `ack` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `id` int(10) UNSIGNED NOT NULL,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `designation`, `created_at`, `updated_at`) VALUES
(1, 'Architect', '2022-03-13 15:59:27', '2022-03-17 15:48:31'),
(2, 'Sr.Analyst', '2022-03-13 16:15:23', '2022-03-13 16:15:23'),
(3, 'Technical Manager', '2022-03-13 16:18:26', '2022-03-13 16:18:26'),
(4, 'Associate Project Mgr', '2022-03-14 02:41:27', '2022-03-14 02:41:27'),
(5, 'Test Analyst', '2022-03-14 02:42:27', '2022-03-14 02:42:27'),
(6, 'Test Lead', '2022-03-17 00:05:43', '2022-03-17 00:05:43'),
(7, 'Senior Test Analyst', '2022-03-19 05:57:14', '2022-03-19 05:57:14'),
(8, 'Test Manager', '2022-03-20 05:57:14', '2022-03-20 05:57:14'),
(9, 'Project Mgr', '2022-03-21 05:57:14', '2022-03-21 05:57:14'),
(10, 'Project Lead', '2022-03-22 05:57:14', '2022-03-22 05:57:14'),
(11, 'Technical Director', '2022-03-23 05:57:14', '2022-03-23 05:57:14'),
(12, 'Senior Test Engineer', '2022-03-24 05:57:14', '2022-03-24 05:57:14'),
(13, 'Senior Project Manager', '2022-03-25 05:57:14', '2022-03-25 05:57:14'),
(14, 'Analyst Prgrmr', '2022-03-26 05:57:14', '2022-03-26 05:57:14'),
(15, 'Technical Architect - Mobile Applications', '2022-03-27 05:57:14', '2022-03-27 05:57:14'),
(16, 'Technical Lead', '2022-03-28 05:57:14', '2022-03-28 05:57:14'),
(17, 'Sr.Analyst Prgrmr', '2022-03-29 05:57:14', '2022-03-29 05:57:14'),
(18, 'Programmer', '2022-03-30 05:57:14', '2022-03-30 05:57:14'),
(19, 'Senior Tester', '2022-03-31 05:57:14', '2022-03-31 05:57:14'),
(20, 'Sr.Anlayst Prgrmr', '2022-04-01 05:57:14', '2022-04-01 05:57:14'),
(21, 'Senior Technical Lead', '2022-04-02 05:57:14', '2022-04-02 05:57:14'),
(22, 'Sr. Tech.Delivery Manager', '2022-04-03 05:57:14', '2022-04-03 05:57:14'),
(23, 'Analyst', '2022-04-04 05:57:14', '2022-04-04 05:57:14'),
(24, 'Devops Technical Lead', '2022-04-05 05:57:14', '2022-04-05 05:57:14'),
(25, 'Senior Devops Engineer', '2022-04-06 05:57:14', '2022-04-06 05:57:14'),
(26, 'Senior Support Specialist', '2022-04-07 05:57:14', '2022-04-07 05:57:14'),
(27, 'Analyst - Production Support', '2022-04-08 05:57:14', '2022-04-08 05:57:14'),
(28, 'Senior Analyst- DBA', '2022-04-09 05:57:14', '2022-04-09 05:57:14'),
(29, 'Manager - HR', '2022-04-10 05:57:14', '2022-04-10 05:57:14'),
(30, 'Senior Manager - Admin', '2022-04-11 05:57:14', '2022-04-11 05:57:14'),
(31, 'CFO', '2022-04-12 05:57:14', '2022-04-12 05:57:14'),
(32, 'Asst. Manager - Admin-Finance', '2022-04-13 05:57:14', '2022-04-13 05:57:14'),
(33, 'Asst. Manager - HR', '2022-04-14 05:57:14', '2022-04-14 05:57:14'),
(34, 'Asst. Manager - System Admin', '2022-04-15 05:57:14', '2022-04-15 05:57:14'),
(35, 'Test Engineer', '2022-06-13 13:14:33', '2022-06-13 13:14:33'),
(36, 'Programmer Analyst', '2023-01-31 06:09:22', '2023-01-31 06:09:22'),
(37, 'Tester', '2023-05-03 21:59:55', '2023-05-03 21:59:55'),
(38, 'Senior Analyst Programmer IT Vendor Management', '2023-10-25 07:39:19', '2023-10-25 07:40:50');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `feedback_date` date NOT NULL,
  `hereismy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regarding` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(3000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `feedback_image` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidaymodels`
--

CREATE TABLE `holidaymodels` (
  `id` int(10) UNSIGNED NOT NULL,
  `holidayname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holidaydate` date NOT NULL,
  `holidaytype` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holidayscope` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holidaystatus` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fullDay` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holidaymodels`
--

INSERT INTO `holidaymodels` (`id`, `holidayname`, `holidaydate`, `holidaytype`, `holidayscope`, `holidaystatus`, `created_at`, `updated_at`, `fullDay`) VALUES
(1, 'Pongal', '2022-01-14', 'External', 'Bank Holiday', 1, '2016-03-22 02:26:00', '2022-12-22 19:12:32', 1),
(2, 'Republic Day', '2023-01-26', 'External', 'Bank Holiday', 1, '2016-03-22 02:29:00', '2023-02-17 23:53:26', 1),
(3, 'Tamil New Year Day', '2022-04-14', 'External', 'Bank Holiday', 1, '2016-03-22 02:30:00', '2016-03-22 02:30:00', 1),
(4, 'Good Friday', '2022-04-15', 'External', 'Bank Holiday', 1, '2016-03-22 04:09:00', '2016-03-22 04:10:00', 1),
(5, 'Ramzan', '2022-05-03', 'External', 'Bank Holiday', 1, '2017-03-22 00:03:00', '2017-03-22 00:04:00', 1),
(6, 'Independence Day', '2022-08-15', 'External', 'Bank Holiday', 1, '2017-03-22 15:56:00', '2017-03-22 15:56:00', 1),
(7, 'Krishna Jayanthi', '2022-08-19', 'External', 'Bank Holiday', 1, '2029-03-21 19:06:00', '2029-03-21 19:06:00', 1),
(8, 'Vinayakar Chathurthi', '2022-08-31', 'External', 'Bank Holiday', 1, '2005-04-22 11:52:00', '2005-04-22 11:52:00', 1),
(9, 'Ayudha Pooja', '2022-10-04', 'External', 'Bank Holiday', 1, '2005-04-22 13:01:00', '2005-04-22 13:01:00', 1),
(10, 'Deepavali', '2022-10-24', 'External', 'Bank Holiday', 1, '2030-04-21 21:39:00', '2030-04-21 21:39:00', 1),
(12, 'Republic Day', '2022-01-26', 'External', 'Bank Holiday', 1, '2022-11-18 19:17:46', '2022-12-22 19:14:26', 1),
(13, 'Good Friday', '2023-04-07', 'External', 'Bank Holiday', 1, '2022-11-18 19:19:40', '2022-11-18 19:19:40', 1),
(14, 'Tamil New Year Day', '2023-04-14', 'External', 'Bank Holiday', 1, '2022-11-18 19:20:17', '2022-11-18 19:20:17', 1),
(15, 'May Day', '2023-05-01', 'External', 'Bank Holiday', 1, '2022-11-18 19:20:58', '2022-11-18 19:20:58', 1),
(16, 'Bakrid', '2023-06-29', 'External', 'Bank Holiday', 1, '2022-11-18 19:21:37', '2022-11-18 19:21:37', 1),
(17, 'Independence Day', '2023-08-15', 'External', 'Bank Holiday', 1, '2022-11-18 19:22:22', '2022-11-18 19:22:22', 1),
(18, 'Krishna Jayanthi', '2023-09-06', 'External', 'Bank Holiday', 1, '2022-11-18 19:22:50', '2022-11-18 19:22:50', 1),
(19, 'Gandhi Jayanthi', '2023-10-02', 'External', 'Bank Holiday', 1, '2022-11-18 19:23:47', '2022-11-18 19:23:47', 1),
(20, 'Ayudha Pooja', '2023-10-23', 'External', 'Bank Holiday', 1, '2022-11-18 19:24:32', '2022-11-18 19:24:32', 1),
(21, 'Christmas', '2023-12-25', 'External', 'Bank Holiday', 1, '2022-11-18 19:24:59', '2022-11-18 19:24:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hr_questionnaire`
--

CREATE TABLE `hr_questionnaire` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `can_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `comments` longtext NOT NULL,
  `looking_out_change_in_job` varchar(10) DEFAULT NULL,
  `tot_exp` varchar(50) DEFAULT NULL,
  `relevant_exp` varchar(50) DEFAULT NULL,
  `current_ctc` varchar(100) DEFAULT NULL,
  `expected_ctc` varchar(100) DEFAULT NULL,
  `why_look_for_job_change` varchar(200) DEFAULT NULL,
  `other_offer_in_pipeline` varchar(10) DEFAULT NULL,
  `native_place` varchar(50) DEFAULT NULL,
  `medical_issues` varchar(200) DEFAULT NULL,
  `marital_status` varchar(50) DEFAULT NULL,
  `family_background` varchar(300) DEFAULT NULL,
  `strengths_weaknesses` varchar(300) DEFAULT NULL,
  `team_player` varchar(100) DEFAULT NULL,
  `interacted_clients` varchar(100) DEFAULT NULL,
  `clients_geography` varchar(200) DEFAULT NULL,
  `extended_working` varchar(100) DEFAULT NULL,
  `additional_skills` varchar(100) DEFAULT NULL,
  `methodology` varchar(100) DEFAULT NULL,
  `absenteeism` varchar(100) DEFAULT NULL,
  `work_pressure` varchar(300) DEFAULT NULL,
  `deal_criticism` varchar(100) DEFAULT NULL,
  `certifications` varchar(100) DEFAULT NULL,
  `hybrid_report` varchar(20) DEFAULT NULL,
  `jumped_job` varchar(100) DEFAULT NULL,
  `notice_peroid` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hr_questionnaire`
--

INSERT INTO `hr_questionnaire` (`id`, `can_id`, `job_id`, `comments`, `looking_out_change_in_job`, `tot_exp`, `relevant_exp`, `current_ctc`, `expected_ctc`, `why_look_for_job_change`, `other_offer_in_pipeline`, `native_place`, `medical_issues`, `marital_status`, `family_background`, `strengths_weaknesses`, `team_player`, `interacted_clients`, `clients_geography`, `extended_working`, `additional_skills`, `methodology`, `absenteeism`, `work_pressure`, `deal_criticism`, `certifications`, `hybrid_report`, `jumped_job`, `notice_peroid`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Selected', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-01 06:35:21', '2023-08-01 06:35:21'),
(2, 2, 1, 'Selected', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-02 11:11:35', '2023-08-02 11:11:35'),
(3, 3, 1, 'selected', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-03 07:59:16', '2023-08-03 07:59:16'),
(4, 4, 1, 'selected', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-03 08:26:06', '2023-08-03 08:26:06'),
(5, 5, 1, 'Selected', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-04 09:42:07', '2023-08-04 09:42:07'),
(6, 6, 1, 'Selected', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-04 13:25:20', '2023-08-04 13:25:20'),
(7, 7, 1, 'selected', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-07 16:33:05', '2023-08-07 16:33:05'),
(8, 8, 1, 'selected', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-09 06:07:52', '2023-08-09 06:07:52'),
(9, 9, 1, 'Selected', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-11 07:34:15', '2023-08-11 07:34:15'),
(10, 10, 1, 'Selected', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-14 10:06:13', '2023-09-14 10:06:13'),
(11, 12, 2, 'Good', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-26 06:02:00', '2023-10-26 06:02:00');

-- --------------------------------------------------------

--
-- Table structure for table `interview_rounds`
--

CREATE TABLE `interview_rounds` (
  `id` bigint(20) NOT NULL,
  `round_name` varchar(200) NOT NULL,
  `feedback_template` int(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `interview_rounds`
--

INSERT INTO `interview_rounds` (`id`, `round_name`, `feedback_template`, `created_at`, `updated_at`) VALUES
(1, 'HR Round', 1, '2023-07-31 10:28:36', '2023-07-31 10:28:36'),
(2, 'Tech Round', 2, '2023-07-31 10:28:48', '2023-07-31 10:28:48'),
(3, 'Client Round', 0, '2023-07-31 10:39:13', '2023-07-31 10:39:13');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_code` varchar(200) DEFAULT NULL,
  `position_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `job_status` int(11) NOT NULL DEFAULT '1',
  `wo_id` varchar(250) DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `submit_date` date DEFAULT NULL,
  `closed_date` date DEFAULT NULL,
  `candidate_type` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `job_type_id` bigint(20) UNSIGNED NOT NULL,
  `headcount` int(11) NOT NULL,
  `minimum_salary` varchar(100) NOT NULL,
  `maximum_salary` varchar(100) NOT NULL,
  `currency` varchar(100) NOT NULL,
  `billing_mode` varchar(100) DEFAULT NULL,
  `experience_required` varchar(50) NOT NULL,
  `importance` varchar(100) NOT NULL,
  `job_posted_date` date NOT NULL,
  `job_owner` bigint(20) UNSIGNED NOT NULL,
  `job_description` mediumtext NOT NULL,
  `jd_upload` varchar(400) DEFAULT NULL,
  `essential_skills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `desirable_skills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `emp_refer` varchar(100) DEFAULT '0',
  `emp_show` int(1) DEFAULT '0',
  `consultancy_refer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `rounds` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `job_code`, `position_id`, `project_id`, `job_status`, `wo_id`, `received_date`, `submit_date`, `closed_date`, `candidate_type`, `location`, `job_type_id`, `headcount`, `minimum_salary`, `maximum_salary`, `currency`, `billing_mode`, `experience_required`, `importance`, `job_posted_date`, `job_owner`, `job_description`, `jd_upload`, `essential_skills`, `desirable_skills`, `emp_refer`, `emp_show`, `consultancy_refer`, `rounds`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'JOB_001', 1, 5, 1, 'WO001', '2023-07-01', '2023-09-30', '2023-09-30', 'Experience', 'Remote', 1, 2, '14LPA', '20LPA', 'INR', NULL, '5LPA', 'High', '2023-07-31', 118, '<p>JAVA</p>\r\n<p>SQL</p>\r\n<p>&nbsp;</p>', '1690800240.pdf', '[1]', '[4]', '0', 0, NULL, '[1,2,3]', '2023-07-31 10:44:00', '2023-07-31 10:44:44', 27, NULL),
(2, 'JOB_002', 2, 5, 1, NULL, '2023-09-01', '2023-09-30', '2024-05-31', 'Experience', 'Remote', 1, 10, '20 LPA', '25 LPA', 'INR', NULL, '5+', 'High', '2023-09-06', 118, '<p>Dot Net</p>\r\n<p>SQL</p>', NULL, '[2,6]', '[4]', '0', 0, '[1]', '[1,2,3]', '2023-09-06 12:00:26', '2023-10-25 09:35:07', 27, NULL);

--
-- Triggers `jobs`
--
DELIMITER $$
CREATE TRIGGER `getId` BEFORE INSERT ON `jobs` FOR EACH ROW BEGIN
	INSERT INTO table1_seq VALUES (NULL);
    SET NEW.job_code = CONCAT("JOB_", LPAD(LAST_INSERT_ID(), 3, "0"));
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `jobs_users`
--

CREATE TABLE `jobs_users` (
  `jobs_id` bigint(20) UNSIGNED NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `ack` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `job_interview`
--

CREATE TABLE `job_interview` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `can_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED DEFAULT NULL,
  `round_1` varchar(250) NOT NULL,
  `round_1_img` varchar(100) DEFAULT NULL,
  `round_1_feedback` bigint(20) UNSIGNED DEFAULT NULL,
  `round_1_feedback_type` varchar(50) DEFAULT NULL,
  `round_1_status` int(11) DEFAULT NULL,
  `round_2` varchar(250) DEFAULT NULL,
  `round_2_img` varchar(100) DEFAULT NULL,
  `round_2_feedback` bigint(20) UNSIGNED DEFAULT NULL,
  `round_2_feedback_type` int(50) DEFAULT NULL,
  `round_2_status` int(1) DEFAULT NULL,
  `round_3` varchar(200) DEFAULT NULL,
  `round_3_img` varchar(100) DEFAULT NULL,
  `round_3_feedback` int(50) DEFAULT NULL,
  `round_3_feedback_type` int(50) DEFAULT NULL,
  `round_3_status` int(50) DEFAULT NULL,
  `round_4` varchar(200) DEFAULT NULL,
  `round_4_img` varchar(100) DEFAULT NULL,
  `round_4_feedback` int(50) DEFAULT NULL,
  `round_4_feedback_type` int(50) DEFAULT NULL,
  `round_4_status` int(50) DEFAULT NULL,
  `round_5` varchar(200) DEFAULT NULL,
  `round_5_img` varchar(100) DEFAULT NULL,
  `round_5_feedback` int(50) DEFAULT NULL,
  `round_5_feedback_type` int(50) DEFAULT NULL,
  `round_5_status` int(50) DEFAULT NULL,
  `round_6` varchar(200) DEFAULT NULL,
  `round_6_img` varchar(100) DEFAULT NULL,
  `round_6_feedback` int(50) DEFAULT NULL,
  `round_6_feedback_type` int(50) DEFAULT NULL,
  `round_6_status` int(50) DEFAULT NULL,
  `round_7` varchar(200) DEFAULT NULL,
  `round_7_img` varchar(100) DEFAULT NULL,
  `round_7_feedback` int(50) DEFAULT NULL,
  `round_7_feedback_type` int(50) DEFAULT NULL,
  `round_7_status` int(50) DEFAULT NULL,
  `round_8` varchar(200) DEFAULT NULL,
  `round_8_img` varchar(100) DEFAULT NULL,
  `round_8_feedback` int(50) DEFAULT NULL,
  `round_8_feedback_type` int(50) DEFAULT NULL,
  `round_8_status` int(50) DEFAULT NULL,
  `round_9` varchar(200) DEFAULT NULL,
  `round_10` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_interview`
--

INSERT INTO `job_interview` (`id`, `can_id`, `job_id`, `round_1`, `round_1_img`, `round_1_feedback`, `round_1_feedback_type`, `round_1_status`, `round_2`, `round_2_img`, `round_2_feedback`, `round_2_feedback_type`, `round_2_status`, `round_3`, `round_3_img`, `round_3_feedback`, `round_3_feedback_type`, `round_3_status`, `round_4`, `round_4_img`, `round_4_feedback`, `round_4_feedback_type`, `round_4_status`, `round_5`, `round_5_img`, `round_5_feedback`, `round_5_feedback_type`, `round_5_status`, `round_6`, `round_6_img`, `round_6_feedback`, `round_6_feedback_type`, `round_6_status`, `round_7`, `round_7_img`, `round_7_feedback`, `round_7_feedback_type`, `round_7_status`, `round_8`, `round_8_img`, `round_8_feedback`, `round_8_feedback_type`, `round_8_status`, `round_9`, `round_10`, `created_at`, `updated_at`) VALUES
(984, 1, 1, '1', NULL, 1, '1', 2, '2', NULL, 1, 2, 2, '3', NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-31 10:47:46', '2023-08-01 06:38:29'),
(985, 2, 1, '1', NULL, 2, '1', 2, '2', NULL, 2, 2, 2, '3', NULL, 2, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-31 10:55:24', '2023-08-02 11:14:39'),
(986, 3, 1, '1', NULL, 3, '1', 2, '2', NULL, 3, 2, 2, '3', NULL, 3, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-31 10:58:26', '2023-08-03 08:01:29'),
(987, 4, 1, '1', NULL, 4, '1', 2, '2', NULL, 4, 2, 2, '3', NULL, 4, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-03 08:25:01', '2023-08-03 08:28:23'),
(988, 5, 1, '1', NULL, 5, '1', 2, '2', NULL, 5, 2, 2, '3', NULL, 5, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-04 09:39:22', '2023-08-04 09:46:52'),
(989, 6, 1, '1', NULL, 6, '1', 2, '2', NULL, 6, 2, 2, '3', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-04 13:22:45', '2023-08-04 13:27:56'),
(990, 7, 1, '1', NULL, 7, '1', 2, '2', NULL, 7, 2, 2, '3', NULL, 6, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-07 16:31:12', '2023-08-07 16:42:10'),
(991, 8, 1, '1', NULL, 8, '1', 2, '2', NULL, 8, 2, 2, '3', NULL, 7, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-08 07:01:44', '2023-08-09 06:10:33'),
(992, 9, 1, '1', NULL, 9, '1', 2, '2', NULL, 9, 2, 2, '3', NULL, 8, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-11 07:32:42', '2023-08-11 07:36:07'),
(993, 10, 1, '1', NULL, 10, '1', 2, '2', NULL, NULL, 2, NULL, '3', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-08 10:44:48', '2023-09-14 10:06:13'),
(994, 11, 1, '1', NULL, NULL, '1', NULL, '2', NULL, NULL, 2, NULL, '3', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-25 09:32:12', '2023-10-25 09:32:12'),
(995, 12, 2, '1', NULL, 11, '1', 2, '2', NULL, 10, 2, 2, '3', NULL, 9, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-26 05:56:56', '2023-10-26 06:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `job_offer`
--

CREATE TABLE `job_offer` (
  `id` int(10) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `can_id` bigint(20) UNSIGNED NOT NULL,
  `document_verified` varchar(50) DEFAULT NULL,
  `dv_comment` varchar(250) DEFAULT NULL,
  `dv_date` timestamp NULL DEFAULT NULL,
  `dv_update_by` bigint(20) UNSIGNED DEFAULT NULL,
  `offer_letter` varchar(50) DEFAULT NULL,
  `ol_comment` varchar(250) DEFAULT NULL,
  `ol_date` timestamp NULL DEFAULT NULL,
  `ol_updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `offer_ack` varchar(50) DEFAULT NULL,
  `offer_ack_comment` varchar(250) DEFAULT NULL,
  `offer_ack_date` timestamp NULL DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `ack_updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `appointment_order_received` varchar(50) DEFAULT NULL,
  `document_submitted` varchar(50) DEFAULT NULL,
  `aor_date` timestamp NULL DEFAULT NULL,
  `aor_comment` varchar(200) DEFAULT NULL,
  `aor_updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_offer`
--

INSERT INTO `job_offer` (`id`, `job_id`, `can_id`, `document_verified`, `dv_comment`, `dv_date`, `dv_update_by`, `offer_letter`, `ol_comment`, `ol_date`, `ol_updated_by`, `offer_ack`, `offer_ack_comment`, `offer_ack_date`, `joining_date`, `ack_updated_by`, `appointment_order_received`, `document_submitted`, `aor_date`, `aor_comment`, `aor_updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Yes', 'Verified', '2023-07-31 18:30:00', 27, 'Yes', 'Offer sent', '2023-07-31 18:30:00', 27, 'Yes', 'Acknowledged', '2023-07-31 18:30:00', '2023-08-04', 27, 'Yes', 'Yes', '2023-07-31 18:30:00', 'Appointment received', 27, '2023-08-01 06:40:13', '2023-08-01 06:41:20'),
(2, 1, 2, 'Yes', 'Document Verification', '2023-08-01 18:30:00', 27, 'Yes', 'Offer sent', '2023-08-01 18:30:00', 27, 'Yes', 'Offer Letter Acknowledged', '2023-08-01 18:30:00', '2023-08-04', 27, 'Yes', 'Yes', '2023-08-01 18:30:00', 'Appointment Order Received', 27, '2023-08-02 11:16:22', '2023-08-02 11:17:27'),
(3, 1, 3, 'Yes', 'Document Verified', '2023-08-02 18:30:00', 27, 'Yes', 'Offer Letter Sent', '2023-08-02 18:30:00', 27, 'Yes', 'Offer Letter Acknowledged', '2023-08-10 18:30:00', '2023-08-04', 27, 'Yes', 'Yes', '2023-08-02 18:30:00', 'Appointment Order Received', 27, '2023-08-03 08:03:02', '2023-08-03 08:04:03'),
(4, 1, 4, 'Yes', 'Document Verified', '2023-08-02 18:30:00', 27, 'Yes', 'Offer Letter Sent', '2023-08-02 18:30:00', 27, 'Yes', 'Offer Letter Acknowledged', '2023-08-02 18:30:00', '2023-08-03', 27, 'Yes', 'Yes', '2023-08-02 18:30:00', 'Appointment Order Received', 27, '2023-08-03 08:28:49', '2023-08-03 08:29:29'),
(5, 1, 5, 'Yes', 'Document Verified', '2023-08-03 18:30:00', 27, 'Yes', 'Offer Letter Sent', '2023-08-03 18:30:00', 27, 'Yes', 'Offer Letter Acknowledged', '2023-08-03 18:30:00', '2023-08-07', 27, 'Yes', 'Yes', '2023-08-03 18:30:00', 'Appointment Order Received', 27, '2023-08-04 09:48:45', '2023-08-04 09:49:49'),
(6, 1, 7, 'Yes', 'Document Verified', '2023-08-06 18:30:00', 27, 'Yes', 'Offer Letter Sent', '2023-08-06 18:30:00', 27, 'Yes', 'Offer Letter Acknowledged', '2023-08-06 18:30:00', '2023-08-11', 27, 'Yes', 'Yes', '2023-08-06 18:30:00', 'Appointment Order Received', 27, '2023-08-07 16:43:25', '2023-08-07 16:44:43'),
(7, 1, 8, 'Yes', 'Document Verified', '2023-08-08 18:30:00', 118, 'Yes', 'Offer Letter Sent', '2023-08-08 18:30:00', 118, 'Yes', 'Offer Letter Acknowledged', '2023-08-08 18:30:00', '2023-08-11', 118, 'Yes', 'Yes', '2023-08-08 18:30:00', 'Appointment Order Received', 118, '2023-08-09 06:12:12', '2023-08-09 06:13:07'),
(8, 1, 9, 'Yes', 'Document Verified', '2023-08-10 18:30:00', 27, 'Yes', 'Offer Letter Sent', '2023-08-10 18:30:00', 27, 'Yes', 'Offer Letter Acknowledged', '2023-08-10 18:30:00', '2023-08-14', 27, 'Yes', 'Yes', '2023-08-10 18:30:00', 'Appointment Order Received', 27, '2023-08-11 07:37:03', '2023-08-11 07:38:08'),
(9, 2, 12, 'Yes', 'veri', '2023-10-25 18:30:00', 118, 'Yes', 'sent', '2023-10-25 18:30:00', 118, 'Yes', 'asd', '2023-10-25 18:30:00', '2023-10-26', 118, 'Yes', 'Yes', '2023-10-25 18:30:00', 'asd', 118, '2023-10-26 07:00:43', '2023-10-26 07:01:10');

-- --------------------------------------------------------

--
-- Table structure for table `job_positions`
--

CREATE TABLE `job_positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `position_name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_positions`
--

INSERT INTO `job_positions` (`id`, `position_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Java Developer', 1, '2023-07-31 08:16:25', '2023-07-31 08:16:25'),
(2, '.Net Developer', 1, '2023-07-31 08:16:49', '2023-07-31 08:16:49');

-- --------------------------------------------------------

--
-- Table structure for table `job_schedule`
--

CREATE TABLE `job_schedule` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `job_interview_id` bigint(20) UNSIGNED NOT NULL,
  `round` varchar(50) NOT NULL,
  `interviewer_id` bigint(20) UNSIGNED NOT NULL,
  `interviewer_2_id` bigint(20) UNSIGNED DEFAULT NULL,
  `can_id` bigint(20) UNSIGNED NOT NULL,
  `round_id` bigint(20) UNSIGNED NOT NULL,
  `schedule_date` date NOT NULL,
  `schedule_time` time NOT NULL,
  `interview_type` varchar(100) NOT NULL,
  `meeting_link` varchar(500) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_schedule`
--

INSERT INTO `job_schedule` (`id`, `job_id`, `job_interview_id`, `round`, `interviewer_id`, `interviewer_2_id`, `can_id`, `round_id`, `schedule_date`, `schedule_time`, `interview_type`, `meeting_link`, `status`, `created_at`, `updated_at`) VALUES
(534, 1, 984, 'round_1', 27, NULL, 1, 1, '2023-08-01', '11:57:00', 'Telephonic Interview', NULL, 0, '2023-08-01 06:26:41', '2023-08-01 06:35:21'),
(535, 1, 984, 'round_2', 27, NULL, 1, 2, '2023-08-01', '12:07:00', 'Telephonic Interview', NULL, 0, '2023-08-01 06:35:52', '2023-08-01 06:36:54'),
(536, 1, 984, 'round_3', 27, NULL, 1, 3, '2023-08-01', '12:08:00', 'Telephonic Interview', NULL, 0, '2023-08-01 06:37:37', '2023-08-01 06:38:29'),
(537, 1, 985, 'round_1', 27, NULL, 2, 1, '2023-08-02', '16:41:00', 'Telephonic Interview', NULL, 0, '2023-08-02 11:10:13', '2023-08-02 11:11:35'),
(538, 1, 985, 'round_2', 27, NULL, 2, 2, '2023-08-02', '16:43:00', 'Telephonic Interview', NULL, 0, '2023-08-02 11:12:26', '2023-08-02 11:13:07'),
(539, 1, 985, 'round_3', 27, NULL, 2, 3, '2023-08-02', '16:45:00', 'Telephonic Interview', NULL, 0, '2023-08-02 11:14:05', '2023-08-02 11:14:39'),
(540, 1, 986, 'round_1', 27, NULL, 3, 1, '2023-08-03', '13:29:00', 'Face to Face', NULL, 0, '2023-08-03 07:58:01', '2023-08-03 07:59:16'),
(541, 1, 986, 'round_2', 27, NULL, 3, 2, '2023-08-03', '13:31:00', 'Telephonic Interview', NULL, 0, '2023-08-03 07:59:57', '2023-08-03 08:00:33'),
(542, 1, 986, 'round_3', 27, NULL, 3, 3, '2023-08-03', '13:32:00', 'Telephonic Interview', NULL, 0, '2023-08-03 08:01:03', '2023-08-03 08:01:29'),
(543, 1, 987, 'round_1', 27, NULL, 4, 1, '2023-08-03', '13:56:00', 'Telephonic Interview', NULL, 0, '2023-08-03 08:25:36', '2023-08-03 08:26:06'),
(544, 1, 987, 'round_2', 27, NULL, 4, 2, '2023-08-03', '13:57:00', 'Telephonic Interview', NULL, 0, '2023-08-03 08:26:39', '2023-08-03 08:27:18'),
(545, 1, 987, 'round_3', 27, NULL, 4, 3, '2023-08-03', '13:59:00', 'Telephonic Interview', NULL, 0, '2023-08-03 08:28:00', '2023-08-03 08:28:23'),
(546, 1, 988, 'round_1', 27, NULL, 5, 1, '2023-08-04', '15:11:00', 'Telephonic Interview', NULL, 0, '2023-08-04 09:40:18', '2023-08-04 09:42:07'),
(547, 1, 988, 'round_2', 27, NULL, 5, 2, '2023-08-04', '15:14:00', 'Telephonic Interview', NULL, 0, '2023-08-04 09:42:56', '2023-08-04 09:44:51'),
(548, 1, 988, 'round_3', 27, NULL, 5, 3, '2023-08-04', '15:16:00', 'Telephonic Interview', NULL, 0, '2023-08-04 09:45:32', '2023-08-04 09:46:52'),
(549, 1, 989, 'round_1', 27, NULL, 6, 1, '2023-08-04', '18:55:00', 'Telephonic Interview', NULL, 0, '2023-08-04 13:24:13', '2023-08-04 13:25:20'),
(550, 1, 989, 'round_2', 27, NULL, 6, 2, '2023-08-04', '18:58:00', 'Telephonic Interview', NULL, 0, '2023-08-04 13:26:53', '2023-08-04 13:27:56'),
(551, 1, 990, 'round_1', 27, NULL, 7, 1, '2023-08-07', '22:03:00', 'Telephonic Interview', NULL, 0, '2023-08-07 16:32:23', '2023-08-07 16:33:05'),
(552, 1, 990, 'round_2', 27, NULL, 7, 2, '2023-08-07', '22:04:00', 'Telephonic Interview', NULL, 0, '2023-08-07 16:33:37', '2023-08-07 16:40:24'),
(553, 1, 990, 'round_3', 27, NULL, 7, 3, '2023-08-07', '22:12:00', 'Telephonic Interview', NULL, 0, '2023-08-07 16:41:17', '2023-08-07 16:42:10'),
(554, 1, 991, 'round_1', 27, NULL, 8, 1, '2023-08-09', '11:38:00', 'Telephonic Interview', NULL, 0, '2023-08-09 06:07:17', '2023-08-09 06:07:52'),
(555, 1, 991, 'round_2', 27, NULL, 8, 2, '2023-08-09', '11:39:00', 'Telephonic Interview', NULL, 0, '2023-08-09 06:08:27', '2023-08-09 06:09:15'),
(556, 1, 991, 'round_3', 27, NULL, 8, 3, '2023-08-09', '11:41:00', 'Face to Face', NULL, 0, '2023-08-09 06:09:56', '2023-08-09 06:10:33'),
(557, 1, 992, 'round_1', 27, NULL, 9, 1, '2023-08-11', '13:04:00', 'Telephonic Interview', NULL, 0, '2023-08-11 07:33:25', '2023-08-11 07:34:15'),
(558, 1, 992, 'round_2', 27, NULL, 9, 2, '2023-08-11', '13:06:00', 'Telephonic Interview', NULL, 0, '2023-08-11 07:34:43', '2023-08-11 07:35:16'),
(559, 1, 992, 'round_3', 27, NULL, 9, 3, '2023-08-11', '13:07:00', 'Telephonic Interview', NULL, 0, '2023-08-11 07:35:45', '2023-08-11 07:36:07'),
(560, 1, 993, 'round_1', 27, NULL, 10, 1, '2023-09-14', '17:16:00', 'Face to Face', NULL, 0, '2023-09-08 11:45:33', '2023-09-14 10:06:13'),
(561, 2, 995, 'round_2', 118, NULL, 12, 2, '2023-10-26', '11:34:00', 'Telephonic Interview', NULL, 0, '2023-10-26 06:04:12', '2023-10-26 06:05:55'),
(562, 2, 995, 'round_3', 118, NULL, 12, 3, '2023-10-26', '11:38:00', 'Telephonic Interview', NULL, 0, '2023-10-26 06:09:01', '2023-10-26 06:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `job_types`
--

CREATE TABLE `job_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_type` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_types`
--

INSERT INTO `job_types` (`id`, `job_type`, `created_at`, `updated_at`) VALUES
(1, 'Fulltime', '2023-07-31 08:59:46', '2023-07-31 08:59:46'),
(2, 'Parttime', '2023-07-31 08:59:46', '2023-07-31 08:59:46');

-- --------------------------------------------------------

--
-- Table structure for table `leave_applications`
--

CREATE TABLE `leave_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullDay` tinyint(1) NOT NULL DEFAULT '1',
  `noOfDayApplied` float NOT NULL,
  `noOfWorkingDay` int(11) NOT NULL,
  `noOfPublicHoliday` int(11) NOT NULL,
  `noOfDayDeduct` float NOT NULL,
  `leaveStatus` int(11) NOT NULL DEFAULT '0',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_id` bigint(20) UNSIGNED NOT NULL,
  `needCertificate` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `leaveReason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assignedBy` int(11) DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_applications`
--

INSERT INTO `leave_applications` (`id`, `startDate`, `endDate`, `name`, `fullDay`, `noOfDayApplied`, `noOfWorkingDay`, `noOfPublicHoliday`, `noOfDayDeduct`, `leaveStatus`, `user_id`, `leave_type_id`, `needCertificate`, `created_at`, `updated_at`, `updated_by`, `leaveReason`, `assignedBy`, `remarks`) VALUES
(3, '2023-09-06', '2023-09-06', 'RAVI RAMU - CL', 1, 1, 1, 1, 0, 0, 27, 1, 0, '2023-09-30 02:43:06', '2023-09-30 02:43:06', NULL, 'asdasd', NULL, NULL),
(4, '2023-09-05', '2023-09-05', 'RAVI RAMU - CL', 1, 1, 1, 0, 1, 0, 27, 1, 0, '2023-09-30 02:46:01', '2023-09-30 02:46:01', NULL, 'zczx', NULL, NULL),
(5, '2023-09-19', '2023-09-19', 'RAVI RAMU - CL', 1, 1, 1, 0, 1, 0, 27, 1, 0, '2023-09-30 02:47:21', '2023-09-30 02:47:21', NULL, 'asd', NULL, NULL),
(6, '2023-10-25', '2023-10-25', 'RAVI RAMU - CL', 1, 1, 1, 0, 1, 1, 27, 1, 0, '2023-10-24 12:28:48', '2023-10-24 12:44:22', NULL, 'test', NULL, NULL),
(7, '2023-10-27', '2023-10-27', ' - CL', 1, 1, 1, 0, 1, 1, 210, 1, 0, '2023-10-24 12:36:01', '2023-10-24 12:43:19', NULL, 'test hrms data', 27, NULL),
(8, '2023-11-01', '2023-11-01', 'RAVI RAMU - CL', 0, 1, 1, 0, 0.5, 0, 27, 1, 0, '2023-11-01 08:24:22', '2023-11-01 08:24:22', NULL, 'sda', NULL, NULL),
(9, '2023-11-06', '2023-11-06', 'RAVI RAMU - PL', 1, 1, 1, 0, 1, 0, 27, 2, 0, '2023-11-03 10:10:18', '2023-11-03 10:10:18', NULL, 'HRMS testing leave', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leave_entitlements`
--

CREATE TABLE `leave_entitlements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `entitlement` float NOT NULL,
  `year` int(11) NOT NULL,
  `leave_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_entitlements`
--

INSERT INTO `leave_entitlements` (`id`, `user_id`, `entitlement`, `year`, `leave_type_id`, `created_at`, `updated_at`) VALUES
(1, 27, 100, 2023, 1, NULL, NULL),
(2, 27, 100, 2023, 2, NULL, NULL),
(3, 27, 100, 2023, 3, NULL, NULL),
(4, 27, 100, 2023, 5, NULL, NULL),
(5, 38, 10, 2023, 1, NULL, NULL),
(6, 38, 10, 2023, 2, NULL, NULL),
(7, 38, 10, 2023, 3, NULL, NULL),
(8, 38, 10, 2023, 5, NULL, NULL),
(9, 44, 10, 2023, 1, NULL, NULL),
(10, 44, 10, 2023, 2, NULL, NULL),
(11, 44, 10, 2023, 3, NULL, NULL),
(12, 44, 10, 2023, 5, NULL, NULL),
(13, 118, 10, 2023, 1, NULL, NULL),
(14, 118, 10, 2023, 2, NULL, NULL),
(15, 118, 20, 2023, 3, NULL, NULL),
(16, 118, 20, 2023, 5, NULL, NULL),
(17, 195, 1, 2023, 1, '2023-08-01 06:47:35', '2023-08-01 06:47:35'),
(18, 195, 0, 2023, 2, '2023-08-01 06:47:35', '2023-08-01 06:47:35'),
(19, 195, 1, 2023, 3, '2023-08-01 06:47:35', '2023-08-01 06:47:35'),
(20, 195, 100, 2023, 5, '2023-08-01 06:47:35', '2023-08-01 06:47:35'),
(21, 195, 0, 2023, 6, '2023-08-01 06:47:35', '2023-08-01 06:47:35'),
(22, 196, 1, 2023, 1, '2023-08-02 11:25:08', '2023-08-02 11:25:08'),
(23, 196, 0, 2023, 2, '2023-08-02 11:25:08', '2023-08-02 11:25:08'),
(24, 196, 1, 2023, 3, '2023-08-02 11:25:08', '2023-08-02 11:25:08'),
(25, 196, 100, 2023, 5, '2023-08-02 11:25:08', '2023-08-02 11:25:08'),
(26, 196, 0, 2023, 6, '2023-08-02 11:25:08', '2023-08-02 11:25:08'),
(27, 197, 1, 2023, 1, '2023-08-03 08:09:09', '2023-08-03 08:09:09'),
(28, 197, 0, 2023, 2, '2023-08-03 08:09:09', '2023-08-03 08:09:09'),
(29, 197, 1, 2023, 3, '2023-08-03 08:09:09', '2023-08-03 08:09:09'),
(30, 197, 100, 2023, 5, '2023-08-03 08:09:09', '2023-08-03 08:09:09'),
(31, 197, 0, 2023, 6, '2023-08-03 08:09:09', '2023-08-03 08:09:09'),
(32, 198, 1, 2023, 1, '2023-08-03 08:32:33', '2023-08-03 08:32:33'),
(33, 198, 0, 2023, 2, '2023-08-03 08:32:33', '2023-08-03 08:32:33'),
(34, 198, 1, 2023, 3, '2023-08-03 08:32:33', '2023-08-03 08:32:33'),
(35, 198, 100, 2023, 5, '2023-08-03 08:32:33', '2023-08-03 08:32:33'),
(36, 198, 0, 2023, 6, '2023-08-03 08:32:33', '2023-08-03 08:32:33'),
(37, 199, 1, 2023, 1, '2023-08-03 10:31:32', '2023-08-03 10:31:32'),
(38, 199, 0, 2023, 2, '2023-08-03 10:31:32', '2023-08-03 10:31:32'),
(39, 199, 1, 2023, 3, '2023-08-03 10:31:32', '2023-08-03 10:31:32'),
(40, 199, 100, 2023, 5, '2023-08-03 10:31:32', '2023-08-03 10:31:32'),
(41, 199, 0, 2023, 6, '2023-08-03 10:31:32', '2023-08-03 10:31:32'),
(42, 200, 1, 2023, 1, '2023-08-04 07:43:05', '2023-08-04 07:43:05'),
(43, 200, 0, 2023, 2, '2023-08-04 07:43:05', '2023-08-04 07:43:05'),
(44, 200, 1, 2023, 3, '2023-08-04 07:43:05', '2023-08-04 07:43:05'),
(45, 200, 100, 2023, 5, '2023-08-04 07:43:05', '2023-08-04 07:43:05'),
(46, 200, 0, 2023, 6, '2023-08-04 07:43:05', '2023-08-04 07:43:05'),
(47, 201, 1, 2023, 1, '2023-08-04 07:45:20', '2023-08-04 07:45:20'),
(48, 201, 0, 2023, 2, '2023-08-04 07:45:20', '2023-08-04 07:45:20'),
(49, 201, 1, 2023, 3, '2023-08-04 07:45:20', '2023-08-04 07:45:20'),
(50, 201, 100, 2023, 5, '2023-08-04 07:45:20', '2023-08-04 07:45:20'),
(51, 201, 0, 2023, 6, '2023-08-04 07:45:20', '2023-08-04 07:45:20'),
(52, 202, 1, 2023, 1, '2023-08-04 07:47:15', '2023-08-04 07:47:15'),
(53, 202, 0, 2023, 2, '2023-08-04 07:47:15', '2023-08-04 07:47:15'),
(54, 202, 1, 2023, 3, '2023-08-04 07:47:15', '2023-08-04 07:47:15'),
(55, 202, 100, 2023, 5, '2023-08-04 07:47:15', '2023-08-04 07:47:15'),
(56, 202, 0, 2023, 6, '2023-08-04 07:47:15', '2023-08-04 07:47:15'),
(57, 203, 1, 2023, 1, '2023-08-04 07:48:25', '2023-08-04 07:48:25'),
(58, 203, 0, 2023, 2, '2023-08-04 07:48:25', '2023-08-04 07:48:25'),
(59, 203, 1, 2023, 3, '2023-08-04 07:48:25', '2023-08-04 07:48:25'),
(60, 203, 100, 2023, 5, '2023-08-04 07:48:25', '2023-08-04 07:48:25'),
(61, 203, 0, 2023, 6, '2023-08-04 07:48:25', '2023-08-04 07:48:25'),
(62, 204, 1, 2023, 1, '2023-08-04 09:59:10', '2023-08-04 09:59:10'),
(63, 204, 0, 2023, 2, '2023-08-04 09:59:10', '2023-08-04 09:59:10'),
(64, 204, 1, 2023, 3, '2023-08-04 09:59:10', '2023-08-04 09:59:10'),
(65, 204, 100, 2023, 5, '2023-08-04 09:59:11', '2023-08-04 09:59:11'),
(66, 204, 0, 2023, 6, '2023-08-04 09:59:11', '2023-08-04 09:59:11'),
(67, 205, 1, 2023, 1, '2023-08-07 16:22:53', '2023-08-07 16:22:53'),
(68, 205, 0, 2023, 2, '2023-08-07 16:22:53', '2023-08-07 16:22:53'),
(69, 205, 1, 2023, 3, '2023-08-07 16:22:53', '2023-08-07 16:22:53'),
(70, 205, 100, 2023, 5, '2023-08-07 16:22:53', '2023-08-07 16:22:53'),
(71, 205, 0, 2023, 6, '2023-08-07 16:22:53', '2023-08-07 16:22:53'),
(72, 206, 1, 2023, 1, '2023-08-07 17:05:59', '2023-08-07 17:05:59'),
(73, 206, 0, 2023, 2, '2023-08-07 17:05:59', '2023-08-07 17:05:59'),
(74, 206, 1, 2023, 3, '2023-08-07 17:05:59', '2023-08-07 17:05:59'),
(75, 206, 100, 2023, 5, '2023-08-07 17:05:59', '2023-08-07 17:05:59'),
(76, 206, 0, 2023, 6, '2023-08-07 17:05:59', '2023-08-07 17:05:59'),
(77, 207, 1, 2023, 1, '2023-08-08 05:46:56', '2023-08-08 05:46:56'),
(78, 207, 0, 2023, 2, '2023-08-08 05:46:56', '2023-08-08 05:46:56'),
(79, 207, 1, 2023, 3, '2023-08-08 05:46:56', '2023-08-08 05:46:56'),
(80, 207, 100, 2023, 5, '2023-08-08 05:46:56', '2023-08-08 05:46:56'),
(81, 207, 0, 2023, 6, '2023-08-08 05:46:56', '2023-08-08 05:46:56'),
(82, 208, 1, 2023, 1, '2023-08-09 06:14:56', '2023-08-09 06:14:56'),
(83, 208, 0, 2023, 2, '2023-08-09 06:14:56', '2023-08-09 06:14:56'),
(84, 208, 1, 2023, 3, '2023-08-09 06:14:56', '2023-08-09 06:14:56'),
(85, 208, 100, 2023, 5, '2023-08-09 06:14:56', '2023-08-09 06:14:56'),
(86, 208, 0, 2023, 6, '2023-08-09 06:14:56', '2023-08-09 06:14:56'),
(87, 209, 1, 2023, 1, '2023-08-11 07:40:10', '2023-08-11 07:40:10'),
(88, 209, 0, 2023, 2, '2023-08-11 07:40:10', '2023-08-11 07:40:10'),
(89, 209, 1, 2023, 3, '2023-08-11 07:40:10', '2023-08-11 07:40:10'),
(90, 209, 100, 2023, 5, '2023-08-11 07:40:10', '2023-08-11 07:40:10'),
(91, 209, 0, 2023, 6, '2023-08-11 07:40:10', '2023-08-11 07:40:10'),
(92, 210, 1, 2023, 1, '2023-10-24 12:09:38', '2023-10-24 12:09:38'),
(93, 210, 0, 2023, 2, '2023-10-24 12:09:38', '2023-10-24 12:09:38'),
(94, 210, 1, 2023, 3, '2023-10-24 12:09:38', '2023-10-24 12:09:38'),
(95, 210, 100, 2023, 5, '2023-10-24 12:09:38', '2023-10-24 12:09:38'),
(96, 210, 0, 2023, 6, '2023-10-24 12:09:38', '2023-10-24 12:09:38'),
(97, 211, 1, 2023, 1, '2023-10-26 07:02:19', '2023-10-26 07:02:19'),
(98, 211, 0, 2023, 2, '2023-10-26 07:02:19', '2023-10-26 07:02:19'),
(99, 211, 1, 2023, 3, '2023-10-26 07:02:19', '2023-10-26 07:02:19'),
(100, 211, 100, 2023, 5, '2023-10-26 07:02:19', '2023-10-26 07:02:19'),
(101, 211, 0, 2023, 6, '2023-10-26 07:02:19', '2023-10-26 07:02:19');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cycleMonth` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `name`, `cycleMonth`, `created_at`, `updated_at`) VALUES
(1, 'CL', NULL, '2022-04-03 08:50:15', '2022-04-03 08:50:15'),
(2, 'PL', NULL, '2022-04-03 08:50:42', '2022-04-03 08:50:42'),
(3, 'SL', NULL, NULL, NULL),
(5, 'LOP', NULL, NULL, NULL),
(6, 'ML count', NULL, '2022-10-05 06:06:30', '2022-10-05 06:06:30');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `months`
--

CREATE TABLE `months` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `month` int(11) NOT NULL,
  `monthName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `months`
--

INSERT INTO `months` (`id`, `month`, `monthName`, `created_at`, `updated_at`) VALUES
(1, 1, 'January', NULL, NULL),
(2, 2, 'February', NULL, NULL),
(3, 3, 'March', NULL, NULL),
(4, 4, 'April', NULL, NULL),
(5, 5, 'May', NULL, NULL),
(6, 6, 'June', NULL, NULL),
(7, 7, 'July', NULL, NULL),
(8, 8, 'August', NULL, NULL),
(9, 9, 'September', NULL, NULL),
(10, 10, 'October', NULL, NULL),
(11, 11, 'November', NULL, NULL),
(12, 12, 'December', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('ahamedirfan.anasdeen@swordgroup.in', '$2y$10$872U5Ey/tx/q.8oacxEqt.xL4OFDCFjW4JJEhwFlznw.Qs6.Ff1sK', '2022-06-13 17:34:12'),
('balamithranadar.selvaraj@swordgroup.in', '$2y$10$Rzr8kTQjS9JU4vdVNO.DfuOxlYPPyjSkt8bFKpORhnsWhRfJSVU4K', '2022-06-14 04:39:56'),
('nagarjun.b@swordgroup.in', '$2y$10$Y25i4rEMd8OvmQBYVL6WROKPYszz6x3D8vGbcpCLMYufblMnuELlC', '2022-06-17 06:12:44'),
('sumathy.ramasamy@swordgroup.in', '$2y$10$qNwdW007Cx5xPg.yZ8w3uOj.anC4P0sT.r0UUfurVeMfAfz63pE4.', '2022-06-21 13:23:13'),
('sathyaraj.mathivanan@swordgroup.in', '$2y$10$0HsrZ4LjT3LgI/kOcy3pNes67oUCJNDHe506h.8HPmgNNLMl82BOG', '2022-06-21 13:25:23'),
('pavithra.thirumalai@swordgroup.in', '$2y$10$d/O.PjlFEgTDqQfEc9fC2.dsHiGEru5tHCsliYXzaC7ESlKvPhP2m', '2022-06-27 04:36:00'),
('vimal.arumugam@swordgroup.in', '$2y$10$q4jVOHshFH4f8G0I3fl0pekRi3cwT0PC/22f4y2bQNj9atvoTksKu', '2022-06-30 20:43:08'),
('senthil.alagappan@swordgroup.in', '$2y$10$gpbOnHfbvFrksGTw/qxbaeezxCw.atStqFVKCctTMx0oooSNRZfou', '2022-07-01 16:36:24'),
('annadurai.b@swordgroup.in', '$2y$10$ZWNB6xhEmnmZvT9m5x2oFOAPtnBY4FrbHtHanuI2NYHqA3bN9H.6y', '2022-07-01 18:24:12'),
('sivakumar.c@swordgroup.in', '$2y$10$7sv0XGSDOUaqbh6DDQFBQuEd2Ou2aHgDa7X1kR6WeAvTZkouFdX9G', '2022-07-01 20:01:38'),
('shanthakumar.parthasarathy@swordgroup.in', '$2y$10$Wy5.PzgGce.usW/fIj5hne0QlP.8JJOeQDVJoi.MXKPcA3nKHpoAC', '2022-07-02 02:31:50'),
('ravi.ramu@swordgroup.in', '$2y$10$NUgC0Oevnn32Ncrx.h2jVum8Uc8B/iL8QpWsrdb/thG0rOuf5/4pq', '2022-07-04 16:49:04'),
('anandan.gunasekaran@swordgroup.in', '$2y$10$ckb.SIGNKu4MifMiWVEexudLVbdW6..JonQTtONxncePY494YhX5y', '2022-07-04 17:01:41'),
('sivambiga.selvam@swordgroup.in', '$2y$10$G34uq.Z4ugfmwKH2FRALN.eEF1tr8ojAp5n37gDOOzZQThceHVaGy', '2022-07-04 22:59:02'),
('elangovan.chinnasamy@swordgroup.in', '$2y$10$IVGfBQ5xj1QVfl5gWCXjEOr8lHHF1YJTJk/V2aeUI.JPaAZt69dcS', '2022-07-04 23:09:37'),
('natesan.velayudham@swordgroup.in', '$2y$10$wJSXnwMJsAzHybCKOQ49YuoUnFw7LhTMOvV3iYUh2m51hk6GTF2jy', '2022-07-04 23:10:21'),
('giridhar.a@swordgroup.in', '$2y$10$HLVxSBolMTE4DI.zfaunxexq7qk4o.14nrzxgs17UKEQu6xbauUXS', '2022-07-05 01:10:26'),
('vigneshkumar.mareeswaran@swordgroup.in', '$2y$10$ZNlHFTtB8kWIZObg6BjWQ.Yr5u4PByRdyXCFw06WzqD/zzCRzNuWe', '2022-07-05 19:25:28'),
('arun.r@swordgroup.in', '$2y$10$NsW19/2N/PBCZcKQT4vL3uHk0s4SlW1ZosD8IhrnE2Ach/y6YyIIa', '2022-07-05 22:03:42'),
('balakrishnan.subburaman@swordgroup.in', '$2y$10$7TVxOzbvWTfv8IjdOMOki.47.La9iso5ot2tav5YwZ87mHrOTReGS', '2022-07-06 20:43:01'),
('gowtham.pugazhaendi@swordgroup.in', '$2y$10$i7/5FEocjUGAKt/ok1PKKewBr0d6fJQGwj8Cys8.XXG3I5jLcENda', '2022-07-07 01:08:13'),
('aswinrupsanth.johnrose@swordgroup.in', '$2y$10$CNwUBFIuJjH980sPjvOj0eFoZKeUOFU6zOIlSN/aGu.BsdSuAcMyu', '2022-07-11 19:21:08'),
('rajavarman.s@swordgroup.in', '$2y$10$AOpzPyPhdRTU2OGt.o.giu/TK4wuym4T9JgXxgWqMs1UDuQs1O3xO', '2022-07-19 18:28:33'),
('mohanaambigha.sampathkumar@swordgroup.in', '$2y$10$zicsnYSYzHYW0QPoS/GOEuy4LJ6XSWsJaAtkmKzJmUYou.B1LU67q', '2022-08-04 23:39:26'),
('nirmal.rajendran@swordgroup.in', '$2y$10$sPSKUHy/dJB6VjDJIPHWNuUQMxn3XZ4MC9zxEeQQXI4ElhGsh.9ei', '2022-08-05 16:27:08'),
('vijayakumar.s@swordgroup.in', '$2y$10$CMT1LXB/pYqaz/F/gOsf8eMSzIjT14q9WFt1jqicMQlL4Guwf/BxS', '2022-08-05 18:24:21'),
('baskar.thangadurai@swordgroup.in', '$2y$10$88/05/OV9PpoRB9ZkznGJuBWxIphF16vpdUL8gnAULvyYsWRFnM/m', '2022-09-15 19:06:49'),
('pappuri.sivalakshmi@swordgroup.in', '$2y$10$8pijVnqAg068s.8p5eLkLehrNkCpojQdYMZcR/dUwKaewZYorh4CK', '2022-10-14 15:44:10'),
('sureshkumaran.shanmugam@swordgroup.in', '$2y$10$z8cMFvnZsOq11eXmIbhjS.en1mp8eueJjfw.xcc2jv95s3Dt3enk6', '2022-11-03 22:00:29'),
('judipreethi.johnpeter@swordgroup.in', '$2y$10$h36tqgOmnVTJ9a6.WZHfuu7pVyhGmAqSF1I9FFW4L5jgpsR/hoqoG', '2022-11-03 23:20:00'),
('webprojects@swordgroup.in', '$2y$10$VAUUvbRU12AbVbGlMsBE3eKwMB26mJDTk7rSq/UAofHoyI8L7sbCa', '2022-11-03 23:32:42'),
('arunkumar.selvaraj@swordgroup.in', '$2y$10$A7l8ChPoWYi1BCtIEzBOleBb6wNJAaaA//feXQ8FZqCBMdENNbkYq', '2023-03-13 17:00:10'),
('swathigaar@swordgroup.in', '$2y$10$33VViLY7eqOooMNfVy8Juuoux.72.agPG798ffo8ycsUIgygPDwsa', '2023-05-22 19:44:17');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projectmasters`
--

CREATE TABLE `projectmasters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `old_project_manager` bigint(20) UNSIGNED DEFAULT NULL,
  `old_pm_end_date` date DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `project_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projectmasters`
--

INSERT INTO `projectmasters` (`id`, `project_name`, `user_id`, `old_project_manager`, `old_pm_end_date`, `location`, `start_date`, `end_date`, `project_id`, `billing_mode`, `currency`, `created_at`, `updated_at`, `status`, `created_by`, `updated_by`) VALUES
(5, 'Sword', 27, NULL, NULL, 'Chennai', '2022-01-01', '2030-12-31', 'SB', 'daily', 'INR', '2022-06-06 08:19:54', '2022-06-08 10:55:04', 1, 0, 0),
(6, 'Sword Project', 44, NULL, NULL, 'India', '2023-10-01', '2031-12-31', 'SW1', 'daily', 'USD', '2023-10-21 06:00:13', '2023-10-21 06:00:13', 1, 27, 27),
(7, 'TSI', 44, NULL, NULL, 'Chennai', '2023-10-24', '2030-12-31', 'TSI', 'daily', 'INR', '2023-10-24 12:23:54', '2023-10-24 12:23:54', 1, 27, 27);

-- --------------------------------------------------------

--
-- Table structure for table `skillsets`
--

CREATE TABLE `skillsets` (
  `id` bigint(20) NOT NULL,
  `skillset` varchar(1000) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `skillsets`
--

INSERT INTO `skillsets` (`id`, `skillset`, `created_at`, `updated_at`) VALUES
(1, 'JAVA', '2023-07-31 08:57:52', '2023-07-31 08:57:52'),
(2, 'DotNet', '2023-07-31 08:58:01', '2023-07-31 08:58:01'),
(3, 'PHP', '2023-07-31 08:58:06', '2023-07-31 08:58:06'),
(4, 'SQL', '2023-07-31 08:58:10', '2023-07-31 08:58:10'),
(5, 'React.Js', '2023-07-31 08:58:20', '2023-07-31 08:58:20'),
(6, 'Angular', '2023-07-31 08:58:29', '2023-07-31 08:58:29');

-- --------------------------------------------------------

--
-- Table structure for table `skill_feedback`
--

CREATE TABLE `skill_feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `can_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `skill_id` bigint(20) UNSIGNED NOT NULL,
  `current_round` varchar(50) NOT NULL,
  `comment` longtext NOT NULL,
  `rating` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `skill_feedback`
--

INSERT INTO `skill_feedback` (`id`, `can_id`, `job_id`, `skill_id`, `current_round`, `comment`, `rating`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'round_2', 'Selected', 10, '2023-08-01 06:36:54', '2023-08-01 06:36:54'),
(2, 1, 1, 4, 'round_2', 'Selected', 1, '2023-08-01 06:36:54', '2023-08-01 06:36:54'),
(3, 2, 1, 1, 'round_2', 'Selected', 10, '2023-08-02 11:13:07', '2023-08-02 11:13:07'),
(4, 2, 1, 4, 'round_2', 'Selected', 1, '2023-08-02 11:13:07', '2023-08-02 11:13:07'),
(5, 3, 1, 1, 'round_2', 'selected', 10, '2023-08-03 08:00:33', '2023-08-03 08:00:33'),
(6, 3, 1, 4, 'round_2', 'selected', 10, '2023-08-03 08:00:33', '2023-08-03 08:00:33'),
(7, 4, 1, 1, 'round_2', 'selected', 10, '2023-08-03 08:27:18', '2023-08-03 08:27:18'),
(8, 4, 1, 4, 'round_2', 'selected', 10, '2023-08-03 08:27:18', '2023-08-03 08:27:18'),
(9, 5, 1, 1, 'round_2', 'Selected', 10, '2023-08-04 09:44:51', '2023-08-04 09:44:51'),
(10, 5, 1, 4, 'round_2', 'Selected', 10, '2023-08-04 09:44:51', '2023-08-04 09:44:51'),
(11, 6, 1, 1, 'round_2', 'selected', 10, '2023-08-04 13:27:56', '2023-08-04 13:27:56'),
(12, 6, 1, 4, 'round_2', 'selected', 10, '2023-08-04 13:27:56', '2023-08-04 13:27:56'),
(13, 7, 1, 1, 'round_2', 'selected', 10, '2023-08-07 16:40:24', '2023-08-07 16:40:24'),
(14, 7, 1, 4, 'round_2', 'selected', 10, '2023-08-07 16:40:24', '2023-08-07 16:40:24'),
(15, 8, 1, 1, 'round_2', 'selected', 10, '2023-08-09 06:09:15', '2023-08-09 06:09:15'),
(16, 8, 1, 4, 'round_2', 'selected', 10, '2023-08-09 06:09:15', '2023-08-09 06:09:15'),
(17, 9, 1, 1, 'round_2', 'Selected', 10, '2023-08-11 07:35:16', '2023-08-11 07:35:16'),
(18, 9, 1, 4, 'round_2', 'Selected', 10, '2023-08-11 07:35:16', '2023-08-11 07:35:16'),
(19, 12, 2, 2, 'round_2', 'good', 8, '2023-10-26 06:05:55', '2023-10-26 06:05:55'),
(20, 12, 2, 6, 'round_2', 'good', 9, '2023-10-26 06:05:55', '2023-10-26 06:05:55'),
(21, 12, 2, 4, 'round_2', 'good', 9, '2023-10-26 06:05:55', '2023-10-26 06:05:55');

-- --------------------------------------------------------

--
-- Table structure for table `table1_seq`
--

CREATE TABLE `table1_seq` (
  `id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table1_seq`
--

INSERT INTO `table1_seq` (`id`) VALUES
(1),
(2);

-- --------------------------------------------------------

--
-- Table structure for table `team_allocations`
--

CREATE TABLE `team_allocations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `is_primary_project` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billable` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shadow_eligible` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `unit_rate` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_allocations`
--

INSERT INTO `team_allocations` (`id`, `user_id`, `project_id`, `is_primary_project`, `work_type`, `billable`, `shadow_eligible`, `start_date`, `end_date`, `unit_rate`, `created_at`, `updated_at`, `status`) VALUES
(1, 27, 5, 'yes', 'FullTime', 'Yes', 'yes', '2023-07-31', '2025-05-31', 1, '2023-07-31 06:33:10', '2023-07-31 06:33:10', 1),
(2, 38, 5, 'yes', 'FullTime', 'Yes', 'yes', '2023-07-31', '2024-07-31', 1, '2023-07-31 06:33:47', '2023-07-31 06:33:47', 1),
(3, 118, 5, 'yes', 'FullTime', 'Yes', 'yes', '2023-07-31', '2025-10-31', 1, '2023-07-31 06:34:18', '2023-07-31 06:34:18', 1),
(4, 44, 5, 'yes', 'FullTime', 'Yes', 'yes', '2023-07-31', '2025-02-28', 1, '2023-07-31 06:34:49', '2023-07-31 06:34:49', 1),
(5, 195, 5, 'yes', 'FullTime', 'Yes', 'no', '2023-08-04', '2030-12-31', 1, '2023-08-01 07:08:24', '2023-08-02 06:06:27', 1),
(6, 196, 5, 'yes', 'FullTime', 'Yes', 'no', '2023-08-04', '2030-12-31', 1, '2023-08-03 06:29:06', '2023-08-03 06:29:06', 1),
(7, 197, 5, 'yes', 'FullTime', 'Yes', 'no', '2023-08-03', '2023-10-24', 1, '2023-08-03 08:10:21', '2023-10-24 13:01:20', 1),
(8, 198, 5, 'yes', 'FullTime', 'Yes', 'no', '2023-08-03', '2030-12-31', 1, '2023-08-03 08:34:02', '2023-08-03 08:34:02', 1),
(9, 204, 5, 'yes', 'FullTime', 'Yes', 'no', '2023-08-07', '2030-12-31', 1, '2023-08-04 10:02:07', '2023-08-04 10:02:07', 1),
(10, 205, 5, 'yes', 'FullTime', 'Yes', 'no', '2023-08-07', '2030-12-31', 1, '2023-08-07 16:23:32', '2023-08-07 16:23:32', 1),
(11, 206, 5, 'yes', 'FullTime', 'Yes', 'no', '2023-08-07', '2030-12-31', 1, '2023-08-07 17:06:45', '2023-08-07 17:06:45', 1),
(12, 207, 5, 'yes', 'FullTime', 'Yes', 'no', '2023-08-08', '2024-03-31', 1, '2023-08-08 05:50:44', '2023-08-08 05:50:44', 1),
(13, 208, 5, 'yes', 'FullTime', 'Yes', 'no', '2023-08-11', '2030-12-31', 1, '2023-08-09 06:16:14', '2023-08-09 06:16:14', 1),
(14, 209, 5, 'yes', 'FullTime', 'Yes', 'no', '2023-08-11', '2030-12-31', 1, '2023-08-11 07:44:07', '2023-08-11 07:44:07', 1),
(15, 205, 6, 'no', 'Part Time', 'No', 'no', '2023-10-18', '2023-10-31', 1, '2023-10-21 06:03:57', '2023-10-21 06:03:57', 1),
(16, 210, 5, 'yes', 'FullTime', 'Yes', 'no', '2023-10-04', '2030-12-31', 1, '2023-10-24 12:10:47', '2023-10-24 12:10:47', 1),
(17, 211, 7, 'yes', 'FullTime', 'Yes', 'no', '2023-11-01', '2023-11-23', 1, '2023-10-26 07:03:03', '2023-10-26 07:03:03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tech_feedback`
--

CREATE TABLE `tech_feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `can_id` int(20) UNSIGNED NOT NULL,
  `job_id` int(20) UNSIGNED NOT NULL,
  `round` varchar(100) NOT NULL,
  `skill_detail` longtext NOT NULL,
  `overall_comment` longtext NOT NULL,
  `can_image` varchar(200) DEFAULT NULL,
  `schedule_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tech_feedback`
--

INSERT INTO `tech_feedback` (`id`, `can_id`, `job_id`, `round`, `skill_detail`, `overall_comment`, `can_image`, `schedule_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'round_2', '[1,2]', 'Selected', NULL, 535, '2023-08-01 06:36:54', '2023-08-01 06:36:54'),
(2, 2, 1, 'round_2', '[3,4]', 'Selected', NULL, 538, '2023-08-02 11:13:07', '2023-08-02 11:13:07'),
(3, 3, 1, 'round_2', '[5,6]', 'selected', NULL, 541, '2023-08-03 08:00:33', '2023-08-03 08:00:33'),
(4, 4, 1, 'round_2', '[7,8]', 'selected', NULL, 544, '2023-08-03 08:27:18', '2023-08-03 08:27:18'),
(5, 5, 1, 'round_2', '[9,10]', 'Selected', NULL, 547, '2023-08-04 09:44:51', '2023-08-04 09:44:51'),
(6, 6, 1, 'round_2', '[11,12]', 'selected', NULL, 550, '2023-08-04 13:27:56', '2023-08-04 13:27:56'),
(7, 7, 1, 'round_2', '[13,14]', 'selected', NULL, 552, '2023-08-07 16:40:24', '2023-08-07 16:40:24'),
(8, 8, 1, 'round_2', '[15,16]', 'selected', NULL, 555, '2023-08-09 06:09:15', '2023-08-09 06:09:15'),
(9, 9, 1, 'round_2', '[17,18]', 'Selected', NULL, 558, '2023-08-11 07:35:16', '2023-08-11 07:35:16'),
(10, 12, 2, 'round_2', '[19,20,21]', 'good', '1698300355.jpg', 561, '2023-10-26 06:05:55', '2023-10-26 06:05:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `update_by` bigint(20) DEFAULT NULL,
  `employee_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `res_address` text COLLATE utf8mb4_unicode_ci,
  `res_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `res_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `res_postal_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `per_address` text COLLATE utf8mb4_unicode_ci,
  `per_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `per_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `per_postal_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dependency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dependency_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `higest_qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_status` tinyint(1) DEFAULT NULL,
  `aadhar_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `previous_employer` text COLLATE utf8mb4_unicode_ci,
  `hobbies` text COLLATE utf8mb4_unicode_ci,
  `skill_set` text COLLATE utf8mb4_unicode_ci,
  `exit_date` date DEFAULT NULL,
  `maternity_leave` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'OFF',
  `ml_from_date` date DEFAULT NULL,
  `ml_to_date` date DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_role` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation_id` int(10) UNSIGNED NOT NULL,
  `image_path` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_contact` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_change_at` timestamp NULL DEFAULT NULL,
  `last_login_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `created_at`, `updated_at`, `update_by`, `employee_code`, `middle_name`, `last_name`, `joining_date`, `birth_date`, `gender`, `marital_status`, `phone_number`, `res_address`, `res_city`, `res_state`, `res_postal_code`, `per_address`, `per_city`, `per_state`, `per_postal_code`, `nationality`, `dependency`, `dependency_name`, `higest_qualification`, `employee_status`, `aadhar_number`, `pan_number`, `experience`, `previous_employer`, `hobbies`, `skill_set`, `exit_date`, `maternity_leave`, `ml_from_date`, `ml_to_date`, `last_login`, `role`, `sub_role`, `designation_id`, `image_path`, `emergency_contact`, `password_change_at`, `last_login_time`) VALUES
(27, 'RAVI RAMU', 'raviramu@swordgroup.in', NULL, '$2y$10$NeoHKhUSCnIwpGL3Gnpaked7XSuomkQEGhAwZZ25vzDVZ6e9iyTrm', NULL, NULL, NULL, '0000-00-00 00:00:00', '2023-11-03 10:08:06', NULL, 's1', NULL, 'M', '2023-02-01', '0000-00-00', 'Male', ' ', ' ', ' ', ' ', ' ', '600115', ' ', ' ', ' ', '600115', ' ', ' ', ' ', ' ', 1, ' ', ' ', ' ', NULL, NULL, ' ', '2042-05-26', ' ', NULL, NULL, NULL, 'super_admin', NULL, 11, 'default.jpg', '12', '2022-06-02 18:06:52', '2023-11-03 15:38:06'),
(38, 'JUDI PREETHI', 'judipreethi.johnpeter@swordgroup.in', NULL, '$2y$10$v7XgWQePIs.03hxRy0T3xuUFTEgXef7.Z8B9oWg73jjNE1F0VhOGC', NULL, NULL, NULL, '0000-00-00 00:00:00', '2023-10-24 12:25:38', NULL, 's11', NULL, 'J', '2023-02-02', '0000-00-00', ' ', ' ', ' ', ' ', ' ', ' ', '600076', ' ', ' ', ' ', '600076', ' ', ' ', ' ', ' ', 1, ' ', ' ', '0', NULL, NULL, 'XYZ', '2042-05-26', 'OFF', NULL, NULL, NULL, 'employee', NULL, 23, 'default.jpg', '123', '2022-06-02 18:25:17', '2023-10-24 17:55:38'),
(44, 'SIVAKUMAR CHANDRAN', 'sivakumar.c@swordgroup.in', NULL, '$2y$10$f96K/87KPwxcJGhJBPqoeu.nsNccFC.a.308T06fZ0lBNCGLKmCg2', NULL, NULL, NULL, '2022-06-08 13:47:09', '2023-07-01 02:30:01', NULL, 's2', NULL, 'C', '2023-02-01', '0000-00-00', 'Male', ' ', ' ', ' ', ' ', ' ', '600089', ' ', ' ', ' ', '600089', ' ', ' ', ' ', 'XYZ', 1, ' ', ' ', ' ', NULL, NULL, 'XYZ', '2042-06-08', 'OFF', NULL, NULL, NULL, 'super_admin', NULL, 8, 'default.jpg', '123', '2022-07-01 19:49:18', '2023-06-30 19:30:01'),
(118, 'BALAKRISHNAN SUBBURAMAN', 'balakrishnan.subburaman@swordgroup.in', NULL, '$2y$10$NeoHKhUSCnIwpGL3Gnpaked7XSuomkQEGhAwZZ25vzDVZ6e9iyTrm', NULL, NULL, NULL, '0000-00-00 00:00:00', '2023-10-26 05:55:01', NULL, 's3', NULL, 'S', '2023-02-01', '0000-00-00', ' ', ' ', ' ', ' ', ' ', 'Tamil Nadu', '600088', ' ', ' ', ' ', '600088', 'Indian', ' ', ' ', 'XYZ', 1, ' ', ' ', '0', NULL, NULL, 'XYZ', '2042-06-26', 'OFF', NULL, NULL, NULL, 'employee', 'hr', 33, 'default.jpg', '123', '2022-07-02 01:09:44', '2023-10-26 11:25:01'),
(195, 'Naresh', 'naresh@s.com', NULL, '$2y$10$NeoHKhUSCnIwpGL3Gnpaked7XSuomkQEGhAwZZ25vzDVZ6e9iyTrm', NULL, NULL, NULL, '2023-08-01 06:47:35', '2023-08-01 07:28:17', 27, 'E001', NULL, 'N', '2023-08-04', '1990-08-21', 'Male', 'Single', '8988998800', 'Chennai', 'Chennai', 'TN', '600000', 'Chennai', 'Chennai', 'TN', '600000', 'Indian', 'Father', 'Naren', 'BE', 1, '000099998888', 'ASDF001', '5', NULL, NULL, 'JAVA', '2043-08-01', NULL, NULL, NULL, NULL, 'employee', NULL, 23, '1690872455.png', '8988998800', NULL, NULL),
(196, 'Divya', 'divya@s.com', NULL, '$2y$10$NeoHKhUSCnIwpGL3Gnpaked7XSuomkQEGhAwZZ25vzDVZ6e9iyTrm', NULL, NULL, NULL, '2023-08-02 11:25:08', '2023-08-03 06:39:00', 27, 'E002', NULL, NULL, '2023-08-04', '2004-04-05', 'Female', 'Single', '7788990089', 'Chennai', 'Chennai', 'TN', '600000', 'Chennai', 'Chennai', 'TN', '600000', 'Indian', 'Father', 'XYZ', 'BE', 1, '123456789', 'asasas', '5', NULL, NULL, 'JAVA', '2043-08-02', NULL, NULL, NULL, NULL, 'employee', NULL, 23, '1690975508.jpg', '7788990089', NULL, '2023-08-03 12:09:00'),
(197, 'JESSY', 'jessy@s.com', NULL, '$2y$10$C1o11aaaO3v/vY0IgzE3IeS106wGYW2Te5.yjOBq5I7YpcqgGgoLy', NULL, NULL, NULL, '2023-08-03 08:09:09', '2023-10-24 13:02:05', 27, 'E003', '', 'MARY', '2023-08-04', '2004-05-19', 'Female', 'Married', '9900890789', 'Chennai', 'Chennai', 'TN', '600000', 'Chennai', 'Chennai', 'TN', '600000', 'Indian', 'Father', 'Jose', 'BE', 0, '5767888787', 'sdfghj789', '5', NULL, NULL, 'JAVA', '2023-10-24', NULL, NULL, NULL, NULL, 'employee', NULL, 14, '1691050149.jpg', '9900890789', '2023-08-03 08:12:13', '2023-08-03 13:42:00'),
(198, 'Ram', 'ram@s.com', NULL, '$2y$10$0j9nyovP55EVV0yJ4NraoOqm2dRYh0DWpzWrMLVn5XqyNBO7k20ci', NULL, NULL, NULL, '2023-08-03 08:32:33', '2023-08-03 08:37:29', 27, 'E004', NULL, NULL, '2023-08-03', '1993-08-18', 'Male', 'Married', '6789890000', 'Chennai', 'Chennai', 'TN', '600000', 'Chennai', 'Chennai', 'TN', '600000', 'Indian', 'Father', 'Ravindren', 'BE', 1, '12435454545454', 'sdfgrty', '5', NULL, NULL, 'JAVA', '2043-08-03', NULL, NULL, NULL, NULL, 'employee', NULL, 14, '1691051553.jpg', '6789890000', '2023-08-03 08:37:29', '2023-08-03 14:07:13'),
(199, 'Deepika', 'deepika@s.com', NULL, '$2y$10$0bQoimrTsIs3D90EyNq5QOZ7IOm.bolE.4K1.nKEQAbVsdZmfsv66', NULL, NULL, NULL, '2023-08-03 10:31:32', '2023-08-03 10:31:32', NULL, 'E005', NULL, NULL, '2023-08-03', '1991-04-12', 'Male', 'Married', '6789009900', 'Chennai', 'Chennai', 'TN', '600000', 'Chennai', 'Chennai', 'TN', '600000', 'Indian', 'Father', 'Natrajan', 'XYZ', 1, '12345678900000', 'vsvd55656', '5.5', NULL, NULL, 'BDDW', '2043-08-03', 'OFF', NULL, NULL, NULL, 'employee', NULL, 14, '1691058692.jpg', '6789009900', NULL, NULL),
(200, 'Naresh', NULL, NULL, '$2y$10$2qaJ42L3A28qee8krtQvIONF0r4z44npQRFwdn.hsQLD1SH./holm', NULL, NULL, NULL, '2023-08-04 07:43:05', '2023-08-04 07:43:05', NULL, NULL, NULL, NULL, '2023-08-04', '1990-08-21', 'Male', 'Single', '8988998358', 'Chennai', 'Chennai', 'tn', '123456', 'Chennai', 'Chennai', 'tn', '123456', 'Indian', 'Father', 'wesd', 'BE', 1, '678', '986', '5', 'CTS', NULL, 'JAVA', '2043-08-04', 'OFF', NULL, NULL, NULL, 'employee', NULL, 3, '1691134985.jpg', '7534861258', NULL, NULL),
(203, 'Naresh', NULL, NULL, '$2y$10$oo23z8EXWs8rUcmRhjNhae1btErMZvsjtkp01JeAjNW3nkWdNXAuW', NULL, NULL, NULL, '2023-08-04 07:48:25', '2023-08-04 07:48:25', NULL, NULL, NULL, NULL, '2023-08-04', '1990-08-21', 'Male', 'Single', '8988998375', 'Chennai', 'Chennai', 'tn', '123456', 'Chennai', 'Chennai', 'tn', '123456', 'Indian', 'Father', 'wesd', 'BE', 1, '6789', '9866', '5', 'CTS', NULL, 'JAVA', '2043-08-04', 'OFF', NULL, NULL, NULL, 'employee', NULL, 3, '1691135305.jpg', '7534861269', NULL, NULL),
(204, 'Dona', 'dona@s.com', NULL, '$2y$10$trloHp9BdFHSeFD9gByv5Ozt8iYypYtmGbQVlNhoZ7kXnI3X6W0Yy', NULL, NULL, NULL, '2023-08-04 09:59:10', '2023-08-04 10:05:43', 27, 'E006', NULL, NULL, '2023-08-07', '1995-05-10', 'Female', 'Single', '8899001234', 'Kerala', 'Kerala', 'Kerala', '700000', 'Kerala', 'Kerala', 'Kerala', '700000', 'Indian', 'Father', 'David', 'BE', 1, '456788656454', 'xxdx777', '5', 'CTS', NULL, 'React', '2043-08-04', NULL, NULL, NULL, NULL, 'employee', NULL, 14, '1691143150.jpg', '8899001234', NULL, NULL),
(205, 'Barathi', 'barathi@s.com', NULL, '$2y$10$DrSDO4V0TGPQG55Ty.v2N.55j0sdOVh84jNLkc1ZcMgxy2bscBgxK', NULL, NULL, NULL, '2023-08-07 16:22:53', '2023-08-07 17:15:52', 118, 'E007', NULL, NULL, '2023-08-07', '2000-05-06', 'Female', 'Single', '5655667898', 'Chennai', 'Chennai', 'TN', '600000', 'Chennai', 'Chennai', 'TN', '600000', 'Indian', 'Father', 'Bharani', 'BE', 1, '12345677676', 'SDSD0909', '5+ years', 'CTS', NULL, 'JAVA', NULL, NULL, NULL, NULL, NULL, 'employee', NULL, 2, '1691425373.jpg', '5655667898', NULL, '2023-08-07 21:58:57'),
(206, 'Nivetha', 'nive@s.com', NULL, '$2y$10$vKnfCI63gjmaVObljFLyXO60NeJQAXovDZ0yY/4PiJzu1bnpgLM.q', NULL, NULL, NULL, '2023-08-07 17:05:59', '2023-08-07 17:26:20', 27, 'E008', NULL, NULL, '2023-08-11', '1990-05-16', 'Female', 'Married', '9900789090', 'Chennai', 'Chennai', 'TN', '600000', 'Chennai', 'Chennai', 'TN', '600000', 'Indian', 'Father', 'Nagaraj', 'BE', 1, '76756455454', 'DSDSD098', '5+ years', 'TCS', NULL, 'JAVA', NULL, NULL, NULL, NULL, NULL, 'employee', NULL, 19, '1691427959.jpg', '9900789090', NULL, NULL),
(207, 'Naresh1', NULL, NULL, '$2y$10$8DmCXSkGwNqngd929gzHg..MF3iaLWwipVrhfM5/73AyOpKqWMvci', NULL, NULL, NULL, '2023-08-08 05:46:56', '2023-08-08 05:46:56', NULL, NULL, 'test', NULL, '2023-08-04', '1990-08-21', 'Male', 'Married', '8988998758', 'Chennai', 'Chennai', 'tn', '456789', 'Chennai', 'Chennai', 'tn', '456789', 'Indian', 'Father', 'tesd', 'BE', 1, '4568', '865f', '5', 'CTS', NULL, 'JAVA', '2043-08-08', 'OFF', NULL, NULL, NULL, 'employee', NULL, 4, '1691473616.jpg', '9654784125', NULL, NULL),
(208, 'Kevin', 'kevin@s.com', NULL, '$2y$10$drETQR9PvW/xQudL2srsq.GKvgVc.y8cXlFjomdLU5MEWhJPJjhdG', NULL, NULL, NULL, '2023-08-09 06:14:56', '2023-08-09 06:21:11', 27, 'E009', NULL, NULL, '2023-08-11', '1999-05-12', 'Male', 'Single', '5678990987', 'Chennai', 'Chennai', 'TN', '600000', 'Chennai', 'Chennai', 'TN', '600000', 'Indian', 'Father', 'Karun', 'BE', 1, '1265656565656', 'SDS23232', '7', 'Infosys', NULL, 'Dotnet', '2043-08-09', NULL, NULL, NULL, NULL, 'employee', NULL, 2, '1691561696.png', '5678990987', '2023-08-09 06:21:11', '2023-08-09 11:50:52'),
(209, 'Ganesh', 'ganesh@s.com', NULL, '$2y$10$8G1pE.u49vwrLpn9ss0DCu/EZGnZieoQyk5jqR0JjsnE2yeJkeJ1i', NULL, NULL, NULL, '2023-08-11 07:40:10', '2023-08-11 07:46:50', 27, 'E0011', NULL, NULL, '2023-08-14', '1997-02-05', 'Male', 'Single', '6788990000', 'Chennai', 'Chennai', 'TN', '600000', 'Chennai', 'Chennai', 'TN', '600000', 'Indian', 'Father', 'Girish', 'BE', 1, '9988877777', 'SDSD89898', '5', 'CTS', NULL, 'JAVA', '2043-08-11', NULL, NULL, NULL, NULL, 'employee', NULL, 14, '1691739610.png', '6788990000', '2023-08-11 07:46:50', '2023-08-11 13:16:37'),
(210, 'JEGAN', 'jegan@s.com', NULL, '$2y$10$oF4CQ50uiJjJF60d6VjTw.1iz0DAIwVKloRQkIIHkAzb67p.aAx3O', NULL, NULL, NULL, '2023-10-24 12:09:38', '2023-10-24 12:09:38', NULL, 'E0012', '', 'RAJ', '2023-10-03', '1991-01-11', 'Female', 'Single', '8890907890', 'Chennai', 'Chennai', 'Tamil Nadu', '600000', 'Chennai', 'Chennai', 'Tamil Nadu', '600000', 'Indian', 'Father', 'Raj', 'BE', 1, '890977778907', 'SDF556', '5', NULL, NULL, 'Dot Net', '2043-10-24', 'OFF', NULL, NULL, NULL, 'employee', NULL, 14, '1698149378.png', '8890907890', NULL, NULL),
(211, 'SAM', NULL, NULL, '$2y$10$XbsSnxgcMv61cp5tI9aYPevxQBaafybqHHaMF1GtQoCXa8OubYipG', NULL, NULL, NULL, '2023-10-26 07:02:19', '2023-10-26 07:03:25', 118, NULL, 'S', 'S', '2023-10-26', '1971-08-25', 'Male', 'Married', '7589421365', 'chaledarasdd', 'chennai', 'Tail Nadu', '456789', 'chaledarasdd', 'chennai', 'Tail Nadu', '456789', 'Indian', 'Father', 'ter', 'qwe', 1, '54687', '75846', '12', 'asdasd', 'asd', 'asdasd', NULL, NULL, NULL, NULL, NULL, 'employee', NULL, 3, '1698303738.jpg', '4875698213', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `week_days`
--

CREATE TABLE `week_days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dayValue` int(11) NOT NULL,
  `dayName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `week_days`
--

INSERT INTO `week_days` (`id`, `dayValue`, `dayName`, `created_at`, `updated_at`) VALUES
(1, 0, 'Sunday', NULL, NULL),
(2, 1, 'Monday', NULL, NULL),
(3, 2, 'Tuesday', NULL, NULL),
(4, 3, 'Wednesday', NULL, NULL),
(5, 4, 'Thursday', NULL, NULL),
(6, 5, 'Friday', NULL, NULL),
(7, 6, 'Saturday', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `working_days`
--

CREATE TABLE `working_days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `day` int(11) NOT NULL,
  `fullDay` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `working_days`
--

INSERT INTO `working_days` (`id`, `day`, `fullDay`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 1, NULL, NULL),
(5, 5, 1, NULL, NULL);

--
-- Indexes for dumped tables
--
CREATE TABLE `likes_comments` (
   `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
 `announcements_id` bigint(20) UNSIGNED NOT NULL,
 `comments` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `like` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_user_id_foreign` (`user_id`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `recruiter_id` (`recruiter_name`),
  ADD KEY `consultancy_id` (`consultancy_id`);

--
-- Indexes for table `common_feedback`
--
ALTER TABLE `common_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interviewer_id` (`interviewer`),
  ADD KEY `candidateid` (`can_id`),
  ADD KEY `jj` (`job_id`);

--
-- Indexes for table `consultancy`
--
ALTER TABLE `consultancy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `consultancy_email_unique` (`email`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_user_id_foreign` (`user_id`);

--
-- Indexes for table `holidaymodels`
--
ALTER TABLE `holidaymodels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `holidaymodels_holidaydate_unique` (`holidaydate`);

--
-- Indexes for table `hr_questionnaire`
--
ALTER TABLE `hr_questionnaire`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interview_rounds`
--
ALTER TABLE `interview_rounds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_type_id` (`job_type_id`),
  ADD KEY `user_id` (`job_owner`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `position_id` (`position_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `jobs_users`
--
ALTER TABLE `jobs_users`
  ADD KEY `jobs_id_foreign` (`jobs_id`),
  ADD KEY `user_id_foreign` (`users_id`);

--
-- Indexes for table `job_interview`
--
ALTER TABLE `job_interview`
  ADD PRIMARY KEY (`id`),
  ADD KEY `positionid` (`job_id`),
  ADD KEY `canid` (`can_id`);

--
-- Indexes for table `job_offer`
--
ALTER TABLE `job_offer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_offer_job_id` (`job_id`),
  ADD KEY `job_offer_can_id` (`can_id`);

--
-- Indexes for table `job_positions`
--
ALTER TABLE `job_positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_schedule`
--
ALTER TABLE `job_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_foreign` (`can_id`),
  ADD KEY `interviewer_foreign` (`interviewer_id`),
  ADD KEY `job_foreign` (`job_id`);

--
-- Indexes for table `job_types`
--
ALTER TABLE `job_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_applications_user_id_foreign` (`user_id`),
  ADD KEY `leave_applications_leave_type_id_foreign` (`leave_type_id`);

--
-- Indexes for table `leave_entitlements`
--
ALTER TABLE `leave_entitlements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_entitlements_user_id_foreign` (`user_id`),
  ADD KEY `leave_entitlements_leave_type_id_foreign` (`leave_type_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `months`
--
ALTER TABLE `months`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `projectmasters`
--
ALTER TABLE `projectmasters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projectmasters_user_id_foreign` (`user_id`);

--
-- Indexes for table `skillsets`
--
ALTER TABLE `skillsets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skill_feedback`
--
ALTER TABLE `skill_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table1_seq`
--
ALTER TABLE `table1_seq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_allocations`
--
ALTER TABLE `team_allocations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_allocations_user_id_foreign` (`user_id`),
  ADD KEY `team_allocations_project_id_foreign` (`project_id`);

--
-- Indexes for table `tech_feedback`
--
ALTER TABLE `tech_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `design_id` (`designation_id`);

--
-- Indexes for table `week_days`
--
ALTER TABLE `week_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `working_days`
--
ALTER TABLE `working_days`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `common_feedback`
--
ALTER TABLE `common_feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `consultancy`
--
ALTER TABLE `consultancy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidaymodels`
--
ALTER TABLE `holidaymodels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `hr_questionnaire`
--
ALTER TABLE `hr_questionnaire`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `interview_rounds`
--
ALTER TABLE `interview_rounds`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_interview`
--
ALTER TABLE `job_interview`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=996;

--
-- AUTO_INCREMENT for table `job_offer`
--
ALTER TABLE `job_offer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `job_positions`
--
ALTER TABLE `job_positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_schedule`
--
ALTER TABLE `job_schedule`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=563;

--
-- AUTO_INCREMENT for table `job_types`
--
ALTER TABLE `job_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leave_applications`
--
ALTER TABLE `leave_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `leave_entitlements`
--
ALTER TABLE `leave_entitlements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `months`
--
ALTER TABLE `months`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projectmasters`
--
ALTER TABLE `projectmasters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `skillsets`
--
ALTER TABLE `skillsets`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `skill_feedback`
--
ALTER TABLE `skill_feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `table1_seq`
--
ALTER TABLE `table1_seq`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `team_allocations`
--
ALTER TABLE `team_allocations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tech_feedback`
--
ALTER TABLE `tech_feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `week_days`
--
ALTER TABLE `week_days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `working_days`
--
ALTER TABLE `working_days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `consultancy_id` FOREIGN KEY (`consultancy_id`) REFERENCES `consultancy` (`id`),
  ADD CONSTRAINT `job_id` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`),
  ADD CONSTRAINT `recruiter_id` FOREIGN KEY (`recruiter_name`) REFERENCES `users` (`id`);

--
-- Constraints for table `common_feedback`
--
ALTER TABLE `common_feedback`
  ADD CONSTRAINT `candidateid` FOREIGN KEY (`can_id`) REFERENCES `candidates` (`id`),
  ADD CONSTRAINT `interviewer_id` FOREIGN KEY (`interviewer`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jj` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `job_type_id` FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`id`),
  ADD CONSTRAINT `position_id` FOREIGN KEY (`position_id`) REFERENCES `job_positions` (`id`),
  ADD CONSTRAINT `project_id` FOREIGN KEY (`project_id`) REFERENCES `projectmasters` (`id`),
  ADD CONSTRAINT `updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`job_owner`) REFERENCES `users` (`id`);

--
-- Constraints for table `jobs_users`
--
ALTER TABLE `jobs_users`
  ADD CONSTRAINT `jobs_id_foreign` FOREIGN KEY (`jobs_id`) REFERENCES `jobs` (`id`),
  ADD CONSTRAINT `user_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `job_interview`
--
ALTER TABLE `job_interview`
  ADD CONSTRAINT `canid` FOREIGN KEY (`can_id`) REFERENCES `candidates` (`id`),
  ADD CONSTRAINT `jobid` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);

--
-- Constraints for table `job_offer`
--
ALTER TABLE `job_offer`
  ADD CONSTRAINT `job_offer_can_id` FOREIGN KEY (`can_id`) REFERENCES `candidates` (`id`),
  ADD CONSTRAINT `job_offer_job_id` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);

--
-- Constraints for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD CONSTRAINT `leave_applications_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`),
  ADD CONSTRAINT `leave_applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
