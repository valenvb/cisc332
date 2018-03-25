-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2018 at 08:10 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `omts`
--

-- --------------------------------------------------------

--
-- Table structure for table `actors`
--

CREATE TABLE `actors` (
  `FName` varchar(50) NOT NULL,
  `LName` varchar(50) NOT NULL,
  `MovieID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `actors`
--

INSERT INTO `actors` (`FName`, `LName`, `MovieID`) VALUES
('Tim', 'Robbins ', 1),
('Morgan', 'Freeman', 1),
('Marlon ', 'Brando', 2),
('Al ', 'Pacino', 2),
('John ', 'Travolta', 3),
('Uma ', 'Thurman', 3),
('Samuel L. ', 'Jackson', 3),
('John ', 'Boyega', 4),
('Scott ', 'Eastwood', 4),
('Kelly ', 'Asbury', 5),
('Mary J. ', 'Blige', 5),
('Storm ', 'Reid', 6),
('Oprah ', 'Winfrey', 6),
('Chadwick ', 'Boseman', 7),
('Lupita ', 'Nyong\'o', 7),
('Michael B. ', 'Jordan', 7),
('Elijah ', 'Wood', 8),
('Viggo ', 'Mortensen', 8),
('Ian ', 'McKellen', 8),
('Alicia ', 'Vikander', 9),
('Tom ', 'Hanks', 10),
('Matt', 'Damon', 10),
('Tom ', 'Sizemore', 10);

-- --------------------------------------------------------

--
-- Table structure for table `complex`
--

CREATE TABLE `complex` (
  `ComplexNo` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Phone` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complex`
--

INSERT INTO `complex` (`ComplexNo`, `Name`, `Address`, `Phone`) VALUES
(1, 'MegaTheater ', '9 City Road Kingston, ON ', '6132345678'),
(2, 'Cineplex ', '21 First Street, Kingston ON ', '6131231234'),
(3, 'MovieBox', '12 Main Street, Springfield TX', '1112223333'),
(4, 'IMAX', '67 Fist Ave New York, NY', '9897675455');

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `MovieID` int(11) NOT NULL,
  `Title` varchar(60) NOT NULL,
  `RunTime` int(11) NOT NULL,
  `Rating` enum('G','PG','14A','18A','R','A') NOT NULL,
  `Plot` text,
  `Director` varchar(100) NOT NULL,
  `Producer` varchar(100) NOT NULL,
  `SDate` date NOT NULL,
  `EDate` date NOT NULL,
  `SupplierID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`MovieID`, `Title`, `RunTime`, `Rating`, `Plot`, `Director`, `Producer`, `SDate`, `EDate`, `SupplierID`) VALUES
