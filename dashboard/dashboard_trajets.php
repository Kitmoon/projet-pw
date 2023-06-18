<?php
require_once '../database.php';
require_once '../posts/trajet.php';
require_once '../posts/trajetDAO.php';
require_once '../posts/lieu.php';
require_once '../posts/lieuDAO.php';
require_once '../user/user.php';
require_once '../user/userDAO.php';
require_once '../posts/festival.php';
require_once '../posts/festivalDAO.php';

$database = new Database();
$trajetDAO = new trajetDAO($database);
$lieuDAO = new LieuDAO($database);
$userDAO = new UserDAO($database);
$festivalDAO = new festivalDAO($database);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_trajet'])) { // modifier trajet
        $trajetId = $_POST['trajet_id'];
        $festivalId = $_POST['festival_id'];
        $driverId = $_POST['driver_id'];
        $dateDepart = $_POST['date_depart'];
        $lieuDepartId = $_POST['lieu_depart'];
        $lieuArriveeId = $_POST['lieu_arrivee'];
        $prix = $_POST['prix'];
        $description = $_POST['description'];
    
        $trajet = new Trajet($festivalId, $driverId, $dateDepart, $lieuDepartId, $lieuArriveeId, $prix, $description);
        $trajet->setId($trajetId);
    
        $trajetDAO->updateTrajet($trajet);
    }
    

    if (isset($_POST['submit_add_trajet'])) { // Ajouter trajet
        $festivalId = $_POST['new_festival_id'];
        $driverId = $_POST['new_driver_id'];
        $dateDepart = $_POST['new_date_depart'];
        $lieuDepartId = $_POST['new_lieu_depart'];
        $lieuArriveeId = $_POST['new_lieu_arrivee'];
        $prix = $_POST['new_prix'];
        $description = $_POST['new_description'];

        $trajet = new Trajet($festivalId, $driverId, $dateDepart, $lieuDepartId, $lieuArriveeId, $prix, $description);
        $trajetDAO->createTrajet($trajet);
    }

    if (isset($_POST['delete_trajet_id'])) { // Supprimer trajet
        $trajetId = $_POST['trajet_id'];

        $trajet = $trajetDAO->getTrajetById($trajetId);
        if ($trajet) {
            $trajetDAO->deleteTrajet($trajet);
        }
    }
}

// Récupération de tous les trajets
$trajets = $trajetDAO->getAllTrajets();

// Récupération de tous les lieux
$lieux = $lieuDAO->getAllLieux();

$users = $userDAO->getAllUsers();
$festivals = $festivalDAO->getAllFestivals();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard des trajets</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <?php include_once('dashboard_header.php'); ?>
    <h2>Gestion des trajets</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Festival</th>
            <th>Conducteur</th>
            <th>Date de départ</th>
            <th>Lieu de départ</th>
            <th>Lieu d'arrivée</th>
            <th>Prix</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($trajets as $trajet) { ?>
            <tr>
                <form method="post" action="">
                    <input type="hidden" name="trajet_id" value="<?= $trajet->getId(); ?>">
                    <td>
                        <?= $trajet->getId(); ?>
                    </td>
                    <td>
                        <select name="festival_id">
                            <?php foreach ($festivals as $festival) { ?>
                                <option value="<?= $festival->getId(); ?>" <?php if ($festival->getId() == $trajet->getFestivalId())
                                      echo 'selected'; ?>>
                                    <?= $festival->getNom(); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="driver_id">
                            <?php foreach ($users as $user) { ?>
                                <option value="<?= $user->getId(); ?>" <?php if ($user->getId() == $trajet->getDriverId())
                                      echo 'selected'; ?>>
                                    <?= $user->getPrenom(); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><input type="datetime" name="date_depart" value="<?= $trajet->getDateDepart(); ?>"></td>
                    <td>
                        <select name="lieu_depart">
                            <?php foreach ($lieux as $lieu) { ?>
                                <option value="<?= $lieu->getId(); ?>" <?php if ($lieu->getId() == $trajet->getLieuDepart())
                                      echo 'selected'; ?>>
                                    <?= $lieu->getNom(); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="lieu_arrivee">
                            <?php foreach ($lieux as $lieu) { ?>
                                <option value="<?= $lieu->getId(); ?>" <?php if ($lieu->getId() == $trajet->getLieuArrivee())
                                      echo 'selected'; ?>>
                                    <?= $lieu->getNom(); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><input type="text" name="prix" value="<?= $trajet->getPrix(); ?>"></td>
                    <td><textarea name="description"><?= $trajet->getDescription(); ?></textarea></td>
                    <td>
                        <input type="submit" name="submit_trajet" value="Modifier">
                        <input type="submit" name="delete_trajet_id[]" value="Supprimer">
                    </td>
                </form>
            </tr>
        <?php } ?>
        <tr>
            <form method="post" action="">
                <td></td>
                <td>
                    <select name="new_festival_id">
                        <?php foreach ($festivals as $festival) { ?>
                            <option value="<?= $festival->getId(); ?>"><?= $festival->getNom(); ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <select name="new_driver_id">
                        <?php foreach ($users as $user) { ?>
                            <option value="<?= $user->getId(); ?>"><?= $user->getPrenom(); ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><input type="datetime" name="new_date_depart"></td>
                <td>
                    <select name="new_lieu_depart">
                        <?php foreach ($lieux as $lieu) { ?>
                            <option value="<?= $lieu->getId(); ?>"><?= $lieu->getNom(); ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <select name="new_lieu_arrivee">
                        <?php foreach ($lieux as $lieu) { ?>
                            <option value="<?= $lieu->getId(); ?>"><?= $lieu->getNom(); ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><input type="text" name="new_prix"></td>
                <td><textarea name="new_description"></textarea></td>
                <td>
                    <input type="submit" name="submit_add_trajet" value="Ajouter">
                </td>
            </form>
        </tr>
    </table>
</body>

</html>