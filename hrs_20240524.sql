-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 06:12 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrs`
--

-- --------------------------------------------------------

--
-- Table structure for table `o_book`
--

CREATE TABLE `o_book` (
  `x_bookid` int(10) NOT NULL,
  `x_room` varchar(10) NOT NULL,
  `x_user` varchar(30) NOT NULL,
  `x_datein` date NOT NULL,
  `x_dateout` date NOT NULL,
  `x_guestnum` int(2) NOT NULL,
  `x_totalfee` float NOT NULL,
  `x_status` int(5) NOT NULL,
  `payment_status` varchar(1) DEFAULT NULL,
  `x_emailaddr` varchar(50) NOT NULL,
  `x_telnum` varchar(15) NOT NULL,
  `x_comment` varchar(2000) NOT NULL,
  `x_createddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `o_book`
--

INSERT INTO `o_book` (`x_bookid`, `x_room`, `x_user`, `x_datein`, `x_dateout`, `x_guestnum`, `x_totalfee`, `x_status`, `payment_status`, `x_emailaddr`, `x_telnum`, `x_comment`, `x_createddate`) VALUES
(6, '001', 'frahman', '2024-05-22', '2024-05-23', 1, 100, 1, '1', 'fazlur@gmail.com', '012-3123123', 'Need ironboard please', '2024-05-20 23:38:04'),
(7, '002', 'syazmin', '2024-05-21', '2024-05-22', 2, 100, 1, '1', 'syazmin@gmail.com', '015-4322122', 'Need extra blanket', '2024-05-20 23:51:43'),
(8, '010', 'asyraf', '2024-05-22', '2024-05-23', 1, 200, 1, '1', 'asyraf@gmail.com', '014-4444444', '', '2024-05-22 23:48:42');

-- --------------------------------------------------------

--
-- Table structure for table `o_room`
--

