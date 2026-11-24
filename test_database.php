<?php
require_once "config/database.php";

echo "Connexion réussie !<br>";

$resultat = $connexion->query("SHOW TABLES");

echo "Tables disponibles :<br>";

while ($table = $resultat->fetch(PDO::FETCH_NUM)) {
    echo $table[0] . "<br>";
}
?>
