CREATE DATABASE OMTS;
USE OMTS;
CREATE TABLE Complex (
	ComplexNo INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	Name VARCHAR(50) NOT NULL, 
	Address VARCHAR(100) NOT NULL,
	Phone CHAR(10) NOT NULL
);
CREATE TABLE Theater (
	TheaterNo INT NOT NULL, 
	ComplexNo INT NOT NULL,
	Seats INT NOT NULL, 
	Screen ENUM('S', 'M', 'L') NOT NULL,
	PRIMARY KEY(ComplexNo, TheaterNo),	
	FOREIGN KEY (ComplexNo) REFERENCES Complex(ComplexNo)
);
CREATE TABLE Supplier(
	SupplierID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Name VARCHAR(50) NOT NULL,
	Address VARCHAR(100) NOT NULL,
	Phone CHAR(10) NOT NULL,
	Contact VARCHAR(100) NOT NULL
);
CREATE TABLE Movie(
	MovieID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	Title VARCHAR(60) NOT NULL,
	RunTime INT NOT NULL,
	Rating ENUM('G', 'PG','14A', '18A','R', 'A') NOT NULL,
	Plot TEXT,
	Director VARCHAR(100) NOT NULL,
	Producer VARCHAR(100) NOT NULL,
	SDate DATE NOT NULL,
	EDate DATE NOT NULL,
	SupplierID INT NOT NULL,
	FOREIGN KEY (SupplierID) REFERENCES Supplier(SupplierID)
);
CREATE TABLE Actors (
	FName VARCHAR(50) NOT NULL,
	LName VARCHAR(50) NOT NULL,
	MovieID INT NOT NULL,
	FOREIGN KEY (MovieID) REFERENCES Movie(MovieID)
);
CREATE TABLE Showing (
	STime TIME NOT NULL,
	SDate DATE NOT NULL,
	TheaterNo INT NOT NULL,
	ComplexNo INT NOT NULL,
	BookedSeats INT NOT NULL,
	MovieID INT NOT NULL,
	FOREIGN KEY (ComplexNo, TheaterNo) REFERENCES Theater(ComplexNo, TheaterNo),
	FOREIGN KEY (MovieID) REFERENCES Movie(MovieID),
	PRIMARY KEY (STime, SDate, TheaterNo, ComplexNo, MovieID)
);
CREATE TABLE Users(
	UserID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	Login VARCHAR(50) NOT NULL,
	Password VARCHAR(100) NOT NULL,
	UserType ENUM('M', 'A')
);
--Check how we will be doing primary key in Reservations
CREATE TABLE Reservation(
	UserID INT NOT NULL,
	STime TIME NOT NULL,
	SDate DATE NOT NULL,
	TheaterNo INT NOT NULL,
	ComplexNo INT NOT NULL,
	MovieID INT NOT NULL,
	NumTickets INT NOT NULL,
	FOREIGN KEY (STime, SDate, MovieID) REFERENCES Showing(STime, SDate, MovieID),
	FOREIGN KEY (UserID) REFERENCES Users(UserID),
	PRIMARY KEY (UserID, STime, SDate, MovieID)
);
CREATE TABLE Member(
	UserID INT NOT NULL,
	Name VARCHAR(100) NOT NULL,
	Address VARCHAR(100),
	Phone CHAR(10),
	Email VARCHAR(50) NOT NULL,
	CreditNo CHAR(16) NOT NULL,
	CreditExp DATE NOT NULL,
	FOREIGN KEY (UserID) REFERENCES Users(UserID)
);
CREATE TABLE Review(
	Words TEXT,
	UserID INT NOT NULL,
	Score INT NOT NULL,
	MovieID INT NOT NULL,
	FOREIGN KEY (UserID) REFERENCES Users(UserID),
	FOREIGN KEY (MovieID) REFERENCES Movie(MovieID)
);