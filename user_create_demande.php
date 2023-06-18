<?php
Session_start();

if (empty($_SESSION)) {
    echo 'Vous n\'avez pas accès à cette section.';
    echo '<br>';
    echo '<a href="../home.php">Retour à l\'accueil</a>';
    die();
}

require_once './database.php';
require_once './posts/trajet.php';
require_once './posts/trajetDAO.php';
require_once './user/user.php';
require_once './user/userDAO.php';
require_once './posts/festival.php';
require_once './posts/festivalDAO.php';
require_once './posts/demande.php';
require_once './posts/demandeDAO.php';
require_once './posts/lieu.php';
require_once './posts/lieuDAO.php';

$database = new Database();

$demandeDAO = new DemandeDAO($database);
$trajetDAO = new trajetDAO($database);
$userDAO = new UserDAO($database);
$festivalDAO = new festivalDAO($database);
$lieuDAO = new LieuDAO($database);


// Récupération de toutes les demandes
$demandes = $demandeDAO->getAllDemandes();

$trajets = $trajetDAO->getAllTrajets();

// Récupération de tous les lieux
$lieux = $lieuDAO->getAllLieux();

$users = $userDAO->getAllUsers();
$festivals = $festivalDAO->getAllFestivals();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_add_demande'])) { // Ajouter demande
        $authorId = $_POST['new_author_id'];

        // Création d'un lieu à partir des infos
        $lieuNom = $_POST['new_adresse_depart'];
        $lieuAdresse = $_POST['new_adresse_depart'];
        $lieuVille = $_POST['new_ville_depart'];
        $lieuCodePostal = $_POST['new_code_postal_depart'];

        // On récupère le lieu créé
        $newLieu = findLieu($lieux, $lieuDAO, $lieuNom, $lieuAdresse, $lieuVille, $lieuCodePostal);


        $festivalId = $_POST['new_festival_id'];
        // On récupère le lieu d'arrivée (le lieu du festival)
        foreach ($festivals as $festival) {
            if ($festivalId == $festival->getId()) {
                $lieuArriveeId = $festival->getLieuId();
            }
        }




        $dateDepart = date("Y-m-d H:i:s", strtotime($_POST['new_date_depart']));
        $dateRetour = date("Y-m-d H:i:s", strtotime($_POST['new_date_retour']));

        $publicationDate = $_POST['new_publication_date'];



        $demande = new Demande($authorId, $newLieu->getId(), $publicationDate, $festivalId, 1, $dateDepart, $dateRetour);
        $demandeDAO->createDemande($demande);
    }
}

function findLieu($lieux, $lieuDAO, $lieuNom, $lieuAdresse, $lieuVille, $lieuCodePostal)
{
    foreach ($lieux as $lieu) {
        if ($lieu->getAdresse() == $lieuAdresse && $lieu->getCodePostal() == $lieuCodePostal) {
            debug_to_console("Lieu trouvé : " . $lieu->getId());
            return $lieu;
        }
    }
    debug_to_console("Lieu non trouvé : " . $lieuNom);
    $newLieu = new Lieu($lieuNom, $lieuAdresse, $lieuVille, $lieuCodePostal);
    $lieuDAO->createLieu($newLieu);
    
    $lieux = $lieuDAO->getAllLieux();
    foreach ($lieux as $lieu) {
        debug_to_console("Lieu en recherche actuellement : " . $lieu->getNom());
        if ($lieu->getAdresse() == $lieuAdresse && $lieu->getCodePostal() == $lieuCodePostal) {
            debug_to_console("Lieu créé puis trouvé : " . $lieu->getId());
            return $lieu;
        }
    }
}



function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('" . $output . "');</script>";
}




?>

<!DOCTYPE html>
<html>

<head>
    <title>Ajouter une demande</title>
</head>

<body>
    <?php include_once('./header.php'); ?>
    <main>
        <h2>Ajouter une demande</h2>
        <form method="post" action="">
            <input type="hidden" name="new_author_id" value="<?= $_SESSION['user_id']; ?>">

            <label for="new_adresse_depart">Adresse : </label>
            <input type="text" name="new_adresse_depart" id="new_adresse_depart"><br>

            <label for="new_ville_depart">Ville : </label>
            <input type="text" name="new_ville_depart" id="new_ville_depart"><br>

            <label for="new_code_postal_depart">Code postal : </label>
            <input type="text" name="new_code_postal_depart" id="new_code_postal_depart"><br>

            <label for="new_festival_id">Festival : </label>
            <select name="new_festival_id" id="new_festival_id">
                <?php foreach ($festivals as $festival) { ?>
                    <option value="<?= $festival->getId(); ?>"><?= $festival->getNom(); ?></option>
                <?php } ?>
            </select><br>

            <label for="new_date_depart">Date de départ : </label>
            <input type="date" name="new_date_depart" id="new_date_depart"><br>

            <label for="new_date_depart">Date de retour : </label>
            <input type="date" name="new_date_retour" id="new_date_retour"><br>

            <input type="hidden" name="new_publication_date" id="new_publication_date" value="<?= date("Y-m-d") ?>;">

            <input type="submit" name="submit_add_demande" value="Ajouter">
        </form>
    </main>
</body>

</html>