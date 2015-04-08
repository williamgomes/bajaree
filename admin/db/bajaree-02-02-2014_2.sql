-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 02, 2014 at 07:19 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_full_name`, `admin_email`, `admin_password`, `admin_hash`, `admin_type`, `admin_status`, `admin_last_login`, `admin_update`, `admin_updated_by`) VALUES
(0, 'System', 'system@bscheme.com', 'e10adc3949ba59abb#b1a2j1r1e2*e56e057f20f883e', 'qk6l2f2onu22kmeqoq1o0plum6', 'master', 'active', '2014-02-02 05:06:22', '2013-04-27 16:10:46', 0),
(1, 'Faruk', 'faruk@bscheme.com', 'e10adc3949ba59abb#b1a2j1r1e2*e56e057f20f883e', '51eh9plsbpflsjo5ec3sclgdl1', 'master', 'active', '2014-02-02 05:28:45', '2013-04-27 16:10:46', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`banner_id`, `banner_title`, `banner_image_name`, `banner_description`, `banner_priority`, `banner_url`, `banner_updated`, `banner_updated_by`) VALUES
(11, 'aaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaa-12.jpg', 'aaaaaaaaaaaaaaa', 333, 'http://facebrrrrrrrook.com', '2014-02-01 09:51:05', 1);

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
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_description`, `category_parent_id`, `category_priority`, `category_logo`, `category_updated`, `category_updated_by`) VALUES
(1, 'cat123', 'cat1 desc23', 2, 0, '', '2013-05-21 11:04:20', 1),
(2, 'Product 1', 'Product 1', 0, 0, '', '2013-05-26 08:48:25', 1),
(3, 'car', 'car', 0, 0, '', '2013-05-26 08:48:39', 1),
(4, 'Toyota', 'Toyota', 2, 0, '', '2013-05-26 08:48:49', 1),
(5, 'Test Category 1', 'Test Category 1', 0, 0, '', '2013-06-03 06:03:54', 1),
(6, 'AAss 123', 'AAss 123', 0, 0, '', '2013-06-03 11:05:03', 1),
(7, 'AAss !!!123', 'AAss 123', 0, 0, '', '2013-06-03 11:05:14', 1),
(8, 'cat123', 'cat123', 2, 0, '', '2013-06-04 10:31:15', 1),
(9, 'Toyota', 'Toyota', 0, 12, 'Toyota-1370342367.', '2013-06-04 10:39:27', 1),
(10, 'Toyota', 'Toyota', 7, 1, 'Toyota-1370342493.', '2013-06-04 10:41:33', 1),
(11, 'Product 1', 'Product 1', 7, 11, 'Product 1-1370342530.jpg', '2013-06-04 10:42:10', 1),
(12, 'Product 1', 'Product 1', 9, 1, 'Product 1-1370343130.jpg', '2013-06-04 10:52:10', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='category_banners = CB' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `category_banners`
--

INSERT INTO `category_banners` (`CB_id`, `CB_category_id`, `CB_image_name`, `CB_title`, `CB_priority`, `CB_description`, `CB_url`, `CB_url_type`, `CB_updated`, `CB_updated_by`) VALUES
(8, 5, 'Category-0_Time-1370254593.png', 'Test category banner 1', 0, 'Test category banner 1', 'http://www.car.com', 'external', '2013-06-03 10:16:33', 1),
(9, 0, 'Category-0_Time-1370323428.png', 'Product 1', 1, 'Product 1', 'http://Product 1', 'internal', '2013-06-04 05:23:48', 1),
(10, 2, 'Category-2_Time-1370333311.png', 'Product 1', 2, 'Product 1', 'http://Product 1', 'internal', '2013-06-04 08:08:31', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='category_promotion = CP' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `category_promotion`
--

INSERT INTO `category_promotion` (`CP_id`, `CP_category_id`, `CP_image_name`, `CP_title`, `CP_priority`, `CP_description`, `CP_url`, `CP_url_type`, `CP_updated`, `CP_updated_by`) VALUES
(8, 5, 'Category-0_Time-1370254593.png', 'Test category banner 1', 0, 'Test category banner 1', 'http://www.car.com', 'external', '2013-06-03 10:16:33', 1),
(9, 0, 'Category-0_Time-1370323428.png', 'Product 1', 1, 'Product 1', 'http://Product 1', 'internal', '2013-06-04 05:23:48', 1),
(10, 2, 'Category-2_Time-1370333311.png', 'Product 1', 2, 'Product 1', 'http://Product 1', 'internal', '2013-06-04 08:08:31', 1);

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
('SITE_NAME', 'SQ Group', '2014-02-01 04:58:41', '', 'yes'),
('SITE_URL', ' http://localhost/sq', '2014-02-01 04:58:51', '', 'yes'),
('SITE_LOGO', 'favicon.ico', '2014-02-01 04:58:59', '', 'yes'),
('SITE_FAVICON', 'DFGDFG', '2014-02-01 04:59:09', '', 'yes'),
('ALBUM_IMAGE_WIDTH', '1024', '0000-00-00 00:00:00', '', 'no'),
('CATEGORY_LOGO_WIDTH', '1024', '0000-00-00 00:00:00', '', 'no'),
('CLIENT_LOGO_WIDTH', '200', '2013-11-23 07:33:08', '', 'no'),
('SITE_DEFAULT_META_TITLE', 'title new', '0000-00-00 00:00:00', '', 'no'),
('SITE_DEFAULT_META_DESCRIPTION', 'description  new', '0000-00-00 00:00:00', '', 'no'),
('SITE_DEFAULT_META_KEYWORDS', 'key, words, new', '0000-00-00 00:00:00', '', 'no'),
('COMPANY_LOGO_WIDTH', '1024', '0000-00-00 00:00:00', '', 'no'),
('COMPANY_BANNER_WIDTH', '400', '0000-00-00 00:00:00', '', 'no'),
('PRODUCT_IMAGE_WIDTH', '1024', '0000-00-00 00:00:00', '', 'no'),
('TESTIMONIAL_IMAGE_WIDTH', '1024', '0000-00-00 00:00:00', '', 'no'),
('MENU_TITLE_CHARACTER_LIMIT', '10', '0000-00-00 00:00:00', '', 'no'),
('ALBUM_IMAGE_THUMB_WIDTH', '21024', '0000-00-00 00:00:00', '', 'no'),
('PARTNER_LOGO_WIDTH', '1024', '0000-00-00 00:00:00', '', 'no'),
('SMTP_SERVER_ADDRESS', 'a', '2013-11-19 07:26:37', '1', 'no'),
('EMAIL_ADDRESS_GENERAL', 'a', '2013-11-19 07:26:47', '1', 'no'),
('HOSTING_ID', 'a', '2013-11-19 07:26:58', '1', 'no'),
('HOSTING_PASS', 'a', '2013-11-19 07:27:10', '1', 'no'),
('SMTP_PORT_NO', 'a', '2013-11-19 07:27:17', '1', 'no'),
('POST_IMAGE_WIDTH', '200', '2013-11-19 07:34:24', '1', 'no'),
('MENU_TITLE_CHARACTER_LIMIT', '10', '2014-02-01 04:52:43', '', 'no');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`faq_id`, `faq_question`, `faq_answer`, `faq_priority`) VALUES
(12, 'what is nu', '&lt;div class=&quot;oneone&quot;&gt;&lt;div class=&quot;oneone&quot;&gt;&lt;div class=&quot;oneone&quot;&gt;&lt;p&gt;It is nothing&lt;/p&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;', 3),
(15, 'what should do now?', 'Go to Home.................now!!!!!!!!!!!!!!!!!!!!', 5),
(16, 'fghgfh', 'ghjfgjdfg', 786),
(17, 'fdgdfg', 'ghjgh', 7);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int(5) NOT NULL AUTO_INCREMENT,
  `menu_title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_title`) VALUES
(1, 'tfdtgh'),
(2, 'header');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `menu_url`
--

