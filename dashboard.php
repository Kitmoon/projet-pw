<?php
require_once 'database.php';
require_once 'user/user.php';
require_once 'user/userDAO.php';
require_once 'posts/lieu.php';
require_once 'posts/lieuDAO.php';

$database = new Database();

$userDAO = new UserDAO($database);
$lieuDAO = new LieuDAO($database);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_user'])) {
        // On récupère les donnnées
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

    if (isset($_POST['submit_lieu'])) {
        // Oon récupère pour le lieu
        $lieuId = $_POST['lieu_id'];
        $lieuNom = $_POST['lieu_nom'];
        $lieuAdresse = $_POST['lieu_adresse'];
        $lieuVille = $_POST['lieu_ville'];
        $lieuCodePostal = $_POST['lieu_code_postal'];

        $lieu = new Lieu($lieuNom, $lieuAdresse, $lieuVille, $lieuCodePostal);
        $lieu->setId($lieuId);

        $lieuDAO->updateLieu($lieu);
    }

    if (isset($_POST['submit_add_user'])) {
        // On récupèer pour l'ajout
        $userNom = $_POST['new_user_nom'];
        $userPrenom = $_POST['new_user_prenom'];
        $userMail = $_POST['new_user_mail'];
        $userPassword = password_hash($_POST['new_user_password'], PASSWORD_DEFAULT);
        $userAdmin = isset($_POST['new_user_admin']) ? 1 : 0;

        $newUser = new User($userPrenom, $userNom, $userMail, $userPassword, $userAdmin);

        $userDAO->createUser($newUser);
    }

    if (isset($_POST['submit_add_lieu'])) {
        // On récupère pour l'ajout de lieu
        $lieuNom = $_POST['new_lieu_nom'];
        $lieuAdresse = $_POST['new_lieu_adresse'];
        $lieuVille = $_POST['new_lieu_ville'];
        $lieuCodePostal = $_POST['new_lieu_code_postal'];

        $newLieu = new Lieu($lieuNom, $lieuAdresse, $lieuVille, $lieuCodePostal);

        $lieuDAO->createLieu($newLieu);
    }

    if (isset($_POST['delete_user_id'])) {
        $userId = $_POST['delete_user_id'];
        // On récupère la suppression
        $user = $userDAO->getUserById($userId);
        if ($user) {
            $userDAO->deleteUser($user);
        }
    }

    if (isset($_POST['delete_lieu_id'])) {
        $lieuIds = $_POST['delete_lieu_id'];
        foreach ($lieuIds as $lieuId) {
            $lieu = $lieuDAO->getLieuById($lieuId);
            if ($lieu) {
                $lieuDAO->deleteLieu($lieu);
            }
        }
    }

}

// Récupération de tous les users
$users = $userDAO->getAllUsers();

// Récup de tous les lieux
$lieux = $lieuDAO->getAllLieux();
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

    <h2>Gestion des utilisateurs</h2>
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
                    <td>
                        <?= $user->getId(); ?>
                    </td>
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
</body>

</html>