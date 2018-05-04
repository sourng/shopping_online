-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.13-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for shopping_online
CREATE DATABASE IF NOT EXISTS `shopping_online` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `shopping_online`;

-- Dumping structure for table shopping_online.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(250) DEFAULT NULL,
  `cat_ico_class` varchar(250) DEFAULT NULL,
  `cat_ico_image` varchar(250) DEFAULT NULL,
  `cat_home` enum('Y','N') DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table shopping_online.categories: ~5 rows (approximately)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_ico_class`, `cat_ico_image`, `cat_home`) VALUES
	(1, 'Electronics & Gedget', 'icofont icofont-laptop-alt', NULL, 'Y'),
	(2, 'Cars & Vehicles', 'icofont icofont-police-car-alt-2', NULL, 'Y'),
	(3, 'Property', 'icofont icofont-building-alt', NULL, 'Y'),
	(4, 'Home & Garden', 'icofont icofont-ui-home', NULL, 'Y'),
	(5, 'Pets & Animals', 'icofont icofont-animal-dog', NULL, 'Y');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Dumping structure for table shopping_online.company
CREATE TABLE IF NOT EXISTS `company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `reg_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table shopping_online.company: ~0 rows (approximately)
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
/*!40000 ALTER TABLE `company` ENABLE KEYS */;

-- Dumping structure for table shopping_online.country
CREATE TABLE IF NOT EXISTS `country` (
  `country_id` int(11) NOT NULL,
  `country_name_kh` varchar(250) DEFAULT NULL,
  `country_name_en` varchar(250) DEFAULT NULL,
  `country_code` varchar(250) DEFAULT NULL,
  `country_flag` varchar(250) DEFAULT NULL,
  `country_note` longtext,
  `country_image` varchar(2150) DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table shopping_online.country: ~0 rows (approximately)
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` (`country_id`, `country_name_kh`, `country_name_en`, `country_code`, `country_flag`, `country_note`, `country_image`) VALUES
	(1, 'កម្ពុជា', 'Cambodia', '855', 'kh-km.png', 'Angkor Waht', 'cambodia.jpg');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;

-- Dumping structure for table shopping_online.products
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `pro_status` enum('Y','N') NOT NULL,
  PRIMARY KEY (`product_id`,`cat_id`,`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table shopping_online.products: ~4 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`product_id`, `cat_id`, `pro_name`, `pro_description`, `pro_condition`, `pro_brand`, `pro_features`, `pro_model`, `post_date`, `ads_id`, `pro_base_price`, `pro_sell_price`, `company_id`, `featured_image`, `folder_image`, `img1`, `img2`, `img3`, `img4`, `img5`, `pro_status`) VALUES
	(1, 1, 'Apple iPhone 6 32GB', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est', 'New', 'Apple', 'Camera,Dual SIM,GSM, Touch Screen', 'iPhone 6', '2017-08-12 18:59:50', '251716763', 1000.00, 950.00, 1, 'list-1.jpg', 'folder1', 'list-1.jpg', 'list-2.jpg', 'list-3.jpg', 'list-4.jpg', 'list-5.jpg', 'Y'),
	(2, 1, 'Apple iPhone 6 16GB', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est', 'New', 'Dell', 'Camera,Dual SIM,GSM, Touch Screen', 'iPhone 6', '2017-08-12 18:59:50', '251716763', 900.00, 850.00, 1, 'list-2.jpg', 'folder1', 'list-1.jpg', 'list-2.jpg', 'list-3.jpg', 'list-4.jpg', 'list-5.jpg', 'N'),
	(3, 2, 'Apple iPhone 6 64GB', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est', 'New', 'Samsung', 'Camera,Dual SIM,GSM, Touch Screen', 'iPhone 6', '2017-08-12 18:59:50', '251716763', 700.00, 650.00, 1, 'list-3.jpg', 'folder1', 'list-1.jpg', 'list-2.jpg', 'list-3.jpg', 'list-4.jpg', 'list-5.jpg', 'N'),
	(4, 3, 'Apple iPhone 6 160GB', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est', 'New', 'Nokia', 'Camera,Dual SIM,GSM, Touch Screen', 'iPhone 6', '2017-08-12 18:59:50', '251716763', 600.00, 550.00, 1, 'list-4.jpg', 'folder1', 'list-1.jpg', 'list-2.jpg', 'list-3.jpg', 'list-4.jpg', 'list-5.jpg', 'Y');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table shopping_online.province
CREATE TABLE IF NOT EXISTS `province` (
  `province_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `image` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`province_id`,`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- Dumping data for table shopping_online.province: ~25 rows (approximately)
/*!40000 ALTER TABLE `province` DISABLE KEYS */;
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
/*!40000 ALTER TABLE `province` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
