
<?php
require_once "../config/database.php";

// Nombre d'utilisateurs
$requeteUsers = $pdo->query("SELECT COUNT(*) FROM Utilisateur");
$nombreUsers = $requeteUsers->fetchColumn();

// Nombre d'exploitations
$requeteExploitations = $pdo->query("SELECT COUNT(*) FROM Exploitation");
$nombreExploitations = $requeteExploitations->fetchColumn();

// Liste des utilisateurs
$requeteListe = $pdo->query("
    SELECT id_utilisateur, nom, prenom, email, role
    FROM Utilisateur
    ORDER BY id_utilisateur DESC
    LIMIT 5
");
$utilisateurs = $requeteListe->fetchAll(PDO::FETCH_ASSOC);
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
                    <h3>0</h3>
                    <small>En attente du module cultures</small>
                </div>

                <div class="stat-card">
                    <p>Conseils publiés</p>
                    <h3>0</h3>
                    <small>En attente du module conseils</small>
                </div>

            </div>

            <section class="panel users-panel">

                <div class="panel-heading">
                    <h2>Gestion des utilisateurs</h2>
                    <button class="primary-button" disabled>
                        Ajouter un utilisateur
                    </button>
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

                        <button class="primary-button" disabled>
                            Ajouter un conseil
                        </button>
                    </div>

                    <div class="advice-list">

                        <article class="advice-card">
                            <h3>Gestion responsable de l'eau</h3>
                            <p>
                                Privilégier une irrigation adaptée
                                aux besoins des cultures.
                            </p>
                        </article>

                        <article class="advice-card">
                            <h3>Choix des cultures selon le climat</h3>
                            <p>
                                Choisir des cultures adaptées
                                aux conditions climatiques locales.
                            </p>
                        </article>

                    </div>

                </section>

                <section class="panel analytics-panel">

                    <h2>Section statistiques</h2>

                    <p class="chart-description">
                        Exemple de représentation mensuelle
                    </p>

                    <div class="chart">

                        <?php
                        $mois = [
                            "Jan", "Fév", "Mar", "Avr",
                            "Mai", "Juin", "Juil", "Août",
                            "Sep", "Oct", "Nov", "Déc"
                        ];

                        $valeurs = [20, 26, 34, 23, 35, 23, 28, 22, 34, 17, 30, 10];

                        foreach ($mois as $i => $m):
                        ?>

                            <div class="chart-column">
                                <div
                                    class="chart-bar"
                                    style="height: <?= $valeurs[$i] * 3 ?>px">
                                </div>
                                <span><?= $m ?></span>
                            </div>

                        <?php endforeach; ?>

                    </div>

                    <small class="chart-note">
                        Données illustratives, à remplacer par les statistiques réelles.
                    </small>

                </section>

            </div>

        </section>

    </main>

</div>

<script src="../assets/js/admin.js"></script>

</body>
</html>
