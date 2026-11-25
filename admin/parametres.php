
<?php
require_once "../config/database.php";

// Vérifier la connexion à la base de données
$etatConnexion = "Connectée";

try {
    $pdo->query("SELECT 1");
} catch (PDOException $e) {
    $etatConnexion = "Déconnectée";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paramètres - AgriTwin</title>

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

        .settings-card {
            background: white;
            border: 1px solid #e5ebe6;
            border-radius: 12px;
            padding: 22px;
            margin-top: 20px;
        }

        .settings-card h3 {
            color: #245c3a;
            margin-bottom: 18px;
        }

        .settings-item {
            padding: 14px 0;
            border-bottom: 1px solid #edf0ed;
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        .settings-item:last-child {
            border-bottom: none;
        }

        .settings-item span {
            color: #718078;
        }

        .settings-item strong {
            color: #245c3a;
            text-align: right;
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

                <h2>Paramètres de la plateforme</h2>

                <p>Informations générales sur AgriTwin.</p>

                <div class="settings-card">

                    <h3>Informations générales</h3>

                    <div class="settings-item">
                        <span>Nom de la plateforme</span>
                        <strong>AgriTwin</strong>
                    </div>

                    <div class="settings-item">
                        <span>Slogan</span>
                        <strong>Voir plus loin, cultiver mieux.</strong>
                    </div>

                    <div class="settings-item">
                        <span>Type de plateforme</span>
                        <strong>Gestion agricole</strong>
                    </div>

                    <div class="settings-item">
                        <span>Espace</span>
                        <strong>Back Office</strong>
                    </div>

                </div>

                <div class="settings-card">

                    <h3>Informations techniques</h3>

                    <div class="settings-item">
                        <span>Base de données</span>
                        <strong>MySQL</strong>
                    </div>

                    <div class="settings-item">
                        <span>Langage Backend</span>
                        <strong>PHP</strong>
                    </div>

                    <div class="settings-item">
                        <span>État de la connexion</span>
                        <strong><?= htmlspecialchars($etatConnexion) ?></strong>
                    </div>

                </div>

            </div>

        </section>

    </main>

</div>

<script src="../assets/js/admin.js"></script>

</body>
</html>
