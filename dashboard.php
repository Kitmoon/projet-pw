<?php
require_once 'database.php';
require_once 'user/user.php';
require_once 'user/userDAO.php';
require_once 'posts/lieu.php';
require_once 'posts/lieuDAO.php';
require_once 'posts/festival.php';
require_once 'posts/festivalDAO.php';

$database = new Database();

$userDAO = new UserDAO($database);
$lieuDAO = new LieuDAO($database);
$festivalDAO = new FestivalDAO($database);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gestion des utilisateurs
    if (isset($_POST['submit_user'])) {
        // Récupération des données
        $userId = $_POST['user_id'];
        $userNom = $_POST['user_nom'];
        $userPrenom = $_POST['user_prenom'];
        $userMail = $_POST['user_mail'];
        $userPassword = password_hash($_POST['new_user_password'], PASSWORD_DEFAULT);
        $userAdmin = isset($_POST['user_admin']) ? 1 : 0;

        $user = new User($userPrenom, $userNom, $userMail, $userPassword, $userAdmin);
        $user->setId($userId);

        $userDAO->updateUser($user);
    }

    if (isset($_POST['submit_add_user'])) {
        // Récupération des données pour l'ajout d'utilisateur
        $userNom = $_POST['new_user_nom'];
        $userPrenom = $_POST['new_user_prenom'];
        $userMail = $_POST['new_user_mail'];
        $userPassword = password_hash($_POST['new_user_password'], PASSWORD_DEFAULT);
        $userAdmin = isset($_POST['new_user_admin']) ? 1 : 0;

        $newUser = new User($userPrenom, $userNom, $userMail, $userPassword, $userAdmin);

        $userDAO->createUser($newUser);
    }

    if (isset($_POST['delete_user_id'])) {
        $userId = $_POST['delete_user_id'];
        // Suppression de l'utilisateur
        $user = $userDAO->getUserById($userId);
        if ($user) {
            $userDAO->deleteUser($user);
        }
    }

    // Gestion des lieux
    if (isset($_POST['submit_lieu'])) {
        // Récupération des données
        $lieuId = $_POST['lieu_id'];
        $lieuNom = $_POST['lieu_nom'];
        $lieuAdresse = $_POST['lieu_adresse'];
        $lieuVille = $_POST['lieu_ville'];
        $lieuCodePostal = $_POST['lieu_code_postal'];

        $lieu = new Lieu($lieuNom, $lieuAdresse, $lieuVille, $lieuCodePostal);
        $lieu->setId($lieuId);

        $lieuDAO->updateLieu($lieu);
    }

    if (isset($_POST['submit_add_lieu'])) {
        // Récupération des données pour l'ajout de lieu
        $lieuNom = $_POST['new_lieu_nom'];
        $lieuAdresse = $_POST['new_lieu_adresse'];
        $lieuVille = $_POST['new_lieu_ville'];
        $lieuCodePostal = $_POST['new_lieu_code_postal'];

        $newLieu = new Lieu($lieuNom, $lieuAdresse, $lieuVille, $lieuCodePostal);

        $lieuDAO->createLieu($newLieu);
    }

    if (isset($_POST['delete_lieu_id'])) {
        $lieuIds = $_POST['delete_lieu_id'];
        // Suppression des lieux
        foreach ($lieuIds as $lieuId) {
            $lieu = $lieuDAO->getLieuById($lieuId);
            if ($lieu) {
                $lieuDAO->deleteLieu($lieu);
            }
        }
    }

    // Gestion des festivals
    if (isset($_POST['submit_festival'])) {
        // Récupération des données
        $festivalId = $_POST['festival_id'];
        $festivalNom = $_POST['festival_nom'];
        $festivalLieuId = $_POST['festival_lieu_id'];
        $festivalDateDebut = $_POST['festival_date_debut'];
        $festivalDateFin = $_POST['festival_date_fin'];

        $festival = new Festival($festivalNom, $festivalLieuId, $festivalDateDebut, $festivalDateFin);
        $festival->setId($festivalId);

        $festivalDAO->updateFestival($festival);
    }

    if (isset($_POST['submit_add_festival'])) {
        // Récupération des données pour l'ajout de festival
        $festivalNom = $_POST['new_festival_nom'];
        $festivalLieuId = $_POST['new_festival_lieu_id'];
        $festivalDateDebut = $_POST['new_festival_date_debut'];
        $festivalDateFin = $_POST['new_festival_date_fin'];

        $newFestival = new Festival($festivalNom, $festivalLieuId, $festivalDateDebut, $festivalDateFin);

        $festivalDAO->createFestival($newFestival);
    }

    if (isset($_POST['delete_festival_id'])) {
        $festivalIds = $_POST['delete_festival_id'];
        // Suppression des festivals
        foreach ($festivalIds as $festivalId) {
            $festival = $festivalDAO->getFestivalById($festivalId);
            if ($festival) {
                $festivalDAO->deleteFestival($festival);
            }
        }
    }
}

