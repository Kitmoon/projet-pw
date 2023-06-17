<?php
require_once __DIR__ . '/../database.php';
require_once('user.php');

class UserDAO
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function createUser($user)
    {
        // Connexion bdd
        $db = $this->database->getPDO();

        // On prépare le SQL
        $sql = "INSERT INTO users (nom, prenom, mail, password, isAdmin) VALUES (:nom, :prenom, :mail, :password, :isAdmin)";
        $statement = $db->prepare($sql);

        // Exécution de la requête
        $statement->execute([
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'mail' => $user->getMail(),
            'password' => $user->getPassword(),
            'isAdmin' => $user->isAdmin()
        ]);

        // On ferme la connexion
        $db = null;
    }

    public function getUserByEmail($mail)
    {
        // Connexion bdd
        $db = $this->database->getPDO();

        $sql = 'SELECT * FROM users WHERE mail = :mail LIMIT 1'; // Requête limitée à 1 pour éviter les erreurs
        $statement = $db->prepare($sql);

        // On exécute
        $statement->execute([
            'mail' => $mail,
        ]);

        $userData = $statement->fetch(PDO::FETCH_ASSOC);

        // On ferme la connexion
        $db = null;

        if ($userData) {
            $user = new User($userData['prenom'], $userData['nom'], $userData['mail'], $userData['password'], $userData['isAdmin']);
            $user->setId($userData['user_id']);
            return $user;
        }

        return null;
    }

    public function getUserById($userId)
    {
        $db = $this->database->getPDO();

        $sql = 'SELECT * FROM users WHERE user_id = :user_id LIMIT 1';
        $statement = $db->prepare($sql);

        $statement->execute([
            'user_id' => $userId,
        ]);

        $userData = $statement->fetch(PDO::FETCH_ASSOC);

        $db = null;

        if ($userData) {
            $user = new User($userData['prenom'], $userData['nom'], $userData['mail'], $userData['password'], $userData['isAdmin']);
            $user->setId($userData['user_id']);
            return $user;
        }

        return null;
    }

    public function updateUser($user)
    {
        $db = $this->database->getPDO();

        $sql = "UPDATE users SET nom = :nom, prenom = :prenom, mail = :mail, isAdmin = :isAdmin, password = :password WHERE user_id = :user_id";
        $statement = $db->prepare($sql);

        $statement->execute([
            'user_id' => $user->getId(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'mail' => $user->getMail(),
            'password' => $user->getPassword(),
            'isAdmin' => $user->isAdmin()
        ]);

        $db = null;
    }
}
