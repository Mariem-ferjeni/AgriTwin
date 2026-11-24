<?php
require_once __DIR__ . "/../app/bootstrap.php";
Auth::requireAdmin();
require_once __DIR__ . "/../includes/admin_layout.php";

$modele = new Utilisateur();
$d = ['nom' => '', 'prenom' => '', 'email' => '', 'telephone' => '', 'role' => 'agriculteur'];
$erreur = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    Csrf::check();
    foreach ($d as $k => $_) {
        $d[$k] = trim((string) ($_POST[$k] ?? ''));
    }
    $d['email'] = strtolower($d['email']);
    $mdp = (string) ($_POST['mot_de_passe'] ?? '');

    if (!Validator::length($d['nom'], 2, 100) || !Validator::length($d['prenom'], 2, 100)) {
        $erreur = "Le nom et le prénom doivent contenir entre 2 et 100 caractères.";
    } elseif (!Validator::email($d['email'])) {
        $erreur = "Adresse email invalide.";
    } elseif ($modele->emailTaken($d['email'])) {
        $erreur = "Un compte existe déjà avec cet email.";
    } elseif (!Validator::phone($d['telephone'])) {
        $erreur = "Numéro de téléphone invalide.";
    } elseif (!isset(Utilisateur::ROLES[$d['role']])) {
        $erreur = "Rôle invalide.";
    } elseif (!Validator::password($mdp)) {
        $erreur = "Le mot de passe doit contenir au moins 8 caractères, une lettre et un chiffre.";
    } else {
        $id = $modele->create($d + ['mot_de_passe' => $mdp]);
        flash('success', "Utilisateur créé avec succès.");
        header("Location: details_utilisateur.php?id=" . $id);
        exit;
    }
}

admin_head("Ajouter un utilisateur");
?>
            <h2>Ajouter un utilisateur</h2>
            <section class="panel">
                <?php if ($erreur !== ""): ?>
                    <p style="color:red; margin-bottom:15px;"><?= htmlspecialchars($erreur) ?></p>
                <?php endif; ?>
                <form method="POST">
                    <?= Csrf::field() ?>
                    <label>Nom *</label>
                    <input type="text" name="nom" value="<?= htmlspecialchars($d['nom']) ?>" required>
                    <label>Prénom *</label>
                    <input type="text" name="prenom" value="<?= htmlspecialchars($d['prenom']) ?>" required>
                    <label>Email *</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($d['email']) ?>" required>
                    <label>Téléphone</label>
                    <input type="text" name="telephone" value="<?= htmlspecialchars($d['telephone']) ?>">
                    <label>Rôle *</label>
                    <select name="role" required>
                        <?php foreach (Utilisateur::ROLES as $valeur => $libelle): ?>
                            <option value="<?= $valeur ?>" <?= $d['role'] === $valeur ? 'selected' : '' ?>><?= htmlspecialchars($libelle) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Mot de passe * (8 caractères minimum, une lettre et un chiffre)</label>
                    <input type="password" name="mot_de_passe" minlength="8" autocomplete="new-password" required>
                    <br><br>
                    <button type="submit" class="view-button">Créer l'utilisateur</button>
                    <a href="utilisateurs.php" style="margin-left:15px;">Annuler</a>
                </form>
            </section>
<?php admin_foot();
