-- Table Users
CREATE TABLE `base de données`.`users` 
( `user_id` INT NOT NULL AUTO_INCREMENT , 
`nom` VARCHAR(128) NOT NULL , 
`prenom` VARCHAR(128) NOT NULL , 
`mail` VARCHAR(256) NOT NULL , 
`password` VARCHAR(128) NOT NULL , 
`isAdmin` BOOLEAN NOT NULL DEFAULT FALSE , 
PRIMARY KEY (`user_id`)) 
ENGINE = InnoDB;


-- Table Vehicules
CREATE TABLE `base de données`.`vehicules` 
( `vehicule_id` INT NOT NULL AUTO_INCREMENT , 
FOREIGN KEY(`driver_id`) REFERENCES (`user_id`),
`marque` VARCHAR(128) NOT NULL , 
`modele` VARCHAR(128) NOT NULL , 
`couleur` VARCHAR(128) NOT NULL , 
`nb_places` VARCHAR(128) NOT NULL , 
PRIMARY KEY (`vechicule_id`)) 
ENGINE = InnoDB;


-- Table Annonces
CREATE TABLE `base de données`.`annonces` 
( `annonce_id` INT NOT NULL AUTO_INCREMENT , 
FOREIGN KEY(`driver_id`) REFERENCES (`user_id`), 
`marque` VARCHAR(128) NOT NULL , 
`modele` VARCHAR(128) NOT NULL , 
`couleur` VARCHAR(128) NOT NULL , 
`nb_places` VARCHAR(128) NOT NULL , 
`isAdmin` BOOLEAN NOT NULL DEFAULT FALSE , 
PRIMARY KEY (`annonce_id`)) 
ENGINE = InnoDB;