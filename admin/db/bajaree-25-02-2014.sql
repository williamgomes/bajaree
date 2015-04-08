-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 25, 2014 at 09:00 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bajaree`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int(5) NOT NULL AUTO_INCREMENT,
  `admin_full_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `admin_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `admin_password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `admin_hash` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `admin_type` enum('master','super','normal') COLLATE utf8_unicode_ci NOT NULL,
  `admin_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `admin_last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin_update` datetime NOT NULL,
  `admin_updated_by` int(5) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_full_name`, `admin_email`, `admin_password`, `admin_hash`, `admin_type`, `admin_status`, `admin_last_login`, `admin_update`, `admin_updated_by`) VALUES
(0, 'System', 'system@bscheme.com', 'e10adc3949ba59abb#b1a2j1r1e2*e56e057f20f883e', 'qk6l2f2onu22kmeqoq1o0plum6', 'master', 'active', '2014-02-02 05:06:22', '2013-04-27 16:10:46', 0),
(1, 'Faruk', 'faruk@bscheme.com', 'e10adc3949ba59abb#b1a2j1r1e2*e56e057f20f883e', '5l119qc4oqe54upnev1ljh88e0', 'master', 'active', '2014-02-25 04:26:02', '2013-04-27 16:10:46', 0),
(2, 'Rashed', 'rashed@bscheme.com', 'd355613d1ed436902#b1a2j1r1e2*c3ebb0590ea833b', 'b907ac4ed7bb6d1feaf42de6eea69583', 'super', 'active', '2014-02-19 05:39:38', '2014-02-03 10:54:08', 0),
(3, 'Mukesh ', 'mukesh@bscheme.com', 'fe9642294f8e3bdac#b1a2j1r1e2*f9de8d8caff83ad', 'b01a3643f7f4c8bbd56938ace7242dfc', 'super', 'active', '2014-02-19 06:59:34', '2014-02-03 10:54:53', 0);

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE IF NOT EXISTS `areas` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_city_id` int(11) NOT NULL,
  `area_name` varchar(300) NOT NULL,
  `area_status` enum('allow','notallow') NOT NULL,
  `area_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `area_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`area_id`, `area_city_id`, `area_name`, `area_status`, `area_updated`, `area_updated_by`) VALUES
(1, 1, 'Banani', 'notallow', '2014-02-20 09:02:03', 1),
(2, 1, ' Gulshan-1', 'notallow', '2014-02-20 09:02:03', 1),
(3, 1, ' Gulshan-2', 'notallow', '2014-02-20 09:02:03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `banner_id` int(5) NOT NULL AUTO_INCREMENT,
  `banner_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `banner_image_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `banner_description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `banner_priority` int(3) NOT NULL,
  `banner_url` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `banner_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `banner_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(5) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `category_description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `category_parent_id` int(5) NOT NULL,
  `category_priority` int(11) NOT NULL,
  `category_logo` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `category_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_updated_by` int(5) NOT NULL,
  `category_type` enum('user_created','builtin') COLLATE utf8_unicode_ci DEFAULT 'user_created',
  `category_level` int(3) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=54 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_description`, `category_parent_id`, `category_priority`, `category_logo`, `category_updated`, `category_updated_by`, `category_type`, `category_level`) VALUES
