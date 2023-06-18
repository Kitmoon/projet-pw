<?php
require_once '../database.php';
require_once '../posts/festival.php';
require_once '../posts/festivalDAO.php';
require_once '../posts/lieu.php';
require_once '../posts/lieuDAO.php';

$database = new Database();

$festivalDAO = new FestivalDAO($database);
$lieuDAO = new LieuDAO($database);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gestion des festivals
    if (isset($_POST['submit_festival'])) { // modifier festival
        $festivalId = $_POST['festival_id'];
        $festivalNom = $_POST['festival_nom'];
        $festivalLieuId = $_POST['festival_lieu_id'];
        $festivalDateDebut = $_POST['festival_date_debut'];
        $festivalDateFin = $_POST['festival_date_fin'];

        $festival = new Festival($festivalNom, $festivalLieuId, $festivalDateDebut, $festivalDateFin);
        $festival->setId($festivalId);

        $festivalDAO->updateFestival($festival);
    }

    if (isset($_POST['submit_add_festival'])) { // Ajouter festival
        $festivalNom = $_POST['new_festival_nom'];
        $festivalLieuId = $_POST['new_festival_lieu_id'];
        $festivalDateDebut = $_POST['new_festival_date_debut'];
        $festivalDateFin = $_POST['new_festival_date_fin'];

        $newFestival = new Festival($festivalNom, $festivalLieuId, $festivalDateDebut, $festivalDateFin);

        $festivalDAO->createFestival($newFestival);
    }

    if (isset($_POST['delete_festival_id'])) { // supprimer festival
        $festivalIds = $_POST['delete_festival_id'];
        foreach ($festivalIds as $festivalId) {
            $festival = $festivalDAO->getFestivalById($festivalId);
            if ($festival) {
                $festivalDAO->deleteFestival($festival);
            }
        }
    }
}

// Récupération de tous les festivals
$festivals = $festivalDAO->getAllFestivals();
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
        <h2>Festivals</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Lieu</th>
                <th>Date Début</th>
                <th>Date Fin</th>
                <th>Action</th>
            </tr>
            <?php foreach ($festivals as $festival) { ?>
                <tr>
                    <form method="post" action="">
                        <td>
                            <?= $festival->getId(); ?>
                        </td>
                        <td><input type="text" name="festival_nom" value="<?= $festival->getNom(); ?>"></td>
                        <td>
                            <select name="festival_lieu_id">
                                <?php foreach ($lieux as $lieu) { ?>
                                    <option value="<?= $lieu->getId(); ?>" <?= $lieu->getId() == $festival->getLieuId() ? 'selected' : ''; ?>>
                                        <?= $lieu->getNom(); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input type="date" name="festival_date_debut" value="<?= $festival->getDateDebut(); ?>"></td>
                        <td><input type="date" name="festival_date_fin" value="<?= $festival->getDateFin(); ?>"></td>
                        <td>
                            <input type="hidden" name="festival_id" value="<?= $festival->getId(); ?>">
                            <input type="submit" name="submit_festival" value="Modifier">
                            <button type="submit" name="delete_festival_id[]"
                                value="<?= $festival->getId(); ?>">Supprimer</button>
                        </td>
                    </form>
                </tr>
            <?php } ?>

            <tr>
                <form method="post" action="">
                    <td></td>
                    <td><input type="text" name="new_festival_nom"></td>
                    <td>
                        <select name="new_festival_lieu_id">
                            <?php foreach ($lieux as $lieu) { ?>
                                <option value="<?= $lieu->getId(); ?>"><?= $lieu->getNom(); ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><input type="date" name="new_festival_date_debut"></td>
                    <td><input type="date" name="new_festival_date_fin"></td>
                    <td>
                        <input type="submit" name="submit_add_festival" value="Ajouter">
                    </td>
                </form>
            </tr>
        </table>
    </main>
</body>

</html>