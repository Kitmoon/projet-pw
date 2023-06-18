<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../posts/vehicule.php';

class VehiculeDAO
{
  private $database;

  public function __construct($database)
  {
    $this->database = $database;
  }

  public function createVehicule($vehicule)
  {
    $db = $this->database->getPDO();

    $sql = "INSERT INTO vehicules (driver_id, marque, modele, couleur, nb_places) VALUES (:driver_id, :marque, :modele, :couleur, :nb_places)";
    $statement = $db->prepare($sql);

    $statement->execute([
      'driver_id' => $vehicule->getDriverId(),
      'marque' => $vehicule->getMarque(),
      'modele' => $vehicule->getModele(),
      'couleur' => $vehicule->getCouleur(),
      'nb_places' => $vehicule->getNbPlaces()
    ]);

    $db = null;
  }

  public function getVehiculeById($vehiculeId)
  {
    $db = $this->database->getPDO();

    $sql = 'SELECT * FROM vehicules WHERE vehicule_id = :vehicule_id';
    $statement = $db->prepare($sql);
    $statement->bindParam(':vehicule_id', $vehiculeId);
    $statement->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return null;
    }

    $vehicule = new Vehicule(
      $row['driver_id'],
      $row['marque'],
      $row['modele'],
      $row['couleur'],
      $row['nb_places']
    );

    $vehicule->setId($row['vehicule_id']);

    $db = null;

    return $vehicule;
  }

  public function updateVehicule($vehicule)
  {
    $db = $this->database->getPDO();

    $sql = "UPDATE vehicules SET driver_id = :driver_id, marque = :marque, modele = :modele, couleur = :couleur, nb_places = :nb_places WHERE vehicule_id = :vehicule_id";
    $statement = $db->prepare($sql);

    $statement->execute([
      'driver_id' => $vehicule->getDriverId(),
      'marque' => $vehicule->getMarque(),
      'modele' => $vehicule->getModele(),
      'couleur' => $vehicule->getCouleur(),
      'nb_places' => $vehicule->getNbPlaces(),
      'vehicule_id' => $vehicule->getId()
    ]);

    $db = null;
  }

  public function deleteVehicule($vehiculeId)
  {
    $db = $this->database->getPDO();

    $sql = 'DELETE FROM vehicules WHERE vehicule_id = :vehicule_id';
    $statement = $db->prepare($sql);
    $statement->bindParam(':vehicule_id', $vehiculeId);
    $statement->execute();

    $db = null;
  }

  public function getAllVehicules()
{
    $db = $this->database->getPDO();

    $sql = 'SELECT * FROM vehicules';
    $statement = $db->prepare($sql);
    $statement->execute();

    $vehicules = [];

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $vehicule = new Vehicule(
            $row['driver_id'],
            $row['marque'],
            $row['modele'],
            $row['couleur'],
            $row['nb_places']
        );

        $vehicule->setId($row['vehicule_id']);
        $vehicules[] = $vehicule;
    }

    $db = null;

    return $vehicules;
}

}