(1, 'Brands', 'this is Brands', 0, 1, 'Brands-1373182145.', '2013-07-07 07:29:05', 1, 'builtin', 0),
(2, 'Products', 'this is Product', 0, 1, 'Categories-1373182178.', '2013-07-07 07:29:38', 1, 'builtin', 0),
(25, 'Food', 'Food', 2, 7, 'Food-2.jpg', '2014-02-02 06:31:59', 1, 'builtin', 1),
(26, 'Beverages', 'Beverages', 2, 6, 'Beverages-2.jpg', '2014-02-02 06:33:58', 1, 'builtin', 1),
(27, 'Water', 'Water', 26, 3, 'Water-26.jpg', '2014-02-02 06:35:12', 2, 'user_created', 2),
(28, 'Coffee', 'Coffee', 26, 3, 'Coffee-26.jpg', '2014-02-02 06:35:39', 2, 'user_created', 2),
(29, 'Health & Beauty ', ' Health & Beauty ', 2, 5, 'Health & Beauty -2.jpg', '2014-02-02 06:37:10', 1, 'builtin', 1),
(30, 'Household ', 'Household ', 2, 3, 'Household -2.jpg', '2014-02-02 06:37:51', 1, 'builtin', 1),
(31, ' Organic ', ' Organic ', 2, 4, ' Organic -2.jpg', '2014-02-02 06:38:40', 1, 'builtin', 1),
(32, '  Baby ', '  Baby ', 2, 2, '  Baby -2.jpg', '2014-02-02 06:39:10', 1, 'builtin', 1),
(33, '   Pet Care ', '   Pet Care ', 2, 1, '   Pet Care -2.jpg', '2014-02-02 06:39:42', 1, 'builtin', 1),
(34, 'Fresh Food ', 'Fresh Food ', 25, 20, 'Fresh Food -25.jpg', '2014-02-02 06:43:45', 1, 'user_created', 2),
(35, 'Vegetable', 'Vegetable', 34, 20, 'Vegetable-34.jpg', '2014-02-02 06:45:22', 2, 'user_created', 3),
(36, 'Fruits', 'Fruits', 34, 20, 'Fruits-34.jpg', '2014-02-02 06:46:27', 2, 'user_created', 3),
(37, 'Frozen Food ', 'Frozen Food ', 25, 20, 'Frozen Food -25.jpg', '2014-02-02 06:47:05', 1, 'user_created', 2),
(38, 'Dips ', 'Dips ', 25, 20, 'Dips -25.jpg', '2014-02-02 06:47:30', 1, 'user_created', 2),
(39, 'Rice, Noodles & Pasta', 'Rice, Noodles & Pasta', 25, 20, 'Rice, Noodles & Pasta-25.jpg', '2014-02-02 06:47:58', 2, 'user_created', 2),
(40, 'Oil, Sauces & Spices', 'Oil, Sauces & Spices', 25, 20, 'Oil, Sauces & Spices-25.jpg', '2014-02-02 06:48:42', 2, 'user_created', 2),
(41, 'Baking ', 'Baking ', 26, 20, 'Baking -26.jpg', '2014-02-02 06:49:09', 2, 'user_created', 2),
(42, 'Bread', 'Bread', 41, 20, 'Bread-41.jpg', '2014-02-02 06:49:39', 1, 'user_created', 3),
(43, 'Cake', 'Cake', 41, 20, 'Cake-41.jpg', '2014-02-02 06:50:10', 1, 'user_created', 3),
(44, 'Juice', 'Juice', 26, 15, 'Juice-26.jpg', '2014-02-03 06:09:09', 2, 'user_created', 2),
(45, 'Biscuits', 'Biscuits', 26, 16, 'Biscuits-26.jpg', '2014-02-03 06:10:27', 2, 'user_created', 2),
(46, 'Soft drinks ', 'Soft drinks ', 26, 14, 'Soft drinks -26.jpg', '2014-02-17 06:55:34', 2, 'user_created', 2),
(47, 'Tea', 'Tea', 26, 13, 'Tea-26.jpg', '2014-02-17 06:58:10', 2, 'user_created', 2),
(48, 'Milk & cream', 'Milk & cream', 26, 12, 'Milk & cream-26.jpg', '2014-02-17 06:59:56', 2, 'user_created', 2),
(49, 'Hot chocolate & nutritional drinks ', 'Hot chocolate & nutritional drinks ', 26, 11, 'Hot chocolate & nutritional drinks -26.jpg', '2014-02-17 07:12:35', 2, 'user_created', 2),
(50, 'Sports & energy drinks', 'Sports & energy drinks', 26, 10, 'Sports & energy drinks-26.jpg', '2014-02-17 07:14:38', 2, 'user_created', 2),
(51, 'Breakfast & cereal ', 'Breakfast & cereal ', 25, 50, 'Breakfast & cereal -25.jpg', '2014-02-17 10:36:48', 2, 'user_created', 2),
(52, 'Dairy ', 'Dairy ', 25, 51, 'Dairy -25.jpg', '2014-02-17 10:37:54', 2, 'user_created', 2),
(53, 'Featured Products', 'Featured Products', 2, 10, 'Random Products-2.jpg', '2014-02-22 08:04:52', 1, 'user_created', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_banners`
--

CREATE TABLE IF NOT EXISTS `category_banners` (
  `CB_id` int(11) NOT NULL AUTO_INCREMENT,
  `CB_category_id` int(11) NOT NULL,
  `CB_image_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `CB_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `CB_priority` int(11) NOT NULL,
  `CB_description` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `CB_url` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `CB_url_type` enum('internal','external') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'internal' COMMENT 'if external set target="_blanck" on anchor tag',
  `CB_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CB_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`CB_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='category_banners = CB' AUTO_INCREMENT=18 ;

--
-- Dumping data for table `category_banners`
--

INSERT INTO `category_banners` (`CB_id`, `CB_category_id`, `CB_image_name`, `CB_title`, `CB_priority`, `CB_description`, `CB_url`, `CB_url_type`, `CB_updated`, `CB_updated_by`) VALUES
(1, 44, 'Category-44_Time-1392630676.jpg', 'juice', 25, '', 'http://', 'internal', '2014-02-17 09:51:16', 1),
(2, 27, 'Category-27_Time-1392630731.jpg', 'Water', 24, '', 'http://', 'internal', '2014-02-17 09:52:11', 2),
(3, 28, 'Category-28_Time-1392630757.jpg', 'Coffee', 23, '', 'http://', 'internal', '2014-02-17 09:52:37', 2),
(4, 45, 'Category-45_Time-1392630791.jpg', 'Biscuits', 22, '', 'http://', 'internal', '2014-02-17 09:53:11', 2),
(5, 46, 'Category-46_Time-1392630823.jpg', 'Soft drinks ', 21, '', 'http://', 'internal', '2014-02-17 09:53:43', 2),
(6, 47, 'Category-46_Time-1392630845.jpg', 'Tea', 20, '', 'http://', 'internal', '2014-02-17 09:54:05', 2),
(7, 48, 'Category-46_Time-1392630874.jpg', 'Milk & cream', 19, '', 'http://', 'internal', '2014-02-17 09:54:34', 2),
(8, 49, 'Category-49_Time-1392630955.jpg', 'Hot chocolate & nutritional drinks ', 18, '', 'http://', 'internal', '2014-02-17 09:55:55', 2),
(9, 50, 'Category-50_Time-1392630978.jpg', 'Sports & energy drinks', 17, '', 'http://', 'internal', '2014-02-17 09:56:18', 2),
(10, 35, 'Category-35_Time-1392631711.jpg', 'Vegetable', 16, '', 'http://', 'internal', '2014-02-17 10:08:31', 2),
(11, 36, 'Category-36_Time-1392631727.jpg', 'Fruits', 15, '', 'http://', 'internal', '2014-02-17 10:08:47', 2),
(12, 39, 'Category-39_Time-1392632235.jpg', 'Rice, Noodles & Past', 14, '', 'http://', 'internal', '2014-02-17 10:17:15', 2),
(13, 40, 'Category-40_Time-1392632260.jpg', 'Oil, Sauces & Spices', 13, '', 'http://', 'internal', '2014-02-17 10:17:40', 2),
(14, 41, 'Category-40_Time-1392633820.jpg', 'Baking ', 12, '', 'http://', 'internal', '2014-02-17 10:43:40', 2),
(15, 2, 'Category-2_Time-1392634951.jpg', 'FREE GROCERY DELIVERY', 5, 'FREE GROCERY DELIVERY', 'http://testserver.bscheme.com/bajaree-html/', 'internal', '2014-02-17 11:02:31', 2),
(16, 2, 'Category-2_Time-1392635061.jpg', 'BUY GROCERIES ONLINE', 4, '<p>BUY GROCERIES ONLINE</p>', 'http://testserver.bscheme.com/bajaree-html/', 'internal', '2014-02-17 11:04:21', 2),
(17, 2, 'Category-2_Time-1392635257.jpg', 'SHOP NOW', 3, '<p>SHOP NOW</p>', 'http://testserver.bscheme.com/bajaree-html/', 'internal', '2014-02-17 11:07:37', 2);

-- --------------------------------------------------------

--
-- Table structure for table `category_featured`
--

CREATE TABLE IF NOT EXISTS `category_featured` (
  `CF_id` int(11) NOT NULL AUTO_INCREMENT,
  `CF_category_id` int(11) NOT NULL,
  `CF_featured_from` date NOT NULL,
  `CF_featured_to` date NOT NULL,
  `CF_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CF_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`CF_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `category_featured`
--

INSERT INTO `category_featured` (`CF_id`, `CF_category_id`, `CF_featured_from`, `CF_featured_to`, `CF_updated`, `CF_updated_by`) VALUES
(1, 34, '2014-02-01', '2014-02-28', '2014-02-12 11:32:51', 1),
(2, 35, '2014-02-01', '2014-02-28', '2014-02-22 08:08:01', 1),
(3, 26, '2014-02-01', '2014-02-02', '2014-02-22 08:10:16', 1),
(4, 44, '2014-02-01', '2014-02-02', '2014-02-22 08:09:23', 1),
(5, 53, '2014-02-01', '2014-03-31', '2014-02-22 08:05:26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_promotion`
--

CREATE TABLE IF NOT EXISTS `category_promotion` (
  `CP_id` int(11) NOT NULL AUTO_INCREMENT,
  `CP_category_id` int(11) NOT NULL,
  `CP_image_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `CP_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `CP_priority` int(11) NOT NULL,
  `CP_description` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `CP_url` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `CP_url_type` enum('internal','external') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'internal' COMMENT 'if external set target="_blanck" on anchor tag',
  `CP_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CP_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`CP_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='category_promotion = CP' AUTO_INCREMENT=8 ;

--
-- Dumping data for table `category_promotion`
--

INSERT INTO `category_promotion` (`CP_id`, `CP_category_id`, `CP_image_name`, `CP_title`, `CP_priority`, `CP_description`, `CP_url`, `CP_url_type`, `CP_updated`, `CP_updated_by`) VALUES
(1, 25, 'Category-25_Time-1392638641.jpg', 'Food', 7, 'Food', 'http://', 'internal', '2014-02-17 12:04:01', 2),
(2, 26, 'Category-25_Time-1392638684.jpg', 'Beverages', 6, 'Beverages', 'http://', 'internal', '2014-02-17 12:04:44', 2),
(3, 29, 'Category-29_Time-1392638750.jpg', 'Health & Beauty ', 5, 'Health &amp; Beauty', 'http://', 'internal', '2014-02-17 12:05:50', 2),
(4, 31, 'Category-31_Time-1392638793.jpg', 'Organic ', 4, 'Organic', 'http://', 'internal', '2014-02-17 12:06:33', 2),
(5, 30, 'Category-30_Time-1392638814.jpg', 'Household ', 3, '<span></span>Household', 'http://', 'internal', '2014-02-17 12:06:54', 2),
(6, 32, 'Category-30_Time-1392638842.jpg', 'Baby ', 2, '<span></span>Baby', 'http://', 'internal', '2014-02-17 12:07:22', 2),
(7, 33, 'Category-33_Time-1392638874.jpg', 'Pet Care ', 1, '<span></span>Pet Care', 'http://', 'internal', '2014-02-17 12:07:54', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `city_id` int(5) NOT NULL AUTO_INCREMENT,
  `city_country_id` int(5) NOT NULL,
  `city_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city_status` enum('allow','notallow') COLLATE utf8_unicode_ci NOT NULL,
  `city_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `city_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `city_country_id`, `city_name`, `city_status`, `city_updated`, `city_updated_by`) VALUES
(1, 1, 'Dhaka', 'allow', '2013-07-31 13:31:55', 1),
(2, 1, ' Barisal', 'notallow', '2013-07-31 13:31:55', 1),
(3, 1, ' Chittagong', 'notallow', '2013-07-31 13:31:55', 1),
(4, 1, ' Khulna', 'notallow', '2013-07-31 13:31:55', 1),
(5, 3, 'Beijing', 'allow', '2013-07-31 13:33:25', 1),
(6, 3, ' Chongqing', 'allow', '2013-07-31 13:33:25', 1),
(7, 3, ' Shanghai', 'allow', '2013-07-31 13:33:25', 1),
(8, 3, '	Tianjin', 'notallow', '2013-07-31 13:33:25', 1),
(9, 1, 'Comilla', 'allow', '2013-08-05 06:29:00', 1),
(10, 1, 'Rajsahi', 'allow', '2013-08-05 06:35:05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE IF NOT EXISTS `colors` (
  `color_id` int(5) NOT NULL AUTO_INCREMENT,
  `color_title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `color_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `color_image_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `color_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `color_updated_by` int(5) NOT NULL,
  PRIMARY KEY (`color_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`color_id`, `color_title`, `color_code`, `color_image_name`, `color_updated`, `color_updated_by`) VALUES
(1, 'Test Color 1', '470047', 'img1.jpg', '2013-06-03 05:21:08', 1),
(2, 'Test Color 2', '7bff00', 'b6.jpg', '2013-06-03 05:35:11', 1),
(3, 'Product 1', 'ff00ff', 'b6.jpg', '2013-06-03 09:21:41', 1),
(4, 'AAaa 123 !!!!!!', 'ff00ff', 'img1.jpg', '2013-06-03 11:28:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `config_settings`
--

CREATE TABLE IF NOT EXISTS `config_settings` (
  `CS_option` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `CS_value` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `CS_update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CS_updated_by` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `CS_auto_load` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `config_settings`
--

INSERT INTO `config_settings` (`CS_option`, `CS_value`, `CS_update_date`, `CS_updated_by`, `CS_auto_load`) VALUES
('SITE_NAME', 'Bajaree', '2014-02-02 08:12:21', 'SQ Group', 'yes'),
('SITE_URL', ' http://localhost/sq', '2014-02-02 05:51:03', ' http://localhost/sq', 'yes'),
('SITE_LOGO', 'favicon.ico', '2014-02-02 05:51:03', 'favicon.ico', 'yes'),
('SITE_FAVICON', 'DFGDFG', '2014-02-02 05:51:03', 'DFGDFG', 'yes'),
('ALBUM_IMAGE_WIDTH', '1024', '2014-02-02 05:51:03', '1024', 'no'),
('CATEGORY_LOGO_WIDTH', '1024', '2014-02-02 05:51:03', '1024', 'no'),
('CLIENT_LOGO_WIDTH', '200', '2014-02-02 05:51:03', '200', 'no'),
('SITE_DEFAULT_META_TITLE', 'Bajaree |', '2014-02-02 08:27:29', 'title new', 'no'),
('SITE_DEFAULT_META_DESCRIPTION', 'description  new', '2014-02-02 05:51:03', 'description  new', 'no'),
('SITE_DEFAULT_META_KEYWORDS', 'key, words, new', '2014-02-02 05:51:03', 'key, words, new', 'no'),
('COMPANY_LOGO_WIDTH', '1024', '2014-02-02 05:51:03', '1024', 'no'),
('COMPANY_BANNER_WIDTH', '400', '2014-02-02 05:51:03', '400', 'no'),
('PRODUCT_IMAGE_WIDTH', '1024', '2014-02-02 05:51:03', '1024', 'no'),
('TESTIMONIAL_IMAGE_WIDTH', '1024', '2014-02-02 05:51:03', '1024', 'no'),
('MENU_TITLE_CHARACTER_LIMIT', '10', '2014-02-02 05:51:03', '10', 'no'),
('ALBUM_IMAGE_THUMB_WIDTH', '21024', '2014-02-02 05:51:03', '21024', 'no'),
('PARTNER_LOGO_WIDTH', '1024', '2014-02-02 05:51:03', '1024', 'no'),
('SMTP_SERVER_ADDRESS', 'ip-203-124-98-163.ip.secureserver.net', '2014-02-13 10:24:34', 'a', 'no'),
('EMAIL_ADDRESS_GENERAL', 'no-reply@bajaree.com', '2014-02-13 10:24:34', 'a', 'no'),
('HOSTING_ID', 'biriqina', '2014-02-13 10:24:34', 'a', 'no'),
('HOSTING_PASS', 'ayNw00XrFT', '2014-02-13 10:24:34', 'a', 'no'),
('SMTP_PORT_NO', '465', '2014-02-13 10:24:34', 'a', 'no'),
('POST_IMAGE_WIDTH', '200', '2014-02-02 05:51:03', '200', 'no'),
('MENU_TITLE_CHARACTER_LIMIT', '10', '2014-02-02 05:51:03', '10', 'no'),
('BANNER_MIN_WIDTH', '150', '2014-02-02 05:51:03', '1', 'no'),
('CATEGORY_BANNER_MAX_WIDTH', '1200', '2014-02-02 07:06:28', '1', 'no'),
('GOOGLE_ANALYTICS', 'GOOGLE_ANALYTICS', '2014-02-02 08:10:45', '1', 'yes'),
('SITE_AUTHOR', 'Blue Scheme', '2014-02-02 08:14:34', '1', 'yes'),
('CATEGORY_BANNER_MIN_WIDTH', '862', '2014-02-17 11:00:52', '1', 'no'),
('CATEGORY_PROMOTION_MIN_WIDTH', '300', '2014-02-17 11:56:19', '1', 'no'),
('CATEGORY_PROMOTION_MAX_WIDTH', '400', '2014-02-17 11:56:19', '1', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `country_id` int(5) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `country_status` enum('allow','notallow') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'notallow',
  `country_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `country_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `country_name`, `country_status`, `country_updated`, `country_updated_by`) VALUES
(1, 'Bangladesh', 'allow', '2013-07-31 13:31:04', 1),
(2, 'Australia', 'notallow', '2013-07-31 13:31:15', 1),
(3, 'China', 'notallow', '2013-07-31 13:31:24', 1),
(4, 'India', 'notallow', '2013-08-05 06:30:10', 1),
(5, 'Pakistan', 'notallow', '2013-08-05 06:30:41', 1),
(6, 'Napel', 'notallow', '2013-08-05 06:32:04', 1),
(7, 'Vutan', 'notallow', '2013-08-05 06:32:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `faq_id` int(3) NOT NULL AUTO_INCREMENT,
  `faq_question` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `faq_answer` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `faq_priority` int(3) NOT NULL,
  PRIMARY KEY (`faq_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int(5) NOT NULL AUTO_INCREMENT,
  `menu_title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu_url`
--

CREATE TABLE IF NOT EXISTS `menu_url` (
  `MU_id` int(5) NOT NULL AUTO_INCREMENT,
  `MU_menu_id` int(5) NOT NULL,
  `MU_url_title` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `MU_url` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `MU_priority` int(3) NOT NULL,
  PRIMARY KEY (`MU_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_user_id` int(11) NOT NULL,
  `order_created` datetime NOT NULL,
  `order_number` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT 'default null. entered by admin when processing orders',
  `order_read` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no' COMMENT 'if order has been viewed',
  `order_status` enum('booking','approved','delivered','paid','closed','pending') COLLATE utf8_unicode_ci NOT NULL COMMENT 'Only can change at booking stage, booking = user placed order, approved = admin approved order, delivered = product sent to shipping address, paid = customer paid and order completed',
  `order_payment_type` enum('COD','Paypal','Walleto','Card') COLLATE utf8_unicode_ci NOT NULL COMMENT 'create table for every option',
  `order_total_item` int(3) NOT NULL,
  `order_total_amount` decimal(10,2) NOT NULL COMMENT 'summation of all product price',
  `order_vat_amount` decimal(10,2) NOT NULL,
  `order_discount_amount` decimal(10,2) NOT NULL COMMENT 'summation of all product discount',
  `order_session_id` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `order_note` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `order_billing_first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `order_billing_middle_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `order_billing_last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `order_billing_phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `order_billing_best_call_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `order_billing_address` text COLLATE utf8_unicode_ci NOT NULL,
  `order_billing_country` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `order_billing_city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `order_billing_zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `order_shipping_first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `order_shipping_middle_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `order_shipping_last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `order_shipping_phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `order_shipping_best_call_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `order_shipping_address` text COLLATE utf8_unicode_ci NOT NULL,
  `order_shipping_country` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `order_shipping_city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `order_shipping_zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `order_updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE IF NOT EXISTS `order_products` (
  `OP_id` int(5) NOT NULL AUTO_INCREMENT,
  `OP_order_id` int(5) NOT NULL,
  `OP_user_id` int(11) NOT NULL,
  `OP_product_id` int(5) NOT NULL,
  `OP_product_inventory_id` int(11) NOT NULL,
  `OP_color_id` int(5) NOT NULL,
  `OP_size_id` int(5) NOT NULL,
  `OP_price` decimal(10,2) NOT NULL,
  `OP_discount` decimal(10,2) NOT NULL,
  `OP_product_quantity` int(5) NOT NULL,
  `OP_product_total_price` decimal(10,2) NOT NULL COMMENT 'total price = quantity * price',
  PRIMARY KEY (`OP_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='OP= order_products' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(3) NOT NULL AUTO_INCREMENT,
  `page_url` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `page_title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `page_short_description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `page_body` text COLLATE utf8_unicode_ci NOT NULL,
  `page_meta_title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `page_meta_description` text COLLATE utf8_unicode_ci NOT NULL,
  `page_meta_keywords` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `page_priority` int(11) DEFAULT NULL,
  `page_type` enum('built-in','user-created') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user-created',
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `product_default_inventory_id` int(11) NOT NULL,
  `product_short_description` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `product_long_description` text COLLATE utf8_unicode_ci NOT NULL,
  `product_meta_title` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `product_meta_keywords` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `product_meta_description` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `product_tags` text COLLATE utf8_unicode_ci NOT NULL,
  `product_avg_rating` int(1) NOT NULL,
  `product_show_as_new_from` date NOT NULL,
  `product_show_as_new_to` date NOT NULL,
  `product_show_as_featured_from` date NOT NULL,
  `product_show_as_featured_to` date NOT NULL,
  `product_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `product_total_viewed` int(11) NOT NULL,
  `product_total_sale` int(11) NOT NULL,
  `product_tax_class_id` int(11) NOT NULL,
  `product_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_updated_by` int(5) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='weight will be gram' AUTO_INCREMENT=101 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_default_inventory_id`, `product_short_description`, `product_long_description`, `product_meta_title`, `product_meta_keywords`, `product_meta_description`, `product_tags`, `product_avg_rating`, `product_show_as_new_from`, `product_show_as_new_to`, `product_show_as_featured_from`, `product_show_as_featured_to`, `product_status`, `product_total_viewed`, `product_total_sale`, `product_tax_class_id`, `product_updated`, `product_updated_by`) VALUES
(1, 'Cabbage (à¦¬à¦¾à¦à¦§à¦¾à¦•à¦ªà¦¿) ', 139, 'Cabbage (à¦¬à¦¾à¦à¦§à¦¾à¦•à¦ªà¦¿) ', 'Cabbage (badhakopi)', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', 'N;', 2, '1970-01-01', '1970-01-01', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 05:10:23', 3),
(2, 'Pran joy', 80, 'Pran Joy mango', 'Pran Joy mango', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 1, '0000-00-00', '0000-00-00', '2014-02-16', '2014-12-16', 'active', 0, 0, 0, '2014-02-03 05:57:06', 3),
(3, 'Fit crackers milk flavour ', 2, 'Fit crackers milk flavour ', 'Fit crackers milk flavour ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 1, '0000-00-00', '0000-00-00', '2014-02-16', '2014-12-16', 'active', 0, 0, 0, '2014-02-03 06:02:02', 3),
(4, 'Pran Joy', 82, 'Pran Joy orange', 'Pran Joy orange', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '2014-02-16', '2014-12-16', 'active', 0, 0, 0, '2014-02-03 06:31:10', 3),
(5, 'Pran Joy', 83, 'Pran Joy fruit cocktail', 'Pran Joy fruit cocktail', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '2014-02-16', '2014-12-16', 'active', 0, 0, 0, '2014-02-03 07:02:10', 3),
(6, 'Pran mango juice pack', 134, 'Pran mango juice pack', 'Pran mango juice pack', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:04:34', 3),
(7, 'Pran mango juice pack', 0, 'Pran mango juice pack', 'Pran mango juice pack', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:11:07', 3),
(8, 'Pran mango juice pack', 0, 'Pran mango juice pack', 'Pran mango juice pack', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 6, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:32:26', 3),
(9, 'Pran mango juice pack', 8, 'Pran mango juice pack', 'Pran mango juice pack', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:38:06', 3),
(10, 'Pran premium mango juice', 0, 'Pran premium mango juice', 'Pran premium mango juice', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:46:00', 3),
(11, 'Pran premium mango juice', 0, 'Pran premium mango juice', 'Pran premium mango juice', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:52:14', 3),
(12, 'Pran juice (Premium)', 0, 'Pran juice (Premium) mango flavour', 'Pran juice (Premium) mango flavour', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 09:36:10', 3),
(13, 'Pran juice (Premium)', 0, 'Pran juice (Premium) orange flavor', 'Pran juice (Premium) orange flavor', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 09:38:41', 3),
(14, 'Pran juice (Premium)', 0, 'Pran juice (Premium) fruit cocktail', 'Pran juice (Premium) fruit cocktail', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 09:49:08', 3),
(15, 'Pran apple nectar', 0, 'Pran apple nectar', 'Pran apple nectar', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 09:59:25', 3),
(16, 'Pran apple nectar', 0, 'Pran apple nectar', 'Pran apple nectar', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:03:49', 3),
(17, 'Pran junior juice', 0, 'Pran junior juice orange flavour', 'Pran junior juice orange flavour', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:06:59', 3),
(18, 'Pran junior juice', 0, 'Pran junior juice mango flavour', 'Pran junior juice mango flavour', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:12:31', 3),
(19, 'Pran junior juice', 0, 'Pran junior juice fruit cocktail', 'Pran junior juice fruit cocktail', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:17:01', 3),
(20, 'Pran junior juice', 0, 'Pran junior juice litchi', 'Pran junior juice litchi', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:19:37', 3),
(21, 'Pran frooto', 0, 'Pran frooto mango flavour', 'Pran frooto mango flavour', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:25:51', 3),
(22, 'Pran frooto', 0, 'Pran frooto mango flavour', 'Pran frooto mango flavour', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:46:57', 3),
(23, 'Pran mango juice', 0, 'Pran mango juice', 'Pran mango juice', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:53:51', 3),
(24, 'Frooto mango juice', 0, 'Frooto mango juice', 'Frooto mango juice', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 11:03:07', 3),
(25, 'Frooto mango juice', 0, 'Frooto mango juice', 'Frooto mango juice', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 11:11:46', 3),
(26, 'Frooto mango juice', 0, 'Frooto mango juice', 'Frooto mango juice', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 04:26:32', 3),
(27, 'Sunny orange', 0, 'Sunny orange', 'Sunny orange', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 04:41:24', 3),
(28, 'Kagozee', 0, 'Kagozee lemon flavour', 'Kagozee lemon flavour', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 04:52:44', 3),
(29, 'Munchy''s Lexus Sandwich Chocolate Cream ', 27, 'Munchy''s Lexus Sandwich Calcium Cracker Chocolate Cream ', 'Munchy''s Lexus Sandwich Calcium Cracker Chocolate Cream ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 5, '0000-00-00', '0000-00-00', '2014-02-16', '2014-12-16', 'active', 0, 0, 0, '2014-02-04 04:57:48', 3),
(30, 'Apple nectar', 0, 'Apple nectar', 'Apple nectar', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 05:05:38', 3),
(31, 'Tiffany Chocolate Cream Wafers ', 29, 'Tiffany Chocolate Cream Wafers ', 'Tiffany Chocolate Cream Wafers ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '2014-02-16', '2014-12-16', 'active', 0, 0, 0, '2014-02-04 05:19:38', 3),
(32, 'Pran juice', 0, 'Pran juice guava flavour', 'Pran juice guava flavour', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 05:29:44', 3),
(33, 'Pran juice', 0, 'Pran juice mango', 'Pran juice mango', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 05:51:45', 3),
(34, 'Pran juice', 0, 'Pran juice orange flavour', 'Pran juice orange flavour', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 06:01:41', 3),
(35, 'Pran juice', 0, 'Pran juice apple flavour', 'Pran juice apple flavour', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 2, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 06:06:29', 3),
(36, 'Ano Danish Butter Cookies Tin Blue ', 33, 'Ano Danish Butter Cookies Tin Blue ', 'Ano Danish Butter Cookies Tin Blue ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '2014-02-16', '2014-12-16', 'active', 0, 0, 0, '2014-02-04 06:10:50', 3),
(37, 'Pran juice ', 0, 'Pran juice fruit cocktail (tin can)', 'Pran juice fruit cocktail (tin can)', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 06:16:15', 3),
(38, 'Baton Rouge Ovaltine Biscuit ', 59, 'Baton Rouge Ovaltine Biscuit ', 'Baton Rouge Ovaltine Biscuit ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 5, '0000-00-00', '0000-00-00', '2014-02-16', '2014-12-16', 'active', 0, 0, 0, '2014-02-04 06:21:47', 3),
(39, 'Pran juice', 0, 'Pran juice mango (tin can)', 'Pran juice mango (tin can)', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 06:36:03', 3),
(40, 'Pran juice', 0, 'Pran Juice tamarind (tin can)', 'Pran Juice tamarind (tin can)', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 07:07:41', 3),
(41, 'Pran juice', 0, 'Pran Juice orange (tin can)', 'Pran Juice orange (tin can)', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 07:21:26', 3),
(42, 'Pran juice', 0, 'Pran Juice banana (tin can)', 'Pran Juice banana (tin can)', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 07:50:17', 3),
(43, 'Pran juice', 0, 'Pran Juice guava (tin can)', 'Pran Juice guava (tin can)', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 2, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 08:00:11', 3),
(44, 'Pran juice', 0, 'Pran juice pineapple (tin can)', 'Pran juice pineapple (tin can)', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 08:20:42', 3),
(45, 'Aarong mango juice ', 42, 'Aarong mango juice ', 'Aarong mango juice ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '2014-01-01', '2014-03-12', 'active', 0, 0, 0, '2014-02-04 08:33:31', 3),
(46, 'Acme mango juice classic ', 43, 'Acme mango juice classic ', 'Acme mango juice classic ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 2, '0000-00-00', '0000-00-00', '2014-02-16', '2014-12-16', 'active', 0, 0, 0, '2014-02-04 08:48:32', 3),
(47, 'Acme mango juice', 44, 'Acme mango juice premium ', 'Acme mango juice premium ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '1970-01-01', '1970-01-01', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 08:54:26', 3),
(48, 'Acme mango orange juice', 0, 'Acme mango orange juice', 'Acme mango orange juice', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 09:42:38', 3),
(49, 'Acme mango juice classic', 0, 'Acme mango juice classic', 'Acme mango juice classic', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'inactive', 0, 0, 0, '2014-02-04 09:55:33', 3),
(50, 'Bengal Orange Cake Biscuit ', 47, 'Bengal Orange Cake Biscuit ', 'Bengal Orange Cake Biscuit ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '2014-02-16', '2014-12-16', 'active', 0, 0, 0, '2014-02-05 06:48:00', 3),
(51, 'Bengal Orange Cake Biscuit Tin', 48, 'Bengal Orange Cake Biscuit Tin', 'Bengal Orange Cake Biscuit Tin', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '2014-02-16', '2014-12-16', 'active', 0, 0, 0, '2014-02-05 06:56:47', 3),
(52, 'Acme mango juice classic', 0, 'Acme mango juice classic', 'Acme mango juice classic', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-06 10:25:35', 3),
(53, 'Berri grapefruit juice ', 0, 'Berri grapefruit juice ', 'Berri grapefruit juice ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-06 10:35:17', 3),
(54, 'Berri cranberry juice', 58, 'Berri cranberry juice', 'Berri cranberry juice', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 2, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-06 10:58:47', 3),
(55, 'Bengal Pineapple Cream biscuit ', 51, 'Bengal Pineapple Cream biscuit ', 'Bengal Pineapple Cream biscuit', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-08 08:17:06', 3),
(56, 'Bissin Premium Coconut Wafers ', 52, 'Bissin Premium Coconut Wafers ', 'Bissin Premium Coconut Wafers ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '2014-02-16', '2014-12-16', 'active', 0, 0, 0, '2014-02-08 08:21:08', 3),
(57, 'Cadbury Oreo Biscuit ', 53, 'Cadbury Oreo Biscuit ', 'Cadbury Oreo Biscuit ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 5, '0000-00-00', '0000-00-00', '2014-02-16', '2014-12-16', 'active', 0, 0, 0, '2014-02-08 08:38:18', 3),
(58, 'Cadbury Oreo Sandwich Biscuits ', 54, 'Cadbury Oreo Sandwich Biscuits', 'Cadbury Oreo Sandwich Biscuits Pack ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-08 08:56:45', 3),
(59, 'Cocola Chocolate Biscuits ', 0, 'Cocola Chocolate Biscuits ', 'Cocola Chocolate Biscuits ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-08 09:00:32', 3),
(60, 'Danish Florida Orange Biscuit ', 0, 'Danish Florida Orange Biscuit ', 'Danish Florida Orange Biscuit ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-08 09:03:55', 3),
(61, 'Danish Hi Energy Biscuits ', 0, 'Danish Hi Energy Biscuits ', 'Danish Hi Energy Biscuits ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-08 09:22:30', 3),
(62, 'Danish Lexus Vegetable Calcium Crackers ', 0, 'Danish Lexus Vegetable Calcium Crackers ', 'Danish Lexus Vegetable Calcium Crackers ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-08 09:35:08', 3),
(63, 'Danish Mckenzie Vegetable Crackers', 0, '', 'Danish Mckenzie Vegetable Crackers', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'active', 0, 0, 0, '2014-02-15 07:10:16', 3),
(64, 'Cyprina Apple Juice', 86, 'Cyprina Apple Juice', 'Cyprina apple juices are 100% pure and natural. You can drink it without hesitation as it is free from any preservative.', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', 'N;', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-15 09:19:44', 3),
(65, 'Danish Milk Marie Biscuits ', 74, 'Danish Milk Marie Biscuits ', 'Danish Milk Marie Biscuits ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '2014-02-16', '2014-02-25', 'active', 0, 0, 0, '2014-02-16 08:24:42', 3),
(66, 'Doreo Black Chocolate Sandwich Biscuit', 78, 'Danish Milk Marie Biscuits ', 'Doreo Black Chocolate Sandwich Biscuit', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-16 08:37:33', 3),
(67, 'Cyprina Mango Mixed Juice ', 84, 'Cyprina Mango Mixed Juice ', 'Cyprina apple juices are 100% pure and natural. You can drink it without hesitation as it is free from any preservative.', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-16 09:57:34', 3),
(68, 'Cyprina juice drink cranberry ', 87, 'Cyprina juice drink cranberry', 'Cyprina apple juices are 100% pure and natural. You can drink it without hesitation as it is free from any preservative.', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-16 10:25:02', 3),
(69, 'Cyprina orange juice ', 88, 'Cyprina orange juice ', 'Cyprina apple juices are 100% pure and natural. You can drink it without hesitation as it is free from any preservative.', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 2, '0000-00-00', '0000-00-00', '2014-02-16', '2014-12-16', 'active', 0, 0, 0, '2014-02-16 10:28:35', 3),
(70, 'Eterna Strawberry Wafer Stick ', 89, 'Eterna Strawberry Wafer Stick ', 'Eterna Strawberry Wafer Stick ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 06:00:18', 3),
(71, 'Fit Crackers Cheese 250gm', 91, 'Fit Crackers Cheese ', 'Fit Crackers Cheese ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'inactive', 0, 0, 0, '2014-02-17 06:04:13', 3),
(72, 'Fit Crackers Milk Flavour ', 94, 'Fit Crackers Milk Flavour ', 'Fit Crackers Milk Flavour ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'inactive', 0, 0, 0, '2014-02-17 06:24:23', 3),
(73, 'Haque Anarkali Biscuits ', 95, 'Haque Anarkali Biscuits ', 'Haque Anarkali Biscuits ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 06:28:04', 3),
(74, 'Haque Bourbon ', 97, 'Haque Bourbon ', 'Haque Bourbon ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 06:35:09', 3),
(75, 'Haque Cream Crackers ', 98, 'Haque Cream Crackers ', 'Haque Cream Crackers ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 06:41:50', 3),
(76, 'Haque Ding Dong Wafer ', 99, 'Haque Ding Dong Wafer ', 'Haque Ding Dong Wafer ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 2, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 06:51:04', 3),
(77, 'Haque Ghee Biscuit Cream Sand', 0, '', 'Haque Ghee Biscuit Cream Sand', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', 'N;', 4, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'inactive', 0, 0, 0, '2014-02-17 07:01:04', 3),
(78, 'Haque Milk chocolate digestive biscuit ', 101, 'Haque Milk chocolate digestive biscuit ', 'Haque Milk chocolate digestive biscuit ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 07:04:08', 3),
(79, 'Haque Mr Cookie Biscuits ', 102, 'Haque Mr. Cookie Biscuit ', 'Haque Mr Cookie Biscuits ', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 07:07:24', 3),
(80, 'Nescafe Classic ', 105, 'Nescafe Classic ', 'Nescafe Classic', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 08:30:10', 3),
(81, 'Nescafe Gold Jar ', 106, 'Nescafe Gold Jar ', 'Nescafe Gold Jar', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 08:37:00', 3),
(82, 'Nescafe Original ', 107, 'Nescafe Original ', 'Nescafe Original', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 08:40:26', 3),
(83, 'Nestle Coffee Mate Box', 109, 'Nestle Coffee Mate Box', 'Nestle Coffee Mate Box', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 08:45:17', 3),
(84, 'Nestle Coffee Mate Jar ', 110, 'Nestle Coffee Mate Jar ', 'Nestle Coffee Mate Jar', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 08:47:39', 3),
(85, 'Nestle Coffee Mate Poly ', 111, 'Nestle Coffee Mate Poly ', 'Nestle Coffee Mate Poly', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 09:10:31', 3),
(86, 'Nestle Nescafe 3 in 1 Coffee Mix ', 112, 'Nestle Nescafe 3 in 1 Coffee Mix ', 'Nestle Nescafe 3 in 1 Coffee Mix', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 09:14:05', 3),
(87, 'Twix chocolate', 113, 'Twix chocolate', 'Twix chocolate', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 11:21:48', 3),
(88, 'Mum drinking water', 114, 'Mum drinking water', 'Mum drinking water', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 2, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 11:33:54', 3),
(89, 'Coca cola', 127, 'Coca Cola', 'Coca Cola', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 2, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 11:38:27', 3),
(90, 'Gatorade tropical drink', 116, 'Gatorade tropical drink', 'Gatorade tropical drink', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-17 11:47:45', 3),
(91, 'Twinings camomile tea', 117, 'Twinings camomile tea', 'Twinings camomile tea', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 2, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-18 04:57:41', 3),
(92, 'Milk vita liquid milk ', 118, 'Milk vita liquid milk', 'Milk vita liquid milk', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 2, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-18 05:08:40', 3),
(93, 'Perrier Mineral Water ', 123, 'Perrier Mineral Water ', 'Perrier Mineral Water', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-18 07:09:02', 3),
(94, 'Evian Water ', 0, '', 'Evian Water', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'active', 0, 0, 0, '2014-02-18 07:15:29', 3),
(95, 'Jibon Natural Mineral Water ', 125, 'Jibon Natural Mineral Water ', 'Jibon Natural Mineral Water', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-18 07:22:30', 3),
(96, 'Nestle Nescafe Matinal', 129, 'Nestle Nescafe Matinal', 'Nestle Nescafe Matinal', 'Nestle Nescafe', 'Nestle Nescafe ', 'Nestle Nescafe Matinal<br /><br />', '', 2, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-18 09:04:16', 3),
(97, 'Twinings english breakfast tea', 131, 'Twinings english breakfast tea', 'Twinings english breakfast tea', '', '', '', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-18 09:38:04', 2),
(98, 'Twinings green tea', 132, 'Twinings green tea', 'Twinings green tea', '', '', '', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-18 09:49:51', 2),
(99, 'Twinings lemon tea', 133, 'Twinings lemon tea', 'Twinings lemon tea', '', '', '', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-18 10:04:40', 2),
(100, 'Fresh home made bread ', 138, 'Fresh home made bread', 'Fresh home made bread', '', '', '', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-19 06:46:12', 2);

-- --------------------------------------------------------

--
-- Table structure for table `products_related`
--

CREATE TABLE IF NOT EXISTS `products_related` (
  `PR_id` int(11) NOT NULL AUTO_INCREMENT,
  `PR_current_product_id` int(11) NOT NULL,
  `PR_related_product_id` int(11) NOT NULL COMMENT '(not equal to current product ID, if current product ID =4 , related product ID cannot be 4)',
  `PR_priority_id` int(3) NOT NULL,
  `PR_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PR_created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`PR_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='products_related = PR' AUTO_INCREMENT=42 ;

--
-- Dumping data for table `products_related`
--

INSERT INTO `products_related` (`PR_id`, `PR_current_product_id`, `PR_related_product_id`, `PR_priority_id`, `PR_created`, `PR_created_by_id`) VALUES
(1, 29, 3, 0, '2014-02-04 05:02:29', 3),
(2, 51, 50, 0, '2014-02-05 07:01:42', 3),
(3, 55, 3, 0, '2014-02-08 08:20:38', 3),
(4, 56, 3, 0, '2014-02-08 08:23:57', 3),
(5, 56, 3, 0, '2014-02-08 08:23:58', 3),
(6, 57, 3, 0, '2014-02-08 08:41:32', 3),
(7, 57, 3, 0, '2014-02-08 08:41:32', 3),
(8, 57, 3, 0, '2014-02-08 08:41:32', 3),
(9, 57, 3, 0, '2014-02-08 08:41:32', 3),
(10, 60, 3, 0, '2014-02-08 09:21:33', 3),
(11, 60, 3, 0, '2014-02-08 09:21:33', 3),
(12, 60, 3, 0, '2014-02-08 09:21:33', 3),
(13, 60, 3, 0, '2014-02-08 09:21:33', 3),
(14, 60, 3, 0, '2014-02-08 09:21:33', 3),
(15, 60, 3, 0, '2014-02-08 09:21:33', 3),
(16, 60, 3, 0, '2014-02-08 09:21:33', 3),
(17, 60, 3, 0, '2014-02-08 09:21:33', 3),
(18, 77, 3, 0, '2014-02-17 07:03:32', 3),
(19, 77, 3, 0, '2014-02-17 07:03:32', 3),
(20, 77, 3, 0, '2014-02-17 07:03:32', 3),
(21, 77, 3, 0, '2014-02-17 07:03:32', 3),
(22, 77, 3, 0, '2014-02-17 07:03:32', 3),
(23, 77, 3, 0, '2014-02-17 07:03:32', 3),
(24, 77, 3, 0, '2014-02-17 07:03:32', 3),
(25, 77, 3, 0, '2014-02-17 07:03:32', 3),
(26, 78, 3, 0, '2014-02-17 07:07:03', 3),
(27, 78, 3, 0, '2014-02-17 07:07:03', 3),
(28, 78, 3, 0, '2014-02-17 07:07:03', 3),
(29, 78, 3, 0, '2014-02-17 07:07:03', 3),
(30, 78, 3, 0, '2014-02-17 07:07:03', 3),
(31, 78, 3, 0, '2014-02-17 07:07:03', 3),
(32, 78, 3, 0, '2014-02-17 07:07:03', 3),
(33, 78, 3, 0, '2014-02-17 07:07:03', 3),
(34, 93, 3, 0, '2014-02-18 07:13:04', 3),
(35, 93, 3, 0, '2014-02-18 07:13:04', 3),
(36, 93, 3, 0, '2014-02-18 07:13:04', 3),
(37, 93, 3, 0, '2014-02-18 07:13:04', 3),
(38, 93, 3, 0, '2014-02-18 07:13:04', 3),
(39, 93, 3, 0, '2014-02-18 07:13:04', 3),
(40, 93, 3, 0, '2014-02-18 07:13:04', 3),
(41, 93, 3, 0, '2014-02-18 07:13:04', 3);

-- --------------------------------------------------------

--
-- Table structure for table `products_upsell`
--

CREATE TABLE IF NOT EXISTS `products_upsell` (
  `PU_id` int(11) NOT NULL AUTO_INCREMENT,
  `PU_current_product_id` int(11) NOT NULL,
  `PU_related_product_id` int(11) NOT NULL COMMENT '(not equal to current product ID, if current product ID =4 , related product ID cannot be 4)',
  `PU_priority_id` int(3) NOT NULL,
  `PU_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PU_created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`PU_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='products_upsell = PU' AUTO_INCREMENT=112 ;

--
-- Dumping data for table `products_upsell`
--

INSERT INTO `products_upsell` (`PU_id`, `PU_current_product_id`, `PU_related_product_id`, `PU_priority_id`, `PU_created`, `PU_created_by_id`) VALUES
(1, 29, 3, 0, '2014-02-04 05:02:17', 3),
(2, 31, 29, 0, '2014-02-04 05:24:41', 3),
(3, 51, 50, 0, '2014-02-05 07:01:09', 3),
(4, 55, 51, 0, '2014-02-08 08:20:29', 3),
(5, 56, 51, 0, '2014-02-08 08:23:49', 3),
(6, 56, 55, 0, '2014-02-08 08:23:49', 3),
(7, 57, 50, 0, '2014-02-08 08:41:16', 3),
(8, 58, 50, 0, '2014-02-08 08:59:42', 3),
(9, 59, 3, 0, '2014-02-08 09:02:56', 3),
(10, 60, 3, 0, '2014-02-08 09:21:26', 3),
(11, 60, 3, 0, '2014-02-08 09:21:26', 3),
(12, 61, 3, 0, '2014-02-08 09:24:35', 3),
(13, 61, 3, 0, '2014-02-08 09:24:35', 3),
(14, 61, 3, 0, '2014-02-08 09:24:35', 3),
(15, 61, 3, 0, '2014-02-08 09:24:35', 3),
(16, 65, 3, 0, '2014-02-16 08:34:45', 3),
(17, 65, 3, 0, '2014-02-16 08:34:45', 3),
(18, 65, 3, 0, '2014-02-16 08:34:45', 3),
(19, 65, 3, 0, '2014-02-16 08:34:45', 3),
(20, 65, 3, 0, '2014-02-16 08:34:45', 3),
(21, 65, 3, 0, '2014-02-16 08:34:45', 3),
(22, 65, 3, 0, '2014-02-16 08:34:45', 3),
(23, 65, 3, 0, '2014-02-16 08:34:45', 3),
(24, 66, 3, 0, '2014-02-16 08:49:46', 3),
(25, 66, 3, 0, '2014-02-16 08:49:46', 3),
(26, 66, 3, 0, '2014-02-16 08:49:46', 3),
(27, 66, 3, 0, '2014-02-16 08:49:46', 3),
(28, 66, 3, 0, '2014-02-16 08:49:46', 3),
(29, 66, 3, 0, '2014-02-16 08:49:46', 3),
(30, 66, 3, 0, '2014-02-16 08:49:46', 3),
(31, 66, 3, 0, '2014-02-16 08:49:46', 3),
(32, 70, 3, 0, '2014-02-17 06:03:18', 3),
(33, 70, 3, 0, '2014-02-17 06:03:18', 3),
(34, 70, 3, 0, '2014-02-17 06:03:18', 3),
(35, 70, 3, 0, '2014-02-17 06:03:18', 3),
(36, 70, 3, 0, '2014-02-17 06:03:18', 3),
(37, 70, 3, 0, '2014-02-17 06:03:18', 3),
(38, 70, 3, 0, '2014-02-17 06:03:18', 3),
(39, 70, 3, 0, '2014-02-17 06:03:18', 3),
(40, 71, 3, 0, '2014-02-17 06:22:39', 3),
(41, 71, 3, 0, '2014-02-17 06:22:39', 3),
(42, 71, 3, 0, '2014-02-17 06:22:39', 3),
(43, 71, 3, 0, '2014-02-17 06:22:39', 3),
(44, 71, 3, 0, '2014-02-17 06:22:39', 3),
(45, 71, 3, 0, '2014-02-17 06:22:39', 3),
(46, 71, 3, 0, '2014-02-17 06:22:39', 3),
(47, 71, 3, 0, '2014-02-17 06:22:39', 3),
(48, 72, 3, 0, '2014-02-17 06:27:31', 3),
(49, 72, 3, 0, '2014-02-17 06:27:31', 3),
(50, 72, 3, 0, '2014-02-17 06:27:31', 3),
(51, 72, 3, 0, '2014-02-17 06:27:31', 3),
(52, 72, 3, 0, '2014-02-17 06:27:31', 3),
(53, 72, 3, 0, '2014-02-17 06:27:31', 3),
(54, 72, 3, 0, '2014-02-17 06:27:31', 3),
(55, 72, 3, 0, '2014-02-17 06:27:31', 3),
(56, 74, 3, 0, '2014-02-17 06:38:05', 3),
(57, 74, 3, 0, '2014-02-17 06:38:05', 3),
(58, 74, 3, 0, '2014-02-17 06:38:05', 3),
(59, 74, 3, 0, '2014-02-17 06:38:05', 3),
(60, 74, 3, 0, '2014-02-17 06:38:05', 3),
(61, 74, 3, 0, '2014-02-17 06:38:05', 3),
(62, 74, 3, 0, '2014-02-17 06:38:05', 3),
(63, 74, 3, 0, '2014-02-17 06:38:05', 3),
(64, 75, 3, 0, '2014-02-17 06:50:37', 3),
(65, 75, 3, 0, '2014-02-17 06:50:37', 3),
(66, 75, 3, 0, '2014-02-17 06:50:37', 3),
(67, 75, 3, 0, '2014-02-17 06:50:37', 3),
(68, 75, 3, 0, '2014-02-17 06:50:37', 3),
(69, 75, 3, 0, '2014-02-17 06:50:37', 3),
(70, 75, 3, 0, '2014-02-17 06:50:37', 3),
(71, 75, 3, 0, '2014-02-17 06:50:37', 3),
(72, 76, 3, 0, '2014-02-17 07:00:22', 3),
(73, 76, 3, 0, '2014-02-17 07:00:22', 3),
(74, 76, 3, 0, '2014-02-17 07:00:22', 3),
(75, 76, 3, 0, '2014-02-17 07:00:22', 3),
(76, 76, 3, 0, '2014-02-17 07:00:22', 3),
(77, 76, 3, 0, '2014-02-17 07:00:22', 3),
(78, 76, 3, 0, '2014-02-17 07:00:23', 3),
(79, 76, 3, 0, '2014-02-17 07:00:23', 3),
(80, 77, 3, 0, '2014-02-17 07:03:25', 3),
(81, 77, 3, 0, '2014-02-17 07:03:25', 3),
(82, 77, 3, 0, '2014-02-17 07:03:25', 3),
(83, 77, 3, 0, '2014-02-17 07:03:25', 3),
(84, 77, 3, 0, '2014-02-17 07:03:25', 3),
(85, 77, 3, 0, '2014-02-17 07:03:25', 3),
(86, 77, 3, 0, '2014-02-17 07:03:25', 3),
(87, 77, 3, 0, '2014-02-17 07:03:25', 3),
(88, 78, 3, 0, '2014-02-17 07:06:57', 3),
(89, 78, 3, 0, '2014-02-17 07:06:57', 3),
(90, 78, 3, 0, '2014-02-17 07:06:57', 3),
(91, 78, 3, 0, '2014-02-17 07:06:57', 3),
(92, 78, 3, 0, '2014-02-17 07:06:57', 3),
(93, 78, 3, 0, '2014-02-17 07:06:57', 3),
(94, 78, 3, 0, '2014-02-17 07:06:57', 3),
(95, 78, 3, 0, '2014-02-17 07:06:57', 3),
(96, 83, 3, 0, '2014-02-17 08:47:03', 3),
(97, 83, 3, 0, '2014-02-17 08:47:03', 3),
(98, 83, 3, 0, '2014-02-17 08:47:03', 3),
(99, 83, 3, 0, '2014-02-17 08:47:03', 3),
(100, 83, 3, 0, '2014-02-17 08:47:03', 3),
(101, 83, 3, 0, '2014-02-17 08:47:03', 3),
(102, 83, 3, 0, '2014-02-17 08:47:03', 3),
(103, 83, 3, 0, '2014-02-17 08:47:03', 3),
(104, 93, 3, 0, '2014-02-18 07:12:59', 3),
(105, 93, 3, 0, '2014-02-18 07:12:59', 3),
(106, 93, 3, 0, '2014-02-18 07:12:59', 3),
(107, 93, 3, 0, '2014-02-18 07:12:59', 3),
(108, 93, 3, 0, '2014-02-18 07:12:59', 3),
(109, 93, 3, 0, '2014-02-18 07:12:59', 3),
(110, 93, 3, 0, '2014-02-18 07:12:59', 3),
(111, 93, 3, 0, '2014-02-18 07:12:59', 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_also_like`
--

CREATE TABLE IF NOT EXISTS `product_also_like` (
  `PAL_id` int(11) NOT NULL AUTO_INCREMENT,
  `PAL_current_product_id` int(11) NOT NULL,
  `PAL_related_product_id` int(11) NOT NULL COMMENT '(not equal to current product ID, if current product ID =4 , related product ID cannot be 4)',
  `PAL_priority_id` int(3) NOT NULL,
  `PAL_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PAL_created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`PAL_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='product_also_like = PAL' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `product_also_like`
--

INSERT INTO `product_also_like` (`PAL_id`, `PAL_current_product_id`, `PAL_related_product_id`, `PAL_priority_id`, `PAL_created`, `PAL_created_by_id`) VALUES
(1, 29, 3, 0, '2014-02-04 05:02:45', 3),
(2, 51, 50, 0, '2014-02-05 07:02:28', 3),
(3, 75, 3, 0, '2014-02-17 06:50:41', 3),
(4, 76, 3, 0, '2014-02-17 07:00:35', 3),
(5, 76, 3, 0, '2014-02-17 07:00:35', 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE IF NOT EXISTS `product_categories` (
  `PC_id` int(11) NOT NULL AUTO_INCREMENT,
  `PC_product_id` int(11) NOT NULL,
  `PC_category_id` int(11) NOT NULL,
  `PC_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PC_created_by` int(11) NOT NULL,
  PRIMARY KEY (`PC_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='product_categories = PC' AUTO_INCREMENT=122 ;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`PC_id`, `PC_product_id`, `PC_category_id`, `PC_created`, `PC_created_by`) VALUES
(1, 1, 35, '2014-02-03 05:11:25', 0),
(2, 3, 45, '2014-02-03 06:10:42', 0),
(3, 2, 44, '2014-02-03 06:11:57', 0),
(4, 4, 44, '2014-02-03 06:31:24', 0),
(5, 5, 44, '2014-02-03 07:02:24', 0),
(6, 6, 44, '2014-02-03 08:04:50', 0),
(7, 8, 44, '2014-02-03 08:32:56', 0),
(8, 9, 44, '2014-02-03 08:38:29', 0),
(9, 10, 44, '2014-02-03 08:46:26', 0),
(10, 11, 44, '2014-02-03 08:52:48', 0),
(11, 12, 44, '2014-02-03 09:36:28', 0),
(12, 13, 44, '2014-02-03 09:45:41', 0),
(13, 14, 44, '2014-02-03 09:49:41', 0),
(14, 15, 44, '2014-02-03 10:00:29', 0),
(15, 16, 44, '2014-02-03 10:04:06', 0),
(16, 17, 44, '2014-02-03 10:08:36', 0),
(17, 18, 44, '2014-02-03 10:12:52', 0),
(18, 19, 44, '2014-02-03 10:17:15', 0),
(19, 20, 44, '2014-02-03 10:19:52', 0),
(20, 21, 44, '2014-02-03 10:26:47', 0),
(21, 22, 44, '2014-02-03 10:47:16', 0),
(22, 23, 44, '2014-02-03 10:54:01', 0),
(23, 24, 44, '2014-02-03 11:07:52', 0),
(24, 25, 44, '2014-02-03 11:11:58', 0),
(25, 26, 44, '2014-02-04 04:26:48', 0),
(26, 27, 44, '2014-02-04 04:41:37', 0),
(27, 29, 45, '2014-02-04 04:58:24', 0),
(28, 30, 44, '2014-02-04 05:06:02', 0),
(29, 31, 45, '2014-02-04 05:20:16', 0),
(30, 32, 44, '2014-02-04 05:30:09', 0),
(31, 33, 44, '2014-02-04 05:51:59', 0),
(32, 34, 44, '2014-02-04 06:01:55', 0),
(33, 35, 44, '2014-02-04 06:06:40', 0),
(34, 36, 45, '2014-02-04 06:11:05', 0),
(35, 37, 44, '2014-02-04 06:16:38', 0),
(36, 38, 45, '2014-02-04 06:25:57', 0),
(37, 39, 44, '2014-02-04 06:55:48', 0),
(38, 40, 44, '2014-02-04 07:09:21', 0),
(39, 41, 44, '2014-02-04 07:21:36', 0),
(40, 42, 44, '2014-02-04 07:52:38', 0),
(41, 43, 44, '2014-02-04 08:00:28', 0),
(42, 44, 44, '2014-02-04 08:22:25', 0),
(44, 47, 44, '2014-02-04 08:56:09', 0),
(45, 46, 44, '2014-02-04 09:08:34', 0),
(46, 48, 44, '2014-02-04 09:42:46', 0),
(47, 49, 44, '2014-02-04 09:55:45', 0),
(48, 50, 45, '2014-02-05 06:48:43', 0),
(49, 51, 45, '2014-02-05 06:57:11', 0),
(50, 52, 44, '2014-02-06 10:25:53', 0),
(51, 53, 44, '2014-02-06 10:40:39', 0),
(52, 54, 44, '2014-02-06 11:00:57', 0),
(53, 55, 45, '2014-02-08 08:17:29', 0),
(54, 56, 45, '2014-02-08 08:21:30', 0),
(55, 57, 45, '2014-02-08 08:38:48', 0),
(56, 58, 45, '2014-02-08 08:57:07', 0),
(57, 59, 45, '2014-02-08 09:01:42', 0),
(58, 60, 45, '2014-02-08 09:04:28', 0),
(59, 61, 45, '2014-02-08 09:22:49', 0),
(60, 62, 45, '2014-02-08 09:35:30', 0),
(61, 1, 25, '2014-02-12 11:19:55', 0),
(62, 2, 26, '2014-02-13 06:59:21', 0),
(63, 64, 44, '2014-02-16 05:17:22', 0),
(65, 45, 26, '2014-02-16 07:22:20', 0),
(66, 45, 44, '2014-02-16 07:51:04', 0),
(67, 64, 26, '2014-02-16 07:58:50', 0),
(68, 65, 45, '2014-02-16 08:26:07', 0),
(69, 66, 45, '2014-02-16 08:41:49', 0),
(71, 67, 26, '2014-02-16 09:59:30', 0),
(72, 67, 44, '2014-02-16 09:59:30', 0),
(73, 68, 26, '2014-02-16 10:26:51', 0),
(74, 68, 44, '2014-02-16 10:26:51', 0),
(75, 69, 26, '2014-02-16 10:30:38', 0),
(76, 69, 44, '2014-02-16 10:30:38', 0),
(77, 3, 26, '2014-02-16 12:06:52', 0),
(78, 29, 26, '2014-02-17 05:39:44', 0),
(79, 31, 26, '2014-02-17 05:47:45', 0),
(80, 36, 26, '2014-02-17 05:51:48', 0),
(81, 38, 26, '2014-02-17 05:52:09', 0),
(82, 50, 26, '2014-02-17 05:52:32', 0),
(83, 51, 26, '2014-02-17 05:52:49', 0),
(84, 55, 26, '2014-02-17 05:53:06', 0),
(85, 56, 26, '2014-02-17 05:56:13', 0),
(86, 57, 26, '2014-02-17 05:56:30', 0),
(87, 58, 26, '2014-02-17 05:56:50', 0),
(88, 70, 45, '2014-02-17 06:00:42', 0),
(89, 71, 45, '2014-02-17 06:05:42', 0),
(90, 72, 45, '2014-02-17 06:24:38', 0),
(91, 73, 45, '2014-02-17 06:28:23', 0),
(92, 74, 45, '2014-02-17 06:35:20', 0),
(93, 75, 45, '2014-02-17 06:42:17', 0),
(94, 76, 45, '2014-02-17 06:51:14', 0),
(95, 77, 45, '2014-02-17 07:01:22', 0),
(96, 78, 45, '2014-02-17 07:04:22', 0),
(97, 79, 45, '2014-02-17 07:07:38', 0),
(99, 80, 28, '2014-02-17 08:36:02', 0),
(100, 81, 28, '2014-02-17 08:37:20', 0),
(101, 82, 28, '2014-02-17 08:40:48', 0),
(102, 83, 28, '2014-02-17 08:45:30', 0),
(103, 84, 28, '2014-02-17 08:47:48', 0),
(104, 85, 28, '2014-02-17 09:10:42', 0),
(105, 86, 28, '2014-02-17 09:14:25', 0),
(106, 87, 49, '2014-02-17 11:29:45', 0),
(107, 88, 27, '2014-02-17 11:35:04', 0),
(108, 89, 46, '2014-02-17 11:42:01', 0),
(109, 90, 50, '2014-02-17 11:49:04', 0),
(110, 91, 47, '2014-02-18 05:02:04', 0),
(111, 92, 48, '2014-02-18 05:11:05', 0),
(112, 93, 27, '2014-02-18 07:09:18', 0),
(113, 95, 27, '2014-02-18 07:22:43', 0),
(114, 96, 28, '2014-02-18 09:07:09', 0),
(115, 97, 47, '2014-02-18 09:38:15', 0),
(116, 98, 47, '2014-02-18 09:50:04', 0),
(117, 99, 47, '2014-02-18 10:05:55', 0),
(118, 100, 41, '2014-02-19 06:46:38', 0),
(119, 1, 53, '2014-02-22 08:05:40', 0),
(120, 5, 53, '2014-02-22 08:06:14', 0),
(121, 31, 53, '2014-02-22 08:11:17', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_discounts`
--

CREATE TABLE IF NOT EXISTS `product_discounts` (
  `PD_id` int(11) NOT NULL AUTO_INCREMENT,
  `PD_product_id` int(11) NOT NULL,
  `PD_inventory_id` int(11) NOT NULL,
  `PD_start_date` date NOT NULL,
  `PD_end_date` date NOT NULL,
  `PD_amount` float NOT NULL,
  `PD_status` int(11) NOT NULL DEFAULT '1',
  `PD_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PD_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`PD_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `product_discounts`
--

INSERT INTO `product_discounts` (`PD_id`, `PD_product_id`, `PD_inventory_id`, `PD_start_date`, `PD_end_date`, `PD_amount`, `PD_status`, `PD_updated`, `PD_updated_by`) VALUES
(1, 1, 57, '2014-02-01', '2014-02-28', 5, 0, '2014-02-12 11:25:33', 1),
(2, 5, 83, '2014-02-01', '2014-03-31', 5, 1, '2014-02-25 04:28:53', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE IF NOT EXISTS `product_images` (
  `PI_id` int(11) NOT NULL AUTO_INCREMENT,
  `PI_product_id` int(11) NOT NULL,
  `PI_file_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `PI_priority` int(6) NOT NULL,
  `PI_inventory_id` int(11) NOT NULL,
  `PI_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PI_updated_by` int(5) NOT NULL,
  PRIMARY KEY (`PI_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PI = product_images' AUTO_INCREMENT=127 ;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`PI_id`, `PI_product_id`, `PI_file_name`, `PI_priority`, `PI_inventory_id`, `PI_updated`, `PI_updated_by`) VALUES
(2, 3, '3_2.gif', 1, 2, '2014-02-03 06:11:17', 3),
(6, 7, '7_6.gif', 5, 0, '2014-02-03 08:11:33', 2),
(7, 8, '8_7.gif', 5, 0, '2014-02-03 08:33:31', 2),
(8, 9, '9_8.jpeg', 5, 8, '2014-02-03 08:38:46', 1),
(9, 10, '10_9.gif', 5, 0, '2014-02-03 08:53:44', 2),
(10, 11, '11_10.gif', 4, 0, '2014-02-03 08:55:05', 2),
(12, 13, '13_11.gif', 0, 0, '2014-02-03 09:45:26', 2),
(13, 14, '14_13.gif', 4, 0, '2014-02-03 09:49:54', 2),
(14, 15, '15_14.gif', 4, 0, '2014-02-03 10:00:40', 2),
(15, 16, '16_15.gif', 0, 0, '2014-02-03 10:05:12', 2),
(16, 17, '17_16.gif', 1, 0, '2014-02-03 10:08:17', 2),
(17, 18, '18_17.gif', 0, 0, '2014-02-03 10:13:38', 2),
(18, 20, '20_18.gif', 0, 0, '2014-02-03 10:22:14', 2),
(19, 19, '19_19.gif', 1, 0, '2014-02-03 10:23:50', 2),
(20, 21, '21_20.gif', 0, 0, '2014-02-03 10:26:59', 2),
(21, 22, '22_21.gif', 4, 0, '2014-02-03 10:47:54', 2),
(22, 23, '23_22.jpg', 0, 0, '2014-02-03 10:54:18', 2),
(23, 24, '24_23.gif', 0, 0, '2014-02-03 11:07:37', 2),
(24, 25, '25_24.gif', 0, 0, '2014-02-03 11:12:10', 2),
(25, 26, '26_25.gif', 0, 0, '2014-02-04 04:27:00', 2),
(26, 27, '27_26.gif', 1, 0, '2014-02-04 04:42:21', 2),
(29, 28, '28_27.gif', 0, 0, '2014-02-04 04:54:49', 2),
(30, 29, '29_30.JPG', 2, 27, '2014-02-04 04:58:51', 3),
(31, 31, '31_31.jpg', 3, 29, '2014-02-04 05:21:32', 3),
(32, 32, '32_32.gif', 0, 0, '2014-02-04 05:30:45', 2),
(33, 30, '30_33.gif', 0, 0, '2014-02-04 05:37:45', 2),
(34, 33, '33_34.gif', 0, 0, '2014-02-04 05:52:13', 2),
(35, 34, '34_35.gif', 0, 0, '2014-02-04 06:02:15', 2),
(36, 35, '35_36.gif', 0, 0, '2014-02-04 06:08:23', 2),
(37, 36, '36_37.jpg', 4, 33, '2014-02-04 06:11:45', 1),
(38, 37, '37_38.gif', 0, 0, '2014-02-04 06:16:53', 2),
(39, 38, '38_39.jpeg', 6, 59, '2014-02-04 06:33:21', 3),
(40, 39, '39_40.gif', 0, 0, '2014-02-04 06:55:35', 2),
(41, 40, '40_41.gif', 0, 0, '2014-02-04 07:07:58', 2),
(43, 41, '41_42.gif', 0, 0, '2014-02-04 07:49:42', 2),
(44, 43, '43_44.gif', 0, 0, '2014-02-04 08:00:49', 2),
(45, 44, '44_45.gif', 0, 0, '2014-02-04 08:23:18', 2),
(46, 45, '45_46.jpg', 0, 42, '2014-02-04 08:36:02', 2),
(47, 46, '46_47.jpg', 0, 43, '2014-02-04 09:08:51', 2),
(48, 47, '47_48.jpg', 0, 44, '2014-02-04 09:10:59', 2),
(49, 48, '48_49.jpg', 0, 0, '2014-02-04 09:42:59', 2),
(50, 49, '49_50.jpg', 0, 0, '2014-02-04 09:56:13', 2),
(51, 50, '50_51.jpeg', 7, 47, '2014-02-05 06:50:07', 3),
(52, 51, '51_52.jpg', 8, 48, '2014-02-05 06:57:34', 3),
(53, 52, '52_53.jpg', 0, 0, '2014-02-06 10:26:22', 2),
(54, 53, '53_54.jpg', 0, 0, '2014-02-06 10:40:54', 2),
(55, 55, '55_55.jpeg', 9, 51, '2014-02-08 08:18:02', 3),
(56, 56, '56_56.jpg', 10, 52, '2014-02-08 08:22:01', 3),
(57, 57, '57_57.jpg', 11, 53, '2014-02-08 08:38:59', 3),
(58, 58, '58_58.jpeg', 12, 54, '2014-02-08 08:57:43', 3),
(59, 59, '59_59.jpeg', 13, 0, '2014-02-08 09:02:18', 3),
(61, 60, '60_60.jpg', 14, 0, '2014-02-08 09:05:21', 3),
(62, 61, '61_62.png', 15, 0, '2014-02-08 09:23:17', 3),
(63, 62, '62_63.jpg', 16, 0, '2014-02-08 09:36:06', 3),
(70, 64, '64_66.jpg', 5, 86, '2014-02-16 07:48:57', 1),
(75, 65, '65_75.jpg', 1, 74, '2014-02-16 08:34:25', 3),
(79, 66, '66_79.jpeg', 3, 78, '2014-02-16 08:49:26', 3),
(81, 4, '4_81.gif', 0, 81, '2014-02-16 09:28:01', 2),
(82, 4, '4_82.gif', 0, 82, '2014-02-16 09:37:47', 2),
(83, 5, '5_83.gif', 0, 83, '2014-02-16 09:51:23', 2),
(85, 67, '67_84.jpg', 0, 84, '2014-02-16 10:21:22', 2),
(86, 68, '68_86.jpg', 3, 87, '2014-02-16 10:27:20', 2),
(87, 69, '69_87.jpg', 0, 88, '2014-02-16 10:30:16', 2),
(88, 54, '54_88.jpg', 0, 58, '2014-02-16 11:32:09', 2),
(89, 70, '70_89.jpeg', 0, 89, '2014-02-17 06:02:48', 3),
(93, 71, '71_93.gif', 0, 91, '2014-02-17 06:21:34', 3),
(94, 72, '72_94.gif', 0, 94, '2014-02-17 06:26:45', 3),
(95, 73, '73_95.jpg', 0, 95, '2014-02-17 06:30:04', 3),
(96, 74, '74_96.jpg', 0, 97, '2014-02-17 06:37:42', 3),
(97, 75, '75_97.jpg', 0, 98, '2014-02-17 06:44:14', 3),
(98, 76, '76_98.jpg', 0, 99, '2014-02-17 06:59:10', 3),
(99, 77, '77_99.jpg', 0, 100, '2014-02-17 07:02:55', 3),
(100, 78, '78_100.jpg', 0, 101, '2014-02-17 07:06:08', 3),
(101, 79, '79_101.jpg', 0, 102, '2014-02-17 07:11:38', 3),
(102, 80, '80_102.jpg', 0, 105, '2014-02-17 08:34:20', 3),
(103, 81, '81_103.jpg', 0, 106, '2014-02-17 08:38:28', 3),
(104, 82, '82_104.jpg', 0, 107, '2014-02-17 08:43:47', 3),
(105, 83, '83_105.jpg', 0, 109, '2014-02-17 08:46:32', 3),
(106, 84, '84_106.jpg', 0, 110, '2014-02-17 08:48:55', 3),
(107, 85, '85_107.png', 0, 111, '2014-02-17 09:11:55', 3),
(108, 86, '86_108.jpg', 0, 112, '2014-02-17 09:15:39', 3),
(109, 87, '87_109.jpg', 0, 113, '2014-02-17 11:28:51', 2),
(110, 88, '88_110.jpeg', 0, 114, '2014-02-17 11:35:45', 2),
(112, 90, '90_112.jpg', 0, 116, '2014-02-17 11:49:32', 2),
(113, 91, '91_113.jpg', 0, 117, '2014-02-18 05:01:47', 2),
(114, 92, '92_114.jpg', 0, 118, '2014-02-18 05:11:38', 2),
(115, 93, '93_115.png', 0, 123, '2014-02-18 07:10:54', 3),
(117, 95, '95_117.png', 0, 125, '2014-02-18 07:24:41', 3),
(118, 89, '89_118.jpg', 0, 127, '2014-02-18 08:16:34', 2),
(119, 96, '96_119.jpg', 0, 129, '2014-02-18 09:12:30', 3),
(120, 97, '97_120.jpg', 0, 131, '2014-02-18 09:41:35', 2),
(121, 98, '98_121.jpg', 0, 132, '2014-02-18 09:54:35', 2),
(122, 99, '99_122.jpg', 0, 133, '2014-02-18 10:07:21', 2),
(123, 6, '6_123.gif', 0, 134, '2014-02-19 05:06:22', 2),
(124, 6, '6_124.gif', 0, 135, '2014-02-19 05:07:00', 2),
(125, 100, '100_125.jpg', 0, 138, '2014-02-19 06:58:57', 2),
(126, 1, '1_126.jpg', 0, 139, '2014-02-19 07:27:34', 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_inventories`
--

CREATE TABLE IF NOT EXISTS `product_inventories` (
  `PI_id` int(11) NOT NULL AUTO_INCREMENT,
  `PI_inventory_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `PI_product_id` int(11) NOT NULL,
  `PI_color_id` int(11) NOT NULL,
  `PI_size_id` int(11) NOT NULL,
  `PI_quantity` int(5) NOT NULL,
  `PI_cost` decimal(10,2) NOT NULL,
  `PI_current_price` decimal(10,2) NOT NULL,
  `PI_old_price` decimal(10,2) NOT NULL,
  `PI_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PI_updated_by` int(5) NOT NULL,
  PRIMARY KEY (`PI_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PI = product_inventories' AUTO_INCREMENT=142 ;

--
-- Dumping data for table `product_inventories`
--

INSERT INTO `product_inventories` (`PI_id`, `PI_inventory_title`, `PI_product_id`, `PI_color_id`, `PI_size_id`, `PI_quantity`, `PI_cost`, `PI_current_price`, `PI_old_price`, `PI_updated`, `PI_updated_by`) VALUES
(2, 'Fit crackers milk flavour 1piece', 3, 0, 4, 1, 12.00, 15.00, 0.00, '2014-02-03 06:13:22', 2),
(6, '', 7, 0, 11, 500, 20.00, 25.00, 0.00, '2014-02-03 08:13:15', 2),
(7, '', 8, 0, 13, 500, 20.00, 25.00, 0.00, '2014-02-03 08:34:46', 2),
(8, ' mango juice 1 ltr', 9, 0, 14, 500, 90.00, 100.00, 0.00, '2014-02-03 08:40:40', 1),
(9, '', 10, 0, 13, 500, 20.00, 25.00, 0.00, '2014-02-03 08:48:42', 2),
(10, '', 11, 0, 14, 500, 90.00, 100.00, 0.00, '2014-02-03 08:55:43', 2),
(11, '', 13, 0, 14, 500, 90.00, 100.00, 0.00, '2014-02-03 09:39:40', 2),
(12, '', 14, 0, 14, 500, 90.00, 100.00, 0.00, '2014-02-03 09:51:37', 2),
(13, '', 15, 0, 14, 500, 90.00, 100.00, 0.00, '2014-02-03 10:01:04', 2),
(14, '', 16, 0, 11, 500, 20.00, 25.00, 0.00, '2014-02-03 10:04:33', 2),
(15, '', 17, 0, 15, 500, 12.00, 15.00, 0.00, '2014-02-03 10:09:43', 2),
(16, '', 18, 0, 15, 300, 12.00, 15.00, 0.00, '2014-02-03 10:14:25', 2),
(17, '', 19, 0, 15, 500, 12.00, 15.00, 0.00, '2014-02-03 10:17:42', 2),
(18, '', 20, 0, 15, 500, 12.00, 15.00, 0.00, '2014-02-03 10:20:35', 2),
(19, '', 21, 0, 15, 300, 12.00, 15.00, 0.00, '2014-02-03 10:30:08', 2),
(20, '', 22, 0, 11, 500, 20.00, 25.00, 0.00, '2014-02-03 10:48:44', 2),
(21, '', 23, 0, 13, 500, 20.00, 25.00, 0.00, '2014-02-03 10:55:11', 2),
(22, '', 24, 0, 13, 300, 20.00, 25.00, 0.00, '2014-02-03 11:09:11', 2),
(23, '', 25, 0, 16, 500, 40.00, 50.00, 0.00, '2014-02-03 11:24:25', 2),
(24, '', 26, 0, 14, 500, 90.00, 100.00, 0.00, '2014-02-04 04:29:15', 2),
(25, '', 27, 0, 13, 300, 30.00, 25.00, 0.00, '2014-02-04 04:42:58', 2),
(26, '', 28, 0, 13, 300, 25.00, 30.00, 0.00, '2014-02-04 04:55:34', 2),
(27, 'Chocolate cream 1piece', 29, 0, 4, 100, 100.00, 350.00, 0.00, '2014-02-04 05:01:13', 2),
(28, '', 30, 0, 13, 300, 20.00, 25.00, 0.00, '2014-02-04 05:07:29', 2),
(29, 'Tiffany chocolate cream wafers 1packet', 31, 0, 7, 100, 100.00, 209.00, 230.00, '2014-02-04 05:22:28', 1),
(30, '', 32, 0, 13, 300, 20.00, 25.00, 0.00, '2014-02-04 05:31:27', 2),
(31, '', 33, 0, 13, 300, 20.00, 25.00, 0.00, '2014-02-04 05:53:02', 2),
(32, '', 35, 0, 13, 300, 20.00, 25.00, 0.00, '2014-02-04 06:07:54', 2),
(33, 'Ano danish butter cookies tin blue 1packet', 36, 0, 7, 100, 100.00, 454.00, 0.00, '2014-02-04 06:12:31', 2),
(34, '', 37, 0, 13, 300, 25.00, 30.00, 0.00, '2014-02-04 06:18:07', 2),
(35, '', 39, 0, 13, 300, 25.00, 30.00, 0.00, '2014-02-04 07:04:21', 2),
(36, '', 40, 0, 13, 300, 25.00, 30.00, 0.00, '2014-02-04 07:09:54', 2),
(38, '', 41, 0, 13, 300, 25.00, 30.00, 0.00, '2014-02-04 07:51:28', 2),
(39, '', 42, 0, 13, 200, 25.00, 30.00, 0.00, '2014-02-04 07:53:32', 2),
(40, '', 43, 0, 13, 200, 25.00, 30.00, 0.00, '2014-02-04 08:01:47', 2),
(41, '', 44, 0, 13, 200, 25.00, 30.00, 0.00, '2014-02-04 08:24:00', 2),
(42, 'Aarong mango juice 250ml', 45, 0, 13, 200, 22.00, 40.00, 0.00, '2014-02-04 08:37:19', 2),
(43, 'Acme mango juice classic 250ml', 46, 0, 13, 500, 20.00, 30.00, 0.00, '2014-02-04 08:51:05', 2),
(44, 'mango juice premium', 47, 0, 13, 300, 20.00, 30.00, 0.00, '2014-02-04 09:14:07', 3),
(45, '', 48, 0, 14, 300, 30.00, 35.00, 0.00, '2014-02-04 09:43:26', 2),
(46, 'Acme mango juice classic 1ltr', 49, 0, 14, 200, 25.00, 35.00, 0.00, '2014-02-04 09:56:50', 2),
(47, 'Bengal orange cake biscuit 1packet', 50, 0, 7, 100, 10.00, 35.00, 0.00, '2014-02-05 06:51:09', 2),
(48, 'Bengal orange cake biscuit  1tin', 51, 0, 20, 100, 100.00, 220.00, 0.00, '2014-02-05 06:59:39', 2),
(49, '', 52, 0, 13, 200, 25.00, 30.00, 0.00, '2014-02-06 10:27:49', 2),
(50, '', 53, 0, 21, 300, 350.00, 400.00, 0.00, '2014-02-06 10:42:09', 2),
(51, 'Bengal pineapple cream biscuit 1 piece', 55, 0, 4, 100, 10.00, 60.00, 0.00, '2014-02-08 08:18:56', 2),
(52, 'Bissin premium coconut wafers 1piece', 56, 0, 4, 100, 10.00, 206.00, 0.00, '2014-02-08 08:22:38', 2),
(53, 'Cadbury oreo biscuit 1piece', 57, 0, 4, 100, 10.00, 90.00, 0.00, '2014-02-08 08:39:48', 2),
(54, 'Cadbury oreo sandwich biscuits 1packet', 58, 0, 7, 100, 10.00, 48.00, 0.00, '2014-02-08 08:58:49', 2),
(55, '', 60, 0, 7, 100, 10.00, 35.00, 0.00, '2014-02-08 09:05:56', 3),
(56, '', 61, 0, 7, 100, 10.00, 13.00, 0.00, '2014-02-08 09:23:57', 3),
(58, 'Berri cranberry juice 100gm', 54, 0, 1, 40, 20.00, 25.00, 0.00, '2014-02-13 06:27:32', 3),
(59, 'Baton rouge ovaltine biscuit 1packet', 38, 0, 7, 20, 20.00, 25.00, 0.00, '2014-02-13 06:44:02', 2),
(74, 'Danish Milk Marie Biscuits 285gm', 65, 0, 22, 100, 25.00, 50.00, 0.00, '2014-02-16 08:29:26', 3),
(78, 'Doreo Black Chocolate Sandwich Biscuit 320gm', 66, 0, 23, 50, 90.00, 120.00, 0.00, '2014-02-16 08:48:31', 3),
(80, 'Pran joy mango juice 200ml', 2, 0, 11, 300, 20.00, 25.00, 0.00, '2014-02-16 09:22:59', 2),
(82, 'Pran joy orange 200ml', 4, 0, 11, 500, 20.00, 25.00, 0.00, '2014-02-16 09:32:35', 2),
(83, 'Pran joy fruit cocktail 200ml', 5, 0, 11, 150, 20.00, 25.00, 0.00, '2014-02-16 09:42:43', 2),
(84, 'Cyprina Mango Mixed Juice 1ltr', 67, 0, 14, 150, 250.00, 295.00, 0.00, '2014-02-16 09:58:42', 2),
(86, 'Cyprina apple juice 1ltr', 64, 0, 14, 15, 250.00, 295.00, 0.00, '2014-02-16 10:09:04', 2),
(87, 'Cyprina juice drink cranberry 1ltr', 68, 0, 14, 300, 250.00, 295.00, 0.00, '2014-02-16 10:26:12', 2),
(88, 'Cyprina orange juice 1ltr', 69, 0, 14, 300, 250.00, 270.00, 0.00, '2014-02-16 10:29:22', 2),
(89, 'Eterna Strawberry Wafer Stick 350gm', 70, 0, 24, 50, 100.00, 510.00, 0.00, '2014-02-17 06:01:48', 3),
(91, 'Fit Crackers Cheese 250 gm', 71, 0, 25, 100, 50.00, 100.00, 0.00, '2014-02-17 06:11:10', 3),
(94, 'Fit Crackers Milk Flavour 130 gm', 72, 0, 26, 50, 10.00, 30.00, 0.00, '2014-02-17 06:25:42', 3),
(95, 'Haque Anarkali Biscuits 220 gm', 73, 0, 27, 50, 20.00, 40.00, 0.00, '2014-02-17 06:29:44', 3),
(97, 'Haque Bourbon 108 gm', 74, 0, 28, 50, 10.00, 20.00, 0.00, '2014-02-17 06:36:53', 3),
(98, 'Haque Cream Crackers ', 75, 0, 29, 50, 10.00, 20.00, 0.00, '2014-02-17 06:43:14', 3),
(99, 'Haque Ding Dong Wafer 80gm', 76, 0, 30, 50, 10.00, 25.00, 0.00, '2014-02-17 06:52:26', 3),
(100, 'Haque Ghee Biscuit Cream Sand', 77, 0, 32, 50, 20.00, 35.00, 0.00, '2014-02-17 07:02:25', 3),
(101, 'Haque Milk chocolate digestive biscuit 145 gm', 78, 0, 33, 50, 30.00, 32.00, 0.00, '2014-02-17 07:05:32', 3),
(102, 'Haque Mr Cookie Biscuits ', 79, 0, 34, 50, 20.00, 24.00, 0.00, '2014-02-17 07:08:53', 3),
(103, 'Haque Mr Cookie Biscuits ', 79, 0, 35, 50, 10.00, 12.00, 0.00, '2014-02-17 07:14:14', 3),
(104, 'Haque Mr Cookie Biscuits ', 79, 0, 1, 50, 10.00, 20.00, 0.00, '2014-02-17 07:14:32', 3),
(105, 'Nescafe Classic 200 gm', 80, 0, 36, 50, 400.00, 495.00, 0.00, '2014-02-17 08:33:26', 3),
(106, 'Nescafe Gold Jar 200 gm', 81, 0, 36, 50, 1000.00, 1050.00, 0.00, '2014-02-17 08:38:08', 3),
(107, 'Nescafe Original big size', 82, 0, 37, 50, 1000.00, 1250.00, 0.00, '2014-02-17 08:42:12', 3),
(108, 'Nescafe Original ', 82, 0, 37, 50, 1000.00, 1250.00, 0.00, '2014-02-17 08:42:46', 3),
(109, 'Nestle Coffee Mate Box 450 gm', 83, 0, 38, 50, 200.00, 250.00, 0.00, '2014-02-17 08:46:20', 3),
(110, 'Nestle Coffee Mate Jar 400 gm', 84, 0, 39, 50, 200.00, 250.00, 0.00, '2014-02-17 08:48:34', 3),
(111, 'Nestle Coffee Mate Poly 450gm', 85, 0, 38, 50, 300.00, 303.00, 0.00, '2014-02-17 09:11:19', 3),
(112, 'Nestle Nescafe 3 in 1 Coffee Mix 14gm', 86, 0, 40, 100, 8.00, 10.00, 0.00, '2014-02-17 09:15:19', 3),
(113, 'Twix chocolate 50gm', 87, 0, 18, 150, 80.00, 90.00, 0.00, '2014-02-17 11:23:24', 2),
(114, 'Mum drinking water ', 88, 0, 21, 200, 25.00, 30.00, 0.00, '2014-02-17 11:34:52', 3),
(116, 'Gatorade tropical drink 500ml', 90, 0, 16, 150, 125.00, 130.00, 0.00, '2014-02-17 11:48:38', 2),
(117, 'Twinings camomile tea 25gm', 91, 0, 42, 150, 80.00, 90.00, 0.00, '2014-02-18 05:00:30', 2),
(118, 'Milk vita liquid milk 1ltr', 92, 0, 14, 150, 50.00, 62.00, 0.00, '2014-02-18 05:10:32', 2),
(119, 'Mum drinking water', 88, 0, 16, 50, 10.00, 15.00, 0.00, '2014-02-18 06:41:21', 3),
(120, 'Mum drinking water', 88, 0, 44, 50, 10.00, 35.00, 0.00, '2014-02-18 06:42:22', 3),
(121, 'Mum drinking water', 88, 0, 45, 50, 10.00, 70.00, 0.00, '2014-02-18 06:42:39', 3),
(123, 'Perrier Mineral Water 750 ml', 93, 0, 46, 50, 200.00, 220.00, 0.00, '2014-02-18 07:10:10', 3),
(124, 'Perrier Mineral Water 330 ml', 93, 0, 47, 50, 100.00, 126.00, 0.00, '2014-02-18 07:12:37', 3),
(125, 'Jibon Natural Mineral Water 500 ml', 95, 0, 16, 50, 10.00, 15.00, 0.00, '2014-02-18 07:23:59', 3),
(127, 'Coca cola  2ltr', 89, 0, 41, 300, 90.00, 100.00, 0.00, '2014-02-18 08:14:06', 2),
(128, 'Coca cola 1.25ltr', 89, 0, 43, 500, 60.00, 68.00, 0.00, '2014-02-18 08:18:15', 2),
(129, 'Nestle Nescafe Matinal 200 gm', 96, 0, 36, 50, 500.00, 570.00, 0.00, '2014-02-18 09:10:53', 3),
(130, 'Nescafe Gold Jar 100 gm', 81, 0, 1, 50, 600.00, 668.00, 0.00, '2014-02-18 09:15:45', 3),
(131, 'Twinings english breakfast tea 50gm', 97, 0, 18, 200, 250.00, 290.00, 0.00, '2014-02-18 09:40:11', 2),
(132, 'Twinings green tea 50gm', 98, 0, 18, 500, 280.00, 295.00, 0.00, '2014-02-18 09:50:52', 2),
(133, 'Twinings lemon tea 50gm', 99, 0, 18, 300, 280.00, 290.00, 0.00, '2014-02-18 10:06:23', 2),
(134, 'Pran mango juice pack 125ml', 6, 0, 15, 200, 18.00, 20.00, 0.00, '2014-02-19 04:38:16', 2),
(135, 'Pran mango juice pack 200ml', 6, 0, 11, 200, 20.00, 22.00, 0.00, '2014-02-19 04:39:26', 2),
(136, 'Pran mango juice pack 250ml', 6, 0, 13, 200, 25.00, 28.00, 0.00, '2014-02-19 04:41:30', 2),
(137, 'Pran mango juice pack 1ltr', 6, 0, 14, 150, 60.00, 70.00, 0.00, '2014-02-19 04:42:09', 2),
(138, 'Fresh home made bread ', 100, 0, 48, 200, 70.00, 75.00, 0.00, '2014-02-19 06:58:12', 2),
(139, 'Cabbage (à¦¬à¦¾à¦à¦§à¦¾à¦•à¦ªà¦¿) ', 1, 0, 4, 100, 15.00, 20.00, 0.00, '2014-02-19 07:26:38', 3),
(140, 'Cabbage (à¦¬à¦¾à¦à¦§à¦¾à¦•à¦ªà¦¿) ', 1, 0, 9, 100, 15.00, 80.00, 0.00, '2014-02-19 07:26:46', 3),
(141, 'Cabbage (à¦¬à¦¾à¦à¦§à¦¾à¦•à¦ªà¦¿) ', 1, 0, 8, 100, 15.00, 240.00, 0.00, '2014-02-19 07:27:07', 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_inventory_log`
--

CREATE TABLE IF NOT EXISTS `product_inventory_log` (
  `PIL_id` int(11) NOT NULL AUTO_INCREMENT,
  `PIL_PI_id` int(11) NOT NULL COMMENT 'product inventory table id',
  `PIL_date` date NOT NULL,
  `PIL_in_qty` int(7) NOT NULL COMMENT 'total qty increase',
  `PIL_out_qty` int(7) NOT NULL COMMENT 'total qty decrease',
  `PIL_order_number` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `PIL_note` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `PIL_created_by` int(11) NOT NULL,
  `PIL_created_date` datetime NOT NULL,
  PRIMARY KEY (`PIL_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PIL=product_inventory_log' AUTO_INCREMENT=143 ;

--
-- Dumping data for table `product_inventory_log`
--

INSERT INTO `product_inventory_log` (`PIL_id`, `PIL_PI_id`, `PIL_date`, `PIL_in_qty`, `PIL_out_qty`, `PIL_order_number`, `PIL_note`, `PIL_created_by`, `PIL_created_date`) VALUES
(1, 1, '2014-02-03', 1, 0, '', 'Inserted initial value ', 3, '2014-02-03 11:15:37'),
(2, 1, '2014-02-03', 5, 0, '', 'new inventory ', 3, '2014-02-03 11:16:14'),
(3, 2, '2014-02-03', 1, 0, '', 'Inserted initial value ', 3, '2014-02-03 12:13:22'),
(4, 3, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 12:16:22'),
(5, 4, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 12:34:25'),
(6, 5, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 14:06:21'),
(7, 6, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 14:13:15'),
(8, 7, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 14:34:48'),
(9, 8, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 14:40:40'),
(10, 9, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 14:48:43'),
(11, 10, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 14:55:43'),
(12, 11, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 15:39:41'),
(13, 12, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 15:51:37'),
(14, 13, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 16:01:04'),
(15, 14, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 16:04:36'),
(16, 15, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 16:09:43'),
(17, 16, '2014-02-03', 300, 0, '', 'Inserted initial value ', 2, '2014-02-03 16:14:25'),
(18, 17, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 16:17:42'),
(19, 18, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 16:20:35'),
(20, 19, '2014-02-03', 300, 0, '', 'Inserted initial value ', 2, '2014-02-03 16:30:09'),
(21, 20, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 16:48:47'),
(22, 21, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 16:55:12'),
(23, 22, '2014-02-03', 300, 0, '', 'Inserted initial value ', 2, '2014-02-03 17:09:12'),
(24, 23, '2014-02-03', 500, 0, '', 'Inserted initial value ', 2, '2014-02-03 17:24:26'),
(25, 24, '2014-02-04', 500, 0, '', 'Inserted initial value ', 2, '2014-02-04 10:29:17'),
(26, 25, '2014-02-04', 300, 0, '', 'Inserted initial value ', 2, '2014-02-04 10:42:58'),
(27, 26, '2014-02-04', 300, 0, '', 'Inserted initial value ', 2, '2014-02-04 10:55:36'),
(28, 27, '2014-02-04', 100, 0, '', 'Inserted initial value ', 3, '2014-02-04 11:01:13'),
(29, 28, '2014-02-04', 300, 0, '', 'Inserted initial value ', 2, '2014-02-04 11:07:29'),
(30, 29, '2014-02-04', 100, 0, '', 'Inserted initial value ', 3, '2014-02-04 11:22:28'),
(31, 30, '2014-02-04', 300, 0, '', 'Inserted initial value ', 2, '2014-02-04 11:31:27'),
(32, 31, '2014-02-04', 300, 0, '', 'Inserted initial value ', 2, '2014-02-04 11:53:03'),
(33, 32, '2014-02-04', 300, 0, '', 'Inserted initial value ', 2, '2014-02-04 12:07:54'),
(34, 33, '2014-02-04', 100, 0, '', 'Inserted initial value ', 3, '2014-02-04 12:12:32'),
(35, 34, '2014-02-04', 300, 0, '', 'Inserted initial value ', 2, '2014-02-04 12:18:07'),
(36, 35, '2014-02-04', 300, 0, '', 'Inserted initial value ', 2, '2014-02-04 13:04:21'),
(37, 36, '2014-02-04', 300, 0, '', 'Inserted initial value ', 2, '2014-02-04 13:09:55'),
(38, 37, '2014-02-04', 500, 0, '', 'Inserted initial value ', 2, '2014-02-04 13:24:06'),
(39, 38, '2014-02-04', 300, 0, '', 'Inserted initial value ', 2, '2014-02-04 13:51:29'),
(40, 39, '2014-02-04', 200, 0, '', 'Inserted initial value ', 2, '2014-02-04 13:53:32'),
(41, 40, '2014-02-04', 200, 0, '', 'Inserted initial value ', 2, '2014-02-04 14:01:47'),
(42, 41, '2014-02-04', 200, 0, '', 'Inserted initial value ', 2, '2014-02-04 14:24:00'),
(43, 42, '2014-02-04', 200, 0, '', 'Inserted initial value ', 2, '2014-02-04 14:37:19'),
(44, 43, '2014-02-04', 500, 0, '', 'Inserted initial value ', 3, '2014-02-04 14:51:05'),
(45, 44, '2014-02-04', 300, 0, '', 'Inserted initial value ', 2, '2014-02-04 15:14:07'),
(46, 45, '2014-02-04', 300, 0, '', 'Inserted initial value ', 2, '2014-02-04 15:43:26'),
(47, 46, '2014-02-04', 200, 0, '', 'Inserted initial value ', 2, '2014-02-04 15:56:50'),
(48, 47, '2014-02-05', 100, 0, '', 'Inserted initial value ', 3, '2014-02-05 12:51:09'),
(49, 48, '2014-02-05', 100, 0, '', 'Inserted initial value ', 3, '2014-02-05 12:59:39'),
(50, 49, '2014-02-06', 200, 0, '', 'Inserted initial value ', 2, '2014-02-06 16:27:49'),
(51, 50, '2014-02-06', 300, 0, '', 'Inserted initial value ', 2, '2014-02-06 16:42:09'),
(52, 51, '2014-02-08', 100, 0, '', 'Inserted initial value ', 3, '2014-02-08 14:18:56'),
(53, 52, '2014-02-08', 100, 0, '', 'Inserted initial value ', 3, '2014-02-08 14:22:38'),
(54, 53, '2014-02-08', 100, 0, '', 'Inserted initial value ', 3, '2014-02-08 14:39:48'),
(55, 54, '2014-02-08', 100, 0, '', 'Inserted initial value ', 3, '2014-02-08 14:58:49'),
(56, 55, '2014-02-08', 100, 0, '', 'Inserted initial value ', 3, '2014-02-08 15:05:56'),
(57, 56, '2014-02-08', 100, 0, '', 'Inserted initial value ', 3, '2014-02-08 15:23:58'),
(58, 57, '2014-02-12', 12, 0, '', 'Inserted initial value ', 1, '2014-02-12 17:22:08'),
(59, 58, '2014-02-13', 40, 0, '', 'Inserted initial value ', 3, '2014-02-13 12:27:32'),
(60, 59, '2014-02-13', 20, 0, '', 'Inserted initial value ', 3, '2014-02-13 12:44:02'),
(61, 60, '2014-02-16', 200, 0, '', 'Inserted initial value ', 2, '2014-02-16 11:02:45'),
(62, 61, '2014-02-16', 200, 0, '', 'Inserted initial value ', 2, '2014-02-16 11:06:00'),
(63, 62, '2014-02-16', 200, 0, '', 'Inserted initial value ', 2, '2014-02-16 11:15:14'),
(64, 63, '2014-02-16', 200, 0, '', 'Inserted initial value ', 2, '2014-02-16 12:37:36'),
(65, 64, '2014-02-16', 200, 0, '', 'Inserted initial value ', 2, '2014-02-16 12:39:10'),
(66, 65, '2014-02-16', 150, 0, '', 'Inserted initial value ', 2, '2014-02-16 12:46:42'),
(67, 66, '2014-02-16', 200, 0, '', 'Inserted initial value ', 2, '2014-02-16 12:55:28'),
(68, 67, '2014-02-16', 150, 0, '', 'Inserted initial value ', 2, '2014-02-16 12:58:47'),
(69, 68, '2014-02-16', 300, 0, '', 'Inserted initial value ', 2, '2014-02-16 13:46:06'),
(70, 69, '2014-02-16', 200, 0, '', 'Inserted initial value ', 2, '2014-02-16 13:48:38'),
(71, 70, '2014-02-16', 150, 0, '', 'Inserted initial value ', 2, '2014-02-16 13:52:55'),
(72, 71, '2014-02-16', 300, 0, '', 'Inserted initial value ', 2, '2014-02-16 14:07:06'),
(73, 72, '2014-02-16', 200, 0, '', 'Inserted initial value ', 2, '2014-02-16 14:08:48'),
(74, 73, '2014-02-16', 200, 0, '', 'Inserted initial value ', 2, '2014-02-16 14:27:25'),
(75, 74, '2014-02-16', 100, 0, '', 'Inserted initial value ', 3, '2014-02-16 14:29:26'),
(76, 75, '2014-02-16', 300, 0, '', 'Inserted initial value ', 2, '2014-02-16 14:38:32'),
(77, 76, '2014-02-16', 300, 0, '', 'Inserted initial value ', 2, '2014-02-16 14:41:40'),
(78, 77, '2014-02-16', 500, 0, '', 'Inserted initial value ', 2, '2014-02-16 14:43:25'),
(79, 78, '2014-02-16', 50, 0, '', 'Inserted initial value ', 3, '2014-02-16 14:48:31'),
(80, 79, '2014-02-16', 200, 0, '', 'Inserted initial value ', 2, '2014-02-16 15:22:09'),
(81, 80, '2014-02-16', 300, 0, '', 'Inserted initial value ', 2, '2014-02-16 15:22:59'),
(82, 81, '2014-02-16', 300, 0, '', 'Inserted initial value ', 2, '2014-02-16 15:25:33'),
(83, 82, '2014-02-16', 500, 0, '', 'Inserted initial value ', 2, '2014-02-16 15:32:35'),
(84, 83, '2014-02-16', 150, 0, '', 'Inserted initial value ', 2, '2014-02-16 15:42:43'),
(85, 84, '2014-02-16', 150, 0, '', 'Inserted initial value ', 2, '2014-02-16 15:58:42'),
(86, 85, '2014-02-16', 6, 0, '', 'Inserted initial value ', 1, '2014-02-16 16:06:14'),
(87, 86, '2014-02-16', 15, 0, '', 'Inserted initial value ', 1, '2014-02-16 16:09:04'),
(88, 87, '2014-02-16', 300, 0, '', 'Inserted initial value ', 2, '2014-02-16 16:26:12'),
(89, 88, '2014-02-16', 300, 0, '', 'Inserted initial value ', 2, '2014-02-16 16:29:23'),
(90, 89, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 12:01:48'),
(91, 90, '2014-02-17', 150, 0, '', 'Inserted initial value ', 2, '2014-02-17 12:10:34'),
(92, 91, '2014-02-17', 100, 0, '', 'Inserted initial value ', 3, '2014-02-17 12:11:10'),
(93, 92, '2014-02-17', 200, 0, '', 'Inserted initial value ', 2, '2014-02-17 12:15:20'),
(94, 93, '2014-02-17', 150, 0, '', 'Inserted initial value ', 2, '2014-02-17 12:16:59'),
(95, 94, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 12:25:42'),
(96, 95, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 12:29:44'),
(97, 96, '2014-02-17', 150, 0, '', 'Inserted initial value ', 2, '2014-02-17 12:32:51'),
(98, 97, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 12:36:53'),
(99, 98, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 12:43:14'),
(100, 99, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 12:52:26'),
(101, 100, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 13:02:25'),
(102, 101, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 13:05:32'),
(103, 102, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 13:08:53'),
(104, 103, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 13:14:14'),
(105, 104, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 13:14:32'),
(106, 105, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 14:33:26'),
(107, 106, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 14:38:08'),
(108, 107, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 14:42:12'),
(109, 108, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 14:42:46'),
(110, 109, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 14:46:20'),
(111, 110, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 14:48:34'),
(112, 111, '2014-02-17', 50, 0, '', 'Inserted initial value ', 3, '2014-02-17 15:11:19'),
(113, 112, '2014-02-17', 100, 0, '', 'Inserted initial value ', 3, '2014-02-17 15:15:19'),
(114, 113, '2014-02-17', 150, 0, '', 'Inserted initial value ', 2, '2014-02-17 17:23:24'),
(115, 114, '2014-02-17', 200, 0, '', 'Inserted initial value ', 2, '2014-02-17 17:34:52'),
(116, 115, '2014-02-17', 150, 0, '', 'Inserted initial value ', 2, '2014-02-17 17:41:43'),
(117, 116, '2014-02-17', 150, 0, '', 'Inserted initial value ', 2, '2014-02-17 17:48:39'),
(118, 117, '2014-02-18', 150, 0, '', 'Inserted initial value ', 2, '2014-02-18 11:00:30'),
(119, 118, '2014-02-18', 150, 0, '', 'Inserted initial value ', 2, '2014-02-18 11:10:32'),
(120, 119, '2014-02-18', 50, 0, '', 'Inserted initial value ', 3, '2014-02-18 12:41:21'),
(121, 120, '2014-02-18', 50, 0, '', 'Inserted initial value ', 3, '2014-02-18 12:42:22'),
(122, 121, '2014-02-18', 50, 0, '', 'Inserted initial value ', 3, '2014-02-18 12:42:39'),
(123, 122, '2014-02-18', 500, 0, '', 'Inserted initial value ', 2, '2014-02-18 13:02:53'),
(124, 123, '2014-02-18', 50, 0, '', 'Inserted initial value ', 3, '2014-02-18 13:10:10'),
(125, 124, '2014-02-18', 50, 0, '', 'Inserted initial value ', 3, '2014-02-18 13:12:37'),
(126, 125, '2014-02-18', 50, 0, '', 'Inserted initial value ', 3, '2014-02-18 13:23:59'),
(127, 126, '2014-02-18', 150, 0, '', 'Inserted initial value ', 2, '2014-02-18 14:10:40'),
(128, 127, '2014-02-18', 300, 0, '', 'Inserted initial value ', 2, '2014-02-18 14:14:06'),
(129, 128, '2014-02-18', 500, 0, '', 'Inserted initial value ', 2, '2014-02-18 14:18:15'),
(130, 129, '2014-02-18', 50, 0, '', 'Inserted initial value ', 3, '2014-02-18 15:10:54'),
(131, 130, '2014-02-18', 50, 0, '', 'Inserted initial value ', 3, '2014-02-18 15:15:46'),
(132, 131, '2014-02-18', 200, 0, '', 'Inserted initial value ', 2, '2014-02-18 15:40:11'),
(133, 132, '2014-02-18', 500, 0, '', 'Inserted initial value ', 2, '2014-02-18 15:50:52'),
(134, 133, '2014-02-18', 300, 0, '', 'Inserted initial value ', 2, '2014-02-18 16:06:23'),
(135, 134, '2014-02-19', 200, 0, '', 'Inserted initial value ', 2, '2014-02-19 10:38:16'),
(136, 135, '2014-02-19', 200, 0, '', 'Inserted initial value ', 2, '2014-02-19 10:39:26'),
(137, 136, '2014-02-19', 200, 0, '', 'Inserted initial value ', 2, '2014-02-19 10:41:30'),
(138, 137, '2014-02-19', 150, 0, '', 'Inserted initial value ', 2, '2014-02-19 10:42:09'),
(139, 138, '2014-02-19', 200, 0, '', 'Inserted initial value ', 2, '2014-02-19 12:58:12'),
(140, 139, '2014-02-19', 100, 0, '', 'Inserted initial value ', 3, '2014-02-19 13:26:38'),
(141, 140, '2014-02-19', 100, 0, '', 'Inserted initial value ', 3, '2014-02-19 13:26:46'),
(142, 141, '2014-02-19', 100, 0, '', 'Inserted initial value ', 3, '2014-02-19 13:27:07');

-- --------------------------------------------------------

--
-- Table structure for table `product_rating`
--

CREATE TABLE IF NOT EXISTS `product_rating` (
  `PR_id` int(5) NOT NULL AUTO_INCREMENT,
  `PR_product_id` int(5) NOT NULL,
  `PR_user_id` int(11) NOT NULL,
  `PR_rating_amount` int(5) NOT NULL,
  PRIMARY KEY (`PR_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_review`
--

CREATE TABLE IF NOT EXISTS `product_review` (
  `PRE_id` int(11) NOT NULL AUTO_INCREMENT,
  `PRE_product_id` int(11) NOT NULL,
  `PRE_user_id` int(5) NOT NULL,
  `PRE_comment` varchar(500) NOT NULL,
  `PRE_status` enum('draft','publish') NOT NULL,
  `PRE_read` enum('yes','no') NOT NULL,
  PRIMARY KEY (`PRE_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE IF NOT EXISTS `product_sizes` (
  `PS_id` int(11) NOT NULL AUTO_INCREMENT,
  `PS_size_id` int(11) NOT NULL,
  `PS_size_title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `PS_product_id` int(11) NOT NULL,
  `PS_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PS_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='product_sizes (specific sizes which show frontend)' AUTO_INCREMENT=133 ;

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`PS_id`, `PS_size_id`, `PS_size_title`, `PS_product_id`, `PS_created`) VALUES
(1, 4, '1pice', 1, '2014-02-03 05:14:13'),
(2, 9, '4 pice', 1, '2014-02-03 05:14:23'),
(3, 8, '1 dozen', 1, '2014-02-03 05:14:29'),
(4, 3, '1kg', 1, '2014-02-03 05:14:35'),
(7, 4, '1pice', 3, '2014-02-03 06:12:56'),
(8, 11, '200ml', 2, '2014-02-03 06:14:10'),
(9, 11, '200ml', 4, '2014-02-03 06:31:33'),
(10, 11, '200ml', 5, '2014-02-03 07:02:50'),
(11, 12, '125gm', 6, '2014-02-03 08:05:41'),
(12, 11, '200ml', 7, '2014-02-03 08:11:46'),
(13, 13, '250ml', 8, '2014-02-03 08:34:10'),
(14, 14, '1ltr', 9, '2014-02-03 08:39:59'),
(15, 13, '250ml', 10, '2014-02-03 08:46:38'),
(16, 14, '1ltr', 11, '2014-02-03 08:55:25'),
(17, 14, '1ltr', 12, '2014-02-03 09:37:06'),
(18, 14, '1ltr', 13, '2014-02-03 09:39:18'),
(19, 14, '1ltr', 14, '2014-02-03 09:51:13'),
(20, 14, '1ltr', 15, '2014-02-03 10:00:51'),
(21, 11, '200ml', 16, '2014-02-03 10:04:17'),
(22, 15, '125ml', 17, '2014-02-03 10:09:17'),
(23, 15, '125ml', 18, '2014-02-03 10:14:02'),
(24, 15, '125ml', 19, '2014-02-03 10:17:23'),
(25, 15, '125ml', 20, '2014-02-03 10:20:02'),
(26, 15, '125ml', 21, '2014-02-03 10:29:45'),
(27, 11, '200ml', 22, '2014-02-03 10:48:06'),
(28, 13, '250ml', 23, '2014-02-03 10:54:31'),
(29, 13, '250ml', 24, '2014-02-03 11:03:30'),
(30, 16, '500ml', 25, '2014-02-03 11:14:10'),
(31, 14, '1ltr', 26, '2014-02-04 04:27:19'),
(32, 13, '250ml', 27, '2014-02-04 04:42:34'),
(33, 13, '250ml', 28, '2014-02-04 04:55:09'),
(34, 4, '1pice', 29, '2014-02-04 04:59:38'),
(35, 13, '250ml', 30, '2014-02-04 05:06:54'),
(36, 7, '1 packet', 31, '2014-02-04 05:21:55'),
(37, 13, '250ml', 32, '2014-02-04 05:31:02'),
(38, 13, '250ml', 33, '2014-02-04 05:52:25'),
(39, 13, '250ml', 34, '2014-02-04 06:02:23'),
(40, 13, '250ml', 35, '2014-02-04 06:07:35'),
(41, 13, '250ml', 34, '2014-02-04 06:10:18'),
(42, 7, '1 packet', 36, '2014-02-04 06:12:05'),
(43, 13, '250ml', 37, '2014-02-04 06:17:06'),
(44, 13, '250ml', 34, '2014-02-04 06:28:42'),
(45, 7, '1 packet', 38, '2014-02-04 06:34:06'),
(46, 13, '250ml', 39, '2014-02-04 06:56:03'),
(47, 13, '250ml', 40, '2014-02-04 07:08:35'),
(48, 13, '250ml', 41, '2014-02-04 07:22:07'),
(49, 13, '250ml', 42, '2014-02-04 07:53:04'),
(50, 13, '250ml', 43, '2014-02-04 08:01:28'),
(51, 13, '250ml', 44, '2014-02-04 08:23:28'),
(52, 13, '250ml', 45, '2014-02-04 08:36:22'),
(53, 4, '1pice', 46, '2014-02-04 08:50:53'),
(54, 13, '250ml', 46, '2014-02-04 09:09:04'),
(55, 13, '250ml', 47, '2014-02-04 09:11:08'),
(56, 14, '1ltr', 48, '2014-02-04 09:43:07'),
(57, 14, '1ltr', 49, '2014-02-04 09:56:21'),
(58, 7, '1 packet', 50, '2014-02-05 06:50:45'),
(59, 20, '1 Tin', 51, '2014-02-05 06:58:32'),
(60, 13, '250ml', 52, '2014-02-06 10:27:22'),
(61, 21, '1.5ltr', 53, '2014-02-06 10:41:35'),
(62, 4, '1pice', 55, '2014-02-08 08:18:24'),
(63, 4, '1pice', 56, '2014-02-08 08:22:15'),
(64, 4, '1pice', 57, '2014-02-08 08:39:10'),
(65, 7, '1 packet', 58, '2014-02-08 08:58:21'),
(66, 7, '1 packet', 59, '2014-02-08 09:02:32'),
(67, 7, '1 packet', 60, '2014-02-08 09:05:38'),
(68, 7, '1 packet', 61, '2014-02-08 09:23:28'),
(69, 7, '1 packet', 62, '2014-02-08 09:36:23'),
(71, 1, '100gm', 54, '2014-02-13 06:25:12'),
(72, 2, '500gm', 54, '2014-02-13 06:25:14'),
(73, 11, '200ml', 54, '2014-02-13 06:25:14'),
(74, 12, '125gm', 54, '2014-02-13 06:25:14'),
(75, 13, '250ml', 54, '2014-02-13 06:25:14'),
(76, 15, '125ml', 54, '2014-02-13 06:25:14'),
(77, 16, '500ml', 54, '2014-02-13 06:25:14'),
(78, 17, '1000ml', 54, '2014-02-13 06:25:14'),
(79, 18, '50gm', 54, '2014-02-13 06:25:14'),
(80, 16, '500ml', 9, '2014-02-16 04:36:44'),
(82, 15, '125ml', 2, '2014-02-16 06:57:43'),
(83, 14, '1ltr', 64, '2014-02-16 07:45:43'),
(84, 22, '285 gm', 65, '2014-02-16 08:28:29'),
(85, 23, '320 gm', 66, '2014-02-16 08:47:58'),
(86, 15, '125ml', 6, '2014-02-16 09:48:58'),
(87, 14, '1ltr', 67, '2014-02-16 09:58:23'),
(88, 14, '1ltr', 68, '2014-02-16 10:25:43'),
(89, 14, '1ltr', 69, '2014-02-16 10:28:52'),
(90, 24, '350 gm', 70, '2014-02-17 06:01:18'),
(91, 25, '250 gm', 71, '2014-02-17 06:06:50'),
(92, 11, '200ml', 6, '2014-02-17 06:09:39'),
(93, 14, '1ltr', 6, '2014-02-17 06:09:58'),
(94, 13, '250ml', 6, '2014-02-17 06:14:44'),
(95, 26, '130 gm', 72, '2014-02-17 06:25:16'),
(96, 27, '220 gm', 73, '2014-02-17 06:29:21'),
(97, 28, '108 gm', 74, '2014-02-17 06:36:12'),
(98, 29, '115 gm', 75, '2014-02-17 06:42:42'),
(99, 30, '80 gm', 76, '2014-02-17 06:51:40'),
(100, 32, '190 gm', 77, '2014-02-17 07:02:06'),
(101, 33, '145 gm', 78, '2014-02-17 07:04:56'),
(102, 34, '125 gm', 79, '2014-02-17 07:08:33'),
(103, 35, '58 gm', 79, '2014-02-17 07:12:55'),
(104, 1, '100gm', 79, '2014-02-17 07:12:59'),
(105, 36, '200 gm', 80, '2014-02-17 08:32:52'),
(106, 36, '200 gm', 81, '2014-02-17 08:37:48'),
(107, 37, 'Big Size', 82, '2014-02-17 08:41:33'),
(108, 38, '450 gm', 83, '2014-02-17 08:45:57'),
(109, 39, '400 gm', 84, '2014-02-17 08:48:10'),
(110, 38, '450 gm', 85, '2014-02-17 09:10:55'),
(111, 40, '14 gm', 86, '2014-02-17 09:14:51'),
(112, 18, '50gm', 87, '2014-02-17 11:22:23'),
(113, 21, '1.5ltr', 88, '2014-02-17 11:34:23'),
(114, 41, '2 ltr', 89, '2014-02-17 11:41:01'),
(115, 16, '500ml', 90, '2014-02-17 11:48:09'),
(116, 42, '25gm', 91, '2014-02-18 04:59:59'),
(117, 14, '1ltr', 92, '2014-02-18 05:08:59'),
(118, 21, '1.5ltr', 89, '2014-02-18 06:30:52'),
(119, 43, '1.25ltr', 89, '2014-02-18 06:32:55'),
(120, 16, '500ml', 88, '2014-02-18 06:35:37'),
(121, 44, '2.5 ltr.', 88, '2014-02-18 06:37:36'),
(122, 45, '4.5 ltr', 88, '2014-02-18 06:37:36'),
(123, 46, '750 ml', 93, '2014-02-18 07:09:43'),
(124, 47, '330 ml', 93, '2014-02-18 07:11:56'),
(125, 16, '500ml', 95, '2014-02-18 07:22:59'),
(127, 36, '200 gm', 96, '2014-02-18 09:10:30'),
(128, 1, '100gm', 81, '2014-02-18 09:15:26'),
(129, 18, '50gm', 97, '2014-02-18 09:39:38'),
(130, 18, '50gm', 98, '2014-02-18 09:50:23'),
(131, 18, '50gm', 99, '2014-02-18 10:05:01'),
(132, 48, '600gm', 100, '2014-02-19 06:52:13');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE IF NOT EXISTS `promotions` (
  `promotion_id` int(11) NOT NULL AUTO_INCREMENT,
  `promotion_title` varchar(1200) COLLATE utf8_unicode_ci NOT NULL,
  `promotion_description` text COLLATE utf8_unicode_ci NOT NULL,
  `promotion_image` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `promotion_code_prefix` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `promotion_code_single_suffix` int(1) NOT NULL COMMENT 'same code can use multiple user ',
  `promotion_code_predefined_user` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no' COMMENT 'admin can enter user email on every code ',
  `promotion_discount_type` enum('percentage','fix') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'percentage' COMMENT 'check discount range table ',
  `promotion_expire` date NOT NULL,
  `promotion_status` enum('active','inactive','archive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`promotion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `promotion_codes`
--

CREATE TABLE IF NOT EXISTS `promotion_codes` (
  `PC_id` int(11) NOT NULL AUTO_INCREMENT,
  `PC_promotion_id` int(11) NOT NULL,
  `PC_code_prefix` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `PC_code_suffix` int(10) NOT NULL,
  `PC_code_used_email` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT 'which user will use the code or used the code ',
  `PC_code_used_order_number` int(11) NOT NULL COMMENT 'if the code already used what is the order number? ',
  `PC_code_discount_gain` decimal(10,2) NOT NULL,
  `PC_code_status` enum('active','inactive','applied','used','archive') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`PC_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PC = promotion_codes' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `promotion_discount_range`
--

CREATE TABLE IF NOT EXISTS `promotion_discount_range` (
  `PDR_id` int(11) NOT NULL AUTO_INCREMENT,
  `PDR_promotion_id` int(11) NOT NULL,
  `PDR_discount_type` enum('percentage','fix') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'percentage',
  `PDR_discount_min_range` int(10) NOT NULL COMMENT 'example: 200 - 300, 400-500',
  `PDR_discount_max_range` int(10) NOT NULL COMMENT 'example: 200 - 300, 400-500',
  `PDR_discount_quantity` int(11) NOT NULL,
  `PDR_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`PDR_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PDR= promotion_discount_range' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE IF NOT EXISTS `sizes` (
  `size_id` int(5) NOT NULL AUTO_INCREMENT,
  `size_title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `size_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `size_updated_by` int(5) NOT NULL,
  PRIMARY KEY (`size_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=49 ;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`size_id`, `size_title`, `size_updated`, `size_updated_by`) VALUES
(1, '100gm', '2014-02-03 05:04:49', 3),
(2, '500gm', '2014-02-03 05:05:01', 3),
(3, '1kg', '2014-02-03 05:05:10', 3),
(4, '1piece', '2014-02-03 05:05:23', 2),
(5, '250gm', '2014-02-03 05:05:32', 3),
(6, '5kg', '2014-02-03 05:05:43', 3),
(7, '1 packet', '2014-02-03 05:05:59', 3),
(8, '1 dozen', '2014-02-03 05:06:57', 3),
(9, '4 piece', '2014-02-03 05:07:11', 2),
(10, '70 gm', '2014-02-03 06:11:47', 3),
(11, '200ml', '2014-02-03 06:13:55', 2),
(12, '125gm', '2014-02-03 08:05:27', 2),
(13, '250ml', '2014-02-03 08:33:58', 2),
(14, '1ltr', '2014-02-03 08:39:45', 2),
(15, '125ml', '2014-02-03 10:09:03', 2),
(16, '500ml', '2014-02-03 11:13:58', 2),
(17, '1000ml', '2014-02-04 05:33:36', 2),
(18, '50gm', '2014-02-04 05:33:55', 2),
(19, 'a', '2014-02-04 08:44:58', 2),
(20, '1 Tin', '2014-02-05 06:58:14', 3),
(21, '1.5ltr', '2014-02-06 10:41:24', 2),
(22, '285 gm', '2014-02-16 08:27:53', 3),
(23, '320 gm', '2014-02-16 08:47:43', 3),
(24, '350 gm', '2014-02-17 06:01:09', 3),
(25, '250 gm', '2014-02-17 06:06:40', 3),
(26, '130 gm', '2014-02-17 06:24:57', 3),
(27, '220 gm', '2014-02-17 06:29:12', 3),
(28, '108 gm', '2014-02-17 06:35:58', 3),
(29, '115 gm', '2014-02-17 06:42:31', 3),
(30, '80 gm', '2014-02-17 06:51:33', 3),
(31, '135 gm', '2014-02-17 07:01:44', 3),
(32, '190 gm', '2014-02-17 07:01:54', 3),
(33, '145 gm', '2014-02-17 07:04:48', 3),
(34, '125 gm', '2014-02-17 07:08:22', 3),
(35, '58 gm', '2014-02-17 07:12:45', 3),
(36, '200 gm', '2014-02-17 08:32:43', 3),
(37, 'Big Size', '2014-02-17 08:41:10', 3),
(38, '450 gm', '2014-02-17 08:45:49', 3),
(39, '400 gm', '2014-02-17 08:48:02', 3),
(40, '14 gm', '2014-02-17 09:14:44', 3),
(41, '2 ltr', '2014-02-17 11:40:09', 2),
(42, '25gm', '2014-02-18 04:59:31', 2),
(43, '1.25ltr', '2014-02-18 06:32:29', 2),
(44, '2.5 ltr.', '2014-02-18 06:36:20', 3),
(45, '4.5 ltr', '2014-02-18 06:36:59', 3),
(46, '750 ml', '2014-02-18 07:09:36', 3),
(47, '330 ml', '2014-02-18 07:11:22', 3),
(48, '600gm', '2014-02-19 06:46:55', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `tag_id` int(5) NOT NULL AUTO_INCREMENT,
  `tag_title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `tag_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tag_updated_by` int(5) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_title`, `tag_updated`, `tag_updated_by`) VALUES
(1, 'food', '2014-02-03 05:03:59', 3),
(2, 'sweet', '2014-02-03 05:04:08', 3),
(3, 'icecream', '2014-02-03 05:04:19', 3),
(4, 'Fruit ', '2014-02-03 06:19:37', 2),
(5, 'juice', '2014-02-03 06:19:40', 2),
(6, 'mango', '2014-02-04 04:44:36', 2),
(7, 'orange', '2014-02-04 04:44:50', 2),
(8, 'lemon', '2014-02-04 04:57:09', 2),
(9, 'guava ', '2014-02-04 05:36:00', 2),
(10, 'apple', '2014-02-04 06:10:13', 2),
(11, 'banana', '2014-02-04 07:24:52', 2),
(12, 'pineapple ', '2014-02-04 08:24:36', 2),
(13, 'aaa', '2014-02-04 08:45:27', 2),
(14, 'grapefruit ', '2014-02-06 10:43:10', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tax_classes`
--

CREATE TABLE IF NOT EXISTS `tax_classes` (
  `TC_id` int(5) NOT NULL AUTO_INCREMENT,
  `TC_title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `TC_percent` decimal(10,0) NOT NULL,
  `TC_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TC_updated_by` int(5) NOT NULL,
  PRIMARY KEY (`TC_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='TC = tax_classes' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tax_classes`
--

INSERT INTO `tax_classes` (`TC_id`, `TC_title`, `TC_percent`, `TC_updated`, `TC_updated_by`) VALUES
(1, 'none', 0, '2013-04-30 08:31:43', 3),
(2, '15%', 15, '2013-04-30 08:37:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `temp_carts`
--

CREATE TABLE IF NOT EXISTS `temp_carts` (
  `TC_id` int(5) NOT NULL AUTO_INCREMENT,
  `TC_session_id` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `TC_user_id` int(11) NOT NULL,
  `TC_product_id` int(5) NOT NULL,
  `TC_product_inventory_id` int(5) NOT NULL,
  `TC_unit_price` decimal(10,0) NOT NULL,
  `TC_per_unit_discount` decimal(10,0) NOT NULL,
  `TC_discount_amount` decimal(10,0) NOT NULL,
  `TC_product_quantity` int(5) NOT NULL,
  `TC_product_total_price` decimal(10,0) NOT NULL COMMENT 'total price = quantity * price',
  `TC_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`TC_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='empty regularly using cron, TC= temp_carts' AUTO_INCREMENT=32 ;

--
-- Dumping data for table `temp_carts`
--

INSERT INTO `temp_carts` (`TC_id`, `TC_session_id`, `TC_user_id`, `TC_product_id`, `TC_product_inventory_id`, `TC_unit_price`, `TC_per_unit_discount`, `TC_discount_amount`, `TC_product_quantity`, `TC_product_total_price`, `TC_created`) VALUES
(1, '863aaea604c023c4821e7a88bf26d4ac', 12, 45, 42, 40, 0, 0, 1, 40, '2014-02-19 07:41:43'),
(13, '21q4vrautb9mmd08p37t7tged0', 12, 5, 83, 25, 0, 10, 2, 50, '2014-02-19 08:02:50'),
(19, '6cga015nu0frlat0p9m44qkbn7', 0, 2, 80, 25, 0, 0, 1, 25, '2014-02-20 09:22:38'),
(22, '6cga015nu0frlat0p9m44qkbn7', 0, 6, 134, 20, 0, 0, 1, 20, '2014-02-20 09:55:39'),
(23, '6cga015nu0frlat0p9m44qkbn7', 0, 8, 0, 25, 0, 0, 1, 25, '2014-02-20 09:55:40'),
(24, '6cga015nu0frlat0p9m44qkbn7', 0, 9, 8, 100, 0, 0, 1, 100, '2014-02-20 09:55:41'),
(31, '5l119qc4oqe54upnev1ljh88e0', 12, 31, 29, 209, 0, 0, 2, 418, '2014-02-25 07:42:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `google_user_id` int(100) NOT NULL,
  `user_hash` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `user_verification` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `user_first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_middle_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_DOB` date NOT NULL COMMENT 'date of birth',
  `user_gender` enum('Male','Female','Not defined') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Not defined',
  `user_aboutme` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `user_street_address` text COLLATE utf8_unicode_ci NOT NULL,
  `user_country` int(11) NOT NULL,
  `user_city` int(11) NOT NULL,
  `user_zip` int(10) NOT NULL,
  `user_delivery_address` text COLLATE utf8_unicode_ci NOT NULL,
  `user_phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_name`, `user_password`, `google_user_id`, `user_hash`, `user_status`, `user_verification`, `user_first_name`, `user_middle_name`, `user_last_name`, `user_DOB`, `user_gender`, `user_aboutme`, `user_street_address`, `user_country`, `user_city`, `user_zip`, `user_delivery_address`, `user_phone`, `user_last_login`) VALUES
(1, 'william@bscheme.com', 'william', 'e10adc3949ba59abb#b1a2j1r1e2*e56e057f20f883e', 0, 'acccs6btbcgk4nc3lvegp27ud0', 'active', 'yes', '', '', '', '0000-00-00', 'Not defined', '', '', 0, 0, 0, '', '', '2014-02-12 07:52:41'),
(10, 'faruk@bscheme.com', 'farukbsa', 'e10adc3949ba59abb#b1a2j1r1e2*e56e057f20f883e', 0, 'be4a378e0edcdde9d187f28d65e09219', 'active', 'yes', '', '', '', '0000-00-00', 'Not defined', '', '', 0, 0, 0, '', '', '2014-02-13 10:57:33'),
(11, 'tanim@bscheme.com', '123456', '85c53abb232311d5d#b1a2j1r1e2*28b0ea218a60232', 0, 'be4a378e0edcdde9d187f28d65e09219', 'active', 'no', '', '', '', '0000-00-00', 'Not defined', '', '', 0, 0, 0, '', '', '2014-02-13 11:14:38'),
(12, 'mijo.jfwg@gmail.com', 'admin1', 'e10adc3949ba59abb#b1a2j1r1e2*e56e057f20f883e', 0, 'adef7b40fcd94773ea5807d2b03e0c45', 'active', 'yes', '', '', '', '0000-00-00', 'Not defined', '', '', 0, 0, 0, '', '', '2014-02-13 11:25:02');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE IF NOT EXISTS `user_addresses` (
  `UA_id` int(5) NOT NULL AUTO_INCREMENT,
  `UA_user_id` int(11) NOT NULL,
  `UA_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `UA_first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `UA_middle_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `UA_last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `UA_phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `UA_best_call_time` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `UA_country_id` int(5) NOT NULL,
  `UA_city_id` int(5) NOT NULL,
  `UA_area_id` int(11) NOT NULL,
  `UA_zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `UA_address` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `UA_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`UA_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='UA= user_addresses' AUTO_INCREMENT=13 ;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`UA_id`, `UA_user_id`, `UA_title`, `UA_first_name`, `UA_middle_name`, `UA_last_name`, `UA_phone`, `UA_best_call_time`, `UA_country_id`, `UA_city_id`, `UA_area_id`, `UA_zip`, `UA_address`, `UA_updated`) VALUES
(1, 0, 'asdadasdad', 'asdadasd', 'asdasd', 'asdasd', 'asdad', '', 1, 1, 1, 'asdad', 'asdasd', '0000-00-00 00:00:00'),
(2, 12, 'asdadasdad', 'asdadasd', 'asdasd', 'asdasd', 'asdad', '', 1, 1, 1, 'asdad', 'asdasd', '2014-02-23 07:35:38'),
(3, 12, 'asdasd', 'asdasdasd', 'asdasd', 'asdasdasd', 'asdasdad', '', 1, 1, 1, 'asdadasd', 'asdadad', '2014-02-23 08:08:00'),
(12, 12, 'My Address', 'William', '', 'Gomes', '01914272921', '', 1, 1, 1, '1215', 'asdsdfsfsdfsdf', '2014-02-23 09:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE IF NOT EXISTS `wishlists` (
  `WL_id` int(5) NOT NULL AUTO_INCREMENT,
  `WL_product_id` int(5) NOT NULL,
  `WL_inventory_id` int(11) NOT NULL,
  `WL_user_id` int(11) NOT NULL,
  `WL_cteated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`WL_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='WL= wishlists ' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`WL_id`, `WL_product_id`, `WL_inventory_id`, `WL_user_id`, `WL_cteated`) VALUES
(1, 31, 29, 12, '2014-02-25 05:05:02'),
(2, 5, 83, 12, '2014-02-25 05:05:06');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
