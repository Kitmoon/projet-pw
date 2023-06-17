<?php
class Lieu {
  private $lieu_id;
  private $nom;
  private $adresse;
  private $ville;
  private $code_postal;

  public function __construct($nom, $adresse, $ville, $code_postal) {
    $this->nom = $nom;
    $this->adresse = $adresse;
    $this->ville = $ville;
    $this->code_postal = $code_postal;
  }

  public function getId() {
    return $this->lieu_id;
  }

  public function setId($lieu_id) {
    $this->lieu_id = $lieu_id;
  }

  public function getNom() {
    return $this->nom;
  }

  public function setNom($nom) {
    $this->nom = $nom;
  }

  public function getAdresse() {
    return $this->adresse;
  }

  public function setAdresse($adresse) {
    $this->adresse = $adresse;
  }

  public function getVille() {
    return $this->ville;
  }

  public function setVille($ville) {
    $this->ville = $ville;
  }

  public function getCodePostal() : string {
    return $this->code_postal;
  }

  public function setCodePostal($code_postal) {
    $this->code_postal = $code_postal;
  }
}