<?php
require_once __DIR__ . '/../database.php';
require_once('lieu.php');

class LieuDAO
{
  private $database;

  public function __construct($database)
  {
    $this->database = $database;
  }

  public function createLieu($lieu)
  {
    $db = $this->database->getPDO();

    $sql = "INSERT INTO lieux (nom, adresse, ville, code_postal) VALUES (:nom, :adresse, :ville, :code_postal)";
    $statement = $db->prepare($sql);

    $statement->execute([
      'nom' => $lieu->getNom(),
      'adresse' => $lieu->getAdresse(),
      'ville' => $lieu->getVille(),
      'code_postal' => $lieu->getCodePostal()
    ]);

    $db = null;
  }

  public function getLieuById($lieuId)
  {
    $db = $this->database->getPDO();

    $sql = 'SELECT * FROM lieux WHERE lieu_id = :lieu_id LIMIT 1';
    $statement = $db->prepare($sql);

    $statement->execute([
      'lieu_id' => $lieuId,
    ]);

    $lieuData = $statement->fetch(PDO::FETCH_ASSOC);

    $db = null;

    if ($lieuData) {
      $lieu = new Lieu($lieuData['nom'], $lieuData['adresse'], $lieuData['ville'], $lieuData['code_postal']);
      $lieu->setId($lieuData['lieu_id']);
      return $lieu;
    }

    return null;
  }

  public function getAllLieux()
  {
    $db = $this->database->getPDO();

    $sql = 'SELECT * FROM lieux';
    $statement = $db->prepare($sql);

    $statement->execute();

    $lieuxData = $statement->fetchAll(PDO::FETCH_ASSOC);

    $db = null;

    $lieux = [];

    foreach ($lieuxData as $lieuData) {
      $lieu = new Lieu($lieuData['nom'], $lieuData['adresse'], $lieuData['ville'], $lieuData['code_postal']);
      $lieu->setId($lieuData['lieu_id']);
      $lieux[] = $lieu;
    }

    return $lieux;
  }



  public function updateLieu($lieu)
  {
    $sql = "UPDATE lieux SET nom = :nom, adresse = :adresse, ville = :ville, code_postal = :code_postal WHERE lieu_id = :lieu_id";
    $statement = $this->database->prepare($sql);

    $statement->execute([
      'lieu_id' => $lieu->getId(),
      'nom' => $lieu->getNom(),
      'adresse' => $lieu->getAdresse(),
      'ville' => $lieu->getVille(),
      'code_postal' => $lieu->getCodePostal()
    ]);
  }

  public function deleteLieu(Lieu $lieu)
  {
    $query = 'DELETE FROM lieux WHERE lieu_id = :lieu_id';
    $statement = $this->database->prepare($query);
    $statement->bindValue(':lieu_id', $lieu->getId());
    $statement->execute();
  }



  public function getLieuxByVille($ville)
  {
    $db = $this->database->getPDO();

    $sql = 'SELECT * FROM lieux WHERE ville = :ville';
    $statement = $db->prepare($sql);

    $statement->execute([
      'ville' => $ville,
    ]);

    $lieuxData = $statement->fetchAll(PDO::FETCH_ASSOC);

    $db = null;

    $lieux = [];

    foreach ($lieuxData as $lieuData) {
      $lieu = new Lieu($lieuData['nom'], $lieuData['adresse'], $lieuData['ville'], $lieuData['code_postal']);
      $lieu->setId($lieuData['lieu_id']);
      $lieux[] = $lieu;
    }

    return $lieux;
  }
}