
<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: conexion.php");
    exit;
}

$nom = htmlspecialchars(
    $_SESSION["nom"] ?? "Utilisateur",
    ENT_QUOTES,
    "UTF-8"
);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - AgriTwin</title>
    <link rel="stylesheet" href="../css/stylee.css">
</head>

<body>

    <h1>Bienvenue sur AgriTwin !</h1>

    <h2>Bonjour <?php echo $nom; ?> !</h2>

    <p>Vous êtes connecté avec succès.</p>

    <h3>Menu principal</h3>

    <ul>
        <li>
            <a href="liste_exploitations.php">
                Gérer mon exploitation
            </a>
        </li>

        <li>
            <a href="parcelles.php">
                Gérer mes parcelles
            </a>
        </li>

        <li>
            <a href="simulations.php">
                Simulations agricoles
            </a>
        </li>
    </ul>

    <a href="logout.php">Déconnexion</a>

    <script src="../js/app.js"></script>

</body>
</html>
