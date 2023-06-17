<?php
require_once __DIR__ . '/../database.php';
require_once('festival.php');

class FestivalDAO
{
  private $database;

  public function __construct($database)
  {
    $this->database = $database;
  }

  public function createFestival($festival)
  {
    $db = $this->database->getPDO();

    $sql = "INSERT INTO festivals (nom, lieu_id, date_debut, date_fin) VALUES (:nom, :lieu_id, :date_debut, :date_fin)";
    $statement = $db->prepare($sql);

    $statement->execute([
      'nom' => $festival->getNom(),
      'lieu_id' => $festival->getLieuId(),
      'date_debut' => $festival->getDateDebut(),
      'date_fin' => $festival->getDateFin()
    ]);

    $db = null;
  }

  public function getFestivalById($festivalId)
  {
    $db = $this->database->getPDO();

    $sql = 'SELECT * FROM festivals WHERE festival_id = :festival_id LIMIT 1';
    $statement = $db->prepare($sql);

    $statement->execute([
      'festival_id' => $festivalId,
    ]);

    $festivalData = $statement->fetch(PDO::FETCH_ASSOC);

    $db = null;

    if ($festivalData) {
      $festival = new Festival($festivalData['nom'], $festivalData['lieu_id'], $festivalData['date_debut'], $festivalData['date_fin']);
      $festival->setId($festivalData['festival_id']);
      return $festival;
    }

    return null;
  }

  public function getAllFestivals()
  {
    $db = $this->database->getPDO();

    $sql = 'SELECT * FROM festivals';
    $statement = $db->prepare($sql);

    $statement->execute();

    $festivalsData = $statement->fetchAll(PDO::FETCH_ASSOC);

    $db = null;

    $festivals = [];

    foreach ($festivalsData as $festivalData) {
      $festival = new Festival($festivalData['nom'], $festivalData['lieu_id'], $festivalData['date_debut'], $festivalData['date_fin']);
      $festival->setId($festivalData['festival_id']);
      $festivals[] = $festival;
    }

    return $festivals;
  }

  public function updateFestival($festival)
  {
    $sql = "UPDATE festivals SET nom = :nom, lieu_id = :lieu_id, date_debut = :date_debut, date_fin = :date_fin WHERE festival_id = :festival_id";
    $statement = $this->database->prepare($sql);

    $statement->execute([
      'festival_id' => $festival->getId(),
      'nom' => $festival->getNom(),
      'lieu_id' => $festival->getLieuId(),
      'date_debut' => $festival->getDateDebut(),
      'date_fin' => $festival->getDateFin()
    ]);
  }

  public function deleteFestival(Festival $festival)
  {
    $query = 'DELETE FROM festivals WHERE festival_id = :festival_id';
    $statement = $this->database->prepare($query);
    $statement->bindValue(':festival_id', $festival->getId());
    $statement->execute();
  }
}