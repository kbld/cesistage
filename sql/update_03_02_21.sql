ALTER TABLE `company`
CHANGE `name` `CompanyName` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `id`,
CHANGE `description` `CompanyDescription` text COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `CompanyName`,
CHANGE `enabled` `CompanyEnabled` tinyint(4) NOT NULL AFTER `CompanyDescription`,
ADD `CompanyLogo` varchar(255) NOT NULL;
ALTER TABLE `offers`
CHANGE `starting` `OfferStarting` date NOT NULL AFTER `id`,
CHANGE `ending` `OfferEnding` date NOT NULL AFTER `OfferStarting`,
CHANGE `posted` `OfferPosted` datetime NOT NULL AFTER `OfferEnding`,
CHANGE `type` `OfferType` varchar(255) NOT NULL AFTER `OfferPosted`,
CHANGE `status` `OfferStatus` tinyint(4) NOT NULL AFTER `OfferType`,
CHANGE `description` `OfferDescription` text COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `company`,
CHANGE `title` `OfferTitle` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `OfferDescription`,
ADD FOREIGN KEY (`OfferCompany`) REFERENCES `company` (`id`);
ALTER TABLE `gps`
CHANGE `name` `GroupName` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `id`,
CHANGE `rights` `GroupRights` text COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `GroupName`,
CHANGE `enabled` `GroupEnabled` tinyint(4) NOT NULL AFTER `GroupRights`;
ALTER TABLE `files`
CHANGE `file` `FilePath` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `id`,
ADD FOREIGN KEY (`offer`) REFERENCES `offers` (`id`),
ADD FOREIGN KEY (`user`) REFERENCES `users` (`id`);
ALTER TABLE `actions`
CHANGE `when` `ActionWhen` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP AFTER `id`,
CHANGE `what` `ActionWhat` longtext COLLATE 'utf8mb4_bin' NOT NULL AFTER `ActionWhen`,
ADD FOREIGN KEY (`user`) REFERENCES `users` (`id`),
ADD FOREIGN KEY (`company`) REFERENCES `company` (`id`),
ADD FOREIGN KEY (`offer`) REFERENCES `offers` (`id`),
ADD FOREIGN KEY (`files`) REFERENCES `files` (`id`);
