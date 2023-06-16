<?php
$db = new PDO('mysql:host=localhost;dbname=base de données;charset=utf8', 'root', 'root');

$sqlQuery = "SELECT * FROM Utilisateurs";

$usersStatement = $db->prepare($sqlQuery);
$usersStatement->execute();
$users = $usersStatement->fetchAll();

foreach ($users as $user) {
    ?>
        <p><?php echo $user['prenom'] . " " . $user['nom']; ?></p>
    <?php
    }
?>