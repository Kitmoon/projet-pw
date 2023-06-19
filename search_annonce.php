<?php
session_start();
require_once './database.php';
require_once './posts/trajet.php';
require_once './posts/trajetDAO.php';
require_once './user/user.php';
require_once './user/userDAO.php';
require_once './posts/festival.php';
require_once './posts/festivalDAO.php';
require_once './posts/annonce.php';
require_once './posts/annonceDAO.php';
require_once './posts/lieu.php';
require_once './posts/lieuDAO.php';
require_once './display.php';

$database = new Database();

$annonceDAO = new AnnonceDAO($database);
$trajetDAO = new trajetDAO($database);
$userDAO = new UserDAO($database);
$festivalDAO = new festivalDAO($database);
$lieuDAO = new LieuDAO($database);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['search'])) {
        $lieuAdresse = $_GET['lieuAdresse'];
        $lieuVille = $_GET['lieuVille'];
        $lieuCodePostal = $_GET['lieuCodePostal'];
        $festivalId = $_GET['festivalId'];
        $dateDepart = $_GET['dateDepart'];

        $annonces = $annonceDAO->searchAnnonces($lieuAdresse, $lieuVille, $lieuCodePostal, $festivalId, $dateDepart);
    }
}


// Récupération de toutes les annonces

$trajets = $trajetDAO->getAllTrajets();

// Récupération de tous les lieux
$lieux = $lieuDAO->getAllLieux();

$users = $userDAO->getAllUsers();
$festivals = $festivalDAO->getAllFestivals();
debug_to_console("annonces contient " . count($annonces) . " éléments.");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard des annonces</title>
    <link rel="icon" href="https://via.placeholder.com/70x70">
    <link rel="stylesheet" href="../mvp.css">

    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include_once('header.php'); ?>
    <main>
        <section>
            <section>
                <form method="get">
                    <header>
                        <h2>Recherche d'annonces</h2>
                    </header>
                    <label for="lieuAdresse">Adresse</label>
                    <input type="text" id="lieuAdresse" name="lieuAdresse" size="20" placeholder="Adresse">
                    <input type="text" name="lieuVille" id="lieuVille" size="20" placeholder="Ville">
                    <input type="number" name="lieuCodePostal" id="lieuCodePostal" size="20" placeholder="Code Postal">

                    <label for="festivalId">Festival</label>
                    <select id="festivalId" name="festivalId">
                        <?php foreach ($festivals as $festival) { ?>
                            <option value="<?= $festival->getId(); ?>"><?= $festival->getNom(); ?></option>
                        <?php } ?>
                    </select>

                    <label for="dateDepart">Adresse</label>
                    <input type="date" name="dateDepart">

                    <button type="submit" name="search">Rechercher</button>
                </form>
            </section>
            <hr>
            <?php
            echo displayAnnonces($annonces, 'home');
            ?>
        </section>
    </main>
</body>

</html>