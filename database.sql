CREATE DATABASE IF NOT EXISTS `reportman`
  DEFAULT CHARACTER SET 'utf8'
  DEFAULT COLLATE 'utf8_general_ci';

# TABLES

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id`       INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name`     VARCHAR(45)  NOT NULL,
  `email`    VARCHAR(255) NOT NULL KEY,
  `password` VARCHAR(255) NOT NULL
)
  ENGINE = 'InnoDB';

DROP TABLE IF EXISTS `records`;
CREATE TABLE `records` (
  `id`             INT UNSIGNED  NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `issue_id`       INT UNSIGNED  NULL,
  `issue_text`     VARCHAR(4096) NULL,
  `spent_time`     SMALLINT      NOT NULL,
  `estimated_time` SMALLINT      NOT NULL,
  `complete`       TINYINT       NOT NULL,
  `user_id`        INT UNSIGNED  NOT NULL,
  `date`           DATE          NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
  ENGINE = 'InnoDB';

# STARTING DATA

INSERT INTO `users`
SET
  `name`     = 'Jaroslav Kuba',
  `email`    = 'kubajaroslav@gmail.com',
  `password` = '$2y$10$HnAkR6XsWeuv4l.oo2sj0OaUEWRGZbBrDhO4AL8sd981Cm4cNH59G';
