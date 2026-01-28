-- =====================================================
-- Student Enrollment System - Database Setup with Sample Data
-- =====================================================

-- Create Database
CREATE DATABASE IF NOT EXISTS student_enrollment;
USE student_enrollment;

-- =====================================================
-- Table 1: Students
-- =====================================================
CREATE TABLE IF NOT EXISTS students (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_no VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_student_no (student_no),
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table 2: Courses
-- =====================================================
CREATE TABLE IF NOT EXISTS courses (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(255) NOT NULL,
    description LONGTEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_course_name (course_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table 3: Enrollments
-- =====================================================
CREATE TABLE IF NOT EXISTS enrollments (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_id BIGINT UNSIGNED NOT NULL,
    course_id BIGINT UNSIGNED NOT NULL,
    enrollment_date DATE NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    UNIQUE KEY unique_student_course (student_id, course_id),
    INDEX idx_student_id (student_id),
    INDEX idx_course_id (course_id),
    INDEX idx_enrollment_date (enrollment_date),
    
    CONSTRAINT fk_enrollments_student 
        FOREIGN KEY (student_id) 
        REFERENCES students(id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    
    CONSTRAINT fk_enrollments_course 
        FOREIGN KEY (course_id) 
        REFERENCES courses(id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Sample Data: Students
-- =====================================================
INSERT INTO students (student_no, name, email) VALUES
('STU001', 'John Smith', 'john.smith@example.com'),
('STU002', 'Sarah Johnson', 'sarah.johnson@example.com'),
('STU003', 'Michael Brown', 'michael.brown@example.com'),
('STU004', 'Emily Davis', 'emily.davis@example.com'),
('STU005', 'David Wilson', 'david.wilson@example.com'),
('STU006', 'Jessica Martinez', 'jessica.martinez@example.com'),
('STU007', 'Robert Taylor', 'robert.taylor@example.com'),
('STU008', 'Amanda Anderson', 'amanda.anderson@example.com'),
('STU009', 'Christopher Lee', 'christopher.lee@example.com'),
('STU010', 'Michelle White', 'michelle.white@example.com');

-- =====================================================
-- Sample Data: Courses
-- =====================================================
INSERT INTO courses (course_name, description) VALUES
('Mathematics 101', 'Fundamentals of Algebra and Geometry. Learn basic mathematical concepts including equations, functions, and geometric properties.'),
('English Literature', 'Study of classical and modern literature including novels, poetry, and drama. Develop critical thinking and analysis skills.'),
('Physics 201', 'Introduction to Classical and Modern Physics. Covers mechanics, thermodynamics, waves, and basic quantum theory.'),
('Chemistry 101', 'General Chemistry course covering atomic structure, chemical bonding, reactions, and stoichiometry.'),
('Biology 101', 'Introduction to Biology. Study of cell structure, genetics, evolution, and ecology.'),
('History of Western Civilization', 'Comprehensive study of Western Europe from Ancient Greece to modern times.'),
('Introduction to Computer Science', 'Fundamentals of programming, algorithms, data structures, and computational thinking.'),
('Business Management 101', 'Principles of business management, organizational behavior, and strategic planning.'),
('Psychology 101', 'Introduction to psychology covering behavior, cognition, development, and social psychology.'),
('Art Appreciation', 'Survey of visual arts from ancient to contemporary periods. Develop aesthetic appreciation and critical analysis.');

-- =====================================================
-- Sample Data: Enrollments
-- =====================================================
INSERT INTO enrollments (student_id, course_id, enrollment_date) VALUES
(1, 1, '2026-01-15'),
(1, 3, '2026-01-15'),
(1, 7, '2026-01-16'),
(2, 2, '2026-01-15'),
(2, 4, '2026-01-16'),
(2, 8, '2026-01-17'),
(3, 1, '2026-01-15'),
(3, 5, '2026-01-16'),
(3, 9, '2026-01-17'),
(4, 2, '2026-01-15'),
(4, 6, '2026-01-16'),
(4, 10, '2026-01-17'),
(5, 3, '2026-01-15'),
(5, 4, '2026-01-16'),
(5, 7, '2026-01-17'),
(6, 1, '2026-01-15'),
(6, 2, '2026-01-16'),
(6, 9, '2026-01-17'),
(7, 5, '2026-01-15'),
(7, 8, '2026-01-16'),
(8, 3, '2026-01-15'),
(8, 6, '2026-01-16'),
(8, 10, '2026-01-17'),
(9, 2, '2026-01-15'),
(9, 4, '2026-01-16'),
(9, 7, '2026-01-17'),
(10, 1, '2026-01-15'),
(10, 5, '2026-01-16'),
(10, 9, '2026-01-17');

-- =====================================================
-- Database Setup Complete
-- Sample data has been loaded successfully!
-- =====================================================
