-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2017 at 11:53 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_booking_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(250) DEFAULT NULL,
  `cat_ico_class` varchar(250) DEFAULT NULL,
  `cat_ico_image` varchar(250) DEFAULT NULL,
  `cat_home` enum('Y','N') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_ico_class`, `cat_ico_image`, `cat_home`) VALUES
(1, 'Electronics & Gedget', 'icofont icofont-laptop-alt', NULL, 'Y'),
(2, 'Cars & Vehicles', 'icofont icofont-police-car-alt-2', NULL, 'Y'),
(3, 'Property', 'icofont icofont-building-alt', NULL, 'Y'),
(4, 'Home & Garden', 'icofont icofont-ui-home', NULL, 'Y'),
(5, 'Pets & Animals', 'icofont icofont-animal-dog', NULL, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `com_fname` varchar(250) DEFAULT NULL,
  `com_lname` varchar(250) DEFAULT NULL,
  `com_address` varchar(250) DEFAULT NULL,
  `com_phone` varchar(250) DEFAULT NULL,
  `Column 13` varchar(250) DEFAULT NULL,
  `com_email` varchar(250) DEFAULT NULL,
  `com_fb` varchar(250) DEFAULT NULL,
  `com_tw` varchar(250) DEFAULT NULL,
  `com_yt` varchar(250) DEFAULT NULL,
  `com_logo` varchar(250) DEFAULT NULL,
  `com_province` varchar(250) DEFAULT NULL,
  `com_username` varchar(250) DEFAULT NULL,
  `com_password` varchar(250) DEFAULT NULL,
  `com_online` varchar(250) DEFAULT NULL,
  `com_activation` varchar(250) DEFAULT NULL,
  `com_status` varchar(250) DEFAULT NULL,
  `reg_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `pro_name` varchar(250) DEFAULT NULL,
  `pro_description` longtext,
  `pro_condition` varchar(250) DEFAULT NULL,
  `pro_brand` varchar(250) DEFAULT NULL,
  `pro_features` varchar(250) DEFAULT NULL,
  `pro_model` varchar(250) DEFAULT NULL,
  `post_date` timestamp NULL DEFAULT NULL,
  `ads_id` varchar(250) DEFAULT NULL,
  `pro_base_price` decimal(10,2) DEFAULT NULL,
  `pro_sell_price` decimal(10,2) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `featured_image` varchar(250) NOT NULL,
  `folder_image` varchar(250) NOT NULL,
  `img1` varchar(250) NOT NULL,
  `img2` varchar(250) NOT NULL,
  `img3` varchar(250) NOT NULL,
  `img4` varchar(250) NOT NULL,
  `img5` varchar(250) NOT NULL,
  `pro_status` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `cat_id`, `pro_name`, `pro_description`, `pro_condition`, `pro_brand`, `pro_features`, `pro_model`, `post_date`, `ads_id`, `pro_base_price`, `pro_sell_price`, `company_id`, `featured_image`, `folder_image`, `img1`, `img2`, `img3`, `img4`, `img5`, `pro_status`) VALUES
(1, 1, 'Apple iPhone 6 32GB', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est', 'New', 'Apple', 'Camera,Dual SIM,GSM, Touch Screen', 'iPhone 6', '2017-08-12 11:59:50', '251716763', '1000.00', '950.00', 1, 'list-1.jpg', 'folder1', 'list-1.jpg', 'list-2.jpg', 'list-3.jpg', 'list-4.jpg', 'list-5.jpg', 'Y'),
(2, 1, 'Apple iPhone 6 16GB', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est', 'New', 'Dell', 'Camera,Dual SIM,GSM, Touch Screen', 'iPhone 6', '2017-08-12 11:59:50', '251716763', '900.00', '850.00', 1, 'list-2.jpg', 'folder1', 'list-1.jpg', 'list-2.jpg', 'list-3.jpg', 'list-4.jpg', 'list-5.jpg', 'N'),
(3, 2, 'Apple iPhone 6 64GB', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est', 'New', 'Samsung', 'Camera,Dual SIM,GSM, Touch Screen', 'iPhone 6', '2017-08-12 11:59:50', '251716763', '700.00', '650.00', 1, 'list-3.jpg', 'folder1', 'list-1.jpg', 'list-2.jpg', 'list-3.jpg', 'list-4.jpg', 'list-5.jpg', 'N'),
(4, 3, 'Apple iPhone 6 160GB', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est', 'New', 'Nokia', 'Camera,Dual SIM,GSM, Touch Screen', 'iPhone 6', '2017-08-12 11:59:50', '251716763', '600.00', '550.00', 1, 'list-4.jpg', 'folder1', 'list-1.jpg', 'list-2.jpg', 'list-3.jpg', 'list-4.jpg', 'list-5.jpg', 'Y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`,`cat_id`,`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
