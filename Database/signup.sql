-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2019 at 06:26 PM
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
-- Table structure for table `tbl_confirm_friend_list`
--

CREATE TABLE `tbl_confirm_friend_list` (
  `PK_confirm_friend_listID` int(11) NOT NULL,
  `FK_UserID` int(11) NOT NULL,
  `FriendUserID` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_confirm_friend_list`
--

INSERT INTO `tbl_confirm_friend_list` (`PK_confirm_friend_listID`, `FK_UserID`, `FriendUserID`, `Status`) VALUES
(2, 3, 1, 'confirm'),
(3, 3, 5, 'confirm'),
(4, 6, 1, 'confirm'),
(5, 8, 9, 'panding'),
(6, 9, 6, 'panding'),
(7, 6, 7, 'confirm');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_bank_details`
--

CREATE TABLE `tbl_user_bank_details` (
  `PK_User_Bank_DetailsID` int(11) NOT NULL,
  `FK_UserID` int(11) NOT NULL,
  `Bank_Name` varchar(50) NOT NULL,
  `Bank_Holder_Name` varchar(100) NOT NULL,
  `Account_Type` varchar(50) NOT NULL,
  `Account_Number` varchar(100) NOT NULL,
  `IFSC_Code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_bank_details`
--

INSERT INTO `tbl_user_bank_details` (`PK_User_Bank_DetailsID`, `FK_UserID`, `Bank_Name`, `Bank_Holder_Name`, `Account_Type`, `Account_Number`, `IFSC_Code`) VALUES
(1, 5, 'sbi', 'arnabdey', 'saving', '123456789', 'sbin123456789'),
(2, 5, 'ubi', 'arnab', 'saving', '1478965236', 'ubin1456'),
(3, 5, 'ubi', 'arnab', 'saving', '1478965236', 'ubin1456'),
(5, 5, 'HDFC', '', '', '', ''),
(6, 5, 'axis', 'arnab', 'current', '1234567891', 'sbin123456789'),
(7, 22, 'SBI', 'amit Biswas', 'Saving', '123456789123456', 'SBI123456');

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
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  `Username` varchar(255) NOT NULL,
  `Password` varchar(150) NOT NULL,
  `Mobile_Number` bigint(20) NOT NULL,
  `Email_Address` varchar(100) NOT NULL,
  `Full_Name` varchar(150) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Bank_Name` varchar(50) NOT NULL,
  `Bank_Holder_Name` varchar(100) NOT NULL,
  `Account_Type` varchar(50) NOT NULL,
  `Account_Number` varchar(100) NOT NULL,
  `IFSC_Code` varchar(100) NOT NULL,
  `Profile_Picture_Path` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_information`
--

INSERT INTO `tbl_user_information` (`PK_UserID`, `FK_CreatedBy`, `CreatedDate`, `FK_ModifyBy`, `ModifyDate`, `IsActive`, `IsDeleted`, `Username`, `Password`, `Mobile_Number`, `Email_Address`, `Full_Name`, `Address`, `Bank_Name`, `Bank_Holder_Name`, `Account_Type`, `Account_Number`, `IFSC_Code`, `Profile_Picture_Path`) VALUES
(1, 1, '2019-05-25 00:00:00', 1, '2019-07-21 08:36:42', b'1', b'0', 'mousou', '123456', 7001629549, 'abc@gmail.com', 'moumita', 'durgapur', 'hsbc', 'moumita', 'saving', '123456789', 'dgr123456789', './Resources/2019/1/User/ProfilePic/201907210836421mousou.jpg'),
(3, 0, '2019-05-26 16:28:36', 0, '0000-00-00 00:00:00', b'0', b'0', 'moumita', '123456', 9966332255, 'moumita@gmail.com', '', '', '', '', '', '', '', ''),
(4, 0, '2019-05-27 17:38:29', 1, '2019-07-21 08:21:13', b'1', b'0', 'sourav', 'e10adc3949ba59abbe56e057f20f883e', 9851757473, 'soumou@gmail.com', 'SouMou', 'BBC Malda', 'Bandhan', 'SOUMOU', 'SAVING', '147896325412', 'HBP123456', './Resources/2019/4/User/ProfilePic/201907210821134.jpg'),
(5, 1, '2019-07-23 00:00:00', 1, '2019-07-27 12:35:28', b'1', b'0', 'arnab', '123456', 9632587415, 'arnab1@gmail.com', 'arnab1', 'malda12', '', '', '', '', '', ''),
(6, 1, '2019-07-28 00:00:00', 0, '0000-00-00 00:00:00', b'1', b'0', 'amit', '123456', 9632587415, 'amit@gmail.com', 'Amit Singha', 'Buniyadpur', '', '', '', '', '', ''),
(7, 1, '2019-07-28 00:00:00', 0, '0000-00-00 00:00:00', b'1', b'0', 'rahul', '123456', 9876541236, 'rahul@gmail.com', 'rahul shina', 'balurghat', '', '', '', '', '', ''),
(8, 1, '2019-07-28 00:00:00', 0, '0000-00-00 00:00:00', b'1', b'0', 'rimpa', '123456', 9632587412, 'rimpa@gmail.com', 'rimpa paul', 'BBC', '', '', '', '', '', ''),
(9, 1, '2019-07-28 00:00:00', 0, '0000-00-00 00:00:00', b'1', b'0', 'asit', '123456', 7895478965, 'asit@gmail.com', 'asit paul', 'Aiho', '', '', '', '', '', ''),
(22, 0, '2019-07-28 17:57:51', 1, '2019-07-29 17:01:29', b'0', b'0', 'amit', '25d55ad283aa400af464c76d713c07ad', 2563214587, 'amit1@gmail.com', 'amit harami', 'balurghat', '', '', '', '', '', ''),
(26, 0, '2019-07-28 18:56:38', 1, '2019-07-28 19:24:38', b'1', b'0', '', '25d55ad283aa400af464c76d713c07ad', 9851836310, '', '', '', '', '', '', '', '', '');

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
-- Indexes for table `tbl_confirm_friend_list`
--
ALTER TABLE `tbl_confirm_friend_list`
  ADD PRIMARY KEY (`PK_confirm_friend_listID`);

--
-- Indexes for table `tbl_user_bank_details`
--
ALTER TABLE `tbl_user_bank_details`
  ADD PRIMARY KEY (`PK_User_Bank_DetailsID`),
  ADD KEY `FK_UserID` (`FK_UserID`);

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
-- AUTO_INCREMENT for table `tbl_confirm_friend_list`
--
ALTER TABLE `tbl_confirm_friend_list`
  MODIFY `PK_confirm_friend_listID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_user_bank_details`
--
ALTER TABLE `tbl_user_bank_details`
  MODIFY `PK_User_Bank_DetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_user_information`
--
ALTER TABLE `tbl_user_information`
  MODIFY `PK_UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `usersdata`
--
ALTER TABLE `usersdata`
  MODIFY `PK_UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_user_bank_details`
--
ALTER TABLE `tbl_user_bank_details`
  ADD CONSTRAINT `tbl_user_bank_details_ibfk_1` FOREIGN KEY (`FK_UserID`) REFERENCES `tbl_user_information` (`PK_UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
