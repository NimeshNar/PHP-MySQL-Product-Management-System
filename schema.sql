-- Database Schema for user_db

-- USE `user_db`;

-- Table structure for table `user`
CREATE TABLE IF NOT EXISTS `user` (
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`name`),
  UNIQUE KEY `email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `product`
CREATE TABLE IF NOT EXISTS `product` (
  `pid` INT(11) NOT NULL AUTO_INCREMENT,
  `pname` VARCHAR(255) NOT NULL,
  `pprice` DECIMAL(10, 2) NOT NULL,
  `pcategory` VARCHAR(100) NOT NULL,
  `pquantity` INT(11) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
