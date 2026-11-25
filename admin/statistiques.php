
<?php
require_once "../config/database.php";

// Récupérer les statistiques réelles
$totalUtilisateurs = $pdo->query("SELECT COUNT(*) FROM Utilisateur")->fetchColumn();

$totalExploitations = $pdo->query("SELECT COUNT(*) FROM Exploitation")->fetchColumn();

$totalCultures = $pdo->query("SELECT COUNT(*) FROM Culture")->fetchColumn();

$totalConseils = $pdo->query("SELECT COUNT(*) FROM Conseil")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques - AgriTwin</title>

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

        .admin-container .topbar,
        .admin-container .content {
            width: 100%;
            box-sizing: border-box;
        }

        .statistics-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            margin-top: 25px;
        }

        .statistic-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #e5ebe6;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .statistic-card span {
            display: block;
            color: #718078;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .statistic-card strong {
            color: #245c3a;
            font-size: 30px;
        }

        @media (max-width: 650px) {
            .statistics-grid {
                grid-template-columns: 1fr;
            }
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

                <h2>Statistiques générales</h2>

                <p>Vue globale des données de la plateforme AgriTwin.</p>

                <div class="statistics-grid">

                    <div class="statistic-card">
                        <span>Nombre d'utilisateurs</span>
                        <strong><?= $totalUtilisateurs ?></strong>
                    </div>

                    <div class="statistic-card">
                        <span>Nombre d'exploitations</span>
                        <strong><?= $totalExploitations ?></strong>
                    </div>

                    <div class="statistic-card">
                        <span>Nombre de cultures</span>
                        <strong><?= $totalCultures ?></strong>
                    </div>

                    <div class="statistic-card">
                        <span>Nombre de conseils</span>
                        <strong><?= $totalConseils ?></strong>
                    </div>

                </div>

            </div>

        </section>

    </main>

</div>

<script src="../assets/js/admin.js"></script>

</body>
</html>
