-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 07:12 AM
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
-- Database: `fedbck`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`, `name`, `email`, `password`) VALUES
(1, 'Puja', 'puja@admin.com', '123puja');

-- --------------------------------------------------------

--
-- Table structure for table `average_ratings`
--

CREATE TABLE `average_ratings` (
  `id` int(11) NOT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `role` enum('student','faculty','hod') DEFAULT NULL,
  `average_rating` float DEFAULT NULL,
  `calculated_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `average_ratings`
--

INSERT INTO `average_ratings` (`id`, `user_email`, `role`, `average_rating`, `calculated_on`) VALUES
(1, 'emily.davis@faculty.com', 'faculty', 2, '2025-05-09 15:35:52'),
(2, 'peter.johnson@hod.com', 'hod', 3, '2025-05-09 01:16:54'),
(6, 'andrew.wilson@hod.com', 'hod', 2.5, '2025-05-09 01:17:18'),
(7, 'michael.brown@faculty.com', 'faculty', 2, '2025-05-09 15:34:57'),
(10, 'payal5@faculty.com', 'faculty', 2.25, '2025-05-09 23:07:54'),
(11, 'john.doe@student.com', 'student', 2.33, '2025-05-10 00:04:25');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `dept_name`) VALUES
(1, 'Computer Science'),
(2, 'Information Technology'),
(3, 'Mechanical Engineering'),
(4, 'Civil Engineering'),
(5, 'Electronics and Communication');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`user_id`, `name`, `email`, `mobile`, `password`, `dept_id`, `section_id`, `semester_id`) VALUES
(1, 'Prof. Michael Brown', 'michael.brown@faculty.com', '9876543218', 'michael@abc', 3, 1, 1),
(2, 'Prof. Emily Davis', 'emily.davis@faculty.com', '9876543219', 'emily@def', 2, 2, 2),
(3, 'Prof. Robert White', 'robert.white@faculty.com', '9876543220', 'robert@ghi', 3, 1, 1),
(4, 'Prof. Olivia Green', 'olivia.green@faculty.com', '9876543221', 'olivia@jkl', 4, 2, 2),
(5, 'Dr.Subir Das', 'subir@faculty.com', '8974586954', '$2y$10$gFifWREnbwbNwLcc2ibzB.NV8H2aM.96A2X/OPVFlv63xiU9oiRFu', 4, 2, 3),
(6, 'Dr.Divya Dutta', 'divya9@faculty.com', '9854759846', '$2y$10$ElaeraPhvOzP.8Sk2Qxv.OVtzB/Xk1XeaETyoAFnB68DYJDBHEEn2', 3, 3, 1),
(9, 'Dr.Rima Sen', 'rima1@faculty.com', '7894561285', '$2y$10$UyAmf45E6K5I5SvdRDwonuewbt1WdEvat/iGneKNyAZgdKazSFH3y', 1, 3, 7),
(10, 'Dr.Lovely Sen', 'lovely@faculty.com', '7845789456', '$2y$10$2EzdlFzKScfJjqn6i3nf4uxtMBg1OiuW/.QBImGA7Zriy7cbmVp6C', 1, 4, 4),
(11, 'Dr.Laboni chaterjee', 'laboni@faculty.com', '6885879623', 'Laboni12@', 1, 1, 6),
(12, 'Dr.Payal Sahoo', 'payal5@faculty.com', '8974562325', 'Payal@15', 3, 2, 1),
(13, 'Dr.Priyum Sen', 'priyum@faculty.com', '9812354877', 'Priyam@2', 1, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `fedback`
--

CREATE TABLE `fedback` (
  `id` int(11) NOT NULL,
  `giver_id` int(11) NOT NULL,
  `giver_role` varchar(20) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `receiver_role` varchar(20) NOT NULL,
  `question_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `receiver_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fedback`
--

INSERT INTO `fedback` (`id`, `giver_id`, `giver_role`, `receiver_id`, `receiver_role`, `question_id`, `rating`, `created_at`, `receiver_email`) VALUES
(7, 2, 'student', 2, 'faculty', 1, 2, '2025-05-05 17:07:05', ''),
(15, 1, 'faculty', 1, 'hod', 2, 3, '2025-05-05 17:31:55', ''),
(23, 3, 'faculty', 3, 'hod', 2, 3, '2025-05-06 21:31:03', ''),
(24, 3, 'faculty', 3, 'hod', 4, 3, '2025-05-06 21:31:03', ''),
(25, 3, 'faculty', 3, 'hod', 5, 2, '2025-05-06 21:31:03', ''),
(26, 3, 'faculty', 3, 'hod', 6, 2, '2025-05-06 21:31:03', ''),
(27, 3, 'student', 3, 'faculty', 1, 2, '2025-05-06 21:33:29', ''),
(33, 2, 'hod', 2, 'faculty', 3, 2, '2025-05-06 22:06:05', ''),
(36, 1, 'hod', 1, 'faculty', 3, 2, '2025-05-07 20:09:14', ''),
(37, 2, 'faculty', 0, 'student', 4, 2, '2025-05-07 20:18:36', ''),
(38, 2, 'faculty', 0, 'student', 5, 3, '2025-05-07 20:18:36', ''),
(39, 2, 'faculty', 0, 'student', 6, 2, '2025-05-07 20:18:37', ''),
(41, 3, 'hod', 3, 'faculty', 3, 2, '2025-05-07 20:27:45', ''),
(42, 4, 'faculty', 0, 'student', 4, 2, '2025-05-07 20:30:30', ''),
(43, 4, 'faculty', 0, 'student', 5, 3, '2025-05-07 20:30:30', ''),
(44, 4, 'faculty', 0, 'student', 6, 3, '2025-05-07 20:30:30', ''),
(45, 1, 'student', 12, 'faculty', 1, 2, '2025-05-09 10:36:36', ''),
(46, 1, 'student', 12, 'faculty', 7, 3, '2025-05-09 10:36:37', ''),
(47, 1, 'student', 12, 'faculty', 8, 2, '2025-05-09 10:36:37', ''),
(48, 1, 'student', 12, 'faculty', 9, 2, '2025-05-09 10:36:37', ''),
(49, 12, 'faculty', 0, 'hod', 2, 2, '2025-05-09 16:47:36', ''),
(51, 12, 'faculty', 3, 'hod', 2, 2, '2025-05-09 16:55:53', ''),
(52, 12, 'faculty', 1, 'student', 4, 2, '2025-05-09 17:00:11', ''),
(53, 12, 'faculty', 1, 'student', 5, 3, '2025-05-09 17:00:12', ''),
(54, 12, 'faculty', 1, 'student', 6, 2, '2025-05-09 17:00:12', ''),
(55, 12, 'faculty', 1, 'hod', 2, 2, '2025-05-09 17:00:59', '');

-- --------------------------------------------------------

--
-- Table structure for table `hod`
--

CREATE TABLE `hod` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `dept_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hod`
--

INSERT INTO `hod` (`user_id`, `name`, `email`, `mobile`, `password`, `dept_id`) VALUES
(1, 'Dr. Peter Johnson', 'peter.johnson@hod.com', '9876543214', '$2y$10$BEMRrnlenzBjWhxW8hMr4eFG5y8fvyXBXu/azQ17Ofdn80PrtD9S6', 3),
(2, 'Dr. Sarah Miller', 'sarah.miller@hod.com', '9876543215', 'sarah@456', 2),
(3, 'Dr. Andrew Wilson', 'andrew.wilson@hod.com', '9876543216', 'andrew@789', 3),
(4, 'Dr. Emily Brown', 'emily.brown@hod.com', '9876543217', 'emily@012', 4),
(5, 'hiya modi', 'hiya55@gmail.com', '6985478547', '$2y$10$lydHEkYAhP3QYAI9F43mu.CADY2CfEYb8.tl68dQinUC7HFRFK14S', 1),
(6, 'Dr.Mahadev Biswas', 'mahadev@hod.com', '9856558967', '$2y$10$mk8G2U6bhMK1g5P0zH8FROWriQipNwu166H2WTxl5NvTypPQzLgUe', 1),
(7, 'Dr.Piyali Bose', 'piyali@hod.com', '7895656895', '$2y$10$khxNW.Rk2rHJ8XfJflxvD.kOwpA86lwUCpUJHyxUahBHCeb6gI7lO', 1);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question_text` varchar(255) NOT NULL,
  `role` enum('student','faculty','hod') NOT NULL,
  `feedback_type` enum('student-to-faculty','faculty-to-student','faculty-to-hod','hod-to-faculty') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question_text`, `role`, `feedback_type`, `created_at`) VALUES
(1, 'How well did the instructor explain the course material?', 'student', 'student-to-faculty', '2025-05-05 09:47:06'),
(2, 'How supportive is the HOD in academic and administrative matters?', 'faculty', 'faculty-to-hod', '2025-05-05 10:05:24'),
(3, 'Does the faculty maintain punctuality and attend classes regularly?', 'hod', 'hod-to-faculty', '2025-05-05 10:53:06'),
(4, 'How actively does the student participate in class discussions and activities?', 'faculty', 'faculty-to-student', '2025-05-06 05:15:27'),
(5, 'How well does the student complete assignments on time and with good quality?', 'faculty', 'faculty-to-student', '2025-05-06 05:16:00'),
(6, 'How well does the student ask relevant questions and show interest in learning?', 'faculty', 'faculty-to-student', '2025-05-06 05:16:21'),
(7, 'How effectively did the instructor help you connect the course material to other disciplines or real-world applications?', 'student', 'student-to-faculty', '2025-05-08 21:52:41'),
(8, 'How could the instructor improve the overall learning environment in the course?', 'student', 'student-to-faculty', '2025-05-08 21:55:20'),
(9, 'How well did the instructor explain the course material  and evaluate properly?', 'student', 'student-to-faculty', '2025-05-09 10:03:28'),
(10, 'How knowledgeable is the instructor about the subject matter?', 'student', 'student-to-faculty', '2025-05-09 18:33:21');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `section_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `section_name`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `semester_id` int(11) NOT NULL,
  `semester_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`semester_id`, `semester_name`) VALUES
(1, '1st Semester'),
(2, '2nd Semester'),
(3, '3rd Semester'),
(4, '4th Semester'),
(5, '5th Semester'),
(6, '6th Semester'),
(7, '7th Semester'),
(8, '8th Semester');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`user_id`, `name`, `email`, `mobile`, `password`, `dept_id`, `section_id`, `semester_id`) VALUES
(1, 'John Doe', 'john.doe@student.com', '9876543210', 'john1234', 3, 2, 1),
(2, 'Alice Smith', 'alice.smith@student.com', '9876543211', 'alice5678', 2, 2, 2),
(3, 'David Clark', 'david.clark@student.com', '9876543212', 'david9876', 3, 1, 1),
(4, 'Sophia Lee', 'sophia.lee@student.com', '9876543213', 'sophia4321', 4, 2, 2),
(6, 'piya sen', 'piya12@student.com', '8956412387', '$2y$10$BuDTyYCCtbIic0gPQJDmHuUpcyoXyp0jOJ8zUFZZzqGJIxCrNMG7m', 3, 3, 5),
(7, 'shalu yadav', 'shalu@student.com', '8574123548', '$2y$10$QuTBHALfcUPnC9S2IimCSunHrHvrBtJ1JePfREi.IyrfAOv0IeIVq', 5, 3, 5),
(8, 'Hridiya Dey', 'hridiya@student.com', '9857495778', 'Hridya@12345', 1, 4, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `average_ratings`
--
ALTER TABLE `average_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_role` (`user_email`,`role`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `semester_id` (`semester_id`);

--
-- Indexes for table `fedback`
--
ALTER TABLE `fedback`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_feedback_per_question` (`giver_id`,`receiver_id`,`question_id`);

--
-- Indexes for table `hod`
--
ALTER TABLE `hod`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `dept_id` (`dept_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`semester_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `semester_id` (`semester_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `average_ratings`
--
ALTER TABLE `average_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `fedback`
--
ALTER TABLE `fedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `hod`
--
ALTER TABLE `hod`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `semester_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`),
  ADD CONSTRAINT `faculty_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`),
  ADD CONSTRAINT `faculty_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`);

--
-- Constraints for table `hod`
--
ALTER TABLE `hod`
  ADD CONSTRAINT `hod_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`),
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`),
  ADD CONSTRAINT `student_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
