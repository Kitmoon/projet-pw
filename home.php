<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>FestiCar - Page d'Accueil</title>
    <link rel="icon" href="https://via.placeholder.com/70x70">
    <link rel="stylesheet" href="./mvp.css">

    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include_once('./header.php'); ?>
    <main>
        <h2>Liste des annonces :</h2>
        <?php

        require_once './database.php';
        require_once './posts/annonce.php';
        require_once './posts/annonceDAO.php';
        require_once './display.php';
        $database = new Database();
        $annonceDAO = new AnnonceDAO($database);
        $annonces = $annonceDAO->getAllAnnonces();
        echo displayAnnonces($annonces, 'home');
        ?>
    </main>
</body>

</html>