-- Adminer 4.7.8 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `gps`;
CREATE TABLE `gps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `GroupRights` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `GroupEnabled` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`GroupName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `gps` (`id`, `GroupName`, `GroupRights`, `GroupEnabled`) VALUES
(1,	'members',	'a:1:{i:0;s:6:\"upload\";}',	1),
(2,	'human_resources',	'a:5:{i:0;s:6:\"upload\";i:1;s:8:\"edit_own\";i:2;s:16:\"create_own_offer\";i:3;s:17:\"disable_own_offer\";i:4;s:16:\"delete_own_offer\";}',	1),
(3,	'company_director',	'a:8:{i:0;s:6:\"upload\";i:1;s:16:\"edit_own_company\";i:2;s:16:\"create_own_offer\";i:3;s:17:\"disable_own_offer\";i:4;s:16:\"delete_own_offer\";i:5;s:18:\"delete_own_company\";i:6;s:19:\"disable_own_company\";i:7;s:14:\"create_company\";}',	1),
(4,	'moderators',	'a:8:{i:0;s:6:\"upload\";i:1;s:12:\"edit_company\";i:2;s:12:\"create_offer\";i:3;s:13:\"disable_offer\";i:4;s:15:\"disable_company\";i:5;s:14:\"create_company\";i:6;s:10:\"edit_users\";i:7;s:13:\"disable_users\";}',	1),
(5,	'operators',	'a:11:{i:0;s:6:\"upload\";i:1;s:12:\"edit_company\";i:2;s:12:\"create_offer\";i:3;s:13:\"disable_offer\";i:4;s:15:\"disable_company\";i:5;s:14:\"create_company\";i:6;s:10:\"edit_users\";i:7;s:13:\"disable_users\";i:8;s:14:\"delete_company\";i:9;s:12:\"delete_users\";i:10;s:12:\"delete_offer\";}',	1);

-- 2021-02-08 10:13:34
