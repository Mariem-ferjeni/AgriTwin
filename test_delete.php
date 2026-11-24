<?php
require_once "config/database.php";

$sql = "DELETE FROM utilisateurs WHERE email = ?";

$requete = $connexion->prepare($sql);

$requete->execute(["crud@gmail.com"]);

echo "Utilisateur supprimé avec succès !";
?>
