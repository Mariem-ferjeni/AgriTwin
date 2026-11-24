<?php
require_once __DIR__ . "/../app/bootstrap.php";
Auth::requireAdmin();

$id = $_GET['id'] ?? '';

if (!ctype_digit((string)$id)) {
    die("Identifiant invalide.");
}

$id = (int)$id;

$requete = $pdo->prepare("
    SELECT c.*, k.nom_categorie AS categorie
    FROM conseil c
    LEFT JOIN categorie k ON k.id_categorie = c.id_categorie
    WHERE c.id_conseil = ?
");

$requete->execute([$id]);

$conseil = $requete->fetch(PDO::FETCH_ASSOC);

if (!$conseil) {
    die("Conseil introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du conseil - AgriTwin</title>

    <link rel="stylesheet" href="../assets/css/admin.css">

    <style>
        .admin-container {
            display: flex !important;
            align-items: stretch !important;
            min-height: 100vh;
            width: 100%;
        }

        .admin-container .sidebar {
            flex: 0 0 260px;
            width: 260px;
            min-height: 100vh;
            position: relative;
        }

        .admin-container .main-content {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .admin-container .topbar {
            width: 100%;
            box-sizing: border-box;
        }

        .admin-container .content {
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>

<body>

<div class="admin-container">

    <?php include "../includes/sidebar.php"; ?>

    <main class="main-content">

        <?php include "../includes/header.php"; ?>

        <section class="content">

            <div class="panel">

                <h2>Détails du conseil agricole</h2>

                <br>

                <div class="details-grid">

                    <div class="detail-item">
                        <span>Identifiant</span>
                        <strong><?= $conseil['id_conseil'] ?></strong>
                    </div>

                    <div class="detail-item">
                        <span>Titre</span>
                        <strong><?= htmlspecialchars($conseil['titre']) ?></strong>
                    </div>

                    <div class="detail-item">
                        <span>Catégorie</span>
                        <strong><?= htmlspecialchars($conseil['categorie'] ?? '') ?></strong>
                    </div>

                    <div class="detail-item">
                        <span>Date de publication</span>
                        <strong><?= htmlspecialchars($conseil['date_publication'] ?? '') ?></strong>
                    </div>

                    <div class="detail-item">
                        <span>Statut</span>
                        <strong><?= htmlspecialchars($conseil['statut'] ?? '') ?></strong>
                    </div>

                    <div class="detail-item">
                        <span>Contenu</span>
                        <strong><?= nl2br(htmlspecialchars($conseil['contenu'])) ?></strong>
                    </div>

                </div>

                <br>

              

                <div>
    <a href="modifier_conseil.php?id=<?= $id ?>" class="view-button">
        ✎ Modifier
    </a>

    <form method="POST" action="supprimer_conseil.php"
          style="display:inline;"
          onsubmit="return confirm('Voulez-vous vraiment supprimer ce conseil ?');">
<?= Csrf::field() ?>

        <input type="hidden" name="id" value="<?= $id ?>">

        <button type="submit" class="delete-button">
            🗑 Supprimer
        </button>
    </form>

    <a href="conseils.php" class="view-button">
        ← Retour aux conseils
    </a>
</div>



            </div>

        </section>

    </main>

</div>

<script src="../assets/js/admin.js"></script>

</body>
</html>