INSERT INTO `menu_url` (`MU_id`, `MU_menu_id`, `MU_url_title`, `MU_url`, `MU_priority`) VALUES
(1, 2, 'header', 'http://dfgd.com', 4),
(2, 2, 'footer', 'http://dfgd.com', 4),
(3, 2, 'center', 'http://dfgd.com', 4),
(4, 2, 'rhgrt', 'http://dfg34543d.com', 5);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_user_id`, `order_created`, `order_number`, `order_read`, `order_status`, `order_payment_type`, `order_total_item`, `order_total_amount`, `order_vat_amount`, `order_discount_amount`, `order_session_id`, `order_note`, `order_billing_first_name`, `order_billing_middle_name`, `order_billing_last_name`, `order_billing_phone`, `order_billing_best_call_time`, `order_billing_address`, `order_billing_country`, `order_billing_city`, `order_billing_zip`, `order_shipping_first_name`, `order_shipping_middle_name`, `order_shipping_last_name`, `order_shipping_phone`, `order_shipping_best_call_time`, `order_shipping_address`, `order_shipping_country`, `order_shipping_city`, `order_shipping_zip`, `order_updated_on`, `order_updated_by`) VALUES
(1, 18, '2013-07-21 14:54:14', 'OID.14552654', 'yes', 'delivered', 'Paypal', 7, 680.00, 0.00, 15.00, 'nre9gikqaqfo52pjcubtmthb51', '', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd', 'Bangladesh', 'Dhaka', '1214', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd', 'Bangladesh', 'Dhaka', '1214', '2013-07-23 07:42:02', 1),
(2, 18, '2013-07-21 14:56:27', 'OID.121215', 'yes', 'approved', 'Paypal', 7, 680.00, 0.00, 15.00, 'nre9gikqaqfo52pjcubtmthb51', '', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd', 'Bangladesh', 'Dhaka', '1214', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd', 'Bangladesh', 'Dhaka', '1214', '2013-07-25 07:03:11', 9),
(3, 18, '2013-07-21 14:56:45', '', 'yes', 'booking', 'Paypal', 7, 680.00, 0.00, 15.00, 'nre9gikqaqfo52pjcubtmthb51', '', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd', 'Bangladesh', 'Dhaka', '1214', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd', 'Bangladesh', 'Dhaka', '1214', '2013-07-21 08:56:45', 0),
(4, 18, '2013-07-21 14:57:24', '', 'yes', 'booking', 'Paypal', 7, 680.00, 0.00, 15.00, 'nre9gikqaqfo52pjcubtmthb51', '', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd', 'Bangladesh', 'Dhaka', '1214', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd', 'Bangladesh', 'Dhaka', '1214', '2013-07-21 08:57:24', 0),
(5, 18, '2013-07-21 15:01:57', '', 'yes', 'booking', 'Paypal', 7, 680.00, 0.00, 15.00, 'nre9gikqaqfo52pjcubtmthb51', '', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd', 'Bangladesh', 'Dhaka', '1214', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd', 'Bangladesh', 'Dhaka', '1214', '2013-07-21 09:01:57', 0),
(6, 18, '2013-07-25 17:37:47', '', 'no', 'booking', 'COD', 1, 70.00, 0.00, 0.00, 'uoh4sr9u4cggefb28jvgmfk3v2', '', 'asd', 'asd', 'asd', '123asd', '10:00 PM', 'aasd', 'Bangladesh', 'Dhaka', '123123', 'asd', 'asd', 'asd', '123asd', '10:00 PM', 'aasd', 'Bangladesh', 'Dhaka', '123123', '2013-07-25 11:37:47', 0),
(7, 18, '2013-07-27 09:47:53', '', 'no', 'booking', 'COD', 1, 150.00, 0.00, 0.00, '0ahm2cc55759ogsvq7d7hlitv5', '', 'William', '', 'Gomes', '1215141617', '10:00 AM', 'asdasdaweawe', 'Bangladesh', 'Dhaka', '1215', 'William', '', 'Gomes', '1215141617', '10:00 AM', 'asdasdaweawe', 'Bangladesh', 'Dhaka', '1215', '2013-07-27 03:47:53', 0),
(8, 18, '2013-07-27 10:09:26', '', 'no', 'booking', 'COD', 1, 150.00, 0.00, 0.00, '0ahm2cc55759ogsvq7d7hlitv5', 'I want to have this delivered after 5PM.', 'William', '', 'Gomes', '1215141617', '10:00 AM', 'asdasdaweawe', 'Bangladesh', 'Dhaka', '1215', 'William', '', 'Gomes', '1215141617', '10:00 AM', 'asdasdaweawe', 'Bangladesh', 'Dhaka', '1215', '2013-07-27 04:09:26', 0),
(9, 18, '2013-08-19 11:24:28', '', 'no', 'booking', 'COD', 3, 300.00, 0.00, 0.00, 'j39gb9u45so885dm61vedc02c0', '', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', '2013-08-19 05:24:28', 0),
(10, 18, '2013-12-05 14:00:01', '', 'yes', 'booking', 'COD', 3, 385.00, 0.00, 20.00, 'jlgjnmpcusmpdce2n875vcb4q2', '', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', '2013-12-07 09:00:16', 0),
(11, 18, '2014-01-16 11:24:55', '', 'no', 'booking', 'COD', 3, 250.00, 0.00, 0.00, '9d5h1o6p3clnimcmbq6bnplpt4', '', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', '2014-01-16 05:24:55', 0),
(12, 18, '2014-01-16 12:23:01', '', 'no', 'pending', 'Card', 4, 340.00, 0.00, 0.00, 'seps8a0mcjpitmjptdeqd6nn56', '', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', '2014-01-16 06:23:01', 0),
(13, 18, '2014-01-16 12:23:13', '', 'no', 'pending', 'Card', 4, 340.00, 0.00, 0.00, 'seps8a0mcjpitmjptdeqd6nn56', '', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', '2014-01-16 06:23:13', 0),
(14, 18, '2014-01-16 12:23:45', '', 'no', 'pending', 'Card', 4, 340.00, 0.00, 0.00, 'seps8a0mcjpitmjptdeqd6nn56', '', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', '2014-01-16 06:23:45', 0),
(15, 18, '2014-01-16 12:24:21', '', 'no', 'pending', 'Card', 4, 340.00, 0.00, 0.00, 'seps8a0mcjpitmjptdeqd6nn56', '', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', '2014-01-16 06:24:21', 0),
(16, 18, '2014-01-16 12:25:57', '', 'no', 'pending', 'Card', 4, 340.00, 0.00, 0.00, 'seps8a0mcjpitmjptdeqd6nn56', '', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', '2014-01-16 06:25:57', 0),
(17, 18, '2014-01-16 12:31:27', '', 'no', 'pending', 'Card', 4, 340.00, 0.00, 0.00, 'seps8a0mcjpitmjptdeqd6nn56', '', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', 'William', '', 'Gomes', '654164654', '', 'sasdasdasd0000000', 'Russia', 'kkk', '1214', '2014-01-16 06:31:27', 0),
(18, 19, '2014-01-22 16:37:41', '', 'no', 'pending', 'Card', 3, 250.00, 0.00, 0.00, 'qne2dilgnepeem5qfn31vcd4l0', '', 'William', '', 'Gomes', '11212121212', '', 'asdasdasdasd', 'Bangladesh', 'Dhaka', '1212', 'William', '', 'Gomes', '11212121212', '', 'asdasdasdasd', 'Bangladesh', 'Dhaka', '1212', '2014-01-22 10:37:41', 0),
(19, 19, '2014-01-22 16:40:15', '', 'no', 'pending', 'Card', 3, 250.00, 0.00, 0.00, 'qne2dilgnepeem5qfn31vcd4l0', '', 'William', '', 'Gomes', '11212121212', '', 'asdasdasdasd', 'Bangladesh', 'Dhaka', '1212', 'William', '', 'Gomes', '11212121212', '', 'asdasdasdasd', 'Bangladesh', 'Dhaka', '1212', '2014-01-22 10:40:15', 0),
(20, 19, '2014-01-22 17:14:24', '', 'no', 'pending', 'Card', 3, 250.00, 0.00, 0.00, 'qne2dilgnepeem5qfn31vcd4l0', '', 'William', '', 'Gomes', '11212121212', '', 'asdasdasdasd', 'Bangladesh', 'Dhaka', '1212', 'William', '', 'Gomes', '11212121212', '', 'asdasdasdasd', 'Bangladesh', 'Dhaka', '1212', '2014-01-22 11:14:24', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='OP= order_products' AUTO_INCREMENT=60 ;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`OP_id`, `OP_order_id`, `OP_user_id`, `OP_product_id`, `OP_product_inventory_id`, `OP_color_id`, `OP_size_id`, `OP_price`, `OP_discount`, `OP_product_quantity`, `OP_product_total_price`) VALUES
(1, 1, 18, 1, 0, 0, 0, 70.00, 0.00, 2, 140.00),
(2, 1, 18, 2, 0, 0, 0, 150.00, 0.00, 2, 300.00),
(3, 1, 18, 9, 0, 0, 0, 80.00, 5.00, 3, 240.00),
(4, 2, 18, 21, 0, 0, 0, 70.00, 0.00, 2, 140.00),
(5, 2, 18, 22, 0, 0, 0, 150.00, 0.00, 2, 300.00),
(6, 2, 18, 19, 0, 0, 0, 80.00, 5.00, 3, 240.00),
(7, 3, 18, 21, 0, 0, 0, 70.00, 0.00, 2, 140.00),
(8, 3, 18, 22, 0, 0, 0, 150.00, 0.00, 2, 300.00),
(9, 3, 18, 19, 0, 0, 0, 80.00, 5.00, 3, 240.00),
(10, 4, 18, 21, 0, 0, 0, 70.00, 0.00, 2, 140.00),
(11, 4, 18, 22, 0, 0, 0, 150.00, 0.00, 2, 300.00),
(12, 4, 18, 19, 0, 0, 0, 80.00, 5.00, 3, 240.00),
(13, 5, 18, 21, 0, 0, 0, 70.00, 0.00, 2, 140.00),
(14, 5, 18, 22, 0, 0, 0, 150.00, 0.00, 2, 300.00),
(15, 5, 18, 19, 0, 0, 0, 80.00, 5.00, 3, 240.00),
(16, 6, 18, 21, 0, 0, 0, 70.00, 0.00, 1, 70.00),
(17, 7, 18, 22, 0, 0, 0, 150.00, 0.00, 1, 150.00),
(18, 8, 18, 22, 0, 0, 0, 150.00, 0.00, 1, 150.00),
(19, 9, 18, 19, 0, 0, 0, 80.00, 0.00, 1, 80.00),
(20, 9, 18, 21, 0, 0, 0, 70.00, 0.00, 1, 70.00),
(21, 9, 18, 22, 0, 0, 0, 150.00, 0.00, 1, 150.00),
(22, 10, 18, 9, 0, 0, 0, 65.00, 0.00, 1, 65.00),
(23, 10, 18, 1, 0, 0, 0, 160.00, 10.00, 2, 320.00),
(24, 11, 18, 10, 0, 0, 0, 85.00, 0.00, 1, 85.00),
(25, 11, 18, 9, 0, 0, 0, 65.00, 0.00, 1, 65.00),
(26, 11, 18, 11, 0, 0, 0, 100.00, 0.00, 1, 100.00),
(27, 12, 18, 11, 0, 0, 0, 100.00, 0.00, 1, 100.00),
(28, 12, 18, 10, 0, 0, 0, 85.00, 0.00, 1, 85.00),
(29, 12, 18, 9, 0, 0, 0, 65.00, 0.00, 1, 65.00),
(30, 12, 18, 12, 0, 0, 0, 90.00, 0.00, 1, 90.00),
(31, 13, 18, 11, 0, 0, 0, 100.00, 0.00, 1, 100.00),
(32, 13, 18, 10, 0, 0, 0, 85.00, 0.00, 1, 85.00),
(33, 13, 18, 9, 0, 0, 0, 65.00, 0.00, 1, 65.00),
(34, 13, 18, 12, 0, 0, 0, 90.00, 0.00, 1, 90.00),
(35, 14, 18, 11, 0, 0, 0, 100.00, 0.00, 1, 100.00),
(36, 14, 18, 10, 0, 0, 0, 85.00, 0.00, 1, 85.00),
(37, 14, 18, 9, 0, 0, 0, 65.00, 0.00, 1, 65.00),
(38, 14, 18, 12, 0, 0, 0, 90.00, 0.00, 1, 90.00),
(39, 15, 18, 11, 0, 0, 0, 100.00, 0.00, 1, 100.00),
(40, 15, 18, 10, 0, 0, 0, 85.00, 0.00, 1, 85.00),
(41, 15, 18, 9, 0, 0, 0, 65.00, 0.00, 1, 65.00),
(42, 15, 18, 12, 0, 0, 0, 90.00, 0.00, 1, 90.00),
(43, 16, 18, 11, 0, 0, 0, 100.00, 0.00, 1, 100.00),
(44, 16, 18, 10, 0, 0, 0, 85.00, 0.00, 1, 85.00),
(45, 16, 18, 9, 0, 0, 0, 65.00, 0.00, 1, 65.00),
(46, 16, 18, 12, 0, 0, 0, 90.00, 0.00, 1, 90.00),
(47, 17, 18, 11, 0, 0, 0, 100.00, 0.00, 1, 100.00),
(48, 17, 18, 10, 0, 0, 0, 85.00, 0.00, 1, 85.00),
(49, 17, 18, 9, 0, 0, 0, 65.00, 0.00, 1, 65.00),
(50, 17, 18, 12, 0, 0, 0, 90.00, 0.00, 1, 90.00),
(51, 18, 19, 9, 0, 0, 0, 65.00, 0.00, 1, 65.00),
(52, 18, 19, 10, 0, 0, 0, 85.00, 0.00, 1, 85.00),
(53, 18, 19, 11, 0, 0, 0, 100.00, 0.00, 1, 100.00),
(54, 19, 19, 9, 0, 0, 0, 65.00, 0.00, 1, 65.00),
(55, 19, 19, 10, 0, 0, 0, 85.00, 0.00, 1, 85.00),
(56, 19, 19, 11, 0, 0, 0, 100.00, 0.00, 1, 100.00),
(57, 20, 19, 9, 0, 0, 0, 65.00, 0.00, 1, 65.00),
(58, 20, 19, 10, 0, 0, 0, 85.00, 0.00, 1, 85.00),
(59, 20, 19, 11, 0, 0, 0, 100.00, 0.00, 1, 100.00);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `page_url`, `page_title`, `page_short_description`, `page_body`, `page_meta_title`, `page_meta_description`, `page_meta_keywords`, `page_priority`, `page_type`) VALUES
(6, 'http://testserver.bscheme.com/tuizo/returns.php', 'returns', 'All merchandise must be returned in the original selling condition with all tags attached.\r\nMerchandise may be returned for a refund to your credit card within 30 days of the order being shipped\r\nfrom our fulfillment center. To ensure timely processing, please include return form with the item. A $7.00\r\nreturn fee will be deducted from the refund amount. Merchandise received as a gift may be returned for a full refund in the form of an online coupon.\r\nFinal sale, altered items, innerwear, opened', '<div class="oneone"><div class="oneone"><div class="cartContainnerLft returnContainer ">\r\n                               \r\n\r\n                                	<h1 class="x-large">return</h1>\r\n                                       <div class="scrollContent">\r\n                                    <h6>Online Returns:</h6>\r\n                                       \r\n                                    <p>All merchandise must be returned in the original selling condition with all tags attached.<br>\r\n\r\nMerchandise may be returned for a refund to your credit card within 30 days of the order being shipped<br> from our fulfillment center. To ensure timely processing, please include return form with the item. A $7.00<br> return fee will be deducted from the refund amount.\r\n\r\nMerchandise received as a gift may be returned for a full refund in the form of an online coupon.<br>\r\n\r\nFinal sale, altered items, innerwear, opened packaged items, and any item $7.00 or less are non-returnable at this time.<br>\r\n\r\nPrice adjustments will not be honored for online shopping.<br>\r\n\r\nItems purchased outside of the U.S. are not eligible for returns.</p>\r\n										<h6>In-Store Returns:</h6>\r\n                                        <p>All merchandise must be returned in the original selling condition with all tags attached.<br>\r\n\r\nYou can return your online purchase to any tuizo store with your shipping receipt within 30 days of the<br>\r\n order being shipped from our fulfillment center. At this time, we can only accept actual shipping receipt<br>\r\n enclosed in the package. We cannot accept electronic version of the shipping receipt. You will be given the<br>\r\n option to exchange the item or receive a refund.\r\n\r\nAny returns made without a shipping receipt will require a photo ID and will be reimbursed with a store<br>\r\n credit. The in-store price will be applied to all returns without a receipt.\r\n\r\nAltered items, inner wear and opened packaged items may not be returned or exchanged at any time.<br>\r\n\r\n\r\nItems purchased outside of the U.S. are not eligible for returns.</p></div>\r\n                                </div><!--cartContainnerLft--></div></div>', 'Tuizo | Returns', 'All merchandise must be returned in the original selling condition with all tags attached.\r\nMerchandise may be returned for a refund to your credit card within 30 days of the order being shipped\r\nfrom our fulfillment center. To ensure timely processing, please include return form with the item. A $7.00\r\nreturn fee will be deducted from the refund amount. Merchandise received as a gift may be returned for a full refund in the form of an online coupon.\r\nFinal sale, altered items, innerwear, opened packaged items, and any item $7.00 or less are non-returnable at this time.\r\nPrice adjustments will not be honored for online shopping.\r\nItems purchased outside of the U.S. are not eligible for returns.', 'tuizo, shop, online shopping.', 5, 'user-created'),
(7, 'http://testserver.bscheme.com/tuizo/about.php', 'about', 'It doesn''t matter who you are or where you live, TUIZO makes clothes that transcend all categories and social groups. Our clothes are made for all, going beyond age, gender, occupation, ethnicity, and all other ways that define people. Our clothes are simple and essential yet universal, so people can freely combine them in their own unique style. \r\n\r\nOnline clothing has just been tweaked!!!', '        <div style="margin:0 auto;" class="aboutContainer fullContainer">\r\n          <div class="innerScroll">\r\n            <div class="aboutTop">\r\n    \r\n              <p>\r\n            Tuizo is an online venture from Bluescheme in collaboration with Fashion ID. The idea is simple, we sell trendy &amp; stylish products  from different brands and we sell them in combinations. If you want to live and breathe style tuizo.com offers a way out.\r\n              </p>\r\n              \r\n              <div class="aboutTopImg">\r\n                <a href="#">\r\n                  <img src="http://tuizo.com/upload/file_manager/about/1.jpg" alt="blog">\r\n                </a>\r\n                <a href="#">\r\n                  <img src="http://tuizo.com/upload/file_manager/about/2.jpg" alt="#">\r\n                </a>\r\n                <a href="#">\r\n                  <img src="http://tuizo.com/upload/file_manager/about/3.jpg" alt="#">\r\n                </a>\r\n                <a href="#">\r\n                  <img src="http://tuizo.com/upload/file_manager/about/4.jpg" alt="#">\r\n                </a>\r\n              </div>\r\n              <!--aboutTopImg-->\r\n            </div>\r\n            <!--aboutTop-->\r\n            \r\n            \r\n            <!--aboutTop-->\r\n            <div class="tuizoNews">\r\n              <h1 class="x-large">\r\n                tuizo news\r\n              </h1>\r\n              <div class="NewsBox">\r\n                <img src="http://tuizo.com/upload/file_manager/about/news1.jpg" alt="news" align="left" height="160" width="260">\r\n                <h6>\r\n                  Tuizo Launches\r\n                </h6>\r\n                <span>\r\n                  October 5, 2013\r\n                </span>\r\n                <p>\r\n                  Tuizo.com launches a new clothing platform where different brands of clothes are made available in combinations. Users online can now pick any style and then choose from a wide range of products to complete each style. Products are priced under a range of combinations or styles. They are currently available for delivery all around the city in Dhaka, however nationwide delivery will be offered very soon. Also international shipping will be offered very soon with shipping partners.<br>Tuizo.com- Online Clothing has just been tweaked!.\r\n                </p>\r\n              </div>\r\n              <!--NewsBox-->\r\n             \r\n              \r\n            </div>\r\n            <!--tuizoNews-->\r\n          </div>\r\n        </div>\r\n        <!--aboutContainer-->', 'Tuizo | About Us', 'It doesn''t matter who you are or where you live, TUIZO makes clothes that transcend all categories and social groups. Our clothes are made for all, going beyond age, gender, occupation, ethnicity, and all other ways that define people. Our clothes are simple and essential yet universal, so people can freely combine them in their own unique style. ', 'tuizo, shop, online shopping.', 5, 'user-created'),
(8, 'http://testserver.bscheme.com/tuizo/conditions.php', 'conditions', 'Tuizo.com Terms and Conditions', '<div class="innerScrollfaq">      \r\n                                   <h6>Acceptance of the use Tuizo.com Terms and Conditions</h6>\r\n                                    <p>Your access to and use of Tuizo.com is subject exclusively to these Terms and Conditions. You will not use the Website for any purpose that is unlawful or prohibited by these Terms and Conditions. By using the Website you are fully accepting the terms, conditions and disclaimers contained in this notice. If you do not accept these Terms and Conditions you must immediately stop using the Website.</p>\r\n                                    \r\n										<h6>Advice</h6>\r\n                                        <p>The contents of Tuizo.com website do not constitute advice and should not be relied upon in making or refraining from making, any decision.</p>\r\n                                        \r\n                                        <h6>Change of Use</h6>\r\n<p>Tuizo.com reserves the right to:</p>\r\n<p>1.1  change or remove (temporarily or permanently) the Website or any part of it without notice and you confirm that Tuizo.com shall not be liable to you for any such change or removal and.</p>\r\n<p>1.2  change these Terms and Conditions at any time, and your continued use of the Website following any changes shall be deemed to be your acceptance of such change.\r\n</p>\r\n                                        \r\n                                        <h6>Links to Third Party Websites</h6>\r\n                                        <p>Tuizo.com Website may include links to third party websites that are controlled and maintained by others. Any link to other websites is not an endorsement of such websites and you acknowledge and agree that we are not responsible for the content or availability of any such sites.</p>\r\n                                        \r\n                                        <h6>Copyright</h6>\r\n                                        <p>2.1  All copyright, trademarks and all other intellectual property rights in the Website and its content (including without limitation the Website design, text, graphics and all software and source codes connected with the Website) are owned by or licensed to Tuizo.com or otherwise used by Tuizo.com as permitted by law.</p>\r\n<p>2.2  In accessing the Website you agree that you will access the content solely for your personal, non-commercial use. None of the content may be downloaded, copied, reproduced, transmitted, stored, sold or distributed without the prior written consent of the copyright holder. This excludes the downloading, copying and/or printing of pages of the Website for personal, non-commercial home use only.\r\n</p>\r\n                                        \r\n                                        <h6>Disclaimers and Limitation of Liability</h6>\r\n                                        <p>3.1  The Website is provided on an AS IS and AS AVAILABLE basis without any representation or endorsement made and without warranty of any kind whether express or implied, including but not limited to the implied warranties of satisfactory quality, fitness for a particular purpose, non-infringement, compatibility, security and accuracy.</p>\r\n<p>3.2  To the extent permitted by law, Tuizo.com will not be liable for any indirect or consequential loss or damage whatever (including without limitation loss of business, opportunity, data, profits) arising out of or in connection with the use of the Website.</p>\r\n<p>3.3  Tuizo.com makes no warranty that the functionality of the Website will be uninterrupted or error free, that defects will be corrected or that the Website or the server that makes it available are free of viruses or anything else which may be harmful or destructive.</p>\r\n<p>3.4  Nothing in these Terms and Conditions shall be construed so as to exclude or limit the liability of Tuizo.com for death or personal injury as a result of the negligence of Tuizo.com or that of its employees or agents.\r\n</p>\r\n                                        \r\n                                        <h6>Indemnity</h6>\r\n                                        <p>You agree to indemnify and hold Tuizo.com and its employees and agents harmless from and against all liabilities, legal fees, damages, losses, costs and other expenses in relation to any claims or actions brought against Tuizo.com arising out of any breach by you of these Terms and Conditions or other liabilities arising out of your use of this Website.</p>\r\n                                        \r\n                                        <h6>Severance</h6>\r\n                                        <p>If any of these Terms and Conditions should be determined to be invalid, illegal or unenforceable for any reason by any court of competent jurisdiction then such Term or Condition shall be severed and the remaining Terms and Conditions shall survive and remain in full force and effect and continue to be binding and enforceable.</p>\r\n                                \r\n                                <h6>Governing Law</h6>\r\n                                        <p>These Terms and Conditions shall be governed by and construed in accordance with the laws of Bangladesh and you hereby submit to the exclusive jurisdiction of Bangladesh courts.\r\n</p>   \r\n                                        </div>', 'Tuizo | Conditions', 'Your access to and use of Tuizo.com is subject exclusively to these Terms and Conditions. You will not use the Website for any purpose that is unlawful or prohibited by these Terms and Conditions. By using the Website you are fully accepting the terms, conditions and disclaimers contained in this notice. If you do not accept these Terms and Conditions you must immediately stop using the Website.', 'tuizo, shop, online shopping.', 5, 'user-created'),
(9, 'http://testserver.bscheme.com/tuizo/pivacy.php', 'privacy', 'Tuizo.com Privacy Policy', '<div class="innerScrollfaq">      \r\n                                    <p>This Privacy Policy governs the manner in which Tuizo.com collects, uses, maintains and discloses information collected from users (each, a "User") of the tuizo.com website ("Site"). This privacy policy applies to the Site and all products and services offered by Tuizo.com.</p>\r\n                                    \r\n										<h6>Personal Identification Information</h6>\r\n                                        <p>We may collect personal identification information from Users in a variety of ways, including, but not limited to, when Users visit our site, register on the siteplace an orderfill out a formsubscribe to the newsletter and in connection with other activities, services, features or resources we make available on our Site. Users may be asked for, as appropriate, name, email address, mailing address, and/or phone number.</p>\r\n<p>Users may, however, visit our Site anonymously.</p>\r\n<p>We will collect personal identification information from Users only if they voluntarily submit such information to us. Users can always refuse to supply personally identification information, except that it may prevent them from engaging in certain Site related activities.</p>\r\n                                        \r\n                                        <h6>Non-personal identification information</h6>\r\n<p>We may collect non-personal identification information about Users whenever they interact with our Site. Non-personal identification information may include the browser name, the type of computer and technical information about Users means of connection to our Site, such as the operating system and the Internet service providers utilized and other similar information.\r\n</p>\r\n                                        \r\n                                        <h6>Web browser cookies</h6>\r\n                                        <p>Our Site may use "cookies" to enhance User experience. User''s web browser places cookies on their hard drive for record-keeping purposes and sometimes to track information about them. User may choose to set their web browser to refuse cookies, or to alert you when cookies are being sent. If they do so, note that some parts of the Site may not function properly.</p>\r\n                                        \r\n                                        <h6>How we use collected information</h6>\r\n                                        <p>Tuizo.com collects and uses Users personal information for the following purposes:</p>\r\n<p><i>To improve customer service</i></p>\r\n<p>Your information helps us to more effectively respond to your customer service requests and support needs.</p>\r\n<p><i>To personalize user experience</i></p>\r\n<p>We may use information in the aggregate to understand how our Users as a group use the services and resources provided on our Site.</p>\r\n<p><i>To improve our Site</i></p>\r\n<p>We continually strive to improve our website offerings based on the information and feedback we receive from you.</p>\r\n<p><i>To process transactions</i></p>\r\n<p>We may use the information Users provide about themselves when placing an order only to provide service to that order. We do not share this information with outside parties except to the extent necessary to provide the service.</p>\r\n<p><i>To administer a content, promotion, survey or other Site feature</i></p>\r\n<p>To send Users information they agreed to receive about topics we think will be of interest to them.</p>\r\n<p><i>To send periodic emails</i></p>\r\n<p>The email address Users provide for order processing, will only be used to send them information and updates pertaining to their order. It may also be used to respond to their inquiries, and/or other requests or questions. If User decides to opt-in to our mailing list, they will receive emails that may include company news, updates, related product or service information, etc. If at any time the User would like to unsubscribe from receiving future emails, we include detailed unsubscribe instructions at the bottom of each email or User may contact us via our Site.</p>\r\n                                        \r\n                                        <h6>How we protect your information</h6>\r\n                                        <p>We adopt appropriate data collection, storage and processing practices and security measures to protect against unauthorized access, alteration, disclosure or destruction of your personal information, username, password, transaction information and data stored on our Site.</p>\r\n                                        \r\n                                        <h6>Changes to this privacy policy</h6>\r\n                                        <p>Tuizo.com has the discretion to update this privacy policy at any time. When we do, post a notification on the main page of our Site,revise the updated date at the bottom of this page,send you an email. We encourage Users to frequently check this page for any changes to stay informed about how we are helping to protect the personal information we collect. You acknowledge and agree that it is your responsibility to review this privacy policy periodically and become aware of modifications.</p>\r\n                                        \r\n                                        <h6>Your acceptance of these terms</h6>\r\n                                        <p>By using this Site, you signify your acceptance of this policy and terms of service. If you do not agree to this policy, please do not use our Site. Your continued use of the Site following the posting of changes to this policy will be deemed your acceptance of those changes.</p>\r\n                                \r\n                                <h6>Legal Action</h6>\r\n                                        <p>The User''s Personal Data may be used for legal purposes by the Data Controller, in Court or in the stages leading to possible legal action arising from improper use of this Application or the related services.\r\n</p>   \r\n\r\n<h6>Additional Information about User''s Personal Data</h6>\r\n                                        <p>In addition to the information in this privacy policy, this Application may provide the User with contextual information concerning particular services or the collection and processing of Personal Data.\r\n</p>   \r\n\r\n<h6>System Logs and Maintenance</h6>\r\n                                        <p>For operation and maintenance purposes, this Application and any third party services may collect files that record interaction with this Application (System Logs) or use for this purpose other Personal Data (such as IP Address).\r\n</p>   \r\n\r\n<h6>The rights of Users</h6>\r\n                                        <p>Users have the right, at any time, to know whether their Personal Data has been stored and can consult the Data Controller to learn about their contents and origin, to verify their accuracy or to ask for them to be supplemented, cancelled, updated or corrected, or for their transformation into anonymous format or to block any data held in violation of the law, as well as to oppose their treatment for any and all legitimate reasons. Requests should be sent to the Data Controller at the contact information set out above.\r\n</p>   \r\n\r\n<h6>Contacting us</h6>\r\n                                        <p>If you have any questions about this Privacy Policy, the practices of this site, or your dealings with this site, please contact us at:\r\n</p>   \r\n<p>Tuizo</p><p>Suite - 1C, House 3B</p><p>Road 49<br></p><p>Gulshan-2</p><p>Dhaka-1212, Bangladesh</p><p>+8801966776655</p><p>info@tuizo.com</p>\r\n                                        </div>', 'Tuizo | Privacy Policy', 'Your access to and use of Tuizo.com is subject exclusively to these Terms and Conditions. You will not use the Website for any purpose that is unlawful or prohibited by these Terms and Conditions. By using the Website you are fully accepting the terms, conditions and disclaimers contained in this notice. If you do not accept these Terms and Conditions you must immediately stop using the Website.', 'tuizo, shop, online shopping.', 5, 'built-in'),
(10, 'http://testserver.bscheme.com/tuizo/delivery.php', 'delivery', 'Tuizo.com Delivery', '<div class="innerScrollfaq">      \r\n                                   <h6>Standard Shipping</h6>\r\n                                    <p>Note that all items on Tuizo qualify for free shipping. For shipments outside Dhaka, items may carry an additional fee and will be noted on the checkout page.</p>\r\n\r\n<h6>FREE Shipping</h6>\r\n<p>Free shipping is determined based on the merchandise subtotal before tax, excluding gift cards, handling fees, and home delivery. Free shipping applies for standard shipping only.</p>\r\n                                    \r\n										<h6>Expedited Shipping</h6>\r\n                                        <p>Most orders deliver in 1 to 3 working days. To guarantee faster delivery, we also offer expedited shipping on select items.</p>\r\n               \r\n                                        </div>', 'Tuizo | Delivery', 'Your access to and use of Tuizo.com is subject exclusively to these Terms and Conditions. You will not use the Website for any purpose that is unlawful or prohibited by these Terms and Conditions. By using the Website you are fully accepting the terms, conditions and disclaimers contained in this notice. If you do not accept these Terms and Conditions you must immediately stop using the Website.', 'tuizo, shop, online shopping.', 5, 'built-in');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='weight will be gram' AUTO_INCREMENT=12 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_sku`, `product_short_description`, `product_long_description`, `product_meta_title`, `product_meta_keywords`, `product_meta_description`, `product_quantity`, `product_weight`, `product_cost`, `product_price`, `product_avg_rating`, `product_discount_price`, `product_show_as_new_from`, `product_show_as_new_to`, `product_show_as_featured_from`, `product_show_as_featured_to`, `product_status`, `product_total_viewed`, `product_tatal_sale`, `product_tax_class_id`, `product_updated`, `product_updated_by`) VALUES
(1, 'One ', '1122', 'my short description', 'my long description', 'asdad111', 'asdads23123', 'asdasda1111', 0, 0, 1, 1234, 4, 123, '2013-11-01', '2013-11-15', '1970-01-01', '1970-01-01', 'active', 0, 0, 0, '2013-05-14 04:14:59', 1),
(2, 'two', '125', 'short description', 'description dwo ', 'asdad111', 'asdads23123', 'asdasda1111', 0, 0, 1, 1234, 0, 123, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'active', 0, 0, 0, '2013-05-14 04:17:45', 1),
(3, 'rwerwe', 'rwerwe', 'qweqwe', 'rewrew', 'asdad111', 'asdads23123', 'asdasda1111', 0, 0, 1, 1234, 0, 123, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'active', 0, 0, 0, '2013-05-18 05:16:01', 1),
(4, 'ewr', 'wer', '', 'wer', 'asdad111', 'asdads23123', 'asdasda1111', 0, 0, 1, 1234, 0, 123, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'active', 0, 0, 0, '2013-05-18 06:18:02', 1),
(5, 'asdasda', 'sdasdasd', '', 'asdasddasda', 'asdad111', 'asdads23123', 'asdasda1111', 0, 0, 1, 1234, 0, 123, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'active', 0, 0, 0, '2013-05-20 10:19:31', 1),
(6, 'qwqw', 'qwqw', '', 'qwqw', 'asdad111', 'asdads23123', 'asdasda1111', 0, 0, 1, 1234, 0, 123, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'active', 0, 0, 0, '2013-05-20 10:26:05', 1),
(7, 'qwqw1', 'wewe1', '', 'wewe2', 'asdad111', 'asdads23123', 'asdasda1111', 0, 0, 1, 1234, 0, 123, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'active', 0, 0, 0, '2013-05-21 06:54:11', 1),
(8, 'dsdfsdf', 'asdad123!!', '', 'sdfsf', 'asdad111', 'asdads23123', 'asdasda1111', 0, 0, 1, 1234, 0, 123, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'active', 0, 0, 0, '2013-05-21 08:31:16', 1),
(9, 'asdasda', 'ABCE123456', '', 'qweqwe', 'asdad111', 'asdads23123', 'asdasda1111', 0, 0, 1, 1234, 0, 123, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'active', 0, 0, 0, '2013-05-21 08:50:38', 1),
(10, 'asda', 'ABCD123456', '', 'asdasd', 'asdad111', 'asdads23123', 'asdasda1111', 0, 0, 1, 1234, 0, 123, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'inactive', 0, 0, 0, '2013-05-22 06:51:06', 1),
(11, 'Test Product 11', 'ABCD123456', 'Short description', 'Test Product 11', 'asdad111', 'asdads23123', 'asdasda1111', 0, 0, 1, 1234, 0, 123, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'active', 0, 0, 0, '2013-05-30 08:09:48', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='products_related = PR' AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='products_upsell = PU' AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='product_also_like = PAL' AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='product_categories = PC' AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PI = product_images' AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PI = product_inventories' AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PIL=product_inventory_log' AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='product_sizes (specific sizes which show frontend)' AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PT = product_tags' AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`size_id`, `size_title`, `size_updated`, `size_updated_by`) VALUES
(1, '30-45', '2013-04-29 08:36:17', 1),
(2, '40-41', '2013-04-29 08:37:26', 1),
(4, '20-21', '2013-04-29 08:45:39', 1),
(5, '20-25', '2013-04-30 06:52:00', 1),
(6, '40-41', '2013-06-03 08:17:59', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_title`, `tag_updated`, `tag_updated_by`) VALUES
(1, 'asdad2232342342', '2013-04-28 05:07:43', 1),
(2, 'asdasdasd', '2013-04-29 05:43:03', 1),
(3, 'asdasdggrrgrrrgrg', '2013-04-29 05:49:05', 1),
(4, 'asda,asdasasd,asdad', '2013-04-29 06:10:47', 1),
(6, 'asdasd', '2013-04-29 06:32:53', 1),
(7, 'dasdasda', '2013-04-30 06:42:46', 1),
(8, 'asdasdasdasdasdasd', '2013-04-30 06:48:17', 1),
(9, 'asdasdad', '2013-05-20 10:18:57', 1);

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
(1, 'asda', 19, '2013-04-30 08:31:43', 1),
(2, 'ewr', 10, '2013-04-30 08:37:00', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='empty regularly using cron, TC= temp_carts' AUTO_INCREMENT=88 ;

--
-- Dumping data for table `temp_carts`
--

INSERT INTO `temp_carts` (`TC_id`, `TC_session_id`, `TC_user_id`, `TC_product_id`, `TC_price`, `TC_per_unit_discount`, `TC_discount_amount`, `TC_product_quantity`, `TC_product_total_price`, `TC_created`) VALUES
(1, '8jlh4iindvm7gn7j8cabp0g176', 0, 21, 70, 0, 0, 1, 70, '2013-08-16 05:22:53'),
(2, 'qt7lpp191nhpderglbp4r4aoj4', 0, 19, 80, 0, 0, 1, 80, '2013-08-16 05:42:22'),
(3, 'qt7lpp191nhpderglbp4r4aoj4', 0, 21, 70, 0, 0, 1, 70, '2013-08-16 05:42:22'),
(4, 'qt7lpp191nhpderglbp4r4aoj4', 0, 22, 150, 0, 0, 20, 3000, '2013-08-16 05:42:23'),
(5, 'vtvdla5jf1cei7dqpp2fo0r871', 0, 21, 70, 0, 0, 1, 70, '2013-08-16 05:55:23'),
(6, '9hut8uau4tp033krd5a7qp6kf3', 18, 21, 70, 0, 0, 1, 70, '2013-08-19 04:41:07'),
(7, '9hut8uau4tp033krd5a7qp6kf3', 18, 22, 150, 0, 0, 1, 150, '2013-08-19 04:41:07'),
(8, '9hut8uau4tp033krd5a7qp6kf3', 18, 19, 80, 0, 0, 1, 80, '2013-08-19 04:41:09'),
(9, 'bcaiorr33blrshdqu3blq9f4k4', 18, 22, 150, 0, 0, 18, 2700, '2013-08-19 04:41:46'),
(10, 'bcaiorr33blrshdqu3blq9f4k4', 18, 21, 70, 0, 0, 1, 70, '2013-08-19 04:41:46'),
(11, 'bcaiorr33blrshdqu3blq9f4k4', 18, 19, 80, 0, 0, 1, 80, '2013-08-19 04:41:47'),
(12, 'j39gb9u45so885dm61vedc02c0', 18, 19, 80, 0, 0, 1, 80, '2013-08-19 05:24:13'),
(13, 'j39gb9u45so885dm61vedc02c0', 18, 21, 70, 0, 0, 1, 70, '2013-08-19 05:24:14'),
(14, 'j39gb9u45so885dm61vedc02c0', 18, 22, 150, 0, 0, 1, 150, '2013-08-19 05:24:15'),
(15, 'n37t1ll4nrp38s9q85gjatr1a1', 0, 22, 150, 0, 0, 20, 3000, '2013-08-20 10:47:05'),
(16, 'n37t1ll4nrp38s9q85gjatr1a1', 0, 21, 70, 0, 0, 13, 910, '2013-08-20 10:47:12'),
(17, 'n37t1ll4nrp38s9q85gjatr1a1', 0, 19, 80, 0, 0, 7, 560, '2013-08-20 10:47:17'),
(18, 'ckutgdet9sep6q43am9epqu1r5', 0, 22, 150, 0, 0, 20, 3000, '2013-08-20 10:51:26'),
(19, 'ckutgdet9sep6q43am9epqu1r5', 0, 21, 70, 0, 0, 1, 70, '2013-08-20 10:51:29'),
(20, 'ckutgdet9sep6q43am9epqu1r5', 0, 19, 80, 0, 0, 1, 80, '2013-08-20 10:51:31'),
(21, 'n37t1ll4nrp38s9q85gjatr1a1', 0, 17, 125, 0, 0, 8, 1000, '2013-08-20 11:20:43'),
(22, 'fu4mdlel7idbq4pajard5tk404', 0, 1, 120, 0, 0, 2, 240, '2013-08-21 05:58:19'),
(23, 'fu4mdlel7idbq4pajard5tk404', 0, 3, 500, 0, 0, 3, 1500, '2013-08-21 05:58:35'),
(24, 'cdi9mgdn2jumv7lo6amup9omu5', 19, 22, 150, 0, 0, 1, 150, '2013-09-09 11:19:31'),
(25, 'cdi9mgdn2jumv7lo6amup9omu5', 19, 21, 70, 0, 0, 1, 70, '2013-09-09 11:19:35'),
(26, 'cdi9mgdn2jumv7lo6amup9omu5', 19, 19, 80, 0, 0, 1, 80, '2013-09-09 11:19:36'),
(27, 'o8u4rk9k2gq6bivtjq260ldlh6', 0, 19, 80, 0, 0, 2, 160, '2013-09-09 12:33:53'),
(28, 'o8u4rk9k2gq6bivtjq260ldlh6', 0, 21, 70, 0, 0, 2, 140, '2013-09-09 12:33:53'),
(29, 'o8u4rk9k2gq6bivtjq260ldlh6', 0, 22, 150, 0, 0, 2, 300, '2013-09-09 12:33:54'),
(30, '0c9dtna925vagbcgoaef2dq010', 0, 1, 120, 0, 0, 1, 120, '2013-09-10 08:16:02'),
(31, 'ie1nrp1nf095lui9bgo85o4qb5', 0, 22, 150, 0, 0, 1, 150, '2013-09-11 07:43:23'),
(32, 'ie1nrp1nf095lui9bgo85o4qb5', 0, 21, 70, 0, 0, 1, 70, '2013-09-11 07:43:24'),
(33, 'ec5b8b8b1021821a0b287dfbb2ba2f74', 0, 5, 225, 0, 0, 1, 225, '2013-09-22 05:08:49'),
(34, '67e8ebe32c2a386916329c0f0739ff40', 0, 12, 90, 0, 0, 1, 90, '2013-09-23 12:14:52'),
(36, '659e3e48b9eaa40b09fdfc3b563dcff2', 0, 12, 90, 0, 0, 1, 90, '2013-09-24 09:50:30'),
(37, 'b3dba1586f9e975c60084d929c290c97', 0, 10, 85, 0, 0, 3, 255, '2013-09-24 12:05:43'),
(39, '7085f0a2f6a3063a12e1b2ba6dee454a', 0, 10, 85, 0, 0, 10, 850, '2013-09-26 11:03:52'),
(40, '7085f0a2f6a3063a12e1b2ba6dee454a', 0, 9, 65, 0, 0, 1, 65, '2013-09-26 11:03:57'),
(41, '7085f0a2f6a3063a12e1b2ba6dee454a', 0, 11, 100, 0, 0, 1, 100, '2013-09-26 11:04:06'),
(42, '7085f0a2f6a3063a12e1b2ba6dee454a', 0, 12, 90, 0, 0, 1, 90, '2013-09-26 11:04:58'),
(43, '14d70a72a47d0f71f5fc7930d9cab5f6', 0, 10, 85, 0, 0, 1, 85, '2013-10-01 05:16:56'),
(44, '7a98b1d5266ead0f009ab594942c9f51', 0, 11, 100, 0, 0, 1, 100, '2013-10-02 04:19:46'),
(45, '586ed5e81deb3a78a40961d466bbb8ae', 0, 11, 100, 0, 0, 1, 100, '2013-10-03 13:35:22'),
(46, '86690c85724715716f4325c462ca5588', 0, 10, 85, 0, 0, 1, 85, '2013-10-03 13:46:11'),
(47, '86690c85724715716f4325c462ca5588', 0, 11, 100, 0, 0, 1, 100, '2013-10-03 13:46:11'),
(48, '9cfc30d24a2d2c89c28f201fe7ca759a', 0, 3, 220, 0, 0, 1, 220, '2013-10-07 15:27:17'),
(51, 'c0ba93694c6d8d0991a5dd72789154b6', 0, 2, 250, 0, 0, 3, 750, '2013-10-22 05:35:45'),
(52, 'c0ba93694c6d8d0991a5dd72789154b6', 0, 3, 220, 0, 0, 3, 660, '2013-10-22 05:35:45'),
(53, 'c0ba93694c6d8d0991a5dd72789154b6', 0, 4, 520, 0, 0, 3, 1560, '2013-10-22 05:35:46'),
(57, '820dc346ebb8bca20e7eb2ba7ba50581', 0, 2, 250, 0, 0, 6, 1500, '2013-11-02 05:33:37'),
(58, '9e0af68dfceee57867fd15523f3ef7cb', 0, 9, 65, 0, 0, 1, 65, '2013-11-19 17:20:14'),
(59, '9e0af68dfceee57867fd15523f3ef7cb', 0, 10, 85, 0, 0, 2, 170, '2013-11-19 17:20:20'),
(60, '472e273ade01ac2acdb74f5e1c71cd83', 0, 11, 100, 0, 0, 1, 100, '2013-11-24 04:36:58'),
(61, '6167b7b3ff9bfd9759f68b5a4a134ac1', 0, 4, 520, 0, 0, 1, 520, '2013-12-01 06:05:42'),
(62, '6167b7b3ff9bfd9759f68b5a4a134ac1', 0, 3, 220, 0, 0, 1, 220, '2013-12-01 06:05:43'),
(63, '6167b7b3ff9bfd9759f68b5a4a134ac1', 0, 2, 250, 0, 0, 1, 250, '2013-12-01 06:05:44'),
(64, '700aac0fe742764b76bc3c2b13b6079f', 0, 11, 100, 0, 0, 1, 100, '2013-12-01 06:10:36'),
(65, '700aac0fe742764b76bc3c2b13b6079f', 0, 10, 85, 0, 0, 2, 170, '2013-12-01 06:10:41'),
(66, '700aac0fe742764b76bc3c2b13b6079f', 0, 9, 65, 0, 0, 1, 65, '2013-12-01 06:10:46'),
(67, '700aac0fe742764b76bc3c2b13b6079f', 0, 12, 90, 0, 0, 4, 360, '2013-12-01 06:11:22'),
(68, '35feeccab7c2aa02a0d82c821fdf30ce', 0, 11, 100, 0, 0, 1, 100, '2013-12-01 06:12:11'),
(69, 'jlgjnmpcusmpdce2n875vcb4q2', 0, 9, 65, 0, 0, 1, 65, '2013-12-05 05:53:28'),
(70, 'jlgjnmpcusmpdce2n875vcb4q2', 0, 1, 160, 10, 10, 2, 320, '2013-12-05 07:58:29'),
(71, 'do1a957j3krmbp6bdo1udubuc7', 0, 9, 65, 0, 0, 1, 65, '2013-12-09 04:42:25'),
(72, 'g62kunhonf69f83dmth024q7p0', 0, 9, 65, 0, 0, 1, 65, '2014-01-15 04:27:05'),
(73, 'g62kunhonf69f83dmth024q7p0', 0, 11, 100, 0, 0, 1, 100, '2014-01-15 04:27:15'),
(74, 'skv9qiqpap9hlhsoq3ubfj9271', 0, 9, 65, 0, 0, 1, 65, '2014-01-16 04:20:32'),
(75, 'skv9qiqpap9hlhsoq3ubfj9271', 0, 10, 85, 0, 0, 1, 85, '2014-01-16 04:20:36'),
(76, '9d5h1o6p3clnimcmbq6bnplpt4', 18, 10, 85, 0, 0, 1, 85, '2014-01-16 05:24:23'),
(77, '9d5h1o6p3clnimcmbq6bnplpt4', 18, 9, 65, 0, 0, 1, 65, '2014-01-16 05:24:24'),
(78, '9d5h1o6p3clnimcmbq6bnplpt4', 18, 11, 100, 0, 0, 1, 100, '2014-01-16 05:24:25'),
(79, 'seps8a0mcjpitmjptdeqd6nn56', 18, 11, 100, 0, 0, 1, 100, '2014-01-16 06:22:37'),
(80, 'seps8a0mcjpitmjptdeqd6nn56', 18, 10, 85, 0, 0, 1, 85, '2014-01-16 06:22:38'),
(81, 'seps8a0mcjpitmjptdeqd6nn56', 18, 9, 65, 0, 0, 1, 65, '2014-01-16 06:22:38'),
(82, 'seps8a0mcjpitmjptdeqd6nn56', 18, 12, 90, 0, 0, 1, 90, '2014-01-16 06:22:40'),
(83, 'qne2dilgnepeem5qfn31vcd4l0', 19, 9, 65, 0, 0, 1, 65, '2014-01-22 10:37:13'),
(84, 'qne2dilgnepeem5qfn31vcd4l0', 19, 10, 85, 0, 0, 1, 85, '2014-01-22 10:37:14'),
(85, 'qne2dilgnepeem5qfn31vcd4l0', 19, 11, 100, 0, 0, 1, 100, '2014-01-22 10:37:15'),
(86, '51eh9plsbpflsjo5ec3sclgdl1', 0, 9, 65, 0, 0, 5, 325, '2014-01-23 09:01:26'),
(87, '51eh9plsbpflsjo5ec3sclgdl1', 0, 10, 85, 0, 0, 1, 85, '2014-01-23 09:02:17');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_password`, `google_user_id`, `user_hash`, `user_status`, `user_verification`, `user_first_name`, `user_middle_name`, `user_last_name`, `user_DOB`, `user_gender`, `user_aboutme`, `user_street_address`, `user_country`, `user_city`, `user_zip`, `user_delivery_address`, `user_phone`, `user_last_login`) VALUES
(1, 'mijo.jfwg@gmail.com', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, '', 'active', 'no', 'William', 'Francis', 'Gomes', '1986-07-10', 'Male', 'I am William', '', 0, 0, 0, 'Sample Shipping Address', '01914272921', '0000-00-00 00:00:00'),
(2, 'faruk@bscheme.com', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, '', 'active', 'no', 'Faruk', '', 'Omar', '1986-07-10', 'Male', 'I am Faruk', '', 0, 0, 0, '', '01914272921', '1986-07-09 12:00:00'),
(3, 'sample@bscheme.com', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, '', 'active', 'no', 'William', '', 'Gomes', '0000-00-00', 'Male', '', '', 3, 10, 0, '', '', '0000-00-00 00:00:00'),
(4, 'sample@sample.com', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, '', 'active', 'no', 'William', '', 'Gomes', '0000-00-00', 'Male', '', '', 3, 10, 0, '', '', '0000-00-00 00:00:00'),
(5, 'ajsdh@kajsdhsaj.ljh', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, '', 'active', 'no', 'ashdasjk', 'sdhfkjshdfkj', 'ajsdhaksjdh', '0000-00-00', 'Male', '', '', 3, 10, 0, '', '', '0000-00-00 00:00:00'),
(6, 'aksjhdkj@jdhfsjkd.com', '81dc9bdb52d04dc20#e3c201m2r1*036dbd8313ed055', 0, '', 'active', 'no', 'William', '', 'Gomes', '0000-00-00', 'Male', '', '', 3, 25, 0, '', '', '0000-00-00 00:00:00'),
(7, 'sjdhakj@jdhfskjf.jhjkh', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, '', 'active', 'no', 'William', '', 'Gomes', '0000-00-00', 'Male', '', '', 3, 10, 0, '', '', '0000-00-00 00:00:00'),
(8, 'jhsdkjah@asjkdhkas.lk', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, '', 'active', 'no', 'Tahim', '', 'Ahmed', '0000-00-00', 'Male', '', '', 3, 13, 0, '', '', '0000-00-00 00:00:00'),
(9, 'jkdshfk@hskfh.com', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, '', 'active', 'no', 'William', '', 'Gomes', '0000-00-00', 'Male', '', '', 3, 13, 0, '', '', '0000-00-00 00:00:00'),
(10, 'aajsdhk@asdjdk.ajsd', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, '', 'active', 'no', 'William', '', 'Gomes', '0000-00-00', 'Male', '', '', 3, 14, 0, '', '', '0000-00-00 00:00:00'),
(11, 'asdad@asdasd.dg', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, '', 'active', 'no', 'sdada', 'asdasd', 'asdasdad', '0000-00-00', 'Male', '', '', 2, 4, 0, '', '', '0000-00-00 00:00:00'),
(12, 'sdjkjh@kjhsk.ljkhl', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, '', 'active', 'no', 'dajshkj', 'sdjkfhsdfkj', 'sdjfhdksfh', '0000-00-00', 'Male', '', '', 2, 4, 0, '', '', '0000-00-00 00:00:00'),
(13, 'sdkjfh@kjashfk.ajsdh', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, '', 'active', 'no', 'asj,daskdhak', 'sdkhskdfhkjsd', 'sdjfhsdkjfhk', '0000-00-00', 'Male', '', '', 3, 13, 0, '', '', '0000-00-00 00:00:00'),
(14, 'akjsadh@kajsdha.asjdh', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, '', 'active', 'no', 'asjdhajkd', 'adjasdkjadh', 'adkjaskdashdk', '0000-00-00', 'Male', '', '', 3, 25, 0, '', '', '0000-00-00 00:00:00'),
(15, 'kjsadhfk@ksjdhfks.aksd', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, '', 'active', 'no', 'djfksh', 'kjasdfhksd', 'dfjkshdfk', '0000-00-00', 'Male', '', '', 3, 16, 0, '', '', '0000-00-00 00:00:00'),
(16, 'sample@nuvista.com', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, '', 'active', 'no', 'Sample', '', 'User', '0000-00-00', 'Male', '', '', 3, 15, 0, '', '', '0000-00-00 00:00:00'),
(17, 'user@sample.com', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, '', 'active', 'no', 'Sample', '', 'User', '0000-00-00', 'Male', '', '', 3, 13, 0, '', '', '0000-00-00 00:00:00'),
(18, 'sample@joinnuvista.com', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, 'nfq15l4qjujv2f67j9hr9p76r2', 'active', 'yes', 'William', 'Francis', 'Gomes', '1980-07-07', 'Male', 'Hello, i am William Gomes.', '80, Tejturi Bazar', 3, 27, 1214, '', '8801914272921', '2013-08-19 09:58:31'),
(19, 'mofiz@mofiz.com', 'e10adc3949ba59abb#e3c201m2r1*e56e057f20f883e', 0, 'qne2dilgnepeem5qfn31vcd4l0', 'active', 'yes', 'Mofiz', '', 'Abul', '0000-00-00', 'Male', '', 'sdjfhsdkjfhsdkfjhs', 3, 12, 1215, '', '', '2014-01-20 13:05:15'),
(20, 'murad.cse.jstu@gmail.com', 'c4ca4238a0b923820#e3c201m2r1*dcc509a6f75849b', 0, 'afbd0bcbafd9240d6862554c5c2252d4', 'active', 'yes', 'murad', 'Middle Name', 'hassan', '0000-00-00', 'Not defined', '', 'aa', 3, 10, 2222, '', '11', '2013-09-26 10:37:53'),
(21, 'tariqul.islam.ronnie@gmail.com', '5e7e476dacd3b33ff#e3c201m2r1*4086ebff1a6eb07', 0, 'vLg2202a', 'active', 'no', 'tariqul', 'islam', 'ronnie', '0000-00-00', 'Not defined', '', '56/67', 3, 10, 1214, '', '', '2013-10-03 13:37:06'),
(22, 'arneebc@gmail.com', 'c696fdbbcecb1b2e8#e3c201m2r1*3cb573580c532bb', 0, 'lp2tpRfr', 'active', 'no', 'Arneeb', 'Middle Name', 'Chaudhury', '0000-00-00', 'Not defined', '', '501 Royal Carriage Mews', 3, 10, 0, '', '', '2013-10-07 15:28:46');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
