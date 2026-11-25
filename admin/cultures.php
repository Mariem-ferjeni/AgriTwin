
<?php
require_once "../config/database.php";

// Récupérer toutes les cultures
$requete = $pdo->query("
    SELECT *
    FROM Culture
    ORDER BY id_culture DESC
");

$cultures = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestion des cultures - AgriTwin</title>

    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

<div class="admin-layout">

    <?php include "../includes/sidebar.php"; ?>

    <main class="main-content">

        <?php include "../includes/header.php"; ?>

        <section class="dashboard-content">

            <h2>Gestion des cultures</h2>

            <p style="color:#68766c; margin-bottom:20px;">
                Consultez et gérez le catalogue des cultures agricoles.
            </p>

            <section class="panel">

                <div class="panel-heading">

                    <h2>Liste des cultures</h2>

                    <span class="role-badge">
                        <?= count($cultures) ?> culture(s)
                    </span>

                </div>

                <div class="search-box" style="margin-bottom:20px; width:100%;">
                    <span>⌕</span>

                    <input
                        type="text"
                        id="cultureSearch"
                        placeholder="Rechercher une culture..."
                        style="width:100%;">
                </div>

                <div class="table-container">

                    <table id="culturesTable">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Type</th>
                                <th>Variété</th>
                                <th>Saison</th>
                                <th>Durée du cycle (jours)</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (count($cultures) > 0): ?>

                                <?php foreach ($cultures as $culture): ?>

                                    <tr>

                                        <td>
                                            <?= htmlspecialchars($culture['id_culture']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($culture['nom']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($culture['type_culture']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($culture['variete'] ?? '') ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($culture['saison'] ?? '') ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($culture['duree_cycle'] ?? '') ?>
                                        </td>

                                        <td>
                                            <a href="details_culture.php?id=<?= urlencode($culture['id_culture']) ?>"
                                               class="view-button">
                                                Voir détails
                                            </a>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="7" class="empty-message">
                                        Aucune culture enregistrée.
                                    </td>
                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </section>

        </section>

    </main>

</div>

<script src="../assets/js/admin.js"></script>

<script>
const cultureSearch = document.getElementById("cultureSearch");

cultureSearch.addEventListener("input", function () {

    const recherche = this.value.toLowerCase();

    document.querySelectorAll("#culturesTable tbody tr").forEach(function(ligne) {

        ligne.style.display = ligne.textContent.toLowerCase().includes(recherche)
            ? ""
            : "none";

    });

});
</script>

</body>
</html>
