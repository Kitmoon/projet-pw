<?php
require_once '../database.php';
require_once '../posts/lieu.php';
require_once '../posts/lieuDAO.php';
require_once '../user/user.php';
require_once '../user/userDAO.php';
require_once '../posts/festival.php';
require_once '../posts/festivalDAO.php';
require_once '../posts/demande.php';
require_once '../posts/demandeDAO.php';
require_once '../posts/lieu.php';
require_once '../posts/lieuDAO.php';

$database = new Database();

$demandeDAO = new DemandeDAO($database);
$lieuDAO = new lieuDAO($database);
$userDAO = new UserDAO($database);
$festivalDAO = new festivalDAO($database);
$lieuDAO = new LieuDAO($database);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_demande'])) { // modifier demande
        $demandeId = $_POST['demande_id'];
        $authorId = $_POST['author_id'];
        $lieuId = $_POST['lieu_id'];
        $publicationDate = $_POST['publication_date'];
        $festivalId = $_POST['festival_id'];
        $isEnabled = isset($_POST['isEnabled']) ? 1 : 0;

        $demande = new Demande($authorId, $lieuId, $publicationDate, $festivalId, $isEnabled);
        $demande->setId($demandeId);

        $demandeDAO->updateDemande($demande);
    }


    if (isset($_POST['submit_add_demande'])) { // Ajouter demande
        $authorId = $_POST['new_author_id'];
        $lieuId = $_POST['new_lieu_id'];
        $publicationDate = $_POST['new_publication_date'];
        $festivalId = $_POST['new_festival_id'];
        $isEnabled = isset($_POST['new_isEnabled']) ? 1 : 0;


        $demande = new Demande($authorId, $lieuId, $publicationDate, $festivalId, $isEnabled);
        $demandeDAO->createDemande($demande);
    }

    if (isset($_POST['delete_demande_id'])) { // Supprimer demande
        $demandeId = $_POST['demande_id'];

        $demande = $demandeDAO->getDemandeById($demandeId);
        if ($demande) {
            $demandeDAO->deleteDemande($demande);
        }
    }
}

// Récupération de toutes les demandes
$demandes = $demandeDAO->getAllDemandes();

$lieux = $lieuDAO->getAllLieux();

// Récupération de tous les lieux
$lieux = $lieuDAO->getAllLieux();

$users = $userDAO->getAllUsers();
$festivals = $festivalDAO->getAllFestivals();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard des demandes</title>
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
    <h2>Gestion des demandes</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Auteur</th>
            <th>Lieu</th>
            <th>Festival</th>
            <th>Date de publication</th>
            <th>isEnabled</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($demandes as $demande) { ?>
            <tr>
                <form method="post" action="">
                    <input type="hidden" name="demande_id" value="<?= $demande->getId(); ?>">
                    <td>
                        <?= $demande->getId(); ?>
                    </td>
                    <td>
                        <select name="author_id">
                            <?php foreach ($users as $user) { ?>
                                <option value="<?= $user->getId(); ?>" <?php if ($user->getId() == $demande->getAuthorId())
                                      echo 'selected'; ?>>
                                    <?= $user->getPrenom(); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="lieu_id">
                            <?php foreach ($lieux as $lieu) { ?>
                                <option value="<?= $lieu->getId(); ?>" <?php if ($lieu->getId() == $demande->getLieuId())
                                      echo 'selected'; ?>>
                                    <?= $lieu->getAdresse(); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="festival_id">
                            <?php foreach ($festivals as $festival) { ?>
                                <option value="<?= $festival->getId(); ?>" <?php if ($festival->getId() == $demande->getFestivalId())
                                      echo 'selected'; ?>>
                                    <?= $festival->getNom(); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><input type="date" name="publication_date" value="<?= $demande->getPublicationDate(); ?>"></td>
                    <td><input type="checkbox" name="isEnabled" <?= $demande->isEnabled() ? 'checked' : ''; ?>></td>
                    <td>
                        <input type="submit" name="submit_demande" value="Modifier">
                        <input type="submit" name="delete_demande_id[]" value="Supprimer">
                    </td>
                </form>
            </tr>
        <?php } ?>
        <tr>
            <form method="post" action="">
                <td></td>
                <td>
                    <select name="new_author_id">
                        <?php foreach ($users as $user) { ?>
                            <option value="<?= $user->getId(); ?>"><?= $user->getPrenom(); ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <select name="new_lieu_id">
                        <?php foreach ($lieux as $lieu) { ?>
                            <option value="<?= $lieu->getId(); ?>"><?= $lieu->getAdresse(); ?></option>
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
                <td>
                    <input type="checkbox" name="new_isEnabled">
                </td>
                <td>
                    <input type="submit" name="submit_add_demande" value="Ajouter">
                </td>
            </form>
        </tr>
    </table>
</body>

</html>