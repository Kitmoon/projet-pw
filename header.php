<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="https://via.placeholder.com/70x70">
    <link rel="stylesheet" href="./mvp.css">

    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <header>
        <nav>
            <a href="./home.php">
                <h1 height="70">FestiCar</h1>
            </a>
            <ul>
                <?php
                if (isset($_SESSION['user_id'])) {
                    require_once 'user/userDAO.php';
                    require_once './database.php';

                    $database = new Database();
                    $userDAO = new UserDAO($database);

                    // On récupère l'user
                    $user = $userDAO->getUserById($_SESSION['user_id']);

                    echo '<li><a href="user/logout.php">Déconnexion</a></li> <li><a href="account.php">Mon Compte</a></li>';
                    echo ('<li><a href="#">Poster</a>
                            <ul>
                                <li><a href="user_create_annonce.php">Annonce</a></li>
                                <li><a href="user_create_demande.php">Demande</a></li>
                            </ul>
                    </li>');
                    // Si c'est un admin, on affiche le lien vers le dashboard
                    if ($user->isAdmin()) {
                        echo ' <li><a href="dashboard/dashboard.php">Dashboard</a></li>';
                    }

                } else {
                    echo '<li><a href="login.php">Connexion</a></li> <li><a href="register.php">Inscription</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>
</body>

</html>