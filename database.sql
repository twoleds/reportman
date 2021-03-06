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
  `password` VARCHAR(255) NOT NULL,
  `admin`    TINYINT(1)   NOT NULL             DEFAULT 0
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
  INDEX (`user_id`, `date`, `issue_id`),
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
  `password` = '$2y$10$HnAkR6XsWeuv4l.oo2sj0OaUEWRGZbBrDhO4AL8sd981Cm4cNH59G',
  `admin`    = 1;

INSERT INTO `users`
SET
  `name`     = 'Lukáš Kováč',
  `email`    = 'lukas.kvc@gmail.com',
  `password` = '$2y$10$HnAkR6XsWeuv4l.oo2sj0OaUEWRGZbBrDhO4AL8sd981Cm4cNH59G';

INSERT INTO `users`
SET
  `name`     = 'Michal Tinka',
  `email`    = 'michal.tinka@gmail.com',
  `password` = '$2y$10$HnAkR6XsWeuv4l.oo2sj0OaUEWRGZbBrDhO4AL8sd981Cm4cNH59G';

INSERT INTO `reports`
SET
  `issue_id`       = 1,
  `issue_text`     = 'Studying zend documentation',
  `spent_time`     = 90,
  `estimated_time` = 4710,
  `complete`       = 5,
  `user_id`        = 1,
  `date`           = '2015-12-01';

INSERT INTO `reports`
SET
  `issue_id`       = 1,
  `issue_text`     = 'Studying zend adapters',
  `spent_time`     = 30,
  `estimated_time` = 4680,
  `complete`       = 5,
  `user_id`        = 1,
  `date`           = '2015-12-01';

INSERT INTO `reports`
SET
  `issue_id`       = 2,
  `issue_text`     = 'Created skeleton application for reportman project',
  `spent_time`     = 60,
  `estimated_time` = 2340,
  `complete`       = 5,
  `user_id`        = 1,
  `date`           = '2015-12-01';

INSERT INTO `reports`
SET
  `issue_id`       = 1,
  `issue_text`     = 'Studying zend session',
  `spent_time`     = 30,
  `estimated_time` = 4650,
  `complete`       = 10,
  `user_id`        = 1,
  `date`           = '2015-12-02';

INSERT INTO `reports`
SET
  `issue_id`       = 2,
  `issue_text`     = 'Added login/logout to the system',
  `spent_time`     = 90,
  `estimated_time` = 2250,
  `complete`       = 10,
  `user_id`        = 1,
  `date`           = '2015-12-02';

INSERT INTO `reports`
SET
  `issue_id`       = 2,
  `issue_text`     = 'Added registration',
  `spent_time`     = 60,
  `estimated_time` = 2190,
  `complete`       = 15,
  `user_id`        = 1,
  `date`           = '2015-12-03';

INSERT INTO `reports`
SET
  `issue_id`       = 1,
  `issue_text`     = 'Studying how to create custom helper for view',
  `spent_time`     = 15,
  `estimated_time` = 4635,
  `complete`       = 15,
  `user_id`        = 1,
  `date`           = '2015-12-03';

INSERT INTO `reports`
SET
  `issue_id`       = 2,
  `issue_text`     = 'Created list for reports (without filtering)',
  `spent_time`     = 60,
  `estimated_time` = 2130,
  `complete`       = 20,
  `user_id`        = 1,
  `date`           = '2015-12-03';

INSERT INTO `reports`
SET
  `issue_id`       = 2,
  `issue_text`     = 'Added filtering and exporting of reports',
  `spent_time`     = 60,
  `estimated_time` = 2070,
  `complete`       = 25,
  `user_id`        = 1,
  `date`           = '2015-12-04';

INSERT INTO `reports`
SET
  `issue_id`       = 1,
  `issue_text`     = 'Studying ajax / restful controllers and JSON responses',
  `spent_time`     = 60,
  `estimated_time` = 4545,
  `complete`       = 15,
  `user_id`        = 1,
  `date`           = '2015-12-05';

INSERT INTO `reports`
SET
  `issue_id`       = 2,
  `issue_text`     = 'Created restful controller for reading & editing reports',
  `spent_time`     = 150,
  `estimated_time` = 1920,
  `complete`       = 30,
  `user_id`        = 1,
  `date`           = '2015-12-05';

INSERT INTO `reports`
SET
  `issue_id`       = 2,
  `issue_text`     = 'Dialog for changing user settings',
  `spent_time`     = 60,
  `estimated_time` = 1860,
  `complete`       = 30,
  `user_id`        = 1,
  `date`           = '2015-12-03';

INSERT INTO `reports`
SET
  `issue_id`       = 3,
  `issue_text`     = 'Testing project reportman',
  `spent_time`     = 30,
  `estimated_time` = 240,
  `complete`       = 30,
  `user_id`        = 2,
  `date`           = '2015-12-05';
