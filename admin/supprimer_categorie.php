<?php
require_once __DIR__ . "/../app/bootstrap.php";
Auth::requireAdmin();

// Suppression autorisee uniquement par POST, avec jeton CSRF
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: categories.php");
    exit;
}
Csrf::check();

$id = $_POST['id'] ?? '';
if (!ctype_digit((string) $id)) {
    flash('error', "Identifiant invalide.");
    header("Location: categories.php");
    exit;
}
$id = (int) $id;

$requete = $pdo->prepare("SELECT id_categorie FROM categorie WHERE id_categorie = ?");
$requete->execute([$id]);
if (!$requete->fetch()) {
    flash('error', "Catégorie introuvable.");
    header("Location: categories.php");
    exit;
}

try {
    $suppression = $pdo->prepare("DELETE FROM categorie WHERE id_categorie = ?");
    $suppression->execute([$id]);
    flash('success', "Catégorie supprimé(e) avec succès. Les conseils concernés passent « sans catégorie ».");
} catch (PDOException $e) {
    error_log($e->getMessage());
    flash('error', "Suppression impossible : des données y sont encore liées.");
}
header("Location: categories.php");
exit;
