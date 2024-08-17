-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Aug 17, 2024 at 07:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medicare`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--
CREATE DATABASE medicare;
USE medicare;
CREATE TABLE `appointment` (
  `sno` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `speciality` enum('Neurologist','Psychiatrist','General physician','Surgeon','Oncologist','Dermatologist','Cardiologist','Gynaecologist') NOT NULL,
  `doc_name` text NOT NULL,
  `doa` date NOT NULL,
  `toa` enum('9:30 AM','10:00 AM','10:30 AM','11:00 AM','11:30 AM','12:00 PM','12:30 PM','2:00 PM','2:30 PM','3:00 PM','3:30 PM','4:00 PM','4:30 PM','5:00 PM','5:30 PM') NOT NULL,
  `type` enum('New consultation','Follow up') NOT NULL,
  `reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`sno`, `username`, `speciality`, `doc_name`, `doa`, `toa`, `type`, `reason`) VALUES
(1, 'sruthi2005', 'Psychiatrist', 'Tuheena sarma', '2024-06-23', '3:00 PM', 'New consultation', 'Depression'),
(2, 'sohana123', 'Cardiologist', 'Dinesh Kumar', '2024-06-24', '3:30 PM', 'New consultation', 'Pain'),
(3, 'sruthi2005', 'Gynaecologist', 'Sruthi Reddy', '2024-06-27', '11:00 AM', 'New consultation', 'body pains'),
(4, 'sohana123', 'Cardiologist', 'Dinesh Kumar', '2024-07-01', '2:30 PM', 'New consultation', 'Chest pain'),
(5, 'sruthi2005', 'Dermatologist', 'Niranjan', '2024-06-29', '11:00 AM', 'New consultation', 'Skin Allergy'),
(6, 'sravani05', 'General physician', 'Anjali', '2024-06-27', '3:30 PM', 'Follow up', 'Fever'),
(7, 'srinija2005', 'General physician', 'Anjali', '2024-06-28', '10:00 AM', 'New consultation', 'Headache'),
(14, 'vijay987', 'Psychiatrist', 'Tuheena sarma', '2024-07-05', '5:00 PM', 'New consultation', 'Sleep Disorder'),
(15, 'sruthi2005', 'General physician', 'Pranathi Reddy', '2024-07-03', '2:30 PM', 'New consultation', 'Headache'),
(16, 'sruthi2005', 'General physician', 'Anjali', '2024-08-28', '4:30 PM', 'Follow up', 'hi');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_history`
--

CREATE TABLE `appointment_history` (
  `username` varchar(50) NOT NULL,
  `doc_name` varchar(50) NOT NULL,
  `doa` date NOT NULL,
  `toa` time NOT NULL,
  `speciality` varchar(50) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('unread','read') NOT NULL DEFAULT 'unread',
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_history`
--

INSERT INTO `appointment_history` (`username`, `doc_name`, `doa`, `toa`, `speciality`, `reason`, `time`, `status`, `id`) VALUES
('sruthi2005', 'Nishant Reddy', '2024-06-28', '03:00:00', 'Neurologist', 'Leg pains', '2024-06-27 19:55:00', 'read', 1),
('srihitha04', 'Nishant Reddy', '2024-07-06', '11:30:00', 'Neurologist', 'Brain Tumor', '2024-06-27 21:12:03', 'read', 2),
('likith05', 'Pranathi Reddy', '2024-07-04', '03:00:00', 'General physician', 'cold', '2024-06-28 16:10:42', 'read', 6);

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `sno` int(11) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `dob` date NOT NULL,
  `phone` bigint(10) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `languages` set('Telugu','Hindi','English','Tamil') NOT NULL,
  `qualification` varchar(50) NOT NULL,
  `speciality` enum('Neurologist','Psychiatrist','General physician','Surgeon','Oncologist','Dermatologist','Cardiologist','Gynaecologist') NOT NULL,
  `area` varchar(30) NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `code` int(10) NOT NULL,
  `password` varchar(30) NOT NULL,
  `photo` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`sno`, `name`, `username`, `email`, `dob`, `phone`, `gender`, `languages`, `qualification`, `speciality`, `area`, `city`, `state`, `code`, `password`, `photo`) VALUES
