<?php
require_once __DIR__ . "/../app/bootstrap.php";
Auth::requireAdmin();

// Suppression autorisee uniquement par POST, avec jeton CSRF
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: conseils.php");
    exit;
}
Csrf::check();

$id = $_POST['id'] ?? '';
if (!ctype_digit((string) $id)) {
    flash('error', "Identifiant invalide.");
    header("Location: conseils.php");
    exit;
}
$id = (int) $id;

$requete = $pdo->prepare("SELECT id_conseil FROM conseil WHERE id_conseil = ?");
$requete->execute([$id]);
if (!$requete->fetch()) {
    flash('error', "Conseil introuvable.");
    header("Location: conseils.php");
    exit;
}

try {
    $suppression = $pdo->prepare("DELETE FROM conseil WHERE id_conseil = ?");
    $suppression->execute([$id]);
    flash('success', "Conseil supprimé(e) avec succès.");
} catch (PDOException $e) {
    error_log($e->getMessage());
    flash('error', "Suppression impossible : des données y sont encore liées.");
}
header("Location: conseils.php");
exit;
