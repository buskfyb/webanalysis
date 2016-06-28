

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `BFK`
--

-- --------------------------------------------------------

--
-- Table structure for table `libraries`
--

DROP TABLE IF EXISTS `libraries`;
CREATE TABLE IF NOT EXISTS `libraries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libraryname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `siteid` int(11) NOT NULL,
  `population` int(11) DEFAULT NULL,
  `URL` varchar(512) COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=100003 ;

-- --------------------------------------------------------

--
-- Table structure for table `traffic`
--

DROP TABLE IF EXISTS `traffic`;
CREATE TABLE IF NOT EXISTS `traffic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` int(11) NOT NULL,
  `period_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `period` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `visitors` int(11) NOT NULL,
  `pageviews` int(11) NOT NULL,
  `visit_time` int(11) NOT NULL,
  `bounce_rate` int(11) NOT NULL,
  `visits` int(11) NOT NULL,
  `change_percent` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `data` (`siteid`,`period_type`,`period`,`year`),
  KEY `siteid` (`siteid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6461 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;


--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `password`, `email`, `role`) VALUES
(7, 'developadmin', 'CREATE NEW USER AND REMOVE ME', '$2y$10$.QdWTLQq0MwOnhgniau/v.i7qQISbsETlCyt.gabwti1afARiNfiG', 'test@example.com', 'superadmin');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
