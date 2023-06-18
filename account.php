<?php
session_start();

// verif connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once './database.php';
require_once 'user/userDAO.php';

$database = new Database();
$userDAO = new UserDAO($database);

// On récupère les données de l'user
$user = $userDAO->getUserById($_SESSION['user_id']);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['mail'];
    $password = $_POST['password'];

    $user->setNom($nom);
    $user->setPrenom($prenom);
    $user->setMail($mail);

    if (!empty($password) && strlen($password) >= 8) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);
        $userDAO->updateUser($user);
        header('Location: ./home.php');
        exit();
    } else {
        $error = "Le mot de passe doit contenir au moins 8 caractères";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>FestiCar - Mon Compte</title>
</head>
<body>
    <?php include_once('./header.php'); ?>
    <h1>Mon Compte</h1>
    <?php if (!empty($error)) : ?>
    <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="account.php">
        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user->getNom()); ?>">
        </div>
        <div>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user->getPrenom()); ?>">
        </div>
        <div>
            <label for="mail">mail :</label>
            <input type="mail" id="mail" name="mail" value="<?php echo htmlspecialchars($user->getMail()); ?>">
        </div>
        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <button type="submit">Enregistrer</button>
        </div>
    </form>
</body>
</html>