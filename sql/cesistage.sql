-- Adminer 4.7.8 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `actions`;
CREATE TABLE `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ActionWhen` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ActionWhat` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `user` int(11) DEFAULT NULL,
  `company` int(11) DEFAULT NULL,
  `offer` int(11) DEFAULT NULL,
  `files` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `company` (`company`),
  KEY `offer` (`offer`),
  KEY `files` (`files`),
  CONSTRAINT `actions_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  CONSTRAINT `actions_ibfk_2` FOREIGN KEY (`company`) REFERENCES `company` (`id`),
  CONSTRAINT `actions_ibfk_3` FOREIGN KEY (`offer`) REFERENCES `offers` (`id`),
  CONSTRAINT `actions_ibfk_4` FOREIGN KEY (`files`) REFERENCES `files` (`id`),
  CONSTRAINT `actions_ibfk_5` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  CONSTRAINT `actions_ibfk_6` FOREIGN KEY (`company`) REFERENCES `company` (`id`),
  CONSTRAINT `actions_ibfk_7` FOREIGN KEY (`offer`) REFERENCES `offers` (`id`),
  CONSTRAINT `actions_ibfk_8` FOREIGN KEY (`files`) REFERENCES `files` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CompanyDescription` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `CompanyEnabled` tinyint(4) NOT NULL,
  `CompanyLogo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`CompanyName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `company` (`id`, `CompanyName`, `CompanyDescription`, `CompanyEnabled`, `CompanyLogo`) VALUES
(1,	'ESA',	'L\'ESA est l\'agence spatiale Européenne\r\nRetrouvez plus d\'infos sur son site… bidul\r\nTruc\r\nChose',	1,	''),
(2,	'Test',	'lct',	1,	'idk.png');

DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FilePath` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `offer` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file` (`FilePath`),
  KEY `offer` (`offer`),
  KEY `user` (`user`),
  CONSTRAINT `files_ibfk_1` FOREIGN KEY (`offer`) REFERENCES `offers` (`id`),
  CONSTRAINT `files_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  CONSTRAINT `files_ibfk_3` FOREIGN KEY (`offer`) REFERENCES `offers` (`id`),
  CONSTRAINT `files_ibfk_4` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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
(1, 'members',  'a:1:{i:0;s:6:\"upload\";}',  1),
(2, 'human_resources',  'a:5:{i:0;s:6:\"upload\";i:1;s:8:\"edit_own\";i:2;s:16:\"create_own_offer\";i:3;s:17:\"disable_own_offer\";i:4;s:16:\"delete_own_offer\";}',  1),
(3, 'company_director', 'a:8:{i:0;s:6:\"upload\";i:1;s:16:\"edit_own_company\";i:2;s:16:\"create_own_offer\";i:3;s:17:\"disable_own_offer\";i:4;s:16:\"delete_own_offer\";i:5;s:18:\"delete_own_company\";i:6;s:19:\"disable_own_company\";i:7;s:14:\"create_company\";}',  1),
(4, 'moderators', 'a:8:{i:0;s:6:\"upload\";i:1;s:12:\"edit_company\";i:2;s:12:\"create_offer\";i:3;s:13:\"disable_offer\";i:4;s:15:\"disable_company\";i:5;s:14:\"create_company\";i:6;s:10:\"edit_users\";i:7;s:13:\"disable_users\";}', 1),
(5, 'operators',  'a:11:{i:0;s:6:\"upload\";i:1;s:12:\"edit_company\";i:2;s:12:\"create_offer\";i:3;s:13:\"disable_offer\";i:4;s:15:\"disable_company\";i:5;s:14:\"create_company\";i:6;s:10:\"edit_users\";i:7;s:13:\"disable_users\";i:8;s:14:\"delete_company\";i:9;s:12:\"delete_users\";i:10;s:12:\"delete_offer\";}', 1);

DROP TABLE IF EXISTS `offers`;
CREATE TABLE `offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OfferStarting` date NOT NULL,
  `OfferEnding` date NOT NULL,
  `OfferPosted` datetime NOT NULL,
  `OfferType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OfferStatus` tinyint(4) NOT NULL,
  `company` int(11) NOT NULL,
  `OfferDescription` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `OfferTitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company` (`company`),
  CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`company`) REFERENCES `company` (`id`),
  CONSTRAINT `offers_ibfk_2` FOREIGN KEY (`company`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `offers` (`id`, `OfferStarting`, `OfferEnding`, `OfferPosted`, `OfferType`, `OfferStatus`, `company`, `OfferDescription`, `OfferTitle`) VALUES
(1,	'2021-01-29',	'2021-01-29',	'2021-01-29 11:05:23',	'stage',	1,	1,	'Quos consequuntur consectetur dolore vero iusto sunt ut. Non velit adipisci voluptatem. Odio natus mollitia vel. Dolor quasi qui officia. Quo nihil voluptatem sequi. Consequatur voluptas qui dolorem adipisci pariatur.\r\n\r\nDoloribus quia ullam et. Iusto iusto nostrum eius omnis amet dicta sed. Et aut veniam dignissimos consequatur qui amet sunt voluptatibus. Sed ut voluptates delectus quisquam dolor harum. Doloremque molestiae nisi provident consequuntur fugiat rem culpa numquam. Rerum molestiae quaerat distinctio molestias.\r\n\r\nSit quae alias est rem beatae eveniet fugiat doloremque. Quam temporibus quisquam et. Fuga sint cumque et velit. Consectetur ipsum qui ad sint quia sunt corporis aut.\r\n\r\nTotam voluptatem iusto quis. Asperiores aperiam maiores numquam dolorem praesentium. Et vero rerum atque enim. Blanditiis quaerat non maiores. Tempora voluptatum cum explicabo eaque dolores tempore nisi. Molestiae modi sunt exercitationem.\r\n\r\nCommodi optio nostrum ex cumque impedit pariatur veritatis. Porro laborum temporibus officiis eveniet qui soluta. Consequatur et labore nisi et nihil omnis provident. Doloremque velit vel consequatur magni ad dolorem. Nobis illum quos necessitatibus. Dolor provident laudantium ut cupiditate.',	'Test'),
(2,	'2021-01-29',	'2021-01-29',	'2021-01-29 11:08:13',	'stage',	1,	1,	'offers_number',	'Test');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `enabled` tinyint(4) NOT NULL DEFAULT 0,
  `company` int(11) DEFAULT NULL,
  `user_groups` int(11) DEFAULT NULL,
  `ProfilePicture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  KEY `company` (`company`),
  KEY `user_groups` (`user_groups`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`company`) REFERENCES `company` (`id`),
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`user_groups`) REFERENCES `gps` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `lastName`, `email`, `username`, `password`, `status`, `enabled`, `company`, `user_groups`, `ProfilePicture`, `Description`) VALUES
(2,	'era',	'',	'era@era.era',	'era',	'$argon2id$v=19$m=2048,t=4,p=3$QVYwb0R6T25OanVMWGszcQ$kzM0yfoJESILiMVMXBkOeeUuO4BvuOt9kbb9LaU4rjo',	0,	0,	NULL,	NULL,	NULL,	NULL),
(3,	'esa',	'esa',	'esa@esa.eu',	'esa',	'$argon2id$v=19$m=2048,t=4,p=3$V05pWUlDMWh2YTg2RVBPbg$LWN7snvXwSLYWmLYcN0+WcU/d80ol8B3JEVvz75A+ms',	0,	0,	1,	NULL,	NULL,	NULL);

-- 2021-02-05 14:57:58
