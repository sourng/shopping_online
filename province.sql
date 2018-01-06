-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2018 at 09:49 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopping_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `province_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `province_name_kh` varchar(250) DEFAULT NULL,
  `province_name_en` varchar(250) DEFAULT NULL,
  `capital_kh` varchar(250) DEFAULT NULL,
  `capital_en` varchar(250) DEFAULT NULL,
  `population_kh` varchar(250) DEFAULT NULL,
  `population_en` varchar(250) DEFAULT NULL,
  `area_kh` varchar(250) DEFAULT NULL,
  `area_en` varchar(250) DEFAULT NULL,
  `density_kh` varchar(250) DEFAULT NULL,
  `density_en` varchar(250) DEFAULT NULL,
  `province_code` varchar(250) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`province_id`, `country_id`, `province_name_kh`, `province_name_en`, `capital_kh`, `capital_en`, `population_kh`, `population_en`, `area_kh`, `area_en`, `density_kh`, `density_en`, `province_code`, `image`) VALUES
(1, 1, 'ភ្នំពេញ', 'Phnom Penh Municipality', 'ចំការមន', 'Chamkarmon District', '១៥០១៧២៥', '1,501,725', '៦៧៨.៤៦', '678.46', '២២០០', '2,200', 'KH-12', 'default.jpg'),
(2, 1, 'បន្ទាយមានជ័យ', 'Banteay Meanchey Province', 'សេរីសោភ័ណ្ឌ', 'Serei Saophoan', '៦៧៧៨៧២', '677,872', '៦៦៧៩', '6,679', '១០២', '102', 'KH-1', 'default.jpg'),
(3, 1, 'បាត់ដំបង', 'Battambang Province', 'បាត់ដំបង', 'Battambang', '១០៥៨១៧៤', '1,058,174', '១១៧០២', '11,702', '៨៩', '89', 'KH-2', 'default.jpg'),
(4, 1, 'កំពង់ចាម', 'Kampong Cham Province', 'កំពង់ចាម', 'Kampong Cham', '៩២៨៦៩៤', '928,694', '៤៥៤៩', '4,549', '២០៤', '204', 'KH-3', 'default.jpg'),
(5, 1, 'កំពង់ឆ្នាំង', 'Kampong Chhnang Province', 'កំពង់ឆ្នាំង', 'Kampong Chhnang', '៤៧២៣៤១', '472,341', '៥៥២១', '5,521', '៨៦', '86', 'KH-4', 'default.jpg'),
(6, 1, 'កំពង់ស្ពឺ', 'Kampong Speu Province', 'ច្បារមន', 'Chbar Mon', '៧១៦៩៤៤', '716,944', '៧០១៧', '7,017', '១០២', '102', 'KH-5', 'default.jpg'),
(7, 1, 'កំពង់ធំ', 'Kampong Thom Province', 'ស្ទឹងសែន', 'Stueng Saen', '៦៣១៤០៩', '631,409', '១៣៨១៤', '13,814	', '៥១', '51', 'KH-6', 'default.jpg'),
(8, 1, 'កំពត', 'Kampot Province', 'កំពត', 'Kampot', '៥៨៥៨៥០', '585,850', '៤៨៧៣', '4,873', '១២០', '120', 'KH-7', 'default.jpg'),
(9, 1, 'កណ្ដាល', 'Kandal Province', 'តាខ្មៅ', 'Ta Khmau', '១២៦៥២៨០', '1,265,280', '៣៥៦៨', '3,568', '៣៥៥', '355', 'KH-8', 'default.jpg'),
(10, 1, 'កោះកុង', 'Koh Kong Province', 'ខេមរភូមិន្ទ	', 'Khemarak Phoumin', '១១៧៤៨១', '117,481', '១១១៦០', '11,160', '១២', '12', 'KH-9', 'default.jpg'),
(11, 1, '	កែប', 'Kep Province', 'កែប', 'Kep', '៣៥៧៥៣', '35,753', '៣៣៦', '336', '១២០', '120', 'KH-23', 'default.jpg'),
(12, 1, 'ក្រចេះ', 'Kratié Province', 'ក្រចេះ', 'Kratié', '៣១៩២១៧', '319,217', '១១០៩៤', '11,094', '២៩', '29', 'KH-10', 'default.jpg'),
(13, 1, 'មណ្ឌលគីរី', 'Mondulkiri Province', 'សែនមនោរម្យ', 'Senmonorom', '៦១១០៧', '61,107', '១៤២៨៨', '14,288', '៤', '4', 'KH-11', 'default.jpg'),
(14, 1, 'ឧត្តរមានជ័យ', 'Oddar Meanchey Province', 'សំរោង', 'Samraong', '១៨៥៨១៩', '185,819', '៦១៥៨', '6,158', '៣០', '30', 'KH-22', 'default.jpg'),
(15, 1, 'បៃលិន', 'Pailin Province', 'បៃលិន', 'Pailin', '៧០៤៨៦', '70,486', '៨០៣', '803', '៨៨', '88', 'KH-24', 'default.jpg'),
(16, 1, 'ព្រះសីហនុ', 'Preah Sihanouk Province', 'ព្រះសីហនុ', 'Sihanoukville', '២២១៣៩៦', '221,396', '៨៦៨', '868', '២៣០', '230', 'KH-18', 'default.jpg'),
(17, 1, 'ព្រះវិហារ', 'Preah Vihear Province', 'ព្រះវិហារ', 'Preah Vihear', '១៧១១៣៩', '171,139', '១៣៧៨៨', '13,788', '១២', '12', 'KH-13', 'default.jpg'),
(18, 1, 'ពោធិ៍សាត់', 'Pursat Province', 'ពោធិ៍សាត់', 'Pursat', '៣៩៧១៦១', '397,161', '១២៦៩២', '12,692', '៣១', '31', 'KH-15', 'default.jpg'),
(19, 1, 'ព្រៃវែង', 'Prey Veng Province', 'ព្រៃវែង', 'Prey Veng', '៩៤៧៣៧២', '947,372', '៤៨៨៣', '4,883', '១៩៤', '194', 'KH-14', 'default.jpg'),
(20, 1, 'រតនគីរី', 'Ratanakiri Province', 'បានលុង', '	Banlung', '១៥០៤៦៦', '150,466', '១០៧៨២', '10,782', '១៤', '14', 'KH-16', 'default.jpg'),
(21, 1, 'សៀមរាប', 'Siem Reap Province', 'សៀមរាប', 'Siem Reap', '៨៩៦៤៤៣', '896,443', '១០២៩៩', '10,299', '៨៧', '87', 'KH-17', 'default.jpg'),
(22, 1, 'ស្ទឹងត្រែង', 'Stung Treng Province', 'ស្ទឹងត្រែង', 'Stung Treng', '១១១៦៧១', '111,671', '១១០៩២', '11,092	', '១០', '10', 'KH-19', 'default.jpg'),
(23, 1, 'ស្វាយរៀង', 'Svay Rieng Province', 'ស្វាយរៀង', 'Svay Rieng', '៤៨២៧៨៨', '482,788', '២៩៦៦', '2,966', '១៦៣', '163', 'KH-20', 'default.jpg'),
(24, 1, 'តាកែវ', 'Takéo Province', 'ដូនកែវ', 'Doun Kaev', '៨៤៤៩០៦', '844,906', '៣៥៦៣', '3,563', '២៣៧', '	237', 'KH-21', 'default.jpg'),
(25, 1, 'ត្បូងឃ្មុំ', 'Tboung Khmum Province', 'សួង', 'Suong', '៧៥៤០០', '754,000', '៤៩២៨', '4,928', '១៥៣', '153', 'KH-25', 'default.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`province_id`,`country_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `province_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
