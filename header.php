<?php

    echo "<a href='home.php'><h1>FestiCar</h1></a>";
    if (isset($_SESSION['user_id'])) {
        require_once 'user/userDAO.php';
        require_once './database.php';

        $database = new Database();
        $userDAO = new UserDAO($database);

        // On récupère l'user
        $user = $userDAO->getUserById($_SESSION['user_id']);

        echo '<a href="user/logout.php">Déconnexion</a> <a href="account.php">Mon Compte</a>';

        // Si c'est un admin, on affiche le lien vers le dashboard
        if ($user->isAdmin()) {
            echo ' <a href="dashboard/dashboard.php">Dashboard</a>';
        }

        echo '<br>';
        echo '<a href="user_create_annonce.php">Créer une annonce</a>';
    } else {
        echo '<a href="login.php">Connexion</a> <a href="register.php">Inscription</a>';
    }
    ?>