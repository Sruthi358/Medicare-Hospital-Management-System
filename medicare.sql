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
