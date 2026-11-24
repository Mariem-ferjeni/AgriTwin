<?php
require_once __DIR__ . "/../app/bootstrap.php";
Auth::requireAdmin();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Identifiant invalide.");
}

$id = (int) $_GET['id'];
$erreur = "";

// Récupérer la culture
$requete = $pdo->prepare("
    SELECT *
    FROM culture
    WHERE id_culture = ?
");

$requete->execute([$id]);
$culture = $requete->fetch(PDO::FETCH_ASSOC);

if (!$culture) {
    die("Culture introuvable.");
}

// Traiter le formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    Csrf::check();

    $nom = trim($_POST['nom'] ?? '');
    $type_culture = trim($_POST['type_culture'] ?? '');
    $variete = trim($_POST['variete'] ?? '');
    $saison = trim($_POST['saison'] ?? '');
    $duree_cycle = $_POST['duree_cycle'] ?? '';
    $description = trim($_POST['description'] ?? '');

    if (
        $nom === "" ||
        $type_culture === "" ||
        $duree_cycle === "" ||
        !ctype_digit((string) $duree_cycle) ||
        (int) $duree_cycle <= 0
    ) {
        $erreur = "Veuillez vérifier les champs obligatoires.";
    } else {

        $update = $pdo->prepare("
            UPDATE culture
            SET nom = ?,
                type_culture = ?,
                variete = ?,
                saison = ?,
                duree_cycle = ?,
                description = ?
            WHERE id_culture = ?
        ");

        $update->execute([
            $nom,
            $type_culture,
            $variete,
            $saison,
            $duree_cycle,
            $description,
            $id
        ]);

        flash('success', "Modifications enregistrées.");
        header("Location: details_culture.php?id=" . $id);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Modifier culture - AgriTwin</title>

    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

<div class="admin-layout">

    <?php include "../includes/sidebar.php"; ?>

    <main class="main-content">

        <?php include "../includes/header.php"; ?>

        <section class="dashboard-content">

            <h2>Modifier une culture</h2>

            <section class="panel">

                <?php if ($erreur !== ""): ?>
                    <p style="color:red; margin-bottom:15px;">
                        <?= htmlspecialchars($erreur) ?>
                    </p>
                <?php endif; ?>

                <form method="POST">
<?= Csrf::field() ?>

                    <label>Nom de la culture *</label>
                    <input type="text" name="nom"
                        value="<?= htmlspecialchars($culture['nom']) ?>"
                        required>

                    <label>Type de culture *</label>
                    <input type="text" name="type_culture"
                        value="<?= htmlspecialchars($culture['type_culture']) ?>"
                        required>

                    <label>Variété</label>
                    <input type="text" name="variete"
                        value="<?= htmlspecialchars($culture['variete'] ?? '') ?>">

                    <label>Saison</label>
                    <input type="text" name="saison"
                        value="<?= htmlspecialchars($culture['saison'] ?? '') ?>">

                    <label>Durée du cycle (jours) *</label>
                    <input type="number" name="duree_cycle"
                        min="1"
                        value="<?= htmlspecialchars($culture['duree_cycle'] ?? '') ?>"
                        required>

                    <label>Description</label>
                    <textarea name="description" rows="4"><?= htmlspecialchars($culture['description'] ?? '') ?></textarea>

                    <br><br>

                    <button type="submit" class="view-button">
                        Enregistrer les modifications
                    </button>

                    <a href="details_culture.php?id=<?= $id ?>"
                       class="view-button">
                        Annuler
                    </a>

                </form>

            </section>

        </section>

    </main>

</div>

</body>
</html>
