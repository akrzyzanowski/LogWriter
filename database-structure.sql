CREATE TABLE `logs` (
  `id` INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'event date',
  `title` VARCHAR(100) COLLATE utf8_general_ci NOT NULL COMMENT 'event title',
  `url` VARCHAR(200) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'event url',
  `message` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'event message',
  `file` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'event file',
  `type` TINYINT(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 - information | 1 - edit | 2 - warning | 3 - error',
  PRIMARY KEY USING BTREE (`id`)
) ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT='table contains events logs'
;