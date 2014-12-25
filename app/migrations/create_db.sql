SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `nplayground`;
CREATE DATABASE `nplayground` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `nplayground`;

/* workaround for missing mysql functionality DROP USER IF EXIST http://bugs.mysql.com/bug.php?id=19166 */
GRANT USAGE ON *.* TO 'nplayground'@'localhost';
DROP USER 'nplayground'@'localhost';

CREATE USER 'nplayground'@'localhost' IDENTIFIED BY PASSWORD '*D2209010EC8EE4C51F5C4363F457E0C8DA04CF2A';
GRANT ALL PRIVILEGES ON nplayground.* TO 'nplayground'@'localhost';
