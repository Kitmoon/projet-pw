<?php
require_once './database.php';
require_once './user/user.php';
require_once './user/userDAO.php';
require_once './posts/annonce.php';
require_once './posts/annonceDAO.php';
require_once './posts/demande.php';
require_once './posts/demandeDAO.php';
require_once './posts/festival.php';
require_once './posts/festivalDAO.php';
require_once './posts/lieu.php';
require_once './posts/lieuDAO.php';
require_once './posts/trajet.php';
require_once './posts/trajetDAO.php';

$database = new Database();

$userDAO = new UserDAO($database);
$annonceDAO = new AnnonceDAO($database);
$demandeDAO = new DemandeDAO($database);
$festivalDAO = new festivalDAO($database);
$lieuDAO = new LieuDAO($database);
$trajetDAO = new trajetDAO($database);


$users = $userDAO->getAllUsers();
$annonces = $annonceDAO->getAllAnnonces();
$demandes = $demandeDAO->getAllDemandes();
$festivals = $festivalDAO->getAllFestivals();
$lieux = $lieuDAO->getAllLieux();
$trajets = $trajetDAO->getAllTrajets();

function displayAnnonces(array $annonces, string $style)
{
    $output = '';
    if ($style == 'full') {
        foreach ($annonces as $annonce) {
            $output = $output . displayAnnonceFull($annonce) . '<br>';
        }
    } else {
        foreach ($annonces as $annonce) {
            $output = $output . displayAnnonceHome($annonce) . '<br>';
        }
    }

    return $output;
}

function displayAnnonceHome(Annonce $annonce)
{
    global $users;
    global $festivals;
    global $trajets;

    $output = "<table>";
    foreach ($users as $user) {
        if ($user->getId() == $annonce->getDriverId()) {
            $output = $output . '<tr><td>' . $user->getPrenom() . " " . $user->getNom() . "</td></tr>";
        }
    }

    foreach ($festivals as $festival) {
        if ($festival->getId() == $annonce->getFestivalId()) {
            $output = $output . '<tr><td>' . displayFestival($festival) . "</td></tr>";
        }
    }

    foreach ($trajets as $trajet) {
        if ($trajet->getId() == $annonce->getTrajetId()) {
            $output = $output . '<tr><td>' . displayTrajet($trajet) . "</td></tr>";
        }
    }

    return $output."</table>";
}


function displayAnnonceFull(Annonce $annonce)
{
    global $users;
    global $festivals;
    global $trajets;

    $output = "<table>";
    foreach ($users as $user) {
        if ($user->getId() == $annonce->getDriverId()) {
            $output = $output . '<tr><td>' . $user->getPrenom() . " " . $user->getNom() . "</td></tr>";
        }
    }

    foreach ($festivals as $festival) {
        if ($festival->getId() == $annonce->getFestivalId()) {
            $output = $output . '<tr><td>' . displayFestival($festival) . "</td></tr>";
        }
    }

    foreach ($trajets as $trajet) {
        if ($trajet->getId() == $annonce->getTrajetId()) {
            $output = $output . '<tr><td>' . displayTrajet($trajet) . "</td></tr>";
        }
    }

    return $output."</table>";
}


function displayTrajet(Trajet $trajet)
{
    global $lieux;

    $output = '';

    foreach ($lieux as $lieu) {
        if ($lieu->getId() == $trajet->getLieuDepart()) {
            debug_to_console("Lieu départ trouvé : " . $lieu->getId());
            $output = $output . displayLieu($lieu);
        }
    }
    $output = $output . " -> ";
    foreach ($lieux as $lieu) {
        if ($lieu->getId() == $trajet->getLieuArrivee()) {
            debug_to_console("Lieu arrivée trouvé : " . $lieu->getId());
            $output = $output . displayLieu($lieu);
        }
    }
    return $output;
}

function displayLieu(Lieu $lieu)
{
    $output = "";
    $output = $lieu->getAdresse();
    return $output;
}

function displayFestival(Festival $festival)
{
    $output = "";
    $output = $festival->getNom();
    return $output;
}








function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('" . $output . "');</script>";
}
