# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.6.35)
# Database: OMTS
# Generation Time: 2018-03-26 03:15:42 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table actors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `actors`;

CREATE TABLE `actors` (
  `FName` varchar(50) NOT NULL,
  `LName` varchar(50) NOT NULL,
  `MovieID` int(11) NOT NULL,
  KEY `MovieID` (`MovieID`),
  CONSTRAINT `actors_ibfk_1` FOREIGN KEY (`MovieID`) REFERENCES `movie` (`MovieID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `actors` WRITE;
/*!40000 ALTER TABLE `actors` DISABLE KEYS */;

INSERT INTO `actors` (`FName`, `LName`, `MovieID`)
VALUES
	('Tim','Robbins ',1),
	('Morgan','Freeman',1),
	('Marlon ','Brando',2),
	('Al ','Pacino',2),
	('John ','Travolta',3),
	('Uma ','Thurman',3),
	('Samuel L. ','Jackson',3),
	('John ','Boyega',4),
	('Scott ','Eastwood',4),
	('Kelly ','Asbury',5),
	('Mary J. ','Blige',5),
	('Storm ','Reid',6),
	('Oprah ','Winfrey',6),
	('Chadwick ','Boseman',7),
	('Lupita ','Nyong\'o',7),
	('Michael B. ','Jordan',7),
	('Elijah ','Wood',8),
	('Viggo ','Mortensen',8),
	('Ian ','McKellen',8),
	('Alicia ','Vikander',9),
	('Tom ','Hanks',10),
	('Matt','Damon',10),
	('Tom ','Sizemore',10);

/*!40000 ALTER TABLE `actors` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table complex
# ------------------------------------------------------------

DROP TABLE IF EXISTS `complex`;

CREATE TABLE `complex` (
  `ComplexNo` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Phone` char(10) NOT NULL,
  PRIMARY KEY (`ComplexNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `complex` WRITE;
/*!40000 ALTER TABLE `complex` DISABLE KEYS */;

INSERT INTO `complex` (`ComplexNo`, `Name`, `Address`, `Phone`)
VALUES
	(1,'MegaTheater ','9 City Road Kingston, ON ','6132345678'),
	(2,'Cineplex ','21 First Street, Kingston ON ','6131231234'),
	(3,'MovieBox','12 Main Street, Springfield TX','1112223333'),
	(4,'IMAX','67 Fist Ave New York, NY','9897675455');

/*!40000 ALTER TABLE `complex` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table movie
# ------------------------------------------------------------

DROP TABLE IF EXISTS `movie`;

CREATE TABLE `movie` (
  `MovieID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(60) NOT NULL,
  `RunTime` int(11) NOT NULL,
  `Rating` enum('G','PG','14A','18A','R','A') NOT NULL,
  `Plot` text,
  `Director` varchar(100) NOT NULL,
  `Producer` varchar(100) NOT NULL,
  `SDate` date NOT NULL,
  `EDate` date NOT NULL,
  `SupplierID` int(11) NOT NULL,
  PRIMARY KEY (`MovieID`),
  KEY `SupplierID` (`SupplierID`),
  CONSTRAINT `movie_ibfk_1` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`SupplierID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `movie` WRITE;
/*!40000 ALTER TABLE `movie` DISABLE KEYS */;

INSERT INTO `movie` (`MovieID`, `Title`, `RunTime`, `Rating`, `Plot`, `Director`, `Producer`, `SDate`, `EDate`, `SupplierID`)
VALUES
	(1,'The Shawshank Redemption',142,'R','Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.','Frank Darabont','Liz Glotzer, David V. Lester, Niki Marvin','2018-03-25','2018-06-30',1),
	(2,' The Godfather',175,'R','When the aging head of a famous crime family decides to transfer his position to one of his subalterns, a series of unfortunate events start happening to the family, and a war begins between all the well-known families leading to insolence, deportation, murder and revenge, and ends with the favorable successor being finally chosen.','Francis Ford Coppola','Paramount Pictures','2018-03-09','2018-06-15',2),
	(3,'Pulp Fiction',154,'R','The lives of two mob hitmen, a boxer, a gangster\'s wife, and a pair of diner bandits intertwine in four tales of violence and redemption.','Quentin Tarantino','Miramax','2018-03-25','2018-08-31',3),
	(4,'Pacific Rim: Uprising',111,'14A','Jake Pentecost, son of Stacker Pentecost, reunites with Mako Mori to lead a new generation of Jaeger pilots, including rival Lambert and 15-year-old hacker Amara, against a new Kaiju threat.','Steven S. DeKnight','Double Dare You (DDY)','2018-03-23','2018-06-15',1),
	(5,'Sherlock Gnomes',86,'PG','Garden gnomes, Gnomeo & Juliet, recruit renowned detective Sherlock Gnomes to investigate the mysterious disappearance of other garden ornaments.','John Stevenson','Metro-Goldwyn-Mayer (MGM)','2018-03-23','2018-06-13',2),
	(6,' A Wrinkle in Time',109,'PG','Following the discovery of a new form of space travel as well as Meg\'s father\'s disappearance, she, her brother, and her friend must join three magical beings - Mrs. Whatsit, Mrs. Who, and Mrs. Which - to travel across the universe to rescue him from a terrible evil.','Ava DuVernay','Walt Disney Pictures','2018-03-09','2018-06-14',4),
	(7,'Black Panther',134,'14A','After the events of Captain America: Civil War, King T\'Challa returns home to the reclusive, technologically advanced African nation of Wakanda to serve as his country\'s new leader. However, T\'Challa soon finds that he is challenged for the throne from factions within his own country. When two foes conspire to destroy Wakanda, the hero known as Black Panther must team up with C.I.A. agent Everett K. Ross and members of the Dora Milaje, Wakandan special forces, to prevent Wakanda from being dragged into a world war.','Ryan Coogler ','Marvel Studios','2018-02-16','2018-03-31',4),
	(8,'The Lord of the Rings: The Return of the King',201,'PG','Gandalf and Aragorn lead the World of Men against Sauron\'s army to draw his gaze from Frodo and Sam as they approach Mount Doom with the One Ring.','Peter Jackson','New Line Cinema','2018-03-01','2018-07-20',5),
	(9,'Tomb Raider',118,'PG','Lara Croft, the fiercely independent daughter of a missing adventurer, must push herself beyond her limits when she finds herself on the island where her father disappeared.','Roar Uthaug','GK Films','2018-03-16','2018-06-14',5),
	(10,'Saving Private Ryan',169,'R','Following the Normandy Landings, a group of U.S. soldiers go behind enemy lines to retrieve a paratrooper whose brothers have been killed in action.','Steven Spielberg','DreamWorks','2018-05-17','2018-09-20',2);

/*!40000 ALTER TABLE `movie` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Reservation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Reservation`;

CREATE TABLE `Reservation` (
  `UserID` int(11) NOT NULL,
  `STime` time NOT NULL,
  `SDate` date NOT NULL,
  `TheaterNo` int(11) NOT NULL,
  `ComplexNo` int(11) NOT NULL,
  `MovieID` int(11) NOT NULL,
  `NumTickets` int(11) NOT NULL,
  PRIMARY KEY (`UserID`,`STime`,`SDate`,`MovieID`),
  KEY `STime` (`STime`,`SDate`,`TheaterNo`,`ComplexNo`,`MovieID`),
  CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`STime`, `SDate`, `TheaterNo`, `ComplexNo`, `MovieID`) REFERENCES `Showing` (`STime`, `SDate`, `TheaterNo`, `ComplexNo`, `MovieID`) on delete cascade,
  CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Reservation` WRITE;
/*!40000 ALTER TABLE `Reservation` DISABLE KEYS */;

INSERT INTO `Reservation` (`UserID`, `STime`, `SDate`, `TheaterNo`, `ComplexNo`, `MovieID`, `NumTickets`)
VALUES
	(1,'16:00:00','2018-03-25',1,1,1,12),
	(1,'20:00:00','2018-03-29',1,2,5,5);

/*!40000 ALTER TABLE `Reservation` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Showing
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Showing`;

CREATE TABLE `Showing` (
  `STime` time NOT NULL,
  `SDate` date NOT NULL,
  `TheaterNo` int(11) NOT NULL,
  `ComplexNo` int(11) NOT NULL,
  `BookedSeats` int(11) NOT NULL,
  `MovieID` int(11) NOT NULL,
  PRIMARY KEY (`STime`,`SDate`,`TheaterNo`,`ComplexNo`,`MovieID`),
  KEY `ComplexNo` (`ComplexNo`,`TheaterNo`),
  KEY `MovieID` (`MovieID`),
  CONSTRAINT `showing_ibfk_1` FOREIGN KEY (`ComplexNo`, `TheaterNo`) REFERENCES `Theater` (`ComplexNo`, `TheaterNo`),
  CONSTRAINT `showing_ibfk_2` FOREIGN KEY (`MovieID`) REFERENCES `Movie` (`MovieID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Showing` WRITE;
/*!40000 ALTER TABLE `Showing` DISABLE KEYS */;

INSERT INTO `Showing` (`STime`, `SDate`, `TheaterNo`, `ComplexNo`, `BookedSeats`, `MovieID`)
VALUES
	('11:30:00','2018-03-24',2,1,0,5),
	('12:00:00','2018-04-19',4,2,0,8),
	('15:00:00','2018-04-01',2,1,0,10),
	('16:00:00','2018-03-25',1,1,12,1),
	('17:00:00','2018-03-29',2,2,0,4),
	('17:30:00','2018-03-24',2,1,0,5),
	('18:00:00','2018-03-15',3,3,0,7),
	('18:00:00','2018-03-26',1,1,0,2),
	('20:00:00','2018-03-28',4,2,0,9),
	('20:00:00','2018-03-29',1,2,5,5),
	('20:00:00','2018-03-31',1,2,0,6),
	('20:30:00','2018-03-26',1,1,0,3);

/*!40000 ALTER TABLE `Showing` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table supplier
# ------------------------------------------------------------

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `SupplierID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Phone` char(10) NOT NULL,
  `Contact` varchar(100) NOT NULL,
  PRIMARY KEY (`SupplierID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `supplier` WRITE;
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;

INSERT INTO `supplier` (`SupplierID`, `Name`, `Address`, `Phone`, `Contact`)
VALUES
	(1,'Columbia Pictures ','98 West Street New York, NY ','2135467689','John Smith '),
	(2,'Paramount Pictures','5555 Melrose Avenue, Hollywood, CA','3239565000','Jim Gianopulos'),
	(3,'Miramax','17 East Ave Los Angeles, California','9876543211','Bill Block'),
	(4,'Walt Disney Company  ','21 Magic Kingdom Orlando, FL','1234567890','Walt Disney '),
	(5,'Warner Bros.','1 Main st Hollywood, LA','1112223333','Warner Bro ');

/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table theater
# ------------------------------------------------------------

DROP TABLE IF EXISTS `theater`;

CREATE TABLE `theater` (
  `TheaterNo` int(11) NOT NULL,
  `ComplexNo` int(11) NOT NULL,
  `Seats` int(11) NOT NULL,
  `Screen` enum('S','M','L') NOT NULL,
  PRIMARY KEY (`ComplexNo`,`TheaterNo`),
  CONSTRAINT `theater_ibfk_1` FOREIGN KEY (`ComplexNo`) REFERENCES `complex` (`ComplexNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `theater` WRITE;
/*!40000 ALTER TABLE `theater` DISABLE KEYS */;

INSERT INTO `theater` (`TheaterNo`, `ComplexNo`, `Seats`, `Screen`)
VALUES
	(1,1,100,'S'),
	(2,1,180,'M'),
	(1,2,200,'M'),
	(2,2,100,'S'),
	(3,2,500,'L'),
	(4,2,200,'M'),
	(1,3,100,'S'),
	(2,3,500,'L'),
	(3,3,200,'M'),
	(1,4,1000,'L'),
	(2,4,1000,'L');

/*!40000 ALTER TABLE `theater` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Login` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `UserType` enum('M','A') DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`UserID`, `Login`, `Password`, `UserType`)
VALUES
	(1,'Test','password','M'),
	(2,'user123','password123','M'),
	(3,'ilovemovies','moviesaregreat','A'),
	(4,'bobsmith','smithbob','M');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
