
<?php
require_once "../config/database.php";

// Récupérer les utilisateurs
$requete = $pdo->query("
    SELECT id_utilisateur, nom, prenom, email, telephone, role
    FROM Utilisateur
    ORDER BY id_utilisateur DESC
");

$utilisateurs = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestion des utilisateurs - AgriTwin</title>

    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

<div class="admin-layout">

    <?php include "../includes/sidebar.php"; ?>

    <main class="main-content">

        <?php include "../includes/header.php"; ?>

        <section class="dashboard-content">

            <h2>Gestion des utilisateurs</h2>

            <p style="color:#68766c; margin-bottom:20px;">
                Consultez et gérez les comptes des utilisateurs de la plateforme.
            </p>

            <section class="panel">

                <div class="panel-heading">

                    <h2>Liste des utilisateurs</h2>

                    <span class="role-badge">
                        <?= count($utilisateurs) ?> utilisateur(s)
                    </span>

                </div>

                <div class="search-box" style="margin-bottom:20px; width:100%;">
                    <span>⌕</span>
                    <input
                        type="text"
                        id="userSearch"
                        placeholder="Rechercher par nom ou email..."
                        style="width:100%;">
                </div>

                <div class="table-container">

                    <table id="usersTable">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom et prénom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Rôle</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (count($utilisateurs) > 0): ?>

                                <?php foreach ($utilisateurs as $user): ?>

                                    <tr>

                                        <td>
                                            <?= htmlspecialchars($user['id_utilisateur']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($user['email']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($user['telephone'] ?? '') ?>
                                        </td>

                                        <td>
                                            <span class="role-badge">
                                                <?= htmlspecialchars($user['role']) ?>
                                            </span>
                                        </td>

                                        <td>
                                            <a
                                                href="details_utilisateur.php?id=<?= urlencode($user['id_utilisateur']) ?>"
                                                class="view-button">
                                                Voir détails
                                            </a>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="6" class="empty-message">
                                        Aucun utilisateur enregistré.
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
const userSearch = document.getElementById("userSearch");

userSearch.addEventListener("input", function () {

    const recherche = this.value.toLowerCase();

    document.querySelectorAll("#usersTable tbody tr").forEach(function(ligne) {

        ligne.style.display = ligne.textContent.toLowerCase().includes(recherche)
            ? ""
            : "none";

    });

});
</script>

</body>
</html>
