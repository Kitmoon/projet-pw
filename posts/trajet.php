<?php
class Trajet {
  private $trajet_id;
  private $festival_id;
  private $driver_id;
  private $date_depart;
  private $lieu_depart;
  private $lieu_arrivee;
  private $prix;
  private $description;

  public function __construct($festival_id, $driver_id, $date_depart, $lieu_depart, $lieu_arrivee, $prix, $description) {
    $this->festival_id = $festival_id;
    $this->driver_id = $driver_id;
    $this->date_depart = $date_depart;
    $this->lieu_depart = $lieu_depart;
    $this->lieu_arrivee = $lieu_arrivee;
    $this->prix = $prix;
    $this->description = $description;
  }

  public function getId() {
    return $this->trajet_id;
  }

  public function setId($trajet_id) {
    $this->trajet_id = $trajet_id;
  }

  public function getFestivalId() {
    return $this->festival_id;
  }

  public function setFestivalId($festival_id) {
    $this->festival_id = $festival_id;
  }

  public function getDriverId() {
    return $this->driver_id;
  }

  public function setDriverId($driver_id) {
    $this->driver_id = $driver_id;
  }

  public function getDateDepart() {
    return $this->date_depart;
  }

  public function setDateDepart($date_depart) {
    $this->date_depart = $date_depart;
  }

  public function getLieuDepart() {
    return $this->lieu_depart;
  }

  public function setLieuDepart($lieu_depart) {
    $this->lieu_depart = $lieu_depart;
  }

  public function getLieuArrivee() {
    return $this->lieu_arrivee;
  }

  public function setLieuArrivee($lieu_arrivee) {
    $this->lieu_arrivee = $lieu_arrivee;
  }

  public function getPrix() {
    return $this->prix;
  }

  public function setPrix($prix) {
    $this->prix = $prix;
  }

  public function getDescription() {
    return $this->description;
  }

  public function setDescription($description) {
    $this->description = $description;
  }
}
