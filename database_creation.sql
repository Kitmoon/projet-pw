CREATE DATABASE `festicar`;

-- Table Users
CREATE TABLE `festicar`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(128) NOT NULL,
  `prenom` VARCHAR(128) NOT NULL,
  `mail` VARCHAR(256) NOT NULL,
  `password` VARCHAR(128) NOT NULL,
  `isAdmin` BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (`user_id`)
);

-- Table Lieux
CREATE TABLE `festicar`.`lieux` (
  `lieu_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(128) NOT NULL,
  `adresse` VARCHAR(256) NOT NULL,
  `ville` VARCHAR(256) NOT NULL, 
  `code_postal` INT NOT NULL 
);


-- Table Festivals
CREATE TABLE `festicar`.`festivals` (
  `festival_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(256),
  `lieu_id` INT NOT NULL,
  `date_debut` DATE NOT NULL,
  `date_fin` DATE NOT NULL,
  `photo` VARCHAR(256),
  FOREIGN KEY (`lieu_id`) REFERENCES `lieux` (`lieu_id`)
);


-- Table Photos
CREATE TABLE `festicar`.`photos` (
  `photo_id` INT NOT NULL AUTO_INCREMENT,
  `festival_id` INT NOT NULL,
  `photo` VARCHAR(256) NOT NULL,
  FOREIGN KEY (`festival_id`) REFERENCES `festivals` (`festival_id`),
  PRIMARY KEY (`photo_id`)
);


-- Table Trajets
CREATE TABLE `festicar`.`trajets` (
  `trajet_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `festival_id` INT NOT NULL,
  `driver_id` INT NOT NULL,
  `date_depart` DATETIME NOT NULL,
  `lieu_depart` INT NOT NULL, 
  `lieu_arrivee` INT NOT NULL,
  `prix` DECIMAL(10, 2) NOT NULL,
  `description` TEXT NOT NULL,
  FOREIGN KEY (`festival_id`) REFERENCES `festivals` (`festival_id`),
  FOREIGN KEY (`driver_id`) REFERENCES `users` (`user_id`),
  FOREIGN KEY (`lieu_depart`) REFERENCES `lieux` (`lieu_id`),
  FOREIGN KEY (`lieu_arrivee`) REFERENCES `lieux` (`lieu_id`)
);


-- Table Annonces
CREATE TABLE `festicar`.`annonces` (
  `annonce_id` INT NOT NULL AUTO_INCREMENT,
  `driver_id` INT NOT NULL,
  `trajet_id` INT NOT NULL,
  `publication_date` DATE NOT NULL,
  `festival_id` INT NOT NULL,
  `vehicule_id` INT,
  `isEnabled` TINYINT(1) NOT NULL,
  FOREIGN KEY (`driver_id`) REFERENCES `users` (`user_id`),
  FOREIGN KEY (`trajet_id`) REFERENCES `trajets` (`trajet_id`),
  FOREIGN KEY (`festival_id`) REFERENCES `festivals` (`festival_id`),
  FOREIGN KEY (`vehicule_id`) REFERENCES `festivals` (`vehicule_id`),
  PRIMARY KEY (`annonce_id`)
);


-- Table Demandes
CREATE TABLE `festicar`.`demandes` (
  `demande_id` INT NOT NULL AUTO_INCREMENT,
  `author_id` INT NOT NULL,
  `lieu_id` INT NOT NULL,
  `publication_date` DATE NOT NULL,
  `festival_id` INT NOT NULL,
  `isEnabled` TINYINT(1) NOT NULL,
  FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`),
  FOREIGN KEY (`lieu_id`) REFERENCES `lieux` (`lieu_id`),
  FOREIGN KEY (`festival_id`) REFERENCES `festivals` (`festival_id`),
  PRIMARY KEY (`demande_id`)
);


-- Table Vehicules
CREATE TABLE `festicar`.`vehicules` (
  `vehicule_id` INT NOT NULL AUTO_INCREMENT,
  `driver_id` INT NOT NULL,
  `marque` VARCHAR(128) NOT NULL,
  `modele` VARCHAR(128) NOT NULL,
  `couleur` VARCHAR(128) NOT NULL,
  `nb_places` INT NOT NULL,
  FOREIGN KEY (`driver_id`) REFERENCES `users` (`user_id`),
  PRIMARY KEY (`vehicule_id`)
);