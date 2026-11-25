
<?php
require_once "../config/database.php";

// Vérifier la méthode de la requête
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: conseils.php");
    exit;
}

// Vérifier l'identifiant
$id = $_POST['id'] ?? '';

if (!ctype_digit((string)$id)) {
    die("Identifiant invalide.");
}

$id = (int)$id;

// Vérifier que le conseil existe
$check = $pdo->prepare("
    SELECT id_conseil
    FROM Conseil
    WHERE id_conseil = ?
");

$check->execute([$id]);

if (!$check->fetch()) {
    die("Conseil introuvable.");
}

// Supprimer le conseil
$delete = $pdo->prepare("
    DELETE FROM Conseil
    WHERE id_conseil = ?
");

$delete->execute([$id]);

header("Location: conseils.php");
exit;
?>