(1, 'Dinesh Kumar', 'dinesh05', 'dinesh@gmail.com', '1982-12-05', 9876543210, 'Male', 'Telugu,Hindi,English', 'MBBS', 'Cardiologist', 'Vanasthalipuram', 'Hyderabad', 'Telangana', 500032, '12345.', 'images/doc6.png'),
(2, 'Sruthi Reddy', 'sruthi05', 'sruthi@gmail.com', '1980-07-23', 9876556789, 'Female', 'Telugu,English', 'MBBS', 'Gynaecologist', 'Saroornagar', 'Hyderabad', 'Telangana', 500035, '12345.', 'images/doc7.png'),
(3, 'Tuheena sarma', 'tuheena05', 'tuheena@gmail.com', '1992-04-29', 9876567890, 'Female', 'Telugu,English', 'MBBS, Doctor of Medicine(Psychology)', 'Psychiatrist', 'LB Nagar', 'Hyderabad', 'Telangana', 500034, '12345.', 'images/doc5.jpg'),
(4, 'Nishant Reddy', 'nishant05', 'nishant@gmail.com', '1989-03-02', 9846734789, 'Male', 'Telugu,Hindi,English', 'MBBS, Doctor of Medicine(Neurology)', 'Neurologist', 'Vanasthalipuram', 'Rangareddy', 'TELANGANA', 500035, '123456;', 'images/doc1.jpg'),
(5, 'Pranathi Reddy', 'pranathi05', 'pranathi@gmail.com', '1996-09-23', 8734145787, 'Female', 'Telugu,Hindi,English', 'MBBS', 'General physician', 'LB Nagar', 'Rangareddy', 'TELANGANA', 500035, '123456;', 'images/doc4.jpg'),
(6, 'Niranjan ', 'niranjan05', 'niranjan@gmail.com', '0001-06-23', 9834458621, 'Male', 'Telugu,English,Tamil', 'MBBS,Dermatology', 'Dermatologist', 'Uppal', 'Hyderabad', 'Telangana', 500035, '123456;', 'images/doc8.jpeg'),
(7, 'Anjali', 'anjali05', 'anjali@gmail.com', '1978-02-14', 6300436184, 'Female', 'Telugu,English', 'MBBS', 'General physician', 'Bandlaguda', 'Hyderabad', 'Telangana', 500035, '123456;', 'images/doc3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `sno` int(11) NOT NULL,
  `name` text NOT NULL,
  `doc_name` text NOT NULL,
  `speciality` enum('Neurologist','Psychiatrist','General physician','Surgeon','Oncologist','Dermatologist','Cardiologist','Gynaecologist') NOT NULL,
  `feedback` text NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`sno`, `name`, `doc_name`, `speciality`, `feedback`, `time`) VALUES
(3, 'sruthi', 'Tuheena sarma', 'Psychiatrist', 'Veey good', '2024-06-22 19:36:08'),
(4, 'srinija', 'Anjali', 'General physician', 'Good treatment', '2024-06-26 13:09:35'),
(6, 'srihitha', 'Nishant Reddy', 'Neurologist', 'They explained clearly and answered all my questions', '2024-06-26 13:23:15'),
(8, 'Sraavani', 'Anjali', 'General physician', 'Thankyou for your dedication and support', '2024-06-28 12:19:34'),
(9, 'Sraavani', 'Pranathi Reddy', 'General physician', 'I feel confident in the care you provide', '2024-06-28 12:24:34');

-- --------------------------------------------------------

--
-- Table structure for table `leave_request`
--

