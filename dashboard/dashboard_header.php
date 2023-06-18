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
    <link rel="icon" href="https://via.placeholder.com/70x70">
    <link rel="stylesheet" href="../mvp.css">

    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
    <h1>Dashboard</h1>
    <a href="../home.php">Accueil</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="dashboard_users.php">Utilisateurs</a>
        <a href="dashboard_annonces.php">Annonces</a>
        <a href="dashboard_demandes.php">Demandes</a>
        <a href="dashboard_lieu.php">Lieux</a>
        <a href="dashboard_festivals.php">Festivals</a>
        <a href="dashboard_trajets.php">Trajets</a>
    </header>
</body>
</html>