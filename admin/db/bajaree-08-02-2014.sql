-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 08, 2014 at 08:08 AM
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
(1, 'Faruk', 'faruk@bscheme.com', 'e10adc3949ba59abb#b1a2j1r1e2*e56e057f20f883e', '2uv8lcfobts0g61u3h2jt26te6', 'master', 'active', '2014-02-08 04:19:42', '2013-04-27 16:10:46', 0),
(2, 'Rashed', 'rashed@bscheme.com', 'd355613d1ed436902#b1a2j1r1e2*c3ebb0590ea833b', '05e6dcba00169e52ca8b08fb8839c583', 'super', 'active', '2014-02-04 04:18:30', '2014-02-03 10:54:08', 0),
(3, 'Mukesh ', 'mukesh@bscheme.com', 'fe9642294f8e3bdac#b1a2j1r1e2*f9de8d8caff83ad', 'bc8b7546d4b72d9f742495acbd4e68fb', 'super', 'active', '2014-02-04 06:08:41', '2014-02-03 10:54:53', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=46 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_description`, `category_parent_id`, `category_priority`, `category_logo`, `category_updated`, `category_updated_by`, `category_type`, `category_level`) VALUES
(1, 'Brands', 'this is Brands', 0, 1, 'Brands-1373182145.', '2013-07-07 07:29:05', 1, 'builtin', 0),
(2, 'Products', 'this is Brands', 0, 1, 'Categories-1373182178.', '2013-07-07 07:29:38', 1, 'builtin', 0),
(25, 'Food', 'Food', 2, 1, 'Food-2.jpg', '2014-02-02 06:31:59', 1, 'builtin', 1),
(26, 'Beverages', 'Beverages', 2, 3, 'Beverages-2.jpg', '2014-02-02 06:33:58', 1, 'builtin', 1),
(27, 'Water', 'Water', 26, 3, 'Water-26.jpg', '2014-02-02 06:35:12', 1, 'builtin', 2),
(28, 'Coffee', 'Coffee', 26, 3, 'Cofee-26.jpg', '2014-02-02 06:35:39', 1, 'builtin', 2),
(29, 'Health & Beauty ', ' Health & Beauty ', 2, 20, 'Health & Beauty -2.jpg', '2014-02-02 06:37:10', 1, 'builtin', 1),
(30, 'Household ', 'Household ', 2, 20, 'Household -2.jpg', '2014-02-02 06:37:51', 1, 'builtin', 1),
(31, ' Organic ', ' Organic ', 2, 20, ' Organic -2.jpg', '2014-02-02 06:38:40', 1, 'builtin', 1),
(32, '  Baby ', '  Baby ', 2, 20, '  Baby -2.jpg', '2014-02-02 06:39:10', 1, 'builtin', 1),
(33, '   Pet Care ', '   Pet Care ', 2, 20, '   Pet Care -2.jpg', '2014-02-02 06:39:42', 1, 'builtin', 1),
(34, 'Fresh Food ', 'Fresh Food ', 25, 20, 'Fresh Food -25.jpg', '2014-02-02 06:43:45', 1, 'user_created', 2),
(35, 'Vegetable', 'Vegetable', 34, 20, 'Vegetable-34.jpg', '2014-02-02 06:45:22', 2, 'user_created', 3),
(36, 'Fruits', 'Fruits', 34, 20, 'Fruits-34.jpg', '2014-02-02 06:46:27', 2, 'user_created', 3),
(37, 'Frozen Food ', 'Frozen Food ', 25, 20, 'Frozen Food -25.jpg', '2014-02-02 06:47:05', 1, 'user_created', 2),
(38, 'Dips ', 'Dips ', 25, 20, 'Dips -25.jpg', '2014-02-02 06:47:30', 1, 'user_created', 2),
(39, 'Rice, Noodles & Past', 'Rice, Noodles & Pasta', 25, 20, 'Rice, Noodles & Past-25.jpg', '2014-02-02 06:47:58', 2, 'user_created', 2),
(40, 'Oil, Sauces & Spices', 'Oil, Sauces & Spices', 25, 20, 'Oil, Sauces & Spices-25.jpg', '2014-02-02 06:48:42', 1, 'user_created', 2),
(41, 'Baking ', 'Baking ', 25, 20, 'Baking -25.jpg', '2014-02-02 06:49:09', 1, 'user_created', 2),
(42, 'Bread', 'Bread', 41, 20, 'Bread-41.jpg', '2014-02-02 06:49:39', 1, 'user_created', 3),
(43, 'Cake', 'Cake', 41, 20, 'Cake-41.jpg', '2014-02-02 06:50:10', 1, 'user_created', 3),
(44, 'Juice', 'Juice', 26, 15, 'Juice-26.jpg', '2014-02-03 06:09:09', 2, 'user_created', 2),
(45, 'Biscuits', 'Biscuits', 26, 16, 'Biscuits-26.jpg', '2014-02-03 06:10:27', 2, 'user_created', 2);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='category_banners = CB' AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `category_featured`
--

INSERT INTO `category_featured` (`CF_id`, `CF_category_id`, `CF_featured_from`, `CF_featured_to`, `CF_updated`, `CF_updated_by`) VALUES
(1, 25, '2014-02-01', '2014-02-28', '2014-02-05 04:44:10', 1),
(2, 29, '2014-02-01', '2014-02-28', '2014-02-05 04:44:17', 1),
(3, 30, '2014-02-01', '2014-02-02', '2014-02-05 05:01:17', 1),
(4, 26, '2014-02-01', '2014-02-28', '2014-02-05 05:01:07', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='category_promotion = CP' AUTO_INCREMENT=1 ;

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
('SMTP_SERVER_ADDRESS', 'a', '2014-02-02 05:51:03', 'a', 'no'),
('EMAIL_ADDRESS_GENERAL', 'a', '2014-02-02 05:51:03', 'a', 'no'),
('HOSTING_ID', 'a', '2014-02-02 05:51:03', 'a', 'no'),
('HOSTING_PASS', 'a', '2014-02-02 05:51:03', 'a', 'no'),
('SMTP_PORT_NO', 'a', '2014-02-02 05:51:03', 'a', 'no'),
('POST_IMAGE_WIDTH', '200', '2014-02-02 05:51:03', '200', 'no'),
('MENU_TITLE_CHARACTER_LIMIT', '10', '2014-02-02 05:51:03', '10', 'no'),
('BANNER_MIN_WIDTH', '150', '2014-02-02 05:51:03', '1', 'no'),
('CATEGORY_BANNER_MAX_WIDTH', '1200', '2014-02-02 07:06:28', '1', 'no'),
('GOOGLE_ANALYTICS', 'GOOGLE_ANALYTICS', '2014-02-02 08:10:45', '1', 'yes'),
('SITE_AUTHOR', 'Blue Scheme', '2014-02-02 08:14:34', '1', 'yes');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='weight will be gram' AUTO_INCREMENT=39 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_default_inventory_id`, `product_short_description`, `product_long_description`, `product_meta_title`, `product_meta_keywords`, `product_meta_description`, `product_tags`, `product_avg_rating`, `product_show_as_new_from`, `product_show_as_new_to`, `product_show_as_featured_from`, `product_show_as_featured_to`, `product_status`, `product_total_viewed`, `product_total_sale`, `product_tax_class_id`, `product_updated`, `product_updated_by`) VALUES
(1, 'Cabbage (à¦¬à¦¾à¦à¦§à¦¾à¦•à¦ªà¦¿) ', 0, 'Cabbage (badhakopi) ', 'Cabbage (badhakopi) ', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', 'a:1:{i:0;s:5:"lemon";}', 2, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'inactive', 0, 0, 0, '2014-02-03 05:10:23', 2),
(2, 'Pran Joy', 3, 'Pran Joy mango', 'Pran Joy mango', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', 'N;', 1, '2014-01-01', '2014-02-28', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 05:57:06', 2),
(3, 'Fit Crackers Milk Flavour ', 0, 'Fit Crackers Milk Flavour ', 'Fit Crackers Milk Flavour ', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 1, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 06:02:02', 2),
(4, 'Pran Joy', 0, 'Pran Joy orange', 'Pran Joy orange', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 06:31:10', 2),
(5, 'Pran Joy', 0, 'Pran Joy fruit cocktail', 'Pran Joy fruit cocktail', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 07:02:10', 2),
(6, 'Pran mango juice pack', 0, 'Pran mango juice pack', 'Pran mango juice pack', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:04:34', 2),
(7, 'Pran mango juice pack', 0, 'Pran mango juice pack', 'Pran mango juice pack', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:11:07', 2),
(8, 'Pran mango juice pack', 0, 'Pran mango juice pack', 'Pran mango juice pack', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 6, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:32:26', 2),
(9, 'Pran mango juice pack', 0, 'Pran mango juice pack', 'Pran mango juice pack', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:38:06', 2),
(10, 'Pran premium mango juice', 0, 'Pran premium mango juice', 'Pran premium mango juice', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:46:00', 2),
(11, 'Pran premium mango juice', 0, 'Pran premium mango juice', 'Pran premium mango juice', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:52:14', 2),
(12, 'Pran juice (Premium)', 0, 'Pran juice (Premium) mango flavour', 'Pran juice (Premium) mango flavour', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 09:36:10', 2),
(13, 'Pran juice (Premium)', 0, 'Pran juice (Premium) orange flavor', 'Pran juice (Premium) orange flavor', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 09:38:41', 2),
(14, 'Pran juice (Premium)', 0, 'Pran juice (Premium) fruit cocktail', 'Pran juice (Premium) fruit cocktail', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 09:49:08', 2),
(15, 'Pran apple nectar', 0, 'Pran apple nectar', 'Pran apple nectar', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 09:59:25', 2),
(16, 'Pran apple nectar', 0, 'Pran apple nectar', 'Pran apple nectar', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:03:49', 2),
(17, 'Pran junior juice', 0, 'Pran junior juice orange flavour', 'Pran junior juice orange flavour', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:06:59', 2),
(18, 'Pran junior juice', 0, 'Pran junior juice mango flavour', 'Pran junior juice mango flavour', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:12:31', 2),
(19, 'Pran junior juice', 0, 'Pran junior juice fruit cocktail', 'Pran junior juice fruit cocktail', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:17:01', 2),
(20, 'Pran junior juice', 0, 'Pran junior juice litchi', 'Pran junior juice litchi', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:19:37', 2),
(21, 'Pran frooto', 0, 'Pran frooto mango flavour', 'Pran frooto mango flavour', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:25:51', 2),
(22, 'Pran frooto', 0, 'Pran frooto mango flavour', 'Pran frooto mango flavour', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:46:57', 2),
(23, 'Pran mango juice', 0, 'Pran mango juice', 'Pran mango juice', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:53:51', 2),
(24, 'Frooto mango juice', 0, 'Frooto mango juice', 'Frooto mango juice', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 11:03:07', 2),
(25, 'Frooto mango juice', 0, 'Frooto mango juice', 'Frooto mango juice', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 11:11:46', 2),
(26, 'Frooto mango juice', 0, 'Frooto mango juice', 'Frooto mango juice', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 04:26:32', 2),
(27, 'Sunny orange', 0, 'Sunny orange', 'Sunny orange', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 04:41:24', 2),
(28, 'Kagozee', 0, 'Kagozee lemon flavour', 'Kagozee lemon flavour', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 04:52:44', 2),
(29, 'Munchy''s Lexus Sandwich Calcium Cracker Chocolate Cream ', 0, 'Munchy''s Lexus Sandwich Calcium Cracker Chocolate Cream ', 'Munchy''s Lexus Sandwich Calcium Cracker Chocolate Cream ', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 04:57:48', 2),
(30, 'Apple nectar', 0, 'Apple nectar', 'Apple nectar', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 05:05:38', 2),
(31, 'Tiffany Chocolate Cream Wafers ', 0, 'Tiffany Chocolate Cream Wafers ', 'Tiffany Chocolate Cream Wafers ', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 05:19:38', 2),
(32, 'Pran juice', 0, 'Pran juice guava flavour', 'Pran juice guava flavour', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 4, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 05:29:44', 2),
(33, 'Pran juice', 0, 'Pran juice mango', 'Pran juice mango', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 05:51:45', 2),
(34, 'Pran juice', 0, 'Pran juice orange flavour', 'Pran juice orange flavour', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 06:01:41', 2),
(35, 'Pran juice', 0, 'Pran juice apple flavour', 'Pran juice apple flavour', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 2, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 06:06:29', 2),
(36, 'Ano Danish Butter Cookies Tin Blue ', 0, '', 'Ano Danish Butter Cookies Tin Blue ', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 4, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'active', 0, 0, 0, '2014-02-04 06:10:50', 2),
(37, 'Pran juice ', 0, 'Pran juice fruit cocktail (tin can)', 'Pran juice fruit cocktail (tin can)', 'Pran juice', 'juice, fruit ', 'Pran juice fruit cocktail (tin can)', '', 3, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 06:16:15', 2),
(38, 'Baton Rouge Ovaltine Biscuit ', 0, 'Baton Rouge Ovaltine Biscuit ', 'Baton Rouge Ovaltine Biscuit ', '', '', '', '', 5, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 06:21:47', 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='products_related = PR' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `products_related`
--

INSERT INTO `products_related` (`PR_id`, `PR_current_product_id`, `PR_related_product_id`, `PR_priority_id`, `PR_created`, `PR_created_by_id`) VALUES
(1, 29, 3, 0, '2014-02-04 05:02:29', 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='products_upsell = PU' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `products_upsell`
--

INSERT INTO `products_upsell` (`PU_id`, `PU_current_product_id`, `PU_related_product_id`, `PU_priority_id`, `PU_created`, `PU_created_by_id`) VALUES
(1, 29, 3, 0, '2014-02-04 05:02:17', 3),
(2, 31, 29, 0, '2014-02-04 05:24:41', 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='product_also_like = PAL' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `product_also_like`
--

INSERT INTO `product_also_like` (`PAL_id`, `PAL_current_product_id`, `PAL_related_product_id`, `PAL_priority_id`, `PAL_created`, `PAL_created_by_id`) VALUES
(1, 29, 3, 0, '2014-02-04 05:02:45', 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='product_categories = PC' AUTO_INCREMENT=41 ;

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
(37, 2, 26, '2014-02-05 05:00:43', 0),
(38, 1, 25, '2014-02-05 08:29:34', 0),
(39, 3, 26, '2014-02-05 08:29:52', 0),
(40, 15, 26, '2014-02-05 08:30:10', 0);

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
(1, 1, 0, '2013-12-01', '2013-12-31', 10, 1, '2013-12-05 07:57:32', 9),
(2, 2, 0, '2013-12-01', '2013-12-31', 10, 1, '2013-12-05 07:57:58', 9);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE IF NOT EXISTS `product_images` (
  `PI_id` int(11) NOT NULL AUTO_INCREMENT,
  `PI_product_id` int(11) NOT NULL,
  `PI_file_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `PI_priority` int(6) NOT NULL,
  `PI_color` int(11) NOT NULL,
  `PI_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PI_updated_by` int(5) NOT NULL,
  PRIMARY KEY (`PI_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PI = product_images' AUTO_INCREMENT=39 ;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`PI_id`, `PI_product_id`, `PI_file_name`, `PI_priority`, `PI_color`, `PI_updated`, `PI_updated_by`) VALUES
(1, 1, '1_1.png', 1, 0, '2014-02-03 05:12:35', 3),
(2, 3, '3_2.gif', 1, 0, '2014-02-03 06:11:17', 3),
(3, 2, '2_3.png', 1, 0, '2014-02-03 06:12:42', 2),
(4, 4, '4_4.gif', 2, 0, '2014-02-03 06:32:01', 2),
(5, 6, '6_5.png', 4, 0, '2014-02-03 08:06:40', 2),
(6, 7, '7_6.gif', 5, 0, '2014-02-03 08:11:33', 2),
(7, 8, '8_7.gif', 5, 0, '2014-02-03 08:33:31', 2),
(8, 9, '9_8.jpeg', 5, 0, '2014-02-03 08:38:46', 2),
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
(30, 29, '29_30.JPG', 2, 0, '2014-02-04 04:58:51', 3),
(31, 31, '31_31.jpg', 3, 0, '2014-02-04 05:21:32', 3),
(32, 32, '32_32.gif', 0, 0, '2014-02-04 05:30:45', 2),
(33, 30, '30_33.gif', 0, 0, '2014-02-04 05:37:45', 2),
(34, 33, '33_34.gif', 0, 0, '2014-02-04 05:52:13', 2),
(35, 34, '34_35.gif', 0, 0, '2014-02-04 06:02:15', 2),
(36, 35, '35_36.gif', 0, 0, '2014-02-04 06:08:23', 2),
(37, 36, '36_37.jpg', 4, 0, '2014-02-04 06:11:45', 3),
(38, 37, '37_38.gif', 0, 0, '2014-02-04 06:16:53', 2);

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
  `PI_cost` decimal(10,0) NOT NULL,
  `PI_price` decimal(10,0) NOT NULL,
  `PI_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PI_updated_by` int(5) NOT NULL,
  PRIMARY KEY (`PI_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PI = product_inventories' AUTO_INCREMENT=36 ;

--
-- Dumping data for table `product_inventories`
--

INSERT INTO `product_inventories` (`PI_id`, `PI_inventory_title`, `PI_product_id`, `PI_color_id`, `PI_size_id`, `PI_quantity`, `PI_cost`, `PI_price`, `PI_updated`, `PI_updated_by`) VALUES
(1, '', 1, 0, 4, 6, 12, 15, '2014-02-03 05:15:37', 3),
(2, '', 3, 0, 4, 1, 12, 15, '2014-02-03 06:13:22', 3),
(3, 'Pran Joy 200ml', 2, 0, 11, 500, 20, 25, '2014-02-03 06:16:22', 1),
(4, '', 4, 0, 11, 500, 20, 25, '2014-02-03 06:34:25', 2),
(5, '', 6, 0, 12, 500, 20, 25, '2014-02-03 08:06:21', 2),
(6, '', 7, 0, 11, 500, 20, 25, '2014-02-03 08:13:15', 2),
(7, '', 8, 0, 13, 500, 20, 25, '2014-02-03 08:34:46', 2),
(8, '', 9, 0, 14, 500, 90, 100, '2014-02-03 08:40:40', 2),
(9, '', 10, 0, 13, 500, 20, 25, '2014-02-03 08:48:42', 2),
(10, '', 11, 0, 14, 500, 90, 100, '2014-02-03 08:55:43', 2),
(11, '', 13, 0, 14, 500, 90, 100, '2014-02-03 09:39:40', 2),
(12, '', 14, 0, 14, 500, 90, 100, '2014-02-03 09:51:37', 2),
(13, '', 15, 0, 14, 500, 90, 100, '2014-02-03 10:01:04', 2),
(14, '', 16, 0, 11, 500, 20, 25, '2014-02-03 10:04:33', 2),
(15, '', 17, 0, 15, 500, 12, 15, '2014-02-03 10:09:43', 2),
(16, '', 18, 0, 15, 300, 12, 15, '2014-02-03 10:14:25', 2),
(17, '', 19, 0, 15, 500, 12, 15, '2014-02-03 10:17:42', 2),
(18, '', 20, 0, 15, 500, 12, 15, '2014-02-03 10:20:35', 2),
(19, '', 21, 0, 15, 300, 12, 15, '2014-02-03 10:30:08', 2),
(20, '', 22, 0, 11, 500, 20, 25, '2014-02-03 10:48:44', 2),
(21, '', 23, 0, 13, 500, 20, 25, '2014-02-03 10:55:11', 2),
(22, '', 24, 0, 13, 300, 20, 25, '2014-02-03 11:09:11', 2),
(23, '', 25, 0, 16, 500, 40, 50, '2014-02-03 11:24:25', 2),
(24, '', 26, 0, 14, 500, 90, 100, '2014-02-04 04:29:15', 2),
(25, '', 27, 0, 13, 300, 30, 25, '2014-02-04 04:42:58', 2),
(26, '', 28, 0, 13, 300, 25, 30, '2014-02-04 04:55:34', 2),
(27, '', 29, 0, 4, 100, 100, 350, '2014-02-04 05:01:13', 3),
(28, '', 30, 0, 13, 300, 20, 25, '2014-02-04 05:07:29', 2),
(29, '', 31, 0, 7, 100, 100, 209, '2014-02-04 05:22:28', 3),
(30, '', 32, 0, 13, 300, 20, 25, '2014-02-04 05:31:27', 2),
(31, '', 33, 0, 13, 300, 20, 25, '2014-02-04 05:53:02', 2),
(32, '', 35, 0, 13, 300, 20, 25, '2014-02-04 06:07:54', 2),
(33, '', 36, 0, 7, 100, 100, 454, '2014-02-04 06:12:31', 3),
(34, '', 37, 0, 13, 300, 25, 30, '2014-02-04 06:18:07', 2),
(35, 'Pran Joy 250ml', 2, 0, 13, 500, 100, 250, '2014-02-06 06:49:51', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PIL=product_inventory_log' AUTO_INCREMENT=37 ;

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
(36, 35, '2014-02-06', 500, 0, '', 'Inserted initial value ', 1, '2014-02-06 12:49:51');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='product_sizes (specific sizes which show frontend)' AUTO_INCREMENT=46 ;

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
(45, 13, '250ml', 2, '2014-02-06 06:49:34');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`size_id`, `size_title`, `size_updated`, `size_updated_by`) VALUES
(1, '100gm', '2014-02-03 05:04:49', 3),
(2, '500gm', '2014-02-03 05:05:01', 3),
(3, '1kg', '2014-02-03 05:05:10', 3),
(4, '1pice', '2014-02-03 05:05:23', 3),
(5, '250gm', '2014-02-03 05:05:32', 3),
(6, '5kg', '2014-02-03 05:05:43', 3),
(7, '1 packet', '2014-02-03 05:05:59', 3),
(8, '1 dozen', '2014-02-03 05:06:57', 3),
(9, '4 pice', '2014-02-03 05:07:11', 3),
(10, '70 gm', '2014-02-03 06:11:47', 3),
(11, '200ml', '2014-02-03 06:13:55', 2),
(12, '125gm', '2014-02-03 08:05:27', 2),
(13, '250ml', '2014-02-03 08:33:58', 2),
(14, '1ltr', '2014-02-03 08:39:45', 2),
(15, '125ml', '2014-02-03 10:09:03', 2),
(16, '500ml', '2014-02-03 11:13:58', 2),
(17, '1000ml', '2014-02-04 05:33:36', 2),
(18, '50gm', '2014-02-04 05:33:55', 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

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
(10, 'apple', '2014-02-04 06:10:13', 2);

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
  `TC_price` decimal(10,0) NOT NULL,
  `TC_per_unit_discount` decimal(10,0) NOT NULL,
  `TC_discount_amount` decimal(10,0) NOT NULL,
  `TC_product_quantity` int(5) NOT NULL,
  `TC_product_total_price` decimal(10,0) NOT NULL COMMENT 'total price = quantity * price',
  `TC_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`TC_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='empty regularly using cron, TC= temp_carts' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
