<?php

require_once "../config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = trim($_POST["nom"]);
    $email = trim($_POST["email"]);
    $mot_de_passe = $_POST["mot_de_passe"];

    if (empty($nom) || empty($email) || empty($mot_de_passe)) {

        $message = "Veuillez remplir tous les champs.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Adresse email invalide.";

    } elseif (strlen($mot_de_passe) < 6) {

        $message = "Le mot de passe doit contenir au moins 6 caractères.";

    } else {

        $verification = $connexion->prepare(
            "SELECT id FROM utilisateurs WHERE email = ?"
        );

        $verification->execute([$email]);

        if ($verification->fetch()) {

            $message = "Cette adresse email existe déjà.";

        } else {

            $mot_de_passe_hash = password_hash(
                $mot_de_passe,
                PASSWORD_DEFAULT
            );

            $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe)
                    VALUES (?, ?, ?)";

            $requete = $connexion->prepare($sql);

            $requete->execute([
                $nom,
                $email,
                $mot_de_passe_hash
            ]);

            header("Location: conexion.php?inscription=success");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription AgriTwin</title>
</head>

<body>

    <h1>Créer un compte AgriTwin</h1>

    <p><?php echo htmlspecialchars($message); ?></p>

    <form method="POST">

        <label>Nom :</label>
        <input type="text" name="nom" required>

        <br><br>

        <label>Email :</label>
        <input type="email" name="email" required>

        <br><br>

        <label>Mot de passe :</label>
        <input type="password" name="mot_de_passe" required>

        <br><br>

        <button type="submit">S'inscrire</button>

    </form>

    <p>
        Déjà inscrit ?
        <a href="conexion.php">Se connecter</a>
    </p>

</body>
</html>
