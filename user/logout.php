<?php
session_start();

// On supprime les données de la session
$_SESSION = array();
session_destroy();

header('Location: ../home.php');
exit();
?>