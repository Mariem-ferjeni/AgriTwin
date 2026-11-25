
<?php

$requiredRole = 'user';

require_once __DIR__ . '/../includes/auth.php';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Espace utilisateur - AgriTwin</title>

    <style>
        body {
            font-family: Arial;
            background: #eaf5ed;
            text-align: center;
            padding: 50px;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 500px;
            margin: auto;
        }

        a {
            display: inline-block;
            padding: 12px 20px;
            background: #287a40;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Bienvenue sur AgriTwin !</h1>

    <h2>
        Bonjour
        <?= htmlspecialchars($_SESSION['prenom']) ?>
        <?= htmlspecialchars($_SESSION['nom']) ?>
    </h2>

    <p>Vous êtes connecté en tant qu'utilisateur.</p>

    <p>
        Email :
        <?= htmlspecialchars($_SESSION['email']) ?>
    </p>

    <p>
        Rôle :
        <?= htmlspecialchars($_SESSION['role']) ?>
    </p>

    <a href="../logout.php">Se déconnecter</a>

</div>

</body>
</html>
