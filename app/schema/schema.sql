/*CREATE TABLE `FilterAttribute` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `filterId` int unsigned NOT NULL,
  `filterAttributeDefinitionId` int unsigned NOT NULL,
  `value` varchar(1024),
  PRIMARY KEY (`id`),
  FOREIGN KEY (filterId) REFERENCES Filter(id)
);*/

CREATE TABLE `FilterDefinition` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` varchar(4096),
  PRIMARY KEY (`id`)
);

CREATE TABLE `File` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `uploadDate` datetime NOT NULL,
  `hasHeaderRow` BOOL,
  `originalColumnCount` int unsigned NOT NULL,
  `originalRowCount` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `FileRow` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `fileId` int unsigned NOT NULL,
  `rowNumber` int unsigned NOT NULL,
  `skipInOutput` BOOL,
  `isHeaderRow` BOOL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (fileId) REFERENCES File(id)
);

CREATE TABLE `FileColumn` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `fileId` int unsigned NOT NULL,
  `columnNumber` int unsigned NOT NULL,
  `originalName` varchar(128),
  `name` varchar(128),
  `filterDefinitionId` int unsigned,
  PRIMARY KEY (`id`),
  FOREIGN KEY (fileId) REFERENCES File(id),
  FOREIGN KEY (filterDefinitionId) REFERENCES FilterDefinition(id)
);

CREATE TABLE `FileCell` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `fileId` int unsigned NOT NULL,
  `fileColumnId` int unsigned NOT NULL,
  `fileRowId` int unsigned NOT NULL,
  `originalValue` text,
  `value` text,
  `isCleaned` BOOL,
  `isValid` BOOL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (fileId) REFERENCES File(id),
  FOREIGN KEY (fileColumnId) REFERENCES FileColumn(id),
  FOREIGN KEY (fileRowId) REFERENCES FileRow(id)
);

CREATE TABLE `JobStatus` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `Job` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `statusId` int unsigned NOT NULL,
  `progressDescription` text,
  PRIMARY KEY (`id`),
  FOREIGN KEY (statusId) REFERENCES JobStatus(id)
);

INSERT INTO `FilterDefinition`(`id`, `name`) VALUES (1,'Phone Number');
INSERT INTO `FilterDefinition`(`id`, `name`) VALUES (2,'Name');
INSERT INTO `FilterDefinition`(`id`, `name`) VALUES (3,'Full Name');
INSERT INTO `FilterDefinition`(`id`, `name`) VALUES (4,'Address Line');
INSERT INTO `FilterDefinition`(`id`, `name`) VALUES (5,'State Abbreviation');
INSERT INTO `FilterDefinition`(`id`, `name`) VALUES (6,'Postal Code');
INSERT INTO `JobStatus`(`id`, `name`) VALUES (1,'Processing');
INSERT INTO `JobStatus`(`id`, `name`) VALUES (2,'Complete: Succeeded');
INSERT INTO `JobStatus`(`id`, `name`) VALUES (3,'Complete: Failed');