CREATE TABLE `authors` (
  `id` CHAR(36) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `categories` (
  `id` CHAR(36) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `books` (
  `id` char(36) not null,
  `title` varchar(255) not null,
  `description` varchar(255) not null,
  `score` INT NOT NULL,
  `authors` JSON NOT NULL,
  `categories` JSON NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `domain_events` (
  `id` CHAR(36) NOT NULL,
  `aggregate_id` CHAR(36) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `body` JSON NOT NULL,
  `occurred_on` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `books_counter` (
  `id` CHAR(36) NOT NULL,
  `total` INT NOT NULL,
  `existing_books` JSON NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `books_counter` VALUES ("212143e1-6372-4e98-bce0-f1d20a87062f", 0, "[]");

CREATE TABLE `auth_users` (
  `id` CHAR(36) NOT NULL,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `auth_users` VALUES ("d5c3e80b-4e60-49f3-838a-704d512a602d", "serodas", "gav739hBPq2vFp8Xlx1KOJdhLaa5YInM");