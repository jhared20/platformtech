-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2026 at 10:05 AM
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
-- Database: `student_enrollment`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Mathematics 101', 'Fundamentals of Algebra and Geometry. Learn basic mathematical concepts including equations, functions, and geometric properties.', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(2, 'English Literature', 'Study of classical and modern literature including novels, poetry, and drama. Develop critical thinking and analysis skills.', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(3, 'Physics 201', 'Introduction to Classical and Modern Physics. Covers mechanics, thermodynamics, waves, and basic quantum theory.', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(4, 'Chemistry 101', 'General Chemistry course covering atomic structure, chemical bonding, reactions, and stoichiometry.', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(5, 'Biology 101', 'Introduction to Biology. Study of cell structure, genetics, evolution, and ecology.', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(6, 'History of Western Civilization', 'Comprehensive study of Western Europe from Ancient Greece to modern times.', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(7, 'Introduction to Computer Science', 'Fundamentals of programming, algorithms, data structures, and computational thinking.', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(8, 'Business Management 101', 'Principles of business management, organizational behavior, and strategic planning.', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(9, 'Psychology 101', 'Introduction to psychology covering behavior, cognition, development, and social psychology.', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(10, 'Art Appreciation', 'Survey of visual arts from ancient to contemporary periods. Develop aesthetic appreciation and critical analysis.', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(11, 'Programming 1', 'An introductory course or concept focusing on the fundamentals of writing instructions (code) for computers, teaching logic, problem-solving, and basic syntax in a chosen language (like Python or C++) to create simple programs, manage data (variables), and control program flow.', '2026-01-28 08:33:26', '2026-01-28 08:33:26');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `enrollment_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `course_id`, `enrollment_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-01-15', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(2, 1, 3, '2026-01-15', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(3, 1, 7, '2026-01-16', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(4, 2, 2, '2026-01-15', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(5, 2, 4, '2026-01-16', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(6, 2, 8, '2026-01-17', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(7, 3, 1, '2026-01-15', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(8, 3, 5, '2026-01-16', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(9, 3, 9, '2026-01-17', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(10, 4, 2, '2026-01-15', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(11, 4, 6, '2026-01-16', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(12, 4, 10, '2026-01-17', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(13, 5, 3, '2026-01-15', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(14, 5, 4, '2026-01-16', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(15, 5, 7, '2026-01-17', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(16, 6, 1, '2026-01-15', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(17, 6, 2, '2026-01-16', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(18, 6, 9, '2026-01-17', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(19, 7, 5, '2026-01-15', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(20, 7, 8, '2026-01-16', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(21, 8, 3, '2026-01-15', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(22, 8, 6, '2026-01-16', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(23, 8, 10, '2026-01-17', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(24, 9, 2, '2026-01-15', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(25, 9, 4, '2026-01-16', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(26, 9, 7, '2026-01-17', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(27, 10, 1, '2026-01-15', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(28, 10, 5, '2026-01-16', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(29, 10, 9, '2026-01-17', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(30, 11, 11, '2026-02-02', '2026-01-28 08:33:53', '2026-01-28 08:33:53');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_no` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_no`, `name`, `email`, `created_at`, `updated_at`) VALUES
(1, 'STU001', 'John Smith', 'john.smith@example.com', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(2, 'STU002', 'Sarah Johnson', 'sarah.johnson@example.com', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(3, 'STU003', 'Michael Brown', 'michael.brown@example.com', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(4, 'STU004', 'Emily Davis', 'emily.davis@example.com', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(5, 'STU005', 'David Wilson', 'david.wilson@example.com', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(6, 'STU006', 'Jessica Martinez', 'jessica.martinez@example.com', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(7, 'STU007', 'Robert Taylor', 'robert.taylor@example.com', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(8, 'STU008', 'Amanda Anderson', 'amanda.anderson@example.com', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(9, 'STU009', 'Christopher Lee', 'christopher.lee@example.com', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(10, 'STU010', 'Michelle White', 'michelle.white@example.com', '2026-01-28 03:11:57', '2026-01-28 03:11:57'),
(11, 'STU011', 'Jhared Sabz', 'jharedsabillo@gmail.com', '2026-01-28 08:32:08', '2026-01-28 08:36:06'),
(12, 'STU012', 'Ean Khali', 'eankhali@gmail.com', '2026-01-28 08:36:21', '2026-01-28 08:36:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_course_name` (`course_name`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_course` (`student_id`,`course_id`),
  ADD KEY `idx_student_id` (`student_id`),
  ADD KEY `idx_course_id` (`course_id`),
  ADD KEY `idx_enrollment_date` (`enrollment_date`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_no` (`student_no`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_student_no` (`student_no`),
  ADD KEY `idx_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `fk_enrollments_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enrollments_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
