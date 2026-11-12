-- ============================================================
-- Auro Moon Residency - Complete Database Schema
-- Database Name: auromoonresidency_db
-- Compatible with MySQL 5.7+ / MariaDB 10.4+ / phpMyAdmin
-- Generated for Auro Moon Residency Web Application
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+05:30";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auromoonresidency_db`
--
CREATE DATABASE IF NOT EXISTS `auromoonresidency_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `auromoonresidency_db`;

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
-- Used for Admin portal authentication (login.php & forgot-password.php)
--
DROP TABLE IF EXISTS `tbladmin`;
CREATE TABLE `tbladmin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(100) NOT NULL DEFAULT 'Administrator',
  `admin_email` varchar(150) NOT NULL,
  `admin_pwd` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_admin_email` (`admin_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping sample data for table `tbladmin`
-- Default credentials:
-- Email: admin@auromoonresidency.com | Password: password123
-- Email: aahaserenitystays@gmail.com | Password: password123
--
INSERT INTO `tbladmin` (`id`, `admin_name`, `admin_email`, `admin_pwd`, `created_at`) VALUES
(1, 'Auro Moon Admin', 'admin@auromoonresidency.com', 'password123', '2026-01-01 00:00:00'),
(2, 'Serenity Host', 'aahaserenitystays@gmail.com', 'password123', '2026-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
-- Used for Room/Property Booking Requests & Reservations
-- Managed in: BookingPage.php, Admin.php, Booked.php, fetch.php, Calendar.php
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `mobnumber` varchar(25) NOT NULL,
  `email` varchar(150) NOT NULL,
  `aadhrno` varchar(100) DEFAULT NULL COMMENT 'ID proof detail or guest summary',
  `aadhaar_pdf` varchar(255) DEFAULT NULL COMMENT 'Uploaded ID PDF file path',
  `checkin` date NOT NULL,
  `checkout` date NOT NULL,
  `notes` text DEFAULT NULL,
  `request_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Pending Request, 1: Confirmed/Booked',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_request_status` (`request_status`),
  KEY `idx_checkin_checkout` (`checkin`,`checkout`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping sample data for table `users` (Initial demo bookings)
--
INSERT INTO `users` (`id`, `name`, `mobnumber`, `email`, `aadhrno`, `aadhaar_pdf`, `checkin`, `checkout`, `notes`, `request_status`, `created_at`) VALUES
(1, 'Sample Guest', '9876543210', 'guest@example.com', 'Entire Property (6-12 Guests)', NULL, '2026-11-20', '2026-11-23', 'Rooms are Booked', 1, current_timestamp());

-- --------------------------------------------------------

--
-- Table structure for table `contact_submissions`
-- Used for "Contact Us" inquiries from contact-us.php & contactBackend.php
-- Managed in: ContactSubmissions.php, fetch.php
--
DROP TABLE IF EXISTS `contact_submissions`;
CREATE TABLE `contact_submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('pending','read') NOT NULL DEFAULT 'pending',
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `read_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_submitted_at` (`submitted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping sample data for table `contact_submissions`
--
INSERT INTO `contact_submissions` (`id`, `name`, `email`, `phone`, `message`, `status`, `submitted_at`, `read_at`) VALUES
(1, 'Ananya Sharma', 'ananya@example.com', '9876543210', 'Looking to book for 8 family members in December. Could you please confirm availability?', 'pending', current_timestamp(), NULL);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

