<?php
require_once '../database.php';
require_once '../posts/trajet.php';
require_once '../posts/trajetDAO.php';
require_once '../user/user.php';
require_once '../user/userDAO.php';
require_once '../posts/festival.php';
require_once '../posts/festivalDAO.php';
require_once '../posts/annonce.php';
require_once '../posts/annonceDAO.php';
require_once '../posts/lieu.php';
require_once '../posts/lieuDAO.php';
require_once '../posts/vehicule.php';
require_once '../posts/vehiculeDAO.php';

$database = new Database();

$annonceDAO = new AnnonceDAO($database);
$trajetDAO = new trajetDAO($database);
$userDAO = new UserDAO($database);
$festivalDAO = new festivalDAO($database);
$lieuDAO = new LieuDAO($database);
$vehiculeDAO = new VehiculeDAO($database);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_annonce'])) { // modifier annonce
        $annonceId = $_POST['annonce_id'];
        $driverId = $_POST['driver_id'];
        $trajetId = $_POST['trajet_id'];
        $festivalId = $_POST['festival_id'];
        $publicationDate = $_POST['publication_date'];
        $vehiculeId = $_POST['vehicule_id'];
        $isEnabled = isset($_POST['isEnabled']) ? 1 : 0;

        $annonce = new Annonce($driverId, $trajetId, $festivalId, $publicationDate, $vehiculeId, $isEnabled);
        $annonce->setId($annonceId);

        $annonceDAO->updateAnnonce($annonce);
    }

    if (isset($_POST['submit_add_annonce'])) { // Ajouter annonce
        $driverId = $_POST['new_driver_id'];
        $trajetId = $_POST['new_trajet_id'];
        $festivalId = $_POST['new_festival_id'];
        $publicationDate = $_POST['new_publication_date'];
        $vehiculeId = $_POST['new_vehicule_id'];
        $isEnabled = isset($_POST['new_isEnabled']) ? 1 : 0;

        $annonce = new Annonce($driverId, $trajetId, $festivalId, $publicationDate, $vehiculeId, $isEnabled);
        $annonceDAO->createAnnonce($annonce);
    }

    if (isset($_POST['delete_annonce_id'])) { // Supprimer annonce
        $annonceId = $_POST['annonce_id'];

        $annonce = $annonceDAO->getAnnonceById($annonceId);
        if ($annonce) {
            $annonceDAO->deleteAnnonce($annonce);
        }
    }
}

// Récupération de toutes les annonces
$annonces = $annonceDAO->getAllAnnonces();

$trajets = $trajetDAO->getAllTrajets();

// Récupération de tous les lieux
$lieux = $lieuDAO->getAllLieux();

$users = $userDAO->getAllUsers();
$festivals = $festivalDAO->getAllFestivals();

$vehicules = $vehiculeDAO->getAllVehicules();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Ajouter une annonce</title>
</head>

<body>
    <?php include_once('../header.php'); ?>
    <h2>Ajouter une annonce</h2>
    <form method="post" action="">
        <label for="new_driver_id">Conducteur:</label>
        <select name="new_driver_id" id="new_driver_id">
            <?php foreach ($users as $user) { ?>
                <option value="<?= $user->getId(); ?>"><?= $user->getPrenom(); ?></option>
            <?php } ?>
        </select><br>

        <label for="new_trajet_id">Trajet:</label>
        <select name="new_trajet_id" id="new_trajet_id">
            <?php foreach ($trajets as $trajet) { ?>
                <option value="<?= $trajet->getId(); ?>"><?= $trajet->getLieuDepart() . " -> " . $trajet->getLieuArrivee(); ?></option>
            <?php } ?>
        </select><br>

        <label for="new_festival_id">Festival:</label>
        <select name="new_festival_id" id="new_festival_id">
            <?php foreach ($festivals as $festival) { ?>
                <option value="<?= $festival->getId(); ?>"><?= $festival->getNom(); ?></option>
            <?php } ?>
        </select><br>

        <label for="new_publication_date">Date de publication:</label>
        <input type="date" name="new_publication_date" id="new_publication_date"><br>

        <label for="new_vehicule_id">Véhicule:</label>
        <select name="new_vehicule_id" id="new_vehicule_id">
            <?php foreach ($vehicules as $vehicule) { ?>
                <option value="<?= $vehicule->getId(); ?>"><?= $vehicule->getMarque() . " " . $vehicule->getModele(); ?></option>
            <?php } ?>
        </select><br>

        <label for="new_isEnabled">isEnabled:</label>
        <input type="checkbox" name="new_isEnabled" id="new_isEnabled"><br>

        <input type="submit" name="submit_add_annonce" value="Ajouter">
    </form>
</body>

</html>
