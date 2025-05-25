-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 25, 2025 at 05:08 PM
-- Server version: 11.4.5-MariaDB-cll-lve
-- PHP Version: 8.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spkq4689_car_showroom`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`spkq4689`@`localhost` PROCEDURE `register` (IN `Name` VARCHAR(100), IN `Email` VARCHAR(100), IN `Pass` VARCHAR(100), IN `Phone` VARCHAR(100), IN `Address` VARCHAR(20))   BEGIN
INSERT INTO customer(name,email,pass,phone,address) VALUES (Name , Email, Pass, Phone, Address);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Cars`
--

CREATE TABLE `Cars` (
  `car_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `license_plate` varchar(50) NOT NULL,
  `price_asli` decimal(15,0) NOT NULL,
  `price` decimal(5,0) NOT NULL,
  `year_asli` int(5) NOT NULL,
  `year` int(11) NOT NULL,
  `physical_condition` tinyint(4) NOT NULL,
  `engine_condition` tinyint(4) NOT NULL,
  `document` tinyint(4) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ahp_value` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `showroom_id` int(11) DEFAULT NULL,
  `description` varchar(9999) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Cars`
--

INSERT INTO `Cars` (`car_id`, `name`, `license_plate`, `price_asli`, `price`, `year_asli`, `year`, `physical_condition`, `engine_condition`, `document`, `phone`, `created_at`, `ahp_value`, `image`, `showroom_id`, `description`) VALUES
(108, 'RUSH', 'DD 1782 AA', 220000000, 1, 2021, 5, 9, 9, 9, NULL, '2025-05-13 17:06:33', 3.98, '[\"1747155993_rush.jpg\",\"1747155993_rush1.jpg\",\"1747155993_rush2.jpg\",\"1747155993_rush3.jpg\",\"1747155993_rush5.jpg\",\"1747155993_rush6.jpg\"]', 1, NULL),
(109, 'TERIOS', 'PA 1855 GI', 220000000, 1, 2022, 7, 9, 9, 9, NULL, '2025-05-13 17:11:56', 4.47, '[\"1747156316_terios.jpg\",\"1747156316_terios1.jpg\",\"1747156316_terios2.jpg\",\"1747156316_terios3.jpg\",\"1747156316_terios5.jpg\"]', 1, NULL),
(110, 'AVANZA', 'PA 1640 GY', 110000000, 5, 2015, 1, 9, 9, 9, NULL, '2025-05-13 17:14:31', 5.02, '[\"1747156471_avanza.jpg\",\"1747156471_avanza1.jpg\",\"1747156471_avanza2.jpg\",\"1747156471_avanza3.jpg\",\"1747156471_avanza5.jpg\"]', 1, NULL),
(111, 'SIGRA', 'K 9332 TF', 100000000, 7, 2018, 3, 9, 9, 9, NULL, '2025-05-13 17:16:08', 6.52, '[\"1747156568_sigra.jpg\",\"1747156568_sigra1.jpg\",\"1747156568_sigra2.jpg\",\"1747156568_sigra3.jpg\",\"1747156568_sigra5.jpg\"]', 1, NULL),
(112, 'HILUX', 'H 1917 VH', 250000000, 1, 2019, 3, 9, 9, 9, NULL, '2025-05-13 17:17:18', 3.50, '[\"1747156638_hilux.jpg\",\"1747156638_hilux1.jpg\",\"1747156638_hilux2.jpg\",\"1747156638_hilux3.jpg\",\"1747156638_hilux5.jpg\"]', 1, NULL),
(113, 'ROCKY', 'B 1732 EZD', 190000000, 3, 2021, 5, 9, 9, 9, NULL, '2025-05-13 17:18:31', 4.99, '[\"1747156711_rocky.jpg\",\"1747156711_rocky1.jpg\",\"1747156711_rocky2.jpg\",\"1747156711_rocky3.jpg\",\"1747156711_rocky5.jpg\"]', 1, NULL),
(114, 'FORTUNER', 'PA 77 A', 360000000, 1, 2016, 1, 9, 9, 9, NULL, '2025-05-13 17:21:51', 3.01, '[\"1747156911_fortuner.jpg\",\"1747156911_fortuner1.jpg\",\"1747156911_fortuner2.jpg\",\"1747156911_fortuner3.jpg\",\"1747156911_fortuner5.jpg\",\"1747156911_fortuner6.jpg\"]', 2, NULL),
(115, 'PAJERO', 'KB 1032 KF', 205000000, 1, 2012, 1, 9, 9, 9, NULL, '2025-05-13 17:23:52', 3.01, '[\"1747157032_pajero.jpg\",\"1747157032_pajero1.jpg\",\"1747157032_pajero2.jpg\",\"1747157032_pajero3.jpg\",\"1747157032_pajero5.jpg\",\"1747157032_pajero6.jpg\"]', 2, NULL),
(116, 'XENIA', 'AB 1618 W', 113000000, 5, 2017, 1, 9, 9, 9, NULL, '2025-05-13 17:25:16', 5.02, '[\"1747157116_xenia.jpg\",\"1747157116_xenia1.jpg\",\"1747157116_xenia2.jpg\",\"1747157116_xenia3.jpg\",\"1747157116_xenia5.jpg\"]', 2, NULL),
(117, 'CARRY', 'G 9532 JZ', 110000000, 5, 2021, 5, 9, 9, 9, NULL, '2025-05-13 17:26:30', 6.00, '[\"1747157190_carry.jpg\",\"1747157190_carry1.jpg\",\"1747157190_carry2.jpg\",\"1747157190_carry3.jpg\",\"1747157190_carry5.jpg\"]', 2, NULL),
(119, 'TERIOS', 'Z 1751 TL', 220000000, 1, 2022, 7, 9, 9, 9, NULL, '2025-05-13 17:31:42', 4.47, '[\"1747157502_terios.jpg\",\"1747157502_terios1.jpg\",\"1747157502_terios2.jpg\",\"1747157502_terios3.jpg\"]', 2, NULL),
(120, 'CARRY', 'P 8311 VL', 135000000, 5, 2023, 7, 9, 9, 9, NULL, '2025-05-13 17:34:25', 6.49, '[\"1747157665_carry.jpg\",\"1747157665_carry1.jpg\",\"1747157665_carry2.jpg\",\"1747157665_carry3.jpg\",\"1747157665_carry5.jpg\",\"1747157665_carry6.jpg\"]', 3, NULL),
(121, 'AYLA', 'G 1646 PZ', 152000000, 3, 2023, 7, 9, 9, 9, NULL, '2025-05-13 17:35:46', 5.48, '[\"1747157746_ayla.jpg\",\"1747157746_ayla1.jpg\",\"1747157746_ayla2.jpg\",\"1747157746_ayla3.jpg\",\"1747157746_ayla5.jpg\"]', 3, NULL),
(122, 'TERIOS', 'L 1281 DAD', 220000000, 1, 2022, 7, 9, 9, 9, NULL, '2025-05-13 17:39:00', 4.47, '[\"1747157940_terios.jpg\",\"1747157940_terios1.jpg\",\"1747157940_terios2.jpg\",\"1747157940_terios3.jpg\"]', 3, NULL),
(123, 'HILUX', 'L 9363 BL', 365000000, 1, 2019, 3, 9, 9, 9, NULL, '2025-05-13 17:42:20', 3.50, '[\"1747158140_hilux.jpg\",\"1747158140_hilux1.jpg\",\"1747158140_hilux2.jpg\",\"1747158140_hilux3.jpg\",\"1747158141_hilux5.jpg\",\"1747158141_hilux6.jpg\"]', 3, NULL),
(124, 'SIGRA', 'A 1532 VJA', 160000000, 3, 2023, 7, 9, 9, 9, NULL, '2025-05-13 17:43:34', 5.48, '[\"1747158214_sigra.jpg\",\"1747158214_sigra1.jpg\",\"1747158214_sigra2.jpg\",\"1747158214_sigra3.jpg\",\"1747158214_sigra5.jpg\"]', 3, NULL),
(125, 'CARRY', 'F 8256 BF', 130000000, 5, 2023, 7, 9, 9, 9, NULL, '2025-05-13 17:51:06', 6.49, '[\"1747158666_carry.jpg\",\"1747158666_carry1.jpg\",\"1747158666_carry2.jpg\",\"1747158666_carry3.jpg\",\"1747158666_carry5.jpg\"]', 4, NULL),
(127, 'AVANZA', 'PA 1765 GY', 150000000, 5, 2018, 3, 9, 9, 9, NULL, '2025-05-13 17:53:31', 5.51, '[\"1747158811_avanza.jpg\",\"1747158811_avanza1.jpg\",\"1747158811_avanza3.jpg\",\"1747158811_avanza6.jpg\",\"1747158811_avanza7.jpg\",\"1747158811_avanza8.jpg\"]', 4, NULL),
(128, 'XENIA', 'PA 1805 GX', 175000000, 3, 2019, 3, 9, 9, 9, NULL, '2025-05-13 17:54:27', 4.50, '[\"1747158867_xenia.jpg\",\"1747158867_xenia1.jpg\",\"1747158867_xenia2.jpg\",\"1747158867_xenia3.jpg\",\"1747158867_xenia5.jpg\"]', 4, NULL),
(129, 'RUSH', 'T 1151 KG', 275000000, 1, 2023, 7, 9, 9, 9, NULL, '2025-05-13 17:57:13', 4.47, '[\"1747159033_rush.jpg\",\"1747159033_rush1.jpg\",\"1747159033_rush2.jpg\",\"1747159033_rush3.jpg\",\"1747159033_rush5.jpg\",\"1747159033_rush6.jpg\"]', 5, NULL),
(130, 'TERIOS X', 'T 1742 KJ', 235000000, 1, 2024, 9, 9, 9, 9, NULL, '2025-05-13 17:59:17', 4.96, '[\"1747159157_xterios.jpg\",\"1747159157_xterios1.jpg\",\"1747159157_xterios2.jpg\",\"1747159157_xterios3.jpg\",\"1747159157_xterios5.jpg\",\"1747159157_xterios6.jpg\"]', 5, NULL),
(131, 'TERIOS R', 'B 1460 ROV', 225000000, 1, 2024, 9, 9, 9, 9, NULL, '2025-05-13 18:01:20', 4.96, '[\"1747159280_rterios.jpg\",\"1747159280_rterios1.jpg\",\"1747159280_rterios2.jpg\",\"1747159280_rterios3.jpg\",\"1747159280_rterios5.jpg\"]', 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `criteria_weights`
--

CREATE TABLE `criteria_weights` (
  `id` int(11) NOT NULL,
  `weights` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `criteria_weights`
--

INSERT INTO `criteria_weights` (`id`, `weights`, `created_at`) VALUES
(1, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-09-20 13:17:28'),
(2, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-10-22 05:46:29'),
(3, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-10-22 05:49:01'),
(4, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-11-06 13:34:33'),
(5, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-11-08 11:53:52'),
(6, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-11-08 12:35:24'),
(7, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-11-17 01:52:30'),
(8, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-11-17 02:01:23'),
(9, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-11-17 02:03:08'),
(10, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-11-17 02:03:43'),
(11, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-11-23 13:22:24'),
(12, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-11-23 13:23:10'),
(13, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-11-23 13:25:00'),
(14, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-11-23 13:25:25'),
(15, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-11-23 13:26:45'),
(16, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-11-24 02:19:28'),
(17, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-11-24 02:44:23'),
(18, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2024-11-24 13:35:58'),
(19, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-05 15:14:57'),
(20, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-05 15:15:28'),
(21, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-05 15:50:57'),
(22, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-05 15:52:04'),
(23, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-05 15:52:10'),
(24, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-05 15:52:14'),
(25, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-05 15:55:20'),
(26, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-05 15:56:15'),
(27, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-05 15:56:54'),
(28, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-05 15:58:14'),
(29, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 14:52:21'),
(30, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 14:54:47'),
(31, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 14:54:50'),
(32, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 14:55:28'),
(33, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:01:36'),
(34, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:02:30'),
(35, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:03:00'),
(36, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:04:55'),
(37, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:05:05'),
(38, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:05:29'),
(39, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:06:56'),
(40, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:09:52'),
(41, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:10:14'),
(42, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:10:16'),
(43, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:12:23'),
(44, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:15:43'),
(45, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:16:38'),
(46, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:19:10'),
(47, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:19:14'),
(48, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:28:44'),
(49, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-06 15:30:38'),
(50, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-08 17:00:44'),
(51, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-08 17:00:49'),
(52, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-08 17:00:52'),
(53, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-08 17:01:24'),
(54, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-12 05:44:54'),
(55, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-12 05:45:18'),
(56, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-12 05:45:21'),
(57, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-12 05:45:22'),
(58, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-12 05:45:23'),
(59, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-12 05:45:23'),
(60, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-12 05:45:23'),
(61, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-12 05:45:23'),
(62, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-12 05:45:23'),
(63, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-12 05:45:23'),
(64, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-12 05:45:23'),
(65, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-12 05:45:24'),
(66, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-12 05:45:24'),
(67, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-12 05:45:24'),
(68, '{\"Harga\":0.24427236452163884,\"Tahun Keluaran\":0.34436949518181453,\"Kondisi Mesin\":0.2324307874765467,\"Kondisi Fisik\":0.16503241578769168,\"Kelengkapan Dokumen\":0.013894937032308274}', '2025-05-12 05:46:28'),
(69, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621886,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309235}', '2025-05-13 13:20:24'),
(70, 'false', '2025-05-13 13:51:25'),
(71, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621886,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309235}', '2025-05-13 13:52:53'),
(72, 'false', '2025-05-13 14:05:00'),
(73, '{\"Harga\":0.5044744521429854,\"Tahun Keluaran\":0.24483445725078465,\"Kondisi Mesin\":0.14299347165837184,\"Kondisi Fisik\":0.07233725103053171,\"Kelengkapan Dokumen\":0.035360367917326496}', '2025-05-13 14:21:31'),
(74, '{\"Harga\":0.5044744521429854,\"Tahun Keluaran\":0.24483445725078465,\"Kondisi Mesin\":0.14299347165837184,\"Kondisi Fisik\":0.07233725103053171,\"Kelengkapan Dokumen\":0.035360367917326496}', '2025-05-13 14:22:17'),
(75, '{\"Harga\":0.5044744521429854,\"Tahun Keluaran\":0.24483445725078465,\"Kondisi Mesin\":0.14299347165837184,\"Kondisi Fisik\":0.07233725103053171,\"Kelengkapan Dokumen\":0.035360367917326496}', '2025-05-13 14:22:48'),
(76, '{\"Harga\":0.5044744521429854,\"Tahun Keluaran\":0.24483445725078465,\"Kondisi Mesin\":0.14299347165837184,\"Kondisi Fisik\":0.07233725103053171,\"Kelengkapan Dokumen\":0.035360367917326496}', '2025-05-13 14:26:48'),
(77, '{\"Harga\":0.5044744521429854,\"Tahun Keluaran\":0.24483445725078465,\"Kondisi Mesin\":0.14299347165837184,\"Kondisi Fisik\":0.07233725103053171,\"Kelengkapan Dokumen\":0.035360367917326496}', '2025-05-13 14:31:35'),
(78, '{\"Harga\":0.5044744521429854,\"Tahun Keluaran\":0.24483445725078465,\"Kondisi Mesin\":0.14299347165837184,\"Kondisi Fisik\":0.07233725103053171,\"Kelengkapan Dokumen\":0.035360367917326496}', '2025-05-14 01:23:06'),
(79, '{\"Harga\":0.5044744521429854,\"Tahun Keluaran\":0.24483445725078465,\"Kondisi Mesin\":0.14299347165837184,\"Kondisi Fisik\":0.07233725103053171,\"Kelengkapan Dokumen\":0.035360367917326496}', '2025-05-14 01:33:05'),
(80, '{\"Harga\":0.5044744521429854,\"Tahun Keluaran\":0.24483445725078465,\"Kondisi Mesin\":0.14299347165837184,\"Kondisi Fisik\":0.07233725103053171,\"Kelengkapan Dokumen\":0.035360367917326496}', '2025-05-14 01:39:08'),
(81, '{\"Harga\":0.5044744521429854,\"Tahun Keluaran\":0.24483445725078465,\"Kondisi Mesin\":0.14299347165837184,\"Kondisi Fisik\":0.07233725103053171,\"Kelengkapan Dokumen\":0.035360367917326496}', '2025-05-14 14:28:29'),
(82, '{\"Harga\":0.5044744521429854,\"Tahun Keluaran\":0.24483445725078465,\"Kondisi Mesin\":0.14299347165837184,\"Kondisi Fisik\":0.07233725103053171,\"Kelengkapan Dokumen\":0.035360367917326496}', '2025-05-14 15:33:20'),
(83, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-14 17:14:23'),
(84, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-14 17:37:41'),
(85, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-14 17:37:43'),
(86, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-15 18:55:24'),
(87, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-17 10:50:26'),
(88, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-17 20:38:23'),
(89, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-17 20:41:10'),
(90, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-17 20:53:23'),
(91, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 15:48:11'),
(92, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 15:51:20'),
(93, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 15:57:33'),
(94, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 16:14:00'),
(95, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 16:16:01'),
(96, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 16:18:22'),
(97, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 16:45:08'),
(98, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 16:45:51'),
(99, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:06:08'),
(100, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:06:09'),
(101, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:06:09'),
(102, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:06:10'),
(103, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:06:10'),
(104, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:06:38'),
(105, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:13:55'),
(106, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:18:40'),
(107, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:18:47'),
(108, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:18:48'),
(109, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:18:48'),
(110, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:18:49'),
(111, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:18:49'),
(112, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:18:49'),
(113, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:18:49'),
(114, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:18:50'),
(115, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:18:50'),
(116, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:18:50'),
(117, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:18:50'),
(118, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:19:05'),
(119, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:19:06'),
(120, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:19:07'),
(121, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:19:07'),
(122, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:19:38'),
(123, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:22:45'),
(124, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:22:46'),
(125, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:22:47'),
(126, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:22:48'),
(127, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:22:48'),
(128, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:22:48'),
(129, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:23:52'),
(130, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:24:36'),
(131, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:25:50'),
(132, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 17:41:55'),
(133, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:17:24'),
(134, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:17:33'),
(135, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:18:11'),
(136, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:19:12'),
(137, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:20:10'),
(138, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:20:12'),
(139, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:21:14'),
(140, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:23:25'),
(141, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:23:28'),
(142, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:27:53'),
(143, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:28:48'),
(144, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:34:24'),
(145, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:35:19'),
(146, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:36:32'),
(147, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:37:24'),
(148, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:37:33'),
(149, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:39:41'),
(150, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:46:06'),
(151, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 20:46:23'),
(152, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-18 21:02:20'),
(153, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-21 03:08:39'),
(154, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-21 03:18:27'),
(155, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-21 05:22:39'),
(156, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-21 05:24:30'),
(157, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-21 05:25:16'),
(158, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-21 05:34:22'),
(159, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-21 05:44:16'),
(160, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-21 05:48:44'),
(161, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-21 05:58:13'),
(162, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-21 06:02:23'),
(163, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-21 06:13:36'),
(164, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-21 06:14:46'),
(165, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-21 06:15:50'),
(166, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-21 06:27:44'),
(167, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-21 06:35:54'),
(168, '{\"Harga\":0.5044382682908679,\"Tahun Keluaran\":0.24539848104541467,\"Kondisi Mesin\":0.14278915975621884,\"Kondisi Fisik\":0.07225096915440621,\"Kelengkapan Dokumen\":0.03512312175309236}', '2025-05-21 06:37:17'),
(169, '{\"Harga\":0.5044382682908679083055858427542261779308319091796875,\"Tahun Keluaran\":0.245398481045414673662463656000909395515918731689453125,\"Kondisi Mesin\":0.1427891597562188363834678739294758997857570648193359375,\"Kondisi Fisik\":0.0722509691544062082613208986003883183002471923828125,\"Kelengkapan Dokumen\":0.03512312175309235950937392090054345317184925079345703125}', '2025-05-21 17:16:25'),
(170, '{\"Harga\":0.5044382682908679083055858427542261779308319091796875,\"Tahun Keluaran\":0.245398481045414673662463656000909395515918731689453125,\"Kondisi Mesin\":0.1427891597562188363834678739294758997857570648193359375,\"Kondisi Fisik\":0.0722509691544062082613208986003883183002471923828125,\"Kelengkapan Dokumen\":0.03512312175309235950937392090054345317184925079345703125}', '2025-05-21 17:16:35'),
(171, '{\"Harga\":0.5044382682908679083055858427542261779308319091796875,\"Tahun Keluaran\":0.245398481045414673662463656000909395515918731689453125,\"Kondisi Mesin\":0.1427891597562188363834678739294758997857570648193359375,\"Kondisi Fisik\":0.0722509691544062082613208986003883183002471923828125,\"Kelengkapan Dokumen\":0.03512312175309235950937392090054345317184925079345703125}', '2025-05-21 17:20:06'),
(172, '{\"Harga\":0.5044382682908679083055858427542261779308319091796875,\"Tahun Keluaran\":0.245398481045414673662463656000909395515918731689453125,\"Kondisi Mesin\":0.1427891597562188363834678739294758997857570648193359375,\"Kondisi Fisik\":0.0722509691544062082613208986003883183002471923828125,\"Kelengkapan Dokumen\":0.03512312175309235950937392090054345317184925079345703125}', '2025-05-21 17:34:15'),
(173, '{\"Harga\":0.5044382682908679083055858427542261779308319091796875,\"Tahun Keluaran\":0.245398481045414673662463656000909395515918731689453125,\"Kondisi Mesin\":0.1427891597562188363834678739294758997857570648193359375,\"Kondisi Fisik\":0.0722509691544062082613208986003883183002471923828125,\"Kelengkapan Dokumen\":0.03512312175309235950937392090054345317184925079345703125}', '2025-05-21 17:42:29'),
(174, '{\"Harga\":0.5044382682908679083055858427542261779308319091796875,\"Tahun Keluaran\":0.245398481045414673662463656000909395515918731689453125,\"Kondisi Mesin\":0.1427891597562188363834678739294758997857570648193359375,\"Kondisi Fisik\":0.0722509691544062082613208986003883183002471923828125,\"Kelengkapan Dokumen\":0.03512312175309235950937392090054345317184925079345703125}', '2025-05-21 17:45:42'),
(175, '{\"Harga\":0.5044382682908679083055858427542261779308319091796875,\"Tahun Keluaran\":0.245398481045414673662463656000909395515918731689453125,\"Kondisi Mesin\":0.1427891597562188363834678739294758997857570648193359375,\"Kondisi Fisik\":0.0722509691544062082613208986003883183002471923828125,\"Kelengkapan Dokumen\":0.03512312175309235950937392090054345317184925079345703125}', '2025-05-23 04:53:38'),
(176, '{\"Harga\":0.5044382682908679083055858427542261779308319091796875,\"Tahun Keluaran\":0.245398481045414673662463656000909395515918731689453125,\"Kondisi Mesin\":0.1427891597562188363834678739294758997857570648193359375,\"Kondisi Fisik\":0.0722509691544062082613208986003883183002471923828125,\"Kelengkapan Dokumen\":0.03512312175309235950937392090054345317184925079345703125}', '2025-05-23 04:53:39'),
(177, '{\"Harga\":0.5044382682908679083055858427542261779308319091796875,\"Tahun Keluaran\":0.245398481045414673662463656000909395515918731689453125,\"Kondisi Mesin\":0.1427891597562188363834678739294758997857570648193359375,\"Kondisi Fisik\":0.0722509691544062082613208986003883183002471923828125,\"Kelengkapan Dokumen\":0.03512312175309235950937392090054345317184925079345703125}', '2025-05-23 04:54:02'),
(178, '{\"Harga\":0.5044382682908679083055858427542261779308319091796875,\"Tahun Keluaran\":0.245398481045414673662463656000909395515918731689453125,\"Kondisi Mesin\":0.1427891597562188363834678739294758997857570648193359375,\"Kondisi Fisik\":0.0722509691544062082613208986003883183002471923828125,\"Kelengkapan Dokumen\":0.03512312175309235950937392090054345317184925079345703125}', '2025-05-23 05:19:01'),
(179, '{\"Harga\":0.5044382682908679083055858427542261779308319091796875,\"Tahun Keluaran\":0.245398481045414673662463656000909395515918731689453125,\"Kondisi Mesin\":0.1427891597562188363834678739294758997857570648193359375,\"Kondisi Fisik\":0.0722509691544062082613208986003883183002471923828125,\"Kelengkapan Dokumen\":0.03512312175309235950937392090054345317184925079345703125}', '2025-05-23 05:19:07'),
(180, '{\"Harga\":0.5044382682908679083055858427542261779308319091796875,\"Tahun Keluaran\":0.245398481045414673662463656000909395515918731689453125,\"Kondisi Mesin\":0.1427891597562188363834678739294758997857570648193359375,\"Kondisi Fisik\":0.0722509691544062082613208986003883183002471923828125,\"Kelengkapan Dokumen\":0.03512312175309235950937392090054345317184925079345703125}', '2025-05-23 05:19:12'),
(181, '{\"Harga\":0.5044382682908679083055858427542261779308319091796875,\"Tahun Keluaran\":0.245398481045414673662463656000909395515918731689453125,\"Kondisi Mesin\":0.1427891597562188363834678739294758997857570648193359375,\"Kondisi Fisik\":0.0722509691544062082613208986003883183002471923828125,\"Kelengkapan Dokumen\":0.03512312175309235950937392090054345317184925079345703125}', '2025-05-23 05:19:15'),
(182, '{\"Harga\":0.5044382682908679083055858427542261779308319091796875,\"Tahun Keluaran\":0.245398481045414673662463656000909395515918731689453125,\"Kondisi Mesin\":0.1427891597562188363834678739294758997857570648193359375,\"Kondisi Fisik\":0.0722509691544062082613208986003883183002471923828125,\"Kelengkapan Dokumen\":0.03512312175309235950937392090054345317184925079345703125}', '2025-05-23 08:22:50'),
(183, '{\"Harga\":0.5044382682908679083055858427542261779308319091796875,\"Tahun Keluaran\":0.245398481045414673662463656000909395515918731689453125,\"Kondisi Mesin\":0.1427891597562188363834678739294758997857570648193359375,\"Kondisi Fisik\":0.0722509691544062082613208986003883183002471923828125,\"Kelengkapan Dokumen\":0.03512312175309235950937392090054345317184925079345703125}', '2025-05-23 08:35:08'),
(184, '{\"Harga\":0.5044382682908679083055858427542261779308319091796875,\"Tahun Keluaran\":0.245398481045414673662463656000909395515918731689453125,\"Kondisi Mesin\":0.1427891597562188363834678739294758997857570648193359375,\"Kondisi Fisik\":0.0722509691544062082613208986003883183002471923828125,\"Kelengkapan Dokumen\":0.03512312175309235950937392090054345317184925079345703125}', '2025-05-23 08:45:37');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `c_id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `role` enum('superadmin','admin','customer') NOT NULL,
  `showroom_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`c_id`, `email`, `pass`, `role`, `showroom_id`) VALUES
(1, 'admin2', 'admin', 'admin', 2),
(2, 'admin1', 'admin', 'admin', 1),
(3, 'rizky', 'gondrong', 'superadmin', NULL),
(4, 'admin3', 'admin', 'admin', 3),
(5, 'admin4', 'admin', 'admin', 4),
(6, 'admin5', 'admin', 'admin', 5);

-- --------------------------------------------------------

--
-- Table structure for table `experts`
--

CREATE TABLE `experts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `criteria_weights` text NOT NULL,
  `matrix` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `experts`
--

INSERT INTO `experts` (`id`, `name`, `criteria_weights`, `matrix`) VALUES
(6, 'Showroom Sadewa', '{\r\n        \"harga_vs_tahun\": \"9\",\r\n        \"harga_vs_mesin\": \"5\",\r\n        \"harga_vs_fisik\": \"3\",\r\n        \"harga_vs_dokumen\": \"7\",\r\n        \"tahun_vs_mesin\": \"0.2\",\r\n        \"tahun_vs_fisik\": \"0.142\",\r\n        \"tahun_vs_dokumen\": \"0.333\",\r\n        \"mesin_vs_fisik\": \"3\",\r\n        \"mesin_vs_dokumen\": \"3\",\r\n        \"fisik_vs_dokumen\": \"5\"\r\n    }', '[\r\n        [1, 3, 5, 7, 9],\r\n        [0.333, 1, 3, 5, 7],\r\n        [0.2, 0.333, 1, 3, 5],\r\n        [0.142, 0.2, 0.333, 1, 3],\r\n        [0.111, 0.142, 0.2, 0.333, 1]\r\n    ]'),
(7, 'Showroom Akbar Motor', '{\r\n        \"harga_vs_tahun\": \"9\",\r\n        \"harga_vs_mesin\": \"6\",\r\n        \"harga_vs_fisik\": \"4\",\r\n        \"harga_vs_dokumen\": \"8\",\r\n        \"tahun_vs_mesin\": \"0.166\",\r\n        \"tahun_vs_fisik\": \"0.25\",\r\n        \"tahun_vs_dokumen\": \"0.333\",\r\n        \"mesin_vs_fisik\": \"3\",\r\n        \"mesin_vs_dokumen\": \"4\",\r\n        \"fisik_vs_dokumen\": \"5\"\r\n    }', '[\r\n        [1, 4, 6, 8, 9],\r\n        [0.25, 1, 3, 5, 7],\r\n        [0.166, 0.333, 1, 4, 6],\r\n        [0.125, 0.2, 0.25, 1, 3],\r\n        [0.111, 0.142, 0.166, 0.333, 1]\r\n    ]'),
(8, 'Showroom Rizki Jaya Mobil', '{\r\n        \"harga_vs_tahun\": \"8\",\r\n        \"harga_vs_mesin\": \"4\",\r\n        \"harga_vs_fisik\": \"2\",\r\n        \"harga_vs_dokumen\": \"6\",\r\n        \"tahun_vs_mesin\": \"0.2\",\r\n        \"tahun_vs_fisik\": \"0.142\",\r\n        \"tahun_vs_dokumen\": \"0.25\",\r\n        \"mesin_vs_fisik\": \"3\",\r\n        \"mesin_vs_dokumen\": \"3\",\r\n        \"fisik_vs_dokumen\": \"5\"\r\n    }', '[\r\n        [1, 2, 4, 6, 8],\r\n        [0.5, 1, 3, 5, 7],\r\n        [0.25, 0.333, 1, 3, 5],\r\n        [0.166, 0.2, 0.333, 1, 4],\r\n        [0.125, 0.142, 0.2, 0.25, 1]\r\n    ]'),
(9, 'Showroom Nadia', '{\r\n        \"harga_vs_tahun\": \"8\",\r\n        \"harga_vs_mesin\": \"5\",\r\n        \"harga_vs_fisik\": \"3\",\r\n        \"harga_vs_dokumen\": \"6\",\r\n        \"tahun_vs_mesin\": \"0.2\",\r\n        \"tahun_vs_fisik\": \"0.166\",\r\n        \"tahun_vs_dokumen\": \"0.333\",\r\n        \"mesin_vs_fisik\": \"2\",\r\n        \"mesin_vs_dokumen\": \"3\",\r\n        \"fisik_vs_dokumen\": \"4\"\r\n    }', '[\r\n        [1, 3, 5, 6, 8],\r\n        [0.333, 1, 2, 4, 6],\r\n        [0.2, 0.5, 1, 3, 5],\r\n        [0.166, 0.25, 0.333, 1, 3],\r\n        [0.125, 0.166, 0.2, 0.333, 1]\r\n    ]'),
(10, 'Showroom Ronggolawe', '{\r\n        \"harga_vs_tahun\": \"9\",\r\n        \"harga_vs_mesin\": \"5\",\r\n        \"harga_vs_fisik\": \"4\",\r\n        \"harga_vs_dokumen\": \"7\",\r\n        \"tahun_vs_mesin\": \"0.2\",\r\n        \"tahun_vs_fisik\": \"0.166\",\r\n        \"tahun_vs_dokumen\": \"0.25\",\r\n        \"mesin_vs_fisik\": \"2\",\r\n        \"mesin_vs_dokumen\": \"3\",\r\n        \"fisik_vs_dokumen\": \"4\"\r\n    }', '[\r\n        [1, 4, 5, 7, 9],\r\n        [0.25, 1, 2, 4, 6],\r\n        [0.2, 0.5, 1, 3, 5],\r\n        [0.142, 0.25, 0.333, 1, 4],\r\n        [0.111, 0.166, 0.2, 0.25, 1]\r\n    ]');

-- --------------------------------------------------------

--
-- Table structure for table `Showrooms`
--

CREATE TABLE `Showrooms` (
  `showroom_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Showrooms`
--

INSERT INTO `Showrooms` (`showroom_id`, `name`, `description`, `location`, `contact`, `image`) VALUES
(1, 'Nadia Showroom', 'Jl. Brawijaya, Merauke', 'Jl. Brawijaya, Merauke', '0813-4472-9889', 'https://via.placeholder.com/375x210?text=Nadia+Motors'),
(2, 'Ronggolawe Showroom', 'Jl. Garuda Spadem, Merauke', 'Jl. Garuda Spadem, Merauke', '0811-4901-892', 'https://via.placeholder.com/375x210?text=Ronggolawe+Auto'),
(3, 'Rizky Jaya Showroom', 'Jl. Gak, Merauke', 'Jl. Gak, Merauke', '0852-4695-9953', 'https://via.placeholder.com/375x210?text=Rizky+Jaya+Mobil'),
(4, 'Akbar Motor Showroom', 'Jl. Gak, Merauke', 'Jl. Gak, Merauke', '0812-4846-5677', 'https://via.placeholder.com/375x210?text=Chevrolet+Express'),
(5, 'Sadewa Showroom', 'Jl. Gak, Merauke', 'Jl. Gak, Merauke', '0813-4443-1283', 'https://via.placeholder.com/375x210?text=Papua+Auto+Centre');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Cars`
--
ALTER TABLE `Cars`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `showroom_id` (`showroom_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `criteria_weights`
--
ALTER TABLE `criteria_weights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `fk_showroom` (`showroom_id`);

--
-- Indexes for table `experts`
--
ALTER TABLE `experts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Showrooms`
--
ALTER TABLE `Showrooms`
  ADD PRIMARY KEY (`showroom_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Cars`
--
ALTER TABLE `Cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `criteria_weights`
--
ALTER TABLE `criteria_weights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `experts`
--
ALTER TABLE `experts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Showrooms`
--
ALTER TABLE `Showrooms`
  MODIFY `showroom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Cars`
--
ALTER TABLE `Cars`
  ADD CONSTRAINT `Cars_ibfk_1` FOREIGN KEY (`showroom_id`) REFERENCES `Showrooms` (`showroom_id`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`showroom_id`) REFERENCES `Showrooms` (`showroom_id`),
  ADD CONSTRAINT `fk_showroom` FOREIGN KEY (`showroom_id`) REFERENCES `Showrooms` (`showroom_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
