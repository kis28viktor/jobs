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

-- Dumping data for table work.education: ~0 rows (приблизно)
/*!40000 ALTER TABLE `education` DISABLE KEYS */;
INSERT INTO `education` (`id`, `name`, `city`, `level_id`) VALUES
	(1, 'Загальноосвітня школа No 5', 'Uzhgorod', 1);
/*!40000 ALTER TABLE `education` ENABLE KEYS */;

-- Dumping data for table work.educationlevel: ~0 rows (приблизно)
/*!40000 ALTER TABLE `educationlevel` DISABLE KEYS */;
INSERT INTO `educationlevel` (`id`, `name`) VALUES
	(1, 'School'),
	(2, 'Bachelor');
/*!40000 ALTER TABLE `educationlevel` ENABLE KEYS */;

-- Dumping data for table work.employer: ~0 rows (приблизно)
/*!40000 ALTER TABLE `employer` DISABLE KEYS */;
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

-- Dumping data for table work.worker: ~3 rows (приблизно)
/*!40000 ALTER TABLE `worker` DISABLE KEYS */;
INSERT INTO `worker` (`id`, `firstName`, `lastName`, `phone`, `age`, `city`, `aboutMe`, `gender_id`) VALUES
	(1, 'Vasuljko', 'Last Name', '+380502145698', 18, 'Uzhgorod', 'asjfbalksbflkasbfagsfhbasjfbajsfbjksavbfkjsbafahsbfkjasbfnabsfjbasjfhvajsbfjavsfjvsafkjavsfv', 1),
	(2, 'Васьок', 'Last name', '+380957896524', 22, 'Uzhgorod', 'афівипдіофвипдфіивпоіифвпорфіивпариіфвиадлфівраофірвпшоіфишвпиАААААААААААААААААААААаааааааааааааааааааааАВВВВВВВВВВввв', 1),
	(3, 'AAA', 'aaa', '+380502456874', 18, 'Some city', 'asfbasmnfblmasbfmas', 2);
/*!40000 ALTER TABLE `worker` ENABLE KEYS */;

-- Dumping data for table work.workers_categories: ~4 rows (приблизно)
/*!40000 ALTER TABLE `workers_categories` DISABLE KEYS */;
INSERT INTO `workers_categories` (`worker_id`, `category_id`) VALUES
	(1, 1),
	(1, 3),
	(1, 4);
/*!40000 ALTER TABLE `workers_categories` ENABLE KEYS */;

-- Dumping data for table work.workers_education: ~2 rows (приблизно)
/*!40000 ALTER TABLE `workers_education` DISABLE KEYS */;
INSERT INTO `workers_education` (`worker_id`, `education_id`) VALUES
	(1, 1);
/*!40000 ALTER TABLE `workers_education` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
