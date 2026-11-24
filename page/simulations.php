<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: conexion.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Simulations agricoles - AgriTwin</title>
    <link rel="stylesheet" href="../css/stylee.css">
</head>
<body>

    <h1>Simulations agricoles</h1>

    <p>Bienvenue dans le module de simulation agricole.</p>

    <p>Cette fonctionnalité sera développée prochainement.</p>

    <a href="dashboard.php">Retour au tableau de bord</a>

    <script src="../js/app.js"></script>
</body>
</html>
