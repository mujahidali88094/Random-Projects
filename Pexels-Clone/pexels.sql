-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2021 at 12:18 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` int(11) NOT NULL,
  `userid` bigint(30) NOT NULL,
  `c_id` varchar(255) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_desc` varchar(65000) DEFAULT NULL,
  `private` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `collection_content`
--

CREATE TABLE `collection_content` (
  `id` int(11) NOT NULL,
  `c_id` varchar(255) NOT NULL,
  `imgid` bigint(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_views`
--

CREATE TABLE `c_views` (
  `cid` varchar(50) NOT NULL,
  `userid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `imgid` bigint(30) NOT NULL,
  `userid` bigint(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dps`
--

CREATE TABLE `dps` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `upload_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `follower` bigint(30) NOT NULL,
  `followed` bigint(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fp`
--

CREATE TABLE `fp` (
  `token` varchar(255) NOT NULL,
  `id` bigint(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `imgid` bigint(30) NOT NULL,
  `userid` bigint(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `imgID` bigint(20) NOT NULL,
  `tag` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`imgID`, `tag`) VALUES
(44469311020, 'boy'),
(44469311020, 'flower'),
(44469311020, 'red');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `imgID` bigint(20) NOT NULL,
  `userID` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `width` int(8) NOT NULL,
  `height` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`imgID`, `userID`, `name`, `location`, `width`, `height`) VALUES
(44469311020, 323824320964, 'pexels-photo-44469311020.jpg', '', 426, 640),
(61270727352, 1, 'pexels-photo-61270727352.jpg', '', 480, 640);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` bigint(30) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(35) NOT NULL,
  `passwordSet` tinyint(1) NOT NULL DEFAULT 0,
  `LinkedWithFacebook` tinyint(1) NOT NULL DEFAULT 0,
  `profilePic` varchar(255) NOT NULL,
  `shortBio` varchar(255) NOT NULL,
  `webLink` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `verifiedEmail` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `firstName`, `lastName`, `email`, `password`, `passwordSet`, `LinkedWithFacebook`, `profilePic`, `shortBio`, `webLink`, `instagram`, `twitter`, `location`, `verifiedEmail`) VALUES
(1, 'Mujahid', 'Ali', 'wordlife883@gmail.com', 'a10b610c14b9bcba99c2993564617159', 0, 0, 'photos/1628268302-flower-red-20274967798.jpg', 'Photography is my passion.', 'https://facebook.com/mujahidali', 'mujahidali', 'alimujahid', 'Faisalabad', 0),
(50392511908, 'Ali', 'Hassan', 'ali@gmail.com', 'd7496ed7665f246e813e96d2aa02b7d8', 0, 0, '', '', '', '', '', '', 0),
(323824320964, 'Saad', 'Butt', 'bcsf19m538@pucit.edu.pk', 'a10b610c14b9bcba99c2993564617159', 0, 0, 'photos/1628249764-Image.jpg', 'I\'m a web dev.', 'https://facebook.com', 'amnotsaadi', 'aslisaadi', 'Lahore', 0),
(416961808436, 'Saad', 'i', 'mujahidali@ffdsfd.con', '013f890e35d1b7f5e45f', 0, 0, '', '', '', '', '', '', 0),
(437855292610, 'Saad', 'Butt', 'alsdsl@sddsf.con', 'c41ca2e23e82a42d2a9d', 0, 0, '', '', '', '', '', '', 0),
(440666202711, '', '', '', 'bfcc0f767f598200da162340678371f1', 0, 1, '', '', '', '', '', '', 0),
(474961559814, 'Sâ', 'Ádï', 'sdasd@adfdsf.con', '3f8145a5d88e1aa52d12', 0, 0, '', '', '', '', '', '', 0),
(576356352067, 'Saad', 'sdsd', 'sdsdsd@sdsd', '718b6dd54c8d1d3ad19e', 0, 0, '', '', '', '', '', '', 0),
(662366556341, 'Mujahid', 'Ali', 'ali@mujahid.com', '2863e072c41954d4ae1b784b87cd72c8', 0, 0, 'photos/1626279117-tumblr_phspwqxZli1tyho6vo1_1280.jpg', 'I\'m a web developer.', 'https://facebook.com/officialsaadbutt', 'amnotsaadi', 'aslisaadi', 'Lahore', 0),
(864002978927, 'Saad', 'Hassan', 'saad@gmail.com', 'a10b610c14b9bcba99c2', 0, 0, '', '', '', '', '', '', 0),
(930756509882, 'Saad', 'Butt', 'ali577355@gmail.com', 'a10b610c14b9bcba99c2993564617159', 0, 0, '', 'I am saad', 'https://abc.com', 'Iamsaadi', 'naklisaadi', 'Peshawar', 0);

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `userid` bigint(30) NOT NULL,
  `imgid` bigint(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collection_content`
--
ALTER TABLE `collection_content`
  ADD PRIMARY KEY (`c_id`,`imgid`),
  ADD UNIQUE KEY `145` (`id`);

--
-- Indexes for table `c_views`
--
ALTER TABLE `c_views`
  ADD PRIMARY KEY (`cid`,`userid`);

--
-- Indexes for table `dps`
--
ALTER TABLE `dps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`follower`,`followed`);

--
-- Indexes for table `fp`
--
ALTER TABLE `fp`
  ADD PRIMARY KEY (`token`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`imgid`,`userid`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`imgID`,`tag`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`imgID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`userid`,`imgid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `collection_content`
--
ALTER TABLE `collection_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dps`
--
ALTER TABLE `dps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `imgID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61270727353;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` bigint(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=357777416913604;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
