
<?php
require_once "../config/database.php";

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = trim($_POST["nom_categorie"] ?? "");
    $description = trim($_POST["description"] ?? "");

    if ($nom === "") {
        $erreur = "Le nom de la catégorie est obligatoire.";
    } else {
        try {
            $requete = $pdo->prepare("
                INSERT INTO Categorie (nom_categorie, description)
                VALUES (?, ?)
            ");

            $requete->execute([$nom, $description]);

            header("Location: categories.php");
            exit;

        } catch (PDOException $e) {
            $erreur = "Cette catégorie existe déjà ou une erreur est survenue.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une catégorie - AgriTwin</title>
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

        .category-form {
            max-width: 650px;
            background: white;
            padding: 25px;
            border-radius: 12px;
        }

        .category-form label {
            display: block;
            margin: 15px 0 7px;
            font-weight: bold;
        }

        .category-form input,
        .category-form textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 7px;
            box-sizing: border-box;
        }

        .category-form textarea {
            min-height: 120px;
            resize: vertical;
        }

        .save-button {
            margin-top: 20px;
            padding: 11px 20px;
            background: #245c3a;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
        }

        .error-message {
            color: #c62828;
            margin-top: 12px;
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
                <h1>Ajouter une catégorie</h1>
                <p>Créer une nouvelle catégorie agricole.</p>
            </div>

            <div class="category-form">

                <form method="POST">

                    <label>Nom de la catégorie</label>
                    <input
                        type="text"
                        name="nom_categorie"
                        placeholder="Exemple : Irrigation"
                        required
                    >

                    <label>Description</label>
                    <textarea
                        name="description"
                        placeholder="Décrire cette catégorie..."
                    ></textarea>

                    <?php if ($erreur !== ""): ?>
                        <p class="error-message">
                            <?= htmlspecialchars($erreur) ?>
                        </p>
                    <?php endif; ?>

                    <button type="submit" class="save-button">
                        Enregistrer la catégorie
                    </button>

                    <a href="categories.php" class="view-button">
                        Retour
                    </a>

                </form>

            </div>

        </section>

    </main>

</div>

<script src="../assets/js/admin.js"></script>

</body>
</html>
