<?php
class Demande {
  private $demande_id;
  private $author_id;
  private $lieu_id;
  private $publication_date;
  private $festival_id;
  private $isEnabled;
  private $date_depart;
  private $date_retour;

  public function __construct($author_id, $lieu_id, $publication_date, $festival_id, $isEnabled, $date_depart, $date_retour) {
    $this->author_id = $author_id;
    $this->lieu_id = $lieu_id;
    $this->festival_id = $festival_id;
    $this->publication_date = $publication_date;
    $this->isEnabled = $isEnabled;
    $this->date_depart = $date_depart;
    $this->date_retour = $date_retour;
  }

  public function getId() {
    return $this->demande_id;
  }

  public function setId($demande_id) {
    $this->demande_id = $demande_id;
  }

  public function getAuthorId() {
    return $this->author_id;
  }

  public function setAuthorId($author_id) {
    $this->author_id = $author_id;
  }
  
  public function getLieuId() {
    return $this->lieu_id;
  }

  public function setLieuId($lieu_id) {
    $this->lieu_id = $lieu_id;
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


  public function getDateDepart() {
    return $this->date_depart;
  }

  public function setDateDepart($date_depart) {
    $this->date_depart = $date_depart;
  }

  public function getDateRetour() {
    return $this->date_retour;
  }

  public function setDateRetour($date_retour) {
    $this->date_retour = $date_retour;
  }

  public function isEnabled() {
    return $this->isEnabled;
  }

  public function setEnabled($isEnabled) {
    $this->isEnabled = $isEnabled;
  }
}
