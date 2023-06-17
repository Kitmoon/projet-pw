<?php
require_once '../database.php';
require_once 'userDAO.php';

$database = new Database();
$userDAO = new UserDAO($database);


// On vérifie si on est déjà connecté
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: ../home.php');
    exit();
}

// On vérifie si le formulaire est bien complété
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // On vérifie que les mots de passe correspondent
    if ($password !== $confirmPassword) {
        $errorMessage = 'Les mots de passe ne correspondent pas.';
    } else {
        if (strlen($password) < 8) {
            $errorMessage = 'Le mot de passe doit faire plus de 8 caractères. ';
        } else {
            // Vérification que l'utilisateur n'existe pas déjà avec cette adresse
            $userDAO = new UserDAO($database);
            $existingUser = $userDAO->getUserByEmail($mail);

            if ($existingUser) {
                $errorMessage = 'Cette adresse mail est déjà utilisée. Essayez de <a href="login.php">vous connecter</a>';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $user = new User($nom, $prenom, $mail, $hashedPassword);

                $userDAO->createUser($user);

                header('Location: confirmation.php');
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Inscription</h1>

    <?php if (isset($errorMessage)): ?>
        <p class="error">
            <?php echo $errorMessage; ?>
        </p>
    <?php endif; ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        <div>
            <label for="mail">Adresse mail :</label>
            <input type="email" id="mail" name="mail" required>
        </div>
        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit">S'inscrire</button>
    </form>
</body>

</html>