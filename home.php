<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>FestiCar - Page d'Accueil</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <?php include_once('./header.php'); ?>
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
</body>

</html>