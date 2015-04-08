-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 12, 2014 at 04:52 PM
-- Server version: 5.1.68-cll
-- PHP Version: 5.3.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bluetest_bajaree`
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
(1, 'Faruk', 'faruk@bscheme.com', 'e10adc3949ba59abb#b1a2j1r1e2*e56e057f20f883e', '8652df5fa5bc8686a5ddc670b114ce96', 'master', 'active', '2014-02-03 05:28:03', '2013-04-27 16:10:46', 0),
(2, 'Rashed', 'rashed@bscheme.com', 'd355613d1ed436902#b1a2j1r1e2*c3ebb0590ea833b', '7461481e4ba37ca8cc6f5e5bd75d8732', 'super', 'active', '2014-02-08 06:31:36', '2014-02-03 10:54:08', 0),
(3, 'Mukesh ', 'mukesh@bscheme.com', 'fe9642294f8e3bdac#b1a2j1r1e2*f9de8d8caff83ad', '5182095d070c546cb0270f6cb199e570', 'super', 'active', '2014-02-12 08:32:53', '2014-02-03 10:54:53', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `product_sku` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `product_short_description` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `product_long_description` text COLLATE utf8_unicode_ci NOT NULL,
  `product_meta_title` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `product_meta_keywords` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `product_meta_description` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `product_quantity` int(4) NOT NULL,
  `product_weight` int(5) NOT NULL,
  `product_cost` decimal(10,0) NOT NULL,
  `product_price` decimal(10,0) NOT NULL,
  `product_avg_rating` int(1) NOT NULL,
  `product_discount_price` decimal(10,0) NOT NULL,
  `product_show_as_new_from` date NOT NULL,
  `product_show_as_new_to` date NOT NULL,
  `product_show_as_featured_from` date NOT NULL,
  `product_show_as_featured_to` date NOT NULL,
  `product_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `product_total_viewed` int(11) NOT NULL,
  `product_tatal_sale` int(11) NOT NULL,
  `product_tax_class_id` int(11) NOT NULL,
  `product_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_updated_by` int(5) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='weight will be gram' AUTO_INCREMENT=63 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_sku`, `product_short_description`, `product_long_description`, `product_meta_title`, `product_meta_keywords`, `product_meta_description`, `product_quantity`, `product_weight`, `product_cost`, `product_price`, `product_avg_rating`, `product_discount_price`, `product_show_as_new_from`, `product_show_as_new_to`, `product_show_as_featured_from`, `product_show_as_featured_to`, `product_status`, `product_total_viewed`, `product_tatal_sale`, `product_tax_class_id`, `product_updated`, `product_updated_by`) VALUES
(1, 'Cabbage (à¦¬à¦¾à¦à¦§à¦¾à¦•à¦ªà¦¿) ', 'Cabbage (badhakopi) ', 'Cabbage (badhakopi) ', 'Cabbage (badhakopi) ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 2, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 05:10:23', 3),
(2, 'Pran Joy', 'Pran Joy', 'Pran Joy mango', 'Pran Joy mango', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 1, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 05:57:06', 3),
(3, 'Fit Crackers Milk Flavour ', 'Fit Crackers Milk Flavour', 'Fit Crackers Milk Flavour ', 'Fit Crackers Milk Flavour ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 1, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 06:02:02', 3),
(4, 'Pran Joy', 'Pran Joy ', 'Pran Joy orange', 'Pran Joy orange', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 06:31:10', 3),
(5, 'Pran Joy', 'Pran Joy', 'Pran Joy fruit cocktail', 'Pran Joy fruit cocktail', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 07:02:10', 3),
(6, 'Pran mango juice pack', 'Pran mango juice pack', 'Pran mango juice pack', 'Pran mango juice pack', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:04:34', 3),
(7, 'Pran mango juice pack', 'Pran mango juice pack', 'Pran mango juice pack', 'Pran mango juice pack', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 5, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:11:07', 3),
(8, 'Pran mango juice pack', 'Pran mango juice pack', 'Pran mango juice pack', 'Pran mango juice pack', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 6, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:32:26', 3),
(9, 'Pran mango juice pack', 'Pran mango juice pack', 'Pran mango juice pack', 'Pran mango juice pack', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 5, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:38:06', 3),
(10, 'Pran premium mango juice', 'Pran premium mango juice', 'Pran premium mango juice', 'Pran premium mango juice', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:46:00', 3),
(11, 'Pran premium mango juice', 'Pran premium mango juice', 'Pran premium mango juice', 'Pran premium mango juice', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 5, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 08:52:14', 3),
(12, 'Pran juice (Premium)', 'Pran juice (Premium)', 'Pran juice (Premium) mango flavour', 'Pran juice (Premium) mango flavour', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 5, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 09:36:10', 3),
(13, 'Pran juice (Premium)', 'Pran juice (Premium)', 'Pran juice (Premium) orange flavor', 'Pran juice (Premium) orange flavor', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 09:38:41', 3),
(14, 'Pran juice (Premium)', 'Pran juice (Premium)', 'Pran juice (Premium) fruit cocktail', 'Pran juice (Premium) fruit cocktail', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 09:49:08', 3),
(15, 'Pran apple nectar', 'Pran apple nectar', 'Pran apple nectar', 'Pran apple nectar', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 09:59:25', 3),
(16, 'Pran apple nectar', 'Pran apple nectar', 'Pran apple nectar', 'Pran apple nectar', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:03:49', 3),
(17, 'Pran junior juice', 'Pran junior juice', 'Pran junior juice orange flavour', 'Pran junior juice orange flavour', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 5, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:06:59', 3),
(18, 'Pran junior juice', 'Pran junior juice', 'Pran junior juice mango flavour', 'Pran junior juice mango flavour', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 5, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:12:31', 3),
(19, 'Pran junior juice', 'Pran junior juice', 'Pran junior juice fruit cocktail', 'Pran junior juice fruit cocktail', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:17:01', 3),
(20, 'Pran junior juice', 'Pran junior juice', 'Pran junior juice litchi', 'Pran junior juice litchi', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:19:37', 3),
(21, 'Pran frooto', 'Pran frooto', 'Pran frooto mango flavour', 'Pran frooto mango flavour', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:25:51', 3),
(22, 'Pran frooto', 'Pran frooto', 'Pran frooto mango flavour', 'Pran frooto mango flavour', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:46:57', 3),
(23, 'Pran mango juice', 'Pran mango juice', 'Pran mango juice', 'Pran mango juice', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 25, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 10:53:51', 3),
(24, 'Frooto mango juice', 'Frooto mango juice', 'Frooto mango juice', 'Frooto mango juice', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 25, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 11:03:07', 3),
(25, 'Frooto mango juice', 'Frooto mango juice', 'Frooto mango juice', 'Frooto mango juice', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 25, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-03 11:11:46', 3),
(26, 'Frooto mango juice', 'Frooto mango juice', 'Frooto mango juice', 'Frooto mango juice', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 90, 100, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 04:26:32', 3),
(27, 'Sunny orange', 'Sunny orange', 'Sunny orange', 'Sunny orange', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 25, 30, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 04:41:24', 3),
(28, 'Kagozee', 'Kagozee', 'Kagozee lemon flavour', 'Kagozee lemon flavour', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 25, 30, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 04:52:44', 3),
(29, 'Munchy''s Lexus Sandwich Calcium Cracker Chocolate Cream ', 'Munchy''s Lexus Sandwich ', 'Munchy''s Lexus Sandwich Calcium Cracker Chocolate Cream ', 'Munchy''s Lexus Sandwich Calcium Cracker Chocolate Cream ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 100, 350, 5, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 04:57:48', 3),
(30, 'Apple nectar', 'Apple nectar', 'Apple nectar', 'Apple nectar', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 05:05:38', 3),
(31, 'Tiffany Chocolate Cream Wafers ', 'Tiffany Chocolate Cream ', 'Tiffany Chocolate Cream Wafers ', 'Tiffany Chocolate Cream Wafers ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 100, 209, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 05:19:38', 3),
(32, 'Pran juice', 'Pran juice', 'Pran juice guava flavour', 'Pran juice guava flavour', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 20, 25, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 05:29:44', 3),
(33, 'Pran juice', 'Pran juice', 'Pran juice mango', 'Pran juice mango', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 25, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 05:51:45', 3),
(34, 'Pran juice', 'Pran juice', 'Pran juice orange flavour', 'Pran juice orange flavour', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 25, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 06:01:41', 3),
(35, 'Pran juice', 'Pran juice', 'Pran juice apple flavour', 'Pran juice apple flavour', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 25, 2, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 06:06:29', 3),
(36, 'Ano Danish Butter Cookies Tin Blue ', 'Ano Danish Butter Cookies', '', 'Ano Danish Butter Cookies Tin Blue ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 100, 900, 4, 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'active', 0, 0, 0, '2014-02-04 06:10:50', 3),
(37, 'Pran juice ', 'Pran juice ', 'Pran juice fruit cocktail (tin can)', 'Pran juice fruit cocktail (tin can)', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 30, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 06:16:15', 3),
(38, 'Baton Rouge Ovaltine Biscuit ', 'Baton Rouge Ovaltine ', 'Baton Rouge Ovaltine Biscuit ', 'Baton Rouge Ovaltine Biscuit ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 60, 5, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 06:21:47', 3),
(39, 'Pran juice', 'Pran juice', 'Pran juice mango (tin can)', 'Pran juice mango (tin can)', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 30, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 06:36:03', 3),
(40, 'Pran juice', 'Pran juice', 'Pran Juice tamarind (tin can)', 'Pran Juice tamarind (tin can)', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 30, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 07:07:41', 3),
(41, 'Pran juice', 'Pran juice', 'Pran Juice orange (tin can)', 'Pran Juice orange (tin can)', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 30, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 07:21:26', 3),
(42, 'Pran juice', 'Pran juice', 'Pran Juice banana (tin can)', 'Pran Juice banana (tin can)', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 30, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 07:50:17', 3),
(43, 'Pran juice', 'Pran juice', 'Pran Juice guava (tin can)', 'Pran Juice guava (tin can)', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 30, 2, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 08:00:11', 3),
(44, 'Pran juice', 'Pran juice', 'Pran juice pineapple (tin can)', 'Pran juice pineapple (tin can)', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 30, 5, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 08:20:42', 3),
(45, 'Aarong mango juice ', 'Aarong mango juice ', 'Aarong mango juice ', 'Aarong mango juice ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 30, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 08:33:31', 3),
(46, 'Acme mango juice classic ', 'Acme mango juice classic ', 'Acme mango juice classic ', 'Acme mango juice classic ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 25, 22, 2, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 08:48:32', 3),
(47, 'Acme mango juice premium ', 'Acme mango juice premium ', 'Acme mango juice premium ', 'Acme mango juice premium ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 35, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 08:54:26', 3),
(48, 'Acme mango orange juice', 'Acme mango orange juice', 'Acme mango orange juice', 'Acme mango orange juice', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 35, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 09:42:38', 3),
(49, 'Acme mango juice classic', 'Acme mango juice classic', 'Acme mango juice classic', 'Acme mango juice classic', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 35, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-04 09:55:33', 3),
(50, 'Bengal Orange Cake Biscuit ', 'Bengal Orange Cake Biscuit ', 'Bengal Orange Cake Biscuit ', 'Bengal Orange Cake Biscuit ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 35, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-05 06:48:00', 3),
(51, 'Bengal Orange Cake Biscuit Tin', 'Bengal Orange Cake Biscuit Tin', 'Bengal Orange Cake Biscuit Tin', 'Bengal Orange Cake Biscuit Tin', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 100, 220, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-05 06:56:47', 3),
(52, 'Acme mango juice classic', 'Acme mango juice classic', 'Acme mango juice classic', 'Acme mango juice classic', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 30, 3, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-06 10:25:35', 3),
(53, 'Berri grapefruit juice ', 'Berri grapefruit juice ', 'Berri grapefruit juice ', 'Berri grapefruit juice ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 400, 5, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-06 10:35:17', 3),
(54, 'Berri cranberry juice', 'Berri cranberry juice', 'Berri cranberry juice', 'Berri cranberry juice', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 0, 400, 2, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-06 10:58:47', 3),
(55, 'Bengal Pineapple Cream biscuit ', 'Bengal Pineapple Cream biscuit ', 'Bengal Pineapple Cream biscuit ', 'Bengal Pineapple Cream biscuit ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 10, 25, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-08 08:17:06', 3),
(56, 'Bissin Premium Coconut Wafers ', 'Bissin Premium Coconut Wafers ', 'Bissin Premium Coconut Wafers ', 'Bissin Premium Coconut Wafers ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 100, 206, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-08 08:21:08', 3),
(57, 'Cadbury Oreo Biscuit ', 'Cadbury Oreo Biscuit ', 'Cadbury Oreo Biscuit ', 'Cadbury Oreo Biscuit ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 10, 90, 5, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-08 08:38:18', 3),
(58, 'Cadbury Oreo Sandwich Biscuits Pack ', 'Cadbury Oreo Sandwich Biscuits Pack ', 'Cadbury Oreo Sandwich Biscuits Pack ', 'Cadbury Oreo Sandwich Biscuits Pack ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 10, 48, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-08 08:56:45', 3),
(59, 'Cocola Chocolate Biscuits ', 'Cocola Chocolate Biscuits ', 'Cocola Chocolate Biscuits ', 'Cocola Chocolate Biscuits ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 10, 15, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-08 09:00:32', 3),
(60, 'Danish Florida Orange Biscuit ', 'Danish Florida Orange Biscuit ', 'Danish Florida Orange Biscuit ', 'Danish Florida Orange Biscuit ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 10, 35, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-08 09:03:55', 3),
(61, 'Danish Hi Energy Biscuits ', 'Danish Hi Energy Biscuits ', 'Danish Hi Energy Biscuits ', 'Danish Hi Energy Biscuits ', 'Danish Hi Energy ', 'Danish Hi Energy ', 'Danish Hi Energy Biscuits ', 0, 0, 10, 13, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-08 09:22:30', 3),
(62, 'Danish Lexus Vegetable Calcium Crackers ', 'Danish Lexus Vegetable Calcium Crackers ', 'Danish Lexus Vegetable Calcium Crackers ', 'Danish Lexus Vegetable Calcium Crackers ', '', '', '', 0, 0, 0, 100, 4, 0, '0000-00-00', '0000-00-00', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2014-02-08 09:35:08', 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='products_related = PR' AUTO_INCREMENT=18 ;

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
(17, 60, 3, 0, '2014-02-08 09:21:33', 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='products_upsell = PU' AUTO_INCREMENT=16 ;

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
(15, 61, 3, 0, '2014-02-08 09:24:35', 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='product_also_like = PAL' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `product_also_like`
--

INSERT INTO `product_also_like` (`PAL_id`, `PAL_current_product_id`, `PAL_related_product_id`, `PAL_priority_id`, `PAL_created`, `PAL_created_by_id`) VALUES
(1, 29, 3, 0, '2014-02-04 05:02:45', 3),
(2, 51, 50, 0, '2014-02-05 07:02:28', 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='product_categories = PC' AUTO_INCREMENT=61 ;

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
(43, 45, 44, '2014-02-04 08:34:11', 0),
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
(60, 62, 45, '2014-02-08 09:35:30', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PI = product_images' AUTO_INCREMENT=64 ;

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
(38, 37, '37_38.gif', 0, 0, '2014-02-04 06:16:53', 2),
(39, 38, '38_39.jpeg', 6, 0, '2014-02-04 06:33:21', 3),
(40, 39, '39_40.gif', 0, 0, '2014-02-04 06:55:35', 2),
(41, 40, '40_41.gif', 0, 0, '2014-02-04 07:07:58', 2),
(43, 41, '41_42.gif', 0, 0, '2014-02-04 07:49:42', 2),
(44, 43, '43_44.gif', 0, 0, '2014-02-04 08:00:49', 2),
(45, 44, '44_45.gif', 0, 0, '2014-02-04 08:23:18', 2),
(46, 45, '45_46.jpg', 0, 0, '2014-02-04 08:36:02', 2),
(47, 46, '46_47.jpg', 0, 0, '2014-02-04 09:08:51', 2),
(48, 47, '47_48.jpg', 0, 0, '2014-02-04 09:10:59', 2),
(49, 48, '48_49.jpg', 0, 0, '2014-02-04 09:42:59', 2),
(50, 49, '49_50.jpg', 0, 0, '2014-02-04 09:56:13', 2),
(51, 50, '50_51.jpeg', 7, 0, '2014-02-05 06:50:07', 3),
(52, 51, '51_52.jpg', 8, 0, '2014-02-05 06:57:34', 3),
(53, 52, '52_53.jpg', 0, 0, '2014-02-06 10:26:22', 2),
(54, 53, '53_54.jpg', 0, 0, '2014-02-06 10:40:54', 2),
(55, 55, '55_55.jpeg', 9, 0, '2014-02-08 08:18:02', 3),
(56, 56, '56_56.jpg', 10, 0, '2014-02-08 08:22:01', 3),
(57, 57, '57_57.jpg', 11, 0, '2014-02-08 08:38:59', 3),
(58, 58, '58_58.jpeg', 12, 0, '2014-02-08 08:57:43', 3),
(59, 59, '59_59.jpeg', 13, 0, '2014-02-08 09:02:18', 3),
(61, 60, '60_60.jpg', 14, 0, '2014-02-08 09:05:21', 3),
(62, 61, '61_62.png', 15, 0, '2014-02-08 09:23:17', 3),
(63, 62, '62_63.jpg', 16, 0, '2014-02-08 09:36:06', 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_inventories`
--