CREATE TABLE `o_room` (
  `x_roomid` varchar(10) NOT NULL,
  `x_roomtype` varchar(15) NOT NULL,
  `x_price` float NOT NULL,
  `x_guestnum` int(2) NOT NULL,
  `x_bedsize` varchar(25) NOT NULL,
  `x_avail_flag` char(1) DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `o_room`
--

INSERT INTO `o_room` (`x_roomid`, `x_roomtype`, `x_price`, `x_guestnum`, `x_bedsize`, `x_avail_flag`) VALUES
('001', 'Standard Room', 100, 1, '1 Single', 'Y'),
('002', 'Standard Room', 100, 1, '1 Single', 'Y'),
('003', 'Standard Room', 100, 1, '1 Single', 'Y'),
('004', 'Standard Room', 100, 1, '1 Single', 'Y'),
('005', 'Standard Room', 100, 1, '1 Single', 'Y'),
('006', 'Standard Room', 100, 1, '1 Single', 'Y'),
('007', 'Standard Room', 100, 1, '1 Single', 'Y'),
('008', 'Standard Room', 100, 1, '1 Single', 'Y'),
('009', 'Standard Room', 100, 1, '1 Single', 'Y'),
('010', 'Deluxe Room', 200, 3, '1 Queen, 1 Single', 'Y'),
('011', 'Deluxe Room', 200, 3, '1 Queen, 1 Single', 'Y'),
('012', 'Deluxe Room', 200, 3, '1 Queen, 1 Single', 'Y'),
('013', 'Deluxe Room', 200, 3, '1 Queen, 1 Single', 'Y'),
('014', 'Deluxe Room', 200, 3, '1 Queen, 1 Single', 'Y'),
('015', 'Premier Room', 300, 4, '2 Queen', 'Y'),
('016', 'Premier Room', 300, 4, '2 Queen', 'Y'),
('017', 'Premier Room', 300, 4, '2 Queen', 'Y'),
('018', 'Premier Room', 300, 4, '2 Queen', 'Y'),
('019', 'Premier Room', 300, 4, '2 Queen', 'Y'),
('020', 'Premier Room', 300, 4, '2 Queen', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `o_status`
--

CREATE TABLE `o_status` (
  `x_id` int(5) NOT NULL,
  `x_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `o_status`
--

INSERT INTO `o_status` (`x_id`, `x_name`) VALUES
(0, 'Received'),
(1, 'Approved'),
(2, 'Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `o_user`
--

CREATE TABLE `o_user` (
  `x_userid` varchar(30) NOT NULL,
  `x_pwd` varchar(120) NOT NULL,
  `x_icnum` varchar(16) DEFAULT NULL,
  `x_name` varchar(100) NOT NULL,
  `x_tel` varchar(15) NOT NULL,
  `x_email` varchar(50) NOT NULL,
  `x_userclass` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `o_user`
--

INSERT INTO `o_user` (`x_userid`, `x_pwd`, `x_icnum`, `x_name`, `x_tel`, `x_email`, `x_userclass`) VALUES
('asyraf', '$2y$10$r/39xJwPjJN3ZY49ZJSVA.YoOgnqoLSy7twKpSKnsvIL2xDs5ELPm', NULL, 'Muhammad Asyraf', '016-34123555', 'muhammad.asyraf@gmail.com', 1),
('fizwan', '$2y$10$6k0swHPORdWOxEkwvY2pu.thluB/nA1LoUj83RSH.AnupKz8VOKL.', '950101145055', 'Fadzrul Izwan', '010-5559073', 'fadzrul@gmail.com', 0),
('frahman', '$2y$10$BYH4rqWNL/cojXiWwnKBaODmr7YJj2ZTdiudC6fZIDISYRAdBhM5e', '966666146666', 'Fazlur Rahman', '016-6666666', 'fazlur@gmail.com', 1),
('syazmin', '$2y$10$HDeNgzAAWhTH5q.okKvOHety2kmfR0SnypK3qgIcXp0CoMLzeby/O', NULL, 'Nurul Syazmin', '015-4322122', 'nurul.syazmin@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_currency` varchar(3) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_intent_id` varchar(50) NOT NULL,
  `payment_timestamp` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `reservation_id`, `payment_amount`, `payment_currency`, `payment_status`, `payment_method`, `payment_intent_id`, `payment_timestamp`, `created_at`, `updated_at`) VALUES
(1, 'frahman', 1, '100.00', 'myr', 'Success', 'Debit', 'pi_3PIY8mJ9ml5ZL2Dp1hOWVLmI', '2024-05-20 15:28:45', '2024-05-20 15:28:45', '2024-05-20 15:28:45'),
(2, 'frahman', 1, '100.00', 'myr', 'Success', 'Debit', 'pi_3PIYDNJ9ml5ZL2Dp0Zl4R0jB', '2024-05-20 15:33:30', '2024-05-20 15:33:30', '2024-05-20 15:33:30'),
(3, 'frahman', 1, '100.00', 'myr', 'Success', 'Debit', 'pi_3PIYHoJ9ml5ZL2Dp0nXtutFx', '2024-05-20 15:38:04', '2024-05-20 15:38:04', '2024-05-20 15:38:04'),
(4, 'syazmin', 2, '100.00', 'myr', 'Success', 'Debit', 'pi_3PIYV0J9ml5ZL2Dp0vLRzORm', '2024-05-20 15:51:42', '2024-05-20 15:51:42', '2024-05-20 15:51:42'),
(5, 'asyraf', 10, '200.00', 'myr', 'Success', 'Debit', 'pi_3PJHPCJ9ml5ZL2Dp1qzDfxzT', '2024-05-22 15:48:42', '2024-05-22 15:48:42', '2024-05-22 15:48:42'),
(6, 'asyraf', 5, '100.00', 'myr', 'Success', 'Debit', 'pi_3PJHRkJ9ml5ZL2Dp1UcIwHVQ', '2024-05-22 15:51:19', '2024-05-22 15:51:19', '2024-05-22 15:51:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `o_book`
--
ALTER TABLE `o_book`
  ADD PRIMARY KEY (`x_bookid`),
  ADD KEY `x_room` (`x_room`),
  ADD KEY `x_user` (`x_user`),
  ADD KEY `x_status` (`x_status`),
  ADD KEY `x_status_2` (`x_status`),
  ADD KEY `x_emailid` (`x_emailaddr`),
  ADD KEY `x_telnum` (`x_telnum`);

--
-- Indexes for table `o_room`
--
ALTER TABLE `o_room`
  ADD PRIMARY KEY (`x_roomid`);

--
-- Indexes for table `o_status`
--
ALTER TABLE `o_status`
  ADD PRIMARY KEY (`x_id`);

--
-- Indexes for table `o_user`
--
ALTER TABLE `o_user`
  ADD PRIMARY KEY (`x_userid`),
  ADD UNIQUE KEY `x_email` (`x_email`),
  ADD UNIQUE KEY `x_tel` (`x_tel`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `o_book`
--
ALTER TABLE `o_book`
  MODIFY `x_bookid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `o_book`
--
ALTER TABLE `o_book`
  ADD CONSTRAINT `o_book_ibfk_1` FOREIGN KEY (`x_user`) REFERENCES `o_user` (`x_userid`),
  ADD CONSTRAINT `o_book_ibfk_2` FOREIGN KEY (`x_room`) REFERENCES `o_room` (`x_roomid`),
  ADD CONSTRAINT `o_book_ibfk_3` FOREIGN KEY (`x_status`) REFERENCES `o_status` (`x_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
