-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jun 09, 2016 at 10:15 AM
-- Server version: 5.6.27-76.0-log
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hackedzw_savlife`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `active` varchar(1) NOT NULL DEFAULT 'y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `active`) VALUES
(1, 'test', '$2y$10$lIn06ikpJPI45Grzd9Ic2e2E7TL3CfM2vhfYPWMBVPvej02GNpjJu', 'y'),
(3, 'test2', '$2y$10$kAzCV5SZnRgH.SKXx3fAh.eO1ylODdxmsw6.KfptFMB3cWlagT/lS', 'y'),
(4, 'test3', '$2y$10$YvZyUS/jHGsBPVdZ0IdjzeLhOrrx9b/.JWv2QKp/cKbGMNnqnzZiK', 'y'),
(5, '8871334161', '$2y$10$Sj3SbyMgYBHCbjp7pFLxdOVpMlQAEi9Tn9taavM4Jydml0PJcvL4u', 'y');

-- --------------------------------------------------------

--
-- Table structure for table `booked_deals`
--

CREATE TABLE IF NOT EXISTS `booked_deals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` text NOT NULL,
  `deal_id` text NOT NULL,
  `time` text NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'p',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `booked_deals`
--

INSERT INTO `booked_deals` (`id`, `mobile`, `deal_id`, `time`, `status`) VALUES
(1, '8962239913', '1', '1465281610', 'p'),
(2, '8962239913', '2', '1465379114', 'p'),
(3, '8962239913', '3', '1465380724', 'p'),
(4, '9752071654', '3', '1465384561', 'p');

-- --------------------------------------------------------

--
-- Table structure for table `deals`
--

CREATE TABLE IF NOT EXISTS `deals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_name` text NOT NULL,
  `code` varchar(6) NOT NULL,
  `image` text NOT NULL,
  `description` text NOT NULL,
  `orginal_price` int(11) NOT NULL,
  `special_price` int(11) NOT NULL,
  `off` int(11) NOT NULL,
  `active` varchar(1) NOT NULL DEFAULT 'y',
  `time` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `deals`
--

INSERT INTO `deals` (`id`, `lab_name`, `code`, `image`, `description`, `orginal_price`, `special_price`, `off`, `active`, `time`) VALUES
(1, 'Safia hospital', '45helw', 'pic/test/DEAL_IMG_1465281588.jpg', 'hello world this is husain aur yhe hai description from HackerKernel', 500, 500, 0, 'y', '1465281588'),
(2, 'nerd lab', 'nerd12', 'pic/test/DEAL_IMG_1465340994.jpg', 'nerd acge hais sunke sath ache bane warna tumhari mar jayegi kyuki tumhe kam to milna ny hai tum nale ho', 100, 90, 10, 'y', '1465340994'),
(3, 'dhhdj djjx', 'hello1', 'pic/test/DEAL_IMG_1465380680.jpg', 'fucdjlxf bfldb', 500, 100, 80, 'y', '1465380681'),
(4, 'hackerkernel', 'hello1', 'pic/test/DEAL_IMG_1465453758.jpg', 'hello worlf\\nmyname is khan and i ak not a teris', 5000, 3000, 40, 'y', '1465453758');

-- --------------------------------------------------------

--
-- Table structure for table `donation_history`
--

CREATE TABLE IF NOT EXISTS `donation_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` text NOT NULL,
  `date` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `donation_history`
--

INSERT INTO `donation_history` (`id`, `mobile`, `date`) VALUES
(1, '8962239913', '4/6/2016'),
(2, '8962239913', '5/6/2016'),
(3, '8962239913', '5/6/2016'),
(4, '9752071654', '25/4/2016'),
(5, '9752071654', '25/4/2016'),
(6, '8602147547', '6/6/2016'),
(7, '9407557209', '8/6/2016'),
(8, '8871334161', '5/5/2016'),
(9, '9752071654', '25/5/2016'),
(10, '9752071654', '25/5/2016'),
(11, '9752071654', '25/5/2016');

-- --------------------------------------------------------

--
-- Table structure for table `feeds`
--

CREATE TABLE IF NOT EXISTS `feeds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` text NOT NULL,
  `status` text NOT NULL,
  `img` text NOT NULL,
  `type` int(1) NOT NULL,
  `time` text NOT NULL,
  `active` varchar(1) NOT NULL DEFAULT 'y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `feeds`
--

INSERT INTO `feeds` (`id`, `mobile`, `status`, `img`, `type`, `time`, `active`) VALUES
(1, '8962239913', 'programmer joke', 'pic/8962239913/FEED_IMG_1465050499.jpg', 1, '1465050499', 'y'),
(2, '8962239913', 'ygh', 'pic/8962239913/FEED_IMG_1465054969.jpg', 1, '1465054969', 'y'),
(3, '7773853532', 'rmubrm', 'pic/7773853532/FEED_IMG_1465119222.jpg', 1, '1465119223', 'y'),
(4, '8962239913', 'fjlfh', 'pic/8962239913/FEED_IMG_1465126421.jpg', 1, '1465126421', 'y'),
(5, '8962239913', 'hello wield', '', 0, '1465126873', 'y'),
(6, '8871334161', 'ritu mam donated blood at hamidiya', 'pic/8871334161/FEED_IMG_1465146728.jpg', 1, '1465146729', 'y'),
(7, '9752071654', 'first ever &#039;blood life saviour&#039;meeting held at Milan restaurant ðŸ˜€ðŸ˜€....', 'pic/9752071654/FEED_IMG_1465151302.jpg', 1, '1465151303', 'y'),
(8, '9752071654', 'finally, we can see our app, I am very happy right now....', '', 0, '1465223495', 'y'),
(9, '8871334161', 'play store pr lao yr jaldi app ko tb to maza aaye', '', 0, '1465286001', 'y'),
(10, '9752071654', 'relax.....relax, intezaar ka phal meetha hota hai....', '', 0, '1465298789', 'y'),
(11, '8962239913', 'bhai log ghr akar admin app to dekh lo', '', 0, '1465304870', 'y'),
(12, '8962239913', 'husep  idjsjd  cjdjdjndjn jdjdjdjdjdjjd jdjdjdjjdn ;aalallal  jdnsj kpaowie  jjsjdnnjo 2 njdknsnksn lw[qnln qkn xdkddkdkdkkdkdk kkkkkkkkkkkkffk kkkkkkk  klllll', '', 0, '1465453189', 'y');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` text NOT NULL,
  `gcm_reg_id` text NOT NULL,
  `img` text NOT NULL,
  `img_thumb` text NOT NULL,
  `mobile` text NOT NULL,
  `gender` text NOT NULL,
  `age` text NOT NULL,
  `blood` text NOT NULL,
  `otp` text NOT NULL,
  `city` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `verified_otp` varchar(1) NOT NULL DEFAULT 'n',
  `active` varchar(1) NOT NULL DEFAULT 'n',
  `last_otp` text NOT NULL,
  `created_at` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `gcm_reg_id`, `img`, `img_thumb`, `mobile`, `gender`, `age`, `blood`, `otp`, `city`, `latitude`, `longitude`, `verified_otp`, `active`, `last_otp`, `created_at`) VALUES
