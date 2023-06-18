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

$database = new Database();

$annonceDAO = new AnnonceDAO($database);
$trajetDAO = new trajetDAO($database);
$userDAO = new UserDAO($database);
$festivalDAO = new festivalDAO($database);
$lieuDAO = new LieuDAO($database);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_annonce'])) { // modifier annonce
        $annonceId = $_POST['annonce_id'];
        $driverId = $_POST['driver_id'];
        $trajetId = $_POST['trajet_id'];
        $festivalId = $_POST['festival_id'];
        $publicationDate = $_POST['publication_date'];
        $voiture = $_POST['voiture'];
        $nbPlaces = $_POST['nb_places'];
        $isEnabled = isset($_POST['isEnabled']) ? 1 : 0;

        $annonce = new Annonce($driverId, $trajetId, $festivalId, $publicationDate, $voiture, $nbPlaces, $isEnabled);
        $annonce->setId($annonceId);

        $annonceDAO->updateAnnonce($annonce);
    }


    if (isset($_POST['submit_add_annonce'])) { // Ajouter annonce
        $driverId = $_POST['new_driver_id'];
        $trajetId = $_POST['new_trajet_id'];
        $festivalId = $_POST['new_festival_id'];
        $publicationDate = $_POST['new_publication_date'];
        $voiture = $_POST['new_voiture'];
        $nbPlaces = $_POST['new_nb_places'];
        $isEnabled = isset($_POST['new_isEnabled']) ? 1 : 0;


        $annonce = new Annonce($driverId, $trajetId, $festivalId, $publicationDate, $voiture, $nbPlaces, $isEnabled);
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
    <?php include_once('dashboard_header.php'); ?>
    <main>
    <h2>Gestion des annonces</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Conducteur</th>
            <th>Trajet</th>
            <th>Festival</th>
            <th>Date de publication</th>
            <th>Voiture</th>
            <th>Nombre de places</th>
            <th>isEnabled</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($annonces as $annonce) { ?>
            <tr>
                <form method="post" action="">
                    <input type="hidden" name="annonce_id" value="<?= $annonce->getId(); ?>">
                    <td>
                        <?= $annonce->getId(); ?>
                    </td>
                    <td>
                        <select name="driver_id">
                            <?php foreach ($users as $user) { ?>
                                <option value="<?= $user->getId(); ?>" <?php if ($user->getId() == $annonce->getDriverId())
                                      echo 'selected'; ?>>
                                    <?= $user->getPrenom(); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="trajet_id">
                            <?php foreach ($trajets as $trajet) { ?>
                                <option value="<?= $trajet->getId(); ?>" <?php if ($trajet->getId() == $annonce->getTrajetId())
                                      echo 'selected'; ?>>
                                    <?= $trajet->getLieuDepart() . " -> " . $trajet->getLieuArrivee(); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="festival_id">
                            <?php foreach ($festivals as $festival) { ?>
                                <option value="<?= $festival->getId(); ?>" <?php if ($festival->getId() == $annonce->getFestivalId())
                                      echo 'selected'; ?>>
                                    <?= $festival->getNom(); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><input type="date" name="publication_date" value="<?= $annonce->getPublicationDate(); ?>"></td>
                    <td><input type="text" name="voiture"value="<?= $annonce->getVoiture(); ?>"></td>
                    <td><input type="number" name="nb_places" value="<?= $annonce->getNbPlaces(); ?>"></td>
                    <td><input type="checkbox" name="isEnabled" <?= $annonce->isEnabled() ? 'checked' : ''; ?>></td>
                    <td>
                        <input type="submit" name="submit_annonce" value="Modifier">
                        <input type="submit" name="delete_annonce_id[]" value="Supprimer">
                    </td>
                </form>
            </tr>
        <?php } ?>
        <tr>
            <form method="post" action="">
                <td></td>
                <td>
                    <select name="new_driver_id">
                        <?php foreach ($users as $user) { ?>
                            <option value="<?= $user->getId(); ?>"><?= $user->getPrenom(); ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <select name="new_trajet_id">
                        <?php foreach ($trajets as $trajet) { ?>
                            <option value="<?= $trajet->getId(); ?>"><?= $trajet->getLieuDepart() . " -> " . $trajet->getLieuArrivee(); ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <select name="new_festival_id">
                        <?php foreach ($festivals as $festival) { ?>
                            <option value="<?= $festival->getId(); ?>"><?= $festival->getNom(); ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><input type="date" name="new_publication_date"></td>
                <td><input type="text" name="new_voiture"></td>
                <td><input type="number" name="new_nb_places"></td>
                <td>
                    <input type="checkbox" name="new_isEnabled">
                </td>
                <td>
                    <input type="submit" name="submit_add_annonce" value="Ajouter">
                </td>
            </form>
        </tr>
    </table>
    </main>
</body>

</html>