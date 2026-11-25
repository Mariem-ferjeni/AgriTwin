
<?php
require_once "../config/database.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Identifiant culture invalide.");
}

$id = (int) $_GET['id'];

// Récupérer les informations de la culture
$requete = $pdo->prepare("
    SELECT *
    FROM Culture
    WHERE id_culture = ?
");

$requete->execute([$id]);
$culture = $requete->fetch(PDO::FETCH_ASSOC);

if (!$culture) {
    die("Culture introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Détails culture - AgriTwin</title>

    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

<div class="admin-layout">

    <?php include "../includes/sidebar.php"; ?>

    <main class="main-content">

        <?php include "../includes/header.php"; ?>

        <section class="dashboard-content">

            <div class="panel-heading">
                <div>
                    <h2>Détails de la culture</h2>
                    <p style="color:#68766c; margin-top:8px;">
                        Informations détaillées de la culture agricole.
                    </p>
                </div>

                
<div>
    
<div>
    <a href="modifier_culture.php?id=<?= $id ?>" class="view-button">
        ✎ Modifier
    </a>

    <form method="POST" action="supprimer_culture.php"
          style="display:inline;"
          onsubmit="return confirm('Voulez-vous vraiment supprimer cette culture ?');">

        <input type="hidden" name="id" value="<?= $id ?>">

        <button type="submit" class="delete-button">
            🗑 Supprimer
        </button>
    </form>

    <a href="cultures.php" class="view-button">
        ← Retour aux cultures
    </a>
</div>

</div>

            </div>

            <section class="panel">

                <h2 style="margin-bottom:20px;">Informations générales</h2>

                <div class="details-grid">

                    <div class="detail-item">
                        <span>Identifiant</span>
                        <strong><?= htmlspecialchars($culture['id_culture']) ?></strong>
                    </div>

                    <div class="detail-item">
                        <span>Nom de la culture</span>
                        <strong><?= htmlspecialchars($culture['nom']) ?></strong>
                    </div>

                    <div class="detail-item">
                        <span>Type de culture</span>
                        <strong><?= htmlspecialchars($culture['type_culture']) ?></strong>
                    </div>

                    <div class="detail-item">
                        <span>Variété</span>
                        <strong><?= htmlspecialchars($culture['variete'] ?: 'Non renseignée') ?></strong>
                    </div>

                    <div class="detail-item">
                        <span>Saison</span>
                        <strong><?= htmlspecialchars($culture['saison'] ?: 'Non renseignée') ?></strong>
                    </div>

                    <div class="detail-item">
                        <span>Durée du cycle</span>
                        <strong><?= htmlspecialchars($culture['duree_cycle'] ?? 'Non renseignée') ?> jours</strong>
                    </div>

                    <div class="detail-item">
                        <span>Description</span>
                        <strong><?= htmlspecialchars($culture['description'] ?: 'Aucune description') ?></strong>
                    </div>

                </div>

            </section>

        </section>

    </main>

</div>

<script src="../assets/js/admin.js"></script>

</body>
</html>
