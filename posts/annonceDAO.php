<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/annonce.php';
require_once __DIR__ . '/lieu.php';
require_once __DIR__ . '/lieuDAO.php';
require_once __DIR__ . '/festival.php';
require_once __DIR__ . '/festivalDAO.php';
require_once __DIR__ . '/trajet.php';
require_once __DIR__ . '/trajetDAO.php';

class AnnonceDAO
{
  private $database;

  public function __construct($database)
  {
    $this->database = $database;
  }

  public function createAnnonce($annonce)
  {
    $db = $this->database->getPDO();

    $sql = "INSERT INTO annonces (festival_id, driver_id, trajet_id, publication_date, voiture, nb_places, isEnabled) VALUES (:festival_id, :driver_id, :trajet_id, :publication_date, :voiture, :nb_places, :isEnabled)";
    $statement = $db->prepare($sql);

    $statement->execute([
      'driver_id' => $annonce->getDriverId(),
      'trajet_id' => $annonce->getTrajetId(),
      'festival_id' => $annonce->getFestivalId(),
      'publication_date' => $annonce->getPublicationDate(),
      'voiture' => $annonce->getVoiture(),
      'nb_places' => $annonce->getNbPlaces(),
      'isEnabled' => $annonce->isEnabled()
    ]);

    $db = null;
  }

  public function getAnnonceById($annonceId)
  {
    $db = $this->database->getPDO();

    $sql = 'SELECT * FROM annonces WHERE annonce_id = :annonce_id LIMIT 1';
    $statement = $db->prepare($sql);

    $statement->execute([
      'annonce_id' => $annonceId,
    ]);

    $annonceData = $statement->fetch(PDO::FETCH_ASSOC);

    $db = null;

    if ($annonceData) {
      $annonce = new Annonce($annonceData['driver_id'], $annonceData['trajet_id'], $annonceData['festival_id'], $annonceData['publication_date'], $annonceData['voiture'], $annonceData['nb_places'], $annonceData['isEnabled']);
      $annonce->setId($annonceData['annonce_id']);
      return $annonce;
    }

    return null;
  }

  public function searchAnnonces($lieuAdresse, $lieuVille, $lieuCodePostal, $festivalId, $dateDepart): array
  {
    $lieuNom = $lieuAdresse;

    $trajetDAO = new trajetDAO($this->database);
    $lieuDAO = new LieuDAO($this->database);

    $trajets = $trajetDAO->getAllTrajets();
    $lieux = $lieuDAO->getAllLieux();

    $newLieu = findLieuGet($lieux, $lieuDAO, $lieuNom, $lieuAdresse, $lieuVille, $lieuCodePostal);

    $trajetId = findTrajetLieu($trajets, $dateDepart, $newLieu);

    $datePublication = $dateDepart;

    $query = "SELECT * FROM annonces WHERE 1=1"; // pour éviter les erreurs

    if ($trajetId != null) {
      $query .= " AND trajet_id = :trajet_id";
    }

    if ($festivalId != null) {
      $query .= " AND festival_id = :festival_id";
    }

    if ($datePublication != null) {
      $query .= " AND publication_date = :publication_date";
    }

    debug_to_console("SQL : " . $query);


    $statement = $this->database->prepare($query);

    if ($trajetId != null) {
      $statement->bindValue(':trajet_id', $trajetId);
    }

    if ($festivalId != null) {
      $statement->bindValue(':festival_id', $festivalId);
    }

    if ($datePublication != null) {
      $statement->bindValue(':publication_date', $datePublication);
    }

    $statement->execute();

    $annonces = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      $annonce = new Annonce($row['driver_id'], $row['trajet_id'], $row['festival_id'], $row['publication_date'], $row['voiture'], $row['nb_places'], $row['is_enabled']);
      $annonce->setId($row['id']);
      $annonces[] = $annonce;
    }

    return $annonces;
  }

  public function getAllAnnonces()
  {
    $db = $this->database->getPDO();

    $sql = 'SELECT * FROM annonces';
    $statement = $db->prepare($sql);

    $statement->execute();

    $annoncesData = $statement->fetchAll(PDO::FETCH_ASSOC);

    $db = null;

    $annonces = [];

    foreach ($annoncesData as $annonceData) {
      $annonce = new Annonce($annonceData['driver_id'], $annonceData['trajet_id'], $annonceData['festival_id'], $annonceData['publication_date'], $annonceData['voiture'], $annonceData['nb_places'], $annonceData['isEnabled']);
      $annonce->setId($annonceData['annonce_id']);
      $annonces[] = $annonce;
    }

    return $annonces;
  }

  public function updateAnnonce($annonce)
  {
    $sql = "UPDATE annonces SET driver_id = :driver_id, trajet_id = :trajet_id, festival_id = :festival_id, publication_date = :publication_date, voiture = :voiture, nb_places = :nb_places, isEnabled = :isEnabled WHERE annonce_id = :annonce_id";
    $statement = $this->database->prepare($sql);

    $statement->execute([
      'annonce_id' => $annonce->getId(),
      'driver_id' => $annonce->getDriverId(),
      'trajet_id' => $annonce->getTrajetId(),
      'festival_id' => $annonce->getFestivalId(),
      'publication_date' => $annonce->getPublicationDate(),
      'voiture' => $annonce->getVoiture(),
      'nb_places' => $annonce->getNbPlaces(),
      'isEnabled' => $annonce->isEnabled()
    ]);
  }

  public function deleteAnnonce(Annonce $annonce)
  {
    $query = 'DELETE FROM annonces WHERE annonce_id = :annonce_id';
    $statement = $this->database->prepare($query);
    $statement->bindValue(':annonce_id', $annonce->getId());
    $statement->execute();
  }

  public function getAnnoncesByFestivalId($festivalId)
  {
    $db = $this->database->getPDO();

    $sql = 'SELECT * FROM annonces WHERE festival_id = :festival_id';
    $statement = $db->prepare($sql);

    $statement->execute([
      'festival_id' => $festivalId,
    ]);

    $annoncesData = $statement->fetchAll(PDO::FETCH_ASSOC);

    $db = null;

    $annonces = [];

    foreach ($annoncesData as $annonceData) {
      $annonce = new Annonce($annonceData['driver_id'], $annonceData['trajet_id'], $annonceData['festival_id'], $annonceData['publication_date'], $annonceData['voiture'], $annonceData['nb_places'], $annonceData['isEnabled']);
      $annonce->setId($annonceData['annonce_id']);
      $annonces[] = $annonce;
    }

    return $annonces;
  }
}

function findLieuGet($lieux, $lieuDAO, $lieuNom, $lieuAdresse, $lieuVille, $lieuCodePostal)
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

function findTrajetLieu($trajets, $dateDepart, $newLieu)
{
    // On vérifie si le trajet existe déjà ou non
    foreach ($trajets as $trajet) {
        debug_to_console("Trajet en recherche : " . $dateDepart);
        if ($trajet->getLieuDepart() == $newLieu->getId() && $trajet->getDateDepart() == $dateDepart) {
            debug_to_console("Trajet trouvé : " . $trajet->getId());
            return $trajet->getId();
        }
    }
    return null;
}

?>