// Récupération de tous les utilisateurs
$users = $userDAO->getAllUsers();

// Récupération de tous les lieux
$lieux = $lieuDAO->getAllLieux();

// Récupération de tous les festivals
$festivals = $festivalDAO->getAllFestivals();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>FestiCar - Dashboard</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <h1>FestiCar - Dashboard</h1>
    <a href="./home.php">Accueil</a>

    <h2>Utilisateurs</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Mot de passe</th>
            <th>Admin</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user) { ?>
            <tr>
                <form method="post" action="">
                    <td><?= $user->getId(); ?></td>
                    <td><input type="text" name="user_nom" value="<?= $user->getNom(); ?>"></td>
                    <td><input type="text" name="user_prenom" value="<?= $user->getPrenom(); ?>"></td>
                    <td><input type="text" name="user_mail" value="<?= $user->getMail(); ?>"></td>
                    <td><input type="password" name="user_password" value="<?= $user->getPassword(); ?>"></td>
                    <td><input type="checkbox" name="user_admin" <?= $user->isAdmin() ? 'checked' : ''; ?>></td>
                    <td>
                        <input type="hidden" name="user_id" value="<?= $user->getId(); ?>">
                        <input type="submit" name="submit_user" value="Modifier">
                        <button type="submit" name="delete_user_id" value="<?= $user->getId(); ?>">Supprimer</button>
                    </td>
                </form>
            </tr>
        <?php } ?>

        <tr>
            <form method="post" action="">
                <td></td>
                <td><input type="text" name="new_user_nom"></td>
                <td><input type="text" name="new_user_prenom"></td>
                <td><input type="text" name="new_user_mail"></td>
                <td><input type="password" name="new_user_password"></td>
                <td><input type="checkbox" name="new_user_admin"></td>
                <td>
                    <input type="submit" name="submit_add_user" value="Ajouter">
                </td>
            </form>
        </tr>
    </table>

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
                    <td><?= $lieu->getId(); ?></td>
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
                    <td><?= $festival->getId(); ?></td>
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
                    <td><input type="text" name="festival_date_debut" value="<?= $festival->getDateDebut(); ?>"></td>
                    <td><input type="text" name="festival_date_fin" value="<?= $festival->getDateFin(); ?>"></td>
                    <td>
                        <input type="hidden" name="festival_id" value="<?= $festival->getId(); ?>">
                        <input type="submit" name="submit_festival" value="Modifier">
                        <button type="submit" name="delete_festival_id[]" value="<?= $festival->getId(); ?>">Supprimer</button>
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
                <td><input type="text" name="new_festival_date_debut"></td>
                <td><input type="text" name="new_festival_date_fin"></td>
                <td>
                    <input type="submit" name="submit_add_festival" value="Ajouter">
                </td>
            </form>
        </tr>
    </table>
</body>

</html>
