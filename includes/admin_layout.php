<?php
/** Gabarit commun des NOUVELLES pages du Back Office (même structure et même design que les pages existantes). */
function admin_head(string $titre): void
{ ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre) ?> - AgriTwin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
<div class="admin-layout">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="main-content">
        <?php include __DIR__ . '/header.php'; ?>
        <section class="dashboard-content">
<?php }

function admin_foot(): void
{ ?>
        </section>
    </main>
</div>
<script src="../assets/js/admin.js"></script>
</body>
</html>
<?php }
