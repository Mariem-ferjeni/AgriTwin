<?php
require_once "config/database.php";

$sql = "UPDATE utilisateurs SET nom = ? WHERE email = ?";

$requete = $connexion->prepare($sql);

$requete->execute([
    "Utilisateur Modifie",
    "crud@gmail.com"
]);

echo "Utilisateur modifié avec succès !";
?>
