/*CREATE TABLE `Filter` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `filterDefinitionId` int unsigned NOT NULL,
  `fileColumnId` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (fileColumnId) REFERENCES FileColumn(id)
);

CREATE TABLE `FilterAttribute` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `filterId` int unsigned NOT NULL,
  `filterAttributeDefinitionId` int unsigned NOT NULL,
  `value` varchar(1024),
  PRIMARY KEY (`id`),
  FOREIGN KEY (filterId) REFERENCES Filter(id)
);*/

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
  PRIMARY KEY (`id`),
  FOREIGN KEY (fileId) REFERENCES File(id)
);

CREATE TABLE `FileCell` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `fileId` int unsigned NOT NULL,
  `fileColumnId` int unsigned NOT NULL,
  `fileRowId` int unsigned NOT NULL,
  `originalValue` text,
  `value` text,
  PRIMARY KEY (`id`),
  FOREIGN KEY (fileId) REFERENCES File(id),
  FOREIGN KEY (fileColumnId) REFERENCES FileColumn(id),
  FOREIGN KEY (fileRowId) REFERENCES FileRow(id)
);