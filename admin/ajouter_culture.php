<?php
require_once __DIR__ . "/../app/bootstrap.php";
Auth::requireAdmin();
require_once __DIR__ . "/../includes/admin_layout.php";

$types = (new Culture())->types();
$d = ['nom' => '', 'type_culture' => '', 'variete' => '', 'saison' => '', 'duree_cycle' => '', 'description' => ''];
$erreur = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    Csrf::check();
    foreach ($d as $k => $_) {
        $d[$k] = trim((string) ($_POST[$k] ?? ''));
    }
    if (!Validator::length($d['nom'], 2, 100) || !Validator::length($d['type_culture'], 2, 100)) {
        $erreur = "Le nom et le type de culture doivent contenir entre 2 et 100 caractères.";
    } elseif (mb_strlen($d['variete']) > 100 || mb_strlen($d['saison']) > 100) {
        $erreur = "La variété et la saison sont limitées à 100 caractères.";
    } elseif (!ctype_digit($d['duree_cycle']) || (int) $d['duree_cycle'] < 1 || (int) $d['duree_cycle'] > 3650) {
        $erreur = "La durée du cycle doit être un nombre de jours entre 1 et 3650.";
    } else {
        $id = (new Culture())->create($d);
        flash('success', "Culture ajoutée au catalogue.");
        header("Location: details_culture.php?id=" . $id);
        exit;
    }
}

admin_head("Ajouter une culture");
?>
            <h2>Ajouter une culture</h2>
            <section class="panel">
                <?php if ($erreur !== ""): ?>
                    <p style="color:red; margin-bottom:15px;"><?= htmlspecialchars($erreur) ?></p>
                <?php endif; ?>
                <form method="POST">
                    <?= Csrf::field() ?>
                    <label>Nom de la culture *</label>
                    <input type="text" name="nom" value="<?= htmlspecialchars($d['nom']) ?>" required>
                    <label>Type de culture *</label>
                    <input type="text" name="type_culture" list="types" value="<?= htmlspecialchars($d['type_culture']) ?>" required>
                    <datalist id="types"><?php foreach ($types as $t): ?><option value="<?= htmlspecialchars($t) ?>"><?php endforeach; ?></datalist>
                    <label>Variété</label>
                    <input type="text" name="variete" value="<?= htmlspecialchars($d['variete']) ?>">
                    <label>Saison</label>
                    <input type="text" name="saison" value="<?= htmlspecialchars($d['saison']) ?>">
                    <label>Durée du cycle (jours) *</label>
                    <input type="number" name="duree_cycle" min="1" max="3650" value="<?= htmlspecialchars($d['duree_cycle']) ?>" required>
                    <label>Description</label>
                    <textarea name="description" rows="4"><?= htmlspecialchars($d['description']) ?></textarea>
                    <br><br>
                    <button type="submit" class="view-button">Ajouter la culture</button>
                    <a href="cultures.php" style="margin-left:15px;">Annuler</a>
                </form>
            </section>
<?php admin_foot();
