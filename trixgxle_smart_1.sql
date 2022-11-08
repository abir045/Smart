-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 25, 2022 at 07:51 AM
-- Server version: 10.3.35-MariaDB-log-cll-lve
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trixgxle_smart`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `id` int(11) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `uqid` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `paid` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cor_cat`
--

CREATE TABLE `cor_cat` (
  `id` int(11) NOT NULL,
  `title` varchar(1024) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cor_history`
--

CREATE TABLE `cor_history` (
  `id` int(11) NOT NULL,
  `buyer` varchar(1024) NOT NULL,
  `seller` varchar(1024) NOT NULL,
  `key` varchar(1024) NOT NULL,
  `product_title` varchar(1024) NOT NULL,
  `catagory_id` varchar(1024) NOT NULL,
  `price` varchar(1024) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cor_keys`
--

CREATE TABLE `cor_keys` (
  `id` int(11) NOT NULL,
  `key` varchar(1024) NOT NULL,
  `prod_id` varchar(1024) NOT NULL,
  `sold` varchar(1024) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cor_prods`
--

CREATE TABLE `cor_prods` (
  `id` int(11) NOT NULL,
  `title` varchar(1024) NOT NULL,
  `dsc` varchar(1024) NOT NULL DEFAULT '0',
  `img` varchar(1024) NOT NULL,
  `price` varchar(1024) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cat` varchar(128) NOT NULL,
  `seller` int(20) NOT NULL,
  `tut` varchar(1024) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payouts`
--

CREATE TABLE `payouts` (
  `id` int(11) NOT NULL,
  `seller` varchar(1024) NOT NULL,
  `amount` varchar(1024) NOT NULL,
  `status` varchar(1024) NOT NULL,
  `wallet` varchar(1024) NOT NULL,
  `coin` varchar(1024) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `coinbase_api` varchar(1024) NOT NULL,
  `coinbase_secret` varchar(1024) NOT NULL,
  `cut` varchar(1024) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `coinbase_api`, `coinbase_secret`, `cut`, `created_at`) VALUES
(1, 'x', 'x', '50', '2022-06-06 11:41:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `email` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `hash` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bal` float(64,3) NOT NULL DEFAULT 0.000
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`, `ip`, `verified`, `hash`, `bal`) VALUES
(1, 'admin', '$2y$10$Yur4NAOBbQj/ADePkpvh1OVvNU0c9GJz20GOg5IUEMgISI01iEmri', '1', 'afmin@gmail.com', '0', 1, '74bba22728b6185eec06286af6bec36d,1641981819', 450.000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cor_cat`
--
ALTER TABLE `cor_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cor_history`
--
ALTER TABLE `cor_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cor_keys`
--
ALTER TABLE `cor_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cor_prods`
--
ALTER TABLE `cor_prods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payouts`
--
ALTER TABLE `payouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
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
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cor_cat`
--
ALTER TABLE `cor_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cor_history`
--
ALTER TABLE `cor_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cor_keys`
--
ALTER TABLE `cor_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cor_prods`
--
ALTER TABLE `cor_prods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payouts`
--
ALTER TABLE `payouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
