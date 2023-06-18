<?php
require_once '../user/user.php';
require_once '../user/userDAO.php';
require_once '../posts/annonce.php';
require_once '../posts/annonceDAO.php';
require_once '../posts/demande.php';
require_once '../posts/demandeDAO.php';

$database = new Database();

$userDAO = new UserDAO($database);
$annonceDAO = new AnnonceDAO($database);
$demandeDAO = new DemandeDAO($database);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>FestiCar - Dashboard</title>
    <link rel="icon" href="https://via.placeholder.com/70x70">
    <link rel="stylesheet" href="../mvp.css">

    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include_once('dashboard_header.php') ?>
    <main>
        <h1>FestiCar - Dashboard</h1>
        <hr>
        <section>
            <aside>
                <h3>Utilisateurs inscrits</h3>
                <p><?php 
                    echo $userDAO->getUserCount();
                ?></p>
            </aside>
            <aside>
                <h3>Annonces</h3>
                <p><?php 
                $annonces = $annonceDAO->getAllAnnonces();
                $count = 0;
                foreach($annonces as $annonce) {$count++;}
                    echo $count;
                ?></p>
            </aside>
            <aside>
                <h3>Demandes</h3>
                <p><?php 
                $demandes = $demandeDAO->getAllDemandes();
                $count = 0;
                foreach($demandes as $annonce) {$count++;}
                    echo $count;
                ?></p>
            </aside>
        </section>
    </main>
</body>

</html>