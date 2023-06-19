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

    $sql = "INSERT INTO demandes (author_id, lieu_id, publication_date, festival_id, isEnabled, date_depart, date_retour) VALUES (:author_id, :lieu_id, :publication_date, :festival_id, :isEnabled, :date_depart, :date_retour)";
    $statement = $db->prepare($sql);

    $statement->execute([
      'author_id' => $demande->getAuthorId(),
      'lieu_id' => $demande->getLieuId(),
      'publication_date' => $demande->getPublicationDate(),
      'festival_id' => $demande->getFestivalId(),
      'isEnabled' => $demande->isEnabled(),
      'date_depart' => $demande->getDateDepart(),
      'date_retour' => $demande->getDateRetour()
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
      $demande = new Demande($demandeData['author_id'], $demandeData['lieu_id'], $demandeData['publication_date'], $demandeData['festival_id'], $demandeData['isEnabled'], $demandeData['date_depart'], $demandeData['date_retour']);
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
      $demande = new Demande($demandeData['author_id'], $demandeData['lieu_id'], $demandeData['publication_date'], $demandeData['festival_id'], $demandeData['isEnabled'], $demandeData['date_depart'], $demandeData['date_retour']);
      $demande->setId($demandeData['demande_id']);
      $demandes[] = $demande;
    }

    return $demandes;
  }

  public function updateDemande($demande)
  {
    $sql = "UPDATE demandes SET author_id = :author_id, lieu_id = :lieu_id, publication_date = :publication_date, festival_id = :festival_id, isEnabled = :isEnabled, date_depart = :date_depart, date_retour = :date_retour WHERE demande_id = :demande_id";
    $statement = $this->database->prepare($sql);

    $statement->execute([
      'demande_id' => $demande->getId(),
      'author_id' => $demande->getAuthorId(),
      'lieu_id' => $demande->getLieuId(),
      'publication_date' => $demande->getPublicationDate(),
      'festival_id' => $demande->getFestivalId(),
      'isEnabled' => $demande->isEnabled(),
      'date_depart' => $demande->getDateDepart(),
      'date_retour' => $demande->getDateRetour()
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
      $demande = new Demande($demandeData['author_id'], $demandeData['lieu_id'], $demandeData['publication_date'], $demandeData['festival_id'], $demandeData['isEnabled'], $demandeData['date_depart'], $demandeData['date_retour']);
      $demande->setId($demandeData['demande_id']);
      $demandes[] = $demande;
    }

    return $demandes;
  }


  public function searchDemandes($lieuAdresse, $lieuVille, $lieuCodePostal, $festivalId, $dateDepart): array
  {
    $lieuNom = $lieuAdresse;

    $lieuDAO = new LieuDAO($this->database);
    $lieux = $lieuDAO->getAllLieux();

    $newLieu = findLieuNew($lieux, $lieuDAO, $lieuNom, $lieuAdresse, $lieuVille, $lieuCodePostal);

    $datePublication = $dateDepart;

    $query = "SELECT * FROM demandes WHERE 1=1"; // pour éviter les erreurs

    if ($newLieu != null) {
      $query .= " AND lieu_id = :lieu_id";
    }

    if ($festivalId != null) {
      $query .= " AND festival_id = :festival_id";
    }

    if ($datePublication != null) {
      $query .= " AND publication_date = :publication_date";
    }

    debug_to_console("SQL : " . $query);


    $statement = $this->database->prepare($query);

    if ($newLieu != null) {
      $statement->bindValue(':lieu_id', $newLieu->getId());
    }

    if ($festivalId != null) {
      $statement->bindValue(':festival_id', $festivalId);
    }

    if ($datePublication != null) {
      $statement->bindValue(':publication_date', $datePublication);
    }

    $statement->execute();

    $demandes = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      $demande = new Demande($row['author_id'], $row['lieu_id'], $row['publication_date'], $row['festival_id'], $row['isEnabled'], $row['date_depart'], $row['date_retour']);
      $demande->setId($row['demande_id']);
      $demandes[] = $demande;
    }

    return $demandes;
  }

}

function findLieuNew($lieux, $lieuDAO, $lieuNom, $lieuAdresse, $lieuVille, $lieuCodePostal)
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

?>