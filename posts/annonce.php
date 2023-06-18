<?php
class Annonce {
  private $annonce_id;
  private $driver_id;
  private $trajet_id;
  private $festival_id;
  private $publication_date;
  private $vehicule_id;
  private $isEnabled;

  public function __construct($driver_id, $trajet_id, $festival_id, $publication_date, $vehicule_id, $isEnabled) {
    $this->driver_id = $driver_id;
    $this->trajet_id = $trajet_id;
    $this->festival_id = $festival_id;
    $this->publication_date = $publication_date;
    $this->vehicule_id = $vehicule_id;
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

  public function getVehiculeId() {
    return $this->vehicule_id;
  }

  public function setVehiculeId($vehicule_id) {
    $this->vehicule_id = $vehicule_id;
  }

  public function isEnabled() {
    return $this->isEnabled;
  }

  public function setEnabled($isEnabled) {
    $this->isEnabled = $isEnabled;
  }
}
