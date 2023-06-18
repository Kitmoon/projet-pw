<?php
require_once '../database.php';
require_once '../posts/vehiculeDAO.php';
require_once '../posts/vehicule.php';
require_once '../user/userDAO.php';

$database = new Database();

$vehiculeDAO = new VehiculeDAO($database);
$userDAO = new UserDAO($database);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_vehicule'])) { // Modifier véhicule
        $vehiculeId = $_POST['vehicule_id'];
        $driverId = $_POST['driver_id'];
        $marque = $_POST['marque'];
        $modele = $_POST['modele'];
        $couleur = $_POST['couleur'];
        $nbPlaces = $_POST['nb_places'];
        
        $vehicule = new Vehicule($driverId, $marque, $modele, $couleur, $nbPlaces);
        $vehicule->setId($vehiculeId);
    
        $vehiculeDAO->updateVehicule($vehicule);
    }

    if (isset($_POST['submit_add_vehicule'])) { // Ajouter véhicule
        $driverId = $_POST['new_driver_id'];
        $marque = $_POST['new_marque'];
        $modele = $_POST['new_modele'];
        $couleur = $_POST['new_couleur'];
        $nbPlaces = $_POST['new_nb_places'];
        
        $vehicule = new Vehicule($driverId, $marque, $modele, $couleur, $nbPlaces);
        $vehiculeDAO->createVehicule($vehicule);
    }

    if (isset($_POST['delete_vehicule_id'])) { // Supprimer véhicule
        $vehiculeId = $_POST['vehicule_id'];

        $vehicule = $vehiculeDAO->getVehiculeById($vehiculeId);
        if ($vehicule) {
            $vehiculeDAO->deleteVehicule($vehiculeId);
        }
    }
}

// Récupération de tous les véhicules
$vehicules = $vehiculeDAO->getAllVehicules();

// Récupération de tous les conducteurs (utilisateurs)
$users = $userDAO->getAllUsers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard des véhicules</title>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <?php include_once('dashboard_header.php'); ?>
    <h2>Gestion des véhicules</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Conducteur</th>
            <th>Marque</th>
            <th>Modèle</th>
            <th>Couleur</th>
            <th>Nombre de places</th>
            <!-- Ajoutez ici la colonne pour afficher l'image du véhicule, si nécessaire -->
            <th>Actions</th>
        </tr>
        <?php foreach ($vehicules as $vehicule) { ?>
            <tr>
                <form method="post" action="">
                    <input type="hidden" name="vehicule_id" value="<?= $vehicule->getId(); ?>">
                    <td><?= $vehicule->getId(); ?></td>
                    <td>
                        <select name="driver_id">
                            <?php foreach ($users as $user) { ?>
                                <option value="<?= $user->getId(); ?>" <?php if ($user->getId() == $vehicule->getDriverId())
                                      echo 'selected'; ?>>
                                    <?= $user->getPrenom(); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><input type="text" name="marque" value="<?= $vehicule->getMarque(); ?>"></td>
                    <td><input type="text" name="modele" value="<?= $vehicule->getModele(); ?>"></td>
                    <td><input type="text" name="couleur" value="<?= $vehicule->getCouleur(); ?>"></td>
                    <td><input type="number" name="nb_places" value="<?= $vehicule->getNbPlaces(); ?>"></td>
                    <!-- Ajoutez ici le code HTML pour afficher l'image du véhicule, si nécessaire -->
                    <td>
                        <input type="submit" name="submit_vehicule" value="Modifier">
                        <input type="submit" name="delete_vehicule_id[]" value="Supprimer">
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
                <td><input type="text" name="new_marque"></td>
                <td><input type="text" name="new_modele"></td>
                <td><input type="text" name="new_couleur"></td>
                <td><input type="number" name="new_nb_places"></td>
                <!-- Ajoutez ici le code HTML pour ajouter l'upload d'une image du véhicule, si nécessaire -->
                <td><input type="submit" name="submit_add_vehicule" value="Ajouter"></td>
            </form>
        </tr>
    </table>
</body>
</html>
