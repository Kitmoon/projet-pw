<?php
Session_start();

    if (empty($_SESSION)) {
        echo 'Vous n\'avez pas accès à cette section.';
        echo '<br>';
        echo '<a href="../home.php">Retour à l\'accueil</a>';
        die();
    }

    require_once '../user/userDAO.php';
    require_once '../database.php';

    $database = new Database();
    $userDAO = new UserDAO($database);
    $user = $userDAO->getUserById($_SESSION['user_id']);

    if (!$user->isAdmin()) {
        echo 'Vous n\'avez pas accès à cette section.';
        die();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        /* Styles CSS pour le header */
        header {
            padding: 10px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        header p {
            margin: 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header>
    <h1>Dashboard</h1>
    <a href="../home.php">Accueil</a>
        <a href="dashboard_users.php">Utilisateurs</a>
        <a href="dashboard_annonces.php">Annonces</a>
        <a href="dashboard_demandes.php">Demandes</a>
        <a href="dashboard_lieu.php">Lieux</a>
        <a href="dashboard_festivals.php">Festivals</a>
        <a href="dashboard_trajets.php">Trajets</a>
    </header>
</body>
</html>