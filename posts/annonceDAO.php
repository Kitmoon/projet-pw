<?php
require_once __DIR__ . '/../database.php';
require_once('annonce.php');

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

    $sql = "INSERT INTO annonces (festival_id, driver_id, trajet_id, publication_date, vehicule_id, isEnabled) VALUES (:festival_id, :driver_id, :trajet_id, :publication_date, :vehicule_id, :isEnabled)";
    $statement = $db->prepare($sql);

    $statement->execute([
      'festival_id' => $annonce->getFestivalId(),
      'driver_id' => $annonce->getDriverId(),
      'trajet_id' => $annonce->getTrajetId(),
      'publication_date' => $annonce->getPublicationDate(),
      'vehicule_id' => $annonce->getVehiculeId(),
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
      $annonce = new Annonce($annonceData['driver_id'], $annonceData['trajet_id'], $annonceData['festival_id'], $annonceData['publication_date'], $annonceData['vehicule_id'], $annonceData['isEnabled']);
      $annonce->setId($annonceData['annonce_id']);
      return $annonce;
    }

    return null;
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
      $annonce = new Annonce($annonceData['driver_id'], $annonceData['trajet_id'], $annonceData['festival_id'], $annonceData['publication_date'], $annonceData['vehicule_id'], $annonceData['isEnabled']);
      $annonce->setId($annonceData['annonce_id']);
      $annonces[] = $annonce;
    }

    return $annonces;
  }

  public function updateAnnonce($annonce)
  {
    $sql = "UPDATE annonces SET driver_id = :driver_id, trajet_id = :trajet_id, festival_id = :festival_id, publication_date = :publication_date, vehicule_id = :vehicule_id, isEnabled = :isEnabled WHERE annonce_id = :annonce_id";
    $statement = $this->database->prepare($sql);

    $statement->execute([
      'annonce_id' => $annonce->getId(),
      'driver_id' => $annonce->getDriverId(),
      'trajet_id' => $annonce->getTrajetId(),
      'festival_id' => $annonce->getFestivalId(),
      'publication_date' => $annonce->getPublicationDate(),
      'vehicule_id' => $annonce->getVehiculeId(),
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
      $annonce = new Annonce($annonceData['driver_id'], $annonceData['trajet_id'], $annonceData['festival_id'], $annonceData['publication_date'], $annonceData['vehicule_id'], $annonceData['isEnabled']);
      $annonce->setId($annonceData['annonce_id']);
      $annonces[] = $annonce;
    }

    return $annonces;
  }
}
?>
