-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 08, 2021 at 11:35 PM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ebills`
--

-- --------------------------------------------------------

--
-- Table structure for table `abuja_postpaid_payment_histories`
--

DROP TABLE IF EXISTS `abuja_postpaid_payment_histories`;
CREATE TABLE IF NOT EXISTS `abuja_postpaid_payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transactionNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receipt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchangeReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creditToken` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `responseMessage` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abuja_postpaid_payment_histories`
--

INSERT INTO `abuja_postpaid_payment_histories` (`id`, `transactionNumber`, `amount`, `accountNumber`, `receipt`, `user_id`, `exchangeReference`, `creditToken`, `responseMessage`, `status`, `customerName`, `requestId`, `created_at`, `updated_at`) VALUES
(1, '162863001461240707', '3000', NULL, '1628630014779', '1', '1628630014779', NULL, 'Vending Successful', 'ACCEPTED', 'Abdulfatah', '5495', NULL, NULL),
(2, '162863298618147691', '3000', NULL, '1628632986617', '1', '1628632986617', NULL, 'Vending Successful', 'ACCEPTED', 'Abdulfatah', '4832', NULL, NULL),
(3, '162863317152123120', '3000', NULL, '1628633171909', '2', '1628633171909', NULL, 'Vending Successful', 'ACCEPTED', 'School Administrstor', '5880', NULL, NULL),
(4, '162920120621438630', '3000', NULL, '1629201206738', '1', '1629201206738', NULL, 'Vending Successful', 'ACCEPTED', 'Abdulfatah', '3451', NULL, NULL),
(5, '162920218443571369', '3000', NULL, '1629202185272', '1', '1629202185272', NULL, 'Vending Successful', 'ACCEPTED', 'Abdulfatah', '6481', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `abuja_post_paids`
--

DROP TABLE IF EXISTS `abuja_post_paids`;
CREATE TABLE IF NOT EXISTS `abuja_post_paids` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uniqueCode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerReference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionReference` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionDate` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abuja_post_paids`
--

INSERT INTO `abuja_post_paids` (`id`, `name`, `uniqueCode`, `customerReference`, `phone`, `email`, `message`, `status`, `transactionReference`, `transactionDate`, `amount`, `requestId`, `user_id`, `billerRequestId`, `created_at`, `updated_at`) VALUES
(1, 'Abdulfatah', NULL, '0011234567', '07038085121', '', '', '', '', '', '3000', '19609', '1', NULL, '2021-08-10 18:54:28', '2021-08-10 18:54:28'),
(2, 'Abdulfatah', NULL, '0011234567', '08027618122', '', 'Request successful', 'Success', 'US4S51FWU0OVGMPE', '10-AUG-21 09.57.15.172996 PM', '200', '72741', '1', '6474', '2021-08-10 19:57:22', '2021-08-10 19:57:22'),
(3, 'Abdulfatah', NULL, '0011234567', '08027618122', '', 'Request successful', 'Success', 'E2OTMTP625P89PL7', '10-AUG-21 10.04.11.411719 PM', '3000', '91402', '1', '5639', '2021-08-10 20:04:18', '2021-08-10 20:04:18'),
(4, 'Abdulfatah', NULL, '0011234567', '08027618122', '', 'Request successful', 'Success', 'DAINOI9N2FWKRAHK', '10-AUG-21 10.06.56.798450 PM', '3000', '68250', '1', '1930', '2021-08-10 20:07:04', '2021-08-10 20:07:04'),
(5, 'Abdulfatah', NULL, '0011234567', '08027618122', '', 'Request successful', 'Success', '1Y1V8LJL0JG830I4', '10-AUG-21 11.02.33.632894 PM', '3000', '56059', '1', '4832', '2021-08-10 21:02:39', '2021-08-10 21:02:39'),
(6, 'School Administrstor', NULL, '0011234567', '08027618122', '', 'Request successful', 'Success', '9CSVGU4LPT9HUTYP', '10-AUG-21 11.05.35.392749 PM', '3000', '50447', '2', '5880', '2021-08-10 21:05:41', '2021-08-10 21:05:41'),
(7, 'Abdulfatah', NULL, '04042404139', '08027618122', '', 'Request successful', 'Success', 'W044Y2HLYXB5H3FW', '17-AUG-21 12.52.44.840290 PM', '3000', '94595', '1', '3451', '2021-08-17 10:52:45', '2021-08-17 10:52:45'),
(8, 'Abdulfatah', NULL, '04042404139', '07036712564', '', 'Request successful', 'Success', 'I8WU4X2YL7KQMT9A', '17-AUG-21 01.09.06.847455 PM', '3000', '52825', '1', '6481', '2021-08-17 11:09:07', '2021-08-17 11:09:07'),
(9, 'Abdulfatah', NULL, '0011234567', '07038085121', '', '', '', '', '', '3000', '96096', '1', NULL, '2021-09-01 13:19:20', '2021-09-01 13:19:20'),
(10, 'Abdulfatah', NULL, '0011234567', '07038085121', '', '', '', '', '', '3000', '26618', '1', NULL, '2021-09-01 13:20:08', '2021-09-01 13:20:08'),
(11, 'Abdulfatah', NULL, '0011234567', '07038085121', '', 'Request successful', 'Success', 'IW6LRRJ4JL69QIAJ', '01-SEP-21 03.28.59.476528 PM', '3000', '73392', '1', '6294', '2021-09-01 13:28:58', '2021-09-01 13:28:58'),
(12, 'School Administrstor', NULL, '0011234567', '08126979718', 'user@gmail.com', 'Request successful', 'Success', 'TB6YV7RS32MU6IQP', '02-SEP-21 10.03.12.876872 AM', '6200', '43652', '2', '5573', '2021-09-02 08:03:11', '2021-09-02 08:03:11');

-- --------------------------------------------------------

--
-- Table structure for table `abuja_prepaids`
--

DROP TABLE IF EXISTS `abuja_prepaids`;
CREATE TABLE IF NOT EXISTS `abuja_prepaids` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uniqueCode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abuja_prepaids`
--

INSERT INTO `abuja_prepaids` (`id`, `name`, `uniqueCode`, `message`, `email`, `status`, `transactionReference`, `transactionDate`, `customerReference`, `phone`, `amount`, `requestId`, `user_id`, `billerRequestId`, `created_at`, `updated_at`) VALUES
(1, 'Abdulfatah', NULL, NULL, NULL, NULL, NULL, NULL, '1234567890', '07036712564', '3500', '55201', '1', '5645', '2021-08-10 12:58:25', '2021-08-10 12:58:25'),
(2, 'Abdulfatah', NULL, 'Request successful', NULL, 'Success', 'Y61EODHQ46J906X5', '10-AUG-21 03.30.47.234126 PM', '123456789223', '08027618122', '200', '36331', '1', '1658', '2021-08-10 13:30:53', '2021-08-10 13:30:53'),
(3, 'Abdulfatah', NULL, 'Request successful', NULL, 'Success', '8VLXRRHFW3I1R1TY', '10-AUG-21 03.57.59.645183 PM', '123456789223', '07038085121', '3000', '88022', '1', '2290', '2021-08-10 13:58:06', '2021-08-10 13:58:06'),
(4, 'Abdulfatah', NULL, 'Request successful', NULL, 'Success', '25CH4RE3BTQ9LBUR', '17-AUG-21 12.49.09.692563 PM', '12345678921', '08027618122', '3000', '60584', '1', '4426', '2021-08-17 10:49:10', '2021-08-17 10:49:10'),
(5, 'School Administrstor', NULL, 'Request successful', NULL, 'Failed', 'VVFZJ1LAG7ON2CDQ', '17-AUG-21 09.27.10.935207 PM', '123456789223', '07036712564', '3000', '14749', '2', NULL, '2021-08-17 19:27:11', '2021-08-17 19:27:11'),
(6, 'Abdulfatah', NULL, 'Request successful', NULL, 'Success', '1ME0NXYO2IUDCPMH', '18-AUG-21 09.33.38.359418 AM', '12345678921', '07036712564', '3000', '79575', '1', '7587', '2021-08-18 07:33:39', '2021-08-18 07:33:39'),
(7, 'Abdulfatah', NULL, 'Request successful', NULL, 'Success', 'H69KXE8OWIIAX3BG', '18-AUG-21 09.38.54.304635 AM', '123456789123', '07036712564', '3000', '17291', '1', '7530', '2021-08-18 07:38:55', '2021-08-18 07:38:55'),
(8, 'Abdulfatah', NULL, 'Request successful', 'admin@gmail.com', 'Success', 'M4JBW6ASNIH6LYS7', '01-SEP-21 01.46.04.821468 PM', '123456789123', '08027618122', '3000', '12788', '1', '2844', '2021-09-01 11:46:03', '2021-09-01 11:46:03'),
(9, 'Abdulfatah', NULL, 'Request successful', 'admin@gmail.com', 'Success', 'OI40HCDLCE5HONPE', '01-SEP-21 03.04.42.441527 PM', '123456789123', '08126979718', '3000', '35084', '1', '1538', '2021-09-01 13:04:41', '2021-09-01 13:04:41');

-- --------------------------------------------------------

--
-- Table structure for table `abuja_prepaid_payment_histories`
--

DROP TABLE IF EXISTS `abuja_prepaid_payment_histories`;
CREATE TABLE IF NOT EXISTS `abuja_prepaid_payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transactionNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meterNumber` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchangeReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creditToken` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `responseMessage` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abuja_prepaid_payment_histories`
--

INSERT INTO `abuja_prepaid_payment_histories` (`id`, `transactionNumber`, `amount`, `accountNumber`, `meterNumber`, `user_id`, `receipt`, `exchangeReference`, `creditToken`, `responseMessage`, `status`, `customerName`, `requestId`, `created_at`, `updated_at`) VALUES
(1, '162860711860232685', '200', NULL, '123456789223', '', '1628607119413', '1628607119413', '4753876996', 'Vending Successful', 'ACCEPTED', NULL, '5948', NULL, NULL),
(2, '162860750789058207', '3000', NULL, '123456789223', '1', '1628607508436', '1628607508436', '8063092866', 'Vending Successful', 'ACCEPTED', NULL, '2290', NULL, NULL),
(3, '162920114300831725', '3000', NULL, '12345678921', '1', '1629201143355', '1629201143355', '6019198063', 'Vending Successful', 'ACCEPTED', 'Abdulfatah', '7017', NULL, NULL),
(4, '162927565364423022', '3000', NULL, '12345678921', '1', '1629275654311', '1629275654311', '2318355274', 'Vending Successful', 'ACCEPTED', 'Abdulfatah', '7587', NULL, NULL),
(5, '162927600450596203', '3000', NULL, '123456789123', '1', '1629276005218', '1629276005218', '8761762132', 'Vending Successful', 'ACCEPTED', 'Abdulfatah', '7530', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `all_payment_histories`
--

DROP TABLE IF EXISTS `all_payment_histories`;
CREATE TABLE IF NOT EXISTS `all_payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transactionNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionStatus` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smartCard` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `returnMessage` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meterNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `responseMessage` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tokenAmount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dstv_sub_val_id` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creditToken` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchangeReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `standardTokenValue` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debtAmount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `standardTokenAmount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `all_payment_histories`
--

INSERT INTO `all_payment_histories` (`id`, `transactionNumber`, `transactionStatus`, `status`, `amount`, `token`, `smartCard`, `returnMessage`, `accountNumber`, `meterNumber`, `accountId`, `responseMessage`, `tokenAmount`, `dstv_sub_val_id`, `date`, `email`, `creditToken`, `exchangeReference`, `standardTokenValue`, `customerName`, `requestId`, `user_id`, `debtAmount`, `standardTokenAmount`, `created_at`, `updated_at`) VALUES
(1, '163041986433536974', NULL, 'ACCEPTED', '3500', NULL, '2005129242', 'succeeded, smart card 2005129242,mobile phone 0,amount NGN 3500.0,transaction id 3560076130. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-31 14:24:25', 'admin@gmail.com', NULL, NULL, NULL, 'Abdulfatah', '9632', '1', NULL, NULL, NULL, NULL),
(2, '163041991179217379', NULL, 'ACCEPTED', '3500', NULL, '2005129242', 'succeeded, smart card 2005129242,mobile phone 0,amount NGN 3500.0,transaction id 3950515660. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-31 14:25:12', 'admin@gmail.com', NULL, NULL, NULL, 'Abdulfatah', '6397', '1', NULL, NULL, NULL, NULL),
(3, '163041995828235660', NULL, 'ACCEPTED', '3500', NULL, '2005129242', 'succeeded, smart card 2005129242,mobile phone 0,amount NGN 3500.0,transaction id 9575324281. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-31 14:25:58', 'admin@gmail.com', NULL, NULL, NULL, 'Abdulfatah', '2366', '1', NULL, NULL, NULL, NULL),
(4, '163041998803096321', NULL, 'ACCEPTED', '3500', NULL, '2005129242', 'succeeded, smart card 2005129242,mobile phone 0,amount NGN 3500.0,transaction id 0315733546. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-31 14:26:28', 'admin@gmail.com', NULL, NULL, NULL, 'Abdulfatah', '3992', '1', NULL, NULL, NULL, NULL),
(5, '163042002387939333', NULL, 'ACCEPTED', '3500', NULL, '2005129242', 'succeeded, smart card 2005129242,mobile phone 0,amount NGN 3500.0,transaction id 5467347038. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-31 14:27:04', 'admin@gmail.com', NULL, NULL, NULL, 'Abdulfatah', '1174', '1', NULL, NULL, NULL, NULL),
(6, '163042009306765955', NULL, 'ACCEPTED', '3500', NULL, '2005129242', 'succeeded, smart card 2005129242,mobile phone 0,amount NGN 3500.0,transaction id 5241114981. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-31 14:28:13', 'admin@gmail.com', NULL, NULL, NULL, 'Abdulfatah', '2158', '1', NULL, NULL, NULL, NULL),
(7, '163042128663986055', NULL, 'ACCEPTED', '6200', NULL, '2005129242', 'succeeded, smart card 2005129242,mobile phone 0,amount NGN 6200.0,transaction id 6870640012. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-31 14:48:07', 'admin@gmail.com', NULL, '1630421287839', NULL, 'Abdulfatah', '9702', '1', NULL, NULL, NULL, NULL),
(8, '163042394470599427', NULL, 'ACCEPTED', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '1630423944503', '64121517123086594934', 'SUNDAY AGAGARAGA', '5562', '1', NULL, NULL, NULL, NULL),
(9, '163048667650181526', NULL, 'ACCEPTED', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '1630486676837', NULL, 'SUNDAY AGAGARAGA', '1017', '1', NULL, NULL, NULL, NULL),
(10, '163048944946062198', NULL, 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '3012', '1', NULL, NULL, NULL, NULL),
(11, '163049226393698552', NULL, 'ACCEPTED', NULL, '5132 7339 3238 1171', NULL, NULL, NULL, '12345678921', NULL, NULL, NULL, NULL, NULL, '', NULL, '1630492264923', NULL, 'George ', '5057', '1', NULL, NULL, NULL, NULL),
(12, '163049233920821305', NULL, 'ACCEPTED', NULL, '5132 7339 3238 1171', NULL, NULL, NULL, '12345678921', NULL, NULL, NULL, NULL, NULL, '', NULL, '1630492339203', NULL, 'George ', '5444', '1', NULL, NULL, NULL, NULL),
(13, '163049245982395993', NULL, 'ACCEPTED', NULL, '5132 7339 3238 1171', NULL, NULL, NULL, '12345678921', NULL, NULL, NULL, NULL, NULL, '', NULL, '1630492464784', NULL, 'George ', '7581', '1', NULL, NULL, NULL, NULL),
(14, '163049258808780054', NULL, 'ACCEPTED', NULL, '5132 7339 3238 1171', NULL, NULL, NULL, '12345678921', NULL, NULL, NULL, NULL, NULL, '', NULL, '1630492588256', NULL, 'George ', '6690', '1', NULL, NULL, NULL, NULL),
(15, '163049272344340959', NULL, 'ACCEPTED', NULL, '5132 7339 3238 1171', NULL, NULL, NULL, '123456789123', NULL, NULL, NULL, NULL, NULL, '', NULL, '1630492723893', NULL, 'George ', '9648', '1', NULL, NULL, NULL, NULL),
(16, '163049499337359759', NULL, 'ACCEPTED', '6200', NULL, NULL, NULL, '121501004001', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '1630494993399', NULL, 'George Weah', '6558', '1', NULL, NULL, NULL, NULL),
(17, '163050268919272970', NULL, 'ACCEPTED', '3000', NULL, NULL, NULL, NULL, '123456789123', NULL, 'Vending Successful', NULL, NULL, NULL, 'admin@gmail.com', '9152699766', '1630502689843', NULL, 'Abdulfatah', '2844', '1', NULL, NULL, NULL, NULL),
(18, '163050274534179455', NULL, 'ACCEPTED', '3000', NULL, NULL, NULL, NULL, '123456789123', NULL, 'Vending Successful', NULL, NULL, NULL, 'admin@gmail.com', '7579725017', '1630502745315', NULL, 'Abdulfatah', '2419', '1', NULL, NULL, NULL, NULL),
(19, '163050278441277814', NULL, 'ACCEPTED', '3000', NULL, NULL, NULL, NULL, '123456789123', NULL, 'Vending Successful', NULL, NULL, NULL, 'admin@gmail.com', '4770737202', '1630502784681', NULL, 'Abdulfatah', '5987', '1', NULL, NULL, NULL, NULL),
(20, '163050282915932444', NULL, 'ACCEPTED', '3000', NULL, NULL, NULL, NULL, '123456789123', NULL, 'Vending Successful', NULL, NULL, NULL, 'admin@gmail.com', '2743331651', '1630502829669', NULL, 'Abdulfatah', '4086', '1', NULL, NULL, NULL, NULL),
(21, '163050291835823873', NULL, 'ACCEPTED', '3000', NULL, NULL, NULL, NULL, '123456789123', NULL, 'Vending Successful', NULL, NULL, NULL, 'admin@gmail.com', '2429677097', '1630502918861', NULL, 'Abdulfatah', '6865', '1', NULL, NULL, NULL, NULL),
(22, '163050297087493285', NULL, 'ACCEPTED', NULL, '5132 7339 3238 1171', NULL, NULL, NULL, '12345678921', NULL, NULL, NULL, NULL, NULL, 'admin@gmail.com', NULL, '1630502971833', NULL, 'George ', '1503', '1', NULL, NULL, NULL, NULL),
(23, '163050311940951194', NULL, 'ACCEPTED', NULL, '5132 7339 3238 1171', NULL, NULL, NULL, '123456789223', NULL, NULL, NULL, NULL, NULL, 'admin@gmail.com', NULL, '1630503119212', NULL, 'George ', '4605', '1', NULL, NULL, NULL, NULL),
(24, '163050404509150059', NULL, 'ACCEPTED', NULL, '5132 7339 3238 1171', NULL, NULL, NULL, '12345678921', NULL, NULL, NULL, NULL, NULL, 'admin@gmail.com', NULL, '1630504045528', NULL, 'George ', '2522', '1', NULL, NULL, NULL, NULL),
(25, '163050512017471733', NULL, 'ACCEPTED', '3000', NULL, NULL, NULL, NULL, '123456789123', NULL, 'Vending Successful', NULL, NULL, NULL, 'admin@gmail.com', '3597237273', '1630505120432', NULL, 'Abdulfatah', '1538', '1', NULL, NULL, NULL, NULL),
(26, '163050874796086565', NULL, 'ACCEPTED', '3000', NULL, NULL, NULL, '0011234567', NULL, NULL, 'Vending Successful', NULL, NULL, NULL, '', NULL, '1630508748334', NULL, 'Abdulfatah', '8779', '1', NULL, NULL, NULL, NULL),
(27, '163050881141375410', NULL, 'ACCEPTED', '3000', NULL, NULL, NULL, '0011234567', NULL, NULL, 'Vending Successful', NULL, NULL, NULL, '', NULL, '1630508811654', NULL, 'Abdulfatah', '2748', '1', NULL, NULL, NULL, NULL),
(28, '163050887917790431', NULL, 'ACCEPTED', '3000', NULL, NULL, NULL, '0011234567', NULL, NULL, 'Vending Successful', NULL, NULL, NULL, '', NULL, '1630508879302', NULL, 'Abdulfatah', '8895', '1', NULL, NULL, NULL, NULL),
(29, '163050892460955313', NULL, 'ACCEPTED', '3000', NULL, NULL, NULL, '0011234567', NULL, NULL, 'Vending Successful', NULL, NULL, NULL, '', NULL, '1630508924660', NULL, 'Abdulfatah', '9195', '1', NULL, NULL, NULL, NULL),
(30, '163050895754137872', NULL, 'ACCEPTED', '3000', NULL, NULL, NULL, '0011234567', NULL, NULL, 'Vending Successful', NULL, NULL, NULL, '', NULL, '1630508957948', NULL, 'Abdulfatah', '8223', '1', NULL, NULL, NULL, NULL),
(31, '163050897409096995', NULL, 'ACCEPTED', '3000', NULL, NULL, NULL, '0011234567', NULL, NULL, 'Vending Successful', NULL, NULL, NULL, '', NULL, '1630508974226', NULL, 'Abdulfatah', '6071', '1', NULL, NULL, NULL, NULL),
(32, '163057342482140730', NULL, 'ACCEPTED', '6200', NULL, NULL, NULL, '0011234567', NULL, NULL, 'Vending Successful', NULL, NULL, NULL, 'user@gmail.com', NULL, '1630573425611', NULL, 'School Administrstor', '5573', '2', NULL, NULL, NULL, NULL),
(33, '163057477587128346', NULL, 'ACCEPTED', '3000', NULL, NULL, NULL, NULL, '123456789223', NULL, NULL, '3000', NULL, '2021-09-02 09:26:16', 'user@gmail.com', '46496513106501895342', '1630574776785', NULL, 'TESTMETER1', '3013', '2', NULL, NULL, NULL, NULL),
(34, '163057954533698767', NULL, 'ACCEPTED', '6200', NULL, NULL, NULL, NULL, '1234567890', NULL, NULL, '6200', NULL, '2021-09-02 10:45:46', 'user@gmail.com', '81027019784664687608', '1630579545989', NULL, 'TESTMETER1', '8973', '2', NULL, NULL, NULL, NULL),
(35, '163058074994569695', NULL, 'ACCEPTED', '10000', NULL, NULL, NULL, '121501004001', NULL, NULL, NULL, NULL, NULL, '2021-09-02 11:05:52', 'user@gmail.com', NULL, '1630580751806', NULL, 'NP NGEMA', '1530', '2', NULL, NULL, NULL, NULL),
(36, '163058269520591463', NULL, 'PENDING', NULL, NULL, NULL, NULL, NULL, '54161045569', NULL, NULL, NULL, NULL, NULL, 'user@gmail.com', NULL, NULL, NULL, 'RUKAYYA AUDU', '9534', '2', NULL, NULL, NULL, NULL),
(37, '163058576369052243', NULL, 'PENDING', NULL, NULL, NULL, NULL, NULL, '54161045569', NULL, NULL, NULL, NULL, '2021-09-02 12:29:22', 'user1@gmail.com', NULL, NULL, NULL, 'RUKAYYA AUDU', '4665', '3', NULL, NULL, NULL, NULL),
(38, NULL, NULL, 'PENDING', '1640', NULL, '2005129242', NULL, '31026282', NULL, NULL, NULL, NULL, NULL, '2021-09-02 15:44:16', 'user1@gmail.com', NULL, NULL, NULL, 'Sten Mockett', '5744', '3', NULL, NULL, NULL, NULL),
(39, NULL, NULL, 'PENDING', '2500', NULL, '2005129242', NULL, '33497482', NULL, NULL, NULL, NULL, NULL, '2021-09-02 16:40:43', 'user1@gmail.com', NULL, NULL, NULL, 'Sten Mockett', '9897', '3', NULL, NULL, NULL, NULL),
(40, '163067873693799468', NULL, 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '8373', '2', NULL, NULL, NULL, NULL),
(41, '163067879301288927', NULL, 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '2343', '2', NULL, NULL, NULL, NULL),
(42, '163067896759270264', NULL, 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '7995', '1', NULL, NULL, NULL, NULL),
(43, '163067919765482512', NULL, 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '4146', '1', NULL, NULL, NULL, NULL),
(44, NULL, NULL, 'PENDING', '6200', NULL, '02021486421', NULL, '62373141', NULL, NULL, NULL, NULL, NULL, '2021-09-03 14:30:38', 'admin@gmail.com', NULL, NULL, NULL, 'Sten Mockett', '9847', '1', NULL, NULL, NULL, NULL),
(45, '163067975866460959', NULL, 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '7922', '1', NULL, NULL, NULL, NULL),
(46, NULL, NULL, 'PENDING', '3260', NULL, '4131953321', NULL, '55245111', NULL, NULL, NULL, NULL, NULL, '2021-09-03 15:46:54', 'admin@gmail.com', NULL, NULL, NULL, 'Sten Mockett', '8252', '1', NULL, NULL, NULL, NULL),
(47, NULL, NULL, 'PENDING', '2300', NULL, '02021486421', NULL, '36802801', NULL, NULL, NULL, NULL, NULL, '2021-09-07 15:10:16', 'admin@gmail.com', NULL, NULL, NULL, 'Sten Mockett', '3967', '1', NULL, NULL, NULL, NULL),
(48, '163292288905734141', NULL, 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '7569', '4', NULL, NULL, NULL, NULL),
(49, '163292297701541373', NULL, 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '9449', '4', NULL, NULL, NULL, NULL),
(50, '163292335634423189', NULL, 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '9494', '4', NULL, NULL, NULL, NULL),
(51, '163292356731270198', NULL, 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '1611', '4', NULL, NULL, NULL, NULL),
(52, NULL, NULL, 'PENDING', '2500', NULL, '1234567890', NULL, '78530020', NULL, NULL, NULL, NULL, NULL, '2021-09-29 14:20:04', 'showaa@gmail.com', NULL, NULL, NULL, 'Sten Mockett', '4529', '4', NULL, NULL, NULL, NULL),
(53, '163292556358758462', NULL, 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '5118', '4', NULL, NULL, NULL, NULL),
(54, '163292570523245527', NULL, 'ACCEPTED', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '1632925705457', NULL, 'SUNDAY AGAGARAGA', '9925', '4', NULL, NULL, NULL, NULL),
(55, NULL, NULL, 'PENDING', '2460', NULL, '231456798', NULL, '27095518', NULL, NULL, NULL, NULL, NULL, '2021-09-29 15:40:00', 'showaa@gmail.com', NULL, NULL, NULL, 'Sten Mockett', '2492', '4', NULL, NULL, NULL, NULL),
(56, NULL, NULL, 'PENDING', '3600', NULL, '1234567890', NULL, '2486650', NULL, NULL, NULL, NULL, NULL, '2021-09-29 15:58:58', 'showaa@gmail.com', NULL, NULL, NULL, 'Sten Mockett', '3552', '4', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dstvaddonsproducts`
--

DROP TABLE IF EXISTS `dstvaddonsproducts`;
CREATE TABLE IF NOT EXISTS `dstvaddonsproducts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `availablePricingOptions` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dstvaddonsproducts`
--

INSERT INTO `dstvaddonsproducts` (`id`, `code`, `availablePricingOptions`, `name`, `price`, `date`, `description`, `created_at`, `updated_at`) VALUES
(1, 'ASIADDE36', '', 'Asian Add-on', '6200', '2021-08-25 15:16:45', '', '2021-08-25 14:16:45', '2021-08-25 14:16:45'),
(2, 'HDPVRE36', '', 'HDPVR/XtraView', '2500', '2021-08-25 15:16:45', '', '2021-08-25 14:16:45', '2021-08-25 14:16:45'),
(3, 'FRN7E36', '', 'French Touch', '2300', '2021-08-25 15:16:45', '', '2021-08-25 14:16:45', '2021-08-25 14:16:45'),
(4, 'FRN15E36', '', 'French Plus', '8100', '2021-08-25 15:16:45', '', '2021-08-25 14:16:45', '2021-08-25 14:16:45'),
(5, 'FRN11E36', '', 'French 11 Bouquet E36', '3260', '2021-08-25 15:16:45', '', '2021-08-25 14:16:45', '2021-08-25 14:16:45');

-- --------------------------------------------------------

--
-- Table structure for table `dstv_suscription_details`
--

DROP TABLE IF EXISTS `dstv_suscription_details`;
CREATE TABLE IF NOT EXISTS `dstv_suscription_details` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smartCard` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dstv_sub_val_id` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoicePeriod` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `productsCode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dstv_suscription_details`
--

INSERT INTO `dstv_suscription_details` (`id`, `firstName`, `lastName`, `smartCard`, `email`, `phone`, `amount`, `dstv_sub_val_id`, `invoicePeriod`, `customerNumber`, `productsCode`, `requestId`, `user_id`, `message`, `status`, `billerRequestId`, `transactionReference`, `transactionDate`, `created_at`, `updated_at`) VALUES
(7, 'Sten Mockett', '', '2005129242', 'admin@gmail.com', '08027618122', '2300', '17', '1', '97542902', 'FRN7E36', '57714', '1', NULL, NULL, NULL, NULL, NULL, '2021-08-27 10:46:17', '2021-08-27 10:46:17'),
(6, 'Sten Mockett', '', '2005129242', 'admin@gmail.com', '07036712564', '12400', '7', '1', '4499662', 'COMPLE36', '64150', '1', NULL, NULL, NULL, NULL, NULL, '2021-08-27 10:45:44', '2021-08-27 10:45:44'),
(5, 'Sten Mockett', '', '2005129242', 'admin@gmail.com', '07038085121', '2500', '16', '1', '99491222', 'HDPVRE36', '97426', '1', 'Request successful', 'Success', '8311', 'I7XP9I01H9TBKB87', '27-AUG-21 12.27.07.119090 PM', '2021-08-27 10:27:05', '2021-08-27 10:27:05'),
(8, 'Sten Mockett', '', '4131953321', 'user@gmail.com', '08027618122', '2500', '16', '1', '18749211', 'HDPVRE36', '11178', '2', NULL, NULL, NULL, NULL, NULL, '2021-08-27 10:55:10', '2021-08-27 10:55:10'),
(9, 'Sten Mockett', '', '2005129242', 'user@gmail.com', '07038085121', '2500', '16', '1', '99318942', 'HDPVRE36', '91313', '2', 'Request successful', 'Failed', NULL, 'DHPMEO0IOVZWDPPJ', '28-AUG-21 09.43.35.579707 PM', '2021-08-28 19:43:33', '2021-08-28 19:43:33'),
(10, 'Sten Mockett', '', '2005129242', 'admin@gmail.com', '08027618122', '3260', '19', '1', '77038572', 'FRN11E36', '70645', '1', NULL, NULL, NULL, NULL, NULL, '2021-08-31 07:46:51', '2021-08-31 07:46:51'),
(11, 'Sten Mockett', '', '2005129242', 'user1@gmail.com', '08027618122', '2500', '16', '1', '33497482', 'HDPVRE36', '53756', '3', 'Request successful', 'Success', '9897', '00C745S2LZWDO0PV', '02-SEP-21 05.39.04.410063 PM', '2021-09-02 15:39:04', '2021-09-02 15:39:04'),
(12, 'Sten Mockett', '', '02021486421', 'admin@gmail.com', '08027618122', '6200', '15', '1', '62373141', 'ASIADDE36', '17738', '1', 'Request successful', 'Success', '9847', 'MBQWH7EASUWT36KR', '03-SEP-21 03.30.15.586943 PM', '2021-09-03 13:30:14', '2021-09-03 13:30:14'),
(13, 'Sten Mockett', '', '4131953321', 'admin@gmail.com', '08027618122', '3260', '19', '1', '55245111', 'FRN11E36', '93091', '1', 'Request successful', 'Success', '8252', '49JRLPV4FE5U6G4V', '03-SEP-21 04.46.27.305459 PM', '2021-09-03 14:46:26', '2021-09-03 14:46:26'),
(14, 'Sten Mockett', '', '02021486421', 'admin@gmail.com', '08027618122', '2300', '17', '1', '36802801', 'FRN7E36', '38167', '1', 'Request successful', 'Success', '3967', 'CA5YYNFUWPNCQ8VG', '07-SEP-21 04.08.22.151064 PM', '2021-09-07 14:08:20', '2021-09-07 14:08:20'),
(15, 'Sten Mockett', '', '1234567890', 'user@gmail.com', '08027618122', '6200', '15', '1', '77603530', 'ASIADDE36', '43912', '2', NULL, NULL, NULL, NULL, NULL, '2021-09-29 08:54:15', '2021-09-29 08:54:15'),
(16, 'Sten Mockett', '', '1234567890', 'user@gmail.com', '08027618122', '2500', '16', '1', '11681300', 'HDPVRE36', '33335', '2', NULL, NULL, NULL, NULL, NULL, '2021-09-29 09:50:53', '2021-09-29 09:50:53'),
(17, 'Sten Mockett', '', '1234567890', 'showaa@gmail.com', '07038085121', '2500', '16', '1', '78530020', 'HDPVRE36', '21432', '4', 'Request successful', 'Success', '4529', 'C7F4TRWJG1Z8Z8QC', '29-SEP-21 03.19.36.244825 PM', '2021-09-29 13:19:36', '2021-09-29 13:19:36');

-- --------------------------------------------------------

--
-- Table structure for table `dstv_transaction_histories`
--

DROP TABLE IF EXISTS `dstv_transaction_histories`;
CREATE TABLE IF NOT EXISTS `dstv_transaction_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `smartCard` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ExchangeReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerCareReferenceId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auditReferenceNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dstv_transaction_histories`
--

INSERT INTO `dstv_transaction_histories` (`id`, `smartCard`, `customerName`, `amount`, `accountNumber`, `status`, `ExchangeReference`, `customerCareReferenceId`, `auditReferenceNumber`, `user_id`, `requestId`, `created_at`, `updated_at`) VALUES
(1, '2005129242', 'Sten Mockett', '2500', '99491222', 'PENDING', NULL, NULL, NULL, '1', '8311', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `enugu_postpaids`
--

DROP TABLE IF EXISTS `enugu_postpaids`;
CREATE TABLE IF NOT EXISTS `enugu_postpaids` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meterNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paymentPlan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enugu_postpaids`
--

INSERT INTO `enugu_postpaids` (`id`, `name`, `address`, `meterNumber`, `paymentPlan`, `phone`, `transactionDate`, `date`, `district`, `amount`, `requestId`, `billerRequestId`, `accountNumber`, `user_id`, `message`, `email`, `status`, `transactionReference`, `created_at`, `updated_at`) VALUES
(1, 'Angius Oriajiaku', '30 Umuluajie Str Off Emic Rd Odume', NULL, 'Prepaid', NULL, NULL, '2021-08-18 13:54:30', 'Enugu', '3000', '17516', NULL, '04042404139', '1', NULL, 'admin@gmail.com', NULL, NULL, '2021-08-18 12:54:30', '2021-08-18 12:54:30'),
(2, 'Angius Oriajiaku', '30 Umuluajie Str Off Emic Rd Odume', NULL, 'Prepaid', NULL, '19-AUG-21 09.13.28.937989 AM', '2021-08-19 08:13:30', 'Enugu', '3000', '40248', NULL, '04042404139', '2', 'Request successful', 'user@gmail.com', 'Success', '88IKIYK5BRYD16RN', '2021-08-19 07:13:30', '2021-08-19 07:13:30'),
(3, 'Angius Oriajiaku', '30 Umuluajie Str Off Emic Rd Odume', NULL, 'Prepaid', NULL, '02-SEP-21 02.24.04.751029 PM', '2021-09-02 13:24:03', 'Enugu', '6200', '65111', NULL, '121501004001', '3', 'Request successful', 'user1@gmail.com', 'Failed', 'HNOPQRMEAE1YP28H', '2021-09-02 12:24:03', '2021-09-02 12:24:03');

-- --------------------------------------------------------

--
-- Table structure for table `enugu_postpaid_payment_histories`
--

DROP TABLE IF EXISTS `enugu_postpaid_payment_histories`;
CREATE TABLE IF NOT EXISTS `enugu_postpaid_payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transactionNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchangeReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `responseMessage` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoiceNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enugu_prepaids`
--

DROP TABLE IF EXISTS `enugu_prepaids`;
CREATE TABLE IF NOT EXISTS `enugu_prepaids` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meterNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paymentPlan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enugu_prepaids`
--

INSERT INTO `enugu_prepaids` (`id`, `name`, `address`, `meterNumber`, `paymentPlan`, `district`, `phone`, `date`, `transactionDate`, `amount`, `requestId`, `billerRequestId`, `accountNumber`, `user_id`, `message`, `email`, `status`, `transactionReference`, `created_at`, `updated_at`) VALUES
(10, 'Angius Oriajiaku', '30 Umuluajie Str Off Emic Rd Odume', '1234567890', 'Prepaid', 'Enugu', NULL, '2021-09-02 13:06:31', NULL, '6200', '26632', NULL, NULL, '3', NULL, 'user1@gmail.com', NULL, NULL, '2021-09-02 12:06:31', '2021-09-02 12:06:31'),
(9, 'Angius Oriajiaku', '30 Umuluajie Str Off Emic Rd Odume', '1234567890', 'Prepaid', 'Enugu', NULL, '2021-09-02 13:06:31', NULL, '6200', '53624', NULL, NULL, '3', NULL, 'user1@gmail.com', NULL, NULL, '2021-09-02 12:06:31', '2021-09-02 12:06:31'),
(8, 'Angius Oriajiaku', '30 Umuluajie Str Off Emic Rd Odume', '6280511000000095', 'Prepaid', 'Enugu', NULL, '2021-09-02 12:36:41', NULL, '6200', '57967', NULL, NULL, '3', NULL, 'user1@gmail.com', NULL, NULL, '2021-09-02 11:36:41', '2021-09-02 11:36:41'),
(7, 'Angius Oriajiaku', '30 Umuluajie Str Off Emic Rd Odume', '12345678921', 'Prepaid', 'Enugu', NULL, '2021-08-18 12:09:45', NULL, '3000', '64585', NULL, NULL, '1', NULL, 'admin@gmail.com', NULL, NULL, '2021-08-18 11:09:45', '2021-08-18 11:09:45');

-- --------------------------------------------------------

--
-- Table structure for table `enugu_prepaid_payment_histories`
--

DROP TABLE IF EXISTS `enugu_prepaid_payment_histories`;
CREATE TABLE IF NOT EXISTS `enugu_prepaid_payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transactionNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meterNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ExchangeReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `responseMessage` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoiceNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gotv_suscription_details`
--

DROP TABLE IF EXISTS `gotv_suscription_details`;
CREATE TABLE IF NOT EXISTS `gotv_suscription_details` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smartCard` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoicePeriod` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gotv_sub_val_id` int(11) NOT NULL,
  `productsCode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dueDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gotv_suscription_details`
--

INSERT INTO `gotv_suscription_details` (`id`, `firstName`, `lastName`, `smartCard`, `email`, `amount`, `phone`, `invoicePeriod`, `customerNumber`, `gotv_sub_val_id`, `productsCode`, `dueDate`, `requestId`, `user_id`, `message`, `status`, `billerRequestId`, `transactionReference`, `transactionDate`, `created_at`, `updated_at`) VALUES
(6, 'Sten Mockett', '', '2005129242', 'user@gmail.com', '800', '07038085121', '1', '53796452', 30, 'GOHAN', '2021-09-20T21:55:36.767+01:00', '76438', '2', 'Request successful', 'Failed', NULL, '5WGA7C06CGQKD4Y5', '20-AUG-21 09.55.39.695434 PM', '2021-08-20 19:55:40', '2021-08-20 19:55:40'),
(5, 'Sten Mockett', '', '2005129242', 'user@gmail.com', '800', '08027618122', '1', '39681442', 30, 'GOHAN', '2021-09-20T21:48:20.808+01:00', '37380', '2', 'Request successful', 'Failed', NULL, 'SVXHY9SDB2JBT622', '20-AUG-21 09.48.23.605322 PM', '2021-08-20 19:48:24', '2021-08-20 19:48:24'),
(4, 'Sten Mockett', '', '2005129242', 'user@gmail.com', '800', '07036712564', '1', '1523472', 30, 'GOHAN', '2021-09-20T15:39:32.788+01:00', '48031', '2', 'Request successful', 'Success', NULL, '8UOPF6S7CG17Z71C', '20-AUG-21 03.39.36.002321 PM', '2021-08-20 13:39:37', '2021-08-20 13:39:37'),
(7, 'Sten Mockett', '', '2005129242', 'user@gmail.com', '800', '07038085121', '1', '31308432', 30, 'GOHAN', '2021-09-20T21:56:42.279+01:00', '80427', '2', 'Request successful', 'Success', NULL, '88P5TSIGLO9LZ966', '20-AUG-21 09.56.46.050104 PM', '2021-08-20 19:56:46', '2021-08-20 19:56:46'),
(8, 'Sten Mockett', '', '2005129242', 'user@gmail.com', '800', '07036712564', '1', '52826132', 30, 'GOHAN', '2021-09-21T07:11:23.095+01:00', '87473', '2', 'Request successful', 'Success', '5302', 'ZERZGWGZO7YVPV90', '21-AUG-21 07.11.25.315512 AM', '2021-08-21 05:11:26', '2021-08-21 05:11:26'),
(9, 'Sten Mockett', '', '2005129242', 'admin@gmail.com', '800', '07036712564', '1', '74092572', 30, 'GOHAN', '2021-09-21T09:54:02.033+01:00', '69859', '1', 'Request successful', 'Success', '7379', 'XHZ3IIVSNP3GB6BV', '21-AUG-21 09.54.05.164227 AM', '2021-08-21 07:54:06', '2021-08-21 07:54:06'),
(10, 'Sten Mockett', '', '2005129242', 'user1@gmail.com', '800', '08126979718', '1', '58720702', 30, 'GOHAN', '2021-09-23T13:02:39.571+01:00', '99952', '3', 'Request successful', 'Failed', NULL, '991I8WYERRH1QW8Y', '23-AUG-21 01.02.46.011177 PM', '2021-08-23 11:02:46', '2021-08-23 11:02:46'),
(11, 'Sten Mockett', '', '2005129242', 'admin@gmail.com', '800', '08027618122', '1', '83361562', 30, 'GOHAN', '2021-09-24T21:39:58.657+01:00', '52491', '1', 'Request successful', 'Success', '7842', 'QXT9DQY6FH8JQT4K', '24-AUG-21 09.40.03.682970 PM', '2021-08-24 19:39:55', '2021-08-24 19:39:55'),
(12, 'Sten Mockett', '', '2005129242', 'user@gmail.com', '800', '08027618122', '1', '32108772', 30, 'GOHAN', '2021-09-25T09:07:34.37+01:00', '72336', '2', NULL, NULL, NULL, NULL, NULL, '2021-08-25 07:07:36', '2021-08-25 07:07:36'),
(13, 'Sten Mockett', '', '2005129242', 'admin@gmail.com', '2460', '08027618122', '1', '30765752', 31, 'GOTVNJ2', '2021-09-30T14:38:02.936+01:00', '70488', '1', NULL, NULL, NULL, NULL, NULL, '2021-08-31 12:38:05', '2021-08-31 12:38:05'),
(14, 'Sten Mockett', '', '2005129242', 'user1@gmail.com', '1640', '08027618122', '1', '90090002', 32, 'GOTVNJ1', '2021-10-02T15:38:17.978+01:00', '53747', '3', 'Request successful', 'Success', '7162', 'UW2BDLRTRZMIFGNM', '02-SEP-21 03.38.20.605908 PM', '2021-09-02 13:38:19', '2021-09-02 13:38:19'),
(15, 'Sten Mockett', '', '2005129242', 'user1@gmail.com', '1640', '08027618122', '1', '31026282', 32, 'GOTVNJ1', '2021-10-02T16:40:58.934+01:00', '86722', '3', 'Request successful', 'Success', '8629', 'TSNZ3LLO3GZ546F6', '02-SEP-21 04.41.02.183226 PM', '2021-09-02 14:41:02', '2021-09-02 14:41:02'),
(16, 'Sten Mockett', '', '231456798', 'showaa@gmail.com', '2460', '07038085121', '1', '27095518', 31, 'GOTVNJ2', '2021-10-29T16:39:08.015+01:00', '25477', '4', 'Request successful', 'Success', '2492', 'UJEUCN63Z54WTMHO', '29-SEP-21 04.39.09.945098 PM', '2021-09-29 14:39:09', '2021-09-29 14:39:09'),
(17, 'Sten Mockett', '', '1234567890', 'showaa@gmail.com', '3600', '07038085121', '1', '2486650', 33, 'GOTVMAX', '2021-10-29T16:58:20.759+01:00', '34922', '4', 'Request successful', 'Success', '3552', '0LSUAUDR3LMA0EYH', '29-SEP-21 04.58.22.567437 PM', '2021-09-29 14:58:22', '2021-09-29 14:58:22');

-- --------------------------------------------------------

--
-- Table structure for table `gotv_transaction_histories`
--

DROP TABLE IF EXISTS `gotv_transaction_histories`;
CREATE TABLE IF NOT EXISTS `gotv_transaction_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `smartCard` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ExchangeReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerCareReferenceId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auditReferenceNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gotv_transaction_histories`
--

INSERT INTO `gotv_transaction_histories` (`id`, `smartCard`, `customerName`, `amount`, `accountNumber`, `status`, `ExchangeReference`, `customerCareReferenceId`, `auditReferenceNumber`, `user_id`, `requestId`, `created_at`, `updated_at`) VALUES
(1, '2005129242', 'Sten Mockett', NULL, '52826132', 'PENDING', NULL, NULL, NULL, '2', '8351', NULL, NULL),
(2, '2005129242', 'Sten Mockett', NULL, '74092572', 'PENDING', NULL, NULL, NULL, '1', '7379', NULL, NULL),
(3, '2005129242', 'Sten Mockett', '800', '83361562', 'PENDING', NULL, NULL, NULL, '1', '7842', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ibadan_postpaids`
--

DROP TABLE IF EXISTS `ibadan_postpaids`;
CREATE TABLE IF NOT EXISTS `ibadan_postpaids` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otherName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionReference` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thirdPartyCode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerType` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ibadan_postpaids`
--

INSERT INTO `ibadan_postpaids` (`id`, `firstName`, `lastName`, `otherName`, `customerReference`, `email`, `transactionDate`, `transactionReference`, `message`, `thirdPartyCode`, `billerRequestId`, `customerType`, `requestId`, `user_id`, `status`, `date`, `amount`, `phone`, `created_at`, `updated_at`) VALUES
(6, 'George', 'Weah', NULL, '121501004001', 'admin@gmail.com', NULL, '', NULL, NULL, '6558', 'POSTPAID', '59121', '1', NULL, '2021-09-01 10:58:24', '6200', '08126979718', '2021-09-01 09:58:24', '2021-09-01 09:58:24'),
(5, 'George', 'Weah', NULL, '121501004001', NULL, NULL, '', NULL, NULL, '7102', 'POSTPAID', '21698', '1', NULL, '2021-08-17 11:47:10', '3000', '07036712564', '2021-08-17 10:47:10', '2021-08-17 10:47:10');

-- --------------------------------------------------------

--
-- Table structure for table `ibadan_postpaid_payment_histories`
--

DROP TABLE IF EXISTS `ibadan_postpaid_payment_histories`;
CREATE TABLE IF NOT EXISTS `ibadan_postpaid_payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transactionNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchangeReference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requestId` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ibadan_postpaid_payment_histories`
--

INSERT INTO `ibadan_postpaid_payment_histories` (`id`, `transactionNumber`, `amount`, `exchangeReference`, `user_id`, `requestId`, `customerName`, `created_at`, `updated_at`) VALUES
(1, '162920086125110592', '3000', '1629200861599', '1', '7102', 'George Weah', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ibadan_prepaids`
--

DROP TABLE IF EXISTS `ibadan_prepaids`;
CREATE TABLE IF NOT EXISTS `ibadan_prepaids` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `requestId` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meterNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otherName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minimumAmount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thirdPartyCode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `outstandingAmount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerType` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `message` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionDate` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionReference` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billerRequestId` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ibadan_prepaids`
--

INSERT INTO `ibadan_prepaids` (`id`, `requestId`, `user_id`, `meterNumber`, `firstName`, `lastName`, `otherName`, `email`, `minimumAmount`, `thirdPartyCode`, `outstandingAmount`, `customerType`, `status`, `amount`, `date`, `phone`, `created_at`, `updated_at`, `message`, `transactionDate`, `transactionReference`, `billerRequestId`) VALUES
(9, 40074, 1, '123456789123', 'George', NULL, NULL, NULL, NULL, NULL, NULL, 'PREPAID', 'Success', '3000', '2021-08-17 10:06:46', '07036712564', '2021-08-17 09:06:46', '2021-08-17 09:06:46', 'Request successful', '17-AUG-21 11.06.45.718600 AM', '0RP5A5RQDDJ6SQOU', '5644'),
(10, 29735, 1, '123456789223', 'George', NULL, NULL, NULL, NULL, NULL, NULL, 'PREPAID', 'Success', '3000', '2021-08-17 11:11:50', '07036712564', '2021-08-17 10:11:50', '2021-08-17 10:11:50', 'Request successful', '17-AUG-21 12.11.50.227729 PM', 'VZLT2BGZM39IO6AH', '7552'),
(11, 15509, 2, '12345678921', 'George', NULL, NULL, NULL, NULL, NULL, NULL, 'PREPAID', 'Failed', '3000', '2021-08-17 20:18:40', '08126979718', '2021-08-17 19:18:40', '2021-08-17 19:18:40', 'Request successful', '17-AUG-21 09.18.39.864663 PM', 'AQ994FX466ZQJNC4', ''),
(12, 22858, 1, '123456789223', 'George', NULL, NULL, NULL, NULL, NULL, NULL, 'PREPAID', 'Success', '3000', '2021-08-18 08:45:10', '08027618122', '2021-08-18 07:45:10', '2021-08-18 07:45:10', 'Request successful', '18-AUG-21 09.45.09.423676 AM', 'EKB8JXIH6XX44E62', '8732'),
(13, 55987, 1, '12345678921', 'George', NULL, NULL, NULL, NULL, NULL, NULL, 'PREPAID', 'Success', '3000', '2021-08-18 08:52:19', '08027618122', '2021-08-18 07:52:19', '2021-08-18 07:52:19', 'Request successful', '18-AUG-21 09.52.19.032484 AM', 'FE5O6DSC08Z2EYEE', '1661'),
(14, 37045, 1, '12345678921', 'George', NULL, NULL, NULL, NULL, NULL, NULL, 'PREPAID', 'Success', '3000', '2021-09-01 09:50:32', '08126979718', '2021-09-01 08:50:32', '2021-09-01 08:50:32', 'Request successful', '01-SEP-21 10.50.32.923451 AM', 'UYDJ2V686PC0N53S', '2678'),
(15, 65852, 1, '123456789123', 'George', NULL, NULL, NULL, NULL, NULL, NULL, 'PREPAID', 'Success', '6200', '2021-09-01 10:37:47', '07038085121', '2021-09-01 09:37:47', '2021-09-01 09:37:47', 'Request successful', '01-SEP-21 11.37.47.670874 AM', '1V0GSPON9XSDT2HN', '9648'),
(16, 15489, 1, '12345678921', 'George', NULL, NULL, 'admin@gmail.com', NULL, NULL, NULL, 'PREPAID', 'Success', '3000', '2021-09-01 13:29:01', '08027618122', '2021-09-01 12:29:01', '2021-09-01 12:29:01', 'Request successful', '01-SEP-21 02.29.02.305060 PM', 'CDY3VZYAEX79NRAO', '1503'),
(17, 87461, 1, '123456789223', 'George', NULL, NULL, 'admin@gmail.com', NULL, NULL, NULL, 'PREPAID', 'Success', '6200', '2021-09-01 13:31:29', '08126979718', '2021-09-01 12:31:29', '2021-09-01 12:31:29', 'Request successful', '01-SEP-21 02.31.30.563253 PM', 'TZP5OKCXM9BYP3SG', '4605'),
(18, 16660, 1, '12345678921', 'George', NULL, NULL, 'admin@gmail.com', NULL, NULL, NULL, 'PREPAID', 'Success', '6200', '2021-09-01 13:46:54', '08027618122', '2021-09-01 12:46:54', '2021-09-01 12:46:54', 'Request successful', '01-SEP-21 02.46.55.322773 PM', 'PN0UC9Z2I0A4CY2Y', '2522'),
(19, 19537, 1, '123456789223', 'George', NULL, NULL, 'admin@gmail.com', NULL, NULL, NULL, 'PREPAID', 'Success', '15000', '2021-09-01 14:03:44', '08126979718', '2021-09-01 13:03:44', '2021-09-01 13:03:44', 'Request successful', '01-SEP-21 03.03.45.103037 PM', 'E1WBKT6SOSIXOSZK', '');

-- --------------------------------------------------------

--
-- Table structure for table `ibadan_prepaid_payment_histories`
--

DROP TABLE IF EXISTS `ibadan_prepaid_payment_histories`;
CREATE TABLE IF NOT EXISTS `ibadan_prepaid_payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transactionNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` int(11) DEFAULT NULL,
  `standardTokenValue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchangeReference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resetToken` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ibadan_prepaid_payment_histories`
--

INSERT INTO `ibadan_prepaid_payment_histories` (`id`, `transactionNumber`, `amount`, `description`, `user_id`, `rate`, `standardTokenValue`, `exchangeReference`, `resetToken`, `token`, `status`, `customerName`, `requestId`, `created_at`, `updated_at`) VALUES
(1, '162919497497643433', '', '', '1', NULL, '', '', '', '', 'PENDING', 'George', '9067', NULL, NULL),
(2, '162919918636155649', '', '', '1', NULL, '', '1629199186752', NULL, '5132 7339 3238 1171', 'ACCEPTED', ' ', '2235', NULL, NULL),
(3, '162927633396224574', '', '', '1', NULL, '', '1629276334865', NULL, '5132 7339 3238 1171', 'ACCEPTED', ' ', '8732', NULL, NULL),
(4, '162927677000679782', '', '', '1', NULL, '', '1629276770103', NULL, '5132 7339 3238 1171', 'ACCEPTED', ' ', '1661', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ikeja_postpaids`
--

DROP TABLE IF EXISTS `ikeja_postpaids`;
CREATE TABLE IF NOT EXISTS `ikeja_postpaids` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customerDtNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customerAccountType` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customerAccount` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionReference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ikeja_postpaids`
--

INSERT INTO `ikeja_postpaids` (`id`, `name`, `address`, `phone`, `customerDtNumber`, `customerAccountType`, `amount`, `customerAccount`, `requestId`, `billerRequestId`, `user_id`, `message`, `email`, `status`, `transactionReference`, `transactionDate`, `created_at`, `updated_at`) VALUES
(9, 'NP NGEMA', '6 ABIODUN ODESEYE Shomolu BU', '07036712564', 'N/A', 'N/A', '10000', '121501004001', '73326', '1530', '2', 'Request successful', 'user@gmail.com', 'Success', 'KBNP0776VRM1TR0V', '02-SEP-21 11.50.53.734830 AM', '2021-09-02 09:50:52', '2021-09-02 09:50:52'),
(8, 'NP NGEMA', '6 ABIODUN ODESEYE Shomolu BU', '07036712564', 'N/A', 'N/A', '3000', '121501004001', '86069', '4706', '1', 'Request successful', 'admin@gmail.com', 'Success', 'PMZB4UBQ8GAGAQ58', '17-AUG-21 01.14.13.970984 PM', '2021-08-17 11:14:14', '2021-08-17 11:14:14');

-- --------------------------------------------------------

--
-- Table structure for table `ikeja_postpaid_payment_histories`
--

DROP TABLE IF EXISTS `ikeja_postpaid_payment_histories`;
CREATE TABLE IF NOT EXISTS `ikeja_postpaid_payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transactionNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utilityName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `errorMessage` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchangeReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ikeja_postpaid_payment_histories`
--

INSERT INTO `ikeja_postpaid_payment_histories` (`id`, `transactionNumber`, `customerName`, `amount`, `utilityName`, `errorMessage`, `balance`, `status`, `accountNumber`, `exchangeReference`, `user_id`, `requestId`, `created_at`, `updated_at`) VALUES
(1, '162897585985384806', 'NP NGEMA', '3000', 'IKEJA', NULL, NULL, 'ACCEPTED', '0011234567', '1628975860726', '1', '6755', NULL, NULL),
(2, '162920248368754782', 'NP NGEMA', '3000', 'IKEJA', NULL, NULL, 'ACCEPTED', '121501004001', '1629202484754', '1', '4706', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ikeja_prepaids`
--

DROP TABLE IF EXISTS `ikeja_prepaids`;
CREATE TABLE IF NOT EXISTS `ikeja_prepaids` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meterNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customerDtNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customerAccountType` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionReference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ikeja_prepaids`
--

INSERT INTO `ikeja_prepaids` (`id`, `name`, `address`, `meterNumber`, `phone`, `email`, `customerDtNumber`, `customerAccountType`, `amount`, `requestId`, `billerRequestId`, `user_id`, `message`, `status`, `transactionReference`, `transactionDate`, `created_at`, `updated_at`) VALUES
(1, 'TESTMETER1', 'ABULE - EGBA BU ABULE', '04042404048', '08027618122', 'user@gmail.com', 'N/A', 'N/A', '3000', '22461', '8101', '2', 'Request successful', 'Success', 'G64QWJ9T5HNF04FP', '11-AUG-21 10.42.56.389938 AM', '2021-08-11 08:43:02', '2021-08-11 08:43:02'),
(2, 'TESTMETER1', 'ABULE - EGBA BU ABULE', 'STS_PREPAID', '08027618122', 'user@gmail.com', 'N/A', 'N/A', '3000', '16767', '', '2', 'Request successful', 'Failed', 'EWMQCH429E4VR2ER', '11-AUG-21 04.43.47.538241 PM', '2021-08-11 14:43:54', '2021-08-11 14:43:54'),
(3, 'TESTMETER1', 'ABULE - EGBA BU ABULE', 'STS_PREPAID', '08027618122', 'user@gmail.com', 'N/A', 'N/A', '3000', '78156', '', '2', 'Request successful', 'Failed', 'D73DCGYR0DMH61B7', '12-AUG-21 01.49.52.658630 PM', '2021-08-12 11:49:59', '2021-08-12 11:49:59'),
(4, 'TESTMETER1', 'ABULE - EGBA BU ABULE', 'STS_PREPAID', '08027618122', 'user@gmail.com', 'N/A', 'N/A', '3000', '17013', '', '2', 'Request successful', 'Failed', '90GNRECHDBTW6XMM', '12-AUG-21 01.51.30.568457 PM', '2021-08-12 11:51:37', '2021-08-12 11:51:37'),
(5, 'TESTMETER1', 'ABULE - EGBA BU ABULE', 'STS_PREPAID', '07038085121', 'user@gmail.com', 'N/A', 'N/A', '3000', '69398', '', '2', 'Request successful', 'Failed', 'KKA7J7H694ZU3LT9', '12-AUG-21 01.52.52.425199 PM', '2021-08-12 11:52:58', '2021-08-12 11:52:58'),
(6, 'TESTMETER1', 'ABULE - EGBA BU ABULE', 'STS_PREPAID', '08027618122', 'user@gmail.com', 'N/A', 'N/A', '3000', '44168', '', '2', 'Request successful', 'Failed', 'U7U269ITFT4W82ZA', '12-AUG-21 04.10.16.913476 PM', '2021-08-12 14:10:23', '2021-08-12 14:10:23'),
(7, 'TESTMETER1', 'ABULE - EGBA BU ABULE', '1234567890', '08027618122', 'user@gmail.com', 'N/A', 'N/A', '3000', '60437', '', '2', '', '', '', '', '2021-08-13 09:19:42', '2021-08-13 09:19:42'),
(8, 'TESTMETER1', 'ABULE - EGBA BU ABULE', '12345678921', '07036712564', 'admin@gmail.com', 'N/A', 'N/A', '3000', '23938', '', '1', 'Request successful', 'Failed', 'UIJ09NRYY6KBU18S', '15-AUG-21 11.58.30.151356 AM', '2021-08-15 09:58:30', '2021-08-15 09:58:30'),
(9, 'TESTMETER1', 'ABULE - EGBA BU ABULE', '123456789123', '08027618122', 'admin@gmail.com', 'N/A', 'N/A', '4000', '63965', '', '1', 'Request successful', 'Failed', 'FN357DC3WLJ6FNZV', '15-AUG-21 11.59.41.528139 AM', '2021-08-15 09:59:41', '2021-08-15 09:59:41'),
(10, 'TESTMETER1', 'ABULE - EGBA BU ABULE', '123456789223', '07036712564', 'admin@gmail.com', 'N/A', 'N/A', '3000', '39124', '3309', '1', 'Request successful', 'Success', '2WBZNKWOF79FWZOF', '17-AUG-21 01.12.55.506582 PM', '2021-08-17 11:12:56', '2021-08-17 11:12:56'),
(11, 'TESTMETER1', 'ABULE - EGBA BU ABULE', '123456789223', '07036712564', 'user@gmail.com', 'N/A', 'N/A', '3000', '76432', '3013', '2', 'Request successful', 'Success', 'LOGQUOFVQN8J8AKE', '02-SEP-21 10.17.42.021647 AM', '2021-09-02 08:17:41', '2021-09-02 08:17:41'),
(12, 'TESTMETER1', 'ABULE - EGBA BU ABULE', '1234567890', '07036712564', 'user@gmail.com', 'N/A', 'N/A', '6200', '77937', '8973', '2', 'Request successful', 'Success', '3PE12BLNDVFPGART', '02-SEP-21 11.45.23.229308 AM', '2021-09-02 09:45:22', '2021-09-02 09:45:22');

-- --------------------------------------------------------

--
-- Table structure for table `ikeja_prepaid_payment_histories`
--

DROP TABLE IF EXISTS `ikeja_prepaid_payment_histories`;
CREATE TABLE IF NOT EXISTS `ikeja_prepaid_payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transactionNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchangeReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creditToken` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tokenAmount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meternumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utilityName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ikeja_prepaid_payment_histories`
--

INSERT INTO `ikeja_prepaid_payment_histories` (`id`, `transactionNumber`, `customerName`, `amount`, `exchangeReference`, `creditToken`, `tokenAmount`, `status`, `meternumber`, `utilityName`, `user_id`, `requestId`, `created_at`, `updated_at`) VALUES
(1, '162920240065326178', 'TESTMETER1', '3000', '1629202400466', '20165217774715963905', '3000', 'ACCEPTED', '123456789223', 'IKEJA', '1', '3309', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jos_postpaids`
--

DROP TABLE IF EXISTS `jos_postpaids`;
CREATE TABLE IF NOT EXISTS `jos_postpaids` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meterNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `responseMessage` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendType` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tariff` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionReference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jos_postpaid_payment_histories`
--

DROP TABLE IF EXISTS `jos_postpaid_payment_histories`;
CREATE TABLE IF NOT EXISTS `jos_postpaid_payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meterNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discoExchangeReference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `responseMessage` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendType` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionReference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jos_prepaids`
--

DROP TABLE IF EXISTS `jos_prepaids`;
CREATE TABLE IF NOT EXISTS `jos_prepaids` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meterNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerAccountType` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `responseMessage` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendType` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tariff` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jos_prepaids`
--

INSERT INTO `jos_prepaids` (`id`, `name`, `address`, `meterNumber`, `phone`, `customerAccountType`, `amount`, `company`, `requestId`, `billerRequestId`, `responseMessage`, `vendType`, `tariff`, `user_id`, `message`, `email`, `status`, `transactionReference`, `transactionDate`, `created_at`, `updated_at`) VALUES
(1, 'RUKAYYA AUDU', 'SHAGARI LOW COST BARNAWA Kaduna', '54161045569', '08027618122', NULL, '3000', 'JOS', '21918', '1321', 'SUCCESS', 'PREPAID', ' 29.81 N/KWh:  :  : ', '2', 'Request successful', 'user@gmail.com', 'Success', 'GHLI6LS9JEE4V0FW', '13-AUG-21 03.47.32.426775 PM', '2021-08-13 13:47:33', '2021-08-13 13:47:33'),
(2, 'RUKAYYA AUDU', 'SHAGARI LOW COST BARNAWA Kaduna', '54161045569', '08027618122', NULL, '3000', 'JOS', '19240', '7519', 'SUCCESS', 'PREPAID', ' 29.81 N/KWh:  :  : ', '2', 'Request successful', 'user@gmail.com', 'Success', 'EU775AISIU8OLR8Y', '13-AUG-21 04.45.39.651591 PM', '2021-08-13 14:45:40', '2021-08-13 14:45:40'),
(3, 'RUKAYYA AUDU', 'SHAGARI LOW COST BARNAWA Kaduna', '54161045569', '07036712564', NULL, '3000', 'JOS', '40184', NULL, 'SUCCESS', 'PREPAID', ' 29.81 N/KWh:  :  : ', '1', NULL, 'admin@gmail.com', NULL, NULL, NULL, '2021-08-17 11:16:03', '2021-08-17 11:16:03'),
(4, 'RUKAYYA AUDU', 'SHAGARI LOW COST BARNAWA Kaduna', '12345678921', '07036712564', NULL, '3000', 'JOS', '22754', '7758', 'SUCCESS', 'PREPAID', ' 29.81 N/KWh:  :  : ', '1', 'Request successful', 'admin@gmail.com', 'Success', 'AO1JVHD2SPI29EVN', '17-AUG-21 01.22.54.346104 PM', '2021-08-17 11:22:55', '2021-08-17 11:22:55'),
(5, 'RUKAYYA AUDU', 'SHAGARI LOW COST BARNAWA Kaduna', '54161045569', '08126979718', NULL, '10000', 'JOS', '99769', NULL, 'SUCCESS', 'PREPAID', ' 29.81 N/KWh:  :  : ', '2', 'Request successful', 'user@gmail.com', 'Success', '0NUHD2G8BVWWHEXQ', '02-SEP-21 12.13.53.911900 PM', '2021-09-02 10:13:53', '2021-09-02 10:13:53'),
(6, 'RUKAYYA AUDU', 'SHAGARI LOW COST BARNAWA Kaduna', '54161045569', '08126979718', NULL, '10000', 'JOS', '28189', '9534', 'SUCCESS', 'PREPAID', ' 29.81 N/KWh:  :  : ', '2', 'Request successful', 'user@gmail.com', 'Success', 'AGFP7A1B5CUIE1F2', '02-SEP-21 12.37.50.305622 PM', '2021-09-02 10:37:49', '2021-09-02 10:37:49'),
(7, 'RUKAYYA AUDU', 'SHAGARI LOW COST BARNAWA Kaduna', '54161045569', '08027618122', NULL, '6200', 'JOS', '35286', '1288', 'SUCCESS', 'PREPAID', ' 29.81 N/KWh:  :  : ', '3', 'Request successful', 'user1@gmail.com', 'Success', '0KM4YHOF061DH5CB', '02-SEP-21 01.27.42.559972 PM', '2021-09-02 11:27:41', '2021-09-02 11:27:41');

-- --------------------------------------------------------

--
-- Table structure for table `jos_prepaid_payment_histories`
--

DROP TABLE IF EXISTS `jos_prepaid_payment_histories`;
CREATE TABLE IF NOT EXISTS `jos_prepaid_payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transactionNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receiptNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meterNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discoExchangeReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jos_prepaid_payment_histories`
--

INSERT INTO `jos_prepaid_payment_histories` (`id`, `transactionNumber`, `customerName`, `amount`, `receiptNumber`, `token`, `status`, `meterNumber`, `discoExchangeReference`, `user_id`, `requestId`, `created_at`, `updated_at`) VALUES
(1, '162920345599238050', 'RUKAYYA AUDU', NULL, NULL, NULL, 'PENDING', NULL, NULL, '1', '7429', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kaduna_prepaids`
--

DROP TABLE IF EXISTS `kaduna_prepaids`;
CREATE TABLE IF NOT EXISTS `kaduna_prepaids` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meterNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tariff` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionReference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kaduna_prepaids`
--

INSERT INTO `kaduna_prepaids` (`id`, `name`, `address`, `meterNumber`, `phone`, `tariff`, `amount`, `requestId`, `billerRequestId`, `user_id`, `message`, `email`, `status`, `transactionReference`, `transactionDate`, `created_at`, `updated_at`) VALUES
(1, 'RUKAYYA AUDU', 'SHAGARI LOW COST BARNAWA Kaduna', '04171254347', '08027618122', ' 29.81 N/KWh:  :  : ', '3000', '83162', '', '2', '', 'user@gmail.com', '', '', '', '2021-08-12 16:47:52', '2021-08-12 16:47:52'),
(2, 'RUKAYYA AUDU', 'SHAGARI LOW COST BARNAWA Kaduna', '04171254347', '08027618122', ' 29.81 N/KWh:  :  : ', '3000', '62657', '', '1', '', 'admin@gmail.com', '', '', '', '2021-08-17 11:42:45', '2021-08-17 11:42:45'),
(3, 'RUKAYYA AUDU', 'SHAGARI LOW COST BARNAWA Kaduna', '04171254347', '08027618122', ' 29.81 N/KWh:  :  : ', '3000', '46763', '', '1', '', 'admin@gmail.com', '', '', '', '2021-08-17 11:42:45', '2021-08-17 11:42:45'),
(4, 'RUKAYYA AUDU', 'SHAGARI LOW COST BARNAWA Kaduna', '04171254347', '08027618122', ' 29.81 N/KWh:  :  : ', '3000', '50896', '2284', '1', 'Request successful', 'admin@gmail.com', 'Success', 'XIRPEZQK4S7GJN4L', '17-AUG-21 01.42.46.235469 PM', '2021-08-17 11:42:46', '2021-08-17 11:42:46'),
(5, 'RUKAYYA AUDU', 'SHAGARI LOW COST BARNAWA Kaduna', '12345678921', '07038085121', ' 29.81 N/KWh:  :  : ', '3000', '79269', '7450', '1', 'Request successful', 'admin@gmail.com', 'Success', 'CWV0K4W7TMM090M5', '17-AUG-21 02.22.25.604972 PM', '2021-08-17 12:22:26', '2021-08-17 12:22:26');

-- --------------------------------------------------------

--
-- Table structure for table `kaduna_prepaid_payment_histories`
--

DROP TABLE IF EXISTS `kaduna_prepaid_payment_histories`;
CREATE TABLE IF NOT EXISTS `kaduna_prepaid_payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transactionNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `responseMessage` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendAmount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discoExchangeReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meternumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kaduna_prepaid_payment_histories`
--

INSERT INTO `kaduna_prepaid_payment_histories` (`id`, `transactionNumber`, `customerName`, `amount`, `responseMessage`, `vendAmount`, `status`, `discoExchangeReference`, `meternumber`, `token`, `user_id`, `requestId`, `created_at`, `updated_at`) VALUES
(1, '162920420692639660', 'RUKAYYA AUDU', '3000', 'SUCCESSFUL', '1100', 'ACCEPTED', '105-220985656792', '04171254347', '0284-0092-4961-0746-0528', '1', '2284', NULL, NULL),
(2, '162920659871618603', 'RUKAYYA AUDU', '3000', 'SUCCESSFUL', '1100', 'ACCEPTED', '105-111421495071', '12345678921', '2947-0792-2049-2706-5864', '1', '7450', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(15, '2014_10_12_000000_create_users_table', 4),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2021_07_22_103847_create_sessions_table', 1),
(16, '2021_07_23_135714_create_prepaid_controllers_table', 5),
(17, '2021_08_06_091900_create_postpaids_table', 5),
(18, '2021_08_06_135240_create_postpaid_payment_histories_table', 6),
(19, '2021_08_06_203757_create_prepaid_payment_histories_table', 7),
(20, '2021_08_09_143810_create_ibadan_prepaids_table', 8),
(21, '2021_08_09_203643_create_ibadan_prepaid_payment_histories_table', 9),
(22, '2021_08_10_080948_create_ibadan_postpaids_table', 10),
(23, '2021_08_10_091636_create_ibadan_postpaid_payment_histories_table', 11),
(25, '2021_08_10_110849_create_abuja_prepaids_table', 12),
(26, '2021_08_10_141343_create_abuja_postpaid_payment_histories_table', 13),
(27, '2021_08_10_142648_create_abuja_prepaid_payment_histories_table', 13),
(28, '2021_08_10_163436_create_abuja_post_paids_table', 14),
(29, '2021_08_11_091147_create_ikeja_prepaids_table', 15),
(30, '2021_08_11_102619_create_ikeja_prepaid_payment_histories_table', 16),
(31, '2021_08_11_161019_create_ikeja_postpaids_table', 17),
(32, '2021_08_11_173926_create_ikeja_postpaid_payment_histories_table', 18),
(33, '2021_08_12_173705_create_kaduna_prepaids_table', 19),
(34, '2021_08_12_185720_create_kaduna_prepaid_payment_histories_table', 20),
(35, '2021_08_13_110435_create_jos_postpaids_table', 21),
(37, '2021_08_13_144157_create_jos_prepaids_table', 22),
(38, '2021_08_13_153106_create_jos_prepaid_payment_histories_table', 23),
(39, '2021_08_13_173111_create_jos_postpaid_payment_histories_table', 24),
(40, '2021_08_16_183229_create_pending_accepted_transactions_table', 25),
(41, '2021_08_18_094853_create_enugu_prepaids_table', 26),
(42, '2021_08_18_104442_create_enugu_prepaid_payment_histories_table', 27),
(43, '2021_08_18_134703_create_enugu_postpaids_table', 28),
(44, '2021_08_19_082440_create_enugu_postpaid_payment_histories_table', 29),
(45, '2021_08_19_120108_create_new_gotv_sub_validates_table', 29),
(46, '2021_08_20_084711_create_gotv_suscription_details_table', 30),
(47, '2021_08_21_063345_create_gotv_transaction_histories_table', 31),
(48, '2021_08_23_123411_create_new_d_s_t_v_sub_validates_table', 32),
(49, '2021_08_25_080039_create_dstv_suscription_details_table', 33),
(50, '2021_08_25_092623_create_dstv_transaction_histories_table', 34),
(51, '2021_08_25_150824_create_dstvaddonsproducts_table', 35),
(52, '2021_08_27_162839_create_startimes_suscription_details_table', 36),
(53, '2021_08_28_082059_create_startimestransaction_histories_table', 37),
(54, '2021_08_30_092228_create_smiles_recharges_table', 38),
(55, '2021_08_30_095223_create_smilesrechargestransaction_histories_table', 39),
(58, '2021_08_30_203514_create_smile_bundles_table', 42),
(57, '2021_08_30_211240_create_smile_bundle_packages_table', 41),
(59, '2021_08_31_074854_create_smiles_bundletransaction_histories_table', 43),
(60, '2021_08_31_101837_create_all_payment_histories_table', 44);

-- --------------------------------------------------------

--
-- Table structure for table `new_d_s_t_v_sub_validates`
--

DROP TABLE IF EXISTS `new_d_s_t_v_sub_validates`;
CREATE TABLE IF NOT EXISTS `new_d_s_t_v_sub_validates` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `availablePricingOptions` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `new_d_s_t_v_sub_validates`
--

INSERT INTO `new_d_s_t_v_sub_validates` (`id`, `code`, `availablePricingOptions`, `name`, `price`, `date`, `description`, `created_at`, `updated_at`) VALUES
(10, 'ASIAE36', '', 'Asian Bouqet', '6200', '2021-08-23 13:39:57', '', '2021-08-23 12:39:58', '2021-08-23 12:39:58'),
(9, 'PRWASIE36', '', 'DStv Premium Asia', '20500', '2021-08-23 13:39:57', '', '2021-08-23 12:39:57', '2021-08-23 12:39:57'),
(8, 'PRWE36', '', 'DStv Premium', '18400', '2021-08-23 13:39:57', '', '2021-08-23 12:39:57', '2021-08-23 12:39:57'),
(7, 'COMPLE36', '', 'DStv Compact Plus', '12400', '2021-08-23 13:39:57', '', '2021-08-23 12:39:57', '2021-08-23 12:39:57'),
(6, 'COMPE36', '', 'DStv Compact', '7900', '2021-08-23 13:39:57', '', '2021-08-23 12:39:57', '2021-08-23 12:39:57'),
(11, 'PRWFRNSE36', '', 'DStv Premium French', '25550', '2021-08-25 13:07:50', '', '2021-08-25 12:07:50', '2021-08-25 12:07:50'),
(12, 'NLTESE36', '', 'Padi', '1850', '2021-08-25 13:07:51', '', '2021-08-25 12:07:51', '2021-08-25 12:07:51'),
(13, 'NNJ1E36', '', 'DStv Yanga Bouquet E36', '2565', '2021-08-25 13:07:51', '', '2021-08-25 12:07:51', '2021-08-25 12:07:51'),
(14, 'NNJ2E36', '', 'DStv Confam Bouquet E36', '4615', '2021-08-25 13:07:51', '', '2021-08-25 12:07:51', '2021-08-25 12:07:51'),
(15, 'ASIADDE36', '', 'Asian Add-on', '6200', '2021-08-27 10:36:10', '', '2021-08-27 09:36:10', '2021-08-27 09:36:10'),
(16, 'HDPVRE36', '', 'HDPVR/XtraView', '2500', '2021-08-27 10:36:10', '', '2021-08-27 09:36:10', '2021-08-27 09:36:10'),
(17, 'FRN7E36', '', 'French Touch', '2300', '2021-08-27 10:36:10', '', '2021-08-27 09:36:10', '2021-08-27 09:36:10'),
(18, 'FRN15E36', '', 'French Plus', '8100', '2021-08-27 10:36:10', '', '2021-08-27 09:36:10', '2021-08-27 09:36:10'),
(19, 'FRN11E36', '', 'French 11 Bouquet E36', '3260', '2021-08-27 10:36:10', '', '2021-08-27 09:36:10', '2021-08-27 09:36:10');

-- --------------------------------------------------------

--
-- Table structure for table `new_gotv_sub_validates`
--

DROP TABLE IF EXISTS `new_gotv_sub_validates`;
CREATE TABLE IF NOT EXISTS `new_gotv_sub_validates` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `availablePricingOptions` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoicePeriod` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `monthsPaidFor` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `new_gotv_sub_validates`
--

INSERT INTO `new_gotv_sub_validates` (`id`, `code`, `availablePricingOptions`, `name`, `price`, `invoicePeriod`, `monthsPaidFor`, `date`, `description`, `created_at`, `updated_at`) VALUES
(31, 'GOTVNJ2', '', 'GOtv Jolli Bouquet', '2460', NULL, NULL, '2021-08-25 13:09:07', '', '2021-08-25 12:09:07', '2021-08-25 12:09:07'),
(32, 'GOTVNJ1', '', 'GOtv Jinja Bouquet', '1640', NULL, NULL, '2021-08-25 13:09:07', '', '2021-08-25 12:09:07', '2021-08-25 12:09:07'),
(33, 'GOTVMAX', '', 'GOtv Max', '3600', NULL, NULL, '2021-08-25 13:09:07', '', '2021-08-25 12:09:07', '2021-08-25 12:09:07'),
(30, 'GOHAN', '', 'GOtv Smallie - monthly', '800', '1', '1', '2021-08-19 21:09:06', '', '2021-08-19 20:09:06', '2021-08-19 20:09:06');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_accepted_transactions`
--

DROP TABLE IF EXISTS `pending_accepted_transactions`;
CREATE TABLE IF NOT EXISTS `pending_accepted_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smartCard` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meterNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pending_accepted_transactions`
--

INSERT INTO `pending_accepted_transactions` (`id`, `status`, `smartCard`, `requestId`, `user_id`, `phone`, `accountNumber`, `meterNumber`, `created_at`, `updated_at`) VALUES
(22, 'PENDING', NULL, '6032', '2', NULL, NULL, '123456789123', NULL, NULL),
(21, 'PENDING', NULL, '4589', '2', NULL, NULL, '123456789123', NULL, NULL),
(20, 'PENDING', NULL, '5417', '1', NULL, NULL, '54161045569', NULL, NULL),
(19, 'PENDING', NULL, '1625', '1', NULL, '1234567890', NULL, NULL, NULL),
(23, 'PENDING', '2005129242', '7204', '2', NULL, NULL, NULL, NULL, NULL),
(24, 'PENDING', '2005129242', '2544', '2', NULL, NULL, NULL, NULL, NULL),
(25, 'PENDING', '2005129242', '1352', '2', NULL, NULL, NULL, NULL, NULL),
(26, 'PENDING', '2005129242', '8351', '2', NULL, NULL, NULL, NULL, NULL),
(27, 'PENDING', '2005129242', '7379', '1', NULL, NULL, NULL, NULL, NULL),
(28, 'PENDING', '2005129242', '7842', '1', NULL, NULL, NULL, NULL, NULL),
(29, 'PENDING', NULL, '4788', '1', NULL, NULL, '123456789223', NULL, NULL),
(30, 'PENDING', '2005129242', '8311', '1', NULL, NULL, NULL, NULL, NULL),
(31, 'PENDING', NULL, '8719', '1', NULL, NULL, '12345678921', NULL, NULL),
(32, 'PENDING', NULL, '5562', '1', NULL, NULL, '12345678921', NULL, NULL),
(33, 'PENDING', NULL, '1017', '1', NULL, NULL, '123456789223', NULL, NULL),
(34, 'PENDING', NULL, '3012', '1', NULL, '1234567890', NULL, NULL, NULL),
(35, 'PENDING', NULL, '9534', '2', '08126979718', NULL, '54161045569', NULL, NULL),
(36, 'PENDING', NULL, '1288', '3', '08027618122', NULL, '54161045569', NULL, NULL),
(37, 'PENDING', NULL, '4665', '3', '08027618122', NULL, '54161045569', NULL, NULL),
(38, 'PENDING', '2005129242', '7162', '3', NULL, NULL, NULL, NULL, NULL),
(39, 'PENDING', '2005129242', '8629', '3', NULL, NULL, NULL, NULL, NULL),
(40, 'PENDING', '2005129242', '1657', '3', NULL, NULL, NULL, NULL, NULL),
(41, 'PENDING', '2005129242', '5744', '3', NULL, NULL, NULL, NULL, NULL),
(42, 'PENDING', '2005129242', '9897', '3', NULL, NULL, NULL, NULL, NULL),
(43, 'PENDING', NULL, '8373', '2', NULL, '1234567890', NULL, NULL, NULL),
(44, 'PENDING', NULL, '2343', '2', NULL, '1234567890', NULL, NULL, NULL),
(45, 'PENDING', NULL, '7995', '1', NULL, '1234567890', NULL, NULL, NULL),
(46, 'PENDING', NULL, '4146', '1', NULL, NULL, '1234567890', NULL, NULL),
(47, 'PENDING', '02021486421', '9847', '1', NULL, NULL, NULL, NULL, NULL),
(48, 'PENDING', NULL, '7922', '1', NULL, '1234567890', NULL, NULL, NULL),
(49, 'PENDING', '4131953321', '8252', '1', NULL, NULL, NULL, NULL, NULL),
(50, 'PENDING', '02021486421', '3967', '1', NULL, NULL, NULL, NULL, NULL),
(51, 'PENDING', NULL, '7569', '4', NULL, NULL, '12314567809', NULL, NULL),
(52, 'PENDING', NULL, '9449', '4', NULL, NULL, '2145328790', NULL, NULL),
(53, 'PENDING', NULL, '9494', '4', NULL, '23456667778', NULL, NULL, NULL),
(54, 'PENDING', NULL, '1611', '4', NULL, '23456667778', NULL, NULL, NULL),
(55, 'PENDING', '1234567890', '4529', '4', NULL, NULL, NULL, NULL, NULL),
(56, 'PENDING', NULL, '5118', '4', NULL, NULL, '12314567809', NULL, NULL),
(57, 'PENDING', NULL, '9925', '4', NULL, NULL, '12345678790', NULL, NULL),
(58, 'PENDING', '231456798', '2492', '4', NULL, NULL, NULL, NULL, NULL),
(59, 'PENDING', '1234567890', '3552', '4', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `postpaids`
--

DROP TABLE IF EXISTS `postpaids`;
CREATE TABLE IF NOT EXISTS `postpaids` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'user_id=userid',
  `businessUnit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phoneNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `postpaids`
--

INSERT INTO `postpaids` (`id`, `customerName`, `user_id`, `businessUnit`, `customerReference`, `phoneNumber`, `message`, `status`, `transactionReference`, `transactionDate`, `amount`, `requestId`, `billerRequestId`, `created_at`, `updated_at`) VALUES
(6, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', 'NS01LA7267WTVR5A', '06-AUG-21 06.34.45.087666 PM', '3450', '75226', '2846', '2021-08-06 16:34:50', '2021-08-06 16:34:50'),
(5, 'SUNDAY AGAGARAGA', 1, 'OJO', '101512454501', NULL, 'Request successful', 'Success', 'UF96VCXXQE5XHKEL', '06-AUG-21 04.16.11.846037 PM', '3000', '73738', '5918', '2021-08-06 14:16:16', '2021-08-06 14:16:16'),
(4, 'SUNDAY AGAGARAGA', 1, 'OJO', '101512454501', NULL, 'Request successful', 'Success', 'S7M6NJ6ZBK754E77', '06-AUG-21 03.48.30.244374 PM', '55000', '88594', '5226', '2021-08-06 13:48:34', '2021-08-06 13:48:34'),
(7, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', 'GWNJM0T1SEE3V1OO', '06-AUG-21 08.06.46.183452 PM', '3000', '28463', '4091', '2021-08-06 18:06:51', '2021-08-06 18:06:51'),
(8, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', 'RATUBG6RY0WH1DNX', '06-AUG-21 10.03.34.630576 PM', '3000', '67809', '4053', '2021-08-06 20:03:39', '2021-08-06 20:03:39'),
(9, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', 'BJKLEL00QXKDT3PM', '07-AUG-21 05.29.44.138090 AM', '3000', '34079', '9448', '2021-08-07 03:29:48', '2021-08-07 03:29:48'),
(10, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', 'USZ7IHU6RRNUAN7V', '09-AUG-21 07.38.28.307596 PM', '200', '78031', '9710', '2021-08-09 17:38:35', '2021-08-09 17:38:35'),
(11, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', 'A51M0G0QPR5F9S8O', '10-AUG-21 02.22.20.695617 PM', '200', '53287', '7060', '2021-08-10 12:22:27', '2021-08-10 12:22:27'),
(12, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Failed', '8PAU5ZG4BXUD61ZI', '15-AUG-21 10.04.40.617688 AM', '3000', '44796', NULL, '2021-08-15 08:04:42', '2021-08-15 08:04:42'),
(13, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', 'PMZPMV25K4NMKF1A', '15-AUG-21 10.12.46.136862 AM', '3000', '43293', '5690', '2021-08-15 08:12:46', '2021-08-15 08:12:46'),
(14, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', '0Q1PPGOWGLN7MIPP', '17-AUG-21 03.43.10.678824 AM', '3000', '38068', '9549', '2021-08-17 01:43:11', '2021-08-17 01:43:11'),
(15, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', 'QLTWOA0WBLTZI4UD', '17-AUG-21 10.11.53.491766 AM', '3000', '36599', '2538', '2021-08-17 08:11:53', '2021-08-17 08:11:53'),
(16, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', '87X096U7W3FQRDN8', '17-AUG-21 10.35.22.051950 AM', '3000', '63243', '6250', '2021-08-17 08:35:22', '2021-08-17 08:35:22'),
(17, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', 'KI7R9O47EMTE7YMB', '17-AUG-21 10.53.54.109439 AM', '3000', '75614', '5010', '2021-08-17 08:53:54', '2021-08-17 08:53:54'),
(18, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', 'PHU8UHDO3YHNRPS9', '17-AUG-21 11.20.16.531141 AM', '3000', '10088', '5424', '2021-08-17 09:20:17', '2021-08-17 09:20:17'),
(19, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', '97LPK23V33VF3IHF', '18-AUG-21 09.46.17.310248 AM', '3000', '97827', '1625', '2021-08-18 07:46:18', '2021-08-18 07:46:18'),
(20, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, NULL, NULL, NULL, NULL, '6200', '39883', NULL, '2021-08-31 09:30:55', '2021-08-31 09:30:55'),
(21, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, NULL, NULL, NULL, NULL, '6200', '72062', NULL, '2021-09-01 08:04:08', '2021-09-01 08:04:08'),
(22, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', 'DW9WQAUFHEH2G9EV', '01-SEP-21 10.41.57.184986 AM', '3000', '44494', NULL, '2021-09-01 08:41:56', '2021-09-01 08:41:56'),
(23, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', '8FH20BHVE31W5TFG', '01-SEP-21 10.43.39.715378 AM', '6200', '62543', '3012', '2021-09-01 08:43:38', '2021-09-01 08:43:38'),
(24, 'SUNDAY AGAGARAGA', 2, 'OJO', '1234567890', NULL, 'Request successful', 'Success', 'OCQ4K3W7XVA09S6I', '03-SEP-21 03.18.36.668788 PM', '3000', '36424', '8373', '2021-09-03 13:18:35', '2021-09-03 13:18:35'),
(25, 'SUNDAY AGAGARAGA', 2, 'OJO', '1234567890', NULL, 'Request successful', 'Success', '8AV098T2DWJRVH2K', '03-SEP-21 03.19.31.202582 PM', '3000', '58752', '2343', '2021-09-03 13:19:30', '2021-09-03 13:19:30'),
(26, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', 'FZO8RIB64YM42Z51', '03-SEP-21 03.22.26.020404 PM', '6200', '11588', '7995', '2021-09-03 13:22:25', '2021-09-03 13:22:25'),
(27, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', NULL, 'Request successful', 'Success', 'Q84RMKZTVL927I9W', '03-SEP-21 03.35.36.476868 PM', '6199', '78463', '7922', '2021-09-03 13:35:35', '2021-09-03 13:35:35'),
(28, 'SUNDAY AGAGARAGA', 2, 'OJO', '123457853687', NULL, NULL, NULL, NULL, NULL, '12345', '47848', NULL, '2021-09-29 09:13:54', '2021-09-29 09:13:54'),
(29, 'SUNDAY AGAGARAGA', 2, 'OJO', '23456667778', NULL, NULL, NULL, NULL, NULL, '2314', '40785', NULL, '2021-09-29 09:19:27', '2021-09-29 09:19:27'),
(30, 'SUNDAY AGAGARAGA', 2, 'OJO', '23456667778', NULL, NULL, NULL, NULL, NULL, '3456', '39329', NULL, '2021-09-29 09:24:21', '2021-09-29 09:24:21'),
(31, 'SUNDAY AGAGARAGA', 2, 'OJO', '23456667778', NULL, NULL, NULL, NULL, NULL, '2000', '48472', NULL, '2021-09-29 09:55:42', '2021-09-29 09:55:42'),
(32, 'SUNDAY AGAGARAGA', 2, 'OJO', '23456667778', NULL, NULL, NULL, NULL, NULL, '2000', '14409', NULL, '2021-09-29 09:57:59', '2021-09-29 09:57:59'),
(33, 'SUNDAY AGAGARAGA', 4, 'OJO', '23456667778', NULL, NULL, NULL, NULL, NULL, '2300', '24313', NULL, '2021-09-29 11:28:48', '2021-09-29 11:28:48'),
(34, 'SUNDAY AGAGARAGA', 4, 'OJO', '23456667778', NULL, 'Request successful', 'Success', 'ELAXSXDOZ8S178RE', '29-SEP-21 02.46.10.230289 PM', '3000', '31283', NULL, '2021-09-29 12:46:10', '2021-09-29 12:46:10'),
(35, 'SUNDAY AGAGARAGA', 4, 'OJO', '23456667778', NULL, 'Request successful', 'Success', 'NY5WQWRW8ZE1JJFY', '29-SEP-21 02.48.53.081862 PM', '3000', '72147', '9494', '2021-09-29 12:48:53', '2021-09-29 12:48:53'),
(36, 'SUNDAY AGAGARAGA', 4, 'OJO', '23456667778', NULL, 'Request successful', 'Success', '4HNM7Z6PCQ6C5H3I', '29-SEP-21 02.52.25.214882 PM', '3000', '75805', '1611', '2021-09-29 12:52:25', '2021-09-29 12:52:25');

-- --------------------------------------------------------

--
-- Table structure for table `postpaid_payment_histories`
--

DROP TABLE IF EXISTS `postpaid_payment_histories`;
CREATE TABLE IF NOT EXISTS `postpaid_payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transactionNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchangeReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `externalReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionStatus` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meterNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'user_id = id in usertable',
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `postpaid_payment_histories`
--

INSERT INTO `postpaid_payment_histories` (`id`, `transactionNumber`, `status`, `exchangeReference`, `externalReference`, `accountNumber`, `transactionStatus`, `meterNumber`, `customerName`, `user_id`, `requestId`, `created_at`, `updated_at`) VALUES
(2, '162826301322378426', 'ACCEPTED', '1628263013906', NULL, '101512454501', 'Success', NULL, 'SUNDAY AGAGARAGA', NULL, '5918', NULL, NULL),
(3, '162919185432177506', 'PENDING', NULL, NULL, NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '1', '9754', NULL, NULL),
(4, '162919185433122058', 'PENDING', NULL, NULL, NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '1', '8683', NULL, NULL),
(5, '162919300461152591', 'PENDING', NULL, NULL, NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '1', '6250', NULL, NULL),
(6, '162919406409868121', 'PENDING', NULL, NULL, NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '1', '5010', NULL, NULL),
(7, '162919564021438696', 'PENDING', NULL, NULL, NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '1', '5424', NULL, NULL),
(8, '162927640016370300', 'PENDING', NULL, NULL, NULL, NULL, NULL, 'SUNDAY AGAGARAGA', '1', '1625', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prepaids`
--

DROP TABLE IF EXISTS `prepaids`;
CREATE TABLE IF NOT EXISTS `prepaids` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'user_id=userid',
  `customerDistrict` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meterNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phonNumber` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionReference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prepaids`
--

INSERT INTO `prepaids` (`id`, `customerName`, `user_id`, `customerDistrict`, `meterNumber`, `billerRequestId`, `message`, `phonNumber`, `status`, `transactionReference`, `transactionDate`, `amount`, `address`, `requestId`, `code`, `created_at`, `updated_at`) VALUES
(33, 'SUNDAY AGAGARAGA', 1, 'OJO', '54161045569', '7483', 'Request successful', '07038085132', 'Success', '2W1QQO7IELXFEH0P', '17-AUG-21 03.46.20.433105 AM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '56089', '', '2021-08-17 01:46:20', '2021-08-17 01:46:20'),
(32, 'SUNDAY AGAGARAGA', 1, 'OJO', '123456789123', '', 'Request successful', '', 'Failed', 'NHFKBOP4353WZJO0', '17-AUG-21 03.41.38.109051 AM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '77292', '', '2021-08-17 01:41:38', '2021-08-17 01:41:38'),
(30, 'SUNDAY AGAGARAGA', 1, 'OJO', '54161045569', '', 'Request successful', '', 'Failed', 'CAODU2AX53FV86Z9', '16-AUG-21 09.49.24.264081 PM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '57278', '', '2021-08-16 19:49:24', '2021-08-16 19:49:24'),
(31, 'SUNDAY AGAGARAGA', 1, 'OJO', '12345678921', '', 'Request successful', '', 'Failed', 'L905XYTC7Y0REGCV', '16-AUG-21 10.16.29.660187 PM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '79125', '', '2021-08-16 20:16:30', '2021-08-16 20:16:30'),
(29, 'SUNDAY AGAGARAGA', 1, 'OJO', '123456789123', '', 'Request successful', '', 'Failed', 'V3FLLYUXC6SGHMUI', '16-AUG-21 09.37.20.982667 PM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '19509', '', '2021-08-16 19:37:21', '2021-08-16 19:37:21'),
(28, 'SUNDAY AGAGARAGA', 1, 'OJO', '123456789123', '', 'Request successful', '', 'Failed', 'K3JLONDDQ4STEQ8O', '16-AUG-21 09.28.50.027587 PM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '12249', '', '2021-08-16 19:28:50', '2021-08-16 19:28:50'),
(27, 'SUNDAY AGAGARAGA', 1, 'OJO', '123456789123', '', 'Request successful', '', 'Failed', 'XIL2VOQ3CISI5605', '16-AUG-21 09.24.56.649237 PM', '4500', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '93121', '', '2021-08-16 19:24:57', '2021-08-16 19:24:57'),
(26, 'SUNDAY AGAGARAGA', 1, 'OJO', '12345678921', '', 'Request successful', '', 'Failed', 'MVVET6YTBMWJNWQO', '16-AUG-21 09.20.58.224332 PM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '67759', '', '2021-08-16 19:20:58', '2021-08-16 19:20:58'),
(34, 'SUNDAY AGAGARAGA', 1, 'OJO', '123456789123', '8178', 'Request successful', '', 'Success', 'M8FBR60JQR5K7X4B', '17-AUG-21 04.16.07.640574 AM', '4500', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '40169', '', '2021-08-17 02:16:08', '2021-08-17 02:16:08'),
(35, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', '2125', 'Request successful', '', 'Success', 'WY5BMLS571GEVP08', '17-AUG-21 10.25.44.927194 AM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '51236', '', '2021-08-17 08:25:45', '2021-08-17 08:25:45'),
(36, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', '8607', 'Request successful', '', 'Success', 'KP463YBV6GEJUL6A', '17-AUG-21 10.43.30.645880 AM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '77555', '', '2021-08-17 08:43:31', '2021-08-17 08:43:31'),
(37, 'SUNDAY AGAGARAGA', 1, 'OJO', '12345678921', '8176', 'Request successful', '', 'Success', 'YGM79UA08SEKI7SV', '17-AUG-21 11.31.33.235364 AM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '18391', '', '2021-08-17 09:31:33', '2021-08-17 09:31:33'),
(38, 'SUNDAY AGAGARAGA', 1, 'OJO', '12345678921', '7778', 'Request successful', '', 'Success', '27BJNNIK5337TYVA', '17-AUG-21 11.37.56.972500 AM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '10682', '', '2021-08-17 09:37:57', '2021-08-17 09:37:57'),
(39, 'SUNDAY AGAGARAGA', 1, 'OJO', '12345678921', '', '', '', '', '', '', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '45062', '', '2021-08-17 09:42:14', '2021-08-17 09:42:14'),
(40, 'SUNDAY AGAGARAGA', 1, 'OJO', '12345678921', '', '', '', '', '', '', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '58272', '', '2021-08-17 09:46:09', '2021-08-17 09:46:09'),
(41, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', '', '', '', '', '', '', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '47593', '', '2021-08-17 09:47:56', '2021-08-17 09:47:56'),
(42, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', '', '', '', '', '', '', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '76671', '', '2021-08-17 09:47:58', '2021-08-17 09:47:58'),
(43, 'SUNDAY AGAGARAGA', 1, 'OJO', '123456789223', '', '', '', '', '', '', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '80347', '', '2021-08-17 09:54:17', '2021-08-17 09:54:17'),
(44, 'SUNDAY AGAGARAGA', 1, 'OJO', '12345678921', '', '', '', '', '', '', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '15317', '', '2021-08-17 09:55:56', '2021-08-17 09:55:56'),
(45, 'SUNDAY AGAGARAGA', 1, 'OJO', '123456789223', '', '', '', '', '', '', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '48680', '', '2021-08-17 09:57:03', '2021-08-17 09:57:03'),
(46, 'SUNDAY AGAGARAGA', 1, 'OJO', '123456789223', '', '', '', '', '', '', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '23465', '', '2021-08-17 09:58:47', '2021-08-17 09:58:47'),
(47, 'SUNDAY AGAGARAGA', 2, 'OJO', '1234567890', '', 'Request successful', '', 'Failed', 'ERR1V62U6UF306MW', '17-AUG-21 09.17.41.156252 PM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '91044', '', '2021-08-17 19:17:42', '2021-08-17 19:17:42'),
(48, 'SUNDAY AGAGARAGA', 1, 'OJO', '54161045569', '5417', 'Request successful', '', 'Success', '9Q5N4SZJ12LK1VIY', '18-AUG-21 09.53.30.329775 AM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '83548', '', '2021-08-18 07:53:31', '2021-08-18 07:53:31'),
(49, 'SUNDAY AGAGARAGA', 2, 'OJO', '123456789123', '4589', 'Request successful', '', 'Success', '7ANYKGSC68S1MNG9', '19-AUG-21 09.56.16.904158 AM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '97548', '', '2021-08-19 07:56:18', '2021-08-19 07:56:18'),
(50, 'SUNDAY AGAGARAGA', 1, 'OJO', '123456789223', '4788', 'Request successful', '', 'Success', 'E244UT6W18RWWXB3', '24-AUG-21 09.42.29.385617 PM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '46015', '', '2021-08-24 19:42:21', '2021-08-24 19:42:21'),
(51, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', '', '', '', '', '', '', '200', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '80281', '', '2021-08-31 09:06:36', '2021-08-31 09:06:36'),
(52, 'SUNDAY AGAGARAGA', 1, 'OJO', '12345678921', '8719', 'Request successful', '', 'Success', 'XNMQAFR3P0TMXAFG', '31-AUG-21 03.58.00.682370 PM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '21621', '', '2021-08-31 13:57:59', '2021-08-31 13:57:59'),
(53, 'SUNDAY AGAGARAGA', 1, 'OJO', '123456789223', '1017', 'Request successful', '', 'Success', 'T172S0QGFJXHNJCS', '01-SEP-21 09.57.19.198712 AM', '3000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '66760', '', '2021-09-01 07:57:18', '2021-09-01 07:57:18'),
(54, 'SUNDAY AGAGARAGA', 1, 'OJO', '1234567890', '4146', 'Request successful', '', 'Success', '3VZG7OSJ78X2HYVQ', '03-SEP-21 03.26.08.077546 PM', '6200', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '18657', '', '2021-09-03 13:26:07', '2021-09-03 13:26:07'),
(55, 'SUNDAY AGAGARAGA', 2, 'OJO', '123456789', '', '', '', '', '', '', '30000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '92997', '', '2021-09-29 09:04:17', '2021-09-29 09:04:17'),
(56, 'SUNDAY AGAGARAGA', 2, 'OJO', '12345678790', '', '', '', '', '', '', '2344', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '31036', '', '2021-09-29 09:09:38', '2021-09-29 09:09:38'),
(57, 'SUNDAY AGAGARAGA', 4, 'OJO', '12314567809', '7569', 'Request successful', '', 'Success', '9C4JNNJEEN93WFBX', '29-SEP-21 02.13.42.341231 PM', '2345', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '58589', '', '2021-09-29 12:13:42', '2021-09-29 12:13:42'),
(58, 'SUNDAY AGAGARAGA', 4, 'OJO', '2145328790', '9449', 'Request successful', '', 'Success', '3FLPDJYWQZ4OZNV4', '29-SEP-21 02.42.20.848598 PM', '2300', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '39974', '', '2021-09-29 12:42:20', '2021-09-29 12:42:20'),
(59, 'SUNDAY AGAGARAGA', 4, 'OJO', '12314567809', '5118', 'Request successful', '', 'Success', 'H8LHB63RRSTH4E1N', '29-SEP-21 03.25.33.684442 PM', '5000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '22969', '', '2021-09-29 13:25:33', '2021-09-29 13:25:33'),
(60, 'SUNDAY AGAGARAGA', 4, 'OJO', '12345678790', '9925', 'Request successful', '', 'Success', 'H7ZQ84E1SLZAP8TP', '29-SEP-21 03.27.58.645985 PM', '2000', 'SHOLAJA ST, VICTORY EST, 5A, IBA', '92473', '', '2021-09-29 13:27:58', '2021-09-29 13:27:58');

-- --------------------------------------------------------

--
-- Table structure for table `prepaid_payment_histories`
--

DROP TABLE IF EXISTS `prepaid_payment_histories`;
CREATE TABLE IF NOT EXISTS `prepaid_payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transactionNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bsstTokenValue` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fixedTariff` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `standardTokenValue` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bsstTokenDescription` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fixedAmount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utilityAddress` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utilityName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debtAmount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clientId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bsstTokenDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utilityTaxReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchangeReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `standardTokenAmount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prepaid_payment_histories`
--

INSERT INTO `prepaid_payment_histories` (`id`, `transactionNumber`, `bsstTokenValue`, `fixedTariff`, `standardTokenValue`, `bsstTokenDescription`, `fixedAmount`, `utilityAddress`, `utilityName`, `debtAmount`, `clientId`, `user_id`, `bsstTokenDate`, `utilityTaxReference`, `exchangeReference`, `status`, `standardTokenAmount`, `customerName`, `requestId`, `created_at`, `updated_at`) VALUES
(1, '162892329835198045', '43587815953137626775', NULL, '53337830313650436279', NULL, NULL, NULL, NULL, NULL, NULL, '2', NULL, NULL, '1628923298891', 'ACCEPTED', '3000', 'SUNDAY AGAGARAGA', '1036', NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'PENDING', NULL, NULL, '3634', NULL, NULL),
(3, '162916907692391766', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, 'PENDING', NULL, 'SUNDAY AGAGARAGA', '1417', NULL, NULL),
(4, '162917019598240763', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, 'PENDING', NULL, 'SUNDAY AGAGARAGA', '8178', NULL, NULL),
(5, '162919239487541213', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, 'PENDING', NULL, 'SUNDAY AGAGARAGA', '2125', NULL, NULL),
(6, '162919349340161744', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, 'PENDING', NULL, 'SUNDAY AGAGARAGA', '8607', NULL, NULL),
(7, '162919633603449064', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, 'PENDING', NULL, 'SUNDAY AGAGARAGA', '8176', NULL, NULL),
(8, '162919675472835787', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, 'PENDING', NULL, 'SUNDAY AGAGARAGA', '7778', NULL, NULL),
(9, '162919762083458912', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, 'PENDING', NULL, 'SUNDAY AGAGARAGA', '9006', NULL, NULL),
(10, '162927683335673180', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, 'PENDING', NULL, 'SUNDAY AGAGARAGA', '5417', NULL, NULL),
(11, '162936340666346011', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2', NULL, NULL, NULL, 'PENDING', NULL, 'SUNDAY AGAGARAGA', '4589', NULL, NULL),
(12, '162937198166895946', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2', NULL, NULL, NULL, 'PENDING', NULL, 'SUNDAY AGAGARAGA', '6032', NULL, NULL),
(13, '162983778799714887', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, 'PENDING', NULL, 'SUNDAY AGAGARAGA', '4788', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Oy1lyXLYGzQ9DitrO31OB7Vl66F3wGKYTYPY2hVR', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidTZkUmRibFMyMlp1UXg3U1Rtdm5mT0hXQXp1dnR6WG1SVWlnSG0xTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly9sb2NhbGhvc3QvRWJpbGwvc2VydmljZXMvcHVibGljL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1633734591);

-- --------------------------------------------------------

--
-- Table structure for table `smilesrechargestransaction_histories`
--

DROP TABLE IF EXISTS `smilesrechargestransaction_histories`;
CREATE TABLE IF NOT EXISTS `smilesrechargestransaction_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchangeReference` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `smilesrechargestransaction_histories`
--

INSERT INTO `smilesrechargestransaction_histories` (`id`, `status`, `transactionNumber`, `requestId`, `customerName`, `email`, `accountId`, `exchangeReference`, `amount`, `user_id`, `transactionDate`, `created_at`, `updated_at`) VALUES
(59, 'ACCEPTED', '163039900368292922', '6211', 'Sabelo SABZA Dlangamandla', 'user1@gmail.com', '1402000567', 'UNIQUE-1973-7803216358', '3000', '3', '2021-08-31 08:36:43', NULL, NULL),
(58, 'ACCEPTED', '163039842719696803', '5615', 'Sabelo SABZA Dlangamandla', 'user1@gmail.com', '1402000567', 'UNIQUE-1973-8278892847', '3000', '3', '2021-08-31 08:27:06', NULL, NULL),
(56, 'ACCEPTED', '163032881164898945', '7953', 'Sabelo SABZA Dlangamandla', 'admin@gmail.com', '1402000567', 'UNIQUE-1973-6524852780', '3000', '1', '2021-08-30 13:06:52', NULL, NULL),
(57, 'ACCEPTED', '163033146730176354', '4757', 'Sabelo SABZA Dlangamandla', 'admin@gmail.com', '1402000567', 'UNIQUE-1973-3434164138', '3000', '1', '2021-08-30 13:51:08', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `smiles_bundletransaction_histories`
--

DROP TABLE IF EXISTS `smiles_bundletransaction_histories`;
CREATE TABLE IF NOT EXISTS `smiles_bundletransaction_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchangeReference` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `smiles_bundletransaction_histories`
--

INSERT INTO `smiles_bundletransaction_histories` (`id`, `status`, `transactionNumber`, `requestId`, `exchangeReference`, `customerName`, `email`, `accountId`, `amount`, `user_id`, `transactionDate`, `created_at`, `updated_at`) VALUES
(1, 'ACCEPTED', '163039743928446952', '7506', 'UNIQUE-1973-5203978251', 'Sabelo SABZA Dlangamandla', 'user1@gmail.com', '1402000567', '9000', '3', '2021-08-31 08:10:39', NULL, NULL),
(2, 'ACCEPTED', '163039745952260363', '7693', 'UNIQUE-1973-4387227789', 'Sabelo SABZA Dlangamandla', 'user1@gmail.com', '1402000567', '9000', '3', '2021-08-31 08:10:59', NULL, NULL),
(3, 'ACCEPTED', '163039803156511635', '5377', 'UNIQUE-1973-0342251575', 'Sabelo SABZA Dlangamandla', 'user1@gmail.com', '1402000567', '17000', '3', '2021-08-31 08:20:31', NULL, NULL),
(4, 'ACCEPTED', '163039861000774198', '9010', 'UNIQUE-1973-7082363650', 'Sabelo SABZA Dlangamandla', 'user1@gmail.com', '1402000567', '4000', '3', '2021-08-31 08:30:09', NULL, NULL),
(5, 'ACCEPTED', '163039886514542906', '7189', 'UNIQUE-1973-2402935911', 'Sabelo SABZA Dlangamandla', 'user1@gmail.com', '1402000567', '17000', '3', '2021-08-31 08:34:24', NULL, NULL),
(6, 'ACCEPTED', '163040210733912740', '5643', 'UNIQUE-1973-0534970815', 'Sabelo SABZA Dlangamandla', 'admin@gmail.com', '1402000567', '4000', '1', '2021-08-31 09:28:27', NULL, NULL),
(7, 'ACCEPTED', '163067852006535194', '3442', 'UNIQUE-1973-0270242270', 'Sabelo SABZA Dlangamandla', 'user@gmail.com', '1402000567', '9000', '2', '2021-09-03 14:15:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `smiles_recharges`
--

DROP TABLE IF EXISTS `smiles_recharges`;
CREATE TABLE IF NOT EXISTS `smiles_recharges` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `smiles_recharges`
--

INSERT INTO `smiles_recharges` (`id`, `name`, `accountId`, `email`, `amount`, `phone`, `date_created`, `requestId`, `billerRequestId`, `user_id`, `message`, `status`, `transactionDate`, `transactionReference`, `created_at`, `updated_at`) VALUES
(1, 'Sabelo SABZA Dlangamandla', '1402000567', 'admin@gmail.com', '6200', '07038085121', '2021-08-30 09:34:26', '53979', NULL, '1', NULL, NULL, NULL, NULL, '2021-08-30 08:34:26', '2021-08-30 08:34:26'),
(2, 'Sabelo SABZA Dlangamandla', '1402000567', 'admin@gmail.com', '6200', '07038085121', '2021-08-30 09:34:54', '67712', '8074', '1', 'Request successful', 'Success', '30-AUG-21 10.34.53.511685 AM', 'VY6GCQ1AG0RC3I9A', '2021-08-30 08:34:54', '2021-08-30 08:34:54'),
(3, 'Sabelo SABZA Dlangamandla', '1402000567', 'admin@gmail.com', '3000', '08027618122', '2021-08-30 10:41:53', '12874', '8618', '1', 'Request successful', 'Success', '30-AUG-21 11.41.52.842762 AM', 'VGPKQ07S95F4COWC', '2021-08-30 09:41:53', '2021-08-30 09:41:53'),
(4, 'Sabelo SABZA Dlangamandla', '1402000567', 'admin@gmail.com', '3000', '07036712564', '2021-08-30 10:56:40', '72923', '9033', '1', 'Request successful', 'Success', '30-AUG-21 11.56.39.970266 AM', 'XVXJKR5WH3AZHDXW', '2021-08-30 09:56:40', '2021-08-30 09:56:40'),
(5, 'Sabelo SABZA Dlangamandla', '1402000567', 'admin@gmail.com', '3000', '07036712564', '2021-08-30 11:04:48', '85609', '9800', '1', 'Request successful', 'Success', '30-AUG-21 12.04.47.701271 PM', 'OA78FWNMLBJXGGVL', '2021-08-30 10:04:48', '2021-08-30 10:04:48'),
(6, 'Sabelo SABZA Dlangamandla', '1402000567', 'admin@gmail.com', '3000', '07036712564', '2021-08-30 11:09:04', '13771', '1582', '1', 'Request successful', 'Success', '30-AUG-21 12.09.03.734347 PM', 'DRUQPXYIRIGVET7K', '2021-08-30 10:09:04', '2021-08-30 10:09:04'),
(7, 'Sabelo SABZA Dlangamandla', '1402000567', 'admin@gmail.com', '3000', '07038085121', '2021-08-30 13:06:21', '87114', '7953', '1', 'Request successful', 'Success', '30-AUG-21 02.06.20.859825 PM', '0ZXWY9G2Q0TCCU5I', '2021-08-30 12:06:21', '2021-08-30 12:06:21'),
(8, 'Sabelo SABZA Dlangamandla', '1402000567', 'admin@gmail.com', '3000', '08027618122', '2021-08-30 13:50:35', '47391', '4757', '1', 'Request successful', 'Success', '30-AUG-21 02.50.34.469912 PM', 'X4N1HRXIBWOAF61Y', '2021-08-30 12:50:35', '2021-08-30 12:50:35'),
(9, 'Sabelo SABZA Dlangamandla', '1402000567', 'user1@gmail.com', '3000', '08027618122', '2021-08-31 08:26:42', '93142', '5615', '3', 'Request successful', 'Success', '31-AUG-21 09.26.43.123960 AM', 'YVOKW6YDK9K3R7YB', '2021-08-31 07:26:42', '2021-08-31 07:26:42'),
(10, 'Sabelo SABZA Dlangamandla', '1402000567', 'user1@gmail.com', '3000', '08027618122', '2021-08-31 08:36:19', '84319', '6211', '3', 'Request successful', 'Success', '31-AUG-21 09.36.19.839756 AM', '999YSUEWID4TXPJ4', '2021-08-31 07:36:19', '2021-08-31 07:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `smile_bundles`
--

DROP TABLE IF EXISTS `smile_bundles`;
CREATE TABLE IF NOT EXISTS `smile_bundles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobileNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `smile_bundles`
--

INSERT INTO `smile_bundles` (`id`, `name`, `accountId`, `email`, `mobileNumber`, `amount`, `date_created`, `requestId`, `billerRequestId`, `user_id`, `message`, `status`, `transactionDate`, `transactionReference`, `created_at`, `updated_at`) VALUES
(1, 'Sabelo SABZA Dlangamandla', '1402000567', 'user1@gmail.com', '08027618122', '9000', '2021-08-31 07:38:04', '23603', '3074', '3', NULL, NULL, NULL, NULL, '2021-08-31 06:38:04', '2021-08-31 06:38:04'),
(2, 'Sabelo SABZA Dlangamandla', '1402000567', 'user1@gmail.com', '08027618122', '17000', '2021-08-31 08:19:52', '55428', '5377', '3', NULL, NULL, NULL, NULL, '2021-08-31 07:19:52', '2021-08-31 07:19:52'),
(3, 'Sabelo SABZA Dlangamandla', '1402000567', 'user1@gmail.com', '08027618122', '4000', '2021-08-31 08:29:36', '41096', '9010', '3', NULL, NULL, NULL, NULL, '2021-08-31 07:29:36', '2021-08-31 07:29:36'),
(4, 'Sabelo SABZA Dlangamandla', '1402000567', 'user1@gmail.com', '08126979718', '17000', '2021-08-31 08:34:00', '54013', '7189', '3', NULL, NULL, NULL, NULL, '2021-08-31 07:34:00', '2021-08-31 07:34:00'),
(5, 'Sabelo SABZA Dlangamandla', '1402000567', 'admin@gmail.com', '08027618122', '4000', '2021-08-31 09:27:39', '67044', '5643', '1', NULL, NULL, NULL, NULL, '2021-08-31 08:27:39', '2021-08-31 08:27:39'),
(6, 'Sabelo SABZA Dlangamandla', '1402000567', 'user@gmail.com', '08126979718', '9000', '2021-09-03 14:14:41', '99201', '3442', '2', NULL, NULL, NULL, NULL, '2021-09-03 13:14:41', '2021-09-03 13:14:41');

-- --------------------------------------------------------

--
-- Table structure for table `smile_bundle_packages`
--

DROP TABLE IF EXISTS `smile_bundle_packages`;
CREATE TABLE IF NOT EXISTS `smile_bundle_packages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `typeCode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `smile_bundle_packages`
--

INSERT INTO `smile_bundle_packages` (`id`, `typeCode`, `description`, `amount`, `date`, `created_at`, `updated_at`) VALUES
(1, '101', '500MB Data Bundle', '1800', '2021-08-30 21:16:56', '2021-08-30 20:16:56', '2021-08-30 20:16:56'),
(2, '102', '5GB Data Bundle', '4000', '2021-08-30 21:16:56', '2021-08-30 20:16:56', '2021-08-30 20:16:56'),
(3, '103', '5GB Night & Weekend Data Bundle', '9000', '2021-08-30 21:16:56', '2021-08-30 20:16:56', '2021-08-30 20:16:56'),
(4, '104', '10GB Night & Weekend Data Bundle', '17000', '2021-08-30 21:16:56', '2021-08-30 20:16:56', '2021-08-30 20:16:56'),
(5, '235', '20GB Night & Weekend Data Bundle', '19800', '2021-08-30 21:16:56', '2021-08-30 20:16:56', '2021-08-30 20:16:56'),
(6, '105', '100GB Data Bundle', '36000', '2021-08-30 21:16:56', '2021-08-30 20:16:56', '2021-08-30 20:16:56');

-- --------------------------------------------------------

--
-- Table structure for table `startimestransaction_histories`
--

DROP TABLE IF EXISTS `startimestransaction_histories`;
CREATE TABLE IF NOT EXISTS `startimestransaction_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `returnMessage` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smartCard` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `startimestransaction_histories`
--

INSERT INTO `startimestransaction_histories` (`id`, `status`, `transactionNumber`, `requestId`, `customerName`, `returnMessage`, `email`, `smartCard`, `amount`, `user_id`, `transactionDate`, `created_at`, `updated_at`) VALUES
(1, 'ACCEPTED', '163014511475213839', '9319', 'Fatima Shokunbi', 'succeeded, smart card 4131953321,mobile phone 0,amount NGN 3000.0,transaction id 2565496285. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', 'user1@gmail.com', '4131953321', '3000', '3', '2021-08-28 10:05:14', NULL, NULL),
(2, 'ACCEPTED', '163014556764531521', '4604', 'Fatima Shokunbi', 'succeeded, smart card 4131953321,mobile phone 0,amount NGN 3000.0,transaction id 5957192497. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', 'user1@gmail.com', '4131953321', '3000', '3', '2021-08-28 10:12:46', NULL, NULL),
(3, 'ACCEPTED', '163014567414132053', '8397', 'Fatima Shokunbi', 'succeeded, smart card 4131953321,mobile phone 0,amount NGN 3000.0,transaction id 9611660105. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', 'user1@gmail.com', '4131953321', '3000', '3', '2021-08-28 10:14:33', NULL, NULL),
(4, 'ACCEPTED', '163014587655294380', '6138', 'Fatima Shokunbi', 'succeeded, smart card 4131953321,mobile phone 0,amount NGN 3000.0,transaction id 0989577283. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', 'user1@gmail.com', '4131953321', '3000', '3', '2021-08-28 10:17:55', NULL, NULL),
(5, 'ACCEPTED', '163014597274421642', '5312', 'Fatima Shokunbi', 'succeeded, smart card 4131953321,mobile phone 0,amount NGN 3000.0,transaction id 0427704525. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', 'user1@gmail.com', '4131953321', '3000', '3', '2021-08-28 10:19:32', NULL, NULL),
(6, 'ACCEPTED', '163014616829450769', '7057', 'Fatima Shokunbi', 'succeeded, smart card 4131953321,mobile phone 0,amount NGN 3000.0,transaction id 6061815278. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', 'user1@gmail.com', '4131953321', '3000', '3', '2021-08-28 10:22:47', NULL, NULL),
(7, 'ACCEPTED', '163014633791042556', '3659', 'Fatima Shokunbi', 'succeeded, smart card 02021486421,mobile phone 0,amount NGN 6200.0,transaction id 7409874811. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', 'user1@gmail.com', '02021486421', '6200', '3', '2021-08-28 10:25:37', NULL, NULL),
(8, 'ACCEPTED', '163014649207959272', '3940', 'Fatima Shokunbi', 'succeeded, smart card 02021486421,mobile phone 0,amount NGN 6200.0,transaction id 3306852372. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', 'user1@gmail.com', '02021486421', '6200', '3', '2021-08-28 10:28:11', NULL, NULL),
(9, 'ACCEPTED', '163014659061264201', '8602', 'Fatima Shokunbi', 'succeeded, smart card 02021486421,mobile phone 0,amount NGN 6200.0,transaction id 2124051009. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', 'user1@gmail.com', '02021486421', '6200', '3', '2021-08-28 10:29:50', NULL, NULL),
(10, 'ACCEPTED', '163041807702717312', '9757', 'Abdulfatah', 'succeeded, smart card 4131953321,mobile phone 0,amount NGN 6200.0,transaction id 7369246025. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', 'admin@gmail.com', '4131953321', '6200', '1', '2021-08-31 13:54:38', NULL, NULL),
(11, 'ACCEPTED', '163041863704049724', '6926', 'Abdulfatah', 'succeeded, smart card 2005129242,mobile phone 0,amount NGN 3500.0,transaction id 5350080384. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', 'admin@gmail.com', '2005129242', '3500', '1', '2021-08-31 14:03:57', NULL, NULL),
(12, 'ACCEPTED', '163041866718768189', '9934', 'Abdulfatah', 'succeeded, smart card 2005129242,mobile phone 0,amount NGN 3500.0,transaction id 1631233272. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', 'admin@gmail.com', '2005129242', '3500', '1', '2021-08-31 14:04:27', NULL, NULL),
(13, 'ACCEPTED', '163041867224987893', '3580', 'Abdulfatah', 'succeeded, smart card 2005129242,mobile phone 0,amount NGN 3500.0,transaction id 5480674519. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', 'admin@gmail.com', '2005129242', '3500', '1', '2021-08-31 14:04:32', NULL, NULL),
(14, 'ACCEPTED', '163041872317160900', '1544', 'Abdulfatah', 'succeeded, smart card 2005129242,mobile phone 0,amount NGN 3500.0,transaction id 7276779345. Enjoy LIVE Bundesliga/SeriaA, AMC Movies, Nickelodeon and much more. Helpline:094618888', 'admin@gmail.com', '2005129242', '3500', '1', '2021-08-31 14:05:23', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `startimes_suscription_details`
--

DROP TABLE IF EXISTS `startimes_suscription_details`;
CREATE TABLE IF NOT EXISTS `startimes_suscription_details` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smartCard` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billerRequestId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionDate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionReference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `startimes_suscription_details`
--

INSERT INTO `startimes_suscription_details` (`id`, `name`, `smartCard`, `email`, `phone`, `amount`, `requestId`, `user_id`, `billerRequestId`, `message`, `status`, `transactionDate`, `date`, `transactionReference`, `created_at`, `updated_at`) VALUES
(1, 'Abdulfatah', '2005129242', 'admin@gmail.com', '08027618122', '3000', '84257', '1', NULL, NULL, NULL, NULL, '2021-08-27 16:40:22', NULL, '2021-08-27 15:40:22', '2021-08-27 15:40:22'),
(2, 'School Administrstor', '2005129242', 'user@gmail.com', '07038085121', '6200', '42557', '2', NULL, 'Request successful', 'Failed', '27-AUG-21 09.33.59.365021 PM', '2021-08-27 20:33:57', 'IUJLX9LVI873Y8MZ', '2021-08-27 19:33:57', '2021-08-27 19:33:57'),
(3, 'Fatima Shokunbi', '2005129242', 'user1@gmail.com', '07038085121', '3000', '30627', '3', NULL, 'Request successful', 'Failed', '28-AUG-21 10.53.23.267119 AM', '2021-08-28 09:53:21', 'JY9LAZDGR7CM25AJ', '2021-08-28 08:53:21', '2021-08-28 08:53:21'),
(4, 'Fatima Shokunbi', '2005129242', 'user1@gmail.com', '07038085121', '3000', '87135', '3', NULL, 'Request successful', 'Success', '28-AUG-21 10.54.22.633650 AM', '2021-08-28 09:54:20', 'E9KQGW3GS081OOGD', '2021-08-28 08:54:20', '2021-08-28 08:54:20'),
(5, 'Fatima Shokunbi', '2005129242', 'user1@gmail.com', '07036712564', '3000', '39527', '3', NULL, 'Request successful', 'Success', '28-AUG-21 10.59.04.375017 AM', '2021-08-28 09:59:02', 'GTFW89064JT52YY5', '2021-08-28 08:59:02', '2021-08-28 08:59:02'),
(6, 'Fatima Shokunbi', '4131953321', 'user1@gmail.com', '08027618122', '3000', '32345', '3', NULL, 'Request successful', 'Success', '28-AUG-21 11.00.31.596086 AM', '2021-08-28 10:00:29', '1IE799AMQIVXO6BK', '2021-08-28 09:00:29', '2021-08-28 09:00:29'),
(7, 'Fatima Shokunbi', '02021486421', 'user1@gmail.com', '08027618122', '3000', '52658', '3', NULL, 'Request successful', 'Success', '28-AUG-21 11.02.18.571653 AM', '2021-08-28 10:02:16', 'KDWU395LUQTHKIUI', '2021-08-28 09:02:16', '2021-08-28 09:02:16'),
(8, 'Fatima Shokunbi', '4131953321', 'user1@gmail.com', '07036712564', '3000', '31397', '3', '4258', 'Request successful', 'Success', '28-AUG-21 11.04.05.535425 AM', '2021-08-28 10:04:03', 'GRH18QU3IUQ2MV46', '2021-08-28 09:04:03', '2021-08-28 09:04:03'),
(9, 'Fatima Shokunbi', '4131953321', 'user1@gmail.com', '07036712564', '3000', '36770', '3', '4604', 'Request successful', 'Success', '28-AUG-21 11.12.21.781866 AM', '2021-08-28 10:12:19', 'C32PS2VIFWN3MBTB', '2021-08-28 09:12:19', '2021-08-28 09:12:19'),
(10, 'Fatima Shokunbi', '02021486421', 'user1@gmail.com', '07038085121', '6200', '19149', '3', '3659', 'Request successful', 'Success', '28-AUG-21 11.25.12.365094 AM', '2021-08-28 10:25:10', '7BIMB5C621PK83GA', '2021-08-28 09:25:10', '2021-08-28 09:25:10'),
(11, 'School Administrstor', '02021486421', 'user@gmail.com', '07038085121', '3000', '31494', '2', NULL, 'Request successful', 'Failed', '28-AUG-21 09.41.28.417778 PM', '2021-08-28 20:41:26', 'FH7CMRTSNRFBASNS', '2021-08-28 19:41:26', '2021-08-28 19:41:26'),
(12, 'Abdulfatah', '4131953321', 'admin@gmail.com', '08027618122', '6200', '45300', '1', '9757', 'Request successful', 'Success', '31-AUG-21 02.54.01.121496 PM', '2021-08-31 13:54:00', 'EAO6MKL2UA9T0X4C', '2021-08-31 12:54:00', '2021-08-31 12:54:00'),
(13, 'Abdulfatah', '2005129242', 'admin@gmail.com', '08027618122', '3500', '88437', '1', '6926', 'Request successful', 'Success', '31-AUG-21 03.02.50.463214 PM', '2021-08-31 14:02:49', 'ROEDL76LBY38AS8D', '2021-08-31 13:02:49', '2021-08-31 13:02:49'),
(14, 'Abdulfatah', '2005129242', 'admin@gmail.com', '08027618122', '6200', '96888', '1', '9702', 'Request successful', 'Success', '31-AUG-21 03.47.39.130511 PM', '2021-08-31 14:47:38', 'IQ1M9NUYKGJIA1A8', '2021-08-31 13:47:38', '2021-08-31 13:47:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userType` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userType`, `name`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, '', 'Abdulfatah', 'admin@gmail.com', '07036712564', NULL, '$2y$10$Hud0OyPh.mxzSZMp6rXDdOjSMuV6dNnDjveBJCXJTFWrVLgmoPY5a', NULL, NULL, NULL, '2021-08-05 11:39:35', '2021-08-05 12:27:16'),
(2, 'Admin', 'School Administrstor', 'user@gmail.com', '08027618122', NULL, '$2y$10$DX1yTU9cTyjNl23URHjT3ehPn8uir.VDQMsTtdoaxNPquIH7iGX8S', NULL, NULL, NULL, '2021-08-10 21:05:06', '2021-08-10 21:05:36'),
(3, '', 'Fatima Shokunbi', 'user1@gmail.com', '08126979718', NULL, '$2y$10$CcZsA4eu0SZA39c06Pth4.1e8yHenIV6Nykni0SiFXUIhD.SExLTu', NULL, NULL, NULL, '2021-08-23 11:01:30', '2021-08-23 11:02:38'),
(4, '', 'Abiodun Adio', 'showaa@gmail.com', '07038085121', NULL, '$2y$10$VRCBtbZfxEha.gmCYHJ5UO1WzwezUk/GE/VXUOpsAmABREle8oud2', NULL, NULL, NULL, '2021-09-29 11:28:04', '2021-09-29 11:28:45');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
