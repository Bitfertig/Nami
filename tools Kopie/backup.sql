-- ---------------------------------------------------------
--
-- SIMPLE SQL Dump
-- 
-- http://www.nawa.me/
--
-- Host Connection Info: Localhost via UNIX socket
-- Generation Time: April 05, 2015 at 02:36 AM ( Europe/Berlin )
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `status`, `username`, `password`, `email`, `birthday`, `registertime`, `registercode`, `lastlogin`, `ip`, `resetcode`) VALUES
(3, 1, 'dipser', '0fdd9f682fe6d949234730348710ac7a', 'dipser@gmail.com', '', 1428191169, '17RdTz7O9', 0, '127.0.0.1', '');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;