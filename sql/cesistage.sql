-- Adminer 4.7.8 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `action`;
CREATE TABLE `action` (
  `ActionId` int(11) NOT NULL AUTO_INCREMENT,
  `ActionWhen` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ActionWhat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` int(11) DEFAULT NULL,
  `company` int(11) DEFAULT NULL,
  `offer` int(11) DEFAULT NULL,
  `file` int(11) DEFAULT NULL,
  PRIMARY KEY (`ActionId`),
  KEY `user` (`user`),
  KEY `company` (`company`),
  KEY `offer` (`offer`),
  KEY `file` (`file`),
  CONSTRAINT `action_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`UserId`),
  CONSTRAINT `action_ibfk_2` FOREIGN KEY (`company`) REFERENCES `company` (`CompanyId`),
  CONSTRAINT `action_ibfk_3` FOREIGN KEY (`offer`) REFERENCES `offer` (`OfferId`),
  CONSTRAINT `action_ibfk_4` FOREIGN KEY (`file`) REFERENCES `file` (`FileId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `CompanyId` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CompanyDescription` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `CompanyEnabled` tinyint(4) NOT NULL,
  `CompanyLogo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`CompanyId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `company` (`CompanyId`, `CompanyName`, `CompanyDescription`, `CompanyEnabled`, `CompanyLogo`) VALUES
(1,	'ESA',	'L\'ESA est l\'agence spatiale Européenne\r\nRetrouvez plus d\'infos sur son site… bidul\r\nTruc\r\nChose',	1,	''),
(2,	'Test',	'lct',	1,	'idk.png');

DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `FileId` int(11) NOT NULL AUTO_INCREMENT,
  `FilePath` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`FileId`),
  KEY `user` (`user`),
  CONSTRAINT `file_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`UserId`),
  CONSTRAINT `file_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `groop`;
