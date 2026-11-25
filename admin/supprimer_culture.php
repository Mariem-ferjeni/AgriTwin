
<?php
require_once "../config/database.php";

// Vérifier que la demande vient d'un formulaire POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: cultures.php");
    exit;
}

// Récupérer l'identifiant
$id = $_POST['id'] ?? '';

if (!ctype_digit((string)$id)) {
    die("Identifiant invalide.");
}

$id = (int)$id;

// Vérifier que la culture existe
$check = $pdo->prepare(
    "SELECT id_culture FROM Culture WHERE id_culture = ?"
);
$check->execute([$id]);

if (!$check->fetch()) {
    die("Culture introuvable.");
}

// Supprimer la culture
$delete = $pdo->prepare(
    "DELETE FROM Culture WHERE id_culture = ?"
);
$delete->execute([$id]);

// Retourner à la liste
header("Location: cultures.php");
exit;
?>
