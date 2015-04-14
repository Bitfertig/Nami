-- ---------------------------------------------------------
--
-- Simple SQL Dump
-- 
--
-- Host Connection Info: Localhost via UNIX socket
-- Generation Time: April 14, 2015 at 23:27 PM ( Europe/Berlin )
-- Server version: 5.5.38
-- PHP Version: 5.6.2
--
-- ---------------------------------------------------------



SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- ---------------------------------------------------------
--
-- Table structure for table : `eventdates`
--
-- ---------------------------------------------------------

CREATE TABLE `eventdates` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `eventid` int(20) unsigned NOT NULL,
  `date` int(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- ---------------------------------------------------------
--
-- Table structure for table : `eventfiles`
--
-- ---------------------------------------------------------

CREATE TABLE `eventfiles` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `extension` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- ---------------------------------------------------------
--
-- Table structure for table : `events`
--
-- ---------------------------------------------------------

CREATE TABLE `events` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(1023) NOT NULL,
  `keywords` varchar(1023) NOT NULL,
  `eventfileid` int(20) NOT NULL COMMENT 'Ein Bild',
  `lastchange` int(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- ---------------------------------------------------------
--
-- Table structure for table : `users`
--
-- ---------------------------------------------------------

CREATE TABLE `users` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '0',
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthday` int(20) unsigned DEFAULT NULL,
  `registertime` int(20) unsigned NOT NULL,
  `registercode` varchar(9) NOT NULL,
  `lastlogin` int(20) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `resetcode` varchar(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `status`, `username`, `password`, `email`, `birthday`, `registertime`, `registercode`, `lastlogin`, `ip`, `resetcode`) VALUES
(3, 1, 'dipser', '0fdd9f682fe6d949234730348710ac7a', 'dipser@gmail.com', 0, 1428191169, '17RdTz7O9', 0, '127.0.0.1', ''),
(4, -1, 'Demobenutzer', 'eb90c4730aa55709b632e6296e235bc1', 'user@demo', '', 1428340739, 'wpWheMkNE', 0, '127.0.0.1', ''),
(5, -1, 'Demobenutzer', 'd2d64ceaf36b04edc58ef31de7cde598', 'user@demo', '', 1428340992, 'NNdRAoLJo', 0, '127.0.0.1', ''),
(6, -1, 'Demobenutzer', '77c502c20bf2d837b16ce0e8b30221b3', 'user@demo', '', 1428704443, 'yHXdAmRMB', 0, '127.0.0.1', ''),
(7, -1, 'Demobenutzer', 'aa04591499703d4634855ee476039296', 'user@demo', '', 1428704492, 'N8EdLIrd0', 0, '127.0.0.1', ''),
(8, -1, 'Demobenutzer', '5082bfc08bd85b1d191d4d7d6cb87917', 'user@demo', '', 1428704955, 'PfbkjDl9A', 0, '127.0.0.1', ''),
(9, -1, 'Demobenutzer', '56f3fe61d1ad2ccffdf34f17372f8241', 'user@demo', '', 1428706285, 'cn0XR3S85', 0, '127.0.0.1', ''),
(10, -1, 'Demobenutzer', 'b8eaf02e072f57c679fccb01392816ee', 'user@demo', '', 1428706324, 'ZRgAlr52P', 0, '127.0.0.1', ''),
(11, -1, 'Demobenutzer', '49d4e3dc94f953ab08f1918ed01b6eb3', 'user@demo', '', 1428706405, 'SZ9NEjDzO', 0, '127.0.0.1', ''),
(12, -1, 'Demobenutzer', 'bfb6eb86b5726033adc10047cf19695a', 'user@demo', '', 1428706702, '9qrARaz23', 0, '127.0.0.1', ''),
(13, -1, 'Demobenutzer', '079b2728cfc1aa5539846ad795efc1cf', 'user@demo', '', 1428772550, 'itc3fVgTx', 0, '127.0.0.1', '');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;