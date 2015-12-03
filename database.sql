CREATE DATABASE IF NOT EXISTS `reportman`
  DEFAULT CHARACTER SET 'utf8'
  DEFAULT COLLATE 'utf8_general_ci';

# TABLES

DROP TABLE IF EXISTS `reports`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id`       INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name`     VARCHAR(45)  NOT NULL,
  `email`    VARCHAR(255) NOT NULL UNIQUE KEY,
  `password` VARCHAR(255) NOT NULL
)
  ENGINE = 'InnoDB';

CREATE TABLE `reports` (
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

INSERT INTO `reports`
SET
  `issue_id`       = NULL,
  `issue_text`     = 'Studying zend documentation',
  `spent_time`     = 90,
  `estimated_time` = 4710,
  `complete`       = 5,
  `user_id`        = 1,
  `date`           = '2015-12-01';

INSERT INTO `reports`
SET
  `issue_id`       = NULL,
  `issue_text`     = 'Studying zend adapters',
  `spent_time`     = 30,
  `estimated_time` = 4680,
  `complete`       = 5,
  `user_id`        = 1,
  `date`           = '2015-12-01';

INSERT INTO `reports`
SET
  `issue_id`       = NULL,
  `issue_text`     = 'Created skeleton application for reportman project',
  `spent_time`     = 60,
  `estimated_time` = 2340,
  `complete`       = 5,
  `user_id`        = 1,
  `date`           = '2015-12-01';

INSERT INTO `reports`
SET
  `issue_id`       = NULL,
  `issue_text`     = 'Studying zend session',
  `spent_time`     = 30,
  `estimated_time` = 4650,
  `complete`       = 10,
  `user_id`        = 1,
  `date`           = '2015-12-02';

INSERT INTO `reports`
SET
  `issue_id`       = NULL,
  `issue_text`     = 'Added login/logout to the system',
  `spent_time`     = 90,
  `estimated_time` = 2250,
  `complete`       = 10,
  `user_id`        = 1,
  `date`           = '2015-12-02';

INSERT INTO `reports`
SET
  `issue_id`       = NULL,
  `issue_text`     = 'Added registration',
  `spent_time`     = 60,
  `estimated_time` = 2190,
  `complete`       = 15,
  `user_id`        = 1,
  `date`           = '2015-12-03';
