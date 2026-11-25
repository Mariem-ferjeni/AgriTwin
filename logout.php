
<?php

session_start();

// Supprimer les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

// Retourner à la connexion
header("Location: views/connexion.php");
exit();

?>
