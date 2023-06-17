<?php
class Festival {
  private $festival_id;
  private $nom;
  private $lieu_id;
  private $date_debut;
  private $date_fin;

  public function __construct($nom, $lieu_id, $date_debut, $date_fin) {
    $this->nom = $nom;
    $this->lieu_id = $lieu_id;
    $this->date_debut = $date_debut;
    $this->date_fin = $date_fin;
  }

  public function getId() {
    return $this->festival_id;
  }

  public function setId($festival_id) {
    $this->festival_id = $festival_id;
  }

  public function getNom() {
    return $this->nom;
  }

  public function setNom($nom) {
    $this->nom = $nom;
  }

  public function getLieuId() {
    return $this->lieu_id;
  }

  public function setLieuId($lieu_id) {
    $this->lieu_id = $lieu_id;
  }

  public function getDateDebut() {
    return $this->date_debut;
  }

  public function setDateDebut($date_debut) {
    $this->date_debut = $date_debut;
  }

  public function getDateFin() {
    return $this->date_fin;
  }

  public function setDateFin($date_fin) {
    $this->date_fin = $date_fin;
  }
}
