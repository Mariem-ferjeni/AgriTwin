<?php
require_once __DIR__ . "/../app/bootstrap.php";
Auth::requireAdmin();
require_once __DIR__ . "/../includes/admin_layout.php";

$categories = (new Categorie())->all();
$d = ['titre' => '', 'contenu' => '', 'id_categorie' => '', 'date_publication' => date('Y-m-d'), 'statut' => 'Publié'];
$erreur = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    Csrf::check();
    foreach ($d as $k => $_) {
        $d[$k] = trim((string) ($_POST[$k] ?? ''));
    }
    $ids = array_map('strval', array_column($categories, 'id_categorie'));

    if (!Validator::length($d['titre'], 3, 150)) {
        $erreur = "Le titre doit contenir entre 3 et 150 caractères.";
    } elseif (!Validator::length($d['contenu'], 10, 10000)) {
        $erreur = "Le contenu doit contenir au moins 10 caractères.";
    } elseif ($d['id_categorie'] !== '' && !in_array($d['id_categorie'], $ids, true)) {
        $erreur = "Catégorie inconnue.";
    } elseif (!Validator::date($d['date_publication'])) {
        $erreur = "Date de publication invalide.";
    } elseif (!in_array($d['statut'], ['Publié', 'Brouillon'], true)) {
        $erreur = "Statut invalide.";
    } else {
        $id = (new Conseil())->create([
            'titre' => $d['titre'], 'contenu' => $d['contenu'],
            'id_categorie' => $d['id_categorie'] === '' ? null : (int) $d['id_categorie'],
            'date_publication' => $d['date_publication'], 'statut' => $d['statut'],
        ]);
        flash('success', "Conseil enregistré (" . $d['statut'] . ").");
        header("Location: details_conseil.php?id=" . $id);
        exit;
    }
}

admin_head("Ajouter un conseil");
?>
            <h2>Ajouter un conseil</h2>
            <section class="panel">
                <?php if ($erreur !== ""): ?>
                    <p style="color:red; margin-bottom:15px;"><?= htmlspecialchars($erreur) ?></p>
                <?php endif; ?>
                <form method="POST">
                    <?= Csrf::field() ?>
                    <label>Titre *</label>
                    <input type="text" name="titre" maxlength="150" value="<?= htmlspecialchars($d['titre']) ?>" required>
                    <label>Catégorie</label>
                    <select name="id_categorie">
                        <option value="">— Sans catégorie —</option>
                        <?php foreach ($categories as $c): ?>
                            <option value="<?= (int) $c['id_categorie'] ?>" <?= (string) $d['id_categorie'] === (string) $c['id_categorie'] ? 'selected' : '' ?>><?= htmlspecialchars($c['nom_categorie']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Contenu *</label>
                    <textarea name="contenu" rows="7" required><?= htmlspecialchars($d['contenu']) ?></textarea>
                    <label>Date de publication *</label>
                    <input type="date" name="date_publication" value="<?= htmlspecialchars($d['date_publication']) ?>" required>
                    <label>Statut *</label>
                    <select name="statut">
                        <option value="Publié" <?= $d['statut'] === 'Publié' ? 'selected' : '' ?>>Publié (visible sur le site)</option>
                        <option value="Brouillon" <?= $d['statut'] === 'Brouillon' ? 'selected' : '' ?>>Brouillon (non visible)</option>
                    </select>
                    <br><br>
                    <button type="submit" class="view-button">Enregistrer le conseil</button>
                    <a href="conseils.php" style="margin-left:15px;">Annuler</a>
                </form>
            </section>
<?php admin_foot();
