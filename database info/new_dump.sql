-- --------------------------------------------------------
-- Сервер:                       127.0.0.1
-- Версія сервера:               5.6.21 - MySQL Community Server (GPL)
-- ОС сервера:                   Win32
-- HeidiSQL Версія:              9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- Dumping data for table work.category: ~4 rows (приблизно)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id`, `name`) VALUES
	(1, 'First category'),
	(2, 'Second one\r\n'),
	(3, 'Third category'),
	(4, 'One more'),
	(13, 'asd');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- Dumping data for table work.education: ~8 rows (приблизно)
/*!40000 ALTER TABLE `education` DISABLE KEYS */;
INSERT INTO `education` (`id`, `name`, `city`, `education_id`) VALUES
	(1, 'Загальноосвітня школа No 5', 'Uzhgorod', 1),
	(3, 'Some education', NULL, 1),
	(12, 'sdfg', NULL, 1),
	(13, NULL, NULL, NULL),
	(14, NULL, NULL, NULL),
	(15, 'sdfgsd', NULL, NULL),
	(16, 'Some education', NULL, NULL),
	(17, NULL, NULL, NULL),
	(18, NULL, NULL, NULL),
	(19, NULL, NULL, NULL);
/*!40000 ALTER TABLE `education` ENABLE KEYS */;

-- Dumping data for table work.educationlevel: ~2 rows (приблизно)
/*!40000 ALTER TABLE `educationlevel` DISABLE KEYS */;
INSERT INTO `educationlevel` (`id`, `name`) VALUES
	(1, 'School'),
	(2, 'Bachelor');
/*!40000 ALTER TABLE `educationlevel` ENABLE KEYS */;

-- Dumping data for table work.employer: ~0 rows (приблизно)
/*!40000 ALTER TABLE `employer` DISABLE KEYS */;
INSERT INTO `employer` (`id`, `firstName`, `lastName`, `phone`, `termFrom`, `termTo`, `priceFrom`, `priceTo`, `ageFrom`, `ageTo`, `city`, `aboutMe`, `gender_id`) VALUES
	(1, 'Vladimir', 'Vladimirovi4', '+3804568789', '2015-05-24', '2015-10-24', 200, 300, 18, 20, 'Uzhgorod', 'Very good factory', 1);
/*!40000 ALTER TABLE `employer` ENABLE KEYS */;

-- Dumping data for table work.employer_categories: ~0 rows (приблизно)
/*!40000 ALTER TABLE `employer_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `employer_categories` ENABLE KEYS */;

-- Dumping data for table work.gender: ~2 rows (приблизно)
/*!40000 ALTER TABLE `gender` DISABLE KEYS */;
INSERT INTO `gender` (`id`, `name`) VALUES
	(1, 'male'),
	(2, 'female');
/*!40000 ALTER TABLE `gender` ENABLE KEYS */;

-- Dumping data for table work.worker: ~11 rows (приблизно)
/*!40000 ALTER TABLE `worker` DISABLE KEYS */;
INSERT INTO `worker` (`id`, `firstName`, `lastName`, `phone`, `city`, `aboutMe`, `gender_id`, `date`) VALUES
	(1, 'Vasuljko', 'Last Name', '+380502145698', 'Uzhgorod', 'asjfbalksbflkasbfagsfhbasjfbajsfbjksavbfkjsbafahsbfkjasbfnabsfjbasjfhvajsbfjavsfjvsafkjavsfv', 1, '1994-03-28'),
	(2, 'Васьок', 'Last name', '+380957896524', 'Uzhgorod', 'афівипдіофвипдфіивпоіифвпорфіивпариіфвиадлфівраофірвпшоіфишвпиАААААААААААААААААААААаааааааааааааааааааааАВВВВВВВВВВввв', 1, '1999-04-25'),
	(3, 'AAA', 'aaa', '+380502456874', 'Some city', 'asfbasmnfblmasbfmas', 2, '2000-03-28'),
	(4, 'Viktor', 'Pupkin', '+380502109213', 'Beregove', 'I`m awesome programmer', 1, '1993-03-28'),
	(6, 'test', 'name', '+1313216', 'test city', 'Smth about myself', 1, '2015-05-20'),
	(19, 'First name', 'фів', '+38050фів', NULL, NULL, 1, NULL),
	(20, 'Viktor', 'фів', '+38050фів', NULL, NULL, 1, NULL),
	(21, 'test', 'asd', '+1313216', 'Берегово', 'asdgfhgjhgfsdfgfhjjhgfd', 1, NULL),
	(22, 'фів', 'Last name', 'asd', NULL, NULL, 1, NULL),
	(23, 'qweqwe', 'qwe', '+2554245321453', NULL, NULL, 1, NULL),
	(24, 'фів', 'фів', 'фів', NULL, NULL, 1, NULL),
	(25, 'asd', 'Last name', '+380502109213', NULL, NULL, 1, NULL),
	(26, 'Новий працівник', 'Прізвище', '+34454528', NULL, NULL, 1, NULL);
/*!40000 ALTER TABLE `worker` ENABLE KEYS */;

-- Dumping data for table work.workers_categories: ~9 rows (приблизно)
/*!40000 ALTER TABLE `workers_categories` DISABLE KEYS */;
INSERT INTO `workers_categories` (`worker_id`, `category_id`) VALUES
	(1, 1),
	(1, 3),
	(1, 4),
	(4, 3),
	(4, 4),
	(6, 1),
	(6, 4),
	(23, 2),
	(23, 4),
	(26, 2);
/*!40000 ALTER TABLE `workers_categories` ENABLE KEYS */;

-- Dumping data for table work.workers_education: ~9 rows (приблизно)
/*!40000 ALTER TABLE `workers_education` DISABLE KEYS */;
INSERT INTO `workers_education` (`worker_id`, `education_id`) VALUES
	(1, 1),
	(6, 3),
	(19, 12),
	(20, 13),
	(21, 14),
	(22, 15),
	(23, 16),
	(24, 17),
	(25, 18),
	(26, 19);
/*!40000 ALTER TABLE `workers_education` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
