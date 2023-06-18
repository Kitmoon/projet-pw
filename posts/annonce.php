<?php
class Annonce {
  private $annonce_id;
  private $driver_id;
  private $trajet_id;
  private $festival_id;
  private $publication_date;
  private $voiture;
  private $nbPlaces;
  private $isEnabled;

  public function __construct($driver_id, $trajet_id, $festival_id, $publication_date, $voiture, $nbPlaces, $isEnabled) {
    $this->driver_id = $driver_id;
    $this->trajet_id = $trajet_id;
    $this->festival_id = $festival_id;
    $this->publication_date = $publication_date;
    $this->voiture = $voiture;
    $this->nbPlaces = $nbPlaces;
    $this->isEnabled = $isEnabled;
  }

  public function getId() {
    return $this->annonce_id;
  }

  public function setId($annonce_id) {
    $this->annonce_id = $annonce_id;
  }

  public function getDriverId() {
    return $this->driver_id;
  }

  public function setDriverId($driver_id) {
    $this->driver_id = $driver_id;
  }
  
  public function getTrajetId() {
    return $this->trajet_id;
  }

  public function setTrajetId($trajet_id) {
    $this->trajet_id = $trajet_id;
  }
  public function getFestivalId() {
    return $this->festival_id;
  }

  public function setFestivalId($festival_id) {
    $this->festival_id = $festival_id;
  }

  public function getPublicationDate() {
    return $this->publication_date;
  }

  public function setPublicationDate($publication_date) {
    $this->publication_date = $publication_date;
  }

  public function getVoiture() {
    return $this->voiture;
  }

  public function setVoiture($voiture) {
    $this->voiture = $voiture;
  }

  public function getNbPlaces() {
    return $this->nbPlaces;
  }

  public function setNbPlaces($nbPlaces) {
    $this->nbPlaces = $nbPlaces;
  }

  public function isEnabled() {
    return $this->isEnabled;
  }

  public function setEnabled($isEnabled) {
    $this->isEnabled = $isEnabled;
  }
}
