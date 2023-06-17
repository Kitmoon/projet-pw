<?php
class User
{
    private $id;
    private $nom;
    private $prenom;
    private $mail;
    private $password;
    private $isAdmin;

    public function __construct(string $prenom, string $nom, string $mail, string $password, int $isAdmin = 0) {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->mail = $mail;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
    }

    /*public function toString() {
        echo 'Bonjour, je suis ' . $this->prenom . ' ' . $this->nom . '. Mon mail est : ' . $this->mail . ' et mon mot de passe hashé est : ' . $this->password; 
    }*/

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function isAdmin()
    {
        return $this->isAdmin;
    }

    public function setAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }
}