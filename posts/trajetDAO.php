<?php
require_once __DIR__ . '/../database.php';
require_once('trajet.php');

class TrajetDAO
{
  private $database;

  public function __construct($database)
  {
    $this->database = $database;
  }

  public function createTrajet($trajet)
  {
    $db = $this->database->getPDO();

    $sql = "INSERT INTO trajets (festival_id, driver_id, date_depart, lieu_depart, lieu_arrivee, prix, description) VALUES (:festival_id, :driver_id, :date_depart, :lieu_depart, :lieu_arrivee, :prix, :description)";
    $statement = $db->prepare($sql);

    $statement->execute([
      'festival_id' => $trajet->getFestivalId(),
      'driver_id' => $trajet->getDriverId(),
      'date_depart' => $trajet->getDateDepart(),
      'lieu_depart' => $trajet->getLieuDepart(),
      'lieu_arrivee' => $trajet->getLieuArrivee(),
      'prix' => $trajet->getPrix(),
      'description' => $trajet->getDescription()
    ]);

    $db = null;
  }

  public function getTrajetById($trajetId)
  {
    $db = $this->database->getPDO();

    $sql = 'SELECT * FROM trajets WHERE trajet_id = :trajet_id LIMIT 1';
    $statement = $db->prepare($sql);

    $statement->execute([
      'trajet_id' => $trajetId,
    ]);

    $trajetData = $statement->fetch(PDO::FETCH_ASSOC);

    $db = null;

    if ($trajetData) {
      $trajet = new Trajet($trajetData['festival_id'], $trajetData['driver_id'], $trajetData['date_depart'], $trajetData['lieu_depart'], $trajetData['lieu_arrivee'], $trajetData['prix'], $trajetData['description']);
      $trajet->setId($trajetData['trajet_id']);
      return $trajet;
    }

    return null;
  }

  public function getAllTrajets()
  {
    $db = $this->database->getPDO();

    $sql = 'SELECT * FROM trajets';
    $statement = $db->prepare($sql);

    $statement->execute();

    $trajetsData = $statement->fetchAll(PDO::FETCH_ASSOC);

    $db = null;

    $trajets = [];

    foreach ($trajetsData as $trajetData) {
      $trajet = new Trajet($trajetData['festival_id'], $trajetData['driver_id'], $trajetData['date_depart'], $trajetData['lieu_depart'], $trajetData['lieu_arrivee'], $trajetData['prix'], $trajetData['description']);
      $trajet->setId($trajetData['trajet_id']);
      $trajets[] = $trajet;
    }

    return $trajets;
  }

  public function updateTrajet($trajet)
  {
    $sql = "UPDATE trajets SET festival_id = :festival_id, driver_id = :driver_id, date_depart = :date_depart, lieu_depart = :lieu_depart, lieu_arrivee = :lieu_arrivee, prix = :prix, description = :description WHERE trajet_id = :trajet_id";
    $statement = $this->database->prepare($sql);

    $statement->execute([
      'trajet_id' => $trajet->getId(),
      'festival_id' => $trajet->getFestivalId(),
      'driver_id' => $trajet->getDriverId(),
      'date_depart' => $trajet->getDateDepart(),
      'lieu_depart' => $trajet->getLieuDepart(),
      'lieu_arrivee' => $trajet->getLieuArrivee(),
      'prix' => $trajet->getPrix(),
      'description' => $trajet->getDescription()
    ]);
  }

  public function deleteTrajet(Trajet $trajet)
  {
    $query = 'DELETE FROM trajets WHERE trajet_id = :trajet_id';
    $statement = $this->database->prepare($query);
    $statement->bindValue(':trajet_id', $trajet->getId());
    $statement->execute();
  }

  public function getTrajetsByFestivalId($festivalId)
  {
    $db = $this->database->getPDO();

    $sql = 'SELECT * FROM trajets WHERE festival_id = :festival_id';
    $statement = $db->prepare($sql);

    $statement->execute([
      'festival_id' => $festivalId,
    ]);

    $trajetsData = $statement->fetchAll(PDO::FETCH_ASSOC);

    $db = null;

    $trajets = [];

    foreach ($trajetsData as $trajetData) {
      $trajet = new Trajet($trajetData['festival_id'], $trajetData['driver_id'], $trajetData['date_depart'], $trajetData['lieu_depart'], $trajetData['lieu_arrivee'], $trajetData['prix'], $trajetData['description']);
      $trajet->setId($trajetData['trajet_id']);
      $trajets[] = $trajet;
    }

    return $trajets;
  }
}
?>
