<?php
require_once __DIR__ . "/../app/bootstrap.php";
Auth::requireAdmin();

// Suppression autorisee uniquement par POST, avec jeton CSRF
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: cultures.php");
    exit;
}
Csrf::check();

$id = $_POST['id'] ?? '';
if (!ctype_digit((string) $id)) {
    flash('error', "Identifiant invalide.");
    header("Location: cultures.php");
    exit;
}
$id = (int) $id;

$requete = $pdo->prepare("SELECT id_culture FROM culture WHERE id_culture = ?");
$requete->execute([$id]);
if (!$requete->fetch()) {
    flash('error', "Culture introuvable.");
    header("Location: cultures.php");
    exit;
}

try {
    $suppression = $pdo->prepare("DELETE FROM culture WHERE id_culture = ?");
    $suppression->execute([$id]);
    flash('success', "Culture supprimé(e) avec succès. Les parcelles concernées sont conservées (sans culture).");
} catch (PDOException $e) {
    error_log($e->getMessage());
    flash('error', "Suppression impossible : des données y sont encore liées.");
}
header("Location: cultures.php");
exit;
