<?php
require_once __DIR__ . "/../app/bootstrap.php";
Auth::requireAdmin();

$requete = $pdo->query("
    SELECT c.*, k.nom_categorie AS categorie
    FROM conseil c
    LEFT JOIN categorie k ON k.id_categorie = c.id_categorie
    ORDER BY c.id_conseil DESC
");

$conseils = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des conseils - AgriTwin</title>

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

                <h2>Gestion des conseils agricoles</h2>

                <p>Liste des conseils agricoles enregistrés.</p>
                <p style="margin-top:12px"><a href="ajouter_conseil.php" class="primary-button">+ Ajouter un conseil</a></p>

                <br>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Catégorie</th>
                            <th>Date de publication</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($conseils as $conseil): ?>

                        <tr>
                            <td><?= $conseil['id_conseil'] ?></td>

                            <td><?= htmlspecialchars($conseil['titre']) ?></td>

                            <td><?= htmlspecialchars($conseil['categorie'] ?? '') ?></td>

                            <td><?= htmlspecialchars($conseil['date_publication'] ?? '') ?></td>

                            <td><?= htmlspecialchars($conseil['statut'] ?? '') ?></td>

                            <td>
                                <a href="details_conseil.php?id=<?= $conseil['id_conseil'] ?>"
                                   class="view-button">
                                    Voir détails
                                </a>
                            </td>
                        </tr>

                        <?php endforeach; ?>

                        <?php if (empty($conseils)): ?>
                        <tr>
                            <td colspan="6">Aucun conseil enregistré.</td>
                        </tr>
                        <?php endif; ?>

                    </tbody>
                </table>

            </div>

        </section>

    </main>

</div>

<script src="../assets/js/admin.js"></script>

</body>
</html>
