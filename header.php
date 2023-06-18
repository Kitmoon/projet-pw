<!DOCTYPE html>
<html>

<body>
    <?php
    if (isset($_SESSION['user_id'])) {
        require_once 'user/userDAO.php';
        require_once './database.php';

        echo '<a href="home.php"><h1>FestiCar</h1></a>';

        $database = new Database();
        $userDAO = new UserDAO($database);

        // On récupère l'user
        $user = $userDAO->getUserById($_SESSION['user_id']);

        echo '<a href="user/logout.php">Déconnexion</a> <a href="user/account.php">Mon Compte</a>';

        // Si c'est un admin, on affiche le lien vers le dashboard
        if ($user->isAdmin()) {
            echo ' <a href="dashboard/dashboard.php">Dashboard</a>';
        }

        echo '<br>';
        echo '<a href="user_interface/user_create_annonce.php">Créer une annonce</a>';
    } else {
        echo '<a href="user/login.php">Connexion</a> <a href="user/register.php">Inscription</a>';
    }
    ?>
</body>

</html>