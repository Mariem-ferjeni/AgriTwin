<?php
require_once "config/database.php";

$resultat = $connexion->query("SELECT * FROM utilisateurs");

echo "<h2>Liste des utilisateurs</h2>";

while ($user = $resultat->fetch(PDO::FETCH_ASSOC)) {
    echo "ID : " . $user["id"] . "<br>";
    echo "Nom : " . $user["nom"] . "<br>";
    echo "Email : " . $user["email"] . "<br>";
    echo "<hr>";
}
?>
