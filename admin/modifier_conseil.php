
<?php
require_once "../config/database.php";

$id = $_GET['id'] ?? '';

if (!ctype_digit((string)$id)) {
    die("Identifiant invalide.");
}

$id = (int)$id;

$requete = $pdo->prepare("
    SELECT *
    FROM Conseil
    WHERE id_conseil = ?
");
$requete->execute([$id]);

$conseil = $requete->fetch(PDO::FETCH_ASSOC);

if (!$conseil) {
    die("Conseil introuvable.");
}

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titre = trim($_POST['titre'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');
    $categorie = trim($_POST['categorie'] ?? '');
    $date_publication = $_POST['date_publication'] ?? '';
    $statut = $_POST['statut'] ?? '';

    if ($titre === "" || $contenu === "") {
        $erreur = "Le titre et le contenu sont obligatoires.";
    } else {

        $update = $pdo->prepare("
            UPDATE Conseil
            SET titre = ?,
                contenu = ?,
                categorie = ?,
                date_publication = ?,
                statut = ?
            WHERE id_conseil = ?
        ");

        $update->execute([
            $titre,
            $contenu,
            $categorie,
            $date_publication !== '' ? $date_publication : null,
            $statut,
            $id
        ]);

        header("Location: details_conseil.php?id=" . $id);
        exit;
    }

    $conseil['titre'] = $titre;
    $conseil['contenu'] = $contenu;
    $conseil['categorie'] = $categorie;
    $conseil['date_publication'] = $date_publication;
    $conseil['statut'] = $statut;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un conseil - AgriTwin</title>

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

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #245c3a;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 11px;
            border: 1px solid #ddd;
            border-radius: 7px;
            box-sizing: border-box;
            font-family: inherit;
        }

        .form-group textarea {
            min-height: 130px;
            resize: vertical;
        }

        .save-button {
            background: #245c3a;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
        }

        .error-message {
            color: #c62828;
            margin-bottom: 15px;
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

                <h2>Modifier un conseil agricole</h2>

                <br>

                <?php if ($erreur !== ""): ?>
                    <p class="error-message">
                        <?= htmlspecialchars($erreur) ?>
                    </p>
                <?php endif; ?>

                <form method="POST">

                    <div class="form-group">
                        <label>Titre</label>
                        <input type="text" name="titre"
                               value="<?= htmlspecialchars($conseil['titre']) ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Catégorie</label>
                        <input type="text" name="categorie"
                               value="<?= htmlspecialchars($conseil['categorie'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label>Contenu</label>
                        <textarea name="contenu" required><?= htmlspecialchars($conseil['contenu']) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Date de publication</label>
                        <input type="date" name="date_publication"
                               value="<?= htmlspecialchars($conseil['date_publication'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label>Statut</label>
                        <select name="statut">
                            <option value="Publié"
                                <?= $conseil['statut'] == 'Publié' ? 'selected' : '' ?>>
                                Publié
                            </option>

                            <option value="Brouillon"
                                <?= $conseil['statut'] == 'Brouillon' ? 'selected' : '' ?>>
                                Brouillon
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="save-button">
                        Enregistrer les modifications
                    </button>

                    <a href="details_conseil.php?id=<?= $id ?>"
                       class="view-button">
                        Annuler
                    </a>

                </form>

            </div>

        </section>

    </main>

</div>

<script src="../assets/js/admin.js"></script>

</body>
</html>