(1, 'husain saify', 'ehXfNnFPWl8:APA91bHrkUpGnWFV7HZmE6vDBAggu0EoAi_hO0D3S_UO6szGrPTSEspBZWksUxKJ69IzZpWLLn0AoeMuMN89PjJ1kDRq3eonTEzx1vmD92KJABaLAhxM7d0xRopnvUhThTUm34OuLPfS', 'pic/8962239913/PROFILE_IMG_1465126447.jpg', 'pic/8962239913/THUMB_PROFILE_IMG_1465126447.jpg', '8962239913', 'Male', '18', 'b+', '7838', 'bhopal', '23.2587473', '77.3991984', 'y', 'y', '1465050406', '1465050406'),
(2, 'Murtaza Agaz', '', 'pic/8602147547/PROFILE_IMG_1465218869.jpg', 'pic/8602147547/THUMB_PROFILE_IMG_1465218869.jpg', '8602147547', 'Male', '18', 'o+', '2705', 'bhopal', '23.258594484377767', '77.39487823638002', 'y', 'y', '1465050710', '1465050710'),
(3, 'ritik soni', '', '', '', '7773853532', 'Male', '19', 'o-', '9155', 'bhopal', '23.2580565', '77.399726', 'y', 'y', '1465119162', '1465119162'),
(4, 'Aayam Soni', '', '', '', '8982307801', 'Male', '19', 'o+', '8023', '', '', '', 'y', 'y', '1465126968', '1465126968'),
(5, 'shrey agrawal', '', 'pic/8871334161/PROFILE_IMG_1465154499.jpg', 'pic/8871334161/THUMB_PROFILE_IMG_1465154499.jpg', '8871334161', 'Male', '24', 'b+', '9772', 'bhopal', '23.258726666666668', '77.40001333333333', 'y', 'y', '1465145678', '1465145678'),
(6, 'anurag vaidya', '', '', '', '9752071654', 'Male', '28', 'a+', '7665', 'bhopal', '23.23893265', '77.40479748999999', 'y', 'y', '1465148295', '1465148295'),
(7, 'insiya saify', '', '', '', '7894561231', 'male', '19', 'HH', '', 'bhopal', '', '', 'y', 'y', '', '1465206268'),
(8, 'arvind vaidya', '', '', '', '7898618189', 'Male', '64', 'a+', '4714', 'bhopal', '23.239126666666667', '77.40524833333333', 'y', 'y', '1465223021', '1465223021'),
(9, 'Siddharth gupta', '', 'pic/9407557209/PROFILE_IMG_1465365641.jpg', 'pic/9407557209/THUMB_PROFILE_IMG_1465365641.jpg', '9407557209', 'Male', '24', 'ab+', '3081', 'bhopal', '23.2573425', '77.3993017', 'y', 'y', '1465317274', '1465317274'),
(10, 'Aditya patidar', '', '', '', '9826066582', 'male', '20', 'AB+', '', 'bhopal', '', '', 'y', 'y', '', '1465325544'),
(11, 'Abhishek sharma', '', '', '', '9893666356', 'male', '21', 'AB+', '', 'bhopal', '', '', 'y', 'y', '', '1465325635'),
(12, 'Shruti agarwal', '', '', '', '9039487393', 'female', '26', 'B+', '', 'banglore', '', '', 'y', 'y', '', '1465325672'),
(13, 'RAHUL YADAV', '', '', '', '9713534453', 'male', '21', 'B-', '', 'bhopal', '', '', 'y', 'y', '', '1465325725'),
(14, 'MIHD.AZGAR', '', '', '', '9893314711', 'male', '24', 'B-', '', 'bhopal', '', '', 'y', 'y', '', '1465325782'),
(15, 'GURU YADAV', '', '', '', '9754677961', 'male', '24', 'B+', '', 'bhopal', '', '', 'y', 'y', '', '1465325835'),
(16, 'GOW SIR', '', '', '', '8989231879', 'male', '24', 'A+', '', 'bhopal', '', '', 'y', 'y', '', '1465325887'),
(17, 'PRANAY NAGWANSHI', '', '', '', '9425153605', 'male', '30', 'A+', '', 'bhopal', '', '', 'y', 'y', '', '1465325926'),
(18, 'ANJU BHASKAR', '', '', '', '8109520827', 'female', '28', 'O-', '', 'bhopal', '', '', 'y', 'y', '', '1465325972'),
(19, 'YASH', '', '', '', '9926642579', 'male', '24', 'O-', '', 'bhopal', '', '', 'y', 'y', '', '1465326012');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
