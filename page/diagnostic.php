<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

echo "<h1>DIAGNOSTIC AGRITWIN</h1>";

echo "<p>1. PHP fonctionne.</p>";

session_start();

if (!isset($_SESSION["user_id"])) {
    die("<p>ERREUR : utilisateur non connecté.</p>");
}

$user_id = $_SESSION["user_id"];

echo "<p>2. Utilisateur connecté : " . htmlspecialchars((string)$user_id) . "</p>";

try {

    require_once "../config/database.php";

    echo "<p>3. Connexion à la base de données réussie.</p>";

    $sql = "SELECT * FROM exploitations
            WHERE id = ? AND utilisateur_id = ?";

    $requete = $connexion->prepare($sql);

    $requete->execute([3, $user_id]);

    $exploitation = $requete->fetch(PDO::FETCH_ASSOC);

    if ($exploitation) {
        echo "<p>4. Exploitation trouvée !</p>";
        echo "<pre>";
        print_r($exploitation);
        echo "</pre>";
    } else {
        echo "<p>4. Exploitation introuvable pour cet utilisateur.</p>";
    }

} catch (Throwable $e) {

    echo "<h2>ERREUR DETECTEE</h2>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";

}

?>