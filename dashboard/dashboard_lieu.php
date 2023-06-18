<?php
require_once '../database.php';
require_once '../posts/lieu.php';
require_once '../posts/lieuDAO.php';

$database = new Database();

$lieuDAO = new LieuDAO($database);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gestion des lieux
    if (isset($_POST['submit_lieu'])) { // Modifier lieu
        $lieuId = $_POST['lieu_id'];
        $lieuNom = $_POST['lieu_nom'];
        $lieuAdresse = $_POST['lieu_adresse'];
        $lieuVille = $_POST['lieu_ville'];
        $lieuCodePostal = $_POST['lieu_code_postal'];

        $lieu = new Lieu($lieuNom, $lieuAdresse, $lieuVille, $lieuCodePostal);
        $lieu->setId($lieuId);

        $lieuDAO->updateLieu($lieu);
    }

    if (isset($_POST['submit_add_lieu'])) { // Ajouter lieu
        $lieuNom = $_POST['new_lieu_nom'];
        $lieuAdresse = $_POST['new_lieu_adresse'];
        $lieuVille = $_POST['new_lieu_ville'];
        $lieuCodePostal = $_POST['new_lieu_code_postal'];

        $newLieu = new Lieu($lieuNom, $lieuAdresse, $lieuVille, $lieuCodePostal);

        $lieuDAO->createLieu($newLieu);
    }

    if (isset($_POST['delete_lieu_id'])) { // Supprimer lieu
        $lieuIds = $_POST['delete_lieu_id'];
        foreach ($lieuIds as $lieuId) {
            $lieu = $lieuDAO->getLieuById($lieuId);
            if ($lieu) {
                $lieuDAO->deleteLieu($lieu);
            }
        }
    }
}

$lieux = $lieuDAO->getAllLieux();

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <?php include_once('dashboard_header.php'); ?>
    <main>
        <h2>Lieux</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Ville</th>
                <th>Code Postal</th>
                <th>Action</th>
            </tr>
            <?php foreach ($lieux as $lieu) { ?>
                <tr>
                    <form method="post" action="">
                        <td>
                            <?= $lieu->getId(); ?>
                        </td>
                        <td><input type="text" name="lieu_nom" value="<?= $lieu->getNom(); ?>"></td>
                        <td><input type="text" name="lieu_adresse" value="<?= $lieu->getAdresse(); ?>"></td>
                        <td><input type="text" name="lieu_ville" value="<?= $lieu->getVille(); ?>"></td>
                        <td><input type="text" name="lieu_code_postal" value="<?= $lieu->getCodePostal(); ?>"></td>
                        <td>
                            <input type="hidden" name="lieu_id" value="<?= $lieu->getId(); ?>">
                            <input type="submit" name="submit_lieu" value="Modifier">
                            <button type="submit" name="delete_lieu_id[]" value="<?= $lieu->getId(); ?>">Supprimer</button>
                        </td>
                    </form>
                </tr>
            <?php } ?>

            <tr>
                <form method="post" action="">
                    <td></td>
                    <td><input type="text" name="new_lieu_nom"></td>
                    <td><input type="text" name="new_lieu_adresse"></td>
                    <td><input type="text" name="new_lieu_ville"></td>
                    <td><input type="text" name="new_lieu_code_postal"></td>
                    <td>
                        <input type="submit" name="submit_add_lieu" value="Ajouter">
                    </td>
                </form>
            </tr>
        </table>
    </main>
</body>