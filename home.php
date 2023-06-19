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
    <header>
    <p><a href="./search_annonce.php"><i>Rechercher des trajets</i></a><a href="./search_demande.php"><b>Trouver des festivaliers &rarr;</b></a></p>
    </header>
    <main>
    <hr>
        <section>
            <header>
                <h2>Liste des annonces</h2>
                <p>Rendez-vous à votre festival préféré en respectant la nature !</p>
            </header>
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
        </section>

    </main>
</body>

</html>