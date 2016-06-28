

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `BFK`
--

--
-- Dumping data for table `libraries`
--

INSERT INTO `libraries` (`id`, `libraryname`, `siteid`, `population`, `URL`) VALUES
(1, 'Drammensbiblioteket', 2, 67895, 'http://dbib.no/'),
(2, 'Flesberg bibliotek', 5, 2699, 'http://flesbergbibliotek.no/'),
(3, 'Øvre Eiker bibliotek', 11, 18205, 'http://oeikbib.no/'),
(4, 'Nedre Eiker bibliotek', 14, 24431, 'http://nedre-eiker.folkebibl.no/'),
(5, 'Midt-Buskerud bibliotek', 15, 19581, 'http://midtfylkebiblioteket.no'),
(6, 'Lier bibliotek', 18, 25731, 'http://lier.folkebibl.no/'),
(7, 'Røyken bibliotek', 19, 21492, 'http://roykenbibliotek.no/'),
(8, 'Hallingdalsbiblioteka', 20, 20704, 'http://hallingdalsbiblioteka.no/'),
(9, 'Rjukan bibliotek', 23, 5940, 'http://tinnbib.no/'),
(10, 'Kragerø bibliotek', 24, 10607, 'http://kragerobib.no'),
(11, 'Bamble bibliotek', 25, 14088, 'http://bamblebib.no/'),
(12, 'Siljan bibliotek', 27, 2335, 'http://siljanbib.no'),
(13, 'Bø bibliotek', 28, 6101, 'http://bobib.no'),
(14, 'Deichmanske bibliotek', 29, 658390, 'https://www.deichman.no/'),
(15, 'Moss bibliotek', 30, 32182, 'http://www.mossbibliotek.no/'),
(16, 'Gjesdal folkebibliotek', 31, 11853, 'http://gjesdal.folkebibl.no'),
(17, 'Østre Toten folkebibliotek', 34, 14906, 'http://www.ostre-toten.folkebibl.no'),
(18, 'Lillehammer bibliotek', 35, 27476, 'http://www.lillehammer.folkebibl.no/cmsms/'),
(19, 'Askim bibliotek', 36, 15615, 'http://www.askim.kommune.no/bibliotek.215587.no.html'),
(20, 'Risør bibliotek', 37, 6920, 'http://risorbibliotek.no'),
(21, 'Åmli bibliotek', 38, 1847, 'http://amlibibliotek.no'),
(22, 'Nore og Uvdal bibliotek', 39, 2548, 'http://noreoguvdalbibliotek.no/'),
(23, 'Lillesand folkebibliotek', 40, 10577, 'http://lillesandfolkebibliotek.no/'),
(24, 'Kristiansand bibliotek', 41, 88447, 'http://krsbib.no/'),
(25, 'Mandal bibliotek', 43, 15529, 'http://mandalbibliotek.no/'),
(26, 'Vennesla bibliotek', 45, 14308, 'http://venneslakulturhus.no'),
(27, 'Gjerstad folkebibliotek', 48, 2463, 'http://gjerstadfolkebibliotek.no/'),
(28, 'Vegårshei bibliotek', 49, 2036, 'http://vegarsheibibliotek.no'),
(29, 'Stryn bibliotek', 50, 7168, 'http://strynbibliotek.no'),
(30, 'Lebesby bibliotek', 51, 1318, 'http://www.lebesbybibliotek.no/'),
(31, 'Vardø bibliotek', 52, 2137, 'http://vardobibliotek.no'),
(32, 'Kvinesdal bibliotek', 59, 5981, 'http://kvinesdalbibliotek.no'),
(33, 'Randaberg folkebibliotek', 63, 10737, 'http://randaberg-folkebibliotek.no'),
(34, 'Arendal bibliotek', 65, 44313, 'http://arendalbibliotek.no/'),
(35, 'Hole bibliotek', 67, 6767, 'http://hole.webloft.no/'),
(36, 'Hurum bibliotek', 69, 9413, 'http://hurumbibliotek.no/'),
(37, 'Rollag bibliotek', 71, 1404, 'http://rollagbibliotek.no'),
(38, 'Skien bibliotek', 73, 53952, 'http://skienbibliotek.no/'),
(39, 'Bærum bibliotek', 75, 122342, 'http://barum.folkebibl.no/'),
(40, 'Klæbu folkebibliotek', 77, 6067, 'http://biblioteket.klabu.kommune.no/'),
(41, 'Skaun bibliotek', 79, 7755, 'http://bibliotek.skaun.kommune.no'),
(42, 'Jærbiblioteka', 42, 63638, 'http://jaerbiblioteka.no/'),
(43, 'Bibliotekrom', 33, 184774, 'http://bibliotekrom.no/'),
(44, 'Vest-Telemarkbiblioteka', 22, 15791, 'http://vest-telemarkbiblioteka.no'),
(100000, 'Total', 100000, 1992867, ''),
(100001, 'Kongsberg bibliotek', 85, 27013, 'http://kongsbergbibliotek.no'),
(100002, 'Bergen bibliotek', 89, 277391, 'http://bergenbibliotek.no');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