CREATE TABLE `groop` (
  `GroupId` int(11) NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `GroupRights` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `GroupEnabled` tinyint(4) NOT NULL,
  PRIMARY KEY (`GroupId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `groop` (`GroupId`, `GroupName`, `GroupRights`, `GroupEnabled`) VALUES
(1,	'members',	'a:1:{i:0;s:6:\\\"upload\\\";}',	1),
(2,	'human_resources',	'a:5:{i:0;s:6:\\\"upload\\\";i:1;s:8:\\\"edit_own\\\";i:2;s:16:\\\"create_own_offer\\\";i:3;s:17:\\\"disable_own_offer\\\";i:4;s:16:\\\"delete_own_offer\\\";}',	1),
(3,	'company_director',	'a:8:{i:0;s:6:\\\"upload\\\";i:1;s:16:\\\"edit_own_company\\\";i:2;s:16:\\\"create_own_offer\\\";i:3;s:17:\\\"disable_own_offer\\\";i:4;s:16:\\\"delete_own_offer\\\";i:5;s:18:\\\"delete_own_company\\\";i:6;s:19:\\\"disable_own_company\\\";i:7;s:14:\\\"create_company\\\";}',	1),
(4,	'moderators',	'a:8:{i:0;s:6:\\\"upload\\\";i:1;s:12:\\\"edit_company\\\";i:2;s:12:\\\"create_offer\\\";i:3;s:13:\\\"disable_offer\\\";i:4;s:15:\\\"disable_company\\\";i:5;s:14:\\\"create_company\\\";i:6;s:10:\\\"edit_users\\\";i:7;s:13:\\\"disable_users\\\";}',	1),
(5,	'operators',	'a:11:{i:0;s:6:\\\"upload\\\";i:1;s:12:\\\"edit_company\\\";i:2;s:12:\\\"create_offer\\\";i:3;s:13:\\\"disable_offer\\\";i:4;s:15:\\\"disable_company\\\";i:5;s:14:\\\"create_company\\\";i:6;s:10:\\\"edit_users\\\";i:7;s:13:\\\"disable_users\\\";i:8;s:14:\\\"delete_company\\\";i:9;s:12:\\\"delete_users\\\";i:10;s:12:\\\"delete_offer\\\";}',	1);

DROP TABLE IF EXISTS `offer`;
CREATE TABLE `offer` (
  `OfferId` int(11) NOT NULL AUTO_INCREMENT,
  `OfferStarting` date NOT NULL,
  `OfferEnding` date NOT NULL,
  `OfferPosted` date NOT NULL,
  `OfferType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OfferStatus` int(11) NOT NULL,
  `OfferDescription` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `OfferTitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` int(11) NOT NULL,
  PRIMARY KEY (`OfferId`),
  KEY `company` (`company`),
  CONSTRAINT `offer_ibfk_1` FOREIGN KEY (`company`) REFERENCES `company` (`CompanyId`),
  CONSTRAINT `offer_ibfk_2` FOREIGN KEY (`company`) REFERENCES `company` (`CompanyId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `offer` (`OfferId`, `OfferStarting`, `OfferEnding`, `OfferPosted`, `OfferType`, `OfferStatus`, `OfferDescription`, `OfferTitle`, `company`) VALUES
(1,	'2021-02-10',	'2021-02-10',	'2021-02-10',	'stage',	1,	'Quos consequuntur consectetur dolore vero iusto sunt ut. Non velit adipisci voluptatem. Odio natus mollitia vel. Dolor quasi qui officia. Quo nihil voluptatem sequi. Consequatur voluptas qui dolorem adipisci pariatur.\r\n\r\nDoloribus quia ullam et. Iusto iusto nostrum eius omnis amet dicta sed. Et aut veniam dignissimos consequatur qui amet sunt voluptatibus. Sed ut voluptates delectus quisquam dolor harum. Doloremque molestiae nisi provident consequuntur fugiat rem culpa numquam. Rerum molestiae quaerat distinctio molestias.\r\n\r\nSit quae alias est rem beatae eveniet fugiat doloremque. Quam temporibus quisquam et. Fuga sint cumque et velit. Consectetur ipsum qui ad sint quia sunt corporis aut.\r\n\r\nTotam voluptatem iusto quis. Asperiores aperiam maiores numquam dolorem praesentium. Et vero rerum atque enim. Blanditiis quaerat non maiores. Tempora voluptatum cum explicabo eaque dolores tempore nisi. Molestiae modi sunt exercitationem.\r\n\r\nCommodi optio nostrum ex cumque impedit pariatur veritatis. Porro laborum temporibus officiis eveniet qui soluta. Consequatur et labore nisi et nihil omnis provident. Doloremque velit vel consequatur magni ad dolorem. Nobis illum quos necessitatibus. Dolor provident laudantium ut cupiditate.',	'Test',	2),
(2,	'2021-02-10',	'2021-02-10',	'2021-02-10',	'Alternance',	1,	'ESA',	'ESA',	1);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `UserLastName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `UserEmail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `UserUsername` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `UserPassword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `UserEnabled` tinyint(4) NOT NULL,
  `UserDescription` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `UserPictureFile` int(11) DEFAULT NULL,
  `company` int(11) DEFAULT NULL,
  `groop` int(11) NOT NULL,
  PRIMARY KEY (`UserId`),
  KEY `company` (`company`),
  KEY `groop` (`groop`),
  KEY `UserPictureFile` (`UserPictureFile`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`company`) REFERENCES `company` (`CompanyId`),
  CONSTRAINT `user_ibfk_3` FOREIGN KEY (`company`) REFERENCES `company` (`CompanyId`),
  CONSTRAINT `user_ibfk_4` FOREIGN KEY (`groop`) REFERENCES `groop` (`GroupId`),
  CONSTRAINT `user_ibfk_5` FOREIGN KEY (`UserPictureFile`) REFERENCES `file` (`FileId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`UserId`, `UserName`, `UserLastName`, `UserEmail`, `UserUsername`, `UserPassword`, `UserEnabled`, `UserDescription`, `UserPictureFile`, `company`, `groop`) VALUES
(2,	'ERA',	'Era',	'era@era.era',	'era',	'$argon2id$v=19$m=2048,t=4,p=3$QVYwb0R6T25OanVMWGszcQ$kzM0yfoJESILiMVMXBkOeeUuO4BvuOt9kbb9LaU4rjo',	1,	'Bruh',	NULL,	1,	1),
(3,	'esa',	'ESA',	'esa@esa.eu',	'esa',	'$argon2id$v=19$m=2048,t=4,p=3$V05pWUlDMWh2YTg2RVBPbg$LWN7snvXwSLYWmLYcN0+WcU/d80ol8B3JEVvz75A+ms',	1,	'L\'ESA est l\'agence spatiale européenne.',	NULL,	1,	5);

-- 2021-02-10 13:33:53
