<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "agritwin_test";

try {
    $connexion = new PDO(
        "mysql:host=$host;dbname=$database;charset=utf8",
        $user,
        $password
    );

    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

?>
