
<?php
session_start();
require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: utilisateurs.php");
    exit;
}

$id = $_POST['id'] ?? '';

if (!ctype_digit((string) $id)) {
    die("Identifiant invalide.");
}

$id = (int) $id;

// Vérifier que l'utilisateur existe
$requete = $pdo->prepare("
    SELECT id_utilisateur
    FROM Utilisateur
    WHERE id_utilisateur = ?
");
$requete->execute([$id]);

if (!$requete->fetch()) {
    die("Utilisateur introuvable.");
}

// Supprimer l'utilisateur
// Les exploitations associées seront supprimées grâce à ON DELETE CASCADE
$suppression = $pdo->prepare("
    DELETE FROM Utilisateur
    WHERE id_utilisateur = ?
");
$suppression->execute([$id]);

header("Location: utilisateurs.php");
exit;
?>
