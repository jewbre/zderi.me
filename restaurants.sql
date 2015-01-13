-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2015 at 07:45 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `restaurants`
--

-- --------------------------------------------------------

--
-- Table structure for table `capacity`
--

CREATE TABLE IF NOT EXISTS `capacity` (
  `restaurantId` int(11) NOT NULL,
  `seatingNumber` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
`id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `deliversfor`
--

CREATE TABLE IF NOT EXISTS `deliversfor` (
  `restaurantId` int(11) NOT NULL,
  `supplierId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `hasingredient`
--

CREATE TABLE IF NOT EXISTS `hasingredient` (
  `ingredientId` int(11) NOT NULL,
  `supplierId` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `unit` varchar(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
`id` int(11) NOT NULL,
  `type` varchar(20) COLLATE utf8_bin NOT NULL,
  `owner` int(11) NOT NULL,
  `url` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ingredient`
--

CREATE TABLE IF NOT EXISTS `ingredient` (
`id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `meal`
--

CREATE TABLE IF NOT EXISTS `meal` (
`id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_bin NOT NULL,
  `price` int(11) NOT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `restaurantId` int(11) NOT NULL,
  `available` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=50 ;

-- --------------------------------------------------------

--
-- Table structure for table `mealconsistsof`
--

CREATE TABLE IF NOT EXISTS `mealconsistsof` (
  `mealId` int(11) NOT NULL,
  `ingredientId` int(11) NOT NULL,
  `units` varchar(4) COLLATE utf8_bin NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE IF NOT EXISTS `orderitems` (
  `ingredientId` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `unit` varchar(5) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
`id` int(11) NOT NULL,
  `restaurantId` int(11) NOT NULL,
  `supplierId` int(11) NOT NULL,
  `orderNo` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
`id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `restaurantId` int(11) NOT NULL,
  `comment` varchar(150) COLLATE utf8_bin NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
`id` int(11) NOT NULL,
  `restaurantId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `barcode` varchar(30) COLLATE utf8_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `reservationmenu`
--

CREATE TABLE IF NOT EXISTS `reservationmenu` (
  `mealId` int(11) NOT NULL,
  `reservationId` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `reservationsseats`
--

CREATE TABLE IF NOT EXISTS `reservationsseats` (
  `reservationId` int(11) NOT NULL,
  `seatingNumber` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE IF NOT EXISTS `restaurant` (
`id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_bin NOT NULL,
  `description` varchar(500) COLLATE utf8_bin NOT NULL,
  `contact` varchar(30) COLLATE utf8_bin NOT NULL,
  `address` varchar(30) COLLATE utf8_bin NOT NULL,
  `city` varchar(30) COLLATE utf8_bin NOT NULL,
  `host` int(11) NOT NULL,
  `picture` varchar(250) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `ingredientId` int(11) NOT NULL,
  `restaurantId` int(11) NOT NULL,
  `units` varchar(2) COLLATE utf8_bin NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_bin NOT NULL,
  `email` varchar(30) COLLATE utf8_bin NOT NULL,
  `password` varchar(30) COLLATE utf8_bin NOT NULL,
  `contact` varchar(30) COLLATE utf8_bin NOT NULL,
  `creditCard` varchar(30) COLLATE utf8_bin NOT NULL,
  `name` varchar(30) COLLATE utf8_bin NOT NULL,
  `lastName` varchar(30) COLLATE utf8_bin NOT NULL,
  `privilege` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT 'user'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=23 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `contact`, `creditCard`, `name`, `lastName`, `privilege`) VALUES
(22, 'admin', 'admin@gmail.com', 'admin', '', '', 'admin', 'admin', '4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `capacity`
--
ALTER TABLE `capacity`
 ADD PRIMARY KEY (`restaurantId`,`seatingNumber`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliversfor`
--
ALTER TABLE `deliversfor`
 ADD PRIMARY KEY (`restaurantId`,`supplierId`), ADD KEY `supplierId` (`supplierId`);

--
-- Indexes for table `hasingredient`
--
ALTER TABLE `hasingredient`
 ADD PRIMARY KEY (`ingredientId`,`supplierId`), ADD KEY `supplierId` (`supplierId`), ADD KEY `supplierId_2` (`supplierId`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
 ADD PRIMARY KEY (`id`), ADD KEY `owner` (`owner`);

--
-- Indexes for table `ingredient`
--
ALTER TABLE `ingredient`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `meal`
--
ALTER TABLE `meal`
 ADD PRIMARY KEY (`id`), ADD KEY `restaurantId` (`restaurantId`);

--
-- Indexes for table `mealconsistsof`
--
ALTER TABLE `mealconsistsof`
 ADD PRIMARY KEY (`mealId`,`ingredientId`), ADD KEY `ingredientId` (`ingredientId`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
 ADD PRIMARY KEY (`ingredientId`,`orderId`), ADD KEY `orderId` (`orderId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`id`), ADD KEY `restaurantId` (`restaurantId`), ADD KEY `supplierId` (`supplierId`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
 ADD PRIMARY KEY (`id`), ADD KEY `userId` (`userId`), ADD KEY `restaurantId` (`restaurantId`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
 ADD PRIMARY KEY (`id`), ADD KEY `restaurantId` (`restaurantId`), ADD KEY `userId` (`userId`);

--
-- Indexes for table `reservationmenu`
--
ALTER TABLE `reservationmenu`
 ADD PRIMARY KEY (`mealId`,`reservationId`), ADD KEY `reservationId` (`reservationId`);

--
-- Indexes for table `reservationsseats`
--
ALTER TABLE `reservationsseats`
 ADD PRIMARY KEY (`reservationId`,`seatingNumber`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
 ADD PRIMARY KEY (`id`), ADD KEY `host` (`host`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
 ADD PRIMARY KEY (`ingredientId`,`restaurantId`), ADD KEY `restaurantId` (`restaurantId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ingredient`
--
ALTER TABLE `ingredient`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `meal`
--
ALTER TABLE `meal`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `capacity`
--
ALTER TABLE `capacity`
ADD CONSTRAINT `capacity_ibfk_1` FOREIGN KEY (`restaurantId`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `deliversfor`
--
ALTER TABLE `deliversfor`
ADD CONSTRAINT `deliversfor_ibfk_1` FOREIGN KEY (`supplierId`) REFERENCES `user` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `deliversfor_ibfk_2` FOREIGN KEY (`restaurantId`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hasingredient`
--
ALTER TABLE `hasingredient`
ADD CONSTRAINT `hasingredient_ibfk_1` FOREIGN KEY (`ingredientId`) REFERENCES `ingredient` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `hasingredient_ibfk_2` FOREIGN KEY (`supplierId`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meal`
--
ALTER TABLE `meal`
ADD CONSTRAINT `meal_ibfk_1` FOREIGN KEY (`restaurantId`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mealconsistsof`
--
ALTER TABLE `mealconsistsof`
ADD CONSTRAINT `mealconsistsof_ibfk_1` FOREIGN KEY (`mealId`) REFERENCES `meal` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `mealconsistsof_ibfk_2` FOREIGN KEY (`ingredientId`) REFERENCES `ingredient` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`ingredientId`) REFERENCES `ingredient` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`orderId`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`restaurantId`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`supplierId`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`restaurantId`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`restaurantId`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservationmenu`
--
ALTER TABLE `reservationmenu`
ADD CONSTRAINT `reservationmenu_ibfk_1` FOREIGN KEY (`reservationId`) REFERENCES `reservation` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservationsseats`
--
ALTER TABLE `reservationsseats`
ADD CONSTRAINT `reservationsseats_ibfk_1` FOREIGN KEY (`reservationId`) REFERENCES `reservation` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `restaurant`
--
ALTER TABLE `restaurant`
ADD CONSTRAINT `restaurant_ibfk_1` FOREIGN KEY (`host`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`ingredientId`) REFERENCES `ingredient` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`restaurantId`) REFERENCES `restaurant` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
