-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: mysql.joelhackney.me
-- Generation Time: Aug 23, 2021 at 09:03 AM
-- Server version: 5.7.29-log
-- PHP Version: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webhooks`
--

-- --------------------------------------------------------

--
-- Table structure for table `hits`
--

CREATE TABLE `hits` (
  `id` int(11) NOT NULL,
  `code` varchar(6) NOT NULL,
  `data` text NOT NULL,
  `datetime_created` timestamp NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hits`
--

INSERT INTO `hits` (`id`, `code`, `data`, `datetime_created`, `flag`) VALUES
(1, 'UWYwf', '/webhooks/?q=UWYwf', '2021-08-23 02:29:37', 0),
(7, 'q3vg9', 'secKey=q3vg9&to=joelhackney%40me.com&subject=Webhook+Post+Data+Test&message=Testing+Webhook+Post&from=no-reply%40joelhackney.me&', '2021-08-23 15:09:28', 0),
(10, 'N1N9P', '{\"customer\":{\"first_name\":\"First name\",\"last_name\":\"last name\",\"email\":\"email@gmail.com\",\"addresses\":{\"address1\":\"some address\",\"city\":\"city\",\"country\":\"CA\",\"first_name\":\"Mother\",\"last_name\":\"Lastnameson\",\"phone\":\"555-1212\",\"province\":\"ON\",\"zip\":\"123 ABC\"}}}', '2021-08-23 15:17:41', 0),
(11, 'UWYwf', '?q=UWYwf&fname=Joel&lname=Hackney&phone=3174505279&zipcode=46250', '2021-08-23 15:35:01', 0);

-- --------------------------------------------------------

--
-- Table structure for table `webhooks`
--

CREATE TABLE `webhooks` (
  `id` int(11) NOT NULL,
  `code` varchar(6) NOT NULL,
  `title` varchar(20) NOT NULL,
  `type` varchar(10) NOT NULL,
  `datetime_created` timestamp NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `webhooks`
--

INSERT INTO `webhooks` (`id`, `code`, `title`, `type`, `datetime_created`, `flag`) VALUES
(1, 'UWYwf', 'GET Webhook Example', 'GET', '2021-08-23 01:40:02', 0),
(5, 'q3vg9', 'POST Webhook Example', 'POST', '2021-08-23 04:01:11', 1),
(6, 'N1N9P', 'JSON Webhook Example', 'JSON', '2021-08-23 14:36:47', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hits`
--
ALTER TABLE `hits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webhooks`
--
ALTER TABLE `webhooks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hits`
--
ALTER TABLE `hits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `webhooks`
--
ALTER TABLE `webhooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
