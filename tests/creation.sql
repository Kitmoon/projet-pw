CREATE DATABASE `festicar`;

-- Table Users
CREATE TABLE `base de données`.`users` 
( `user_id` INT NOT NULL AUTO_INCREMENT , 
`nom` VARCHAR(128) NOT NULL , 
`prenom` VARCHAR(128) NOT NULL , 
`mail` VARCHAR(256) NOT NULL , 
`password` VARCHAR(128) NOT NULL , 
`isAdmin` BOOLEAN NOT NULL DEFAULT FALSE , 
PRIMARY KEY (`user_id`)) 

insert into `users` (`nom`, `prenom`, `mail`, `password`, `isAdmin`) values (`Alexandre`, 'Le Poulichet', 'alex.kalonkoat@gmail.com', 'admin', TRUE);