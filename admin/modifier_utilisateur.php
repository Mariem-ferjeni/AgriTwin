<?php
require_once __DIR__ . "/../app/bootstrap.php";
Auth::requireAdmin();

// Vérifier l'identifiant
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Identifiant invalide.");
}

$id = (int) $_GET['id'];
$erreur = "";

// Récupérer l'utilisateur
$requete = $pdo->prepare("
    SELECT * FROM utilisateur
    WHERE id_utilisateur = ?
");
$requete->execute([$id]);
$user = $requete->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Utilisateur introuvable.");
}

// Traitement du formulaire
$roles = Utilisateur::ROLES;
$modele = new Utilisateur();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    Csrf::check();

    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $nouveauMdp = $_POST['nouveau_mot_de_passe'] ?? '';
    $monId = (int) Auth::user()['id_utilisateur'];

    if ($nom === "" || $prenom === "" || $email === "" || $role === "") {
        $erreur = "Veuillez remplir tous les champs obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse email invalide.";
    } elseif (!isset($roles[$role])) {
        $erreur = "Rôle invalide.";
    } elseif ($id === $monId && $role !== 'admin') {
        $erreur = "Vous ne pouvez pas retirer votre propre rôle administrateur.";
    } elseif ($user['role'] === 'admin' && $role !== 'admin' && $modele->countByRole('admin') <= 1) {
        $erreur = "Impossible de retirer le rôle du dernier administrateur.";
    } elseif ($nouveauMdp !== '' && !Validator::password($nouveauMdp)) {
        $erreur = "Le nouveau mot de passe doit contenir au moins 8 caractères, une lettre et un chiffre.";
    } elseif ($modele->emailTaken($email, $id)) {
        $erreur = "Cet email est déjà utilisé par un autre compte.";
    } else {
        try {
            $modele->update($id, ['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'telephone' => $telephone, 'role' => $role]);
            if ($nouveauMdp !== '') {
                $modele->updatePassword($id, $nouveauMdp);
            }
            flash('success', "Utilisateur mis à jour.");
            header("Location: details_utilisateur.php?id=" . $id);
            exit;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $erreur = "Erreur lors de l'enregistrement.";
        }
    }
    // reafficher les valeurs saisies
    $user = array_merge($user, ['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'telephone' => $telephone, 'role' => $role]);
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
<?= Csrf::field() ?>

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
                        <?php foreach ($roles as $valeur => $libelle): ?>
                            <option value="<?= $valeur ?>" <?= $user['role'] === $valeur ? 'selected' : '' ?>>
                                <?= htmlspecialchars($libelle) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label>Nouveau mot de passe (laisser vide pour ne pas le changer)</label>
                    <input type="password" name="nouveau_mot_de_passe" minlength="8" autocomplete="new-password">

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
