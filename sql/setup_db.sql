-- CREATE USER 'cesi'@'localhost' IDENTIFIED BY 'CesiPassWord';
-- GRANT ALL PRIVILEGES ON 'cesistage'.* TO 'cesi'@'localhost';

-- DROP DATABASE cesistage;
-- CREATE DATABASE cesistage;

CREATE TABLE `gps` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL UNIQUE,
  `rights` text NOT NULL,
  `enabled` tinyint NOT NULL
);

CREATE TABLE `company` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL UNIQUE,
  `description` text NOT NULL,
  `enabled` tinyint NOT NULL
);

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `username` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `status` int NOT NULL DEFAULT 0,
  `enabled` tinyint NOT NULL DEFAULT 0,
  `company` int NULL,
  `user_groups` int(11) NULL,
  FOREIGN KEY (`company`) REFERENCES `company` (`id`),
  FOREIGN KEY (`user_groups`) REFERENCES `gps` (`id`)
);

CREATE TABLE `offers` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `starting` date NOT NULL,
  `ending` date NOT NULL,
  `posted` datetime NOT NULL,
  `type` tinyint NOT NULL,
  `status` tinyint NOT NULL,
  `company` int(11) NOT NULL,
  FOREIGN KEY (`company`) REFERENCES `company` (`id`)
);

CREATE TABLE `files` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `file` varchar(255) NOT NULL UNIQUE,
  `offer` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  FOREIGN KEY (`offer`) REFERENCES `offers` (`id`),
  FOREIGN KEY (`user`) REFERENCES `users` (`id`)
);

CREATE TABLE `actions` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `when` timestamp NOT NULL,
  `what` json NOT NULL,
  `user` int(11) NULL,
  `company` int(11) NULL,
  `offer` int(11) NULL,
  `files` int(11) NULL,
  FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  FOREIGN KEY (`company`) REFERENCES `company` (`id`),
  FOREIGN KEY (`offer`) REFERENCES `offers` (`id`),
  FOREIGN KEY (`files`) REFERENCES `files` (`id`)
);
