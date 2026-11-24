<?php
require_once __DIR__ . "/../app/bootstrap.php";
Auth::requireAdmin();

$requete = $pdo->query("
    SELECT *
    FROM categorie
    ORDER BY id_categorie DESC
");

$categories = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des catégories - AgriTwin</title>

    <link rel="stylesheet" href="../assets/css/admin.css">

    <style>
        .admin-container {
            display: flex !important;
            flex-direction: row !important;
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

        .admin-container .topbar,
        .admin-container .content {
            width: 100%;
            box-sizing: border-box;
        }

        .categories-table {
            width: 100%;
            border-collapse: collapse;
        }

        .categories-table th,
        .categories-table td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #e5ebe6;
        }

        .categories-table th {
            background: #f5f8f5;
            color: #245c3a;
        }

        .add-category {
            display: inline-block;
            background: #245c3a;
            color: white;
            padding: 11px 18px;
            border-radius: 7px;
            text-decoration: none;
            font-weight: bold;
        }

/* ESPACEMENT FORCE DE LA PAGE CATEGORIES */

.main-content section.content {
    padding: 45px 30px 30px !important;
    box-sizing: border-box !important;
}

.main-content section.content .page-heading {
    display: block !important;
    margin: 20px 0 35px !important;
    padding: 28px 30px !important;
    background: #e3f0e4 !important;
    border-left: 5px solid #245c3a !important;
    border-radius: 12px !important;
    box-sizing: border-box !important;
}

.main-content section.content .page-heading h1 {
    margin: 0 0 18px 0 !important;
    padding: 0 !important;
    line-height: 1.5 !important;
}

.main-content section.content .page-heading p {
    margin: 0 !important;
    padding: 0 !important;
    line-height: 1.8 !important;
}

    </style>
</head>

<body>

<div class="admin-container">

    <?php include "../includes/sidebar.php"; ?>

    <main class="main-content">

        <?php include "../includes/header.php"; ?>

        <section class="content">

            <div class="page-heading">
                <div>
                    <h1>Gestion des catégories</h1>
                    <p>Consulter et gérer les catégories agricoles.</p>
                </div>
            </div>

            <div class="panel">

                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">

                    <h2>Liste des catégories</h2>

                    <a href="ajouter_categorie.php" class="add-category">
                        + Ajouter une catégorie
                    </a>

                </div>

                <div class="table-container">

                    <table class="categories-table">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom de la catégorie</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (count($categories) > 0): ?>

                                <?php foreach ($categories as $categorie): ?>

                                    <tr>
                                        <td>
                                            <?= htmlspecialchars($categorie['id_categorie']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($categorie['nom_categorie']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($categorie['description'] ?? '') ?>
                                        </td>

                                        <td><div style="display:flex; gap:8px;">

<a
    href="modifier_categorie.php?id=<?= (int)$categorie['id_categorie'] ?>"
    class="view-button">
    Modifier
</a>

<form method="POST" action="supprimer_categorie.php"
      onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">
<?= Csrf::field() ?>

    <input type="hidden" name="id"
           value="<?= (int)$categorie['id_categorie'] ?>">

    <button type="submit" class="delete-button">
        Supprimer
    </button>

</form>

</div></td>
                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="4">Aucune catégorie enregistrée.</td>
                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </section>

    </main>

</div>

<script src="../assets/js/admin.js"></script>

</body>
</html>
