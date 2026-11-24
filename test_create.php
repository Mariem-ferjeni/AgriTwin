<?php
require_once "config/database.php";

$nom = "Utilisateur Test CRUD";
$email = "crud@gmail.com";
$mot_de_passe = password_hash("123456", PASSWORD_DEFAULT);
$role = "user";

$sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe, role)
        VALUES (?, ?, ?, ?)";

$requete = $connexion->prepare($sql);

$requete->execute([$nom, $email, $mot_de_passe, $role]);

echo "Utilisateur ajouté avec succès !";
?>
