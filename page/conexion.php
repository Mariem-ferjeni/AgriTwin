<?php
session_start();

require_once "../config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $mot_de_passe = $_POST["mot_de_passe"];

    $sql = "SELECT * FROM utilisateurs WHERE email = ?";
    $requete = $connexion->prepare($sql);
    $requete->execute([$email]);

    $user = $requete->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($mot_de_passe, $user["mot_de_passe"])) {

        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["nom"] = $user["nom"];

        header("Location: dashboard.php");
        exit;

    } else {
        $message = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion AgriTwin</title>
</head>
<body>

    <h1>AgriTwin</h1>
    <h2>Connexion</h2>

    <?php
    if (isset($_GET["inscription"])) {
        echo "<p>Inscription réussie ! Connectez-vous.</p>";
    }
    ?>

    <p><?php echo htmlspecialchars($message); ?></p>

    <form method="POST">

        <label>Email :</label>
        <input type="email" name="email" required>

        <br><br>

        <label>Mot de passe :</label>
        <input type="password" name="mot_de_passe" required>

        <br><br>

        <button type="submit">Se connecter</button>

    </form>

    <p>
        Pas encore de compte ?
        <a href="inscription.php">S'inscrire</a>
    </p>

</body>
</html>
