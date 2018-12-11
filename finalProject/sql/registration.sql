-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 08, 2018 at 11:59 PM
-- Server version: 5.5.57-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `final_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `admin_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`admin_id`, `user_name`, `password`) VALUES
(1, 'admin', '25ab86bed149ca6ca9c1c0d5d');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `time` time NOT NULL,
  `days_of_week` int(10) NOT NULL,
  `start_date` date NOT NULL,
  `semester` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `course_id`, `room_number`, `time`, `days_of_week`, `start_date`, `semester`) VALUES
(1, 4, 'A105', '18:15:00', 0, '2019-06-11', 'Summer'),
(2, 1, 'A105', '11:00:00', 0, '2019-01-29', 'Spring'),
(3, 5, 'A105', '08:45:00', 0, '2019-06-11', 'Summer'),
(4, 4, 'CA103', '17:00:00', 0, '2019-09-03', 'Fall'),
(5, 3, 'A204', '14:30:00', 0, '2019-09-03', 'Fall'),
(6, 2, 'B203', '10:00:00', 0, '2019-06-11', 'Summer'),
(7, 1, 'D101', '14:30:00', 0, '2019-01-03', 'Winter'),
(8, 5, 'D101', '18:15:00', 0, '2019-01-03', 'Winter'),
(9, 3, 'A105', '11:30:00', 0, '2019-01-29', 'Spring'),
(10, 1, 'A204', '13:45:00', 0, '2019-01-29', 'Spring'),
(11, 3, 'D101', '18:30:00', 0, '2019-09-03', 'Fall'),
(12, 3, 'CA105', '11:15:00', 0, '2019-01-29', 'Spring'),
(13, 3, 'D101', '09:30:00', 0, '2019-01-03', 'Winter'),
(14, 1, 'B215', '10:00:00', 0, '2019-09-03', 'Fall'),
(15, 3, 'B215', '14:30:00', 0, '2019-01-03', 'Winter'),
(16, 2, 'B215', '16:45:00', 0, '2019-01-03', 'Winter'),
(17, 2, 'B215', '14:30:00', 0, '2019-09-03', 'Fall'),
(18, 2, 'B203', '08:30:00', 0, '2019-01-29', 'Spring'),
(19, 4, 'A105', '12:15:00', 0, '2019-01-03', 'Winter'),
(20, 1, 'A103', '08:45:00', 0, '2019-01-03', 'Winter'),
(21, 2, 'D101', '17:30:00', 0, '2019-01-29', 'Spring'),
(22, 4, 'A103', '16:30:00', 0, '2019-01-29', 'Spring'),
(23, 1, 'B215', '13:30:00', 0, '2019-09-03', 'Fall'),
(24, 4, 'A103', '11:45:00', 0, '2019-06-11', 'Summer'),
(25, 3, 'CA103', '17:30:00', 0, '2019-09-03', 'Fall'),
(26, 4, 'A204', '17:00:00', 0, '2019-09-03', 'Fall'),
(27, 1, 'A103', '18:15:00', 0, '2019-09-03', 'Fall'),
(28, 1, 'B215', '16:45:00', 0, '2019-06-11', 'Summer'),
(29, 2, 'CA105', '16:45:00', 0, '2019-01-29', 'Spring'),
(30, 3, 'A105', '18:30:00', 0, '2019-09-03', 'Fall');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(30) NOT NULL,
  `number_of_units` int(11) NOT NULL,
  `course_description` text NOT NULL,
  `cost` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `number_of_units`, `course_description`, `cost`) VALUES
(1, 'Calculus I', 5, 'This is the first course in calculus for students majoring in mathematics, physical science, computer science, or engineering. Students study functions and inverse functions, limits, the derivative as a limit, continuity, rules of differentiation, chain rule, implicit differentiation, applications of differentiation, linear approximations, related rates, optimization problems, antiderivatives, Riemann sums, the Fundamental Theorem of Calculus, and the substitution rule for integration.', '2630'),
(2, 'English I', 5, 'The course emphasizes expository writing, critical reading, and research techniques. Students are required to produce a series of academic essays including a documented research paper in conventional format. Analysis of readings and the practice of writing processes create the bases for student essays.', '2630'),
(3, 'Jazz Appreciation', 3, 'Students who have little or no previous experience in musical performance or listening to the traditions of jazz music will study the musical elements of jazz and appraise the development of the jazz art form as a product of culture. Students will also study how to aurally distinguish the elements of jazz music and trace the evolution of styles and structures of jazz from its inception to the present time.', '1578'),
(4, 'Computer Science I', 4, 'This course is an introduction to computer science using an object-oriented programming language. Students will write computer programs that include control structures, iteration, methods and argument passing, and classes. Problem solving, documentation, programming style, and program design and development are addressed throughout the course.', '2104'),
(5, 'Computer Science II', 4, 'This course covers data abstraction and structures as well as associated algorithms for linear lists, stacks, queues, trees, and other linked structures, arrays, strings, and hash tables. Software engineering techniques are applied to the design and development of large programming projects in an object-oriented environment. Searching and sorting algorithms are also covered.', '2104');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `date_of_birth` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `first_name`, `last_name`, `date_of_birth`) VALUES
(1, 'Brandon', 'Hiraki', '1982-03-24'),
(2, 'Elmer', 'Hartwig', '1983-12-03'),
(3, 'Lavonia', 'Jarecke', '1992-01-04'),
(4, 'Maureen', 'Callies', '1981-03-03'),
(5, 'Coleman', 'Fridlington', '1996-04-02'),
(6, 'Lupe', 'Vanalstine', '1997-09-18'),
(7, 'See', 'Pead', '1982-09-26'),
(8, 'Pamela', 'Lachino', '1988-01-20'),
(9, 'Tonia', 'Grussing', '1988-04-04'),
(10, 'Spencer', 'Easly', '1993-11-14'),
(11, 'Gerry', 'Welchel', '1988-03-23'),
(12, 'Kathlyn', 'Crescenti', '1998-07-17'),
(13, 'In', 'Mrozoski', '1981-10-04'),
(14, 'Kristeen', 'Shackelton', '1987-12-19'),
(15, 'Mohammed', 'Bangura', '1991-07-19'),
(16, 'Tamika', 'Hollender', '1982-02-11'),
(17, 'Dayle', 'Borcuk', '1990-07-25'),
(18, 'Rhona', 'Nuesca', '1980-10-10'),
(19, 'Isa', 'Olofson', '1988-02-03'),
(20, 'Marylyn', 'Pinon', '1982-01-14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
