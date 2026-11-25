
<?php
require_once "../config/database.php";

// Vérifier que l'identifiant existe dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Identifiant utilisateur invalide.");
}

$id = (int) $_GET['id'];

// Récupérer les informations de l'utilisateur
$requete = $pdo->prepare("
    SELECT id_utilisateur, nom, prenom, email, telephone, role
    FROM Utilisateur
    WHERE id_utilisateur = ?
");

$requete->execute([$id]);
$user = $requete->fetch(PDO::FETCH_ASSOC);

// Vérifier que l'utilisateur existe
if (!$user) {
    die("Utilisateur introuvable.");
}

// Récupérer les exploitations de cet utilisateur
$requeteExploitations = $pdo->prepare("
    SELECT id_exploitation, nom, localisation, superficie_totale, description
    FROM Exploitation
    WHERE id_utilisateur = ?
");

$requeteExploitations->execute([$id]);
$exploitations = $requeteExploitations->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Détails utilisateur - AgriTwin</title>

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
        <h2>Détails de l'utilisateur</h2>
        <p style="color:#68766c; margin-top:8px;">
            Informations du compte et exploitations associées.
        </p>
    </div>

    <div>
        <a href="modifier_utilisateur.php?id=<?= $id ?>" class="view-button">
            ✎ Modifier
        </a>

        <form method="POST" action="supprimer_utilisateur.php"
              style="display:inline;"
              onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur et ses exploitations ? Cette action est irréversible.');">

            <input type="hidden" name="id" value="<?= $id ?>">

            <button type="submit" class="delete-button">
                🗑 Supprimer
            </button>

        </form>

        <a href="utilisateurs.php" class="view-button">
            ← Retour aux utilisateurs
        </a>
    </div>
</div>

            </div>

            <section class="panel">

                <h2 style="margin-bottom:20px;">Informations personnelles</h2>

                <div class="details-grid">

                    <div class="detail-item">
                        <span>Identifiant</span>
                        <strong><?= htmlspecialchars($user['id_utilisateur']) ?></strong>
                    </div>

                    <div class="detail-item">
                        <span>Nom</span>
                        <strong><?= htmlspecialchars($user['nom']) ?></strong>
                    </div>

                    <div class="detail-item">
                        <span>Prénom</span>
                        <strong><?= htmlspecialchars($user['prenom']) ?></strong>
                    </div>

                    <div class="detail-item">
                        <span>Email</span>
                        <strong><?= htmlspecialchars($user['email']) ?></strong>
                    </div>

                    <div class="detail-item">
                        <span>Téléphone</span>
                        <strong>
                            <?= htmlspecialchars($user['telephone'] ?: 'Non renseigné') ?>
                        </strong>
                    </div>

                    <div class="detail-item">
                        <span>Rôle</span>
                        <strong>
                            <span class="role-badge">
                                <?= htmlspecialchars($user['role']) ?>
                            </span>
                        </strong>
                    </div>

                </div>

            </section>

            <section class="panel">

                <div class="panel-heading">
                    <h2>Exploitations de l'utilisateur</h2>

                    <span class="role-badge">
                        <?= count($exploitations) ?> exploitation(s)
                    </span>
                </div>

                <?php if (count($exploitations) > 0): ?>

                    <div class="table-container">

                        <table>

                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Localisation</th>
                                    <th>Superficie (ha)</th>
                                    <th>Description</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php foreach ($exploitations as $exploitation): ?>

                                    <tr>
                                        <td>
                                            <?= htmlspecialchars($exploitation['nom']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($exploitation['localisation']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($exploitation['superficie_totale']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($exploitation['description'] ?? '') ?>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php else: ?>

                    <p class="empty-message">
                        Cet utilisateur ne possède aucune exploitation enregistrée.
                    </p>

                <?php endif; ?>

            </section>

        </section>

    </main>

</div>

<script src="../assets/js/admin.js"></script>

</body>
</html>