CREATE TABLE `leave_request` (
  `sno` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `doc_name` varchar(30) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `comments` varchar(100) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Accepted','Pending','Rejected') NOT NULL DEFAULT 'Pending',
  `status_read` enum('read','unread') NOT NULL DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_request`
--

INSERT INTO `leave_request` (`sno`, `username`, `doc_name`, `reason`, `start_date`, `end_date`, `comments`, `time`, `status`, `status_read`) VALUES
(6, 'nishant05', 'Nishant Reddy', 'I have sister\'s marriage', '2024-07-03', '2024-07-03', 'Please accept my leave', '2024-06-27 19:39:06', 'Accepted', 'read'),
(7, 'dinesh05', 'Dinesh Kumar', 'Health is not well', '2024-06-29', '2024-07-02', 'Please accept my leave', '2024-06-27 19:41:22', 'Accepted', 'read'),
(9, 'nishant05', 'Nishant Reddy', 'Going for a tour', '2024-07-04', '2024-07-04', 'Please accept my leave', '2024-06-27 20:58:49', 'Pending', 'unread'),
(10, 'anjali05', 'Anjali', 'Marriage', '2024-06-29', '2024-07-03', 'Please accept my leave', '2024-06-28 09:42:48', 'Rejected', 'read');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `sno` int(3) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `dob` date NOT NULL,
  `phone` bigint(10) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `area` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `code` int(10) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`sno`, `name`, `username`, `email`, `dob`, `phone`, `gender`, `area`, `city`, `state`, `code`, `password`) VALUES
(1, 'sohana', 'sohana123', 'gsohana95@gmail.com', '2005-09-03', 9381224969, 'Female', 'siddipet', 'hyderabad', 'Telangana', 500035, '123456;'),
(2, 'Sruthi ', 'sruthi2005', 'asruthi3525@gmail.com', '2001-12-28', 9876543210, 'Female', 'Jubliee hills', 'Hyderabad', 'Telangana', 500035, '12345678/'),
(3, 'srinija', 'srinija2005', 'narayanamsrinija18@gmail.com', '2005-08-18', 8179626262, 'Female', 'Gollapudi', 'Vijayawada', 'Andhrapradesh', 521225, '12345;'),
(4, 'srihitha', 'srihitha04', 'rsrihitha1712@gmail.com', '2004-12-17', 7672006809, 'Female', 'Dilshuknagar', 'Hyderabad', 'Telangana', 500035, '12346;'),
(5, 'Sraavani', 'sravani05', 'sravani34@gmail.com', '2004-08-23', 8567348572, 'Female', 'Nalgonda', 'Hyderabad', 'Telangana', 500035, '123456;'),
(7, 'Sunitha', 'sunitha05', 'nvlsunitha.5@gmail.com', '1980-06-12', 9390244541, 'Female', 'Saroornagar', 'Rangareddy', 'Telangana', 500035, '12345;'),
(8, 'Ramesh', 'ramesh05', 'ramesh34@gmail.com', '1984-07-15', 9823456278, 'Male', 'Suryapet', 'Hyderabad', 'Telangana', 500035, '123456;'),
(9, 'Likith', 'likith05', 'likith54@gmail.com', '1979-04-07', 7533862768, 'Male', 'Miryalaguda', 'Suryapet', 'Telangana', 500035, '123456;'),
(10, 'Vijay', 'vijay987', 'vijay98@gmail.com', '1987-10-03', 8745382945, 'Male', 'Karimanagar', 'Hyderabad', 'Telangana', 500035, '123456;'),
(11, 'Srinidhi', 'srinidhi02', 'srinidhi123@gmail.com', '2001-09-20', 9876567890, 'Female', 'Saroornagar', 'Hyderabad', 'Telangana', 500035, '123456;');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `appointment_history`
--
ALTER TABLE `appointment_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `leave_request`
--
ALTER TABLE `leave_request`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`sno`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `appointment_history`
--
ALTER TABLE `appointment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `leave_request`
--
ALTER TABLE `leave_request`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `sno` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