(1, 'The Shawshank Redemption', 142, 'R', 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', 'Frank Darabont', 'Liz Glotzer, David V. Lester, Niki Marvin', '2018-03-25', '2018-06-30', 1),
(2, ' The Godfather', 175, 'R', 'When the aging head of a famous crime family decides to transfer his position to one of his subalterns, a series of unfortunate events start happening to the family, and a war begins between all the well-known families leading to insolence, deportation, murder and revenge, and ends with the favorable successor being finally chosen.', 'Francis Ford Coppola', 'Paramount Pictures', '2018-03-09', '2018-06-15', 2),
(3, 'Pulp Fiction', 154, 'R', 'The lives of two mob hitmen, a boxer, a gangster\'s wife, and a pair of diner bandits intertwine in four tales of violence and redemption.', 'Quentin Tarantino', 'Miramax', '2018-03-25', '2018-08-31', 3),
(4, 'Pacific Rim: Uprising', 111, '14A', 'Jake Pentecost, son of Stacker Pentecost, reunites with Mako Mori to lead a new generation of Jaeger pilots, including rival Lambert and 15-year-old hacker Amara, against a new Kaiju threat.', 'Steven S. DeKnight', 'Double Dare You (DDY)', '2018-03-23', '2018-06-15', 1),
(5, 'Sherlock Gnomes', 86, 'PG', 'Garden gnomes, Gnomeo & Juliet, recruit renowned detective Sherlock Gnomes to investigate the mysterious disappearance of other garden ornaments.', 'John Stevenson', 'Metro-Goldwyn-Mayer (MGM)', '2018-03-23', '2018-06-13', 2),
(6, ' A Wrinkle in Time', 109, 'PG', 'Following the discovery of a new form of space travel as well as Meg\'s father\'s disappearance, she, her brother, and her friend must join three magical beings - Mrs. Whatsit, Mrs. Who, and Mrs. Which - to travel across the universe to rescue him from a terrible evil.', 'Ava DuVernay', 'Walt Disney Pictures', '2018-03-09', '2018-06-14', 4),
(7, 'Black Panther', 134, '14A', 'After the events of Captain America: Civil War, King T\'Challa returns home to the reclusive, technologically advanced African nation of Wakanda to serve as his country\'s new leader. However, T\'Challa soon finds that he is challenged for the throne from factions within his own country. When two foes conspire to destroy Wakanda, the hero known as Black Panther must team up with C.I.A. agent Everett K. Ross and members of the Dora Milaje, Wakandan special forces, to prevent Wakanda from being dragged into a world war.', 'Ryan Coogler ', 'Marvel Studios', '2018-02-16', '2018-03-31', 4),
(8, 'The Lord of the Rings: The Return of the King', 201, 'PG', 'Gandalf and Aragorn lead the World of Men against Sauron\'s army to draw his gaze from Frodo and Sam as they approach Mount Doom with the One Ring.', 'Peter Jackson', 'New Line Cinema', '2018-03-01', '2018-07-20', 5),
(9, 'Tomb Raider', 118, 'PG', 'Lara Croft, the fiercely independent daughter of a missing adventurer, must push herself beyond her limits when she finds herself on the island where her father disappeared.', 'Roar Uthaug', 'GK Films', '2018-03-16', '2018-06-14', 5),
(10, 'Saving Private Ryan', 169, 'R', 'Following the Normandy Landings, a group of U.S. soldiers go behind enemy lines to retrieve a paratrooper whose brothers have been killed in action.', 'Steven Spielberg', 'DreamWorks', '2018-05-17', '2018-09-20', 2);

-- --------------------------------------------------------

--
-- Table structure for table `showing`
--

CREATE TABLE `showing` (
  `STime` time NOT NULL,
  `SDate` date NOT NULL,
  `TheaterNo` int(11) NOT NULL,
  `ComplexNo` int(11) NOT NULL,
  `BookedSeats` int(11) NOT NULL,
  `MovieID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `showing`
--

INSERT INTO `showing` (`STime`, `SDate`, `TheaterNo`, `ComplexNo`, `BookedSeats`, `MovieID`) VALUES
('12:00:00', '2018-04-19', 4, 2, 0, 8),
('15:00:00', '2018-04-01', 2, 1, 0, 10),
('16:00:00', '2018-03-25', 1, 1, 0, 1),
('17:00:00', '2018-03-29', 2, 2, 0, 4),
('17:30:00', '0000-00-00', 2, 1, 0, 5),
('18:00:00', '2018-03-26', 1, 1, 0, 2),
('18:00:00', '2018-03-15', 3, 3, 0, 7),
('20:00:00', '2018-03-29', 1, 2, 0, 5),
('20:00:00', '2018-03-31', 1, 2, 0, 6),
('20:00:00', '2018-03-28', 4, 2, 0, 9),
('20:30:00', '2018-03-26', 1, 1, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Phone` char(10) NOT NULL,
  `Contact` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `Name`, `Address`, `Phone`, `Contact`) VALUES
(1, 'Columbia Pictures ', '98 West Street New York, NY ', '2135467689', 'John Smith '),
(2, 'Paramount Pictures', '5555 Melrose Avenue, Hollywood, CA', '3239565000', 'Jim Gianopulos'),
(3, 'Miramax', '17 East Ave Los Angeles, California', '9876543211', 'Bill Block'),
(4, 'Walt Disney Company  ', '21 Magic Kingdom Orlando, FL', '1234567890', 'Walt Disney '),
(5, 'Warner Bros.', '1 Main st Hollywood, LA', '1112223333', 'Warner Bro ');

-- --------------------------------------------------------

--
-- Table structure for table `theater`
--

CREATE TABLE `theater` (
  `TheaterNo` int(11) NOT NULL,
  `ComplexNo` int(11) NOT NULL,
  `Seats` int(11) NOT NULL,
  `Screen` enum('S','M','L') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `theater`
--

INSERT INTO `theater` (`TheaterNo`, `ComplexNo`, `Seats`, `Screen`) VALUES
(1, 1, 100, 'S'),
(2, 1, 180, 'M'),
(1, 2, 200, 'M'),
(2, 2, 100, 'S'),
(3, 2, 500, 'L'),
(4, 2, 200, 'M'),
(1, 3, 100, 'S'),
(2, 3, 500, 'L'),
(3, 3, 200, 'M'),
(1, 4, 1000, 'L'),
(2, 4, 1000, 'L');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Login` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `UserType` enum('M','A') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Login`, `Password`, `UserType`) VALUES
(1, 'Test', 'password', 'M'),
(2, 'user123', 'password123', 'M'),
(3, 'ilovemovies', 'moviesaregreat', 'A'),
(4, 'bobsmith', 'smithbob', 'M');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actors`
--
ALTER TABLE `actors`
  ADD KEY `MovieID` (`MovieID`);

--
-- Indexes for table `complex`
--
ALTER TABLE `complex`
  ADD PRIMARY KEY (`ComplexNo`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`MovieID`),
  ADD KEY `SupplierID` (`SupplierID`);

--
-- Indexes for table `showing`
--
ALTER TABLE `showing`
  ADD PRIMARY KEY (`STime`,`MovieID`),
  ADD KEY `ComplexNo` (`ComplexNo`,`TheaterNo`),
  ADD KEY `MovieID` (`MovieID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- Indexes for table `theater`
--
ALTER TABLE `theater`
  ADD PRIMARY KEY (`ComplexNo`,`TheaterNo`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complex`
--
ALTER TABLE `complex`
  MODIFY `ComplexNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `MovieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `SupplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actors`
--
ALTER TABLE `actors`
  ADD CONSTRAINT `actors_ibfk_1` FOREIGN KEY (`MovieID`) REFERENCES `movie` (`MovieID`);

--
-- Constraints for table `movie`
--
ALTER TABLE `movie`
  ADD CONSTRAINT `movie_ibfk_1` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`SupplierID`);

--
-- Constraints for table `showing`
--
ALTER TABLE `showing`
  ADD CONSTRAINT `showing_ibfk_1` FOREIGN KEY (`ComplexNo`,`TheaterNo`) REFERENCES `theater` (`ComplexNo`, `TheaterNo`),
  ADD CONSTRAINT `showing_ibfk_2` FOREIGN KEY (`MovieID`) REFERENCES `movie` (`MovieID`);

--
-- Constraints for table `theater`
--
ALTER TABLE `theater`
  ADD CONSTRAINT `theater_ibfk_1` FOREIGN KEY (`ComplexNo`) REFERENCES `complex` (`ComplexNo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
