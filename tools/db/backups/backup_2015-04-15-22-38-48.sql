-- ---------------------------------------------------------
--
-- Simple SQL Dump
-- 
--
-- Host Connection Info: Localhost via UNIX socket
-- Generation Time: April 15, 2015 at 22:38 PM ( Europe/Berlin )
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
  `status` int(1) NOT NULL,
  `userid` int(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(1023) NOT NULL,
  `keywords` varchar(1023) NOT NULL,
  `eventfileid` int(20) NOT NULL COMMENT 'Ein Bild',
  `lastchange` int(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `status`, `userid`, `title`, `description`, `keywords`, `eventfileid`, `lastchange`) VALUES
(1, 1, 1, 'Meine <b>Veranstaltung</b> "1"', 'Die und das ist die Beschreibung.', 'Wort1, Wort2, Wort3', 0, 0),
(2, 0, 1, 'Meine Veranstaltung 2', 'Die und das ist die Beschreibung.', 'Wort1, Wort2, Wort3', 0, 0);



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
(1, 1, 'dipser', '0fdd9f682fe6d949234730348710ac7a', 'dipser@gmail.com', 0, 1428191169, '17RdTz7O9', 0, '127.0.0.1', ''),
(2, 1, 'Benjamin', '0fdd9f682fe6d949234730348710ac7a', 'benjamin@hermand.de', 0, 1428340739, 'wpWheMkNE', 0, '127.0.0.1', ''),
(3, -1, 'Demobenutzer', 'd2d64ceaf36b04edc58ef31de7cde598', 'user@demo', 0, 1428340992, 'NNdRAoLJo', 0, '127.0.0.1', '');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;