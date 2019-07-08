-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2019 at 08:33 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `signup`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `PK_AdminID` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`PK_AdminID`, `UserName`, `Password`) VALUES
(1, 'Admin', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_information`
--

CREATE TABLE `tbl_user_information` (
  `PK_UserID` int(11) NOT NULL,
  `FK_CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `FK_ModifyBy` int(11) NOT NULL,
  `ModifyDate` datetime NOT NULL,
  `IsActive` int(11) NOT NULL,
  `IsDeleted` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(150) NOT NULL,
  `Mobile_Number` bigint(20) NOT NULL,
  `Email_Address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_information`
--

INSERT INTO `tbl_user_information` (`PK_UserID`, `FK_CreatedBy`, `CreatedDate`, `FK_ModifyBy`, `ModifyDate`, `IsActive`, `IsDeleted`, `Username`, `Password`, `Mobile_Number`, `Email_Address`) VALUES
(1, 1, '2019-05-25 00:00:00', 0, '0000-00-00 00:00:00', 1, 0, 'mousou', '123456', 9851757473, 'soumou@gmail.com'),
(3, 0, '2019-05-26 16:28:36', 0, '0000-00-00 00:00:00', 0, 0, 'moumita', '123456', 9966332255, 'moumita@gmail.com'),
(4, 0, '2019-05-27 17:38:29', 0, '0000-00-00 00:00:00', 0, 0, 'sourav', '25f9e794323b453885f5181f1b624d0b', 9966332255, 'sourav@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `usersdata`
--

CREATE TABLE `usersdata` (
  `PK_UserID` int(11) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  `Name` varchar(100) NOT NULL,
  `Mobile` varchar(15) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `DOB` date NOT NULL,
  `Nationality` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usersdata`
--

INSERT INTO `usersdata` (`PK_UserID`, `IsActive`, `IsDeleted`, `Name`, `Mobile`, `Email`, `DOB`, `Nationality`) VALUES
(1, b'1', b'0', 'SOURAV', '9632587452', 'abc@gmail.com', '2018-12-03', 'Indian'),
(2, b'1', b'0', 'amit123', '1234567854', 'amit@gmail.com', '1994-01-20', 'indian'),
(5, b'1', b'0', 'Moumita Majumdar', '9835698574', 'souvar@gmail.com', '0000-00-00', 'indian');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`PK_AdminID`);

--
-- Indexes for table `tbl_user_information`
--
ALTER TABLE `tbl_user_information`
  ADD PRIMARY KEY (`PK_UserID`);

--
-- Indexes for table `usersdata`
--
ALTER TABLE `usersdata`
  ADD PRIMARY KEY (`PK_UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `PK_AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_user_information`
--
ALTER TABLE `tbl_user_information`
  MODIFY `PK_UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usersdata`
--
ALTER TABLE `usersdata`
  MODIFY `PK_UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
