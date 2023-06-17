<?php

class Database
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'root';
    private $dbname = 'festicar';
    private $pdo;

    public function __construct() {
        $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
        }
    
        public function getPDO() {
            return $this->pdo;
        }

        public function prepare($sql) {
            return $this->pdo->prepare($sql);
        }
}
?>