
<?php
session_start();
require_once "../config/database.php";

// Vérifier l'identifiant
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Identifiant invalide.");
}

$id = (int) $_GET['id'];
$erreur = "";

// Récupérer l'utilisateur
$requete = $pdo->prepare("
    SELECT * FROM Utilisateur
    WHERE id_utilisateur = ?
");
$requete->execute([$id]);
$user = $requete->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Utilisateur introuvable.");
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $role = trim($_POST['role'] ?? '');

    if ($nom === "" || $prenom === "" || $email === "" || $role === "") {
        $erreur = "Veuillez remplir tous les champs obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse email invalide.";
    } else {
        try {
            $update = $pdo->prepare("
                UPDATE Utilisateur
                SET nom = ?, prenom = ?, email = ?, telephone = ?, role = ?
                WHERE id_utilisateur = ?
            ");

            $update->execute([
                $nom,
                $prenom,
                $email,
                $telephone,
                $role,
                $id
            ]);

            header("Location: details_utilisateur.php?id=" . $id);
            exit;

        } catch (PDOException $e) {
            $erreur = "Erreur : cet email est peut-être déjà utilisé.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier utilisateur - AgriTwin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

<div class="admin-layout">

    <?php include "../includes/sidebar.php"; ?>

    <main class="main-content">

        <?php include "../includes/header.php"; ?>

        <section class="dashboard-content">

            <h2>Modifier un utilisateur</h2>

            <section class="panel">

                <?php if ($erreur !== ""): ?>
                    <p style="color:red; margin-bottom:15px;">
                        <?= htmlspecialchars($erreur) ?>
                    </p>
                <?php endif; ?>

                <form method="POST">

                    <label>Nom *</label>
                    <input type="text" name="nom"
                        value="<?= htmlspecialchars($user['nom']) ?>"
                        required>

                    <label>Prénom *</label>
                    <input type="text" name="prenom"
                        value="<?= htmlspecialchars($user['prenom']) ?>"
                        required>

                    <label>Email *</label>
                    <input type="email" name="email"
                        value="<?= htmlspecialchars($user['email']) ?>"
                        required>

                    <label>Téléphone</label>
                    <input type="text" name="telephone"
                        value="<?= htmlspecialchars($user['telephone'] ?? '') ?>">

                    <label>Rôle *</label>
                    <select name="role" required>
                        <option value="utilisateur"
                            <?= $user['role'] === 'utilisateur' ? 'selected' : '' ?>>
                            Utilisateur
                        </option>

                        <option value="admin"
                            <?= $user['role'] === 'admin' ? 'selected' : '' ?>>
                            Administrateur
                        </option>
                    </select>

                    <br><br>

                    <button type="submit" class="view-button">
                        Enregistrer les modifications
                    </button>

                    <a href="details_utilisateur.php?id=<?= $id ?>"
                       class="view-button">
                        Annuler
                    </a>

                </form>

            </section>

        </section>

    </main>

</div>

</body>
</html>
