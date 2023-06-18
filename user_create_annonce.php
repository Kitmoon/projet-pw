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
require_once './posts/annonce.php';
require_once './posts/annonceDAO.php';
require_once './posts/lieu.php';
require_once './posts/lieuDAO.php';

$database = new Database();

$annonceDAO = new AnnonceDAO($database);
$trajetDAO = new trajetDAO($database);
$userDAO = new UserDAO($database);
$festivalDAO = new festivalDAO($database);
$lieuDAO = new LieuDAO($database);


// Récupération de toutes les annonces
$annonces = $annonceDAO->getAllAnnonces();

$trajets = $trajetDAO->getAllTrajets();

// Récupération de tous les lieux
$lieux = $lieuDAO->getAllLieux();

$users = $userDAO->getAllUsers();
$festivals = $festivalDAO->getAllFestivals();

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('" . $output . "');</script>";
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_add_annonce'])) { // Ajouter annonce
        $driverId = $_POST['new_driver_id'];

        // Création d'un lieu à partir des infos
        $lieuNom = $_POST['new_adresse_depart'];
        $lieuAdresse = $_POST['new_adresse_depart'];
        $lieuVille = $_POST['new_ville_depart'];
        $lieuCodePostal = $_POST['new_code_postal_depart'];



        // On récupère le lieu créé
        $newLieu = findLieu($lieux, $lieuDAO, $lieuNom, $lieuAdresse, $lieuVille, $lieuCodePostal);

        debug_to_console("newLieu : " . $newLieu->getNom());


        $festivalId = $_POST['new_festival_id'];
        // On récupère le lieu d'arrivée (le lieu du festival)
        foreach ($festivals as $festival) {
            if ($festivalId == $festival->getId()) {
                $lieuArriveeId = $festival->getLieuId();
            }
        }



        $dateDepart = date("Y-m-d H:i:s", strtotime($_POST['new_date_depart']));

        $publicationDate = $_POST['new_publication_date'];
        $voiture = $_POST['new_voiture'];
        $nbPlaces = $_POST['new_nb_places'];


        $prix = $_POST['new_prix'];
        $description = $_POST['new_description'];

        // On cherche le trajet
        $trajetId = findTrajet($trajets, $trajetDAO, $festivalId, $driverId, $dateDepart, $newLieu, $lieuArriveeId, $prix, $description);

        $annonce = new Annonce($driverId, $trajetId, $festivalId, $publicationDate, $voiture, $nbPlaces, 1);
        $annonceDAO->createAnnonce($annonce);
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

function findTrajet($trajets, $trajetDAO, $festivalId, $driverId, $dateDepart, $newLieu, $lieuArriveeId, $prix, $description)
{
    // On vérifie si le trajet existe déjà ou non
    foreach ($trajets as $trajet) {
        debug_to_console("Trajet en recherche : " . $dateDepart);
        if ($trajet->getDriverId() == $driverId && $trajet->getDateDepart() == $dateDepart) {
            debug_to_console("Trajet trouvé : " . $trajet->getId());
            return $trajet->getId();
        }
    }

    // il n'existe pas donc on le crée
    $trajetNew = new Trajet($festivalId, $driverId, $dateDepart, $newLieu->getId(), $lieuArriveeId, $prix, $description);
    $trajetDAO->createTrajet($trajetNew);
    // On récupère la liste mise à jour (j'ai bloqué pendant 3h parce que j'avais pas mis à jour...)
    $trajets = $trajetDAO->getAllTrajets();
    debug_to_console("Trajet non trouvé, le festival : " . $festivalId);
    foreach ($trajets as $trajet) {
        debug_to_console("Trajet recherche : " . $trajet->getId());
        debug_to_console("On a  : " . $trajet->getDateDepart(). " et on cherche : " . $dateDepart);
        if ($trajet->getDriverId() == $driverId && $trajet->getDateDepart() == $dateDepart) {
            debug_to_console("Trajet créé puis trouvé : " . $trajet->getId());
            return $trajet->getId();
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Ajouter une annonce</title>
</head>

<body>
    <?php include_once('./header.php'); ?>
    <main>
        <h2>Ajouter une annonce</h2>
        <form method="post" action="">
            <input type="hidden" name="new_driver_id" value="<?= $_SESSION['user_id']; ?>">

            <label for="new_adresse_depart">Adresse : </label>
            <input type="text" name="new_adresse_depart" id="new_adresse_depart"><br>

            <label for="new_ville_depart">Ville : </label>
            <input type="text" name="new_ville_depart" id="new_ville_depart"><br>

            <label for="new_code_postal_depart">Code postal : </label>
            <input type="number" name="new_code_postal_depart" id="new_code_postal_depart"><br>

            <label for="new_festival_id">Festival : </label>
            <select name="new_festival_id" id="new_festival_id">
                <?php foreach ($festivals as $festival) { ?>
                    <option value="<?= $festival->getId(); ?>"><?= $festival->getNom(); ?></option>
                <?php } ?>
            </select><br>

            <label for="new_date_depart">Date de départ : </label>
            <input type="date" name="new_date_depart" id="new_date_depart" value="<?= date("Y-m-d") ?>;"><br>

            <input type="hidden" name="new_publication_date" id="new_publication_date" value="<?= date("Y-m-d") ?>;">



            <label for="new_voiture">Véhicule : </label>
            <input type="text" name="new_voiture" id="new_voiture"><br>

            <label for="new_nb_places">Nombre de places : </label>
            <input type="number" name="new_nb_places" id="new_nb_places"><br>

            <label for="new_prix">Prix : </label>
            <input type="number" name="new_prix" id="new_prix"><br>
            <input type="hidden" name="new_description" id="new_description">

            <input type="submit" name="submit_add_annonce" value="Ajouter">
        </form>
    </main>
</body>

</html>