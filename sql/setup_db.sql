CREATE USER 'cesi'@'localhost' IDENTIFIED BY 'CesiPassWord';
GRANT ALL PRIVILEGES ON 'cesistage'.* TO 'cesi'@'localhost';
CREATE DATABASE cesistage;
CREATE TABLE `groups` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `rights` json NOT NULL,
  `enabled` tinyint NOT NULL
);
CREATE TABLE `company` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `enabled` tinyint NOT NULL,
);
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int NOT NULL,
  `enabled` tinyint NOT NULL,
  `company` int NULL,
  `group` int(11) NOT NULL,
  FOREIGN KEY (`company`) REFERENCES `company` (`id`),
  FOREIGN KEY (`group`) REFERENCES `groups` (`id`)
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
CREATE TABLE `cv` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `file` varchar(255) NOT NULL,
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
  `cv` int(11) NULL,
  FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  FOREIGN KEY (`company`) REFERENCES `company` (`id`),
  FOREIGN KEY (`offer`) REFERENCES `offers` (`id`),
  FOREIGN KEY (`cv`) REFERENCES `cv` (`id`)
);
