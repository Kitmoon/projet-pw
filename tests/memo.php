<?php
try
{
	$db = new PDO('mysql:host=localhost;dbname=users;charset=utf8', 'root', 'root');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

// Ecriture de la requête
$sqlQuery = 'INSERT INTO recipes(nom, prenom, mail, password) VALUES (:nom, :prenom, :mail, :password)';

// Préparation
$insertUser = $db->prepare($sqlQuery);

// Exécution ! La recette est maintenant en base de données
$insertUser->execute([
    'nom' => 'admin',
    'prenom' => 'admin',
    'mail' => 'alex.kalonkoat@gmail.com',
    'password' => 'admin'
]);
?>