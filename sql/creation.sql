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

-- Table Vehicules
CREATE TABLE `base de données`.`vehicules` 
( `vehicule_id` INT NOT NULL AUTO_INCREMENT , 
FOREIGN KEY(`driver_id`) REFERENCES (`user_id`),
`marque` VARCHAR(128) NOT NULL , 
`modele` VARCHAR(128) NOT NULL , 
`couleur` VARCHAR(128) NOT NULL , 
`nb_places` INT(3) NOT NULL , 
PRIMARY KEY (`vechicule_id`)) 




insert into `users` (`nom`, `prenom`, `mail`, `password`, `isAdmin`) values (`Alexandre`, 'Le Poulichet', 'alex.kalonkoat@gmail.com', 'admin', TRUE);