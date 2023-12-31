<?php
require_once './database.php';
require_once 'user/userDAO.php';

$database = new Database();
$userDAO = new UserDAO($database);

// On vérifie si on est déjà connecté
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: ./home.php');
    exit();
}

// Vérification du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if (!$mail || !$password) {
        // Gestion erreurs
        $errorMessage = 'Veuillez remplir tous les champs.';
    } else {
        // On regarde si le mail correspond bien à un compte utilisateur
        $user = $userDAO->getUserByEmail($mail);

        if ($user && password_verify($password, $user->getPassword())) {
            // On a réussi le login !
            session_start();
            $_SESSION['user_id'] = $user->getId();
            header('Location: ./home.php');
            exit();
        } else {
            // Login raté
            $errorMessage = 'Adresse e-mail ou mot de passe incorrect.';
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        .error {
            color: red;
        }
    </style>
    <link rel="icon" href="https://via.placeholder.com/70x70">
    <link rel="stylesheet" href="./mvp.css">

    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include_once('./header.php'); ?>
    <main>
        <h1>Connexion</h1>

        <?php if (isset($errorMessage)): ?>
            <p class="error">
                <?php echo $errorMessage; ?>
            </p>
        <?php endif; ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div>
                <label for="mail">Adresse e-mail:</label>
                <input type="email" id="mail" name="mail" required>
            </div>
            <div>
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
    </main>
</body>

</html>