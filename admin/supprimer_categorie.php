
<?php
require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: categories.php");
    exit;
}

if (!isset($_POST["id"]) || !is_numeric($_POST["id"])) {
    header("Location: categories.php");
    exit;
}

$id = (int) $_POST["id"];

$requete = $pdo->prepare("
    DELETE FROM Categorie
    WHERE id_categorie = ?
");

$requete->execute([$id]);

header("Location: categories.php");
exit;
?>
