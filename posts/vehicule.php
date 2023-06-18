<?php 
class Vehicule {
  private $vehicule_id;
  private $driver_id;
  private $marque;
  private $modele;
  private $couleur;
  private $nb_places;

  public function __construct($driver_id, $marque, $modele, $couleur, $nb_places) {
    $this->driver_id = $driver_id;
    $this->marque = $marque;
    $this->modele = $modele;
    $this->couleur = $couleur;
    $this->nb_places = $nb_places;
  }

  public function getId() {
    return $this->vehicule_id;
  }

  public function setId($vehicule_id) {
    $this->vehicule_id = $vehicule_id;
  }

  public function getDriverId() {
    return $this->driver_id;
  }

  public function setDriverId($driver_id) {
    $this->driver_id = $driver_id;
  }

  public function getMarque() {
    return $this->marque;
  }

  public function setMarque($marque) {
    $this->marque = $marque;
  }

  public function getModele() {
    return $this->modele;
  }

  public function setModele($modele) {
    $this->modele = $modele;
  }

  public function getCouleur() {
    return $this->couleur;
  }

  public function setCouleur($couleur) {
    $this->couleur = $couleur;
  }

  public function getNbPlaces() {
    return $this->nb_places;
  }

  public function setNbPlaces($nb_places) {
    $this->nb_places = $nb_places;
  }
}
