-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2021 at 05:34 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `data`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `address` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `name`, `image`, `address`) VALUES
(1, 'admin1@gmail.com', 'Md. Abdul Mazid', 'admin1@gmail.com.1635262200.jpg', ''),
(2, 'admin2@gmail.com', 'Dr. Md. Yunus Miah', 'admin2@gmail.com.1634544505.jpg', ''),
(3, 'admin3@gmail.com', 'Dr. Shahida Rafique', 'admin3@gmail.com.1634544548.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `s_id` int(11) NOT NULL,
  `present` int(2) NOT NULL,
  `t_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `course_id`, `date`, `s_id`, `present`, `t_id`) VALUES
(124, 104, '2021-10-15', 6, 0, 1),
(123, 104, '2021-10-15', 5, 1, 1),
(122, 104, '2021-10-15', 4, 0, 1),
(121, 104, '2021-10-15', 3, 0, 1),
(120, 104, '2021-10-15', 2, 1, 1),
(119, 104, '2021-10-15', 1, 0, 1),
(118, 104, '2021-10-14', 6, 1, 1),
(117, 104, '2021-10-14', 5, 0, 1),
(116, 104, '2021-10-14', 4, 1, 1),
(115, 104, '2021-10-14', 3, 0, 1),
(114, 104, '2021-10-14', 2, 1, 1),
(113, 104, '2021-10-14', 1, 1, 1),
(112, 102, '2021-10-15', 6, 1, 1),
(111, 102, '2021-10-15', 5, 1, 1),
(110, 102, '2021-10-15', 4, 1, 1),
(109, 102, '2021-10-15', 3, 1, 1),
(108, 102, '2021-10-15', 2, 1, 1),
(107, 102, '2021-10-15', 1, 1, 1),
(106, 102, '2021-10-14', 6, 1, 1),
(105, 102, '2021-10-14', 5, 1, 1),
(104, 102, '2021-10-14', 4, 0, 1),
(103, 102, '2021-10-14', 3, 1, 1),
(102, 102, '2021-10-14', 2, 0, 1),
(101, 102, '2021-10-14', 1, 1, 1),
(125, 112, '2021-10-16', 1, 1, 1),
(126, 112, '2021-10-16', 2, 1, 1),
(127, 112, '2021-10-16', 3, 1, 1),
(128, 112, '2021-10-16', 4, 1, 1),
(129, 112, '2021-10-16', 5, 0, 1),
(130, 112, '2021-10-16', 6, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `t_id`, `name`) VALUES
(101, 2, 'CSE 101'),
(102, 1, 'CSE 102'),
(103, 3, 'CSE 103'),
(104, 1, 'CSE 104'),
(105, -1, 'CSE 105'),
(106, 4, 'CSE 106'),
(107, 4, 'CSE 107'),
(111, 3, 'CSE 111'),
(112, 1, 'CSE 112');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `address` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `image`, `address`) VALUES
(1, 'Khadija Haque', 'student01@gamil.com', 'student01@gamil.com.1634545183.jpg', ''),
(2, 'Rakin Alom', 'student02@gamil.com', 'student02@gamil.com.1634545249.jpg', ''),
(3, 'Rakib Abrar', 'student03@gamil.com', 'student03@gamil.com.1634545503.jpg', ''),
(4, 'Runa Akhter', 'student04@gamil.com', 'student04@gamil.com.1634545552.jpg', ''),
(5, 'Toriqul Islam', 'student05@gamil.com', 'student05@gamil.com.1634545587.jpg', ''),
(6, 'Mashruk Hridoy', 'student06@gamil.com', 'student06@gamil.com.1634545635.jpg', ''),
(7, 'Emamuj Jaman', 'student07@gamil.com', 'default.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `address` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `email`, `image`, `address`) VALUES
(1, 'Sanjida Hoque Shoshey', 'teacher1@gamil.com', 'teacher1@gamil.1634544661.jpg', ''),
(2, 'Lutfi Habiba', 'teacher2@gamil.com', 'teacher2@gamil.com.1634544703.jpg', ''),
(3, 'Tasmi Sultana', 'teacher3@gamil.com', 'teacher3@gamil.com.1634544940.jpg', ''),
(4, 'Tania Sultana', 'teacher4@gamil.com', 'teacher4@gamil.com.1634544956.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `passHash` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `role`, `pass`, `passHash`) VALUES
('admin1@gmail.com', 'Admin', '12345', '827ccb0eea8a706c4c34a16891f84e7b'),
('admin2@gmail.com', 'Admin', '1234567', 'fcea920f7412b5da7be0cf42b8c93759'),
('admin3@gmail.com', 'Admin', '112322', '860815578d0504c5c7ccb5aa95b4461b'),
('teacher4@gamil.com', 'Teacher', '345345', '0c0b3da4ac402bd86191d959be081114'),
('teacher3@gamil.com', 'Teacher', '33445', 'dd2123d4ed992ad5710750cfbae4414b'),
('student01@gamil.com', 'Student', '333', '310dcbbf4cce62f762a2aaa148d556bd'),
('student02@gamil.com', 'Student', '222', 'bcbe3365e6ac95ea2c0343a2395834dd'),
('student03@gamil.com', 'Student', '3', 'eccbc87e4b5ce2fe28308fd9f2a7baf3'),
('student04@gamil.com', 'Student', '4', 'a87ff679a2f3e71d9181a67b7542122c'),
('student05@gamil.com', 'Student', '5', 'e4da3b7fbbce2345d7772b0674a318d5'),
('student06@gamil.com', 'Student', '6', '1679091c5a880faf6fb5e6087eb1b2dc'),
('teacher1@gamil.com', 'Teacher', '123231', '3f1dbc417664139dda097bcd516ceeed'),
('teacher2@gamil.com', 'Teacher', '23435', 'cba2e39793995b3b682da78f854786f2'),
('student07@gamil.com', 'Student', 'ff444', 'dacfcf74f94b6fa9a0ae474f464f7629');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `s_id` (`s_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_id` (`t_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
