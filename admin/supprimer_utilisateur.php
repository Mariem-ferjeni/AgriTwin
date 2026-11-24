<?php
require_once __DIR__ . "/../app/bootstrap.php";
Auth::requireAdmin();

// Suppression autorisee uniquement par POST, avec jeton CSRF
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: utilisateurs.php");
    exit;
}
Csrf::check();

$id = $_POST['id'] ?? '';
if (!ctype_digit((string) $id)) {
    flash('error', "Identifiant invalide.");
    header("Location: utilisateurs.php");
    exit;
}
$id = (int) $id;

$requete = $pdo->prepare("SELECT id_utilisateur FROM utilisateur WHERE id_utilisateur = ?");
$requete->execute([$id]);
if (!$requete->fetch()) {
    flash('error', "Utilisateur introuvable.");
    header("Location: utilisateurs.php");
    exit;
}
if ($id === (int) Auth::user()['id_utilisateur']) {
    flash('error', "Vous ne pouvez pas supprimer votre propre compte.");
    header("Location: utilisateurs.php");
    exit;
}
$cible = (new Utilisateur())->find($id);
if ($cible && $cible['role'] === 'admin' && (new Utilisateur())->countByRole('admin') <= 1) {
    flash('error', "Impossible de supprimer le dernier administrateur.");
    header("Location: utilisateurs.php");
    exit;
}

try {
    $suppression = $pdo->prepare("DELETE FROM utilisateur WHERE id_utilisateur = ?");
    $suppression->execute([$id]);
    flash('success', "Utilisateur supprimé(e) avec succès. Ses exploitations ont aussi été supprimées.");
} catch (PDOException $e) {
    error_log($e->getMessage());
    flash('error', "Suppression impossible : des données y sont encore liées.");
}
header("Location: utilisateurs.php");
exit;
