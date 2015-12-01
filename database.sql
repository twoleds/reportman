CREATE DATABASE IF NOT EXISTS `reportman`
  DEFAULT CHARACTER SET 'utf8'
  DEFAULT COLLATE 'utf8_general_ci';

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  email VARCHAR(255) NOT NULL KEY,
  password VARCHAR(255) NOT NULL
) ENGINE = 'InnoDB';

DROP TABLE IF EXISTS `records`;
CREATE TABLE `records` (
  id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT
) ENGINE = 'InnoDB';