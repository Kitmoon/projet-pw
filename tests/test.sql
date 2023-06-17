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


-- Table Annonces
CREATE TABLE `base de données`.`annonces` 
( `annonce_id` INT NOT NULL AUTO_INCREMENT , 
FOREIGN KEY(`driver_id`) REFERENCES (`user_id`), 
`publication_date` DATE NOT NULL,
FOREIGN KEY(`festival_id`) REFERENCES (`festival_id`)
`isEnabled` BOOL NOT NULL,  
PRIMARY KEY (`annonce_id`)) 


-- Table Festivals
CREATE TABLE `base de données`.`festivals` 
( `festival_id` INT NOT NULL AUTO_INCREMENT , 
FOREIGN KEY(`lieu_id`) REFERENCES (`lieu_id`),
`date_debut` DATE NOT NULL,
`date_fin` DATE NOT NULL, 
PRIMARY KEY (`festival_id`)) 


-- Table de photos
CREATE TABLE `base de données`.`photos`
(`photo_id` INT NOT NULL AUTO_INCREMENT,
FORGEIGN KEY(`festival_id`) REFERENCES (`festival_id`),)