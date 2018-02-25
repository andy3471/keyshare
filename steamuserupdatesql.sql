ALTER TABLE `users` 
CHANGE COLUMN `username` `username` VARCHAR(32) NOT NULL ,
CHANGE COLUMN `password` `password` CHAR(128) NULL ,
ADD COLUMN `displayname` VARCHAR(45) NULL AFTER `bio`,
ADD COLUMN `steamuser` INT NULL DEFAULT 0 AFTER `displayname`;
CHANGE COLUMN `forename` `forename` VARCHAR(45) NULL ,
CHANGE COLUMN `surname` `surname` VARCHAR(45) NULL ,
CHANGE COLUMN `email` `email` VARCHAR(50) NULL ;
DROP INDEX `email` ;

ALTER TABLE `users` 
CHANGE COLUMN `forename` `forename` VARCHAR(45) NULL ,
CHANGE COLUMN `surname` `surname` VARCHAR(45) NULL ,
CHANGE COLUMN `email` `email` VARCHAR(50) NULL ;



SET SQL_SAFE_UPDATES = 0;

UPDATE `users
SET displayname = username