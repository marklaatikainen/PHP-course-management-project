SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

create database <db>;
use <db>;

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `opFirstName` varchar(15) NOT NULL,
  `opLastName` varchar(15) NOT NULL,
  `courseName` varchar(70) NOT NULL,
  `courseId` varchar(15) NOT NULL,
  `ects` int(11) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completedDate` date DEFAULT NULL,
  `grade` varchar(1) DEFAULT NULL,
  `info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `opLastName` (`opLastName`),
  ADD KEY `opFirstName` (`opFirstName`),
  ADD KEY `courseId` (`courseId`);


ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


