<?php
require_once '../user/user.php';
require_once '../user/userDAO.php';

$database = new Database();

$userDAO = new UserDAO($database);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gestion des utilisateurs
    if (isset($_POST['submit_user'])) { // Modifier user
        $userId = $_POST['user_id'];
        $userNom = $_POST['user_nom'];
        $userPrenom = $_POST['user_prenom'];
        $userMail = $_POST['user_mail'];
        $userPassword = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
        $userAdmin = isset($_POST['user_admin']) ? 1 : 0;

        $user = new User($userPrenom, $userNom, $userMail, $userPassword, $userAdmin);
        $user->setId($userId);

        $userDAO->updateUser($user);
    }

    if (isset($_POST['submit_add_user'])) { // Ajouter user
        $userNom = $_POST['new_user_nom'];
        $userPrenom = $_POST['new_user_prenom'];
        $userMail = $_POST['new_user_mail'];
        $userPassword = password_hash($_POST['new_user_password'], PASSWORD_DEFAULT);
        $userAdmin = isset($_POST['new_user_admin']) ? 1 : 0;

        $newUser = new User($userPrenom, $userNom, $userMail, $userPassword, $userAdmin);

        $userDAO->createUser($newUser);
    }

    if (isset($_POST['delete_user_id'])) { // Supprimer user
        $userId = $_POST['delete_user_id'];
        $user = $userDAO->getUserById($userId);
        if ($user) {
            $userDAO->deleteUser($user);
        }
    }
}

// Récupération de tous les utilisateurs
$users = $userDAO->getAllUsers();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <?php include_once('dashboard_header.php'); ?>
    <main>
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
    </main>
</body>

</html>