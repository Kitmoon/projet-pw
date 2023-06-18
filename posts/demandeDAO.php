<?php
require_once __DIR__ . '/../database.php';
require_once('demande.php');

class DemandeDAO
{
  private $database;

  public function __construct($database)
  {
    $this->database = $database;
  }

  public function createDemande($demande)
  {
    $db = $this->database->getPDO();

    $sql = "INSERT INTO demandes (author_id, lieu_id, publication_date, festival_id, isEnabled) VALUES (:author_id, :lieu_id, :publication_date, :festival_id, :isEnabled)";
    $statement = $db->prepare($sql);

    $statement->execute([
      'author_id' => $demande->getAuthorId(),
      'lieu_id' => $demande->getLieuId(),
      'publication_date' => $demande->getPublicationDate(),
      'festival_id' => $demande->getFestivalId(),
      'isEnabled' => $demande->isEnabled()
    ]);

    $db = null;
  }

  public function getdemandeById($demandeId)
  {
    $db = $this->database->getPDO();

    $sql = 'SELECT * FROM demandes WHERE demande_id = :demande_id LIMIT 1';
    $statement = $db->prepare($sql);

    $statement->execute([
      'demande_id' => $demandeId,
    ]);

    $demandeData = $statement->fetch(PDO::FETCH_ASSOC);

    $db = null;

    if ($demandeData) {
      $demande = new Demande($demandeData['author_id'], $demandeData['lieu_id'], $demandeData['publication_date'], $demandeData['festival_id'], $demandeData['isEnabled']);
      $demande->setId($demandeData['demande_id']);
      return $demande;
    }

    return null;
  }

  public function getAllDemandes()
  {
    $db = $this->database->getPDO();

    $sql = 'SELECT * FROM demandes';
    $statement = $db->prepare($sql);

    $statement->execute();

    $demandesData = $statement->fetchAll(PDO::FETCH_ASSOC);

    $db = null;

    $demandes = [];

    foreach ($demandesData as $demandeData) {
      $demande = new Demande($demandeData['author_id'], $demandeData['lieu_id'], $demandeData['publication_date'], $demandeData['festival_id'], $demandeData['isEnabled']);
      $demande->setId($demandeData['demande_id']);
      $demandes[] = $demande;
    }

    return $demandes;
  }

  public function updateDemande($demande)
  {
    $sql = "UPDATE demandes SET author_id = :author_id, lieu_id = :lieu_id, publication_date = :publication_date, festival_id = :festival_id, isEnabled = :isEnabled WHERE demande_id = :demande_id";
    $statement = $this->database->prepare($sql);

    $statement->execute([
      'demande_id' => $demande->getId(),
      'author_id' => $demande->getAuthorId(),
      'lieu_id' => $demande->getLieuId(),
      'publication_date' => $demande->getPublicationDate(),
      'festival_id' => $demande->getFestivalId(),
      'isEnabled' => $demande->isEnabled()
    ]);
  }

  public function deleteDemande(Demande $demande)
  {
    $query = 'DELETE FROM demandes WHERE demande_id = :demande_id';
    $statement = $this->database->prepare($query);
    $statement->bindValue(':demande_id', $demande->getId());
    $statement->execute();
  }

  public function getDemandesByFestivalId($festivalId)
  {
    $db = $this->database->getPDO();

    $sql = 'SELECT * FROM demandes WHERE festival_id = :festival_id';
    $statement = $db->prepare($sql);

    $statement->execute([
      'festival_id' => $festivalId,
    ]);

    $demandesData = $statement->fetchAll(PDO::FETCH_ASSOC);

    $db = null;

    $demandes = [];

    foreach ($demandesData as $demandeData) {
      $demande = new Demande($demandeData['author_id'], $demandeData['lieu_id'], $demandeData['publication_date'], $demandeData['festival_id'], $demandeData['isEnabled']);
      $demande->setId($demandeData['demande_id']);
      $demandes[] = $demande;
    }

    return $demandes;
  }
}
?>