CREATE TABLE IF NOT EXISTS `product_inventories` (
  `PI_id` int(11) NOT NULL AUTO_INCREMENT,
  `PI_product_id` int(11) NOT NULL,
  `PI_color_id` int(11) NOT NULL,
  `PI_size_id` int(11) NOT NULL,
  `PI_quantity` int(5) NOT NULL,
  `PI_weight` int(5) NOT NULL,
  `PI_cost` decimal(10,0) NOT NULL,
  `PI_price` decimal(10,0) NOT NULL,
  `PI_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PI_updated_by` int(5) NOT NULL,
  PRIMARY KEY (`PI_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PI = product_inventories' AUTO_INCREMENT=57 ;

--
-- Dumping data for table `product_inventories`
--

INSERT INTO `product_inventories` (`PI_id`, `PI_product_id`, `PI_color_id`, `PI_size_id`, `PI_quantity`, `PI_weight`, `PI_cost`, `PI_price`, `PI_updated`, `PI_updated_by`) VALUES
(1, 1, 0, 4, 6, 1000, 12, 15, '2014-02-03 05:15:37', 3),
(2, 3, 0, 4, 1, 70, 12, 15, '2014-02-03 06:13:22', 3),
(3, 2, 0, 11, 500, 200, 20, 25, '2014-02-03 06:16:22', 2),
(4, 4, 0, 11, 500, 200, 20, 25, '2014-02-03 06:34:25', 2),
(5, 6, 0, 12, 500, 125, 20, 25, '2014-02-03 08:06:21', 2),
(6, 7, 0, 11, 500, 200, 20, 25, '2014-02-03 08:13:15', 2),
(7, 8, 0, 13, 500, 250, 20, 25, '2014-02-03 08:34:46', 2),
(8, 9, 0, 14, 500, 1, 90, 100, '2014-02-03 08:40:40', 2),
(9, 10, 0, 13, 500, 250, 20, 25, '2014-02-03 08:48:42', 2),
(10, 11, 0, 14, 500, 1, 90, 100, '2014-02-03 08:55:43', 2),
(11, 13, 0, 14, 500, 1, 90, 100, '2014-02-03 09:39:40', 2),
(12, 14, 0, 14, 500, 1, 90, 100, '2014-02-03 09:51:37', 2),
(13, 15, 0, 14, 500, 1, 90, 100, '2014-02-03 10:01:04', 2),
(14, 16, 0, 11, 500, 200, 20, 25, '2014-02-03 10:04:33', 2),
(15, 17, 0, 15, 500, 125, 12, 15, '2014-02-03 10:09:43', 2),
(16, 18, 0, 15, 300, 125, 12, 15, '2014-02-03 10:14:25', 2),
(17, 19, 0, 15, 500, 125, 12, 15, '2014-02-03 10:17:42', 2),
(18, 20, 0, 15, 500, 125, 12, 15, '2014-02-03 10:20:35', 2),
(19, 21, 0, 15, 300, 125, 12, 15, '2014-02-03 10:30:08', 2),
(20, 22, 0, 11, 500, 200, 20, 25, '2014-02-03 10:48:44', 2),
(21, 23, 0, 13, 500, 250, 20, 25, '2014-02-03 10:55:11', 2),
(22, 24, 0, 13, 300, 250, 20, 25, '2014-02-03 11:09:11', 2),
(23, 25, 0, 16, 500, 500, 40, 50, '2014-02-03 11:24:25', 2),
(24, 26, 0, 14, 500, 1, 90, 100, '2014-02-04 04:29:15', 2),
(25, 27, 0, 13, 300, 250, 30, 25, '2014-02-04 04:42:58', 2),
(26, 28, 0, 13, 300, 250, 25, 30, '2014-02-04 04:55:34', 2),
(27, 29, 0, 4, 100, 190, 100, 350, '2014-02-04 05:01:13', 3),
(28, 30, 0, 13, 300, 250, 20, 25, '2014-02-04 05:07:29', 2),
(29, 31, 0, 7, 100, 153, 100, 209, '2014-02-04 05:22:28', 3),
(30, 32, 0, 13, 300, 250, 20, 25, '2014-02-04 05:31:27', 2),
(31, 33, 0, 13, 300, 250, 20, 25, '2014-02-04 05:53:02', 2),
(32, 35, 0, 13, 300, 250, 20, 25, '2014-02-04 06:07:54', 2),
(33, 36, 0, 7, 100, 454, 100, 454, '2014-02-04 06:12:31', 3),
(34, 37, 0, 13, 300, 250, 25, 30, '2014-02-04 06:18:07', 2),
(35, 39, 0, 13, 300, 250, 25, 30, '2014-02-04 07:04:21', 2),
(36, 40, 0, 13, 300, 250, 25, 30, '2014-02-04 07:09:54', 2),
(38, 41, 0, 13, 300, 250, 25, 30, '2014-02-04 07:51:28', 2),
(39, 42, 0, 13, 200, 250, 25, 30, '2014-02-04 07:53:32', 2),
(40, 43, 0, 13, 200, 250, 25, 30, '2014-02-04 08:01:47', 2),
(41, 44, 0, 13, 200, 250, 25, 30, '2014-02-04 08:24:00', 2),
(42, 45, 0, 13, 200, 250, 22, 40, '2014-02-04 08:37:19', 2),
(43, 46, 0, 13, 500, 250, 20, 30, '2014-02-04 08:51:05', 2),
(44, 47, 0, 13, 300, 250, 20, 30, '2014-02-04 09:14:07', 2),
(45, 48, 0, 14, 300, 1, 30, 35, '2014-02-04 09:43:26', 2),
(46, 49, 0, 14, 200, 1, 25, 35, '2014-02-04 09:56:50', 2),
(47, 50, 0, 7, 100, 190, 10, 35, '2014-02-05 06:51:09', 3),
(48, 51, 0, 20, 100, 1000, 100, 220, '2014-02-05 06:59:39', 3),
(49, 52, 0, 13, 200, 250, 25, 30, '2014-02-06 10:27:49', 2),
(50, 53, 0, 21, 300, 2, 350, 400, '2014-02-06 10:42:09', 2),
(51, 55, 0, 4, 100, 60, 10, 60, '2014-02-08 08:18:56', 3),
(52, 56, 0, 4, 100, 100, 10, 206, '2014-02-08 08:22:38', 3),
(53, 57, 0, 4, 100, 120, 10, 90, '2014-02-08 08:39:48', 3),
(54, 58, 0, 7, 100, 60, 10, 48, '2014-02-08 08:58:49', 3),
(55, 60, 0, 7, 100, 210, 10, 35, '2014-02-08 09:05:56', 3),
(56, 61, 0, 7, 100, 90, 10, 13, '2014-02-08 09:23:57', 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PIL=product_inventory_log' AUTO_INCREMENT=58 ;

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
(57, 56, '2014-02-08', 100, 0, '', 'Inserted initial value ', 3, '2014-02-08 15:23:58');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='product_sizes (specific sizes which show frontend)' AUTO_INCREMENT=70 ;

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
(69, 7, '1 packet', 62, '2014-02-08 09:36:23');

-- --------------------------------------------------------

--
-- Table structure for table `product_tags`
--

CREATE TABLE IF NOT EXISTS `product_tags` (
  `PT_id` int(11) NOT NULL AUTO_INCREMENT,
  `PT_product_id` int(11) NOT NULL,
  `PT_tag_id` int(11) NOT NULL,
  `PT_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PT_updated_by` int(5) NOT NULL,
  PRIMARY KEY (`PT_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PT = product_tags' AUTO_INCREMENT=67 ;

--
-- Dumping data for table `product_tags`
--

INSERT INTO `product_tags` (`PT_id`, `PT_product_id`, `PT_tag_id`, `PT_updated`, `PT_updated_by`) VALUES
(1, 1, 1, '2014-02-03 05:19:55', 3),
(2, 2, 5, '2014-02-03 06:19:56', 2),
(3, 4, 5, '2014-02-03 06:50:25', 2),
(4, 5, 5, '2014-02-03 07:03:23', 2),
(5, 6, 5, '2014-02-03 08:06:58', 2),
(6, 7, 5, '2014-02-03 08:13:47', 2),
(7, 8, 5, '2014-02-03 08:36:31', 2),
(8, 9, 5, '2014-02-03 08:43:22', 2),
(9, 10, 5, '2014-02-03 08:50:40', 2),
(10, 11, 5, '2014-02-03 08:57:57', 2),
(11, 12, 5, '2014-02-03 09:37:33', 2),
(12, 13, 5, '2014-02-03 09:40:15', 2),
(13, 14, 5, '2014-02-03 09:52:28', 2),
(14, 15, 5, '2014-02-03 10:01:46', 2),
(15, 18, 5, '2014-02-03 10:15:14', 2),
(16, 20, 5, '2014-02-03 10:21:13', 2),
(17, 21, 5, '2014-02-03 10:32:11', 2),
(18, 22, 5, '2014-02-03 10:49:57', 2),
(19, 26, 5, '2014-02-04 04:35:31', 2),
(20, 26, 4, '2014-02-04 04:35:40', 2),
(21, 27, 5, '2014-02-04 04:44:14', 2),
(22, 28, 5, '2014-02-04 04:56:58', 2),
(23, 28, 5, '2014-02-04 04:57:23', 2),
(24, 28, 8, '2014-02-04 04:57:27', 2),
(25, 28, 8, '2014-02-04 04:58:23', 2),
(26, 28, 8, '2014-02-04 04:58:32', 2),
(27, 29, 1, '2014-02-04 05:03:10', 3),
(28, 29, 2, '2014-02-04 05:03:10', 3),
(29, 32, 9, '2014-02-04 05:36:07', 2),
(30, 33, 6, '2014-02-04 05:57:49', 2),
(31, 33, 5, '2014-02-04 05:57:52', 2),
(32, 35, 10, '2014-02-04 06:10:31', 2),
(33, 39, 5, '2014-02-04 07:05:07', 2),
(34, 39, 6, '2014-02-04 07:05:15', 2),
(35, 41, 5, '2014-02-04 07:24:44', 2),
(36, 41, 5, '2014-02-04 07:25:05', 2),
(37, 41, 11, '2014-02-04 07:25:16', 2),
(38, 41, 7, '2014-02-04 07:52:21', 2),
(39, 42, 11, '2014-02-04 07:54:02', 2),
(40, 43, 5, '2014-02-04 08:02:09', 2),
(41, 43, 9, '2014-02-04 08:02:14', 2),
(42, 44, 12, '2014-02-04 08:24:43', 2),
(43, 45, 8, '2014-02-04 08:45:55', 2),
(44, 45, 8, '2014-02-04 08:46:01', 2),
(45, 48, 5, '2014-02-04 09:46:16', 2),
(46, 50, 1, '2014-02-05 06:54:37', 3),
(47, 50, 2, '2014-02-05 06:54:37', 3),
(48, 51, 1, '2014-02-05 07:02:44', 3),
(49, 51, 2, '2014-02-05 07:02:44', 3),
(50, 52, 5, '2014-02-06 10:28:36', 2),
(51, 52, 6, '2014-02-06 10:28:39', 2),
(52, 53, 14, '2014-02-06 10:43:19', 2),
(53, 56, 1, '2014-02-08 08:24:18', 3),
(54, 56, 2, '2014-02-08 08:24:18', 3),
(55, 55, 1, '2014-02-08 08:25:12', 3),
(56, 55, 2, '2014-02-08 08:25:13', 3),
(57, 57, 1, '2014-02-08 08:41:26', 3),
(58, 57, 2, '2014-02-08 08:41:26', 3),
(59, 58, 1, '2014-02-08 08:59:56', 3),
(60, 58, 2, '2014-02-08 08:59:56', 3),
(61, 59, 1, '2014-02-08 09:03:03', 3),
(62, 59, 2, '2014-02-08 09:03:03', 3),
(63, 60, 1, '2014-02-08 09:21:43', 3),
(64, 60, 2, '2014-02-08 09:21:43', 3),
(65, 61, 1, '2014-02-08 09:24:43', 3),
(66, 61, 2, '2014-02-08 09:24:43', 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

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
(18, '50gm', '2014-02-04 05:33:55', 2),
(19, 'a', '2014-02-04 08:44:58', 2),
(20, '1 Tin', '2014-02-05 06:58:14', 3),
(21, '1.5ltr', '2014-02-06 10:41:24', 2);

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
