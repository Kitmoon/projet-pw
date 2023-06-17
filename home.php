<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>FestiCar - Page d'Accueil</title>
</head>

<body>
    <h1>FestiCar</h1>
    <?php
    if (isset($_SESSION['user_id'])) {
        require_once 'user/userDAO.php';
        require_once './database.php';

        $database = new Database();
        $userDAO = new UserDAO($database);

        // On récupère l'user
        $user = $userDAO->getUserById($_SESSION['user_id']);

        // Si c'est un admin, on affiche le lien vers le dashboard
        if ($user->isAdmin()) {
            echo '<a href="user/logout.php">Déconnexion</a> <a href="user/account.php">Mon Compte</a> <a href="dashboard.php">Dashboard</a>';
        } else {
            echo '<a href="user/logout.php">Déconnexion</a> <a href="user/account.php">Mon Compte</a>';
        }
    } else {
        echo '<a href="user/login.php">Connexion</a> <a href="user/register.php">Inscription</a>';
    }
    ?>
</body>

</html>
