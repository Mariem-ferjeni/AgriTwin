<?php
require_once __DIR__ . "/../app/bootstrap.php";
Auth::requireAdmin();

// Nombre d'utilisateurs
$requeteUsers = $pdo->query("SELECT COUNT(*) FROM utilisateur");
$nombreUsers = $requeteUsers->fetchColumn();

// Nombre d'exploitations
$requeteExploitations = $pdo->query("SELECT COUNT(*) FROM exploitation");
$nombreExploitations = $requeteExploitations->fetchColumn();

// Liste des utilisateurs
$requeteListe = $pdo->query("
    SELECT id_utilisateur, nom, prenom, email, role
    FROM utilisateur
    ORDER BY id_utilisateur DESC
    LIMIT 5
");
$utilisateurs = $requeteListe->fetchAll(PDO::FETCH_ASSOC);

// Compteurs reels (corrige : les cartes Cultures et Conseils etaient figees a 0)
$nombreCultures = $pdo->query("SELECT COUNT(*) FROM culture")->fetchColumn();
$nombreConseils = $pdo->query("SELECT COUNT(*) FROM conseil WHERE statut = 'Publié'")->fetchColumn();

// Derniers conseils publies
$derniersConseils = $pdo->query("
    SELECT titre, contenu FROM conseil
    WHERE statut = 'Publié'
    ORDER BY date_publication DESC, id_conseil DESC
    LIMIT 2
")->fetchAll(PDO::FETCH_ASSOC);

// Inscriptions par mois (annee en cours)
$parMois = array_fill(1, 12, 0);
foreach ($pdo->query("SELECT MONTH(date_inscription) AS m, COUNT(*) AS n FROM utilisateur WHERE YEAR(date_inscription) = YEAR(CURDATE()) GROUP BY m") as $r) {
    $parMois[(int) $r['m']] = (int) $r['n'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - AgriTwin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body class="dashboard-page">

<div class="admin-layout">

    <?php include "../includes/sidebar.php"; ?>

    <main class="main-content">

        <?php include "../includes/header.php"; ?>

        <section class="dashboard-content">

            <h2>Vue d'ensemble de la plateforme</h2>

            <div class="stats-grid">

                <div class="stat-card">
                    <p>Utilisateurs</p>
                    <h3><?= $nombreUsers ?></h3>
                </div>

                <div class="stat-card green-card">
                    <p>Exploitations</p>
                    <h3><?= $nombreExploitations ?></h3>
                </div>

                <div class="stat-card light-green-card">
                    <p>Cultures référencées</p>
                    <h3><?= (int) $nombreCultures ?></h3>
                    <small>Catalogue des cultures</small>
                </div>

                <div class="stat-card">
                    <p>Conseils publiés</p>
                    <h3><?= (int) $nombreConseils ?></h3>
                    <small>Visibles sur le site</small>
                </div>

            </div>

            <section class="panel users-panel">

                <div class="panel-heading">
                    <h2>Gestion des utilisateurs</h2>
                    <a href="ajouter_utilisateur.php" class="primary-button">+ Ajouter un utilisateur</a>
                </div>

                <div class="table-container">
                    <table id="usersTable">

                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Identifiant</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (count($utilisateurs) > 0): ?>

                                <?php foreach ($utilisateurs as $user): ?>

                                    <tr>
                                        <td>
                                            <?= htmlspecialchars($user["prenom"] . " " . $user["nom"]) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($user["email"]) ?>
                                        </td>

                                        <td>
                                            <span class="role-badge">
                                                <?= htmlspecialchars($user["role"]) ?>
                                            </span>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($user["id_utilisateur"]) ?>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="4" class="empty-message">
                                        Aucun utilisateur enregistré.
                                    </td>
                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>
                </div>

            </section>

            <div class="bottom-grid">

                <section class="panel advice-panel">

                    <div class="panel-heading">
                        <div>
                            <small>Agricultural Advice Management</small>
                            <h2>Conseils agricoles</h2>
                        </div>

                        <a href="ajouter_conseil.php" class="primary-button">+ Ajouter un conseil</a>
                    </div>

                    <div class="advice-list">

                        <?php foreach ($derniersConseils as $c): ?>
                            <article class="advice-card">
                                <h3><?= htmlspecialchars($c['titre']) ?></h3>
                                <p><?= htmlspecialchars(mb_strimwidth($c['contenu'], 0, 140, '…')) ?></p>
                            </article>
                        <?php endforeach; ?>

                        <?php if (!$derniersConseils): ?>
                            <p class="empty-message">Aucun conseil publié pour le moment.</p>
                        <?php endif; ?>

                    </div>

                </section>

                <section class="panel analytics-panel">

                    <h2>Section statistiques</h2>

                    <p class="chart-description">
                        Nouvelles inscriptions par mois (année en cours)
                    </p>

                    <div class="chart">

                        <?php
                        $mois = [
                            "Jan", "Fév", "Mar", "Avr",
                            "Mai", "Juin", "Juil", "Août",
                            "Sep", "Oct", "Nov", "Déc"
                        ];

                        $valeurs = array_values($parMois);
                        $maxVal = max(1, max($valeurs));

                        foreach ($mois as $i => $m):
                        ?>

                            <div class="chart-column">
                                <div
                                    class="chart-bar"
                                    title="<?= $valeurs[$i] ?> inscription(s)"
                                    style="height: <?= max(4, (int) round($valeurs[$i] / $maxVal * 100)) ?>px">
                                </div>
                                <span><?= $m ?></span>
                            </div>

                        <?php endforeach; ?>

                    </div>

                    <small class="chart-note">
                        Données réelles : table utilisateur (date d'inscription).
                    </small>

                </section>

            </div>

        </section>

    </main>

</div>

<script src="../assets/js/admin.js"></script>

</body>
</html>
