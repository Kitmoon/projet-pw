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
            $output = $output . displayAnnonceHome($annonce) . '<br>';
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

    $output = "<aside>";
          
    foreach ($festivals as $festival) {
        if ($festival->getId() == $annonce->getFestivalId()) {
            $output = $output . '<h3>' . displayFestival($festival) . "</h3>";
        }
    }

    foreach ($users as $user) {
        if ($user->getId() == $annonce->getDriverId()) {
            $output = $output . '<p>' . $user->getPrenom() . " " . $user->getNom() . "</p>";
        }
    }

    foreach ($trajets as $trajet) {
        if ($trajet->getId() == $annonce->getTrajetId()) {
            $output = $output . '<p><small>' . displayTrajet($trajet) . "</small></p>";
        }
    }

    return $output."</aside>";
}


function displayDemandes(array $demandes, string $style)
{
    $output = '';
    if ($style == 'full') {
        foreach ($demandes as $demande) {
            $output = $output . displayDemandeHome($demande) . '<br>';
        }
    } else {
        foreach ($demandes as $demande) {
            $output = $output . displayDemandeHome($demande) . '<br>';
        }
    }

    return $output;
}


function displayDemandeHome(Demande $demande)
{
    global $users;
    global $festivals;
    global $lieux;

    $output = "<aside>";
          
    foreach ($festivals as $festival) {
        if ($festival->getId() == $demande->getFestivalId()) {
            $output = $output . '<h3>' . displayFestival($festival) . "</h3>";
        }
    }

    foreach ($users as $user) {
        if ($user->getId() == $demande->getAuthorId()) {
            $output = $output . '<p>' . $user->getPrenom() . " " . $user->getNom() . "</p>";
        }
    }

    foreach ($lieux as $lieu) {
        if ($lieu->getId() == $demande->getLieuId()) {
            $output = $output . '<p><small>' . displayLieuDet($lieu) . "</small></p>";
        }
    }

    return $output."</aside>";
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

function displayLieuDet(Lieu $lieu)
{
    $output = "";
    $output = $lieu->getVille() . " " . $lieu->getCodePostal();
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
