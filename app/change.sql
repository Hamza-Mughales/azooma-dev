ALTER TABLE `hotel_info` CHANGE `updatedAt` `updatedAt` DATETIME NULL DEFAULT NULL;
ALTER TABLE `admin` CHANGE `country` `country` VARCHAR(200) NULL DEFAULT '1';


// 
ALTER TABLE `azooma`.`press` CHANGE `updatedAt` `updatedAt` datetime NOT NULL DEFAULT now() COMMENT '';
ALTER TABLE `azooma`.`testimonials` CHANGE `updatedAt` `updatedAt` datetime NOT NULL DEFAULT now() COMMENT '';
ALTER TABLE `azooma`.`art_work` CHANGE `updatedAt` `updatedAt` datetime NOT NULL DEFAULT now() COMMENT '';
ALTER TABLE `azooma`.`art_work` CHANGE `img_alt` `img_alt` varchar(255) NULL  COMMENT '';
ALTER TABLE `azooma`.`art_work` CHANGE `img_alt_ar` `img_alt_ar` varchar(255) NULL  COMMENT '';
ALTER TABLE `azooma`.`event` CHANGE `updatedAt` `updatedAt` datetime NOT NULL DEFAULT now() COMMENT '';
ALTER TABLE `azooma`.`event` CHANGE `recipients_test` `recipients_test` varchar(500) NULL  COMMENT '';
ALTER TABLE `azooma`.`event` CHANGE `total_receiver` `total_receiver` int(11) NOT NULL DEFAULT '0' COMMENT '';
ALTER TABLE `azooma`.`newsletter` CHANGE `updatedAt` `updatedAt` datetime NOT NULL DEFAULT now() COMMENT '';
ALTER TABLE `azooma`.`newsletter` CHANGE `html` `html` mediumtext NULL  COMMENT '';
ALTER TABLE `azooma`.`article` CHANGE `updatedAt` `updatedAt` datetime NOT NULL DEFAULT now() COMMENT '';
ALTER TABLE `azooma`.`recipe` CHANGE `author` `author` varchar(255) NOT NULL DEFAULT '0' COMMENT '';
ALTER TABLE `azooma`.`article` CHANGE `views` `views` int(11) NOT NULL DEFAULT '0' COMMENT '';
ALTER TABLE `azooma`.`categories` CHANGE `lastupdatedArticle` `lastupdatedArticle` datetime NOT NULL DEFAULT now() COMMENT '';
ALTER TABLE `azooma`.`district_list` CHANGE `oldID` `oldID` int(11) NOT NULL DEFAULT '0' COMMENT '';
ALTER TABLE `azooma`.`bestfor_list` CHANGE `oldID` `oldID` int(11) NOT NULL DEFAULT '0' COMMENT '';
ALTER TABLE `azooma`.`master_cuisine` CHANGE `viewed` `viewed` int(11) NOT NULL DEFAULT '0' COMMENT '';

//----
ALTER TABLE `image_gallery` CHANGE `updatedAt` `updatedAt` DATETIME NULL;
ALTER TABLE `rest_offer` CHANGE `termsAr` `termsAr` TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL;

//-----
ALTER TABLE `newsletter` CHANGE `cuisines` `cuisines` VARCHAR(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `cities` `cities` VARCHAR(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL;
UPDATE `admin` SET `pass`=MD5(pass);

ALTER TABLE `azooma`.`restaurant_info` CHANGE `lastUpdatedOn` `lastUpdatedOn` timestamp NOT NULL DEFAULT now() COMMENT '';
ALTER TABLE `azooma`.`rest_branches` CHANGE `lastUpdated` `lastUpdated` timestamp NOT NULL DEFAULT now() COMMENT '';


-- Last Update on DB 
ALTER TABLE `azooma`.`notifications` ADD COLUMN `detail` VARCHAR(255) COMMENT '' AFTER `country`;

ALTER TABLE `azooma`.`notifications` CHANGE `createdAt` `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '' AFTER `detail`;

ALTER TABLE `azooma`.`notifications` CHANGE `country` `country` int(2) NOT NULL DEFAULT '1' COMMENT '' AFTER `createdAt`;

ALTER TABLE `azooma`.`notifications` ADD COLUMN `rest_ID` int(11) COMMENT '' AFTER `user_ID`;

ALTER TABLE `azooma`.`notifications` CHANGE `detail` `detail` TEXT NULL  COMMENT '';